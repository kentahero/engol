<?php

namespace App\Service;

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
	const PRODUCTION_ORDER_URL = '';
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

	public function start($vo) {

		debug($vo);

		$return = ['status'=>0,'message'=>''];
		$http = new Client();
		$response = $http->post(self::DEBUG_ORDER_URL,$vo,
				[
					'ssl_cafile' => '/etc/pki/tls/certs/ca-bundle.crt'
				]);
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
}