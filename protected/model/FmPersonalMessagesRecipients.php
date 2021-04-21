<?php
Doo::loadCore('db/DooSmartModel');

class FmPersonalMessagesRecipients extends DooSmartModel{
    public $ID_PM;
    public $ID_PLAYER;
    public $Bcc;
    public $isRead;
    public $isDeleted;

    public $_table = 'fm_pm_recipients';
    public $_primarykey = 'ID_PM';
    public $_fields = array('ID_PM','ID_PLAYER','Bcc','isRead', 'isDeleted');
    
    
    
}
?>