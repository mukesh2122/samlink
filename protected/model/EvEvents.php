<?php

Doo::loadCore('db/DooSmartModel');

class EvEvents extends DooSmartModel {

	/**
	 * @var mediumint Max length is 8.  unsigned.
	 */
	public $ID_EVENT;

	/**
	 * @var mediumint Max length is 8.  unsigned.
	 */
	public $ID_PLAYER;
	public $ID_GAME;
	public $ID_COMPANY;
	public $ID_GROUP;
	public $ID_TEAM;

	/**
	 * @var enum 'esport','live').
	 */
	public $EventType;

	/**
	 * @var int Max length is 10.  unsigned.
	 */
	public $EventTime;

	/**
	 * @var int Max length is 10.  unsigned.
	 */
	public $EventDuration;

	/**
	 * @var varchar Max length is 144.
	 */
	public $EventHeadline;
	public $EventLocation;
	public $isPublic;
	public $InviteLevel;
	public $ImageURL;
	public $ActiveCount;

	/**
	 * @var text
	 */
	public $EventDescription;

	/**
	 * @var tinyint Max length is 1.  unsigned.
	 */
	public $RecurringEvent;

	/**
	 * @var enum 'weekly','monthly','yearly').
	 */
	public $RecurrenceInterval;

	/**
	 * @var tinyint Max length is 3.  unsigned.
	 */
	public $RecurrenceCount;

	/**
	 * @var int Max length is 10.  unsigned.
	 */
	public $RecurrenceEndDate;
	
	public $isExpired;
	public $LocatTimeOffset;
	
	
	//public $EVENT_URL;
	public $_table = 'ev_events';
	public $_primarykey = 'ID_EVENT';
	public $_fields = array('ID_EVENT', 'ID_PLAYER', 'ID_GAME', 'ID_COMPANY', 'ID_GROUP', 'ID_TEAM', 'EventType', 'EventTime', 'EventDuration', 'EventHeadline', 'EventDescription', 'RecurringEvent', 'RecurrenceInterval', 'RecurrenceCount', 'RecurrenceEndDate', 'EventLocation', 'isPublic', 'InviteLevel', 'ImageURL', 'ActiveCount', 'isExpired', 'LocalTimeOffset');

	public function getVRules() {
		return array(
			'ID_EVENT' => array(
				array('integer'),
				array('min', 0),
				array('maxlength', 8),
				array('optional'),
			),
			'ID_PLAYER' => array(
				array('integer'),
				array('min', 0),
				array('maxlength', 8),
				array('notnull'),
			),
			'EventType' => array(
				array('notnull'),
			),
			'EventTime' => array(
				array('integer'),
				array('min', 0),
				array('maxlength', 10),
				array('notnull'),
			),
			'EventDuration' => array(
				array('integer'),
				array('min', 0),
				array('maxlength', 10),
				array('notnull'),
			),
			'EventHeadline' => array(
				array('maxlength', 144),
				array('notnull'),
			),
			'EventDescription' => array(
				array('notnull'),
			),
			'RecurringEvent' => array(
				array('integer'),
				array('min', 0),
				array('maxlength', 1),
				array('notnull'),
			),
			'RecurrenceInterval' => array(
				array('notnull'),
			),
			'RecurrenceCount' => array(
				array('integer'),
				array('min', 0),
				array('maxlength', 3),
				array('notnull'),
			),
			'RecurrenceEndDate' => array(
				array('integer'),
				array('min', 0),
				array('maxlength', 10),
				array('notnull'),
			)
		);
	}
	
	 public function __get($attr) {
	      switch ($attr) {
            case 'EVENT_URL':
				$this->$attr = Url::getUrl($this, "EVENT_URL");
                break;
        }
        return $this->$attr;
    }
	
	public function isAdmin() {
        $p = User::getUser();
        if($p) {
			if($p->ID_PLAYER == $this->ID_PLAYER or $p->canAccess('Super Admin Interface') === TRUE){
				return true;
			}
        }
        return FALSE;
    }
	
	public function getLocalTime($format = DATE_FULL){
		return date($format, $this->EventTime + intval($this->LocalTimeOffset));
	}
	
	public function getLocalEndTime($format = DATE_FULL){
		return date($format, $this->EventTime + $this->LocalTimeOffset + $this->EventDuration);
	}
	
	public function isInvited(){
		$p = User::getUser();
		if($p){
			$participants = new EvParticipants;
			
			$query = "SELECT COUNT(1) as 'cnt' FROM ".$participants->_table." WHERE ID_EVENT = ? AND ID_PLAYER = ? AND isInvited = 1 AND isParticipating IS NULL LIMIT 1";
			
			$result = Doo::db()->fetchRow($query, array($this->ID_EVENT, $p->ID_PLAYER));
			if($result['cnt'] == 1){
				return true;
			}
			else{
				return false;
			}
		}
	}
	
	public function isParticipating(){
		$p = User::getUser();
		if($p){
			$participants = new EvParticipants;
			
			$query = "SELECT COUNT(1) as 'cnt' FROM ".$participants->_table." WHERE ID_EVENT = ? AND ID_PLAYER = ? AND isParticipating = 1 LIMIT 1";
			
			$result = Doo::db()->fetchRow($query, array($this->ID_EVENT, $p->ID_PLAYER));
			if($result['cnt'] == 1){
				return true;
			}
			else{
				return false;
			}
		}
	}
	
	
	public function isSubscribed(){
		$p = User::getUser();
		if($p){
			$participants = new EvParticipants;
			
			$query = "SELECT COUNT(1) as 'cnt' FROM ".$participants->_table." WHERE ID_EVENT = ? AND ID_PLAYER = ? AND isSubscribed = 1 LIMIT 1";
			
			$result = Doo::db()->fetchRow($query, array($this->ID_EVENT, $p->ID_PLAYER));
			if($result['cnt'] == 1){
				return true;
			}
			else{
				return false;
			}
		}
	}
	
	public function invite($playerId){
		$participants = new EvParticipants;
		
		$participants->ID_EVENT = $this->ID_EVENT;
		$participants->ID_PLAYER = $playerId;
		$participants->isInvited = 1;
		
		$participants->insert();
	}

}
?>