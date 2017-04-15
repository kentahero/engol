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

class TopController extends AppController
{

	public function index() {
		
		$tableAreas = TableRegistry::get('Areas');
		$query = $tableAreas->find();
		foreach ($query as $row) {
			//debug($row);
		}
		
		$tablePref = TableRegistry::get('Prefectures');
		$prefs = $tablePref->find();
		$this->set('prefs',$prefs);
	}
}
