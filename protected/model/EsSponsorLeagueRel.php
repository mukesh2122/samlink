<?php

Doo::loadCore('db/DooSmartModel');

class EsSponsorLeagueRel extends DooSmartModel {
    
    public $FK_LEAGUE;
    public $FK_SPONSOR;
    public $SponsorPlace;
    
    public $_table = 'es_sponsorleague_rel';
    public $_primarykey = ''; 
    public $_fields = array(
		'FK_LEAGUE',
		'FK_SPONSOR',
                'SponsorPlace'
	);

}
?>