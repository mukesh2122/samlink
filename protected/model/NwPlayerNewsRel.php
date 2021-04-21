<?php
Doo::loadCore('db/DooSmartModel');

class NwPlayerNewsRel extends DooSmartModel{

    public $ID_PLAYER;
    public $ID_NEWS;
    public $ID_OWNER;
    public $OwnerType;
    public $isShared;
    public $isCommented;
    public $isSubscribed;
    public $SubscriptionTime;
    public $Headline;

    public $_table = 'nw_playernews_rel';
    public $_primarykey = '';
    public $_fields = array(
			'ID_PLAYER',
			'ID_NEWS',
			'ID_OWNER',
			'OwnerType',
			'isShared',
			'isCommented',
			'isSubscribed',
			'SubscriptionTime',
			'Headline',
	 );
}
?>