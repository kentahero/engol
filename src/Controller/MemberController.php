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

	public function index() {

		$member = $this->request->session()->read('member');

		if ($member) {
			$tableOffer = TableRegistry::get('Offers');
			$offers = $tableOffer->find()
				->where(['OR'=>['receive_group_id'=>$member->group_id,'offer_user_id'=>$member->id],'Offers.deleted'=>0])
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

	public function login() {

		if ($this->request->is('post')) {
			$email = $this->request->getData('email');
			$password = $this->request->getData('password');

			$tableUser = TableRegistry::get('Users');
			$member = $tableUser->find('all')->where(['email'=>$email,'password'=>$password])->first();
			if ($member) {
				$this->request->session()->write('member',$member);

				if ($member->companion_flg == '1') {
					//登録ゴルファーの場合

				} else {
					//申し込み者の場合

				}
				$this->redirect('/member/');
			} else {

			}
		}
	}

	public function logout() {
		$member = $this->request->session()->read('member');
		if ($member) {
			$this->request->session()->delete('member');
		}
		$this->redirect('/');
	}

	public function forgot() {
		$email = $this->request->getData('email');
		$birth = $this->request->getData('birth');
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
		//$offer = $offerTable->find()->where(['id'=>$offerId,'receive_group_id'=>$member->group_id])->first();
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
			//debug($offer);
			$emailUser = new EMail();
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

		if ($this->statusChange(Offer::STATUS_REDUCE)) {
			$this->redirect('/member/detail?offer_id='.$offerId);
		}
	}

	/**
	 * 承諾オファーキャンセル
	 */
	public function cancel() {
		$offerId = $this->request->getQuery('offer_id');
		if ($this->statusChange(Offer::STATUS_CANCEL)) {
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
		$service = new EpsilonService();
		$vo = $service->createVO($offer);
		$res = $service->start($vo);
		debug($res);

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
		$data = $this->request->getData();
		debug($data);
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

	private function statusChange($status) {
		$offerId = $this->request->getData('offer_id');
		if (!$offerId) {
			throw new NotFoundException();
		}
		$member = parent::isMember();
		if (!$member) {
			throw new NotFoundException();
		}
		$condition['id'] = $offerId;
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
		$offer = $offerTable->find()->where($condition)->first();
		if (!$offer) {
			throw new NotFoundException();
		}
		$offer->status = $status;
		return $offerTable->save($offer);
	}

	private function calcAmount($group) {
		$amount = ['user_amount'=>0,'play_amount'=>0,'site_amount'=>0,'total'=>0];
		foreach($group->users as $user) {
			$amount['user_amount'] += $user->companion_info->amount;
			$total+= $amount['user_amount'];
		}
		$amount['play_amount'] = count($group->users) * PLAY_AMOUNT;
		$amount['site_amount'] = count($group->users) * SITE_AMOUNT;
		$amount['total'] = $amount['user_amount'] + $amount['play_amount'] + $amount['site_amount'];

		return $amount;
	}
}
