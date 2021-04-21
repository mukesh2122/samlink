<?php
Doo::loadCore('db/DooSmartModel');

class SnWalltags extends DooSmartModel{

	public $ID_WALLTAG;
	public $ID_WALLITEM;
	public $ID_TAGGED;
	public $ID_TAGGEDBY;
	public $ID_ALBUM;
	public $OwnerType;
	public $DisplayName;
	public $Frame;
	public $Untagged;
	
	public $_table = 'sn_walltags';
	public $_primarykey = 'ID_WALLTAG';
	public $_fields = array(
		'ID_WALLTAG'
	,	'ID_WALLITEM'
	,	'ID_TAGGED'
	,	'ID_TAGGEDBY'
	,	'ID_ALBUM'
	,	'OwnerType'
	,	'DisplayName'
	,	'Frame'
	,	'Untagged'
	);

}
?>