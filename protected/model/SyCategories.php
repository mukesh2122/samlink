<?php
Doo::loadCore('db/DooSmartModel');

class SyCategories extends DooSmartModel {

    public $ID_CATEGORY; 
    public $CategoryName;
    public $MBA_enabled;
    public $OwnerType;

    public $_table = 'sy_categories';
    public $_primarykey = 'ID_CATEGORY';
    public $_fields = array(
        'ID_CATEGORY',
        'CategoryName',
        'MBA_enabled',
        'OwnerType',
        );
};
?>
