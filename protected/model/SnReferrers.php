<?php

Doo::loadCore('db/DooSmartModel');

class SnReferrers extends DooSmartModel {

	public $ID_REFERRER;
	public $ID_PARENT;
	public $VoucherCode;
	public $EMail;
	public $DisplayName;
	public $Commision;
	
	public $_table = 'sn_referrers';
	public $_primarykey = 'VoucherCode';
	public $_fields = array(
		'ID_REFERRER',
		'ID_PARENT',
		'EMail',
		'VoucherCode',
		'DisplayName',
		'Commision',
	);

}
?>