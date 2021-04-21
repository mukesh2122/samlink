<?php
Doo::loadCore('db/DooSmartModel');

class SnFriendsRel extends DooSmartModel{

	public $ID_PLAYER;
	public $ID_FRIEND;
	public $Mutual;
	public $MutualTime;
	public $Subscribed;
	public $SubscriptionTime;
	public $RequestPending;
	public $FriendName;
	
	public $_table = 'sn_friends_rel';
	public $_primarykey = 'ID_PLAYER';
	public $_fields = array(
		'ID_PLAYER'
	,	'ID_FRIEND'
	,	'Mutual'
	,	'MutualTime'
	,	'Subscribed'
	,	'SubscriptionTime'
	,	'RequestPending'
	,	'FriendName'
	);

}
?>