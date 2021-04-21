<?php
Doo::loadCore('db/DooSmartModel');

class FiProductTypeLocale extends DooSmartModel{

    public $ID_PRODUCTTYPE;
    public $ID_LANGUAGE;
    public $ProductTypeName;
    public $ProductTypeDesc;

    public $_table = 'fi_producttypelocales';
    public $_primarykey = '';
    public $_fields = array(
                            'ID_PRODUCTTYPE',
                            'ID_LANGUAGE',
                            'ProductTypeName',
                            'ProductTypeDesc',
                         );


}
?>