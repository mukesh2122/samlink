<?php

Doo::loadCore('db/DooSmartModel');

class AdCampaignCountryRel extends DooSmartModel {
    
    public $ID_CAMPAIGN;
    public $ID_COUNTRY;
    
    public $_table = 'ad_campaigncountry_rel';
    public $_primarykey = 'ID_LEVEL'; 
    public $_fields = array(
		'ID_CAMPAIGN',
		'ID_COUNTRY',
	);

}
?>