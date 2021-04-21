<?php
Doo::loadCore('db/DooSmartModel');

class SnRatings extends DooSmartModel{

    public $ID_OWNER;
    public $OwnerType;
    public $ID_FROM;
    public $Rating;

    public $_table = 'sn_ratings';
    public $_primarykey = 'ID_OWNER';
    public $_fields = array(
                            'ID_OWNER',
                            'OwnerType',
							'ID_FROM',
							'Rating'
                         );
}
?>