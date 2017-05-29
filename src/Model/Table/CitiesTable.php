<?php
namespace App\Model\Table;

use Cake\ORM\Table;

class CitiesTable extends Table {

	public function initialize(array $config) {
		$this->setPrimaryKey('cd');

		//同伴者情報の結合
		$this->belongsTo('Prefectures')
			->setForeignKey('prefecture_cd');
	}

}
