<?php
Doo::loadCore('db/DooSmartModel');

class FiPlayerPackageRel extends DooSmartModel {

    public $ID_PLAYER;
    public $ID_PACKAGE;
    public $PackageType;
    public $PurchaseTime;
    public $ActivationTime;
    public $ExpirationTime;
    public $AutomaticExtension;
    public $isPaid;
    public $isPromotion;
   
    public $_table = 'fi_playerpackage_rel';
    public $_primarykey = '';
    public $_fields = array(
        'ID_PLAYER',
		'ID_PACKAGE',
		'PackageType',
		'PurchaseTime',
		'ActivationTime',
		'ExpirationTime',
		'AutomaticExtension',
		'isPaid',
		'isPromotion',
    );

}
?>