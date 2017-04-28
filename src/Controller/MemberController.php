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

class MemberController extends AppController
{

	public function index() {

		$member = $this->request->session()->read('member');

		if ($member) {

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

	public function forgot() {
		$email = $this->request->getData('email');
		$birth = $this->request->getData('birth');
	}
}
