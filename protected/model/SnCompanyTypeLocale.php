<?php

Doo::loadCore('db/DooSmartModel');

class SnCompanyTypeLocale extends DooSmartModel {

	public $ID_COMPANYTYPE;
	public $ID_LANGUAGE;
	public $CompanyTypeName;
	public $CompanyTypeDesc;

	public $_table = 'sn_companytypelocales';
	public $_primarykey = '';
	public $_fields = array(
		'ID_COMPANYTYPE',
		'ID_LANGUAGE',
		'CompanyTypeName',
		'CompanyTypeDesc',
	);

}
?>