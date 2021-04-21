<?php
Doo::loadCore('db/DooSmartModel');

class FmBannedPlayerBoardRel extends DooSmartModel{

    public $ID_PLAYER;
    public $OwnerType;
    public $ID_OWNER;
    public $ID_BOARD;
    public $StartDate;
    public $EndDate;
    public $Unlimited;
    public $isHistory;
    public $PosterIP;

   
    public $_table = 'fm_bannedplayerboard_rel';
   	public $_primarykey = 'ID_SUSPEND';
    public $_fields = array(
                            'ID_PLAYER',
                            'OwnerType',
                           	'ID_OWNER',
                           	'ID_BOARD',
                           	'StartDate',
                           	'EndDate',
                           	'Unlimited',
                           	'isHistory',
                           	'PosterIP',
                         );

 


}