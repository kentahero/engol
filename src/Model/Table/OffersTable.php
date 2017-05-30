<?php
namespace App\Model\Table;

use Cake\ORM\Table;
use Cake\Validation\Validator;
use Cake\I18n\FrozenDate;
use App\Model\Entity\Offer;

class OffersTable extends Table {

	public function initialize(array $config) {
		//同伴者情報の結合
		$this->belongsTo('OfferUsers',
				[
						'className'=>'Users',
						'foreignKey'=>'offer_user_id',
						'propertyName'=>'offer_user',
						'joinType'=>'INNER',
						'conditions'=>['OfferUsers.deleted'=>'0']
				]);
		$this->belongsTo('ReceiveGroups',
				[
						'className'=>'UserGroups',
						'foreignKey'=>'receive_group_id',
						'propertyName'=>'receive_group'
				]);

		$this->belongsTo('CoursePrefectures',
				[
						'className'=>'Prefectures',
						'foreignKey'=>'course_prefecture_cd',
                        'propertyName'=>'course_prefecture'
				]);
		$this->belongsTo('TrainingPrefectures',
				[
						'className'=>'Prefectures',
						'foreignKey'=>'training_prefecture_cd',
						'propertyName'=>'training_prefecture'
				]);
	}

	public function validationDefault(Validator $validator) {
		$validator
			->notEmpty('date1','希望日１を選択して下さい')
			->add('date1','custom1',['rule'=>[$this,'limitDate'],'message'=>'本日より4日後～30日以内の日付でしか希望出来ません'])
			->add('date1','custom2',['rule'=>[$this,'mergeDate'],'message'=>'希望日付が他の日付と同じ日になっています'])
			->add('date1','custom3',['rule'=>[$this,'duplicateDate'],'message'=>'その日付は既にオファー申し込みしています']);
		$validator
			->allowEmpty('date2')
			->add('date2','custom1',['rule'=>[$this,'limitDate'],'message'=>'本日より4日後～30日以内の日付でしか希望出来ません'])
			->add('date2','custom2',['rule'=>[$this,'mergeDate'],'message'=>'希望日付が他の日付と同じ日になっています'])
			->add('date2','custom3',['rule'=>[$this,'duplicateDate'],'message'=>'その日付は既にオファー申し込みしています']);
		$validator
			->allowEmpty('date3')
			->add('date3','custom1',['rule'=>[$this,'limitDate'],'message'=>'本日より4日後～30日以内の日付でしか希望出来ません'])
			->add('date3','custom2',['rule'=>[$this,'mergeDate'],'message'=>'希望日付が他の日付と同じ日になっています'])
			->add('date3','custom3',['rule'=>[$this,'duplicateDate'],'message'=>'その日付は既にオファー申し込みしています']);
		$validator
			->requirePresence('course_kind','プレイ場所を選択してください')
			->notEmpty('course_kind','プレイ場所を選択してください');
		$validator
			->notEmpty('course_prefecture_cd','ゴルフ場の地域を選択して下さい')
			->notEmpty('course_name','ゴルフ場名を選択または入力して下さい');
		$validator
			->notEmpty('training_prefecture_cd','練習場の地域を選択して下さい')
			->notEmpty('training_name','練習場名を入力して下さい');

		return $validator;
	}

	public function limitDate($value, $context) {

		$date = new FrozenDate($value);
		if ($date->isPast()) {
			return false;
		}
		if ($date->isWithinNext('3 days')) {
			return false;
		}
		if (!$date->isWithinNext('30 days')) {
			return false;
		}
		return true;
	}

	public function mergeDate($value, $context) {
		if (($context['data']['date1'] == $context['data']['date2'] && $context['data']['date1'] !=null && $context['data']['date2'] != null)
				|| ($context['data']['date1'] == $context['data']['date3'] && $context['data']['date1'] !=null && $context['data']['date3'] != null)
						|| $context['data']['date2'] == $context['data']['date3'] && $context['data']['date2'] !=null && $context['data']['date3'] != null) {
					return false;
		}
		return true;
	}

	public function duplicateDate($value, $context) {
		if (isset($context['data']['offer_user_id'])) {
			$offer = $this->find()->where([
					'offer_user_id'=>$context['data']['offer_user_id'],
					'OR'=>['date1'=>$value,'date2'=>$value,'date3'=>$value],
					'status !='=>Offer::STATUS_CANCEL,
					'status !='=>Offer::STATUS_REDUCE
				])->first();

			if ($offer)
				return false;
		}
		return true;
	}

	public function playEmpty($value, $context) {
		if (isset($context['data']['course_kind'])) {
			if ($context['data']['course_kind'] == '1') {
				return !(empty($context['data']['course_name']) && empty($context['data']['course_name_other']));
			} else if ($context['data']['course_kind'] == '2') {
				return !empty($value);
			}
		}
		return true;
	}
}
