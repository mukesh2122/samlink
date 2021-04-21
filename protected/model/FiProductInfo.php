<?php

Doo::loadCore('db/DooSmartModel');

class FiProductInfo extends DooSmartModel {

    public $ID_PRODUCTINFO;
    public $ID_PRODUCT;
    public $InfoType;
    public $Priority;
    public $Headline;
    public $InfoDesc;
    public $ImageURL;
    public $_table = 'fi_productinfo';
    public $_primarykey = 'ID_PRODUCTINFO';
    public $_fields = array(
        'ID_PRODUCTINFO',
        'ID_PRODUCT',
        'InfoType',
        'Priority',
        'Headline',
        'InfoDesc',
        'ImageURL',
    );

}
?>