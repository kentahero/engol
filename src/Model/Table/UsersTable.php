<?php
namespace App\Model\Table;

use Cake\ORM\Table;
use Cake\Validation\Validator;
use Cake\ORM\TableRegistry;

class UsersTable extends Table {

	public function initialize(array $config) {
		//同伴者情報の結合
		$this->hasOne('CompanionInfos');
		//居住地都道府県情報の結合
		$this->belongsTo('Prefectures')
			->setForeignKey('prefecture_cd');
			//->setJoinType('INNER');
		//居住地市区町村情報の結合
			$this->belongsTo('Cities')
			->setForeignKey('city_cd');
			//->setJoinType('INNER');
	}

	/**
	 *
	 * @param Validator $validator
	 */
	public function validationDefault(Validator $validator) {
		//Eメールチェック
		$validator
			//->requirePresence('email')
			->notEmpty('email','Eメールを入力して下さい')
			->add('email','validFormat',['rule'=>'email','message'=>'Eメールアドレスの形式で入力して下さい'])
			->add('email','maxLength',['rule'=>['maxLength',256],'message'=>'256文字以下で入力して下さい'])
			->add('email','custom',['rule'=>[$this,'duplicate'],'message'=>'既に登録されているアドレスです']);
		//Eメール確認チェック
		$validator
			->notEmpty('email_confirm','Eメールの確認を入力して下さい')
			->add('email_confirm','custom',['rule'=>[$this,'confirmEmail'],'message'=>'Eメールの確認が一致しません']);
		//パスワード
		$validator
			->notEmpty('password','パスワードを入力して下さい')
			->add('password','maxLength',['rule'=>['maxLength',64],'message'=>'64文字以下で入力して下さい']);

		//パスワード確認
		$validator
			->notEmpty('password_confirm','パスワードの確認を入力して下さい')
			->add('password_confirm','custom',['rule'=>[$this,'confirmPass'],'message'=>'パスワードの確認が一致しません']);

		return $validator;
	}

	public function duplicate($value, $context) {
		$count = $this->find('all')->where(['email'=>$value])->count();
		return $count==0;
	}

	public function confirmEmail($value, $context) {
		if (!$context) {
			return true;
		}
		if ($value != $context['data']['email']) {
			return false;
		}
		return true;
	}

	public function confirmPass($value, $context) {
		if ($context && $value != $context['data']['password']) {
			return false;
		}
		return true;
	}

}
