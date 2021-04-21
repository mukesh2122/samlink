<?php
Doo::loadCore('db/DooSmartModel');

class SnPlayerWidgetRel extends DooSmartModel {

	public $ID;
	public $ID_PLAYER;
	public $ID_WIDGET;
	public $isOpen;
	public $isVisible;
	public $WidgetOrder;

	public $_table = 'sn_playerwidget_rel';
	public $_primarykey = 'ID';
	public $_fields = array(
		'ID',
		'ID_PLAYER',
		'ID_WIDGET',
		'isOpen',
		'isVisible',
		'WidgetOrder'
	);
}
?>