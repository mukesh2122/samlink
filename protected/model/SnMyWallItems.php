<?php
Doo::loadCore('db/DooSmartModel');

class SnMyWallItems extends DooSmartModel{

    public $ID_WALLITEM;
    public $ID_VIEWER;
    public $ID_OWNER;
    public $OwnerType;
 
    public $_table = 'sn_mywallitems';
    public $_primarykey = 'ReplyNumber';
    public $_fields = array('ID_WALLITEM','ID_VIEWER','ID_OWNER','OwnerType');

}
?>