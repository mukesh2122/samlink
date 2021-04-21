<?php

Doo::loadCore('db/DooSmartModel');

class EsFanclubs extends DooSmartModel {
    
    public $FK_TEAM;
    public $WelcomeMessage;
    public $ImageURL;
    public $isProfileUrl;
    
    public $_table = 'es_fanclubs';
    public $_primarykey = 'FK_TEAM'; 
    public $_fields = array(
		'FK_TEAM',
                'WelcomeMessage',
                'ImageURL',
                'isProfileUrl',
	);
}
?>