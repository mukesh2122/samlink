<?php
Doo::loadCore('db/DooSmartModel');

class MeConversations extends DooSmartModel{

	public $ID_CONVERSATION;
	public $Participants;
	public $ParticipantCount;
	public $MessageCount;
	public $LastMessageTime;

	public $_table = 'me_conversations';
	public $_primarykey = 'ID_CONVERSATION';
	public $_fields = array(
							'ID_CONVERSATION',
							'Participants',
							'ParticipantCount',
							'MessageCount',
							'LastMessageTime',
						 );


}
?>