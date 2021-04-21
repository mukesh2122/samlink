<?php
Doo::loadCore('db/DooSmartModel');

class CssProfiletable extends DooSmartModel {
    public $ID;
    public $fk_memberLevel;
    public $fk_profileType;
    public $fk_playerID;
    public $fk_cssTable;

	public $_table = 'css_profiletable';
	public $_primarykey = 'ID';
	public $_fields = array(
        'ID',
        'fk_memberLevel',
        'fk_profileType',
        'fk_playerID',
        'fk_cssTable',
    );
}
?>