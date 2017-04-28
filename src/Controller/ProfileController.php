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

/**
 * 登録ゴルファーコントローラー
 * @author toshikazu.matsumoto
 *
 */
class ProfileController extends AppController
{
	public $paginate = ['limit' => 5];
	public $helpers = [
			'Paginator' => ['templates' => 'paginator-templates']
	];

	public function initialize()	{
		parent::initialize();
		$this->loadComponent('Paginator');
	}

	/**
	 * プロフィール表示
	 */
	public function index($userId = null) {
		$service = new CompanionService();
		$user = $service->getCompanionPair($userId);
		if ($user == null) {
			throw new NotFoundException('User Not Found');
		}
		$this->set('user',$user);
	}

	/**
	 * お相手検索
	 */
	public function search() {
		$prefCd = $this->request->getQuery('pref');
		$sex = $this->request->getQuery('sex');
		$age = $this->request->getQuery('age');

		//登録ゴルファーの検索
		$service = new CompanionService();
		$groups= $service->findCompanions(['pref_cd'=>$prefCd,'sex'=>$sex,'age'=>$age],$this->Paginator);

		//都道府県リストの生成
		$tablePref = TableRegistry::get('Prefectures');
		$prefs = $tablePref->find('list');
		$this->set(compact('groups','prefs'));

		if ($prefCd) {
			$pref = $tablePref->get($prefCd);
			$this->set('title',"{$pref->name}に居るゴルフのお相手一覧");
		} else {
			$this->set('title','ゴルフのお相手一覧');
		}
	}
}
