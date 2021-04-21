<?php

Doo::loadCore('db/DooSmartModel');

class SnLevel2Friends extends DooSmartModel {

	public $ID_PLAYER;
	public $ID_LEVEL2FRIEND;
	public $isFriends;
	public $MutualCount;
	public $sameCity;
	public $sameCountry;
	public $CommonGamesPlayedCount;
	public $CommonGamesSubscribedCount;
	public $CommonGroupsCount;
	public $isHidden;
	public $_table = 'sn_level2friends';
	public $_primarykey = '';
	public $_fields = array(
		'ID_PLAYER',
		'ID_LEVEL2FRIEND',
		'isFriends',
		'MutualCount',
		'sameCity',
		'sameCountry',
		'CommonGamesPlayedCount',
		'CommonGamesSubscribedCount',
		'CommonGroupsCount',
		'isHidden',
	);
	
	public function getFields() {
		$fields = array();
		
		foreach($this->_fields as $field) {
			if($field != 'ID_PLAYER') {
				$fields[] = $this->_table.'.'.$field;
			}
		}
		return implode(", ", $fields);
	}

}
?> 