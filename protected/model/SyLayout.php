<?php
Doo::loadCore('db/DooSmartModel');

class SyLayout extends DooSmartModel {

    public $Menu;
    public $Name;
    public $Value;
    public $isDefault;
    public $isActive;
    
    public $_table = 'sy_layout';
    public $_primarykey = ''; 
    public $_fields = array(
        'Menu',
		'Name',
		'Value',
        'isDefault',
        'isActive',
	);

}
?>