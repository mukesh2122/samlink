<?php
Doo::loadCore('db/DooSmartModel');

class RsNotices extends DooSmartModel {

    public $ID_NOTICE;
    public $FK_OWNER;
    public $OwnerType;
    public $isActive;
    public $FK_REGION;
    public $FK_LANGUAGE;
    public $FK_GAME;
    public $FK_SERVER;
    public $FK_FACTION;
    public $FK_GAMEPLAYLVL;
    public $FK_GAMEPLAYMODE;
    public $FK_ROLE;
    public $Details;
    public $InGameHandle;

    public $_table = 'rs_notices';
    public $_primarykey = 'ID_NOTICE';
    public $_fields = array(
        'ID_NOTICE',
        'FK_OWNER',
        'OwnerType',
        'isActive',
        'FK_REGION',
        'FK_LANGUAGE',
        'FK_GAME',
        'FK_SERVER',
        'FK_FACTION',
        'FK_GAMEPLAYLVL',
        'FK_GAMEPLAYMODE',
        'FK_ROLE',
        'Details',
        'InGameHandle',
        );
};
?>
