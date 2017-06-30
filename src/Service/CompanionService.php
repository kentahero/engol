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
	public function findCompanions($conditions,$pagenator) {
		$GroupsTable = TableRegistry::get('UserGroups');
		$UsersTable = TableRegistry::get('Users');

		//ぶら下がるユーザーの条件式を構築
		$companionCond = ['companion_flg'=>'1','Users.deleted'=>'0'];
		if (!empty($conditions['pref_cd']))$companionCond['prefecture_cd'] = $conditions['pref_cd'];
		if (!empty($conditions['sex']))$companionCond['sex'] = $conditions['sex'];
		if (!empty($conditions['age'])) {
			$ageTable = [
					'20'=>['lower'=>20,'upper'=>24],
					'25'=>['lower'=>25,'upper'=>29],
					'30'=>['lower'=>30,'upper'=>34],
					'35'=>['lower'=>35,'upper'=>39],
					'40'=>['lower'=>40,'upper'=>0]
			];
			$companionCond['display_age >='] = $ageTable[$conditions['age']]['lower'];
			if ($ageTable[$conditions['age']]['upper']!=0)$companionCond['display_age <='] = $ageTable[$conditions['age']]['upper'];
		}
		$userQuery = $UsersTable->find('all')->select(['group_id'])->where($companionCond);

		//グループテーブルを検索
		$query = $GroupsTable->find('all')
			->where(['deleted'=>'0','id IN'=>$userQuery])
			->contain(['Users'=> function($query) {
				return $query->select()->where(['companion_flg'=>'1','Users.deleted'=>'0'])->contain(['CompanionInfos','Prefectures']);
			}]);
		//$groups = $query->all();
		$groups = $pagenator->paginate($query,['limit'=>10]);

		//debug($groups);

		return $groups;
	}

	/**
	 * レコメンドの取得
	 */
	public function getReccomend() {
		$CompanionInfos = TableRegistry::get("Users");
		$query = $CompanionInfos->find('all')->contain(['CompanionInfos'])->order('CompanionInfos.offer_count DESC')->limit(10);
		return $query->all();
	}

	/**
	 * 特定のユーザーからペアを取得する
	 * @param unknown $userId
	 * @return unknown
	 */
	public function getCompanionPair($userId) {

		$Users = TableRegistry::get("Users");
		$queryUser = $Users->find()->where([
					'Users.id'=>$userId,
					'Users.deleted'=>'0',
					'companion_flg'=>'1',
				])->contain(['CompanionInfos'=>function ($query) {
					return $query->select()->contain(['CoursePrefectures','TrainingPrefectures']);
				},'Prefectures','Cities']);
		$user = $queryUser->first();
		if ($user == null) {
			return null;
		}
		$queryPair = $Users->find()->where([
					'Users.id !='=>$userId,
					'group_id'=>$user->group_id,
					'Users.deleted'=>'0',
					'companion_flg'=>'1',
				])->contain(['CompanionInfos'=>function ($query) {
					return $query->select()->contain(['CoursePrefectures','TrainingPrefectures']);
				},'Prefectures','Cities']);
		$pair = $queryPair->first();
		$user['pair'] = $pair;
		return $user;
	}

	/**
	 * グループIDからペアを取得
	 * @param unknown $groupId
	 * @return unknown
	 */
	public function getCompanionPairGroup($groupId) {
		$UsersGroup = TableRegistry::get("UserGroups");
		$query = $UsersGroup->find('all')->where(
				[
					'id'=>$groupId,
					'UserGroups.deleted'=>'0',
				])->contain(['Users'=> function($query) {
					$query->select()->where(['Users.deleted'=>'0','companion_flg'=>'1'])->contain(['CompanionInfos','Prefectures']);
					return $query;
				}]);
		return $query->first();
	}

}