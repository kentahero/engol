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
use Cake\Datasource\ConnectionManager;
use Cake\I18n\Time;
use Cake\Filesystem\File;
use Cake\Utility\Text;
use Cake\Network\Exception\NotFoundException;

/**
 * 登録ゴルファーコントローラー
 * @author toshikazu.matsumoto
 *
 */
class GolferEntryController extends AppController
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
	}
	public function index() {

		$this->common();

		$tableUser = TableRegistry::get('Users');
		$user = $tableUser->newEntity();
		$tableComp = TableRegistry::get('CompanionInfos');
		$golfer = $tableComp->newEntity();

		$this->set('entities',['User'=>$user,'CompanionInfo'=>$golfer]);
	}

	public function confirm() {

		$data = $this->request->getData();
		$member = $this->request->session()->read('member');

		if (!$this->request->is('post')) {
			throw new NotFoundException();
		}
		$this->common();

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
		}
		$data['CompanionInfo']['round_week'] = '';
		$data['CompanionInfo']['training_week'] = '';
		foreach ($data['CompanionInfo']['round_week_ar'] as $round_week) {
			if ($round_week != '0')$data['CompanionInfo']['round_week']=$data['CompanionInfo']['round_week'].$round_week.'、';
		}
		foreach ($data['CompanionInfo']['training_week_ar'] as $training_week) {
			if ($training_week != '0')$data['CompanionInfo']['training_week']=$data['CompanionInfo']['training_week'].$training_week.'、';
		}
		//一時画像の移動
		$uuid = Text::uuid();
		for($i=1;$i<=3;$i++) {
			$moved = $this->moveTmpImages($data['CompanionInfo']['image'.$i],$uuid.'-'.$i);
			if ($moved) {
				$data['CompanionInfo']['image'.$i]['path'] = $moved['path'];
				$data['CompanionInfo']['image'.$i]['url'] = $moved['url'];
			}
		}
		$tableComp = TableRegistry::get('CompanionInfos');
		$tableComp->validator('default')->offsetUnset('round_week_ar');
		$tableComp->validator('default')->offsetUnset('training_week_ar');
		if (empty($data['CompanionInfo']['amount']) && $data['CompanionInfo']['play_amount_kind'] != '2') {
			$tableComp->validator('default')->offsetUnset('payment_bank');
			$tableComp->validator('default')->offsetUnset('payment_shop_name');
			$tableComp->validator('default')->offsetUnset('payment_bank_kind');
			$tableComp->validator('default')->offsetUnset('payment_no');
			$tableComp->validator('default')->offsetUnset('payment_name');
		}

		$golfer = $tableComp->newEntity($data['CompanionInfo']);
		$entities['CompanionInfo'] = $golfer;

		//---------------------------------
		//付属情報の取得
		//---------------------------------
		if (!empty($entities['User']['city_cd'])) {
			$tableCity = TableRegistry::get('Cities');
			$city = $tableCity->find()->where(['Cities.cd'=>$entities['User']['city_cd']])->contain('Prefectures')->first();
			$entities['User']['prefecture_name'] = $city->prefecture->name;
			$entities['User']['city_name'] = $city->name;
		}
		if (!empty($entities['CompanionInfo']['course_prefecture_cd'])) {
			$tablePref = TableRegistry::get('Prefectures');
			$coursePref = $tablePref->get($entities['CompanionInfo']['course_prefecture_cd']);
			$entities['CompanionInfo']['course_prefecture_name'] = $coursePref->name;
		}
		if (!empty($entities['CompanionInfo']['training_prefecture_cd'])) {
			$tablePref = TableRegistry::get('Prefectures');
			$coursePref = $tablePref->get($entities['CompanionInfo']['training_prefecture_cd']);
			$entities['CompanionInfo']['training_prefecture_name'] = $coursePref->name;
		}


		$this->set('entities',$entities);
		//セッションにデータ書き込み
		$this->request->session()->write('golfer_form_data',$entities);

		if ((!$member && $user->errors()) || $golfer->errors()) {
			//バリデーションエラーがあった場合は入力画面表示
			$this->set('error',true);
			$this->render('index');
		}
	}

	public function complete() {

		$entities= $this->request->session()->read('golfer_form_data');

		if (!$entities) {
			throw new InternalErrorException('セッション情報消失');
		}
		//トランザクションの開始
		$connection = ConnectionManager::get('default');
		$connection->begin();
		try {
			$member = $this->request->session()->read('member');
			if (!$member) { //未ログインの場合新規登録
				$tableUser = TableRegistry::get('Users');
				if ($entities['CompanionInfo']->pair_email)  { //ペアのメールアドレス入力済みの場合
					$pair = $tableUser->find()->where(['email'=>$entities['CompanionInfo']->pair_email,'deleted'=>0])->first();
					if ($pair) {
						$groupId = $pair->group_id;
					} else {
						throw Exception('指定のペアのメールアドレスなし');
					}
				} else {
					//グループの登録
					$tableGroup = TableRegistry::get('UserGroups');
					$group = $tableGroup->newEntity();
					$group->name = $entities['User']['nickname'].'グループ';
					$groupId = $group->id;
					if (!$tableGroup->save($group)) {
						throw new InternalErrorException('グループテーブルの保存に失敗');
					}
				}
				//ユーザーの登録
				$tableUser = TableRegistry::get('Users');
				//$user = $tableUser->newEntity((array)$entities['User'],['validate' => false]);
				$user = $entities['User'];
				$user->group_id = $groupId;
				$user->companion_flg = '1';
				if (!$tableUser->save($user)) {
					throw new InternalErrorException('ユーザーテーブルの保存に失敗');
				}
			} else { //ログイン済みの場合
				$user = $member;
				$entities['User'] = $user;
			}
			//ゴルファーの登録
			$tableComp = TableRegistry::get('CompanionInfos');
			//$offer =$tableOffer->newEntity((array)$entities['Offer'],['validate' => false]);
			$golfer = $entities['CompanionInfo'];
			$golfer->user_id = $user->id;
			if (!$tableComp->save($golfer)) {
				throw new InternalErrorException('ゴルファーテーブルの保存に失敗');
			}
			//画像の本登録
			$this->moveImage($golfer->image1['path'],$user->id,1);
			if ($golfer->image2['name'])$this->moveImage($golfer->image2['path'],$user->id,2);
			if ($golfer->image3['name'])$this->moveImage($golfer->image3['path'],$user->id,3);
			/*

			$entities['member'] = $member;
			//登録ゴルファーへのメール
			$emailComp = new EMail($this->mailConf);
			$emailComp
				->setTemplate('offer')
				->setSubject('【エンゴル】オファーの申し込みがありました')
				->setViewVars($entities);
			//運営へのメール
			$emailAdmin = new EMail($this->mailConf);
			$emailAdmin
				->setTemplate('admin')
				->setTo('info@engol.jp')
				->setSubject('【エンゴル】オファー申し込みがありました')
				->setViewVars($entities)
				->send();
			*/
			$connection->commit();

		} catch(Exception $e) {
			$connection->rollback();
			debug($e);
			throw $e;
		}
		$this->request->session()->delete('form_data');



	}

	private function moveTmpImages($image,$uuid) {
		//一時画像の移動
		if ($image['name']) {
			$ext = pathinfo($image['name'],PATHINFO_EXTENSION);
			$file = new File($image['tmp_name']);
			$file->copy(IMAGE_TMP.$uuid.'.'.$ext);

			return ['url'=>'/img/pic/tmp/'.$uuid.'.'.$ext,'path'=>IMAGE_TMP.$uuid.'.'.$ext];
		}
		return null;
	}

	private function moveImage($imagePath,$userId,$no) {
		if ($imagePath) {
			$ext = pathinfo($imagePath,PATHINFO_EXTENSION);
			$file = new File($imagePath);
			$file->copy(IMAGE_PIC.$userId.$no.$ext);
		}
	}
	}