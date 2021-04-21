<?php
Doo::loadCore('db/DooSmartModel');

class SnCategories extends DooSmartModel {

    public $ID_CATEGORY;
    public $CategoryName;

    public $_table = 'sn_categories';
    public $_primarykey = 'ID_CATEGORY';
    public $_fields = array(
        'ID_CATEGORY',
        'CategoryName',
        );
};
?>
