<?php
Doo::loadCore('db/DooSmartModel');

class SnPlatformsLocale extends DooSmartModel{

    public $ID_PLATFORM;
    public $ID_LANGUAGE;
    public $PlatformName;
    public $PlatformDesc;

    public $_table = 'sn_platformlocales';
    public $_primarykey = 'ID_PLATFORM';
    public $_fields = array(
                            'ID_PLATFORM',
                            'ID_LANGUAGE',
                            'PlatformName',
                            'PlatformDesc',
                         );


}
?>