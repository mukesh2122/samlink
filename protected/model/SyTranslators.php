<?php
Doo::loadCore('db/DooSmartModel');

class SyTranslators extends DooSmartModel{

	public $ID_PLAYER;
	public $ID_LANGUAGE;
	public $Country;
	public $isEditor;
	public $Commission;

	public $_table = 'sy_translators';
	public $_primarykey = '';
	public $_fields = array(
							'ID_PLAYER',
							'ID_LANGUAGE',
							'Country',
							'isEditor',
							'Commission',
						 );
}
?>