<?php
namespace App\Model\Table;

use Cake\ORM\Table;

class OffersTable extends Table {

	public function initialize(array $config) {
		//同伴者情報の結合
		$this->belongsTo('OfferUsers',
				[
						'className'=>'Users',
						'foreignKey'=>'offer_user_id',
						'propertyName'=>'offer_user'
				]);
		$this->belongsTo('RecieveGroups',
				[
						'className'=>'UserGroups',
						'foreignKey'=>'recieve_group_id',
						'propertyName'=>'recieve_group'
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
						'propertyName'=>'course_prefecture'
				]);
	}


	public function validationDefault(Validator $validator) {

		$validator
			->notEmpty('offer_date_year1','希望日１を選択して下さい');

		return $validator;
	}
}
