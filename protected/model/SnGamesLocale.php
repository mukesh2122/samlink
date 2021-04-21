<?php
Doo::loadCore('db/DooSmartModel');

class SnGamesLocale extends DooSmartModel{

    public $ID_GAME;
    public $ID_LANGUAGE;
    public $GameName;
    public $CreationDate;
    public $GameDesc;
    public $ID_GAMETYPE;
    public $GameType;
    public $ID_COMPANY;
    public $CompanyName;

    public $_table = 'sn_gamelocales';
    public $_primarykey = 'ID_GAME';
    public $_fields = array(
                            'ID_GAME',
                            'ID_LANGUAGE',
                            'GameName',
                            'CreationDate',
                            'GameDesc',
                            'ID_GAMETYPE',
                            'GameType',
                            'ID_COMPANY',
                            'CompanyName',
                         );
}
?>