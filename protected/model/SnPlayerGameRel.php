<?php

Doo::loadCore('db/DooSmartModel');

class SnPlayerGameRel extends DooSmartModel {

    public $ID_PLAYER;
    public $ID_GAME;
    public $isAdmin;
    public $isSubscribed;
    public $SubscriptionTime;
    public $isPlaying;
    public $isMember;
    public $MemberTime;
    public $isEditor;
    public $isForumAdmin;
    public $isForumModerator;
    public $isShared;
    public $isLiked;
    public $isDownloaded;
    public $PostCount;
    public $Comments;
    public $ESport;
    public $GameName;
    public $ID_GAMETYPE;
    public $Signature;
    
    public $_table = 'sn_playergame_rel';
    public $_primarykey = ''; //disabled cuz of updates and 2 keys used
    public $_fields = array(
		'ID_PLAYER',
		'ID_GAME',
		'isAdmin',
		'isSubscribed',
        'SubscriptionTime',
		'isPlaying',
		'isMember',
        'MemberTime',
		'isEditor',
		'isForumAdmin',
		'isForumModerator',
		'isShared',
		'isLiked',
        'isDownloaded',
		'PostCount',
		'Comments',
		'ESport',
        'GameName',
        'ID_GAMETYPE',
        'Signature',
	);

}
?>