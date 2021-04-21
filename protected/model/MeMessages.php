<?php
Doo::loadCore('db/DooSmartModel');

class MeMessages extends DooSmartModel{

	public $ID_MESSAGE;
	public $ID_CONVERSATION;
	public $ID_PLAYER;
	public $DisplayName;
	public $Avatar;
	public $MessageText;
	public $MessageTime;
	public $isShared;
	public $ID_SHAREOWNER;
	public $ShareOwnerType;

	public $_table = 'me_messages';
	public $_primarykey = 'ID_MESSAGE';
	public $_fields = array(
							'ID_MESSAGE',
							'ID_CONVERSATION',
							'ID_PLAYER',
							'DisplayName',
							'Avatar',
							'MessageText',
							'MessageTime',
							'isShared',
							'ID_SHAREOWNER',
							'ShareOwnerType',
						 );

}
?>