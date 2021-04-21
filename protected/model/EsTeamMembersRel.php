<?php

Doo::loadCore('db/DooSmartModel');

class EsTeamMembersRel extends DooSmartModel {
    
    public $FK_PLAYER;
    public $FK_TEAM;
    public $Role;
    public $isCaptain;
    public $isPending;
    
    public $_table = 'es_teammembers_rel';
    public $_primarykey = ''; 
    public $_fields = array(
		'FK_PLAYER',
                'FK_TEAM',
                'Role',
                'isCaptain',
                'isPending'
	);

}
?>