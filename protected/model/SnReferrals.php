<?php

Doo::loadCore('db/DooSmartModel');

class SnReferrals extends DooSmartModel {

	public $ID_REFERRAL;
	public $VoucherCode;
	public $RecordType;
	public $ID_REFERRER;
	public $ActionTime;
	public $ID_REFERREE;
	public $Credits;
	
	public $_table = 'sn_referrals';
	public $_primarykey = 'ID_REFERRAL';
	public $_fields = array(
		'ID_REFERRAL',
		'VoucherCode',
		'ID_REFERRER',
		'RecordType',
		'ActionTime',
		'ID_REFERREE',
		'Credits',
	);

}
?>