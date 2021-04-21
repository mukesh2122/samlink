<?php

Doo::loadCore('db/DooSmartModel');

class FiProducts extends DooSmartModel {

    public $ID_PRODUCT;
    public $ProductName;
    public $ProductDesc;
    public $ImageURL;
    public $isDownloadable;
    public $isFeatured;
    public $LastFeaturedTime;
    public $isSpecialOffer;
    public $SpecialPrice;
    public $isSpecialPremOffer;
    public $SpecialPremPrice;
    public $DownloadURL;
    public $ID_PRODUCTTYPE;
    public $ProductType;
    public $ID_PACKAGE;
    public $Price;
    public $Available;
    public $PurchaseCount;
    public $Position;
    public $InfoCount;
    public $ImageCount;
    public $_table = 'fi_products';
    public $_primarykey = 'ID_PRODUCT';
    public $_fields = array(
        'ID_PRODUCT',
        'ProductName',
        'ProductDesc',
        'ImageURL',
        'isDownloadable',
        'isFeatured',
        'LastFeaturedTime',
        'isSpecialOffer',
        'SpecialPrice',
        'isSpecialPremOffer',
        'SpecialPremPrice',
        'DownloadURL',
        'ID_PRODUCTTYPE',
        'ProductType',
        'ID_PACKAGE',
        'Price',
        'Available',
        'PurchaseCount',
        'Position',
        'InfoCount',
        'ImageCount',
    );

    /**
     * Checks if player is allowed to edit
     *
     * @return unknown
     */
    public function isAdmin()
    {
        $p = User::getUser();
        if($p)
        {
            if($p->canAccess('Edit products') === TRUE)
            {
                return TRUE;
            }
        }
        return FALSE;
    }
    
}
?>