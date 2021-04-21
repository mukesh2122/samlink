<?php
Doo::loadCore('db/DooSmartModel');

class MeParticipants extends DooSmartModel{

	public $ID_CONVERSATION;
	public $ID_PLAYER;
	public $LastReadTime;
	public $NewMessageCount;

	public $_table = 'me_participants';
	public $_primarykey = '';
	public $_fields = array(
							'ID_CONVERSATION',
							'ID_PLAYER',
							'LastReadTime',
							'NewMessageCount',
						 );

}
?>