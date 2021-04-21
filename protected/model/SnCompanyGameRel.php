<?php
Doo::loadCore('db/DooSmartModel');

class SnCompanyGameRel extends DooSmartModel{

    public $ID_GAME;
    public $ID_COMPANY;
    public $isDeveloper;
    public $isDistributor;

    public $_table = 'sn_companygame_rel';
    public $_primarykey = 'ID_GAME';
    public $_fields = array(
                            'ID_GAME',
                            'ID_COMPANY',
							'isDeveloper',
							'isDistributor'
                         );
}
?>