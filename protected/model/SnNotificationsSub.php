<?php
Doo::loadCore('db/DooSmartModel');

class SnNotificationsSub extends DooSmartModel{
    public $ID_MAIN;
    public $MainType;
    public $NotificationType;
    public $ID_SUB;
    public $ReplyNumber;
    public $ID_OWNER;
    public $OwnerType;
    public $ActionTime;

    public $_table = 'sn_subnotifications';
    public $_primarykey = 'ID_MAIN';
    public $_fields = array('ID_MAIN',
                            'MainType',
                            'NotificationType',
                            'ID_SUB',
                            'ReplyNumber',
                            'ID_OWNER',
                            'OwnerType',
                            'ActionTime',
                            );
    
}
?>