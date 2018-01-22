<?php

namespace App\Service;

use Cake\Core\Configure;
use Cake\Network\Http\Client;
use Cake\Utility\Xml;

/**
 * イプシロン決済サービス
 *
 * @property \App\Model\Table\GroupsTable $GroupsTable
 * @property \App\Model\Table\UsersTable $UsersTable
 * @property \App\Model\Table\CompanionInfosTable $CompanionInfosTable
 */
class EpsilonService extends AppService {

	const DEBUG_ORDER_URL = 'https://beta.epsilon.jp/cgi-bin/order/receive_order3.cgi';
	const PRODUCTION_ORDER_URL = 'https://secure.epsilon.jp/cgi-bin/order/receive_order3.cgi';
	const DEBUG_CONFIRM_URL = 'https://beta.epsilon.jp/cgi-bin/order/getsales2.cgi';
	const PRODUCTION_CONFIRM_URL = 'https://secure.epsilon.jp/cgi-bin/order/getsales2.cgi';
	const CONTRACT_CODE = '64985980';
	const ITEM_CODE = 'IT001';
	const ST_CODE = '10000-0000-00000-00000-00000-00000-00000';

	public function createVO($offer) {

		$vo = [
				'contract_code'		=>	self::CONTRACT_CODE,
				'user_id'			=>	$offer->offer_user->id,
				'user_name'			=>	$offer->offer_user->first_name.' '.$offer->offer_user->last_name,
				'user_mail_add'		=>	$offer->offer_user->email,
				'item_code'			=>	self::ITEM_CODE,
				'item_name'			=>	'エンゴル利用料金',
				'order_number'		=>	$offer->id,
				'st_code'			=>	self::ST_CODE,
				'mission_code'		=>	'1',
				'item_price'		=>	$offer->amount,
				'process_code'		=>	'1',
				'memo1'				=>	'',
				'memo2'				=>	'',
				'xml'				=>	'1',
				'conveni_code'		=>	'',
				'user_tel'			=>	$offer->offer_user->tel,
				'user_name_kana'	=>	$offer->offer_user->first_kana.' '.$offer->offer_user->last_kana
			];

		return $vo;
	}
	/**
	 * 決済処理の開始
	 * @param unknown $vo
	 * @return number[]|string[]|boolean[]|number[]|string[]|boolean[]|NULL[]
	 */
	public function start($vo) {
		$return = ['status'=>0,'message'=>''];
		$options = [];
		$url = self::DEBUG_ORDER_URL;
		if (!Configure::read('debug')) {
			$options['ssl_cafile'] = '/etc/pki/tls/certs/ca-bundle.crt';
			$url = self::PRODUCTION_ORDER_URL;
		}
		$http = new Client();
		$response = $http->post($url,$vo,$options);
		if (!$response->isOk()) {
			$return['status'] = false;
			$return['message'] = '通信失敗';
			return $return;
		}

		$xml = Xml::toArray(Xml::build($response->body()));
		if ($xml['Epsilon_result']['result'][0]['@result'] != '1') {
			$return['status'] = false;
			$return['message'] = mb_convert_encoding(
					urldecode($xml['Epsilon_result']['result'][2]['@err_detail']),
					mb_internal_encoding(),
					'SJIS-WIN');
			return $return;
		}

		$return['status'] = true;
		$return['message'] = urldecode($xml['Epsilon_result']['result'][1]['@redirect']);
		return $return;
	}
	/**
	 * 決済完了後の確認
	 * @param unknown $data
	 * @return number[]|string[]|boolean[]
	 */
	public function confirm($data) {
		$return = ['status'=>0,'message'=>''];
		$options = [];
		$url = self::DEBUG_CONFIRM_URL;
		if (!Configure::read('debug')) {
			$options['ssl_cafile'] = '/etc/pki/tls/certs/ca-bundle.crt';
			$url = self::PRODUCTION_CONFIRM_URL;
		}
		$http = new Client();
		$response = $http->post(
				$url,
				['contract_code'=>self::CONTRACT_CODE,'trans_code'=>$data['trans_code']],
				$options);
		if (!$response->isOk()) {
			$return['status'] = false;
			$return['message'] = '通信失敗';
			return $return;
		}
		$xml_str = $response->body();
		$xml_str = mb_convert_encoding($xml_str, 'UTF-8'); //x-sjisがエラーになるためUTF-8変換
		$xml_str = str_replace('x-sjis-cp932', 'UTF-8', $xml_str);
		$xml = Xml::toArray(Xml::build($xml_str));
		if (!isset($xml['Epsilon_result']['result'])) {
			$return['status'] = false;
			$return['message'] = '該当データなし';
			return $return;
		}
		if ($xml['Epsilon_result']['result'][2]['@state'] != '1') {
			$return['status'] = false;
			$return['message'] = '未決済';
			return $return;
		}
		$return['status'] = true;
		return $return;
	}
}