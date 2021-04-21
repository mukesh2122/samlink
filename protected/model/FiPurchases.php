<?php

Doo::loadCore('db/DooSmartModel');

class FiPurchases extends DooSmartModel {

    public $ID_PURCHASE;
    public $ID_PLAYER;
    public $ID_PRODUCT;
    public $ProductType;
    public $ProductName;
    public $ProductDesc;
    public $ImageURL;
    public $ID_ORDER;
    public $Status;
    public $PurchaseTime;
    public $PendingTime;
    public $ProcessingTime;
    public $ShippingTime;
    public $ClosedTime;
    public $CancelledTime;
    public $RefundedTime;
    public $UnitPrice;
    public $Quantity;
    public $Remaining;
    public $Discount;
    public $TotalPrice;
    public $DownloadURL;
    public $DownloadAttempts;
    public $AttemptsRemaining;
    public $isDownloaded;
    
    public $_table = 'fi_purchases';
    public $_primarykey = 'ID_PURCHASE';
    public $_fields = array(
        'ID_PURCHASE',
		'ID_PLAYER',
		'ID_PRODUCT',
		'ProductType',
		'ProductName',
		'ProductDesc',
		'ImageURL',
		'ID_ORDER',
		'Status',
		'PurchaseTime',
		'PendingTime',
		'ProcessingTime',
		'ShippingTime',
		'ClosedTime',
		'CancelledTime',
		'RefundedTime',
		'UnitPrice',
		'Quantity',
		'Remaining',
		'Discount',
		'TotalPrice',
		'DownloadURL',
		'DownloadAttempts',
		'AttemptsRemaining',
		'isDownloaded',
    );

}
?>