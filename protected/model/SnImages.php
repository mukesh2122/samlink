<?php
Doo::loadCore('db/DooSmartModel');

class SnImages extends DooSmartModel{

	public $ID_OWNER;
	public $OwnerType;
	public $ImageUrl;
	public $Orientation;

	public $_table = 'sn_images';
	public $_primarykey = '';
	public $_fields = array(
							'ID_OWNER',
							'OwnerType',
							'ImageUrl',
							'Orientation',
						 );

}
?>
