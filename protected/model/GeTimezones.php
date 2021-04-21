<?php
Doo::loadCore('db/DooSmartModel');

class GeTimezones extends DooSmartModel{

    public $ID_TIMEZONE;
    public $TimeZoneText;
    public $HelpText;
    public $Offset;
    

    public $_table = 'ge_timezones';
    public $_primarykey = 'ID_TIMEZONE';
    public $_fields = array(
                            'ID_TIMEZONE',
                            'TimeZoneText',
                            'HelpText',
                            'Offset'
                         );
}
?>