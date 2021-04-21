<?php
Doo::loadCore('db/DooSmartModel');

class SnNotices extends DooSmartModel {

    public $ID_NOTICE;
    public $FK_OWNER;
    public $OwnerType;
    public $isActive;
    public $FK_COUNTRY;
    public $FK_LANGUAGE;
    public $FK_CATEGORY;
    public $Details;
    public $NoticesStatus;
	public $Headline;
	public $NoticeType;
	public $SaleType;   
	public $CreatedTime; 
	public $CurrentPrice;  
	public $MinPrice;   
	public $StartPrice;   
	public $PaymentType; 
	public $Currency;
	public $FK_ALBUM;//catia
    public $_table = 'sn_notices';
    public $_primarykey = 'ID_NOTICE';
    public $_fields = array(
        'ID_NOTICE',
        'FK_CATEGORY',
		'FK_OWNER',
        'OwnerType',
        'isActive',
        'FK_LANGUAGE',
        'FK_COUNTRY',
        'Details',
        'NoticesStatus',
		'Headline',
		'NoticeType',
		'SaleType',
	'CreatedTime',
	'CurrentPrice',
	'MinPrice', 
	'StartPrice',
	'PaymentType',
	'Currency',
	'FK_ALBUM',//catia
        );
};
?>
