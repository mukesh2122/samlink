<?php

Doo::loadCore('db/DooSmartModel');

class FmCollapsedCategories extends DooSmartModel {

    public $ID_PLAYER;
    public $ID_OWNER;
    public $ID_CAT;
    public $OwnerType;
	
    public $_table = 'fm_collapsed_categories';
    public $_primarykey = '';
    public $_fields = array('ID_PLAYER', 'ID_OWNER', 'ID_CAT', 'OwnerType');

}
?>