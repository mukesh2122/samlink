<?php
Doo::loadCore('db/DooSmartModel');

class FriendsRel extends DooSmartModel{

    public $ID_PLAYER;
    public $ID_FRIEND;
    public $Mutual;
    public $Subscribed;
    public $RequestPending;
    public $FriendName;

    public $_table = 'sn_friends_rel';
    public $_primarykey = 'ID_FRIEND';
    public $_fields = array('ID_PLAYER','ID_FRIEND','Mutual','Subscribed','RequestPending','FriendName');
}
?>