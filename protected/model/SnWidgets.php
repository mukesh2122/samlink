<?php
Doo::loadCore('db/DooSmartModel');

class SnWidgets extends DooSmartModel {

	public $ID_WIDGET;
	public $Name;
	public $Module;
	public $isDefault;
	public $isHidden;

	public $_table = 'sn_widgets';
	public $_primarykey = 'ID_WIDGET';
	public $_fields = array(
		'ID_WIDGET',
		'Name',
		'Module',
		'isDefault',
		'isHidden'
	);
}
?>