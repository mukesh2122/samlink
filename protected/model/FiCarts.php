<?php
Doo::loadCore('db/DooSmartModel');

class FiCarts extends DooSmartModel{
    public $ID_CART;
    public $ID_PLAYER;
    public $CreatedTime;
    public $LastUpdatedTime;
    public $TotalPrice;
    public $Quantity;

    public $_table = 'fi_carts';
    public $_primarykey = 'ID_CART';
    public $_fields = array(
        'ID_CART',
        'ID_PLAYER',
        'CreatedTime',
        'LastUpdatedTime',
        'TotalPrice',
        'Quantity',
        );

}
?>