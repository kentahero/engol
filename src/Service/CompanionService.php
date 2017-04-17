<?php

namespace App\Service;

use Cake\ORM\TableRegistry;

/**
 * @property \App\Model\Table\GroupsTable $GroupsTable
 * @property \App\Model\Table\UsersTable $UsersTable
 * @property \App\Model\Table\CompanionInfosTable $CompanionInfosTable
 */
class CompanionService extends AppService {

	/**
	 * 登録ゴルファーの検索
	 * @param unknown $conditions 検索条件
	 * @return unknown
	 */
	public function findCompanions($conditions) {
		$GroupsTable = TableRegistry::get('UserGroups');
		$query = $GroupsTable->find('all')
			->where(['deleted'=>'0'])
			->contain(['Users'=> function($query){
				$companionCond = ['companion_flg'=>'1','Users.deleted'=>'0'];
				if (!empty($conditions['pref_cd']))$companionCond['prefecture_cd'] = $conditions['pref_cd'];
				if (!empty($conditions['sex']))$companionCond['sex'] = $conditions['sex'];
				if (!empty($conditions['age']))$companionCond['display_age'] = $conditions['age'];

				return $query->select()->where($companionCond)->contain('CompanionInfos');
			}]);
		$groups = $query->all();

		return $groups;
	}

	/**
	 * レコメンドの取得
	 */
	public function getReccomend() {
		$CompanionInfos = TableRegistry::get("Users");
		$CompanionInfos->find('all')->order('');
		return $CompanionInfos->all();
	}

	/**
	 * 特定のユーザーからペアを取得する
	 * @param unknown $userId
	 * @return unknown
	 */
	public function getCompanionPair($userId) {

		$Users = TableRegistry::get("Users");
		$user = $Users->find(
				['conditions'=>[
					'user_id'=>$userId,
					'deleted'=>'0',
					'companion_flg'=>'1',
					]
				]
			)->contain('CompanionInfos');
		return $user;

	}

}