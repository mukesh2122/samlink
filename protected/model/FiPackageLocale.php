<?php

Doo::loadCore('db/DooSmartModel');

class FiPackageLocale extends DooSmartModel {

	public $ID_PACKAGE;
	public $ID_LANGUAGE;
	public $PackageName;
	public $PackageDesc;
	public $_table = 'fi_packagelocales';
	public $_primarykey = '';
	public $_fields = array(
		'ID_PACKAGE',
		'ID_LANGUAGE',
		'PackageName',
		'PackageDesc',
	);

}
?>