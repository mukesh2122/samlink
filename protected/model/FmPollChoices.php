<?php
Doo::loadCore('db/DooSmartModel');

class FmPollChoices extends DooSmartModel{

    /**
     * @var mediumint Max length is 8.  unsigned.
     */
    public $ID_OWNER;

    /**
     * @var enum 'group','company','game').
     */
    public $OwnerType;

    /**
     * @var mediumint Max length is 8.  unsigned.
     */
    public $ID_POLL;

    /**
     * @var tinyint Max length is 3.  unsigned.
     */
    public $ID_CHOICE;

    /**
     * @var tinytext
     */
    public $Label;

    /**
     * @var smallint Max length is 5.  unsigned.
     */
    public $Votes;

    public $_table = 'fm_poll_choices';
    public $_primarykey = 'ID_CHOICE';
    public $_fields = array('ID_OWNER','OwnerType','ID_POLL','ID_CHOICE','Label','Votes');


}
?>