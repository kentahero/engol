<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;
use Cake\I18n\Time;

class User extends Entity {

	protected $_virtual = ['sex_name','sex_class','email_kind_name','real_age'];

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

	protected function _getRealAge() {
		return (int) ((date('Ymd')-$this->_properties['birth']->i18nFormat('YYYYMMdd', 'Asia/Tokyo'))/10000);
	}

	protected function _passwordConfirm() {
	}

	protected function _emailConfirm() {
	}

	protected function _emailKindName() {
		switch($this->_properties['email_kind']) {
			case '1':return '携帯';
			case '2':return 'PC';
		}
	}

}
