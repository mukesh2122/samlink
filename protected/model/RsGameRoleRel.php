<?php
Doo::loadCore('db/DooSmartModel');

class RsGameRoleRel extends DooSmartModel {

    public $FK_GAME;
    public $FK_ROLE;

    public $_table = 'rs_gamerole_rel';
    public $_primarykey = '';
    public $_fields = array(
        'FK_GAME',
        'FK_ROLE',
        );
};
?>
