<?php
Doo::loadCore('db/DooSmartModel');

class FiPayments extends DooSmartModel{
    public $ID_PAYMENT;
    public $ID_PLAYER;
    public $PaymentTime;
    public $PaymentType;
    public $PaymentProvider;
    public $PlayerIP;
    public $PaymentText;
    public $Hash;
    public $ID_TXN;

    public $_table = 'fi_payments';
    public $_primarykey = 'ID_PAYMENT';
    public $_fields = array(
        'ID_PAYMENT',
        'ID_PLAYER',
        'PaymentTime',
        'PaymentType',
        'PaymentProvider',
        'PlayerIP',
        'PaymentText',
        'Hash',
        'ID_TXN',
        );

}
?>