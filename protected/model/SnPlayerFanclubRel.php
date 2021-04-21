<?php

Doo::loadCore('db/DooSmartModel');

class SnPlayerFanclubRel extends DooSmartModel {

    public $ID_PLAYER;
    public $ID_FANCLUB;
    public $isSubscribed;
    public $SubsriptionTime;
    public $isLiked;
    
    public $_table = 'sn_playerfanclub_rel';
    public $_primarykey = ''; //disabled cuz of updates and 2 keys used
    public $_fields = array(
		'ID_PLAYER',
		'ID_FANCLUB',
		'isSubscribed',
		'SubscriptionTime',
		'isLiked',
	);
    
    public function isLiked(){
        return $this->isLiked == 1 ? true : false;
    }
    public function isSubscribed(){
        return $this->isSubscribed == 1 ? true : false;
    }
}
?>