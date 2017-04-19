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

class EntryController extends AppController
{

	public function index() {

		$groupId = $this->request->getQuery('group_id');

		//都道府県リストの生成
		$tablePref = TableRegistry::get('Prefectures');
		$prefs = $tablePref->find('list');
		$this->set('prefs',$prefs);

		//選択ペアの取得
		$service = new CompanionService();
		$group = $service->getCompanionPairGroup($groupId);
		if (count($group->users) != 2) {
			//ペア出ない場合は404
			throw new NotFoundException();
		}
		$this->set('group',$group);

	}

	public function confirm() {

	}

	public function finish() {

	}
}