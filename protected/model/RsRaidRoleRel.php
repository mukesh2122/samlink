<?php
Doo::loadCore('db/DooSmartModel');

class RsRaidRoleRel extends DooSmartModel {

    public $FK_RAID;
    public $FK_ROLE;
    public $RoleCount;
    public $Remaining;

    public $_table = 'rs_raidrole_rel';
    public $_primarykey = '';
    public $_fields = array(
        'FK_RAID',
        'FK_ROLE',
        'RoleCount',
        'Remaining',
        );
};
?>
