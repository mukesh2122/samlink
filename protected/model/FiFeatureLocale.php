<?php

Doo::loadCore('db/DooSmartModel');

class FiFeatureLocale extends DooSmartModel {

	public $ID_FEATURE;
	public $ID_LANGUAGE;
	public $FeatureName;
	public $FeatureDesc;
	public $_table = 'fi_featurelocales';
	public $_primarykey = '';
	public $_fields = array(
		'ID_FEATURE',
		'ID_LANGUAGE',
		'FeatureName',
		'FeatureDesc',
	);

}
?>