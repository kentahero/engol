<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

class Users extends Entity {

	protected function _getSexName() {

		switch($this->_properties['sex']) {
			case '1':return '男性';
			case '2':return '女性';
		}

		return '';
	}

	protected function _getCoursePrefecture() {
		return 'ほげほげ';
	}

	protected function _getTrainingPrefecture() {
		return 'トレーニング';
	}
}
