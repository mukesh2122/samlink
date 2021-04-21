<?php
Doo::loadCore('db/DooSmartModel');

class SyPlayerBugRel extends DooSmartModel{

    public $ID_PLAYER;
    public $ID_ERROR;

    public $_table = 'sy_playerbug_rel';
    public $_primarykey = '';
    public $_fields = array(
                            'ID_PLAYER',
                            'ID_ERROR',
                         );
}
?>