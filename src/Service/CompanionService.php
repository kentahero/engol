<?php

namespace App\Service;

/**
 * @property \App\Model\Table\UsersTable $Users
 * @property \App\Model\Table\CompanionInfosTable $CompanionInfos
 */
class EnqueteFileService extends AppService {


	public function findCompanions($conditions) {
		$CompanionInfos = TableRegistryy::get("CompanionInfos");
		$CompanionInfos->find(
			['conditions'=>[
				'delete_flg'=>'0',
				'prefecture_cd'=>$conditions['pref_cd'],
				'sex'=>$conditions['sex'],
				'display_age'=>$conditions['age']
			]
		]);
	}

	public function getReccomend() {

	}


}