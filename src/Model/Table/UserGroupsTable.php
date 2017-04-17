<?php
namespace App\Model\Table;

use Cake\ORM\Table;

class UserGroupsTable extends Table {

	public function initialize(array $config) {
		//同伴者情報の結合
		$this->hasMany('Users')->setForeignKey('group_id');
	}


}
