<?php
Doo::loadCore('db/DooSmartModel');

class SnGroupTypes extends DooSmartModel{

    public $ID_GROUPTYPE;
    public $GroupTypeName;
    public $GroupTypeDesc;
    public $Subtype;

    public $_table = 'sn_grouptypes';
    public $_primarykey = 'ID_GROUPTYPE';
    public $_fields = array(
                            'ID_GROUPTYPE',
                            'GroupTypeName',
                            'GroupTypeDesc',
                            'Subtype'
                         );
}
?>