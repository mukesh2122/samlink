<?php
Doo::loadCore('db/DooSmartModel');

class CssMemberlevel extends DooSmartModel {
    public $ID;
    public $type;
    public $level;
    public $description;

	public $_table = 'css_memberlevel';
	public $_primarykey = 'ID';
	public $_fields = array(
        'ID',
        'type',
        'level',
        'description',
    );
}
?>