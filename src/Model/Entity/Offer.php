<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

class Offer extends Entity {

	const STATUS_OFFER = 0;
	const STATUS_ACCEPT = 1;
	const STATUS_PAYED = 2;
	const STATUS_CLOSE = 3;
	const STATUS_REDUCE = 5;
	const STATUS_CANCEL = 9;

	protected $_virtual = ['offer_title','receive_title','course_kind_name'];

	protected function _getOfferTitle() {
		switch ($this->_properties['status']) {
			case self::STATUS_OFFER:
				return 'オファーを申し込みました';
			case self::STATUS_ACCEPT:
				return 'オファーが承諾されました';
			case self::STATUS_PAYED:
				return 'ご成約が完了しました';
			case self::STATUS_CLOSE:
				return 'ラウンドが完了しました';
			case self::STATUS_REDUCE:
				return 'オファーが拒否されました';
			case self::STATUS_CANCEL:
				return 'キャンセルされました';
		}
		return '';
	}

	protected function _getReceiveTitle() {
		switch ($this->_properties['status']) {
			case self::STATUS_OFFER:
				return 'オファーが申し込まれました';
			case self::STATUS_ACCEPT:
				return 'オファーを承諾しました';
			case self::STATUS_REDUCE:
				return 'オファーを拒否しました';
			case self::STATUS_PAYED:
				return 'ご成約が完了ました。';
			case self::STATUS_CLOSE:
				return 'ラウンドが完了しました';
			case self::STATUS_CANCEL:
				return 'キャンセルされました';
		}
		return '';
	}

	protected function _getCourseKindName() {
		switch ($this->_properties['course_kind']) {
			case 1:
				return 'ゴルフ場';
			case 2:
				return '練習場';
		}
		return '';
	}
}
