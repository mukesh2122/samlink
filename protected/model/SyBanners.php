<?php

Doo::loadCore('db/DooSmartModel');

class SyBanner extends DooSmartModel {

	public $ID_BANNER;
	public $Placement;
	public $isCode;
	public $Code;
	public $PathToBanner;
	public $DestinationUrl;
	public $MaxDisplays;
	public $CurrentDisplays;
	public $MaxClicks;
	public $CurrentClicks;
	public $_table = 'sy_banners';
	public $_primarykey = 'ID_BANNER';
	public $_fields = array(
		'ID_BANNER',
		'Placement',
		'isCode',
		'Code',
		'PathToBanner',
		'DestinationUrl',
		'MaxDisplays',
		'CurrentDisplays',
		'MaxClicks',
		'CurrentClicks',
		);
}
?>