<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

class CompanionInfo extends Entity {

	protected $_virtual = ['play_amount_kind_name','payment_bank_kind_name'];

	protected function _getPlayAmountKindName() {
		switch($this->_properties['play_amount_kind']) {
			case '1':return '自身で負担';
			case '2':return '相手に負担してもらう';
		}
		return '';
	}

	protected function _getPaymentBankKindName() {
		switch($this->_properties['payment_bank_kind']) {
			case '1':return '普通';
			case '2':return '当座';
		}
		return '';
	}

}
