<?php
Doo::loadCore('db/DooSmartModel');

class FmPollVotes extends DooSmartModel{

    /**
     * @var mediumint Max length is 8.  unsigned.
     */
    public $ID_OWNER;

    /**
     * @var enum 'company','game','group').
     */
    public $OwnerType;

    /**
     * @var mediumint Max length is 8.  unsigned.
     */
    public $ID_POLL;

    /**
     * @var mediumint Max length is 8.  unsigned.
     */
   // public $ID_MEMBER;

    /**
    *@var mediumint Max length is 8.  unsigned.
    */
    public $ID_PLAYER;

    /**
     * @var tinyint Max length is 3.  unsigned.
     */
    public $ID_CHOICE;

    public $_table = 'fm_poll_votes';
    public $_primarykey = 'ID_CHOICE';
    public $_fields = array('ID_OWNER','OwnerType','ID_POLL','ID_PLAYER','ID_CHOICE');

}
?>