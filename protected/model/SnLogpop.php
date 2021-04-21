<?php

Doo::loadCore('db/DooSmartModel');

class SnLogpop extends DooSmartModel {

	public $ID_OWNER;
	public $OwnerType;
	public $LogDate;
	public $LogTime;
	public $NewsReadCount;
	public $NewsCommentCount;
	public $NewsLikeCount;
	public $ItemLikeCount;
	public $NewsShareCount;
	public $ItemShareCount;
	public $DownloadCount;
	public $_table = 'sn_logpop';
	public $_primarykey = '';
	public $_fields = array(
		'ID_OWNER',
		'OwnerType',
		'LogDate',
		'LogTime',
		'NewsReadCount',
		'NewsCommentCount',
		'NewsLikeCount',
		'ItemLikeCount',
		'NewsShareCount',
		'ItemShareCount',
		'DownloadCount',
	);

}
?> 
