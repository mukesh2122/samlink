<?php
Doo::loadCore('db/DooSmartModel');

class RsGameModeRel extends DooSmartModel {

    public $FK_GAME;
    public $FK_GROUPTYPE;

    public $_table = 'rs_gamemode_rel';
    public $_primarykey = '';
    public $_fields = array(
        'FK_GAME',
        'FK_GROUPTYPE',
        );
};
?>
