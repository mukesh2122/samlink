<?php

Doo::loadCore('db/DooSmartModel');

class SnPlayerInfoRel extends DooSmartModel {

	public $ID_PLAYER;
	public $ID_INFO;
	public $_table = 'sn_playerinfo_rel';
	public $_primarykey = '';
	public $_fields = array(
		'ID_PLAYER',
		'ID_INFO',
	);

}
?> 
