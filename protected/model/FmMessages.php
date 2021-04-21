<?php
Doo::loadCore('db/DooSmartModel');

class FmMessages extends DooSmartModel{

    /**
     * @var mediumint Max length is 8.  unsigned.
     */
    public $ID_OWNER;

    /**
     * @var enum 'company','game','group').
     */
    public $OwnerType;

    /**
     * @var int Max length is 10.  unsigned.
     */
    public $ID_MSG;

    /**
     * @var mediumint Max length is 8.  unsigned.
     */
    public $ID_TOPIC;

    /**
     * @var smallint Max length is 5.  unsigned.
     */
    public $ID_BOARD;

    /**
     * @var int Max length is 10.  unsigned.
     */
    public $PostingTime;

    /**
     * @var mediumint Max length is 8.  unsigned.
     */
    public $ID_PLAYER;

    /**
     * @var int Max length is 10.  unsigned.
     */
    public $ID_MSG_MODIFIED;

    /**
     * @var tinytext
     */
    public $Subject;

    /**
     * @var tinytext
     */
    public $PosterName;

    /**
     * @var tinytext
     */
    public $PosterEMail;

    /**
     * @var tinytext
     */
    public $PosterIP;

    /**
     * @var int Max length is 10.  unsigned.
     */
    public $ModifiedTime;

    /**
     * @var tinytext
     */
    public $ModifiedName;

    /**
     * @var text
     */
    public $Body;

    public $_table = 'fm_messages';
    public $_primarykey = 'ID_MSG';
    public $_fields = array('ID_OWNER','OwnerType','ID_MSG','ID_TOPIC','ID_BOARD','PostingTime','ID_PLAYER','ID_MSG_MODIFIED','Subject','PosterName','PosterEMail','PosterIP','ModifiedTime','ModifiedName','Body');

}
?>