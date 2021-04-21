<?php
Doo::loadCore('db/DooSmartModel');

class SnResponses extends DooSmartModel {

    public $ID_RESPONSE;
    public $FK_NOTICE;
    public $FK_OWNER;
    public $OwnerType;
    public $ResponseDetailsLog;
    public $ResponseStatus;
    public $CreatedTime;
    public $Price;
	public $PaymentType;
    public $_table = 'sn_responses';
    public $_primarykey = 'ID_RESPONSE';
    public $_fields = array(
        'ID_RESPONSE',
        'FK_NOTICE',
        'FK_OWNER',
        'OwnerType',
        'ResponseDetailsLog',
        'ResponseStatus',
		'CreatedTime',
        'Price',
	    'PaymentType',
        );
};
?>
