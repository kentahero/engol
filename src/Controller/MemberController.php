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
use Cake\Mailer\Email;
use Cake\I18n\FrozenDate;
use Cake\Network\Exception\NotFoundException;
use App\Service\CompanionService;
use App\Model\Entity\Offer;
use App\Service\EpsilonService;


class MemberController extends AppController
{

	/**
	 * メールボックス画面
	 */
	public function index() {

		$member = $this->request->session()->read('member');

		if ($member) {
			$tableOffer = TableRegistry::get('Offers');
			$offers = $tableOffer->find()
				->where(['OR'=>['Offers.receive_group_id'=>$member->group_id,'offer_user_id'=>$member->id],'Offers.deleted'=>0])
				->order('Offers.created DESC')
				->contain([
					'OfferUsers'=>function ($query) {
						return $query->select()->contain(['Prefectures']);
					},
					'ReceiveGroups'=>function($query) {
						return $query->select()->contain(['Users']);
					}
				])->all();
			$this->set('offers',$offers);
		} else {
			$this->redirect('/member/login');
		}
	}

	/**
	 * ログイン画面
	 */
	public function login() {

		if ($this->request->is('post')) {
			$email = $this->request->getData('email');
			$password = $this->request->getData('password');

			$tableUser = TableRegistry::get('Users');
			$member = $tableUser->find('all')->where(['email'=>$email,'password'=>$password,'deleted'=>'0'])->first();
			if ($member) {
				$this->request->session()->write('member',$member);

				if ($member->companion_flg == '1') {
					//登録ゴルファーの場合

				} else {
					//申し込み者の場合

				}
				$this->redirect('/member/');
			} else {
				$this->set('error','メールアドレスまたはパスワードに誤りがあります');
			}
		}
	}

	/**
	 * ログアウト処理
	 */
	public function logout() {
		$member = $this->request->session()->read('member');
		if ($member) {
			$this->request->session()->delete('member');
		}
		$this->redirect('/');
	}

	/**
	 * パスワード再発行
	 */
	public function forgot() {
		$email = $this->request->getData('email');
		$birth = $this->request->getData('birth');

		if (!$this->request->is('post')) {
			return;
		}

		if (empty($email) || empty($birth)) {
			$this->set('error','メールアドレス、誕生日を入力して下さい');
			return;
		}
		if (!preg_match('/^([0-9]{8})$/', $birth)) {
			$this->set('error','誕生日を8桁の数値で入力して下さい');
			return;
		}
		$tableUser = TableRegistry::get('Users');
		$user = $tableUser->find()->where(['email'=>$email,'birth'=>$birth,'deleted'=>'0'])->first();
		if (!$user) {
			$this->set('error','メールアドレスまたは誕生日に誤りがあります');
			return;
		}
		//登録ゴルファーへのメール
		$email = new EMail($this->mailConf);
		$email
			->setTemplate('password')
			->setTo($user->email)
			->setSubject('【エンゴル】パスワード通知')
			->setViewVars(['user'=>$user])
			->send();

		$this->render('resent');
	}

	public function changePassword() {
		if (!$this->request->is('post')) {
			return;
		}
		$member = $this->request->session()->read('member');
		if (!$member) {
			$this->redirect('/member/login');
			return;
		}
		$now = $this->request->getData('now');
		$new = $this->request->getData('new');
		$confirm = $this->request->getData('new_confirm');

		if (empty($now) || empty($new) || empty($confirm)) {
			$this->set('error','現在のパスワード、新しいパスワードを全て入力して下さい');
			return;
		}

		if ($member->password != $now) {
			$this->set('error','現在のパスワードが間違っています');
			return;
		}

		if ($new != $confirm) {
			$this->set('error','パスワードの確認が一致しません');
			return;
		}

		$tableUser = TableRegistry::get('Users');
		$user = $tableUser->get($member->id);
		$user->password = $new;
		$tableUser->save($user);
		$this->request->session()->delete('member');
		$this->render('password_changed');
	}

	public function common() {

	}

	/**
	 * オファー詳細画面表示
	 */
	public function detail() {

		$member = $this->request->session()->read('member');

		if (!$member) {
			$this->redirect('/member/login');
			return;
		}
		$offerId = $this->request->getQuery('offer_id');
		$error = $this->request->getQuery('error');
		if ($error) {
			$this->set('error','希望日を選択して下さい');
		}
		$tableOffer = TableRegistry::get('Offers');
		$offer = $tableOffer->find('all')->where(['Offers.id'=>$offerId])->contain(['CoursePrefectures','TrainingPrefectures',
					'OfferUsers'=>function ($query) {
						return $query->select()->contain(['Prefectures']);
					},
					'ReceiveGroups'=>function($query) {
						return $query->select()->contain(['Users']);
					}
				]
			)->first();
		if (!$offer) {
			throw new NotFoundException();
		}
		$this->set('offer',$offer);
		if ($offer->receive_group_id == $member->group_id) {
			//オファーを受信した側の場合
			$this->render('receive');
		} else if ($offer->offer_user_id == $member->id) {
			//オファーを送信した側の場合
			//お相手情報を取得
			$service = new CompanionService();
			$group = $service->getCompanionPairGroup($offer->receive_group_id);
			$this->set('group',$group);
			$this->set('amount',$this->calcAmount($group));
		} else {
			//受信、送信ではない場合不正アクセス
			throw new NotFoundException();
		}

	}

	/**
	 * オファー承諾
	 */
	public function accept() {

		$member = $this->request->session()->read('member');

		$offerId = $this->request->getData('offer_id');
		$selectDate = $this->request->getData('offer_date');
		if (!$selectDate) {
			$this->redirect('/member/detail?offer_id='.$offerId.'&error=true');
			return;
		}

		$offerTable = TableRegistry::get('Offers');
		$offer = $offerTable->find('all')->where(['Offers.id'=>$offerId])->contain(['CoursePrefectures','TrainingPrefectures',
				'OfferUsers'=>function ($query) {
					return $query->select()->contain(['Prefectures']);
				}
			])->first();

		if (!$offer) {
			throw new NotFoundException();
		}
		if ($offer->receive_group_id != $member->group_id) {
			throw new NotFoundException();
		}

		$service = new CompanionService();
		$group = $service->getCompanionPairGroup($offer->receive_group_id);
		$this->set('group',$group);

		$offer->status = Offer::STATUS_ACCEPT;
		$offer->play_date = new FrozenDate($selectDate); //決定日のセット
		$amount = $this->calcAmount($group);
		$offer->amount = $amount['total'];

		if ($offerTable->save($offer)) {
			$emailUser = new EMail($this->mailConf);
			$emailUser
				->setTemplate('accept')
				->setTo($offer->offer_user->email)
				->setSubject('【エンゴル】オファーが承諾されました')
				->setViewVars(['offer'=>$offer])
				->send();

				$this->redirect('/member/detail?offer_id='.$offerId);
		}
	}

	/**
	 * オファー拒否
	 */
	public function reduce() {
		$offerId = $this->request->getQuery('offer_id');
		if (!$offerId) {
			throw new NotFoundException();
		}
		$offer = $this->statusChange($offerId,Offer::STATUS_REDUCE);
		if ($offer) {
			$mail = new EMail($this->mailConf);
			$mail
				->setTemplate('reduce')
				->setTo($offer->offer_user->email)
				->setSubject('【エンゴル】オファーが拒否されました')
				->setViewVars(['offer'=>$offer])
				->send();
			$this->redirect('/member/detail?offer_id='.$offerId);
		}
	}

	/**
	 * 承諾オファーキャンセル
	 */
	public function cancel() {
		$offerId = $this->request->getQuery('offer_id');
		if ($this->statusChange($offerId,Offer::STATUS_CANCEL)) {
			$this->redirect('/member/detail?offer_id='.$offerId);
		}
	}

	/**
	 * クレジットカード決済
	 */
	public function pay() {
		$member = $this->request->session()->read('member');
		if (!$member) {
			$this->redirect('/member/login');
			return;
		}
		$offerId = $this->request->getQuery('offer_id');
		if (!$offerId) {
			throw new NotFoundException();
		}
		$offerTable = TableRegistry::get('Offers');
		$offer = $offerTable->find('all')->where(['Offers.id'=>$offerId])->contain(['CoursePrefectures','TrainingPrefectures',
					'OfferUsers'=>function ($query) {
						return $query->select()->contain(['Prefectures']);
					}
				])->first();
		if (!$offer) {
			throw new NotFoundException();
		}
		if ($offer->offer_user_id != $member->id) {
			throw new NotFoundException();
		}
		//イプシロンへの連携
		$service = new EpsilonService();
		$vo = $service->createVO($offer);
		$res = $service->start($vo);
		if ($res['status']) {
			$this->redirect($res['message']);
			return;
		}
		$this->set('error',$res['message']);
	}

	/**
	 * カード決済完了
	 */
	public function paid() {
		$data = $this->request->getQuery();
		if (!isset($data['order_number']) || !isset($data['trans_code'])) {
			throw new NotFoundException();
		}
		$offerTable = TableRegistry::get('Offers');
		$offer = $offerTable->find('all')->where(['Offers.id'=>$data['order_number']])->contain(['CoursePrefectures','TrainingPrefectures',
				'OfferUsers'=>function ($query) {
					return $query->select()->contain(['Prefectures']);
				},
				'ReceiveGroups'=>function($query) {
					return $query->select()->contain(['Users']);
				}
			])->first();

		if (!$offer) {
			$this->set('error','該当注文なし');
			return;
		}
		if ($offer->status != Offer::STATUS_ACCEPT) {
			$this->set('error','オファーステータスが不一致');
			return;
		}
		//イプシロンに決済の問い合わせ
		$service = new EpsilonService();
		$res = $service->confirm($data);
		if (!$res['status']) {
			$this->set('error',$res['message']);
			return;
		}
		$offer->status = Offer::STATUS_PAID;
		if ($offerTable->save($offer)) {

			$emailUser = new EMail($this->mailConf);
			$emailUser
				->setTemplate('paid')
				->setTo($offer->offer_user->email)
				->setSubject('【エンゴル】お支払いが完了しました')
				->setViewVars(['offer'=>$offer])
				->send();

			foreach($offer->receive_group->users as $user) {
				$emailComp = new EMail($this->mailConf);
				$emailComp
					->setTemplate('paid_comp')
					->setTo($user->email)
					->setSubject('【エンゴル】ご成約が完了しました')
					->setViewVars(['offer'=>$offer])
					->send();
			}
			$this->redirect('/member/detail?offer_id='.$offer->id);
		}
	}

	/**
	 * ラウンド終了
	 */
	public function close() {
		$offerId = $this->request->getQuery('offer_id');
		if ($this->statusChange(Offer::STATUS_CLOSE)) {
			$this->redirect('/member/detail?offer_id='.$offerId);
		}
	}

	/**
	 * ゴルファー情報非公開
	 */
	public function unpublish() {
	}
	public function unpublished() {

		$member = $this->request->session()->read('member');

		if (!$member) {
			$this->redirect('/member/login');
			return;
		}

		$tableUser = TableRegistry::get('Users');
		$user = $tableUser->get($member->id);
		$user->companion_flg = '0';
		$tableUser->save($user);
		$this->request->session()->write('member',$user);

		$this->redirect('/member/index');
	}

	/**
	 * 退会
	 */
	public function resign() {

	}
	public function resigned() {
		$member = $this->request->session()->read('member');

		if (!$member) {
			$this->redirect('/member/login');
			return;
		}

		$tableUser = TableRegistry::get('Users');
		$user = $tableUser->get($member->id);
		$user->deleted = '1';
		$tableUser->save($user);
		$this->request->session()->delete('member');
		$this->redirect('/');
	}

	private function statusChange($offerId,$status) {

		$member = $this->request->session()->read('member');
		if (!$member) {
			throw new NotFoundException('ログインしていない');
		}
		$condition['Offers.id'] = $offerId;
		switch($status) {
			case Offer::STATUS_ACCEPT:
			case Offer::STATUS_REDUCE:
			case Offer::STATUS_CLOSE:
				$condition['receive_group_id'] = $member->group_id;
				break;
			case Offer::STATUS_PAYED:
				$condition['offer_user_id'] = $member->id;
				break;
			case Offer::STATUS_CANCEL:
				$condition['OR'] = ['offer_user_id'=>$member->id,'receive_group_id'=>$member->group_id];
				break;
		}
		$offerTable = TableRegistry::get('Offers');
		$offer = $offerTable->find()->where($condition)
			->contain(['CoursePrefectures','TrainingPrefectures','OfferUsers',
					'ReceiveGroups'=>function($query) {
						return $query->select()->contain(['Users']);
					}
			])->first();
		if (!$offer) {
			throw new NotFoundException('該当オファーデータがない');
		}
		$offer->status = $status;
		if ($offerTable->save($offer)) {
			return $offer;
		}
		return null;
	}

	private function calcAmount($group) {
		$amount = ['user_amount'=>0,'play_amount'=>0,'site_amount'=>0,'total'=>0];
		foreach($group->users as $user) {
			$amount['user_amount'] += $user->companion_info->amount;
			if ($user->companion_info->play_amount_kind == '2') { //プレイ費を相手に負担してもらう場合のみ
				$amount['play_amount'] += PLAY_AMOUNT;
			}
		}
		$amount['site_amount'] = count($group->users) * SITE_AMOUNT;
		$amount['total'] = $amount['user_amount'] + $amount['play_amount'] + $amount['site_amount'];

		return $amount;
	}
}
