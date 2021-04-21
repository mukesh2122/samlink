<?php
Doo::loadCore('db/DooSmartModel');

class SnAlbums extends DooSmartModel{

	public $ID_ALBUM;
	public $ID_OWNER;
	public $OwnerType;
	public $AlbumName;
	public $AlbumDescription;
	public $LastUpdatedTime;
	public $ImageCount;
	
	public $_table = 'sn_albums';
	public $_primarykey = 'ID_ALBUM';
	public $_fields = array(
		'ID_ALBUM'
	,	'ID_OWNER'
	,	'OwnerType'
	,	'AlbumName'
	,	'AlbumDescription'
	,	'LastUpdatedTime'
	,	'ImageCount'
	);

}
?>