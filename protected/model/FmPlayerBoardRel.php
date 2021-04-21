<?php

Doo::loadCore('db/DooSmartModel');

class FmPlayerBoardRel extends DooSmartModel {

    public $ID_PLAYER;
    public $ID_OWNER;
    public $ID_BOARD;
    public $OwnerType;
    public $ID_MSG;
    public $LastActivityTime;
	
    public $_table = 'fm_playerboard_rel';
    public $_primarykey = '';
    public $_fields = array('ID_PLAYER', 'ID_OWNER', 'ID_BOARD', 'OwnerType', 'ID_MSG', 'LastActivityTime');

}
?>