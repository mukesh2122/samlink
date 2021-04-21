<?php
Doo::loadCore('db/DooSmartModel');

class SyModules extends DooSmartModel{

	public $ID_MODULE;
	public $ModuleName;
	public $ModuleTitle;
	public $ModuleDesc;
	public $isEnabled;
	public $dependID;
	public $ModuleTag;
	public $OwnerType;
	public $_table = 'sy_modules';
	public $_primarykey = 'ID_MODULE';
	public $_fields = array(
		'ID_MODULE'
	,	'ModuleName'
	,	'ModuleTitle'
	,	'ModuleDesc'
	,	'isEnabled'
	,	'dependID'
	,	'ModuleTag'
	,	'OwnerType'
	);

}
?>
