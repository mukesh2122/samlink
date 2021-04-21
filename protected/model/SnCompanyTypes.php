<?php
Doo::loadCore('db/DooSmartModel');

class SnCompanyTypes extends DooSmartModel{

    public $ID_COMPANYTYPE;
    public $CompanyTypeName;
    public $CompanyTypeDesc;

    public $_table = 'sn_companytypes';
    public $_primarykey = 'ID_COMPANYTYPE';
    public $_fields = array(
                            'ID_COMPANYTYPE',
                            'CompanyTypeName',
                            'CompanyTypeDesc',
                         );
}
?>