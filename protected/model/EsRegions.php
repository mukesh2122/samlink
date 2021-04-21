<?php
Doo::loadCore('db/DooSmartModel');

class EsRegions extends DooSmartModel{

	public $ID_REGION;
	public $FK_GAME;
	public $RegionName;

	public $_table = 'es_regions';
	public $_primarykey = '';
	public $_fields = array(
							'ID_REGION',
							'FK_GAME',
							'RegionName',
						 );

}
?>
