<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

class User extends Entity {

	protected $_virtual = ['sex_name'];

	protected function _getSexName() {

		switch($this->_properties['sex']) {
			case '1':return '男性';
			case '2':return '女性';
		}

		return '';
	}
}
