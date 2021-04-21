<?php

Doo::loadCore('db/DooSmartModel');

class NwPrefixes extends DooSmartModel {

    public $ID_PREFIX;
    public $PrefixName;
    public $PrefixColor;
    public $PrefixText;
    public $isLocked;
    //external
    private $URL;
    public $_table = 'nw_prefixes';
    public $_primarykey = 'ID_PREFIX';
    public $_fields = array(
        'ID_PREFIX',
        'PrefixName',
        'PrefixColor',
          'PrefixText',
        'isLocked',
    );

}

?>