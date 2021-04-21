<?php

Doo::loadCore('db/DooSmartModel');

class EsMapLeagueRel extends DooSmartModel {
    
    public $FK_MAP;
    public $FK_LEAGUE;
    public $Round;
    
    public $_table = 'es_mapleague_rel';
    public $_primarykey = ''; 
    public $_fields = array(
		'FK_MAP',
                'FK_LEAGUE',
                'Round'
	);

}
?>