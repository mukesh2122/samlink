<?php

Doo::loadCore('db/DooSmartModel');

class EvParticipants extends DooSmartModel {

	public $ID_EVENT;
	public $ID_PLAYER;
	public $isParticipating;
	public $isSubscribed;
	public $isExpired;
	public $isInvited;
	public $isExtended;
	public $_table = 'ev_participants';
	public $_primarykey = '';
	public $_fields = array(
		'ID_EVENT',
		'ID_PLAYER',
		'isParticipating',
		'isSubscribed',
		'isExpired',
		'isInvited',
		'isExtended'
	);

}
?>