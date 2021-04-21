<?php
Doo::loadCore('db/DooSmartModel');

class NwHighlights extends DooSmartModel{

	public $ID_HIGHLIGHT;
	public $Image;
	public $Headline;
	public $IntroText;
	public $URL;
	public $Priority;
	public $isActive;
	public $InactiveReason;

	public $_table = 'nw_highlights';
	public $_primarykey = 'ID_HIGHLIGHT';
	public $_fields = array(
		'ID_HIGHLIGHT'
	,	'Image'
	,	'Headline'
	,	'IntroText'
	,	'URL'
	,	'Priority'
	,	'isActive'
	,	'InactiveReason'
	);

}
?>