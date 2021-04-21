<?php

Doo::loadCore('db/DooSmartModel');

class SnInvitations extends DooSmartModel {

	public $ID_PLAYER;
	public $EMail;
	public $InviteTime;
	public $SentCount;
	public $LastNotificationTime;
	public $isAccepted;
	public $ID_NEWPLAYER;
	public $_table = 'sn_invitations';
	public $_fields = array(
		'ID_PLAYER',
		'EMail',
		'InviteTime',
		'SentCount',
		'LastNotificationTime',
		'isAccepted',
		'ID_NEWPLAYER',
	);

}
?> 
