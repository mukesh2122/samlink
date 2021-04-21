<?php
Doo::loadCore('db/DooSmartModel');

class SnGroupAlliances extends DooSmartModel{

    public $ID_GROUP;
    public $ID_ALLIANCE;
    public $AllianceName;
    public $AllianceDesc;

    public $_table = 'sn_groupalliances';
    public $_primarykey = 'ID_GROUP';
    public $_fields = array(
                            'ID_GROUP',
                            'ID_ALLIANCE',
                            'AllianceName',
                            'AllianceDesc'
                         );
}
?>