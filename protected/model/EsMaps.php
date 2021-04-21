<?php

Doo::loadCore('db/DooSmartModel');

class EsMaps extends DooSmartModel {
    
    public $ID_MAP;
    public $MapName;
    public $MapDesc;
    public $FK_GAME;
    
    public $_table = 'es_maps';
    public $_primarykey = 'ID_MAP'; 
    public $_fields = array(
		'ID_MAP',
                'MapName',
                'MapDesc',
                'FK_GAME'
	);

}
?>