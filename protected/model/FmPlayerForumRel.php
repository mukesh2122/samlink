<?php

Doo::loadCore('db/DooSmartModel');

class FmPlayerForumRel extends DooSmartModel {

    public $ID_PLAYER;
    public $ID_OWNER;
    public $OwnerType;
    public $ID_MSG;
    public $LastActivityTime;
	
    public $_table = 'fm_playerforum_rel';
    public $_primarykey = '';
    public $_fields = array('ID_PLAYER', 'ID_OWNER', 'OwnerType', 'ID_MSG', 'LastActivityTime');

}
?>