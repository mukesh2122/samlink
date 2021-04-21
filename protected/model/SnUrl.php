<?php

Doo::loadCore('db/DooSmartModel');

class SnUrl extends DooSmartModel {

	public $ID_URL;
	public $ID_OWNER;
	public $OwnerType;
	public $ID_LANGUAGE;
	public $URLType;
	public $URL;
	public $Controller;
	public $Method;
	public $ID_PLAYER;
	public $UsrInfo;
	public $LastVisitedTime;
	public $VisitCount;
	public $_table = 'sn_url';
	public $_primarykey = 'ID_URL';
	public $_fields = array(
		'ID_URL',
		'ID_OWNER',
		'OwnerType',
		'ID_LANGUAGE',
		'URLType',
		'URL',
		'Controller',
		'Method',
		'ID_PLAYER',
		'UsrInfo',
		'LastVisitedTime',
		'VisitCount',
	);

}
?>