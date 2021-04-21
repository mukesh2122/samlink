<?php
Doo::loadCore('db/DooSmartModel');

class SyModuleFunctions extends DooSmartModel{

	public $ID_MODFUNC;
	public $ID_MODULE;
	public $FunctionName;
	public $FunctionTitle;
	public $isEnabled;
	public $dependModuleID;
	public $dependFunctionID;
	public $Required;
	public $FunctionTag;
	public $FunctionDesc;
	public $_table = 'sy_modulefunctions';
	public $_primarykey = 'ID_MODFUNC';
	public $_fields = array(
		'ID_MODFUNC'
	,	'ID_MODULE'
	,	'FunctionName'
	,	'FunctionTitle'
	,	'isEnabled'
	,	'dependModuleID'
	,	'dependFunctionID'
	,	'Required'
	,	'FunctionTag'
	,	'FunctionDesc'
	);

}
?>
