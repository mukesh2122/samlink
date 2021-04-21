<?php

Doo::loadCore('db/DooSmartModel');

class EsLeagueTeamRel extends DooSmartModel {
    
    public $FK_LEAGUE;
    public $FK_TEAM;
    public $ParticipantStatus;
    
    public $_table = 'es_leagueteam_rel';
    public $_primarykey = ''; 
    public $_fields = array(
		'FK_LEAGUE',
                'FK_TEAM',
                'ParticipantStatus',
	);
}
?>