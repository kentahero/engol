<?php
namespace App\Model\Table;

use Cake\ORM\Table;

class UsersTable extends Table {

	public function initialize(array $config) {
		//同伴者情報の結合
		$this->hasOne('CompanionInfos');
		//居住地都道府県情報の結合
		$this->belongsTo('Prefectures')
			->setForeignKey('prefecture_cd')
			->setJoinType('INNER');
		//居住地市区町村情報の結合
			$this->belongsTo('Cities')
			->setForeignKey('city_cd')
			->setJoinType('INNER');

	}

}
