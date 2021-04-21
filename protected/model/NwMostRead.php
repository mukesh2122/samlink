<?php
Doo::loadCore('db/DooSmartModel');

class NwMostRead extends DooSmartModel{

	public $ID_NEWS;
	public $ReadDate;
	public $ShowCount;

	public $_table = 'nw_mostread';
	public $_primarykey = 'ID_NEWS';
	public $_fields = array(
		'ID_NEWS'
	,	'ReadDate'
	,	'ShowCount'
	);

	// Checks if player is super admin
	public function isAdmin() {
		$p = User::getUser();
		if($p) {
			if($p->canAccess('Super Admin Interface') === TRUE) {
				return TRUE;
			}
		}
		return FALSE;
	}
}
?>