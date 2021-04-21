<?php
Doo::loadCore('db/DooSmartModel');

class FiCartProductRel extends DooSmartModel{
    public $ID_CART;
    public $ID_PRODUCT;
    public $ProductName;
    public $UnitPrice;
    public $Quantity;
    public $Discount;
    public $TotalPrice;
    public $LastUpdatedTime;

    public $_table = 'fi_cartproduct_rel';
    public $_primarykey = '';
    public $_fields = array(
        'ID_CART',
        'ID_PRODUCT',
        'ProductName',
        'UnitPrice',
        'Quantity',
        'Discount',
        'TotalPrice',
        'LastUpdatedTime',
        );

}
?>