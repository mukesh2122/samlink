<?php
Doo::loadCore('db/DooSmartModel');

class RsServers extends DooSmartModel {

    public $ID_SERVER;
    public $ServerName;
    public $ServerIP;
    public $ServerDesc;

    public $_table = 'rs_servers';
    public $_primarykey = 'ID_SERVER';
    public $_fields = array(
        'ID_SERVER',
        'ServerName',
        'ServerIP',
        'ServerDesc',
        );
};
?>