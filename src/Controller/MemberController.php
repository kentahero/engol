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
use App\Service\CompanionService;


class MemberController extends AppController
{

	public function index() {

		$member = $this->request->session()->read('member');

		if ($member) {
			$tableOffer = TableRegistry::get('Offers');
			$offers = $tableOffer->find()
				->where(['OR'=>['recieve_group_id'=>$member->group_id,'offer_user_id'=>$member->id],'Offers.deleted'=>0])
				->order('Offers.created DESC')
				->contain([
					'OfferUsers'=>function ($query) {
						return $query->select()->contain(['Prefectures']);
					},
					'RecieveGroups'=>function($query) {
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
				$this->redirect('/');
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
		$tableOffer = TableRegistry::get('Offers');
		$offer = $tableOffer->find('all')->where(['Offers.id'=>$offerId])->contain(['OfferUsers'=>function ($query) {
				return $query->select()->contain(['Prefectures']);
			}])->first();
		if (!$offer) {
			throw new NotFoundException();
		}
		$this->set('offer',$offer);
		if ($offer->recieve_group_id == $member->group_id) {
			//オファーを受信した側の場合
			$this->render('recieve');
		} else if ($offer->offer_user_id == $member->id) {
			//オファーを送信した側の場合
			//お相手情報を取得
			$service = new CompanionService();
			$group = $service->getCompanionPairGroup($offer->recieve_group_id);
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

	}

	/**
	 * オファー拒否
	 */
	public function reduce() {

	}

	/**
	 * 承諾オファーキャンセル
	 */
	public function cancel() {
	}

	/**
	 * クレジットカード決済
	 */
	public function pay() {

	}
}
