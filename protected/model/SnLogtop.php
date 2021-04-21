<?php

Doo::loadCore('db/DooSmartModel');

class SnLogtop extends DooSmartModel {

	public $ID_OWNER;
	public $OwnerType;
	public $LogDate;
	public $LogTime;
	public $NewsCount;
	public $MessageCount;
	public $GameCount;
	public $DownloadCount;
	public $EventCount;
	public $_table = 'sn_logtop';
	public $_primarykey = '';
	public $_fields = array(
		'ID_OWNER',
		'OwnerType',
		'LogDate',
		'LogTime',
		'NewsCount',
		'MessageCount',
		'GameCount',
		'DownloadCount',
		'EventCount',
	);

}
?> 
