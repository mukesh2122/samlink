<?php
Doo::loadCore('db/DooSmartModel');

class NwSites extends DooSmartModel{

	public $ID_SITE;
	public $Name;
	public $LastUpdateTime;
	public $isActive;
	public $_table = 'nw_sites';
	public $_primarykey = 'ID_SITE';
	public $_fields = array(
		'ID_SITE'
	,	'Name'
	,	'LastUpdateTime'
	,	'isActive'
	 );

	// Checks if player is super admin
	public function isAdmin()
	{
		$p = User::getUser();
		if($p)
		{
			if($p->canAccess('Super Admin Interface') === TRUE)
			{
				return TRUE;
			}
		}
		return FALSE;
	}

}
?>
