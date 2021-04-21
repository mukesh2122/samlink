<?php
Doo::loadCore('db/DooSmartModel');

class RsResponses extends DooSmartModel {

    public $ID_RESPONSE;
    public $FK_NOTICE;
    public $FK_OWNER;
    public $OwnerType;
    public $ResponseDetailsLog;
    public $ResponseStatus;

    public $_table = 'rs_responses';
    public $_primarykey = 'ID_RESPONSE';
    public $_fields = array(
        'ID_RESPONSE',
        'FK_NOTICE',
        'FK_OWNER',
        'OwnerType',
        'ResponseDetailsLog',
        'ResponseStatus',
        );
};
?>
