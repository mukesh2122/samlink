<?php
Doo::loadCore('db/DooSmartModel');

class FiPlayerFeatureRel extends DooSmartModel {

    public $ID_PLAYER;
    public $ID_PACKAGE;
    public $PackageType;
    public $ID_FEATURE;
    public $ActivationTime;
    public $ExpirationTime;
    public $Quantity;
    public $SpecialType;
   
    public $_table = 'fi_playerfeature_rel';
    public $_primarykey = '';
    public $_fields = array(
        'ID_PLAYER',
		'ID_PACKAGE',
		'PackageType',
		'ID_FEATURE',
		'ActivationTime',
		'ExpirationTime',
		'Quantity',
		'SpecialType',
    );

}
?>