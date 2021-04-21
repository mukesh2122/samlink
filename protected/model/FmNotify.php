<?php
Doo::loadCore('db/DooSmartModel');

class FmNotify extends DooSmartModel{

    /**
     * @var mediumint Max length is 8.  unsigned.
     */
    public $ID_OWNER;

    /**
     * @var enum 'company','game','group').
     */
    public $OwnerType;

    /**
     * @var smallint Max length is 5.  unsigned.
     */
    public $ID_BOARD;

    /**
     * @var mediumint Max length is 8.  unsigned.
     */
    public $ID_TOPIC;

    /**
     * @var mediumint Max length is 8.  unsigned.
     */
    public $ID_PLAYER;

    /**
     * @var tinyint Max length is 1.  unsigned.
     */
    public $Sent;

    public $_table = 'fm_notify';
    public $_primarykey = 'ID_PLAYER';
    public $_fields = array('ID_OWNER','OwnerType','ID_BOARD','ID_TOPIC','ID_PLAYER','Sent');

}
?>