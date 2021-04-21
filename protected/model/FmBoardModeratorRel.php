<?php
Doo::loadCore('db/DooSmartModel');

class FmBoardModeratorRel extends DooSmartModel{

   
    public $OwnerType;
    public $ID_PLAYER;
    public $ID_BOARD;
	public $ID_OWNER;

   
    public $_table = 'fm_boardmoderator_rel';
    public $_fields = array(
                            'OwnerType',
                            'ID_PLAYER',
                            'ID_BOARD',
                           	'ID_OWNER'
                         );

 


}