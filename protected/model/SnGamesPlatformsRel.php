<?php
Doo::loadCore('db/DooSmartModel');

class SnGamesPlatformsRel extends DooSmartModel{

    public $ID_GAME;
    public $ID_PLATFORM;

    public $_table = 'sn_gameplatform_rel';
    public $_primarykey = 'ID_GAME';
    public $_fields = array(
                            'ID_GAME',
                            'ID_PLATFORM',
                         );
}
?>