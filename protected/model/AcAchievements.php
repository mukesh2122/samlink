<?php

Doo::loadCore('db/DooSmartModel');

class AcAchievements extends DooSmartModel {

    public $ID_ACHIEVEMENT;
    public $FK_BRANCH;
    public $AchievementName;
    public $AchievementDesc;
    public $ImageURL;
    public $IsActive;
    
    public $_table = 'ac_achievements';
    public $_primarykey = 'ID_ACHIEVEMENT'; 
    public $_fields = array(
		'ID_ACHIEVEMENT',
		'FK_BRANCH',
		'AchievementName',
		'AchievementDesc',
		'ImageURL',
                'IsActive'
	);
}
?>