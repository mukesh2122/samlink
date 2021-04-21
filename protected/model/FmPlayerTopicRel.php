<?php

Doo::loadCore('db/DooSmartModel');

class FmPlayerTopicRel extends DooSmartModel {

    public $ID_PLAYER;
    public $ID_OWNER;
    public $ID_TOPIC;
    public $OwnerType;
    public $ID_MSG;
    public $LastActivityTime;
	
    public $_table = 'fm_playertopic_rel';
    public $_primarykey = '';
    public $_fields = array('ID_PLAYER', 'ID_OWNER', 'ID_TOPIC', 'OwnerType', 'ID_MSG', 'LastActivityTime');

}
?>