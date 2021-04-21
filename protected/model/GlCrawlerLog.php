<?php
Doo::loadCore('db/DooSmartModel');

class GlCrawlerLog extends DooSmartModel{

	public $ID_LOG;
	public $LogStartTime;
	public $LogUpdateTime;
	public $LogEndTime;
	public $LogStatus;
	public $LogReport;

	public $_table = 'gl_crawlerlog';
	public $_primarykey = 'ID_LOG';
	public $_fields = array(
		'ID_LOG',
		'LogStartTime',
		'LogUpdateTime',
		'LogEndTime',
		'LogStatus',
		'LogReport',
	);
}
?>