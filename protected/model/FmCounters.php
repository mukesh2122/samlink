<?php
Doo::loadCore('db/DooSmartModel');

class FmCounters extends DooSmartModel{

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
    public $NextCat;

    /**
     * @var mediumint Max length is 8.  unsigned.
     */
    public $NextBoard;

    /**
     * @var mediumint Max length is 8.  unsigned.
     */
    public $NextTopic;

    /**
     * @var mediumint Max length is 8.  unsigned.
     */
    public $NextMessage;

    /**
     * @var mediumint Max length is 8.  unsigned.
     */
    public $NextPoll;

    public $_table = 'fm_counters';
    public $_primarykey = 'OwnerType';
    public $_fields = array('ID_OWNER','OwnerType','NextCat','NextBoard','NextTopic','NextMessage','NextPoll');

}
?>