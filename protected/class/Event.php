<?php

class Event {

	public function getIndex($type, $phrase = '', $limit = 0) {
		$modelInfo = $this->getTypeAttr($type);
		$model = $modelInfo['model'];
		$fields = $modelInfo['fields'];

		$params['select'] = $model->_table . "." . $fields['name'] . ", " . $model->_table . "." . $fields['id'] . ", " . $model->_table . ".EventCount, " . $model->_table . ".EventParticipantCount";
		$params['asc'] = $model->_table . "." . $fields['name'];

		if (strlen($phrase) > 2) {
			$params['where'] = $model->_table . "." . $fields['name'] . " LIKE ?";
			$params['param'] = array('%'. $phrase . "%");
		}

		if($limit != 0)
			$params['limit'] = $limit;

		$data['results'] = Doo::db()->find($model, $params);
		$data['fields'] = (Object) $fields;


		return $data;
	}

	public function unparticipate($player, $event){
		$event = intval($event);
		if($player and $event > 0){
			$participants = new EvParticipants();
			$participants->isParticipating = 0;
			$participants->update(array(
				'field' => 'isParticipating',
				'where' => 'ID_PLAYER = ? AND ID_EVENT = ?',
				'param' => array($player->ID_PLAYER, $event)
			));

			return TRUE;
		}
		return FALSE;
	}

	public function removePlayers($event){
		$participants = new EvParticipants();

		$participants->delete(array('where' => 'ID_EVENT = ?', 'param' => array($event->ID_EVENT)));
	}

	public function getList($type, $id, $phrase = '', $listtype, $limit = 0) {
		$event = new EvEvents;

		$modelInfo = $this->getTypeAttr($type);
		$model = $modelInfo['model'];
		$fields = $modelInfo['fields'];


		$params['asc'] = $event->_table . ".EventTime";
		$params['where'] = $event->_table . "." . $fields['id'] . " = ? AND ".$event->_table.".isPublic = 1 ";
		$params['param'] = array($id);
        if($listtype == 'upcoming') {
            $params['where'] .= "AND ".$event->_table.".EventTime > ?" ;
    		$params['param'] = array($id, time());
        }

		if ($phrase) {
			$params['where'] .= ' AND '.$event->_table. ".EventHeadline LIKE ?";
			$params['param'][2] = '%'.$phrase . "%";
		}
		if($limit != 0){
			$params['limit'] = $limit;
		}

		$data = Doo::db()->find('EvEvents', $params);
		return $data;
	}

	public function getListAll($type, $id, $phrase = '', $listtype, $limit = 0) {
		$event = new EvEvents;

		$modelInfo = $this->getTypeAttr($type);
		$model = $modelInfo['model'];
		$fields = $modelInfo['fields'];

		$params['select'] = $event->_table . ".ID_EVENT, " . $event->_table . ".EventTime, " . $event->_table . ".EventHeadline, " . $event->_table . ".ActiveCount";
		$params['asc'] = $event->_table . ".EventTime";
		$params['where'] = $event->_table . "." . $fields['id'] . " = ? ";
		$params['param'] = array($id);
        if($listtype == 'upcoming') {
            $params['where'] .= "AND ".$event->_table.".EventTime > ?" ;
    		$params['param'] = array($id, time());
        }

		if ($phrase) {
			$params['where'] .= ' AND '.$event->_table. ".EventHeadline LIKE ?";
			$params['param'][2] = '%'.$phrase . "%";
		}
		if($limit != 0){
			$params['limit'] = $limit;
		}

		$data = Doo::db()->find('EvEvents', $params);
		return $data;
	}

	public function getAll($phrase = '', $limit = 0, $tab = 1, $order = 'desc', $publicOnly = true) {
		$event = new EvEvents;

		if($tab == 2) {
			$params[$order] = $event->_table . ".ActiveCount";
		} else {
			$params[$order] = $event->_table . ".EventTime";
		}

		if($publicOnly){
			$params['where'] = "{$event->_table}.isPublic = 1" ;
		}

		if (strlen($phrase) > 2) {
			$params['where'] .= ' AND '.$event->_table. ".EventHeadline LIKE ?";
			$params['param'] = array('%'. $phrase . "%");
		}

		$params['limit'] = $limit;

		$data = Doo::db()->find('EvEvents', $params);
		return $data;
	}

	public function getUpcoming($phrase = '', $limit = 0, $tab = 1, $order = 'asc', $publicOnly = true) {
		$event = new EvEvents;

		if($tab == 2) {
			$params[$order] = $event->_table . ".ActiveCount";
		} else {
			$params[$order] = $event->_table . ".EventTime";
		}

		if($publicOnly){
			$params['where'] = $event->_table.".EventTime > ? AND {$event->_table}.isPublic = 1" ;
			$params['param'] = array(time());
		}
		else{
			$params['where'] = $event->_table.".EventTime > ?" ;
			$params['param'] = array(time());
		}

		if (strlen($phrase) > 2) {
			$params['where'] .= ' AND '.$event->_table. ".EventHeadline LIKE ?";
			$params['param'][1] = '%'. $phrase . "%";
		}

		$params['limit'] = $limit;

		$data = Doo::db()->find('EvEvents', $params);
		return $data;
	}

	public function getCurrent($phrase = '', $limit = 0, $tab = 1, $order = 'desc', $publicOnly = true) {
		$event = new EvEvents;

		if($tab == 2) {
			$params[$order] = $event->_table . ".ActiveCount";
		} else {
			$params[$order] = $event->_table . ".EventTime";
		}

		if($publicOnly){
			$params['where'] = $event->_table.".EventTime + EventDuration < ? AND EventTime > ? AND {$event->_table}.isPublic = 1" ;
			$params['param'] = array(time(), time());
		}
		else{
			$params['where'] = $event->_table.".EventTime + EventDuration < ? AND EventTime > ?" ;
			$params['param'] = array(time(), time());
		}

		if (strlen($phrase) > 2) {
			$params['where'] .= ' AND '.$event->_table. ".EventHeadline LIKE ?";
			$params['param'][1] = '%'. $phrase . "%";
		}

		$params['limit'] = $limit;

		$data = Doo::db()->find('EvEvents', $params);
		return $data;
	}

	public function getTypeAttr($type) {
		switch ($type) {
			case 'game':
				$model = new SnGames;
				$fields = array(
					'id' => 'ID_GAME',
					'name' => 'GameName',
				);
				break;

			case 'company':
				$model = new SnCompanies;
				$fields = array(
					'id' => 'ID_COMPANY',
					'name' => 'CompanyName',
				);
				break;

			case 'group':
				$model = new SnGroups;
				$fields = array(
					'id' => 'ID_GROUP',
					'name' => 'GroupName',
				);
				break;

			default:
				$type = 'game';
				$model = new SnGames;
				$fields = array(
					'id' => 'ID_GAME',
					'name' => 'GameName',
				);
				break;
		}

		return array('model' => $model, 'fields' => $fields);
	}

	public function getItemName($type, $id) {
		switch ($type) {
			case 'game':
				$model = new SnGames;
				$fields = array(
					'id' => 'ID_GAME',
					'name' => 'GameName',
				);
				break;

			case 'company':
				$model = new SnCompanies;
				$fields = array(
					'id' => 'ID_COMPANY',
					'name' => 'CompanyName',
				);
				break;

			case 'group':
				$model = new SnGroups;
				$fields = array(
					'id' => 'ID_GROUP',
					'name' => 'GroupName',
				);
				break;
		}

		$params['select'] = $model->_table . "." . $fields['name'];
		$params['limit'] = 1;
		$params['where'] = $model->_table . "." . $fields['id'] . " = ?";
		$params['param'] = array($id);

		$model = Doo::db()->find($model, $params);

		return $model->$fields['name'];
	}

	public function create_event($type, $id, $player, $params, $personal = false) {
		if (is_array($params) and !empty($params)) {
			$event = new EvEvents;
			$event->ID_PLAYER = $player;
			switch ($type) {
				case "game":
					$event->ID_GAME = $id;
					$event->ID_COMPANY = 0;
					$event->ID_GROUP = 0;
					$event->ID_TEAM = 0;
					$url = URL_GAME;
					break;
				case "company":
					$event->ID_GAME = 0;
					$event->ID_COMPANY = $id;
					$event->ID_GROUP = 0;
					$event->ID_TEAM = 0;
					$url = URL_COMPANY;
					break;
				case "group":
					$event->ID_GAME = 0;
					$event->ID_COMPANY = 0;
					$event->ID_GROUP = $id;
					$event->ID_TEAM = 0;
					$url = URL_GROUP;
					break;
				case "team":
					$event->ID_GAME = 0;
					$event->ID_COMPANY = 0;
					$event->ID_GROUP = 0;
					$event->ID_TEAM = $id;
					$url = URL_TEAM;
					break;
				default:
					$event->ID_GAME = 0;
					$event->ID_COMPANY = 0;
					$event->ID_GROUP = 0;
					$event->ID_TEAM = 0;
					break;
			}

			$event->EventHeadline = ContentHelper::handleContentInput($params['title']);
			$event->EventLocation = ContentHelper::handleContentInput($params['location']);
			$event->EventTime = $params['start'];
			$event->EventDuration = $params['end'] - $event->EventTime;
			$event->EventType = $params['type'];
			$event->isPublic = $params['public'];
			$event->LocatTimeOffset = intval($params['timezone']);


			if ($params['recurrance'] === 0 or $params['recurrance'] == '') {
				$event->RecurringEvent = 0;
				$event->RecurrenceInterval = '';
				$event->RecurrenceEndDate = 0;
				$event->RecurrenceCount = 0;
			} else {
				$event->RecurringEvent = 1;
				$event->RecurrenceInterval = $params['recurrance'];

				if(isset($params['repeat']) and $params['repeat'] != 0){
					$event->RecurrenceCount = $params['repeat'];
					$event->RecurrenceEndDate = 0;
				}
				elseif(isset($params['repeatDate']) and $params['repeatDate'] != 0){
					$event->RecurrenceCount = 0;
					$event->RecurrenceEndDate = $params['repeatDate'];
				}
				else{
					$event->RecurrenceCount = 0;
					$event->RecurrenceEndDate = 0;
				}
			}

			$event->InviteLevel = $params['inviteLevel'];
			$event->EventDescription = ContentHelper::handleContentInput($params['description']);

			if($personal){
				$ev = $event->insert();

				if($type == '')
					$this->addToCalendar('personal',$ev,$player,0);

				$result = true;
			}
			else{
				$query = "CALL CreateEvent(?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,@event)";
				$p = array(
					$event->ID_PLAYER,
					$params['invite'],
					$event->ID_COMPANY,
					$event->ID_GAME,
					$event->ID_GROUP,
					$event->ID_TEAM,
					$event->EventType,
					$event->EventTime,
					$event->LocatTimeOffset,
					$event->EventDuration,
					$event->EventHeadline,
					$event->EventDescription,
					$event->EventLocation,
					$event->isPublic,
					$event->InviteLevel,
					$event->RecurringEvent,
					$event->RecurrenceInterval,
					$event->RecurrenceCount,
					$event->RecurrenceEndDate
				);

				$result = Doo::db()->query($query, $p);
				$ev = Doo::db()->query("SELECT @event LIMIT 1");
				$ev = $ev->fetchAll();
			}

			return $result;
		} else {
			return false;
		}
	}

	public function edit_event(EvEvents $event, $params, $personal = false) {
		if (is_array($params) and !empty($params)) {
			$event->EventHeadline = ContentHelper::handleContentInput($params['title']);
			$event->EventTime = $params['start'];

			if(!$personal){
				$event->EventDuration = $params['end'] - $params['start'];
				$event->EventType = $params['type'];
				$event->isPublic = $params['public'];
				$event->InviteLevel = $params['inviteLevel'];
				$event->EventLocation = $params['location'];
				$event->LocalTimeOffset = intval($params['timezone']);
				$event->EventDescription = ContentHelper::handleContentInput($params['description']);

			}
			else{
				$event->EventDescription = ContentHelper::handleContentInput($params['title']);
			}


			if ($params['recurrance'] === 0 or $params['recurrance'] == '') {
				$event->RecurringEvent = 0;
				$event->RecurrenceInterval = '';
				$event->RecurrenceEndDate = 0;
				$event->RecurrenceCount = 0;
			} else {
				$event->RecurringEvent = 1;
				$event->RecurrenceInterval = $params['recurrance'];

				if(isset($params['repeat']) and $params['repeat'] != 0){
					$event->RecurrenceCount = $params['repeat'];
					$event->RecurrenceEndDate = 0;
				}
				elseif(isset($params['repeatDate']) and $params['repeatDate'] != 0){
					$event->RecurrenceCount = 0;
					$event->RecurrenceEndDate = $params['repeatDate'];
				}
				else{
					$event->RecurrenceCount = 0;
					$event->RecurrenceEndDate = 0;
				}
			}

			if($event->RecurringEvent and $personal){
				//DELETE ALL FUTURE since changes should be made to them also
				$this->retireOldEvent($event->ID_EVENT);
				$this->deletePlayersEvent($event->ID_EVENT,$event->EventTime,true);

				//ADD with new options
				$pr['title'] = $event->EventHeadline;
				$pr['description'] = $event->EventHeadline;
				$pr['location'] = '';
				$pr['start'] = $event->EventTime;
				$pr['end'] = $event->EventTime + $event->EventDuration;
				$pr['type'] = 'live';
				$pr['public'] = 0;
				$pr['inviteLevel'] = 'closed';
				$pr['invite'] = '';
				$pr['recurrance'] = $event->RecurrenceInterval;
				$pr['repeat'] = $event->RecurrenceCount;
				$pr['repeatDate'] = $event->RecurrenceEndDate;

				$this->create_event('', 0, $event->ID_PLAYER, $pr, true);
			}
			else{
				$event->update();
			}
			return true;
		} else {
			return false;
		}
	}

	public static function getClosest(){
		$params['where'] = "EventTime > ? AND isPublic = 1 AND ID_GROUP = 0 AND ID_TEAM = 0";
		$params['param'] = array(time());
		$params['asc'] = "EventTime";
		$params['limit'] = 1;

		return Doo::db()->find('EvEvents', $params);
	}

	public static function getEvent($id) {

		if (Doo::conf()->cache_enabled == TRUE) {
			$currentDBconf = Doo::db()->getDefaultDbConfig();
            $cacheKey = md5(CACHE_EVENT."_{$id}_".$currentDBconf[0]."_".$currentDBconf[1]."_".Cache::getVersion(CACHE_EVENT.$id));

            if (Doo::cache('apc')->get($cacheKey)) {
                return Doo::cache('apc')->get($cacheKey);
            }
        }

		$event = new EvEvents;

		$params['where'] = $event->_table . ".ID_EVENT = ?";
		$params['limit'] = 1;
		$params['param'] = array($id);

		$data = Doo::db()->find('EvEvents', $params);

		if (Doo::conf()->cache_enabled == TRUE) {
            Doo::cache('apc')->set($cacheKey, $data, Doo::conf()->EVENT_LIFETIME);
        }

		return $data;
	}

	public function getWall($id) {
		$news = new NwItems();

		$params['select'] = $news->_table.".*";
		$params['where'] = $news->_table.".ID_EVENT = ?";
		$params['param'] = array($id);

		$data = Doo::db()->find('NwItems', $params);

		return $data;
	}

	
	public function getParticipants($id, $limit = 0, $search = '') {
		$participants = new EvParticipants;
		$players = new Players;

		$params['select'] = $participants->_table . ".*, " . $players->_table . ".*";
		$params['filters'][] = array(
			'model' => 'Players',
			'joinType' => 'INNER',
			'where' => $players->_table . ".ID_PLAYER = " . $participants->_table . ".ID_PLAYER",
		);

		$params['where'] = $participants->_table . ".isParticipating = 1 AND " . $participants->_table . ".ID_EVENT = ?".MainHelper::getSuspendQuery("{$players->_table}.ID_PLAYER");

		if($limit != 0){
			$params['limit'] = $limit;
		}
		$params['param'] = array($id);

		if($search != ''){
			$params['where'] .= " AND (".$players->_table.".FirstName LIKE ? OR ".$players->_table.".LastName LIKE ? OR ".$players->_table.".NickName LIKE ? )".MainHelper::getSuspendQuery("{$players->_table}.ID_PLAYER");
			$params['param'] = array_merge($params['param'], array($search.'%', $search.'%', $search.'%'));
		}

		$data = Doo::db()->find('EvParticipants', $params);

		return $data;
	}

	public function getInvited($id, $limit = 0, $search = '') {
		$participants = new EvParticipants;
		$players = new Players;

		$params['select'] = $participants->_table . ".*, " . $players->_table . ".*";
		$params['filters'][] = array(
			'model' => 'Players',
			'joinType' => 'INNER',
			'where' => $players->_table . ".ID_PLAYER = " . $participants->_table . ".ID_PLAYER",
		);
		if($limit != 0){
			$params['limit'] = $limit;
		}

		$params['where'] = $participants->_table . ".isParticipating IS NULL AND " . $participants->_table . ".ID_EVENT = ?";

		$params['param'] = array($id);

		if($search != ''){
			$params['where'] .= " AND (".$players->_table.".FirstName LIKE ? OR ".$players->_table.".LastName LIKE ? OR ".$players->_table.".NickName LIKE ? )";
			$params['param'] = array_merge($params['param'], array($search.'%', $search.'%', $search.'%'));
		}

		$params['where'] .= MainHelper::getSuspendQuery("{$players->_table}.ID_PLAYER");

		$data = Doo::db()->find('EvParticipants', $params);
		return $data;
	}

	public function uploadPhoto($id, $user) {
		$e = Doo::db()->getOne('EvEvents', array(
			'limit' => 1,
			'where' => 'ID_EVENT = ?',
			'param' => array($id)
				));

		if ($e->ID_PLAYER == $user or $e->isAdmin()) {
			$image = new Image();
			$result = $image->uploadImage(FOLDER_EVENTS, $e->ImageURL);
			if ($result['filename'] != '') {
				$e->ImageURL = $result['filename'];
				$e->update(array('field' => 'ImageURL'));
				$e->purgeCache();
				$result['e'] = $e;
			}


			return $result;
		}
	}

	public function search($type, $id, $query) {
		$event = new EvEvents;

		$modelInfo = $this->getTypeAttr($type);
		$model = $modelInfo['model'];
		$fields = $modelInfo['fields'];

		$params['select'] = $event->_table . ".ID_EVENT, " . $event->_table . ".EventTime, " . $event->_table . ".EventHeadline, " . $event->_table . ".ActiveCount";
		$params['asc'] = $event->_table . ".EventTime";
		$params['where'] = $event->_table . "." . $fields['id'] . " = ? AND " . $event->_table . ".EventHeadline LIKE ?";
		$params['param'] = array($id, '%' . ContentHelper::handleContentInput($query) . '%');

		$data = Doo::db()->find('EvEvents', $params);
		return $data;
	}

	public function searchIndex($type, $query) {
		$modelInfo = $this->getTypeAttr($type);
		$model = $modelInfo['model'];
		$fields = $modelInfo['fields'];

		$params['select'] = $model->_table . "." . $fields['name'] . ", " . $model->_table . "." . $fields['id'] . ", " . $model->_table . ".EventCount, " . $model->_table . ".EventParticipantCount";
		$params['asc'] = $model->_table . "." . $fields['name'];

		$params['where'] = $model->_table . "." . $fields['name'] . " LIKE ?";
		$params['param'] = array('%' . ContentHelper::handleContentInput($query) . "%");

		$data['results'] = Doo::db()->find($model, $params);
		$data['fields'] = (Object) $fields;


		return $data;
	}

	/**
     * Returns amount of games/companies/groups
     *
     * @return int
     */
    public function getTotalType($type) {

		$model = $this->getTypeAttr($type);
		$model = $model['model'];
        $totalNum = 0;

        $totalNum = (object) Doo::db()->fetchRow('SELECT COUNT(1) as cnt FROM `' . $model->_table . '` LIMIT 1');

        return $totalNum->cnt;
    }


	/**
     * Returns amount of events
     *
     * @return int
     */
    public function getTotalEvents($type, $id) {
		$model = $this->getTypeAttr($type);
		$fields= $model['fields'];
		$model = $model['model'];
        $totalNum = 0;

		$event = new EvEvents();

		$totalNum = (object) Doo::db()->fetchRow('SELECT COUNT(1) as cnt FROM `' . $event->_table .
				'` WHERE `'.$fields['id'].'` = ? AND isPublic = 1 AND EventTime > ? LIMIT 1', array($id, time()));

        return $totalNum->cnt;
    }
    public function getTotal($publicOnly = true, $search = '') {
		$event = new EvEvents();

		$where = '';
		$params = array();
		if (strlen($search) > 2) {
			$where .= ' AND '.$event->_table. ".EventHeadline LIKE ?";
			$params[] = '%'. $search . "%";
		}

		if($publicOnly)
			$totalNum = (object) Doo::db()->fetchRow('SELECT COUNT(1) as cnt FROM `' . $event->_table .
					'` WHERE isPublic = 1 '.$where.' LIMIT 1', $params);
		else
			$totalNum = (object) Doo::db()->fetchRow('SELECT COUNT(1) as cnt FROM `' . $event->_table .
					'` WHERE '.$where.' LIMIT 1', $params);
        return $totalNum->cnt;
    }

    public function getTotalCurrent($publicOnly = true, $search = '') {
		$event = new EvEvents();

		$where = '';
		$params = array(time(),time());
		if (strlen($search) > 2) {
			$where .= ' AND '.$event->_table. ".EventHeadline LIKE ?";
			$params[] = '%'. $search . "%";
		}

		if($publicOnly)
			$totalNum = (object) Doo::db()->fetchRow('SELECT COUNT(1) as cnt FROM `' . $event->_table .
					'` WHERE isPublic = 1 AND EventTime + EventDuration < ? AND EventTime > ? '.$where.' LIMIT 1', $params);
		else
			$totalNum = (object) Doo::db()->fetchRow('SELECT COUNT(1) as cnt FROM `' . $event->_table .
					'` WHERE EventTime + EventDuration < ? AND EventTime > ? '.$where.' LIMIT 1', $params);
        return $totalNum->cnt;
    }

	public function getTotalUpcoming($publicOnly = true, $search = '') {
		$event = new EvEvents();

		$where = '';
		$params = array(time());
		if (strlen($search) > 2) {
			$where .= ' AND '.$event->_table. ".EventHeadline LIKE ?";
			$params[] = '%'. $search . "%";
		}

		if($publicOnly)
			$totalNum = (object) Doo::db()->fetchRow('SELECT COUNT(1) as cnt FROM `' . $event->_table .
					'` WHERE isPublic = 1 AND EventTime > ? '.$where.' LIMIT 1', $params);
		else
			$totalNum = (object) Doo::db()->fetchRow('SELECT COUNT(1) as cnt FROM `' . $event->_table .
					'` WHERE EventTime > ? '.$where.' LIMIT 1', $params);
        return $totalNum->cnt;
    }

    public function getTotalEventsAll($type, $id) {
		$model = $this->getTypeAttr($type);
		$fields= $model['fields'];
		$model = $model['model'];
        $totalNum = 0;

		$event = new EvEvents();

		$totalNum = (object) Doo::db()->fetchRow('SELECT COUNT(1) as cnt FROM `' . $event->_table .
					'` WHERE `'.$fields['id'].'` = ? AND EventTime > ? LIMIT 1', array($id, time()));

        return $totalNum->cnt;
    }

	public function getTotalParticipants($id){
		$p = new EvParticipants();

		$totalNum = (object) Doo::db()->fetchRow('SELECT COUNT(1) as cnt FROM `' . $p->_table .
					'` WHERE `ID_EVENT` = ? AND `isParticipating` = 1 LIMIT 1', array($id));
		return $totalNum->cnt;
	}

	public function getTotalInvited($id){
		$p = new EvParticipants();

		$totalNum = (object) Doo::db()->fetchRow('SELECT COUNT(1) as cnt FROM `' . $p->_table .
					'` WHERE `ID_EVENT` = ? AND `isParticipating` IS NULL LIMIT 1', array($id));
		return $totalNum->cnt;
	}

	public function join($id, $player){
		$p = new EvParticipants();

		$p->ID_PLAYER = $player;
		$p->ID_EVENT = $id;
		$p->isParticipating = 1;

		$query = "SELECT COUNT(1) as 'cnt' FROM ".$p->_table." WHERE ID_EVENT = ? AND ID_PLAYER = ? LIMIT 1";

		$result = Doo::db()->fetchRow($query, array($id, $player));
		if($result['cnt'] == 1){
			$p->update(array('where'=> 'ID_EVENT = ? AND ID_PLAYER = ?', 'param' => array($id, $player)));
				return true;
		}
		else{
			$p->insert();
			return true;
		}
	}

	private function updateCacheEvent($type){
		Cache::increase(CACHE_FORUM.$id);
	}

	public function getPlayerEvents(Players $player, $limit = 0, $private = false) {
        $params = array();
		$event = new EvEvents();
		$participant = new EvParticipants();

		if(!$private) {
			$filterWhere = $participant->_table.".ID_PLAYER = ? AND ({$participant->_table}.isParticipating = 1 AND {$event->_table}.isPublic = 1)";
		} else {
			$filterWhere = $participant->_table.".ID_PLAYER = ? AND ({$participant->_table}.isParticipating = 1 OR {$participant->_table}.isParticipating IS NULL)";
		}
		$params['filters'][] = array(
			'model'		=> 'EvParticipants',
			'joinType'	=> 'INNER',
			'where'		=> $filterWhere,
			'param'		=> array($player->ID_PLAYER)
		);
		$params['where'] = $event->_table.".EventTime > ?";
		$params['asc'] = $event->_table.".EventTime";
		$params['param'] = array(time());
		$params['limit'] = $limit;

		$events = Doo::db()->find('EvEvents', $params);

        return $events;
    }

	public function getSearchPlayerEvents($phrase, $player = null, $limit, $private = false){
		if($player == null)
			$player = User::getUser();

		$params = array();
		$event = new EvEvents();
		$participant = new EvParticipants();
		$events = array();

		if (strlen($phrase) > 2 and $player) {
			if(!$private) {
				$filterWhere = $participant->_table.".ID_PLAYER = ? AND ({$participant->_table}.isParticipating = 1 AND {$event->_table}.isPublic = 1)";
			} else {
				$filterWhere = $participant->_table.".ID_PLAYER = ?  AND ({$participant->_table}.isParticipating = 1 OR {$participant->_table}.isParticipating IS NULL)";
			}

			$params['filters'][] = array(
				'model'		=> 'EvParticipants',
				'joinType'	=> 'INNER',
				'where'		=> $filterWhere,
				'param'		=> array($player->ID_PLAYER)
			);
			$params['where'] = $event->_table.".EventTime > ? AND {$event->_table}.EventHeadline LIKE ?";
			$params['asc'] = $event->_table.".EventTime";
			$params['param'] = array(time(), '%'. $phrase . '%');

			$events = Doo::db()->find('EvEvents', $params);
		}

        return $events;
	}

	public function getPlayerEventsCount(Players $player, $private = false, $phrase = ''){
		$event = new EvEvents();
		$participant = new EvParticipants();

		if(!$private) {
			$filterWhere = $participant->_table.".ID_PLAYER = ? AND (".$participant->_table.".isParticipating = 1 AND {$event->_table}.isPublic = 1)";
		} else {
			$filterWhere = $participant->_table.".ID_PLAYER = ?"; //AND (".$participant->_table.".isParticipating IN(0,1) OR ".$participant->_table.".isParticipating IS NULL)
		}
		$params['select'] = "COUNT(1) as cnt";
		$params['filters'][] = array(
			'model' => 'EvParticipants',
			'joinType' => 'INNER',
			'where' => $filterWhere,
			'param' => array($player->ID_PLAYER)
		);
		$params['where'] = $event->_table.".EventTime > ?";
		$params['param'] = array(time());
		$params['limit'] = 1;

		if(strlen($phrase) > 2 ) {
			 $params['where'] .= " AND {$event->_table}.EventHeadline LIKE ?";
			 $params['param'][] = '%'.$phrase.'%';
		}

		$results = Doo::db()->find('EvEvents', $params);

        return $results->cnt;
	}

	public function getInvitees(EvEvents $event) {
		$player = User::getUser();
		$invitees = array();
		if($event and $player) {
			$participants = new EvParticipants();
			$players = new Players();
			$rel = new FriendsRel();
			$params['where'] = "ID_EVENT = ?".MainHelper::getSuspendQuery("ev_participants.ID_PLAYER");
			$params['param'] = array($event->ID_EVENT);
			if($event->isAdmin()) {
				$part = Doo::db()->find('EvParticipants', $params);
				$friends = $player->getFriends();
				//echo var_dump($friends);
				//exit;
				if(!empty($friends)) {
					foreach($friends->list as $f) {
						$fr = (object) $f;
						$add = true;
						foreach($part as $p) { if($p->ID_PLAYER == $fr->ID_PLAYER) { $add = false; }; };
                        if($add) { $invitees[] = $fr; };
					};
				};
			} else {
				if($event->isParticipating() and $event->InviteLevel != 'closed') {
					$part = Doo::db()->find('EvParticipants', $params);
					$friends = $player->getFriends();
					$friends = $friends->list;
					if(!empty($friends)) {
						foreach($friends as $f) {
							$fr = (object) $f;
							$add = true;
							foreach($part as $p) { if($p->ID_PLAYER == $fr->ID_PLAYER) { $add = false; }; };
                            if($add) { $invitees[] = $fr; };
						};
					};
				};
			};
		};
		return $invitees;
	}

	/**
		function getPlayersMonth
	*	@param integer $ID_PLAYER
	*	@param string $date date formated as mm/dd/yyyy
 	*	@return mixed return and array with calendardays objects, seperated by weeks
 	**/
	public function getPlayersMonth($ID_PLAYER,$date){
		try{
			$month =substr($date,0,2);
			$time['dd']=substr($date,3,2);
			$year=substr($date,6,4);
			$currentDay = mktime(0,0,0,$month,$time['dd'],$year);
			$lastDay = mktime(24,0,0,$month,date('t',$currentDay),$year);
			$firstDay = mktime(0,0,0,$month,01,$year);
			$firstDayOffTheWeek = date('w',$firstDay);
			//monday - sunday fix
			if($firstDayOffTheWeek==0){$firstDayOffTheWeek=7;}
			//emptyDays
			$eD = 1;
			$i = 0;
			$m = 0;
			$day = $firstDay;
			$weeks = false;
			$monthEvents = $this->getPlayersMonthEvents($ID_PLAYER,$year,$month);
			while ($day < $lastDay){
				++$i;
				if($firstDayOffTheWeek>$eD){
					//create empty days
					$days[] = new CalendarDay(false);
					++$eD;
				}
				else {
					//fetch day
					++$m;
					//check if day has events
					$checkDay = $this->hasPlayersDayEvents($monthEvents,$year,$month,$m);
					//update now 1 event shorter list
					$monthEvents = $checkDay['list'];
					$days[] = new CalendarDay($day,mktime(0,0,0,date('m'),date('d'),date('Y')),$checkDay['found']);
					//day of month counter
					//add one day
					$dayDiff = mktime(0,0,0,$month,($m+1),$year)-$day;
					$day += $dayDiff;
				}
				if($i==7){
					$weeks[] = $days;
					$days = array();
					$i = 0;
				}
				//week counter
			}
			if(!empty($days)){
				$weeks[] = $days;
			}
			$interval = $this->getInterval($day,'daily');


			if($weeks){
				return $weeks;
			}
			else {
				throw new Exception("Error fetching players month");
			}
		}catch (Exception $e){print_r($e);return false;}
	}
	/**
	function hasPlayersDayEvents
	*	@param array $list
	*	@param integer $year (yyyy)
	*	@param integer $month (mm)
	*	@param integer $day (dd)
 	*	@return mixed returns and array with the new list and boolean for days events
 	**/
	private function hasPlayersDayEvents($list,$year,$month,$day){
		$found = false;
		$dayStart = mktime(0,0,0,$month,$day,$year)-1;
		$dayEnd = mktime(23,59,59,$month,$day,$year);

		foreach($list as &$e){
			if($e->EventTime>$dayStart && $e->EventTime<$dayEnd){
				$found=true;
				unset($e);
				break 1;
			}else if(($e->EventTime+$e->EventDuration) > $dayStart && $e->EventTime < $dayStart){
				$found=true;
				unset($e);
				break 1;
			}

		}
		return array('list'=>$list,'found'=>$found);
	}
	/**
	function getPlayersMonthEvents
	*	@param integer $ID_PLAYER
	*	@param integer $year (yyyy)
	*	@param integer $month (mm)
 	*	@return object
 	**/
	private function getPlayersMonthEvents($ID_PLAYER,$year,$month){
		$monthStart = mktime(0,0,0,$month,01,$year)-1;
		$monthEnd = mktime(23,59,59,$month,date("t",mktime(1,0,0,$year,$month,01)),$year);
		$params['where'] = "ID_PLAYER = ?
							AND ((EventTime > ? AND EventTime < ?)
							OR ((EventTime+EventDuration)>? AND EventTime < ?))";
		$params['param'] = array($ID_PLAYER,$monthStart,$monthEnd,$monthStart,$monthStart);
		$events = Doo::db()->find('EvCalendar',$params);
		return $events;
	}
	/**
	function getPlayersDayEvents
	*	@param integer $ID_PLAYER
	*	@param integer $year (yyyy)
	*	@param integer $month (mm)
	*	@param integer $month (dd)
	*	@param boolean $limit false for many true for one
 	*	@return array (couldnt get this to work with objects)
 	**/
	public function getPlayersDayEvents($ID_PLAYER,$year,$month,$day,$UNIX_TIMESTAMP=false,$ID_EVENT=false){
		$c = new EvCalendar;
		$e = new EvEvents;
		$p = new Players;
		if($ID_EVENT){
			$params["where"] = "{$c->_table}.ID_PLAYER = ?
			AND {$c->_table}.ID_EVENT = ?
			AND {$c->_table}.EventTime = ?";
			$params["param"] = array($ID_PLAYER,$ID_EVENT,$UNIX_TIMESTAMP);
			$params["limit"] = 1;
		}
		else {
			$dayStart = mktime(0,0,0,$month,$day,$year)-1;
			$dayEnd = mktime(23,59,59,$month,$day,$year);
			$params["where"] = "{$c->_table}.ID_PLAYER = ?
					AND (({$c->_table}.EventTime > ? AND {$c->_table}.EventTime < ?)
					OR (({$c->_table}.EventTime+{$c->_table}.EventDuration)>? AND {$c->_table}.EventTime < ?))";
			$params["param"] = array($ID_PLAYER,$dayStart,$dayEnd,$dayStart,$dayStart);
		}
		$params["select"] = "
		{$c->_table}.*,

		{$e->_table}.RecurrenceCount,
		{$e->_table}.RecurringEvent,
		{$e->_table}.RecurrenceEndDate,
		{$e->_table}.RecurrenceInterval,
		{$e->_table}.RecurrenceCount,

		{$p->_table}.*";

		$params["filters"][] = array(
			"model" => 'EvEvents',
			"joinType" => 'INNER'/*,
			"where" => "{$c->_table}.ID_EVENT = {$e->_table}.ID_EVENT"*/);

		$params["filters"][] = array(
			"model" => "Players",
			"joinType" => "INNER"/*,
			"where" => "{$c->_table}.ID_PLAYER = {$p->_table}.ID_PLAYER"*/);
		$events = Doo::db()->find('EvCalendar',$params);
		return $events;
	}
	/**
	function deletePlayersEvent
	*	@param integer $ID_EVENT
	*	@param integer $eventTime
	*	@param boolean $future
	*
 	*	@return void
 	**/
	public function deletePlayersEvent($ID_EVENT,$eventTime,$future=false){
		//FIRST DELETE FROM CALENDAR
		$player = User::getUser();
		$ID_PLAYER = $player->ID_PLAYER;
		if($future==true){
			//DELETE FUTURE CALENDAR NOTES
			$c = new EvCalendar;
			$params['where'] = "ID_EVENT = ? AND ID_PLAYER = ? AND EventTime >= ?";
			$params['param'] = array($ID_EVENT,$ID_PLAYER,$eventTime);
			$c->delete($params);
 		}
		else {
			//Delete calendarnote
			$c = new EvCalendar;
			$params['where'] = "ID_EVENT = ? AND ID_PLAYER = ? AND EventTime = ?";
			$params['param'] = array($ID_EVENT,$ID_PLAYER,$eventTime);
			$c->delete($params);
		}
		$c 				= new EvCalendar;
		$c->ID_EVENT	= $ID_EVENT;
		$c = $c->getOne();

		//if no calendar entrys are left also delete event(only on personal)
		$e 				= new EvEvents;
		$e->ID_EVENT 	= $ID_EVENT;
		$e = $e->getOne();
		//if no calendars entrys are left then DELETE EVENT
		if(empty($c)&&$e->ID_PLAYER==$ID_PLAYER){
			$e->delete();
			//delete participation
			$e 				= new EvParticipants;
			$e->ID_EVENT 	= $ID_EVENT;
			$e->delete();
		}
		else {
			//set participation to off
			if($future){
				$p 					= new EvParticipants;
				$p->isParticipating = 0;
				$params['where'] 	= "ID_EVENT = ? AND ID_PLAYER = ?";
				$params['param']	= array($ID_EVENT,$ID_PLAYER);
				$p->update($params);
			}
		}

	}

	/**
	function retireOldEvent
	* @param integer $ID_EVENT
	* @return void
	**/
	private function retireOldEvent($ID_EVENT){
		//update old event to prevent duplicate repetition on editEvent
		$p 						= new EvEvents;
		$p->RecurringEvent 		= 0;
		$p->RecurrenceInterval 	= '';
		$p->RecurrenceEndDate 	= 0;
		$p->recurrenceCount 	= 0;
		$params['where'] 	= "ID_EVENT = ?";
		$params['param']	= array($ID_EVENT);
		$p->update($params);
	}
	/**
	function fetchAllPlayers
 	*	@return object
 	**/
	private function fetchAllPlayers(){
		try{
			$players = doo::db()->find('Players');
			if($players){
				return $players;
			}else {throw new Exception("Error fetching playerlist");}
		}catch (Exception $e){return false;}

	}
	/**
	function addToCalendar
	*	@param string $type ('live','esport','birthday','personal')
	*	@param integer $ID_EVENT
	*	@param integer $ID_PLAYER
	*	@param integer $ID_FROM
 	*	@return boolean
 	**/
	private function addToCalendar($type,$ID_EVENT,$ID_PLAYER=false,$ID_FROM=0){
		try {
			// get the event
			$e = $this->getEvent($ID_EVENT);
			//determine which users should have the event displayed
			switch ($type){
				case 'esport';
				case 'live';
				/*
				ONLY PERSONAL ARE ADDED THROUGH HERE

					//IF this should be an limited group, such as friends
					//	ID_PLAYER could be used to retrive friend list
					//BUT for now add to all users
					$playerList = $this->fetchAllPlayers();
				break;
				*/
				case 'personal';
				case 'birthday';
					//Just add to the calendar of ID_PLAYER
					$playerList[] = User::getUser();
				break;

				default:
					throw new Exception("Type is invalid(addToCalendar() )");
				break;
			}
			$succes = false;
			//determine recurrence
			if($e->RecurringEvent){
				//first we find recurring type
				$interval = $this->getInterval($e->EventTime,$e->RecurrenceInterval);
				//second we find the enddate, either by manual enddate or by fixed count, or by 2month infident rule
				if($e->RecurrenceEndDate != 0){
					//This is manual enddate
					$RecurrenceEndDate = $e->RecurrenceEndDate;
				}
				else {
					if($e->RecurrenceCount != 0){
						//This is fixed count
						$RecurrenceEndDate = $e->EventTime + ($e->RecurrenceCount*$interval)-$interval;
					}
					else {
						//this is infident
						//needs automated script for more than 2 months
						$RecurrenceEndDate = $e->EventTime;
						if($e->RecurrenceInterval=='weekly'){
							$date = $interval*8;
						}else if($e->RecurrenceInterval=='monthly'){
							$date = $interval;
						}else {
							$date = 0;
						}
						$RecurrenceEndDate += $date;
						$this->createParticipater($ID_EVENT,$ID_PLAYER,1);
					}
				}
				//Then we simply add in a loop:)
				$eventTime = $e->EventTime;
				for($i=$eventTime; $i<=$RecurrenceEndDate; $i=$i+$interval){
					foreach($playerList as $player){
						if(!$this->createCalendarNote($player->ID_PLAYER,$ID_EVENT,$type,$i,$e->EventDuration,$e->EventDescription,$ID_FROM)){
							throw new Exception("Error while creating calendarNote of recurring event - ABORTING");
						}
					}
					$interval = $this->getInterval($i,$e->RecurrenceInterval);
				}

				$succes = true;
			}else {
				//NON recurring event simply add to calendar
				foreach($playerList as $player){
					if(!$this->createCalendarNote($player->ID_PLAYER,$ID_EVENT,$type,$e->EventTime,$e->EventDuration,$e->EventDescription,$ID_FROM)){
						throw new Exception("Error while creating calendarNote of NON recurring event - ABORTING");
					}
				}
				$succes = true;
			}
			if($succes){
				return true;
			}else {return false;}
		}catch (Exception $e){return false;}
	}
	/**
	function getInterval
	*	Find the interval relative to the date.. example.. february have 28 days, january have 31
	* 	@todo make this use mktime instead since this only return result in full days
	*
	*	@param integer $startDate
	*	@param string $recurrenceInterval ('yearly','weekly','monthly')
 	*	@return interger interval in seconds
 	**/
	private function getInterval($startDate,$RecurrenceInterval){
		try {
			$date = new DateTime();
			$date->setTimestamp($startDate);

			switch($RecurrenceInterval){
				case 'yearly':
					$date->add(new DateInterval('P1Y'));
				break;
				case 'monthly':
					$date->add(new DateInterval('P1M'));
				break;
				case 'weekly':
					$date->add(new DateInterval('P1W'));
				break;
				default:
					throw new Exception('$RecurringInterval must be "yearly", "monthly" or "weekly"');
				break;
			}
			$oldDate = new DateTime();
			$oldDate->setTimestamp($startDate);
			$interval = date_diff($oldDate, $date);
			$interval = (60*60*24)*$interval->days;
			return $interval;
		} catch (Exception $e){return false;}
	}

    /**
     * Crop handler
     *
     * @return array
     */
    public function cropPhoto($id, $orientation, $ownertype) {
		$p = User::getUser();
        
        if ($p and $p->canAccess('Add game image')) {

            $SnImages = Doo::db()->getOne('SnImages', array(
            'limit' => 1,
            'where' => 'ID_OWNER = ? AND OwnerType = ? AND Orientation = ?',
            'param' => array($id, $ownertype, $orientation)
            ));

            if(!is_object($SnImages))
            {
                $SnImages = new SnImages();
                $SnImages->ID_OWNER = $id;
                $SnImages->OwnerType = $ownertype;
                $SnImages->Orientation = $orientation;
                $SnImages->insert();
            }
            
            switch ($ownertype) {
                case 'company':
                    $folder = FOLDER_COMPANIES;
                break;
                case 'game':
                    $folder = FOLDER_GAMES;
                break;
                case 'group':
                    $folder = FOLDER_GROUPS;
                break;
                case 'event':
                    $folder = FOLDER_EVENTS;
                break;
                case 'news':
                    $folder = FOLDER_NEWSITEMS;
                break;
                case 'product':
                    $folder = FOLDER_SHOP;
                break;
                default:
                    exit();
                break;
            }

            $Image = new Image();
            if(!isset($_POST)||$_POST == array())
            {
                $result = $Image->uploadImage($folder, $SnImages->ImageUrl);
            }else{
                $result = $Image->cropImage($folder, $SnImages->ImageUrl);
            }

            if ($result['filename'] != '') {
                $SnImages->ImageUrl = ContentHelper::handleContentInput($result['filename']);
                $SnImages->update(array(
                'field' => 'ImageUrl',
                'where' => 'ID_OWNER = ? AND OwnerType = ? AND Orientation = ?',
                'param' => array($id,$ownertype,$orientation)
                ));
                $SnImages->purgeCache();
            }

            $result['c'] = $SnImages;
            return $result;
        }
    }
    

	/**
	function createCalendarNote
	*	@param integer $ID_PLAYER
	*	@param integer $ID_EVENT
	*	@param string $eventType ('esport','live')
	*	@param integer $eventTime
	*	@param integer $eventDuration
	*	@param string $eventText
	*	@param integer $ID_FROM
 	*	@return boolean
 	**/
	private function createCalendarNote($ID_PLAYER,$ID_EVENT,$eventType,$eventTime,$eventDuration,$eventText,$ID_FROM=0){
		try {
			doo::loadModel("EvCalendar");
			$model = new EvCalendar;
			$model->ID_PLAYER 		= $ID_PLAYER;
			$model->ID_EVENT		= $ID_EVENT;
			$model->ID_FROM 		= $ID_FROM;
			$model->EventTime 		= $eventTime;
			$model->EventDuration 	= $eventDuration;
			$model->EventText 		= ContentHelper::handleContentInput($eventText);
			$model->EventType 		= $eventType;

			$result = doo::db()->insert($model);

		//DONE Adding event to to calendar, add parcipetating entry if nedded
			if($eventType=='esport'||$eventType=='live'){
				$this->createParticipater($ID_EVENT,$ID_PLAYER,$eventTime);
			}
			return true;
		} catch (Exception $e){return false;}
	}
	/**
	function createParticipater
	*	@param integer $ID_EVENT
	*	@param integer $ID_PLAYER
	*	@param boolen|NULL $state 1 = participating, 0 = not, NULL = not answered on inivite
 	*	@return boolean
 	**/
	private function createParticipater($ID_EVENT,$ID_PLAYER,$state=NULL){
		try {
			$model = new EvParticipants;
			$model->ID_PLAYER 		= $ID_PLAYER;
			$model->ID_EVENT		= $ID_EVENT;
			$model->isParticipating	= $state;
			$result = doo::db()->insert($model);
			if($result){
				return true;
			}else {throw new Exception("Error adding calendar event to db - Event has been created, but not in calendar");}
		} catch (Exception $e){return false;}
	}
}
?>