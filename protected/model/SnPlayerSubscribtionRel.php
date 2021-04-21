<?php

Doo::loadCore('db/DooSmartModel');

class SnPlayerSubscribtionRel extends DooSmartModel {

	public $ID_PLAYER;
	public $ID_ITEM;
	public $ItemType;
	public $ItemName;
	public $SubscriptionTime;
	public $ID_OWNER;
	public $OwnerType;
	public $_table = 'sn_playersubscription_rel';
	public $_primarykey = '';
	public $_fields = array(
		'ID_PLAYER',
		'ID_ITEM',
		'ItemType',
		'ItemName',
		'SubscriptionTime',
		'ID_OWNER',
		'OwnerType',
	);

}
?> 
