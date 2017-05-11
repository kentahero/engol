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
use App\Service\CompanionService;
use Cake\Network\Exception\NotFoundException;
use Cake\I18n\Time;
use Cake\Mailer\Email;
use Cake\Network\Exception\InternalErrorException;
use Cake\Datasource\ConnectionManager;
use Cake\Network\Http\Client;

class EntryController extends AppController
{

	private function common() {

		//都道府県リストの生成
		$tablePref = TableRegistry::get('Prefectures');
		$prefs = $tablePref->find('list');
		$this->set('prefs',$prefs);

		if($this->request->getData('prefecture_cd')) {
			$tableCity = TableRegistry::get('Cities');
			$cities = $tableCity->find('list')->where(['prefecture_cd'=>$this->request->getData('prefecture_cd')])->all();
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

		//ゴルフ場リストの生成
		if ($this->request->getData('course_prefecture_cd')) {
			$courses = [];
			$courses = $this->courseApi($this->request->getData('course_prefecture_cd'),1,$courses);
			$this->set('courses',$courses);
		} else {
			$this->set('courses',[]);
		}

	}

	public function index() {

		$groupId = $this->request->getQuery('group_id');
		if (!$groupId) {
			throw new NotFoundException();
		}
		$this->common();

		//選択ペアの取得
		$service = new CompanionService();
		$group = $service->getCompanionPairGroup($groupId);
		if (!$group) {
			//グループが見つからない場合404
			throw new NotFoundException();
		}

		$tableUser = TableRegistry::get('Users');
		$user = $tableUser->newEntity();
		//セッションからデータ読み込み
		$formData = $this->request->session()->read('form_data');
		if ($formData) {
			//$user = $tableUser->patchEntity($user, $formData);
		}
		//$user->offer_month = $now->month;
		$user->group_id = $groupId;
		$this->set('user',$user);
		$this->set('group',$group);
	}

	public function confirm() {

		$data = $this->request->getData();

		if (!$this->request->is('post')) {
			throw new NotFoundException();
		}
		//セッションにデータ書き込み
		$this->request->session()->write('form_data',$data);

		$this->common();

		$groupId = $data['group_id'];
		//選択ペアの取得
		$service = new CompanionService();
		$group = $service->getCompanionPairGroup($groupId);
		if (!$group) {
			//ペア出ない場合は404
			throw new NotFoundException();
		}
		$this->set('group',$group);

		//バリデーション実行
		$tableUser = TableRegistry::get('Users');
		$user = $tableUser->newEntity($data);
		if ($user->errors()) {
			$this->set('user',$user);
			$this->render('index');
		}
		$this->set('data',$user);
	}

	public function complete() {

		$data = $this->request->session()->read('form_data');
		if (!$data) {
			throw new NotFoundException();
		}

		//トランザクションの開始
		$connection = ConnectionManager::get('default');
		$connection->begin();

		try {
			$tableGroup = TableRegistry::get('UserGroups');
			$group = $tableGroup->newEntity();
			$group->name = $data['nickname'].'グループ';
			if (!$tableGroup->save($group)) {
				throw new InternalErrorException();
			}

			$userId = null;
			$tableUser = TableRegistry::get('Users');
			$user = $tableUser->newEntity($data);
			$user->group_id = $group->id;
			$user->companion_flg = '0';
			if (!$tableUser->save($user)) {
				throw new InternalErrorException();
			}
			debug($user);

			$tableOffer = TableRegistry::get('Offers');
			$offer =$tableOffer->newEntity($data);
			$offer->offer_user_id = $user->id;
			$offer->recieve_group_id = $data['group_id'];
			$tableOffer->save($offer);

			$emailUser = new EMail();
			$emailUser
				->setTemplate('user')
				->setTo($user->email)
				->setViewVars($data)
				->send();

			$connection->commit();

		} catch(Exception $e) {
			$connection->rollback();
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
				]);
		$json = json_decode($response->body(),true);
		//debug($json);

		if (isset($json['Items'])) {
			foreach($json['Items'] as $course) {
				$courses[$course['golfCourseName']] = $course['golfCourseName'];
			}

			if ($page != $json['pageCount']) {
				$courses = $this->courseApi($prefecture_cd, $page+1, $courses);
			}
		}
		return $courses;
	}
}