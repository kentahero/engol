<?php
namespace App\Model\Table;

use Cake\ORM\Table;
use Cake\Validation\Validator;
use Cake\ORM\TableRegistry;

class CompanionInfosTable extends Table {


	/**
	 *
	 * @param Validator $validator
	 */

	public function validationDefault(Validator $validator) {

		$validator
			->notEmpty('pr','ＰＲ文を入力して下さい');
		$validator
			->notEmpty('average_score','平均スコアを入力して下さい')
			->numeric('average_score','半角数字のみで入力して下さい');
		$validator
			->notEmpty('round_week','ラウンド出来る曜日を選択して下さい');
		$validator
			->notEmpty('training_week','練習場に行ける曜日を選択して下さい');
		$validator
			->notEmpty('course_prefecture_cd','ゴルフ場エリアを選択して下さい');
		$validator
			->notEmpty('training_prefecture_cd','練習場エリアを選択して下さい');
		$validator
			->notEmpty('history','ゴルフ歴を入力して下さい');
		$validator
			->allowEmpty('amount')
			->numeric('amount','半角数字のみで入力して下さい')
			->lessThanOrEqual('amount', 30000, '最大3万円までで指定して下さい');
		$validator
			->requirePresence('play_amount_kind','プレイ費の負担について選択して下さい')
			->notEmpty('play_amount_kind','プレイ費の負担について選択して下さい');
		$validator
			->allowEmpty('pair_email')
			->add('pair_email','validFormat',['rule'=>'email','message'=>'メールアドレスの形式で入力して下さい'])
			->add('pair_email','custom',['rule'=>[$this,'existsEmail'],'message'=>'このアドレスでは登録されていません']);
		$validator
			->notEmpty('image1','プロフィール画像を少なくとも一つはアップロードして下さい');

		$validator
			->notEmpty('payment_bank','金融機関名を入力して下さい')
			->notEmpty('payment_shop_name','支店名を入力して下さい')
			->notEmpty('payment_no','口座番号を入力して下さい')
			->notEmpty('payment_name','口座名義を入力して下さい');
		$validator
			->requirePresence('payment_bank_kind','口座種別を選択して下さい')
			->notEmpty('payment_bank_kind','口座種別を選択して下さい');
		return $validator;
	}

	public function existsEmail($value, $context) {

		$tableUser = TableRegistry::get('Users');
		$user = $tableUser->find()->where(['email'=>$value,'deleted'=>0])->first();
		if ($user) {
			return true;
		}
		return false;
	}


}
