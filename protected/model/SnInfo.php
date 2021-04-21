<?php

Doo::loadCore('db/DooSmartModel');

class SnInfo extends DooSmartModel {

	public $ID_INFO;
	public $InfoTextEN;
	public $InfoTextDK;
	public $InfoTextDE;
	public $InfoTextFR;
	public $InfoTextES;
	public $InfoTextRO;
	public $InfoTextLT;
	public $InfoTextBG;
	public $InfoTextNL;
	public $InfoTextEL;
	public $Controller;
	public $Method;
	public $_table = 'sn_info';
	public $_primarykey = 'ID_INFO';
	public $_fields = array(
		'ID_INFO',
		'InfoTextEN',
		'InfoTextDK',
		'InfoTextDE',
		'InfoTextFR',
		'InfoTextES',
		'InfoTextRO',
		'InfoTextLT',
		'InfoTextBG',
		'InfoTextNL',
		'InfoTextEL',
		'Controller',
		'Method',
	);

}
?>