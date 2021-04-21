<?php
Doo::loadCore('db/DooSmartModel');

class FiExchangeRates extends DooSmartModel{
    public $ID_EXCHANGE;
    public $Credits;
    public $Money;
    public $Currency;

    public $_table = 'fi_exchangerates';
    public $_primarykey = 'ID_EXCHANGE';
    public $_fields = array(
        'ID_EXCHANGE',
        'Credits',
        'Money',
        'Currency',
        );

}
?>