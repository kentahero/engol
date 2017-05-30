<?php
namespace App\Model\Table;

use Cake\ORM\Table;
use Cake\Validation\Validator;
use Cake\I18n\FrozenDate;

class UsersTable extends Table {

	public function initialize(array $config) {
		//同伴者情報の結合
		$this->hasOne('CompanionInfos');
		//居住地都道府県情報の結合;
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
			->notEmpty('email','メールアドレスを入力して下さい')
			->add('email','validFormat',['rule'=>'email','message'=>'メールアドレスの形式で入力して下さい'])
			->add('email','length',['rule'=>['maxLength',256],'message'=>'256文字以下で入力して下さい'])
			->add('email','custom',['rule'=>[$this,'duplicateEmail'],'message'=>'既に登録されているアドレスです']);
		//Eメール確認チェック
		$validator
			->notEmpty('email_confirm','メールアドレスの確認を入力して下さい')
			->add('email_confirm','custom',['rule'=>[$this,'confirmEmail'],'message'=>'メールアドレスの確認が一致しません']);
		//パスワード
		$validator
			->notEmpty('password','パスワードを入力して下さい')
			->add('password','length',['rule'=>['maxLength',64],'message'=>'64文字以下で入力して下さい'])
			->add('password','alphaNumeric',['rule'=>['alphaNumeric'],'message'=>'半角英数字のみで入力して下さい']);

		//パスワード確認
		$validator
			->notEmpty('password_confirm','パスワードの確認を入力して下さい')
			->add('password_confirm','custom',['rule'=>[$this,'confirmPass'],'message'=>'パスワードの確認が一致しません']);
		//名前４つ
		$validator
			->notEmpty('first_name','名前(性)を入力して下さい')
			->add('first_name','length',['rule'=>['maxLength',16],'message'=>'16文字以下で入力して下さい']);
		$validator
			->notEmpty('last_name','名前(名)を入力して下さい')
			->add('last_name','length',['rule'=>['maxLength',16],'message'=>'16文字以下で入力して下さい']);
		$validator
			->notEmpty('first_kana','名前(カナ性)を入力して下さい')
			->add('first_kana','length',['rule'=>['maxLength',16],'message'=>'16文字以下で入力して下さい'])
			->add('first_kana','katakana',['rule'=>[$this,'katakana'],'message'=>'全角カタカナで入力して下さい']);
		$validator
			->notEmpty('last_kana','名前(カナ名)を入力して下さい')
			->add('last_kana','length',['rule'=>['maxLength',16],'message'=>'16文字以下で入力して下さい'])
			->add('last_kana','katakana',['rule'=>[$this,'katakana'],'message'=>'全角カタカナで入力して下さい']);
		//ニックネーム
		$validator
			->notEmpty('nickname','ニックネームを入力して下さい')
			->add('nickname','length',['rule'=>['maxLength',9],'message'=>'9文字以下で入力して下さい'])
			->add('nickname','custom',['rule'=>[$this,'duplicateNickname'],'message'=>'既に使われているニックネームです']);
		//性別
		$validator
			->requirePresence('sex','性別を選択して下さい')
			->notEmpty('sex','性別を選択して下さい');
		//生年月日
		$validator
			->notEmpty('birth','生年月日を入力して下さい')
			->add('birth','date1',['rule'=>['date'],'message'=>'生年月日を入力して下さい'])
			->add('birth','custom',['rule'=>[$this,'birthAdult'],'message'=>'20歳未満の方はご利用頂けません']);
		//住所各種
		$validator
			->notEmpty('postal','郵便番号を入力して下さい')
			->add('postal','numeric',['rule'=>'numeric','message'=>'ハイフンなしの数字のみで入力して下さい'])
			->add('postal','length',['rule'=>['minLength',7],'message'=>'7桁の数字で入力して下さい'])
			->add('postal','length',['rule'=>['maxLength',7],'message'=>'7桁の数字で入力して下さい']);
		$validator
			->notEmpty('prefecture_cd','都道府県を選択して下さい');
		$validator
			->notEmpty('city_cd','市区町村を選択して下さい');
		$validator
			->allowEmpty('address1')
			->add('address1','length',['rule'=>['maxLength',256],'message'=>'256文字以内で入力して下さい']);
		$validator
			->allowEmpty('address2')
			->add('address2','length',['rule'=>['maxLength',256],'message'=>'256文字以内で入力して下さい']);
		$validator
			->notEmpty('tel','連絡先電話番号を入力して下さい')
			->add('tel','tel',['rule'=>['custom','/\d{2,4}-\d{2,4}-\d{4}/'],'message'=>'ハイフンありの電話番号形式で入力して下さい']);
		$validator
			->notEmpty('offer_year_1','希望日を入れて下さい')
			->notEmpty('offer_month_1','希望日を入力して下さい');
		$validator
			->requirePresence('agree','個人情報保護方針へ同意願います')
			->notEmpty('agree','個人情報保護方針へ同意願います')
			->equals('agree', '1', '個人情報保護方針へ同意願います');

		return $validator;
	}

	public function duplicateEmail($value, $context) {
		$count = $this->find('all')->where(['email'=>$value,'deleted'=>'0'])->count();
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
	public function duplicateNickname($value, $context) {
		$count = $this->find('all')->where(['nickname'=>$value,'deleted'=>'0'])->count();
		return $count==0;
	}
	public function birthAdult($value, $context) {
		$birth = new FrozenDate($value);
		if ((date('Ymd')-(int)$birth->format('Ymd'))/10000 < 20) {
			return false;
		}
		return true;
	}
	public function katakana($value, $context){
		return (bool)preg_match("/^[ァ-ヶー゛゜]*$/u", $value); // カタカナ
	}
}
