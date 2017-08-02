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
use Cake\Mailer\Email;
use Cake\Filesystem\File;
use Cake\Utility\Text;
use Cake\Network\Exception\NotFoundException;
use Cake\Network\Exception\InternalErrorException;

/**
 * 登録ゴルファーコントローラー
 * @author toshikazu.matsumoto
 *
 */
class MemberEditController extends AppController
{
	private $member = null;

	private function common() {

		$entities = $this->request->session()->read('form_data');

		//都道府県リストの生成
		$tablePref = TableRegistry::get('Prefectures');
		$prefs = $tablePref->find('list');
		$this->set('prefs',$prefs);

		$prefectureCd = '';
		if ($this->member->prefecture_cd) {
			$prefectureCd = $this->member->prefecture_cd;
		} else if ($this->request->getData('User.prefecture_cd')) {
			$prefectureCd= $this->request->getData('User.prefecture_cd');
		} else if (isset($entities['User']) && $entities['User']->prefecture_cd) {
			$prefectureCd= $entities['User']->prefecture_cd;
		}
		if ($prefectureCd != '') {
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

		$this->member = $this->request->session()->read('member');
		if (!$this->member) {
			throw new NotFoundException('ログインされていません');
		}
		$entities['User'] = $this->member;
		$entities['User']->email_confirm = $this->member->email;
		$entities['User']->birth_year = date_format($this->member->birth,'Y');
		$entities['User']->birth_month = date_format($this->member->birth,'m');
		$entities['User']->birth_day = date_format($this->member->birth,'d');

		if ($this->member->companion_flg == '1') { //ゴルファー登録している場合

			$tableComp = TableRegistry::get('CompanionInfos');
			$golfer = $tableComp->find()->where(['user_id'=>$this->member->id])->first();
			$golfer['round_week_ar']= explode(',',$golfer->round_week);
			$golfer['training_week_ar']= explode(',',$golfer->training_week);
			for($i=1;$i<=$golfer->image;$i++) {
				if ($golfer['image_file'.$i]) {
					$golfer['image_url'.$i] = '/img/pic/'.$golfer['image_file'.$i];
				}
			}
			$entities['CompanionInfo'] = $golfer;
		}
		$this->common();
		$this->set('entities',$entities);
	}

	public function confirm() {

		$data = $this->request->getData();
		$this->member = $this->request->session()->read('member');
		/*
		if (!$this->request->is('post')) {
			throw new NotFoundException('フォームの不正遷移');
		}
		*/
		if (!$this->member) {
			$this->redirect('/member/login');
			return;
		}
		$this->common();

		$entities = [];
		//-------------------------------------
		//会員登録のバリデーション実行
		//-------------------------------------
		$data['User']['birth'] = null;
		if (!empty($data['User']['birth_year'])&&!empty($data['User']['birth_month'])&&!empty($data['User']['birth_day'])) {
			$data['User']['birth'] = $data['User']['birth_year'].'-'.$data['User']['birth_month'].'-'.$data['User']['birth_day'];
		}
		$data['User']['agree'] = '1';
		$tableUser = TableRegistry::get('Users');
		$tableUser->validator('default')->offsetUnset('agree');
		$user = $tableUser->patchEntity($this->member,$data['User']);
		$entities['User'] = $user;

		//-------------------------------------
		//ゴルファー情報のバリデーション実行
		//-------------------------------------
		if ($this->member->companion_flg== '1') {
			$data['CompanionInfo']['round_week'] = implode(',', $data['CompanionInfo']['round_week_ar']);
			$data['CompanionInfo']['training_week'] = implode(',', $data['CompanionInfo']['training_week_ar']);
			//一時画像の移動
			$uuid = Text::uuid();
			$imageCount = 0;
			for($i=1;$i<=3;$i++) {
				$moved = $this->moveTmpImages($data['CompanionInfo']['image_up'.$i],$uuid.'-'.$i);
				if ($moved) {
					$data['CompanionInfo']['image_url'.$i] = $moved['url'];
					$data['CompanionInfo']['image_file'.$i] = $moved['file'];
					$data['CompanionInfo']['image_moved'.$i] = true;
					$imageCount++;
				} else if ($data['CompanionInfo']['image_file'.$i]){
					$data['CompanionInfo']['image_url'.$i] = '/img/pic/'.$data['CompanionInfo']['image_file'.$i];
					$imageCount++;
				}
			}
			$data['CompanionInfo']['image'] = $imageCount;
			$tableComp = TableRegistry::get('CompanionInfos');
			$golfer = $tableComp->find()->where(['user_id'=>$this->member->id])->first();
			$tableComp->validator('default')->offsetUnset('round_week_ar');
			$tableComp->validator('default')->offsetUnset('training_week_ar');
			if ($data['CompanionInfo']['round_week'] != '') $tableComp->validator('default')->offsetUnset('training_week');
			if ($data['CompanionInfo']['training_week'] != '') $tableComp->validator('default')->offsetUnset('round_week');
			if (empty($data['CompanionInfo']['amount']) && $data['CompanionInfo']['play_amount_kind'] != '2') {
				$tableComp->validator('default')->offsetUnset('payment_bank');
				$tableComp->validator('default')->offsetUnset('payment_shop_name');
				$tableComp->validator('default')->offsetUnset('payment_bank_kind');
				$tableComp->validator('default')->offsetUnset('payment_no');
				$tableComp->validator('default')->offsetUnset('payment_name');
			}
			$golfer = $tableComp->patchEntity($golfer,$data['CompanionInfo']);
			$entities['CompanionInfo'] = $golfer;
		}

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
		$this->request->session()->write('form_data',$entities);

		if ($user->errors() || $golfer->errors()) {
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
		$this->member = $this->request->session()->read('member');
		if (!$this->member) {
			$this->redirect('/member/login');
			return;
		}
		//トランザクションの開始
		$connection = ConnectionManager::get('default');
		$connection->begin();
		try {
			$tableUser = TableRegistry::get('Users');
			/*
			if ($entities['CompanionInfo']->pair_email)  { //ペアのメールアドレス入力済みの場合
				$pair = $tableUser->find()->where(['email'=>$entities['CompanionInfo']->pair_email,'deleted'=>0])->first();
				if ($pair) {
					$groupId = $pair->group_id;
				} else {
					throw Exception('指定のペアのメールアドレスなし');
				}
			}
			*/
			//ユーザーの登録
			$user = $entities['User'];
			//$user->group_id = $groupId;
			if (!$tableUser->save($user)) {
				throw new InternalErrorException('ユーザーテーブルの保存に失敗');
			}
			if ($this->member->companion_flg == '1') {
				//ゴルファーの登録
				$tableComp = TableRegistry::get('CompanionInfos');
				$golfer = $entities['CompanionInfo'];
				$golfer->user_id = $user->id;
				//画像の本登録
				if ($golfer->image_moved1)$golfer->image_file1 = $this->moveImage($golfer->image_file1,$user->id,1);
				if ($golfer->image_moved2)$golfer->image_file2 = $this->moveImage($golfer->image_file2,$user->id,2);
				if ($golfer->image_moved3)$golfer->image_file3 = $this->moveImage($golfer->image_file3,$user->id,3);
				if (!$tableComp->save($golfer)) {
					throw new InternalErrorException('ゴルファーテーブルの保存に失敗');
				}
			}
			/*
			$entities['member'] = $this->member;
			//登録ゴルファーへのメール
			$emailComp = new EMail($this->mailConf);
			$emailComp
				->setTemplate('golfer')
				->setTo($user->email)
				->setSubject('【エンゴル】ゴルファー登録が完了しました')
				->setViewVars($entities);
			//運営へのメール
			$emailAdmin = new EMail($this->mailConf);
			$emailAdmin
				->setTemplate('golfer')
				->setTo('info@engol.jp')
				->setSubject('【エンゴル】ゴルファー登録がありました')
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

			return ['url'=>'/img/pic/tmp/'.$uuid.'.'.$ext,'path'=>IMAGE_TMP.$uuid.'.'.$ext,'file'=>$uuid.'.'.$ext];
		}
		return null;
	}

	private function moveImage($imageFile,$userId,$no) {
		if ($imageFile) {
			$imagePath = IMAGE_TMP.$imageFile;
			$ext = mb_strtolower(pathinfo($imagePath,PATHINFO_EXTENSION));
			$file = new File($imagePath);
			$file->copy(IMAGE_PIC.'pic_'.$userId.'_'.$no.'.'.$ext);
			return 'pic_'.$userId.'_'.$no.'.'.$ext;
		}
		return '';
	}
}