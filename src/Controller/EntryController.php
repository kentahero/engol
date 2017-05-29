<?php
/**
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link      http://cakephp.org CakePHP(tm) Project
 * @since     0.2.9
 * @license   http://www.opensource.org/licenses/mit-license.php MIT License
 */
namespace App\Controller;

use Cake\ORM\TableRegistry;
use Cake\Network\Exception\NotFoundException;
use Cake\I18n\Time;
use Cake\Mailer\Email;
use Cake\Network\Exception\InternalErrorException;
use Cake\Datasource\ConnectionManager;
use Cake\Network\Http\Client;
use App\Service\CompanionService;
use App\Model\Entity\Offer;

class EntryController extends AppController
{

	private function common() {

		$entities = $this->request->session()->read('form_data');

		//都道府県リストの生成
		$tablePref = TableRegistry::get('Prefectures');
		$prefs = $tablePref->find('list');
		$this->set('prefs',$prefs);

		$prefectureCd = '';
		if ($this->request->getData('User.prefecture_cd')) {
			$prefectureCd= $this->request->getData('User.prefecture_cd');
		} else if (isset($entities['User']) && $entities['User']->prefecture_cd) {
			$prefectureCd= $entities['User']->prefecture_cd;
		}
		if ($prefectureCd!= '') {
			$tableCity = TableRegistry::get('Cities');
			$cities = $tableCity->find('list')->where(['prefecture_cd'=>$prefectureCd])->all();
			$this->set('cities',$cities);
		} else {
			$this->set('cities',[]);
		}

		//日付の生成
		$now = Time::now();
		$bithYears = [];
		for($i=$now->year-21;$i>=$now->year-100;$i--) {
			$bithYears[$i] = "{$i}年";
		}
		$this->set('birth_years',$bithYears);
		$this->set('default_year',$now->year - 40);

		$offerYears = [$now->year=>"{$now->year}年",($now->year+1)=>($now->year+1)."年"];
		$this->set('offer_years',$offerYears);

		$months = [];
		for($i=1;$i<=12;$i++) {
			$months[sprintf("%02d",$i)] = "{$i}月";
		}
		$this->set('months',$months);
		$days = [];
		for($i=1;$i<=31;$i++) {
			$days[sprintf("%02d",$i)] = "{$i}日";
		}
		$this->set('days',$days);

		$coursePrefCd = '';
		//ゴルフ場リストの生成
		if ($this->request->getData('Offer.course_prefecture_cd')) {
			$coursePrefCd = $this->request->getData('Offer.course_prefecture_cd');
		} else if ($entities && $entities['Offer']->course_prefecture_cd) {
			$coursePrefCd = $entities['Offer']->course_prefecture_cd;
		}
		if ($coursePrefCd != '') {
			$courses = [];
			$courses = $this->courseApi($coursePrefCd,1,$courses);
			$this->set('courses',$courses);
		} else {
			$this->set('courses',[]);
		}

	}

	public function index() {

		$offerGroupId = $this->request->getQuery('group_id');
		if (!$offerGroupId) {
			throw new NotFoundException();
		}
		$this->common();

		//選択ペアの取得
		$service = new CompanionService();
		$group = $service->getCompanionPairGroup($offerGroupId);
		if (!$group) {
			//グループが見つからない場合404
			throw new NotFoundException();
		}

		//セッションからデータ読み込み
		$entities = $this->request->session()->read('form_data');
		if ($entities) {
			$entities['Offer']->receive_group_id = $offerGroupId;
			$this->set('entities',$entities);
		} else {
			$tableUser = TableRegistry::get('Users');
			$user = $tableUser->newEntity();
			$tableOffer = TableRegistry::get('Offers');
			$offer = $tableOffer->newEntity();
			$offer->receive_group_id = $offerGroupId;

			$this->set('entities',['User'=>$user,'Offer'=>$offer]);
		}

		$this->set('group',$group);
	}

	public function confirm() {

		$data = $this->request->getData();
		$member = $this->request->session()->read('member');

		if (!$this->request->is('post')) {
			throw new NotFoundException();
		}
		$this->common();

		$groupId = $data['Offer']['receive_group_id'];
		//選択ペアの取得
		$service = new CompanionService();
		$group = $service->getCompanionPairGroup($groupId);
		if (!$group) {
			//ペア出ない場合は404
			throw new NotFoundException();
		}
		$receiveUserId = '';
		foreach($group->users as $comp) {
			if ($comp->leader_flg == '1') {
				$receiveUserId = $comp->id;
			}
		}
		$this->set('group',$group);
		$entities = [];
		//バリデーション実行
		if (!$member) { //未ログインの場合
			//-------------------------------------
			//会員登録のバリデーション実行
			//-------------------------------------
			$data['User']['birth'] = null;
			if (!empty($data['User']['birth_year'])&&!empty($data['User']['birth_month'])&&!empty($data['User']['birth_day'])) {
				$data['User']['birth'] = $data['User']['birth_year'].'-'.$data['User']['birth_month'].'-'.$data['User']['birth_day'];
			}
			$tableUser = TableRegistry::get('Users');
			$user = $tableUser->patchEntity(
					$tableUser->newEntity(),
					$data['User']);
			$entities['User'] = $user;
		} else {
			$data['Offer']['offer_user_id'] = $member->id;
		}
		//-------------------------------------
		//オファーのバリデーション
		//-------------------------------------
		//希望日付のデータ生成
		$data['Offer']['date1'] = null;
		$data['Offer']['date2'] = null;
		$data['Offer']['date3'] = null;
		for($i=0;$i<3;$i++) {
			$offerDate = $data['Offer']['date'][$i];
			if (!empty($offerDate['year'])&&!empty($offerDate['month'])&&!empty($offerDate['day'])) {
				$data['Offer']['date'.($i+1)] = $offerDate['year'].'-'.$offerDate['month'].'-'.$offerDate['day'];
			}
		}
		//バリデーション
		$tableOffer = TableRegistry::get('Offers');
		if (isset($data['Offer']['course_kind']) && $data['Offer']['course_kind'] == 1) {
			if (!empty($data['Offer']['course_name_other'])) {
				$data['Offer']['course_name'] = $data['Offer']['course_name_other'];
			}
			$tableOffer->validator('default')->offsetUnset('training_prefecture_cd');
			$tableOffer->validator('default')->offsetUnset('training_name');
		} else if (isset($data['Offer']['course_kind']) && $data['Offer']['course_kind'] ==2) {
			$tableOffer->validator('default')->offsetUnset('course_prefecture_cd');
			$tableOffer->validator('default')->offsetUnset('course_name');
		}
		$data['Offer']['receive_user_id'] = $receiveUserId;
		$offer = $tableOffer->newEntity($data['Offer']);
		$entities['Offer'] = $offer;

		//---------------------------------
		//付属情報の取得
		//---------------------------------
		if (!empty($entities['User']['city_cd'])) {
			$tableCity = TableRegistry::get('Cities');
			$city = $tableCity->find()->where(['Cities.cd'=>$entities['User']['city_cd']])->contain('Prefectures')->first();
			$entities['User']['prefecture_name'] = $city->prefecture->name;
			$entities['User']['city_name'] = $city->name;
		}

		if (!empty($entities['Offer']['course_prefecture_cd'])) {
			$tablePref = TableRegistry::get('Prefectures');
			$coursePref = $tablePref->get($entities['Offer']['course_prefecture_cd']);
			$entities['Offer']['course_prefecture_name'] = $coursePref->name;
		}
		$entities['Group'] = $group;
		$this->set('entities',$entities);
		//セッションにデータ書き込み
		$this->request->session()->write('form_data',$entities);

		if ((!$member && $user->errors()) || $offer->errors()) {
			//バリデーションエラーがあった場合は入力画面表示
			$this->set('error',true);
			$this->render('index');
		}

	}

	public function complete() {

		$entities= $this->request->session()->read('form_data');
		if (!$entities) {
			throw new InternalErrorException('セッション情報消失');
		}

		//トランザクションの開始
		$connection = ConnectionManager::get('default');
		$connection->begin();

		try {
			$member = $this->request->session()->read('member');
			if (!$member) {
				//グループの登録
				$tableGroup = TableRegistry::get('UserGroups');
				$group = $tableGroup->newEntity();
				$group->name = $entities['User']['nickname'].'グループ';
				if (!$tableGroup->save($group)) {
					throw new InternalErrorException('グループテーブルの保存に失敗');
				}
				//ユーザーの登録
				$tableUser = TableRegistry::get('Users');
				//$user = $tableUser->newEntity((array)$entities['User'],['validate' => false]);
				$user = $entities['User'];
				$user->group_id = $group->id;
				$user->companion_flg = '0';
				if (!$tableUser->save($user)) {
					throw new InternalErrorException('ユーザーテーブルの保存に失敗');
				}
			} else {
				$user = $member;
			}
			//オファーの登録
			$tableOffer = TableRegistry::get('Offers');
			//$offer =$tableOffer->newEntity((array)$entities['Offer'],['validate' => false]);
			$offer = $entities['Offer'];
			$offer->offer_user_id = $user->id;
			$offer->status = Offer::STATUS_OFFER;
			if (!$tableOffer->save($offer)) {
				throw new InternalErrorException('オファーテーブルの保存に失敗');
			}

			$entities['member'] = $member;
			//申込者へのメール送信
			$emailUser = new EMail();
			$emailUser
				->setTemplate('user')
				->setTo($user->email)
				->setSubject('【エンゴル】オファー申し込み完了')
				->setViewVars($entities)
				->send();
			//登録ゴルファーへのメール
			$emailComp = new EMail();
			$emailComp
				->setTemplate('offer')
				->setSubject('【エンゴル】オファーの申し込みがありました')
				->setViewVars($entities);
			foreach($entities['Group']['users'] as $companion) {
				if ($companion->email) {
					$emailComp
						->setTo($companion->email)
						->send();
				}
			}
			//運営へのメール
			$emailAdmin = new EMail();
			$emailAdmin
				->setTemplate('admin')
				->setTo('info@engol.jp')
				->setSubject('【エンゴル】オファー申し込みがありました')
				->setViewVars($entities)
				->send();
			$connection->commit();

		} catch(Exception $e) {
			$connection->rollback();
			debug($e);
			throw $e;
		}
		//$this->request->session()->delete('form_data');
	}

	private function courseApi($prefecture_cd,$page,$courses) {
		//楽天APIの呼び出し
		$http = new Client();
		$response = $http->get(
				'https://app.rakuten.co.jp/services/api/Gora/GoraGolfCourseSearch/20131113',
				[
						'format'=>'json',
						'formatVersion'=>'2',
						'applicationId'=>'1062787586708515126',
						'page'=>$page,
						'areaCode'=>$prefecture_cd,
						'sort'=>'50on'
				],
				[
						'ssl_cafile' => '/etc/pki/tls/certs/ca-bundle.crt'
				]);
		$json = json_decode($response->body(),true);
		//debug($json);

		if (isset($json['Items'])) {
			foreach($json['Items'] as $course) {
				$courses[$course['golfCourseName']] = $course['golfCourseName'];
			}

			if ($page != $json['pageCount']) {
				//sleep(60);
				$courses = $this->courseApi($prefecture_cd, $page+1, $courses);
			}
		}
		return $courses;
	}
}