<?php

Doo::loadCore('db/DooSmartModel');

class SyCampaigns extends DooSmartModel {

	public $ID_CAMPAIGN;
	public $AdvertiserName;
	public $StartDate;
	public $EndDate;
	public $isAllTerritories;
	public $_table = 'sy_campaigns';
	public $_primarykey = 'ID_CAMPAIGN';
	public $_fields = array(
		'ID_CAMPAIGN',
		'AdvertiserName',
		'StartDate',
		'EndDate',
		'isAllTerritories',
		);
}
?>