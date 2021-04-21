<?php
Doo::loadCore('db/DooSmartModel');

class RsFactions extends DooSmartModel {

    public $ID_FACTION;
    public $FactionName;

    public $_table = 'rs_factions';
    public $_primarykey = 'ID_FACTION';
    public $_fields = array(
        'ID_FACTION',
        'FactionName',
        );
};
?>
