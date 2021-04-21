<?php
Doo::loadCore('db/DooSmartModel');

class CssPlayerprofileRel extends DooSmartModel {
    public $ID_PROFILE;
    public $ID_PLAYER;

	public $_table = 'css_playerprofile_rel';
	public $_primarykey = '';
	public $_fields = array(
        'ID_PROFILE',
        'ID_PLAYER',
    );
}
?>