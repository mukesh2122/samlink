<?php
Doo::loadCore('db/DooSmartModel');

class RsGameFactionRel extends DooSmartModel {

    public $FK_GAME;
    public $FK_FACTION;

    public $_table = 'rs_gamefaction_rel';
    public $_primarykey = '';
    public $_fields = array(
        'FK_GAME',
        'FK_FACTION',
        );
};
?>
