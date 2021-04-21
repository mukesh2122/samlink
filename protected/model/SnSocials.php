<?php

Doo::loadCore('db/DooSmartModel');

class SnSocials extends DooSmartModel {
    
    public $ID_SOCIAL;
    public $SocialName;
    public $ImageURL;
    
    //Owners url
    public $SocialURL;
    
    public $_table = 'sn_socials';
    public $_primarykey = 'ID_SOCIAL'; 
    public $_fields = array(
		'ID_SOCIAL',
                'SocialName',
                'ImageURL'
	);

}
?>