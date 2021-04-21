<?php

Doo::loadCore('db/DooSmartModel');

class EsGamelobby extends DooSmartModel {
    
    public $FK_PLAYER;
    public $OnPage;
    
    public $_table = 'es_gamelobby';
    public $_primarykey = ''; 
    public $_fields = array(
		'FK_PLAYER',
                'OnPage'
	);

}
?>