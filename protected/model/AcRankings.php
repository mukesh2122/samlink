<?php

Doo::loadCore('db/DooSmartModel');

class AcRankings extends DooSmartModel {

    public $FK_PLAYER;
    public $Points;
    public $PlayerName;
    public $Place;
    
    public $_table = 'ac_rankings';
    public $_primarykey = 'FK_PLAYER'; 
    public $_fields = array(
		'FK_PLAYER',
                'Points',
                'PlayerName',
                'Place'
	);

}
?>