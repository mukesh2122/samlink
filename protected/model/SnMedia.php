<?php
Doo::loadCore('db/DooSmartModel');

class SnMedia extends DooSmartModel{
	public $ID_MEDIA;
	public $MediaType;
	public $MediaName;
	public $MediaDesc;
	public $URL;
	public $ID_OWNER;
	public $OwnerType;

	public $_table = 'sn_media';
    public $_primarykey = 'ID_MEDIA';
	public $_fields = array('ID_MEDIA',
                            'MediaType',
                            'MediaName',
                            'MediaDesc',
                            'URL',
                            'ID_OWNER',
                            'OwnerType',
                            );
}
?>