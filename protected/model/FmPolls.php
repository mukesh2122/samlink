<?php
Doo::loadCore('db/DooSmartModel');

class FmPolls extends DooSmartModel{

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
     * @var tinytext
     */
    public $Question;

    /**
     * @var tinyint Max length is 1.
     */
    public $VotingLocked;

    /**
     * @var tinyint Max length is 3.  unsigned.
     */
    public $MaxVotes;

    /**
     * @var int Max length is 10.  unsigned.  
     */
    public $ExpireTime;

    /**
     * @var tinyint Max length is 3.  unsigned.
     */
    public $HideResults;

    /**
     * @var tinyint Max length is 3.  unsigned.
     */
    public $ChangeVote;

    /**
     * @var mediumint Max length is 8.  unsigned.
     */
    public $ID_PLAYER;

    /**
     * @var tinytext
     */
    public $PlayerName;



    public $_table = 'fm_polls';
    public $_primarykey = 'ID_POLL';
    public $_fields = array('ID_OWNER','OwnerType','ID_POLL','Question','VotingLocked','MaxVotes','ExpireTime','HideResults','ChangeVote','ID_PLAYER','PlayerName');


}
?>