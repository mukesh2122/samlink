<?php

Doo::loadCore('db/DooSmartModel');

class SyPlayerChannelRel extends DooSmartModel {
    
    public $FK_CHANNEL;
    public $FK_PLAYER;
    public $isFavorite;
    
    public $_table = 'sy_playerchannel_rel';
    public $_primarykey = ''; 
    public $_fields = array(
		'FK_CHANNEL',
                'FK_PLAYER',
                'isFavorite',
	);

}
?>