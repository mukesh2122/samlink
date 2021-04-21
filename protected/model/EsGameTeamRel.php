<?php

Doo::loadCore('db/DooSmartModel');

class EsGameTeamRel extends DooSmartModel {
    
    public $FK_TEAM;
    public $FK_GAME;
    public $isActive;
    
    public $_table = 'es_gameteam_rel';
    public $_primarykey = ''; 
    public $_fields = array(
                'FK_TEAM',
		'FK_GAME',
                'isActive',
	);
}
?>