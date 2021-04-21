<?php

Doo::loadCore('db/DooSmartModel');

class AcPlayerAchievementRel extends DooSmartModel {

    public $FK_PLAYER;
    public $FK_ACHIEVEMENT;
    public $Achievement;
    public $AchievementDesc;
    public $FK_LEVEL;
    public $Level;
    public $AchievementTime;
    public $ImageURL;
    
    public $_table = 'ac_playerachievement_rel';
    public $_primarykey = ''; 
    public $_fields = array(
                'FK_PLAYER',
		'FK_ACHIEVEMENT',
                'Achievement',
                'AchievementDesc',
                'FK_LEVEL',
                'Level',
                'AchievementTime',
                'ImageURL'
	);

}
?>