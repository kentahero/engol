<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

class CompanionInfo extends Entity {

	const WEEK_ARRAY = ['月','火','水','木','金','土','日'];

	protected $_virtual = ['play_amount_kind_name','payment_bank_kind_name','round_week_str','training_week_str'];

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

	protected function _getRoundWeekStr() {
		if (!$this->getWeekStr('round_week')) {
			return '設定なし';
		}
		return $this->getWeekStr('round_week');
	}

	protected function _getTrainingWeekStr() {
		if (!$this->getWeekStr('training_week')) {
			return '設定なし';
		}
		return $this->getWeekStr('training_week');
	}

	private function getWeekStr($property) {

		$weeks = '';
		$ar = explode(',',$this->_properties[$property]);
		foreach($ar as $key=>$val) {
			if ($val == '1') {
				$weeks = $weeks . self::WEEK_ARRAY[$key]. ',';
			}
			if ($val == 'ALL') {
				return 'いつでも';
			}
		}
		$weeks = rtrim($weeks,',');
		return $weeks;
	}
}
