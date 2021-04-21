<?php
Doo::loadCore('db/DooSmartModel');

class FmTopics extends DooSmartModel{

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
    public $ID_TOPIC;

    /**
     * @var tinyint Max length is 1.  unsigned.
     */
    public $isSticky;

    /**
     * @var smallint Max length is 5.  unsigned.
     */
    public $ID_BOARD;

    /**
     * @var int Max length is 10.  unsigned.
     */
    public $ID_FIRST_MSG;

    /**
     * @var int Max length is 10.  unsigned.
     */
    public $ID_LAST_MSG;

    /**
     * @var mediumint Max length is 8.  unsigned.
     */
    public $ID_PLAYER_STARTED;

    /**
     * @var mediumint Max length is 8.  unsigned.
     */
    public $ID_PLAYER_UPDATED;

    /**
     * @var mediumint Max length is 8.  unsigned.
     */
    public $ID_POLL;


	public $TopicName;
    /**
     * @var int Max length is 10.  unsigned.
     */
    public $ReplyCount;

    /**
     * @var int Max length is 10.  unsigned.
     */
    public $ViewCount;

    /**
     * @var tinyint Max length is 1.  unsigned.
     */
    public $isLocked;
	private $URL;

    public $_table = 'fm_topics';
    public $_primarykey = 'ID_TOPIC';
    public $_fields = array('ID_OWNER','OwnerType','ID_TOPIC','isSticky','ID_BOARD','ID_FIRST_MSG','ID_LAST_MSG','ID_PLAYER_STARTED','ID_PLAYER_UPDATED','ID_POLL','ReplyCount','ViewCount','isLocked','TopicName');

	
	
	public function __get($attr) {

        switch ($attr) {
        	case 'URL':
				$this->$attr = Url::getUrl($this, "URL");
        		break;
        }
        return $this->$attr;
    }

	public function getTopicName(){
		$params['select'] = 'Subject';
		$params['where'] = "ID_MSG = {$this->ID_FIRST_MSG}";
		$params['limit'] = 1;
		
		$topic = Doo::db()->find('FmMessages', $params);
		
		return $topic->Subject;
	}
	
	public function getTopicStarter(){
		return User::getById($this->ID_PLAYER_STARTED);
	}
}
?>