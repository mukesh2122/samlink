<?php
Doo::loadCore('db/DooSmartModel');

class FmPersonalMessages extends DooSmartModel{
    public $ID_PM;
    public $ID_PLAYER_FROM;
    public $DeletedBySender;
    public $FromName;
    public $MsgTime;
    public $Subject;
    public $Body;
	public $isShared;
	public $ID_SHAREOWNER;
	public $ShareOwnerType;

    public $_table = 'fm_personal_messages';
    public $_primarykey = 'ID_PM';
    public $_fields = array('ID_PM','ID_PLAYER_FROM','DeletedBySender','FromName', 'MsgTime','Subject','Body', 'isShared', 'ID_SHAREOWNER', 'ShareOwnerType');
    
    public function markAsRead() {
        $p = User::getUser();
        if($p) {
            $message = new FmPersonalMessagesRecipients();
            $message->isRead = 1;

            Doo::db()->update($message, array('where' => 'ID_PM = ? AND ID_PLAYER = ?' ,
                                                'param' => array($this->ID_PM, $p->ID_PLAYER)));

            $p->purgeCache();
        }
    }
    
}
?>