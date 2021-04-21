<?php

Doo::loadCore('db/DooSmartModel');

class SnPlayerCompanyRel extends DooSmartModel{
	public $ID_PLAYER;
	public $ID_COMPANY;
	public $isAdmin;
	public $isSubscribed;
	public $isMember;
	public $isEditor;
	public $isForumModerator;
	public $isForumAdmin;
	public $isShared;
	public $isLiked;
	public $Signature;

	public $_table = 'sn_playercompany_rel';
	public $_primarykey = '';

	public $_fields = array('ID_PLAYER','ID_COMPANY','isAdmin','isMember','isEditor','isForumModerator','isForumAdmin','isSubscribed','isShared', 'isLiked','Signature');
}
?>
