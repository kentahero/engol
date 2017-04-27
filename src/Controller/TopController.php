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

class TopController extends AppController
{

	public function index() {

		//成約数の取得
		$tableResv = TableRegistry::get('Reservations');
		$count = $tableResv->find('all')->count();
		$this->set('count',$count);

		//都道府県データの取得
		$tablePref = TableRegistry::get('Prefectures');
		$prefs = $tablePref->find('list');
		$this->set('prefs',$prefs);

		//レコメンドデータの取得
		$service = new CompanionService();
		$recommend = $service->getReccomend();
		$this->set('recommend',$recommend);

		$this->assign('title','ゴルフのお相手を探すならエンゴル');
	}
}
