<?php
Doo::loadCore('db/DooSmartModel');

class RsRaidPlayerRoleRel extends DooSmartModel {

    public $FK_RAID;
    public $FK_PLAYER;
    public $FK_ROLE;
    public $CharName;

    public $_table = 'rs_raidplayerrole_rel';
    public $_primarykey = '';
    public $_fields = array(
        'FK_RAID',
        'FK_PLAYER',
        'FK_ROLE',
        'CharName',
        );
};
?>
