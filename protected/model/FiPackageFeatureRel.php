<?php
Doo::loadCore('db/DooSmartModel');

class FiPackageFeatureRel extends DooSmartModel {

    public $ID_PACKAGE;
    public $ID_FEATURE;
    public $Quantity;
    public $SpecialType;
    public $Position;
   
    public $_table = 'fi_packagefeature_rel';
    public $_primarykey = '';
    public $_fields = array(
        'ID_PACKAGE',
		'ID_FEATURE',
		'Quantity',
		'SpecialType',
		'Position',
    );

}
?>