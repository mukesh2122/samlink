<?php

Doo::loadCore('db/DooSmartModel');

class EsSponsors extends DooSmartModel {
    
    public $ID_SPONSOR;
    public $SponsorName;
    public $SponsorDesc;
    public $ImageURL;
    public $Link;
    
    public $_table = 'es_sponsors';
    public $_primarykey = 'ID_SPONSOR'; 
    public $_fields = array(
		'ID_SPONSOR',
                'SponsorName',
                'SponsorDesc',
                'ImageURL',
                'Link'
	);

}
?>