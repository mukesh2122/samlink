<?php

Doo::loadCore('db/DooSmartModel');

class SnSocialsRel extends DooSmartModel {
    
    public $FK_OWNER;
    public $OwnerType;
    public $FK_SOCIAL;
    
    public $_table = 'sn_socials_rel';
    public $_primarykey = ''; //Multiple
    public $_fields = array(
		'FK_OWNER',
                'OwnerType',
                'FK_SOCIAL',
                'SocialURL',
	);

}
?>