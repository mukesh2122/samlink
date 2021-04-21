<?php

Doo::loadCore('db/DooSmartModel');

class SyMenuLocale extends DooSmartModel {

	public $ID_MENU;
	public $ID_LANGUAGE;
	public $MenuName;
	public $MenuDesc;
	
	public $_table = 'sy_menulocales';
	public $_primarykey = '';
	public $_fields = array(
		'ID_MENU',
		'ID_LANGUAGE',
		'MenuName',
		'MenuDesc',
	);

}
?>