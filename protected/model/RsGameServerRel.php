<?php
Doo::loadCore('db/DooSmartModel');

class RsGameServerRel extends DooSmartModel {

    public $FK_GAME;
    public $FK_SERVER;

    public $_table = 'rs_gameserver_rel';
    public $_primarykey = '';
    public $_fields = array(
        'FK_GAME',
        'FK_SERVER',
    );
};
?>
