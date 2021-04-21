<?php

Doo::loadCore('db/DooSmartModel');

class AdCampaigns extends DooSmartModel {
    
    public $ID_LEVEL;
    public $FK_ACHIEVEMENT;
    public $Level;
    public $LevelName;
    public $LevelDesc;
    public $Points;
    
    public $_table = 'ad_campaigns';
    public $_primarykey = 'ID_CAMPAIGN'; 
    public $_fields = array(
		'ID_CAMPAIGN',
		'AdvertiserName',
                'StartDate',
                'EndDate',
                'Country',
                'Language',
	);

}
?>