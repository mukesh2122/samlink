<?php
Doo::loadCore('db/DooSmartModel');

class RsRaids extends DooSmartModel {

    public $ID_RAID;
    public $OwnerType;
    public $FK_OWNER;
    public $StartTime;
    public $EndTime;
    public $Recurring;
    public $FK_GAME;
    public $FK_SERVER;
    public $Location;
    public $Size;
    public $RaidDesc;
    public $InviteType;
    public $Finalized;
    public $RemindInterval;

    public $_table = 'rs_raids';
    public $_primarykey = 'ID_RAID';
    public $_fields = array(
        'ID_RAID',
        'OwnerType',
        'FK_OWNER',
        'StartTime',
        'EndTime',
        'Recurring',
        'FK_GAME',
        'FK_SERVER',
        'Location',
        'Size',
        'RaidDesc',
        'InviteType',
        'Finalized',
        'RemindInterval',
        );
};
?>