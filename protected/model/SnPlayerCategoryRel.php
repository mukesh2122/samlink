<?php
Doo::loadCore('db/DooSmartModel');

class SnPlayerCategoryRel extends DooSmartModel {

    public $ID_OWNER;
    public $ID_CATEGORY;
    public $Approved;
    public $ID_APPROVER;

    public $_table = 'sn_playercategory_rel';
    public $_primarykey = '';
    public $_fields = array(
        'ID_OWNER',
        'ID_CATEGORY',
        'Approved',
        'ID_APPROVER'
        );
};
?>
