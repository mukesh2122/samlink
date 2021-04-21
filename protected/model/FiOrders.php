<?php

Doo::loadCore('db/DooSmartModel');

class FiOrders extends DooSmartModel {

	public $ID_ORDER;
	public $ID_PARENT;
	public $ID_PLAYER;
	public $PlayerIP;
	public $BillingFirstName;
	public $BillingLastName;
	public $BillingAddress;
	public $BillingCity;
	public $BillingZip;
	public $BillingCountry;
	public $BillingEMail;
	public $BillingPhone;
	public $ID_COUNTRY;
	public $ShippingFirstName;
	public $ShippingLastName;
	public $ShippingAddress;
	public $ShippingCity;
	public $ShippingZip;
	public $ShippingCountry;
	public $ShippingInclVAT;
	public $ShippingExclVAT;
	public $ShippingVAT;
	public $ShippingVATPercentage;
	public $GeoLocation;
	public $Status;
	public $CreatedTime;
	public $PendingTime;
	public $ProcessingTime;
	public $ClosedTime;
	public $CancelledTime;
	public $RefundedTime;
	public $PendingCount;
	public $ProcessingCount;
	public $ShippingCount;
	public $ClosedCount;
	public $CancelledCount;
	public $RefundedCount;
	public $Quantity;
	public $TotalPrice;
	
	public $_table = 'fi_orders';
	public $_primarykey = 'ID_ORDER';
	public $_fields = array(
		'ID_ORDER',
		'ID_PARENT',
		'ID_PLAYER',
		'PlayerIP',
		'BillingFirstName',
		'BillingLastName',
		'BillingAddress',
		'BillingCity',
		'BillingZip',
		'BillingCountry',
		'BillingEMail',
		'BillingPhone',
		'ID_COUNTRY',
		'ShippingFirstName',
		'ShippingLastName',
		'ShippingAddress',
		'ShippingCity',
		'ShippingZip',
		'ShippingCountry',
		'ShippingInclVAT',
		'ShippingExclVAT',
		'ShippingVAT',
		'ShippingVATPercentage',
		'GeoLocation',
		'Status',
		'CreatedTime',
		'PendingTime',
		'ProcessingTime',
		'ShippingTime',
		'ClosedTime',
		'CancelledTime',
		'RefundedTime',
		'PendingCount',
		'ProcessingCount',
		'ShippingCount',
		'ClosedCount',
		'CancelledCount',
		'RefundedCount',
		'Quantity',
		'TotalPrice',
	);

}
?>