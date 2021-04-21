<?php

Doo::loadCore('db/DooSmartModel');

class SnPlayerGroupRel extends DooSmartModel{
	public $ID_PLAYER;
    public $ID_GROUP;
    public $ID_PARENT;
    public $isLeader;
    public $isOfficer;
    public $isAdmin;
    public $isSubscribed;
    public $isMember;
    public $isEditor;
    public $isForumAdmin;
    public $isForumModerator;
    public $isShared;
    public $isLiked;
    public $isInvited;
    public $ID_INVITEDBY;
    public $hasApplied;
    public $PostCount;
    public $Comments;
    public $Signature;
    
    public $_table = 'sn_playergroup_rel';
    public $_primarykey = ''; //disabled cuz of updates and 2 keys used
    
    public $_fields = array( 
		'ID_PLAYER',
		'ID_GROUP',
		'ID_PARENT',
		'isLeader',
		'isOfficer',
		'isAdmin',
		'isSubscribed',
		'isMember',
		'isEditor',
		'isForumAdmin',
		'isForumModerator',
		'isShared',
		'isLiked',
		'isInvited',
		'ID_INVITEDBY',
		'hasApplied',
		'PostCount',
		'Comments',
		'Signature',
	);
	
}
?>