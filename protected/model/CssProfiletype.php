<?php
Doo::loadCore('db/DooSmartModel');

class CssProfiletype extends DooSmartModel {
    public $ID;
    public $typeName;

	public $_table = 'css_profiletype';
	public $_primarykey = 'ID';
	public $_fields = array(
        'ID',
        'typeName',
    );
}
?>