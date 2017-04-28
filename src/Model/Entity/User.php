<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

class User extends Entity {

	protected $_virtual = ['sex_name','sex_class'];

	protected function _getSexName() {
		switch($this->_properties['sex']) {
			case '1':return '男';
			case '2':return '女';
		}
		return '';
	}

	protected function _getSexClass() {
		switch($this->_properties['sex']) {
			case '1':return 'male';
			case '2':return 'female';
		}
		return '';
	}
}
