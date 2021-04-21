<?php
Doo::loadCore('db/DooSmartModel');

class GlSites extends DooSmartModel{

	public $ID_SITE;
	public $ID_LANGUAGE;
	public $Name;
	public $URL;
	public $isInternal;
	public $DomArticle;
	public $DomHeadline;
	public $DomIntrotext;
	public $DomNewstext;
	public $LastUpdateTime;
	public $isActive;
	public $Inactivereason;
	public $LoginURL;
	public $LoginUserXpath;
	public $LoginUsername;
	public $LoginPasswordXpath;
	public $LoginPassword;
	public $LoginSubmitXpath;
	public $LoginActive;
	public $_table = 'gl_sites';
	public $_primarykey = 'ID_SITE';
	public $_fields = array(
		'ID_SITE'
	,	'ID_LANGUAGE'
	,	'Name'
	,	'URL'
	,	'isInternal'
	,	'DomArticle'
	,	'DomHeadline'
	,	'DomIntrotext'
	,	'DomNewstext'
	,	'LastUpdateTime'
	,	'isActive'
	,	'InactiveReason'
	,	'LoginURL'
	,	'LoginUserXpath'
	,	'LoginUsername'
	,	'LoginPasswordXpath'
	,	'LoginPassword'
	,	'LoginSubmitXpath'
	,	'LoginActive'
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
