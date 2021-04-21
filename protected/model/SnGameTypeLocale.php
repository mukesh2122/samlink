<?php

Doo::loadCore('db/DooSmartModel');

class SnGameTypeLocale extends DooSmartModel {

	public $ID_GAMETYPE;
	public $ID_LANGUAGE;
	public $GameTypeName;
	public $GameTypeDesc;
	
	public $_table = 'sn_gametypelocales';
	public $_primarykey = '';
	public $_fields = array(
		'ID_GAMETYPE',
		'ID_LANGUAGE',
		'GameTypeName',
		'GameTypeDesc',
	);

}
?>