<?php

Doo::loadCore('db/DooSmartModel');

class AcLevels extends DooSmartModel {
    
    public $ID_LEVEL;
    public $FK_ACHIEVEMENT;
    public $Level;
    public $LevelName;
    public $LevelDesc;
    public $Points;
    public $ImageURL;
    public $Multiplier;
    public $IsLevelActive;
    public $Bonus;
    
    public $_table = 'ac_levels';
    public $_primarykey = 'ID_LEVEL'; 
    public $_fields = array(
		'ID_LEVEL',
		'FK_ACHIEVEMENT',
                'Level',
                'LevelName',
                'LevelDesc',
                'Points',
                'ImageURL',
                'Multiplier',
                'IsLevelActive',
                'Bonus'
	);

}
?>