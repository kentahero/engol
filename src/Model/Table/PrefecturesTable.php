<?php
namespace App\Model\Table;

use Cake\ORM\Table;

class PrefecturesTable extends Table {

	public function initialize(array $config) {
		$this->setPrimaryKey('cd');
	}

}
