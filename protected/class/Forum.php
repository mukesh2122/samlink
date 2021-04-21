<?php
class Forum{

	public function getIndex($type = null, $phrase = '', $limit = null) {
	// this call the model that is used for the case
		switch($type) {
			case 'game':
				$model = new SnGames;
				$fields = array(
					'id' => 'ID_GAME',
					'name' => 'GameName',
					'image' => 'ImageURL',
				);
				break;
			case 'company':
				$model = new SnCompanies;
				$fields = array(
					'id' => 'ID_COMPANY',
					'name' => 'CompanyName',
					'image' => 'ImageURL',
				);
				break;
			case 'group':
				$model = new SnGroups;
				$fields = array(
					'id' => 'ID_GROUP',
					'name' => 'GroupName',
					'image' => 'ImageURL',
				);
                break;
			default:
				$type = 'game';
				$model = new SnGames;
				$fields = array(
					'id' => 'ID_GAME',
					'name' => 'GameName',
					'image' => 'ImageURL',
				);
				break;
		};
		$count = new FmCounters;
		$params['select'] = $model->_table.".".$fields['name'].", ".$model->_table.".".$fields['id'].", ".$model->_table.".".$fields['image'].", ".$count->_table.".TopicCount, ".$count->_table.".PostCount";
		$params['asc'] = $model->_table.".".$fields['name'];
		if(strlen($phrase) > 2) {
			$params['where'] = $model->_table.".".$fields['name']." LIKE ?";
			$params['param'] = array("%".$phrase."%");
		};
		$params['filters'][] = array(
			'model' => 'FmCounters',
			'joinType' => 'INNER',
			'where' => $count->_table.".OwnerType = ?",
			'param' => array($type)
		);
		if($limit != null) { $params['limit'] = $limit; };
		$data['results'] = Doo::db()->find($model, $params);
		$data['fields'] = (Object) $fields;
		return $data;
	}

	/**
     * Returns amount of games/companies/groups
     *
     * @return int
     */
    public function getTotalType($type, $search = '') {
		$model = $this->getTypeAttr($type);
		$fields= $model['fields'];
		$model = $model['model'];
        $totalNum = 0;
        if(strlen($search) > 2) {
            $totalNum = (object) Doo::db()->fetchRow('SELECT COUNT(1) as cnt FROM `' . $model->_table . '` WHERE `'.$fields['name'].'` LIKE ? LIMIT 1', array('%' . $search . '%'));
        } else {
            $totalNum = (object) Doo::db()->fetchRow('SELECT COUNT(1) as cnt FROM `' . $model->_table . '` LIMIT 1');
        };
        return $totalNum->cnt;
    }

	public function getForum($type, $id, $adminPage = FALSE, $search = NULL) {
		if(Doo::conf()->cache_enabled == TRUE) {
            $currentDBconf = Doo::db()->getDefaultDbConfig();
            $cacheKey = md5(CACHE_FORUM."_{$type}_{$id}_".$currentDBconf[0]."_".$currentDBconf[1]."_".Cache::getVersion(CACHE_FORUM.$type.$id));
            if (Doo::cache('apc')->get($cacheKey)) {
                return Doo::cache('apc')->get($cacheKey);
            };
        };
		// BOARD IMAGE FIELD IS MISSING?
		$categories = new FmCategories;
		$boards = new FmBoards;
		$messages = new FmMessages;
		$params['asc'] = $categories->_table.".CatOrder";
		$params['where'] = $categories->_table.".OwnerType = ? AND ".$categories->_table.".ID_OWNER = ?";
		$params['param'] = array($type ,$id);
		$data = Doo::db()->find('FmCategories', $params);
		if(TRUE === $adminPage) {
			foreach($data as $c) {
				$c->boards = $this->getCategoryBoards($type, $id, $c->ID_CAT, $search);
			};
		} else {
			foreach($data as $c) {
				if(!$c->isCollapsed()) {
					$c->boards = $this->getCategoryBoards($type, $id, $c->ID_CAT, $search);
				};
			};
		};
		if(Doo::conf()->cache_enabled == TRUE) {
            Doo::cache('apc')->set($cacheKey, $data, Doo::conf()->FORUM_LIFETIME);
        };
		return $data;
	}

	public function getCategoryBoards($type, $id, $cid, $search = NULL) {
		$boards = new FmBoards;
		$topics = new FmTopics();
//		$messages = new FmMessages;
		$data = array();
/*		$query = "SELECT ".$boards->_table.".* ,
			".$messages->_table.".PosterName, ".$messages->_table.".PostingTime, ".$messages->_table.".Subject, "
			.$messages->_table.".ID_MSG, ".$messages->_table.".ID_TOPIC
			FROM ".$boards->_table."
			LEFT JOIN ".$messages->_table." ON ".$messages->_table.".ID_MSG = ".$boards->_table.".ID_LAST_MSG
			AND ".$messages->_table.".OwnerType = ? AND ".$messages->_table.".ID_OWNER = ? 
			WHERE ".$boards->_table.".OwnerType = ? AND ".$boards->_table.".ID_OWNER = ?
			AND ".$boards->_table.".ID_CAT = ? AND {$boards->_table}.ChildLevel = 0";*/
		/*$params['asc'] = $boards->_table.".BoardOrder";
		$params['where'] = "OwnerType = ? AND ID_OWNER = ? AND ID_CAT = ? AND BoardName LIKE ?";
		$params['param'] = array($type, $id, $cid, '%'.$search.'%');
		$b = Doo::db()->find('FmBoards', $params);*/
		$query = "SELECT ".$boards->_table.".*, ".$topics->_table.".TopicName
		FROM ".$boards->_table."
		RIGHT JOIN ".$topics->_table." ON ".$topics->_table.".ID_BOARD = ".$boards->_table.".ID_BOARD
		WHERE ".$boards->_table.".OwnerType = ?
		AND ".$boards->_table.".ID_OWNER = ?
		AND ".$boards->_table.".ID_CAT = ?
		AND (
		".$boards->_table.".BoardName LIKE ?
		OR ".$topics->_table.".TopicName LIKE ?
		)
		GROUP BY ".$boards->_table.".ID_BOARD
		ORDER BY ".$boards->_table.".BoardOrder ASC";
		$params = array($type, $id, $cid, "%".$search."%", "%".$search."%");
		$b = Doo::db()->query($query, $params);
		$b = $b->fetchAll(PDO::FETCH_CLASS, 'FmBoards');
		foreach($b as $brd) {
			//$brd = (object) $brd;
			$brd->childBoards = array();
			// child boards
			$par['select'] = "ID_BOARD, BoardName";
			$par['where'] = "OwnerType = ? AND ID_OWNER = ? AND ID_PARENT = ?";
			$par['param'] = array($type, $id, $brd->ID_BOARD);
			$chb = Doo::db()->find('FmBoards', $par);
			if(count($chb) > 0) { $brd->childBoards = $chb; };
			$data[] = $brd;
		};
		return $data;
	}

	public function getChildBoards($type, $id, $board) {
		$boards = new FmBoards();
		$messages = new FmMessages;
		$query = "SELECT ".$boards->_table.".*,
			".$messages->_table.".PosterName, ".$messages->_table.".PostingTime, ".$messages->_table.".Subject, "
			.$messages->_table.".ID_MSG, ".$messages->_table.".ID_TOPIC
			FROM ".$boards->_table."
			LEFT JOIN ".$messages->_table." ON ".$messages->_table.".ID_MSG = ".$boards->_table.".ID_LAST_MSG
			AND ".$messages->_table.".OwnerType = ? AND ".$messages->_table.".ID_OWNER = ? 
			WHERE ".$boards->_table.".OwnerType = ? AND ".$boards->_table.".ID_OWNER = ?
			AND {$boards->_table}.ID_PARENT = ?";
		$params = array($type, $id, $type, $id, $board);
		$b = Doo::db()->query($query, $params);
		$data = array();
		if(count($b) > 0) {
			foreach($b as $brd) {
				$brd = (object) $brd;
				$brd->childBoards = array();
				$par['select'] = "ID_BOARD, BoardName";
				$par['where'] = "OwnerType = ? AND ID_OWNER = ? AND ID_PARENT = ?";
				$par['param'] = array($type, $id, $brd->ID_BOARD);
				$chb = Doo::db()->find('FmBoards', $par);
				if(count($chb) > 0) { $brd->childBoards = $chb; };
				$data[] = $brd;
			};
		};
		return $data;
	}

	public function getBoard($type, $id, $board, $sort = 'recently-updated', $search = NULL, $limit = NULL) {
		$topic = new FmTopics();
		$messages = new FmMessages();
		$sortTypes = array(
			'recently-updated' => 'ID_LAST_MSG',
			'start-date' => 'ID_FIRST_MSG',
			'most-replies' => 'ReplyCount',
			'most-viewed' => 'ViewCount'
		);
		$params['select'] = $topic->_table.".*, ".$messages->_table.".*";
		$params['where'] = $topic->_table.".ID_OWNER = ? AND ".$topic->_table.".OwnerType = ? AND ".$topic->_table.".ID_BOARD = ? AND ".$topic->_table.".TopicName LIKE ?";
		$params['param'] = array($id, $type, $board, "%".$search."%");
		$params['filters'][] = array(
			'model' => 'FmMessages',
			'joinType' => 'INNER',
			'where' => $messages->_table.".ID_OWNER = ? AND ".$messages->_table.".OwnerType = ? AND ".$messages->_table.".ID_MSG = ".$topic->_table.".ID_FIRST_MSG",
			'param' => array($id, $type)
		);
		$params['custom'] = "ORDER BY ".$topic->_table.".isSticky = 1 DESC, ".$topic->_table.".".$sortTypes[$sort]." DESC";
		if($limit != null ) { $params['limit'] = $limit; };
		$data = Doo::db()->find('FmTopics', $params);
		foreach($data as $d) {
			$d->lastMessage = $this->getLastMessage($type, $id, $d->ID_TOPIC);
		};
		return $data;
	}

	public static function getBoardIdFromTopicId($ownerID, $ownerType, $topicID) {
		$fmTopic = new FmTopics();
		$fmTopic->ID_OWNER = $ownerID;
		$fmTopic->OwnerType = $ownerType;
		$fmTopic->ID_TOPIC = $topicID;
		$fmTopic = $fmTopic->getOne();
		return $fmTopic->ID_BOARD;
	}

	public function getLastMessage($type, $id, $topic) {
		$messages = new FmMessages;
		$params['select'] = $messages->_table.".PostingTime, ".$messages->_table.".PosterName, ".$messages->_table.".ID_PLAYER ";
		$params['where'] = $messages->_table.".ID_OWNER = ? AND ".$messages->_table.".OwnerType = ? AND ".$messages->_table.".ID_TOPIC = ?";
		$params['param'] = array($id, $type, $topic);
		// $params['desc'] = $messages->_table.".PostingTime";
		$params['limit'] = 1;
		$data = Doo::db()->find('FmMessages', $params);
		return $data;
	}

	public function getCategories($type, $id) {
		$cat = new FmCategories;
		$params['select'] = $cat->_table.".ID_CAT, ".$cat->_table.".CategoryName";
		$params['where'] = $cat->_table.".ID_OWNER = ? AND ".$cat->_table.".OwnerType = ?";
		$params['param'] = array($id, $type);
		$data = Doo::db()->find('FmCategories', $params);
		return $data;
	}

	public function allOnlineUsers(){
		$users = new Players;

		//$params['select'] = $users->_table;
		$params['where'] = $users->_table.".isOnline=1";
		
		$data = Doo::db()->find('Players', $params);
		return $data;
	}

	
	public function getPlayerInfo($id) {
		$player = new Players;
		$params['select'] = $player->_table.".ID_PLAYER, ".$player->_table.".DisplayName";
		$params['where'] = $player->_table.".ID_PLAYER = ?";
		$params['limit'] = 1;
		$params['param'] = array($id);
		$data = Doo::db()->find('Players', $params);
		return $data;
	}
	// returns the whole row from table
	public function getTopicById($type, $id, $topicId) {
		$topic = new FmTopics();
		$params['where'] = "{$topic->_table}.ID_OWNER = ? AND OwnerType = ? AND ID_TOPIC = ?";
		$params['param'] = array($id, $type, $topicId);
		$params['limit'] = 1;
		return Doo::db()->find('FmTopics', $params);
	}
	
	public function getTopic($type, $id, $topicId, $limit = null) {
		$messages = new FmMessages;
		$players = new Players;
		$params = array();
		$params['select'] = $messages->_table.".PostingTime, ".$messages->_table.".Body, ".$messages->_table.".Subject, ".$messages->_table.".ModifiedTime, ".$players->_table.".ID_PLAYER, ".$messages->_table.".PosterName, ".$players->_table.".Avatar, ".$players->_table.".URL, ".$players->_table.".SocialRating";
		$params['Players']['where'] = $messages->_table.".ID_OWNER = ? AND ".$messages->_table.".OwnerType = ? AND ".$messages->_table.".ID_TOPIC = ?";
		$params['Players']['param'] = array($id, $type, $topicId);
		$params['Players']['joinType'] = 'INNER';
		$params['Players']['match'] = true;
		$params['Players']['order'] = $messages->_table.".PostingTime ASC";

		if($limit != null ) {
			$params['Players']['limit'] = $limit;
		};

		$data = Doo::db()->relateMany('FmMessages', array('Players'), $params);

		if(!empty($data)) {
			foreach($data as $d) {
				$d->postCount = $this->getForumPostsCount($id, $type, $d->Players->ID_PLAYER);
			};
		};
		return $data;
	}

	public function getForumPostsCount($id, $type, $player) {
		if (Doo::conf()->cache_enabled == TRUE) {
			$currentDBconf = Doo::db()->getDefaultDbConfig();
			$cacheKey = md5(CACHE_FORUM_PLAYER_POST_COUNT."_{$type}_{$id}_{$player}_".$currentDBconf[0]."_".$currentDBconf[1]."_".Cache::getVersion(CACHE_FORUM_PLAYER_POST_COUNT.$type.$id.'_'.$player));
			if (Doo::cache('apc')->get($cacheKey)) {
				return Doo::cache('apc')->get($cacheKey);
			};
		};
		$messages = new FmMessages;
		$params['select'] = "COUNT(1) as cnt";
		$params['where'] = $messages->_table.".ID_OWNER = ? AND ".$messages->_table.".OwnerType = ? AND ".$messages->_table.".ID_PLAYER = ?";
		$params['param'] = array($id, $type, $player);
		$params['limit'] = 1;
		$data = Doo::db()->find('FmMessages', $params);
		if (Doo::conf()->cache_enabled == TRUE) {
            Doo::cache('apc')->set($cacheKey, $data->cnt, Doo::conf()->FORUM_LIFETIME);
        };
		return $data->cnt;
	}

	public function createCategory($type, $id, $name) {
		$category = new FmCategories();
		$category->CategoryName = ContentHelper::handleContentInput($name);
		$category->OwnerType = $type;
		$category->ID_OWNER = $id;
		$category->CatOrder = $this->getLastCatNumber($type, $id) + 1;
		Doo::db()->insert($category);
		$category = Doo::db()->find($category, array('limit' => 1));
		$this->updateCacheForum($type, $id);
		return $category->ID_CAT;
	}

	public function getLastCatNumber($type, $id) {
		$category = new FmCategories();
		$params['select'] = '`CatOrder`';
		$params['where'] = "`OwnerType` = ? AND `ID_OWNER` = ?";
		$params['desc'] = "`CatOrder`";
		$params['param'] = array($type, $id);
		$params['limit'] = 1;
		$num = Doo::db()->find("FmCategories", $params);
		return $num->CatOrder;
	}

	public function getCatNumber($type, $id, $category) {
		$params['select'] = '`CatOrder`';
		$params['where'] = "`OwnerType` = ? AND `ID_OWNER` = ? AND `ID_CAT` = ?";
		$params['desc'] = "`CatOrder`";
		$params['param'] = array($type, $id, $category);
		$params['limit'] = 1;
		$num = Doo::db()->find("FmCategories", $params);
		if(is_object($num)) { return $num->CatOrder; };
		return 0;
	}

	public function getPrevCat($type, $id, $category) {
		$params['where'] = "`OwnerType` = ? AND `ID_OWNER` = ? AND `CatOrder` < ?";
		$params['desc'] = "`CatOrder`";
		$params['param'] = array($type, $id, $this->getCatNumber($type, $id, $category));
		$params['limit'] = 1;
		$cat = Doo::db()->find("FmCategories", $params);
		return $cat;
	}

	public function getNextCat($type, $id, $category) {
		$params['where'] = "`OwnerType` = ? AND `ID_OWNER` = ? AND `CatOrder` > ?";
		$params['asc'] = "`CatOrder`";
		$params['param'] = array($type, $id, $this->getCatNumber($type, $id, $category));
		$params['limit'] = 1;
		$cat = Doo::db()->find("FmCategories", $params);
		return $cat;
	}

	public function CheckBans($type, $id){
		$bans = new FmBannedPlayerBoardRel;

		$params['where'] = $bans->_table.".ID_OWNER = ? AND ".$bans->_table.".OwnerType = ? ";
		$params['param'] = array($id, $type);
		
		$data = Doo::db()->find('FmBannedPlayerBoardRel', $params);	

		if(!empty($data)){ 
			return true; 	
		}else{ 	
			return false;
		}
	}

	public function allActiveBans($type, $id){
		$bans = new FmBannedPlayerBoardRel;

		$params['where'] = $bans->_table.".OwnerType = ? AND ".$bans->_table.".ID_OWNER = ? AND isHistory = 0" ;
		$params['desc'] = "`ID_SUSPEND`";
		$params['param'] = array($type, $id);	

		$data = Doo::db()->find('FmBannedPlayerBoardRel', $params);

		return $data;

	}

	public function banHistory($type,$id){
		$bans = new FmBannedPlayerBoardRel;

		$params['where'] = $bans->_table.".OwnerType = ? AND ".$bans->_table.".ID_OWNER = ? AND isHistory = 1" ;
		$params['desc'] = "`ID_SUSPEND`";
		$params['param'] = array($type, $id);	

		$data = Doo::db()->find('FmBannedPlayerBoardRel', $params);

		return $data;

	}



	public function forumBan($type, $id, $id_player, $board, $PosterIP, $startDate, $endDate, $unlimited){
		$ban = new FmBannedPlayerBoardRel;

		$ban->OwnerType = $type;
		$ban->ID_OWNER = $id;
		$ban->ID_PLAYER = $id_player;
		$ban->ID_BOARD = $board;
		$ban->StartDate = $startDate;
		$ban->EndDate = $endDate;
		$ban->Unlimited = $unlimited;
		$ban->PosterIP = $PosterIP;

		$ban = Doo::db()->insert($ban);
		$this->updateCacheForum($type, $id);
		 
			
			return TRUE;
		
	}

	public function addBoardModerator($type, $id, $board, $player) {
		 $mod = new FmBoardModeratorRel;  
		 $mod->OwnerType = $type;
		 $mod->ID_OWNER = $id;
		 $mod->ID_BOARD = $board;
		 $mod->ID_PLAYER = $player;
		 $mod = Doo::db()->insert($mod);
		 $this->updateCacheForum($type, $id);
		 return true;
	}

	public function moveBoardOrder($model, $post) {
        if(!empty($post)) {
            $board = new FmBoards();
            $board->ID_OWNER = $model->UNID;
            $board->BoardOrder = ContentHelper::handleContentInput($post['board_order']);
            $board->OwnerType = $post['type'];
            if(isset($post['board_order'])) {
                $board->ID_BOARD = $post['board_id'];
                $catid = $post['cat_id'];
                $q = "UPDATE {$board->_table} SET BoardOrder = ? WHERE ID_CAT = ? AND ID_BOARD = ? AND ID_OWNER = ? AND OwnerType = ?";
                $param = array($board->BoardOrder, $catid, $board->ID_BOARD, $board->ID_OWNER, $board->OwnerType);
                Doo::db()->query($q, $param);
	           	return true;         
            };
        };
    }   

	public function moveCat($model, $post) {
        if(!empty($post)) {
			$cat = new FmCategories();
			$cat->ID_OWNER = $model->UNID;
			$cat->CatOrder = ContentHelper::handleContentInput($post['cat_order']);
			$cat->OwnerType = $post['type'];
			if(isset($post['cat_id'])) {
				$cat->ID_CAT = $post['cat_id'];
				$q = "UPDATE {$cat->_table} SET CatOrder = ? WHERE ID_CAT = ? AND ID_OWNER = ? AND OwnerType = ?";
				$param = array($cat->CatOrder, $cat->ID_CAT, $cat->ID_OWNER, $cat->OwnerType);
				Doo::db()->query($q, $param);
			} else {
				$cat->insert();
			};
            return true;
        };
        return false;
	}

	public function moveCatUp($type, $id, $cat) {
		$prev = $this->getPrevCat($type, $id, $cat);
		if($prev != null) {
			$category = new FmCategories();
			// UPDATE category we're moving
			$query = "UPDATE {$category->_table} SET `CatOrder` = ? WHERE `ID_CAT` = ? AND `ID_OWNER` = ? AND `OwnerType` = ? LIMIT 1";
			$param = array($prev->CatOrder, $cat, $id, $type);
			$results = Doo::db()->query($query, $param);
			// UPDATE category which is being switched
			$query = "UPDATE {$category->_table} SET `CatOrder` = ? WHERE `ID_CAT` = ? AND `ID_OWNER` = ? AND `OwnerType` = ? LIMIT 1";
			$param = array($prev->CatOrder+1, $prev->ID_CAT, $id, $type);
			$results = Doo::db()->query($query, $param);
			// CLEAR cache
			$this->updateCacheForum($type, $id);
			return true;
		};
		return false;
	}

	public function moveCatDown($type, $id, $cat) {
		$next = $this->getNextCat($type, $id, $cat);
		if($next != null) {
			$category = new FmCategories();
			// UPDATE category we're moving
			$query = "UPDATE {$category->_table} SET `CatOrder` = ? WHERE `ID_CAT` = ? AND `ID_OWNER` = ? AND `OwnerType` = ? LIMIT 1";
			$param = array($next->CatOrder, $cat, $id, $type);
			$results = Doo::db()->query($query, $param);
			// UPDATE category which is being switched
			$query = "UPDATE {$category->_table} SET `CatOrder` = ? WHERE `ID_CAT` = ? AND `ID_OWNER` = ? AND `OwnerType` = ? LIMIT 1";
			$param = array($next->CatOrder-1, $next->ID_CAT, $id, $type);
			$results = Doo::db()->query($query, $param);
			$this->updateCacheForum($type, $id);
			return true;
		};
		return false;
	}

	public function createBoard($type, $id, $name, $category) {
		$board = new FmBoards;
		$board->BoardName = ContentHelper::handleContentInput($name);
		$board->ID_CAT = $category;
		$board->OwnerType = $type;
		$board->ID_OWNER = $id;
		$board->insert();
		$this->updateCacheForum($type, $id);
	}

	public function editCategory($type, $id, $name, $categoryId) {
		if ($categoryId > 0) {
			$category = new FmCategories;
			$category->ID_CAT = $categoryId;
			$category->CategoryName = ContentHelper::handleContentInput($name);
			$category->OwnerType = $type;
			$category->ID_OWNER = $id;
			Doo::db()->update($category, array('limit' => 1));
			$this->updateCacheForum($type, $id);
			return true;
		}
		return false;
	}

	public function deleteCategory($type, $id, $categoryId) {
		if ($categoryId > 0) {
			$category = new FmCategories;
			$category->ID_CAT = $categoryId;
			$category->OwnerType = $type;
			$category->ID_OWNER = $id;
			$this->updateCacheForum($type, $id);
			Doo::db()->delete($category, array('limit' => 1));
			return true;
		}
		return false;
	}

	public function editBoard($type, $id, $name, $categoryId, $boardId) {
		if ($boardId > 0) {
			$board = new FmBoards;
			$board->ID_CAT = $categoryId;
			$board->OwnerType = $type;
			$board->BoardName = ContentHelper::handleContentInput($name);
			$board->ID_OWNER = $id;
			$board->ID_BOARD = $boardId;
			Doo::db()->update($board, array('limit' => 1));
			$this->updateCacheForum($type, $id);
			return true;
		}
		return false;
	}

	public function deleteBoard($type, $id, $boardId) {
		if ($boardId > 0) {
			$board = new FmBoards;
			$board->OwnerType = $type;
			$board->ID_OWNER = $id;
			$board->ID_BOARD = $boardId;
			$this->updateCacheForum($type, $id);
			Doo::db()->delete($board, array('limit' => 1));
			return true;
		}
		return false;
	}

	// both reply and first msg in thread - 
	public function deleteMessage($type, $id, $board, $messageId, $playerId = null) {
		if ($messageId > 0) {
			$message = new FmMessages;
			$message->OwnerType = $type;
			$message->ID_OWNER = $id;
			$message->ID_BOARD = $board;
			$message->ID_MSG = $messageId;
			
			if($playerId != null) {
				$message->ID_PLAYER = $playerId;
				$this->updateCachePlayerPostCount($id, $type, $playerId);
			};
			
			Doo::db()->delete($message, array('limit' => 1));
			return true;
		}
		return false;
	}

	//new
	public function deleteTopic($type, $id, $board, $topic, $playerId = null) {
		if ($topic > 0) {
			$message = new FmTopics;
			$message->OwnerType = $type;
			$message->ID_OWNER = $id;
			$message->ID_BOARD = $board;
			$message->ID_TOPIC = $topic;
			if($playerId != null) {
				$message->ID_PLAYER = $playerId;
				$this->updateCachePlayerPostCount($id, $type, $playerId);
			}
	
			Doo::db()->delete($message, array('limit' => 1));
			return true;
		}
		return false;
	}

	// ok
	public function getPlayerIDfromMsgID($id, $type, $board, $topic, $msgid) {
		$message = new FmMessages;
		//$params['select'] = $message->_table.".ID_PLAYER";
		$params['where'] = $message->_table.".ID_OWNER = ? AND ".$message->_table.".OwnerType = ? AND ".$message->_table.".ID_BOARD = ? 
		AND ".$message->_table.".ID_TOPIC = ? AND ".$message->_table.".ID_MSG = ? ";		
		$params['param']  = array($id, $type, $board, $topic, $msgid);

		$data = (object) Doo::db()->getOne('FmMessages', $params);
		return $data->ID_PLAYER;
	}

	public function getMessage($id, $type, $board, $topic, $msgid) {
		$message = new FmMessages;
		$params['where'] = $message->_table.".ID_OWNER = ? AND ".$message->_table.".OwnerType = ? AND ".$message->_table.".ID_BOARD = ? AND ".$message->_table.".ID_TOPIC = ? AND ".$message->_table.".ID_MSG = ? ";		
		$params['param'] = array($id, $type, $board, $topic, $msgid);
		$data = Doo::db()->getOne('FmMessages', $params);
		return $data;
	}

	//ok
 	public function editTopicSubject($type, $id, $board, $topicId, $subject) {
 		$topic = new FmTopics();
 		$table = $topic->_table;
		//$topic->TopicName =ContentHelper::handleContentInput('topicSubject');
		$opts = array(
			'limit' => 1,
			'param' => array($type, $id, $board, $topicId),
			'where' => "{$table}.OwnerType = ? AND {$table}.ID_OWNER = ? AND {$table}.ID_BOARD = ? AND {$table}.ID_TOPIC = ?"
		);
		
		$result = $topic->updateAttributes(array('TopicName' => $subject), $opts);
		
		$param = array( $topic->TopicName, $topic->ID_OWNER, $topic->OwnerType, $topic->ID_BOARD, $topic->ID_TOPIC);

    	return $result;
	}

	// ok
	public function editSubject ($type, $id, $board, $topic, $msgId, $subject, $modifiedName, $playerId = null) {
		$message = new FmMessages;
		$message->Subject = ContentHelper::handleContentInput($subject);
		$message->ModifiedName = $modifiedName;
		$message->OwnerType = $type;
		$message->ID_OWNER = $id;
		$message->ID_BOARD = $board;
		$message->ID_TOPIC = $topic;
		$message->ID_MSG = $msgId;

        $q = "UPDATE {$message->_table} SET Subject = ?  WHERE  ID_OWNER = ? AND OwnerType = ?  AND ID_BOARD = ? AND ID_TOPIC = ? AND ID_MSG = ?";
        $param = array( $message->Subject, $message->ID_OWNER, $message->OwnerType, $message->ID_BOARD, $message->ID_TOPIC, $message->ID_MSG );

        return Doo::db()->query($q, $param);
	}
	//ok ok for body
	public function editMessage ($type, $id, $board, $topic, $msgId, $body, $modifiedName, $playerId = null) {
		$message = new FmMessages;
		$message->Body = ContentHelper::handleContentInput($body);

		$message->ModifiedName = $modifiedName;

		$message->OwnerType = $type;
		$message->ID_OWNER = $id;
		$message->ID_BOARD = $board;
		$message->ID_TOPIC = $topic;
		$message->ID_MSG = $msgId;		
        $q = "UPDATE {$message->_table} SET Body = ?  WHERE  ID_OWNER = ? AND OwnerType = ?  AND ID_BOARD = ? AND ID_TOPIC = ? AND ID_MSG = ?";
        $param = array( $message->Body, $message->ID_OWNER, $message->OwnerType, $message->ID_BOARD, $message->ID_TOPIC, $message->ID_MSG );

        return Doo::db()->query($q, $param);
	}

	// when a subject is edited in the first msg - this updates the all others msg subject in a topic.
	public function UpdateAllOtherMessagesSubject($type, $id, $board, $topic, $firstmsg, $subject){
		$message = new FmMessages;
		
		$message->Subject = ContentHelper::handleContentInput($subject);
		$message->OwnerType = $type;
		$message->ID_OWNER = $id;
		$message->ID_BOARD = $board;
		$message->ID_TOPIC = $topic;
		
        $q = "UPDATE {$message->_table} SET Subject = ?  WHERE  ID_OWNER = ? AND OwnerType = ?  AND ID_BOARD = ? AND ID_TOPIC = ? AND ID_MSG != ?";
        $param = array( 'Re:'.$message->Subject, $message->ID_OWNER, $message->OwnerType, $message->ID_BOARD, $message->ID_TOPIC, $firstmsg );

        return Doo::db()->query($q, $param);

	}

	//ok
	public function createTopic($type, $id, $boardId, $topicName, $playerId, $messageText) {
		$message = new FmMessages;
		$message->ID_BOARD = $boardId;
		$message->ID_OWNER = $id;
		$message->ID_PLAYER = $playerId;
		$message->ID_TOPIC = 0;
		$message->OwnerType = $type;
		$message->Body = ContentHelper::handleContentInputWysiwyg($messageText);
		$message->Subject = ContentHelper::handleContentInput($topicName);
		$message = Doo::db()->insert($message);

		//echo var_dump($message); exit;
	}
	//ok
	public function createPoll( $type, $id, $poll_id, $PLAYER_ID, $DisplayName, $enddate, $hour, $topicName) {
		$polls = new FmPolls;
		$polls->ownerType = $type;
		$polls->ID_OWNER = $id; 
		$polls->ID_POLL = $poll_id;
		$polls->ID_PLAYER 	= $PLAYER_ID;
		$polls->PlayerName	= $DisplayName;
		$date = ContentHelper:: handleContentInput($enddate); 
		$time = ContentHelper:: handleContentInput($hour);
		$ndate = explode("-", $date);
		$ntime = explode(":", $time);
		$timestamp =  mktime($ntime[0],$ntime[1],'00',$ndate[1],$ndate[2],$ndate[0]);
		$polls->ExpireTime = $timestamp;
		$polls->Question = ContentHelper::handleContentInputWysiwyg($topicName);
		$polls->MaxVotes = 1;
		$polls = Doo::db()->insert($polls);
	}

	public function updateExpiretime( $type, $id, $poll_id, $enddate, $hour) {
		$polls = new FmPolls;
		$polls->OwnerType = $type;
		$polls->ID_OWNER = $id; 
		$polls->ID_POLL = $poll_id;
		$ndate = explode("-", $enddate);
		$ntime = explode(":", $hour);
		$timestamp =  mktime($ntime[0],$ntime[1],'00',$ndate[1],$ndate[2],$ndate[0]);
		$polls->ExpireTime = $timestamp; 
		$q = "UPDATE {$polls->_table} SET ExpireTime = ?  WHERE  ID_OWNER = ? AND OwnerType = ?  AND ID_POLL = ?";
		$param = array( $polls->ExpireTime, $polls->ID_OWNER, $polls->OwnerType, $polls->ID_POLL);

        Doo::db()->query($q, $param);
	}

	public function updateQuestion( $type, $id, $poll_id, $subject) {
		$polls = new FmPolls;
		$polls->OwnerType = $type;
		$polls->ID_OWNER = $id; 
		$polls->ID_POLL = $poll_id;
		$polls->Question = ContentHelper::handleContentInputWysiwyg($subject);  

		$q = "UPDATE {$polls->_table} SET Question = ?  WHERE  ID_OWNER = ? AND OwnerType = ?  AND ID_POLL = ?";
		$param = array( $polls->Question, $polls->ID_OWNER, $polls->OwnerType, $polls->ID_POLL);
        Doo::db()->query($q, $param);
	}
	//ok
	public function createChoices($type, $id, $poll_id, $choice_id, $choice) {
		$C = new FmPollChoices;
		$C->OwnerType = $type;
		$C->ID_OWNER  = $id;
		$C->ID_POLL   = $poll_id;
		$C->ID_CHOICE = $choice_id;
		$C->Label 	  = $choice;  
		$C = Doo::db()->insert($C);

	}

	public function updatePollChoices($type, $id, $poll_id, $choice_id, $choice) {
		$C = new FmPollChoices;
		$C->OwnerType = $type;
		$C->ID_OWNER  = $id;
		$C->ID_POLL   = $poll_id;
		$C->ID_CHOICE = $choice_id;
		$C->Label 	  = $choice;  
		$q = "UPDATE {$C->_table} SET Label = ?  WHERE  ID_CHOICE = ? AND ID_OWNER = ? AND OwnerType = ?  AND ID_POLL = ?";
		$param = array( $C->Label, $C->ID_CHOICE, $C->ID_OWNER , $C->OwnerType, $C->ID_POLL );
		 Doo::db()->query($q, $param);
	}
	//ok
	public function getPlayersVotes($type ,$id, $poll_id, $playerid ) {
		$vote = new  FmPollVotes;
		$params['where'] = $vote->_table.".OwnerType = ? AND ".$vote->_table.".ID_OWNER = ? AND ".$vote->_table.".ID_POLL = ? AND ".$vote->_table.".ID_PLAYER = ?";
		$params['param'] = array($type, $id, $poll_id, $playerid);
		$data = Doo::db()->getOne('FmPollVotes', $params);
		if($data != null ) {
			return $data->ID_CHOICE;
		} else {
			return false;
		};
	}
	//ok
	public function deleteVote($type ,$id, $poll_id, $playerid ) {
		$vote = new  FmPollVotes;
		$vote->OwnerType = $type;
		$vote->ID_OWNER = $id;
		$vote->ID_POLL = $poll_id;
		$vote->ID_PLAYER = $playerid;
		Doo::db()->delete($vote, array('limit' => 1));
		return true;
	}
	//ok
	public function checkIfVoted($type ,$id, $poll_id, $playerid ) {
		$vote = new  FmPollVotes;
		$params['where'] = $vote->_table.".OwnerType = ? AND ".$vote->_table.".ID_OWNER = ? AND ".$vote->_table.".ID_POLL = ? AND ".$vote->_table.".ID_PLAYER = ?";
		$params['param'] = array($type, $id, $poll_id, $playerid);
		$data = Doo::db()->getOne('FmPollVotes', $params);
		if($data != null ) {
			return true;
		} else {
			return false;
		};
	}
	//ok
	public function castVote($type ,$id, $poll, $playerid, $PollChoice) {
		$vote = new  FmPollVotes;
		$vote->OwnerType  = $type;
		$vote->ID_OWNER = $id;
		$vote->ID_POLL = $poll;
		$vote->ID_PLAYER  = $playerid;
		$vote->ID_CHOICE = $PollChoice;
		$vote = Doo::db()->insert($vote);
	}
	//ok
	public function getCurrentVotes($type, $id, $poll_id, $choice_id) {
		$C = new FmPollChoices;
		$params['where'] = $C->_table.".OwnerType = ? AND ".$C->_table.".ID_OWNER = ? AND ".$C->_table.".ID_POLL = ? AND ".$C->_table.".ID_CHOICE = ?";
		$params['param'] = array($type, $id, $poll_id, $choice_id);
		$data = Doo::db()->getOne('FmPollChoices', $params);
		return $data->Votes;
	}
	//ok
	public function getPollbase($type, $id, $poll_id ) {
		$C = new FmPolls;
		$params['where'] = $C->_table.".OwnerType = ? AND ".$C->_table.".ID_OWNER = ? AND ".$C->_table.".ID_POLL = ?";
		$params['param'] = array($type, $id, $poll_id);
		$data = Doo::db()->getOne('FmPolls', $params);
		return $data;
	}
	//ok
	public function deletePollbase($type, $id, $poll_id) {
		if ($poll_id > 0) {
			$C = new FmPolls;
			$C->OwnerType = $type;
			$C->ID_OWNER = $id;
			$C->ID_POLL = $poll_id;
			Doo::db()->delete($C, array());
			return true;
		}
		return false;
	}
	//ok
	public function getPollChoices($type, $id, $poll_id) {
		$C = new FmPollChoices;
		$params['where'] = $C->_table.".ownerType = ? AND ".$C->_table.".ID_OWNER = ? AND ".$C->_table.".ID_POLL = ?";
		$params['param'] = array($type, $id , $poll_id);
		$C = Doo:: db()->find('FmPollChoices', $params);
		return $C;
	}

	public function deletePollChoice($type, $id, $poll_id, $choice_id) {
		if ($poll_id > 0) {
			$C = new FmPollChoices;
			$C->OwnerType = $type;
			$C->ID_OWNER = $id;
			$C->ID_POLL = $poll_id;
			$C->ID_CHOICE = $choice_id;
			Doo:: db()->delete($C,array('limit'=> 1));
			return true;
		}
		return false;
	}

	public function deleteChoiceVotes($type ,$id, $poll_id, $choice_id ) {
		if ($poll_id > 0) {
			$vote = new  FmPollVotes;
			$vote->OwnerType = $type;
			$vote->ID_OWNER = $id;
			$vote->ID_POLL = $poll_id;
			$vote->ID_CHOICE = $choice_id;
			Doo::db()->delete($vote, array());
			return true;
		}
		return false;
	}

	// should be done by triggers in database ? 
		public function removeVote($type, $id, $poll_id, $choice_id, $curVotes) {
			$C = new FmPollChoices;
			$newVotes = $curVotes-1;
			$query = "UPDATE ".$C->_table." SET ".$C->_table.".Votes = ?
				WHERE ".$C->_table.".OwnerType = ? AND ".$C->_table.".ID_OWNER = ? AND ".$C->_table.".ID_POLL = ? AND ".$C->_table.".ID_CHOICE =?";
			Doo::db()->query($query, array($newVotes, $type, $id, $poll_id, $choice_id));
		}
		
		public function addVote($type, $id, $poll_id, $choice_id, $curVotes) {
			$C = new FmPollChoices;
			$newVotes = $curVotes+1;
			$query = "UPDATE ".$C->_table." SET ".$C->_table.".Votes = ?
				WHERE ".$C->_table.".OwnerType = ? AND ".$C->_table.".ID_OWNER = ? AND ".$C->_table.".ID_POLL = ? AND ".$C->_table.".ID_CHOICE =?";
			Doo::db()->query($query, array($newVotes, $type, $id, $poll_id, $choice_id));

			return true;
		}

		public function updateTopicsPollid( $type, $id, $topic_id, $poll_id) {
			$topic = new FmTopics;
			$query = "UPDATE ".$topic->_table." SET ".$topic->_table.".ID_POLL = ?
				WHERE ".$topic->_table.".ID_OWNER = ? AND ".$topic->_table.".OwnerType = ? AND ".$topic->_table.".ID_TOPIC = ?";
			Doo::db()->query($query, array($poll_id, $id, $type, $topic_id));
		}
		 // update FmCounter  on field NextPoll
		public function updateCounter($type, $id, $poll_id) {
			$counter = new FmCounters;
			$newpollID = $poll_id+1;
			$query = "UPDATE ".$counter->_table." SET ".$counter->_table.".NextPoll = ?
				WHERE ".$counter->_table.".ID_OWNER = ? AND ".$counter->_table.".OwnerType = ? ";
			Doo::db()->query($query, array($newpollID, $id, $type));
		}

		public function GetCounters($type, $id) {
			$Counter = new FmCounters;
			$params['where'] = $Counter->_table.".ID_owner = ? AND ".$Counter->_table.".OwnerType = ?";
			$params['param'] = array($id, $type);
			$data = Doo::db()->getOne('FmCounters', $params);
			return $data;
		}

	public function reply($type, $id, $board, $topic, $subject, $player, $text) {
		$message = new FmMessages;
		$message->ID_BOARD = $board;
		$message->ID_OWNER = $id;
		$message->ID_TOPIC = $topic;
		$message->Subject = ContentHelper::handleContentInput($subject);
		$message->OwnerType = $type;
		$message->Body = ContentHelper::handleContentInputWysiwyg($text);
		$message->ID_PLAYER = $player;

		$message = Doo::db()->insert($message);
	}

	public static function getBoardInfo($type, $id, $boardId) {
		$board = new FmBoards;

		$params['where'] = $board->_table.".ID_BOARD = ? AND ".$board->_table.".ID_OWNER = ? AND ".$board->_table.".OwnerType = ?";
		$params['limit'] = 1;
		$params['param'] = array($boardId, $id, $type);

		return Doo::db()->find('FmBoards', $params);
	}

	public function getItemName($type, $id) {
		switch($type) {
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
		};

		$params['select'] = $model->_table.".".$fields['name'];
		$params['limit'] = 1;
		$params['where'] = $model->_table.".".$fields['id']." = ?";
		$params['param'] = array($id);

		$model = Doo::db()->find($model, $params);

		return $model->$fields['name'];
	}

	// should be deleted 
	public function checkIfAdmin($user, $page, $pr) {
        if(!$user) { return FALSE; };
		switch($pr['type']) {
			case 'game':
				$model = new SnPlayerGameRel;
				$fields = array(
					'id' => 'ID_GAME',
				);
                break;
			case 'company':
				$model = new SnPlayerCompanyRel;
				$fields = array(
					'id' => 'ID_COMPANY',
				);
                break;
			case 'group':
				$model = new SnPlayerGroupRel;
				$fields = array(
					'id' => 'ID_GROUP',
				);
                break;
			default:
				$type = 'game';
				$model = new SnPlayerGameRel;
				$fields = array(
					'id' => 'ID_GAME',
				);
                break;
		};

		$params['select'] = $model->_table.".isAdmin, ".$model->_table.".isEditor, ".$model->_table.".isForumAdmin, ".$model->_table.".isForumModerator";
		$params['where'] = $model->_table.".".$fields['id']." = ? AND ".$model->_table.".ID_PLAYER = ?";
		$params['param'] = array($pr['id'], $user->ID_PLAYER);
		$params['limit'] = 1;

		$data = Doo::db()->find($model, $params);
		if(($data != null and ($data->isAdmin == 1 or $data->isForumAdmin == 1 or $data->isForumModerator == 1)) or $user->canAccess('Super Admin Interface') === TRUE){
			return true;
		} else {
			return false;
		};
	}
	//
	public function getTotalTopics($type, $id, $board) {
		$topic = new FmTopics;
		$params['select'] = "COUNT(1) as cnt";
		$params['where'] = $topic->_table.".ID_OWNER = ? AND ".$topic->_table.".OwnerType = ? AND ".$topic->_table.".ID_BOARD = ?";
		$params['param'] = array($id, $type, $board);
		$params['limit'] = 1;

		$data = Doo::db()->find('FmTopics', $params);

		return $data->cnt;
	}

	public function getTotalMessages($type, $id, $topic) {
		$message = new FmMessages;
		$params['select'] = "COUNT(1) as cnt";
		$params['where'] = $message->_table.".ID_OWNER = ? AND ".$message->_table.".OwnerType = ? AND ".$message->_table.".ID_TOPIC = ?";
		$params['param'] = array($id, $type, $topic);
		$params['limit'] = 1;

		$data = Doo::db()->find('FmMessages', $params);

		return $data->cnt;
	}

	public function addViewCount($type, $id, $topicId) {
		$topic = new FmTopics;
		$query = "UPDATE ".$topic->_table." SET ".$topic->_table.".ViewCount = ".$topic->_table.".ViewCount+1
			WHERE ".$topic->_table.".ID_OWNER = ? AND ".$topic->_table.".OwnerType = ? AND ".$topic->_table.".ID_TOPIC = ?";
		Doo::db()->query($query, array($id, $type, $topicId));
	}

	public function searchIndex($type, $query) {
		$count = new FmCounters;
		$modelInfo = $this->getTypeAttr($type);
		$model = $modelInfo['model'];
		$fields = $modelInfo['fields'];

		$params['select'] = $model->_table.".".$fields['name'].", ".$model->_table.".".$fields['id'].", ".$count->_table.".TopicCount, ".$count->_table.".PostCount";
		$params['asc'] = $model->_table.".".$fields['name'];
		$params['filters'][] = array(
			'model' => 'FmCounters',
			'joinType' => 'INNER',
			'where' => $count->_table.".OwnerType = ?",
			'param' => array($type)
		);
		$params['where'] = $model->_table.".".$fields['name']." LIKE ?";
		$params['param'] = array('%'.$query.'%');

		$data['results'] = Doo::db()->find($model, $params);
		$data['fields'] = (Object) $fields;

		return $data;
	}

	public function search($type, $id, $query) {
		$topic = new FmTopics;
		$messages = new FmMessages;

		$params['select'] = $topic->_table.".ID_TOPIC, ".$topic->_table.".ID_OWNER, ".$topic->_table.".ID_BOARD, "
				.$messages->_table.".Subject, ".$topic->_table.".ReplyCount, ".$topic->_table.".ViewCount";
		$params['where'] = $topic->_table.".ID_OWNER = ? AND ".$topic->_table.".OwnerType = ?";
		$params['param'] = array($id, $type);
		$params['filters'][] = array(
			'model' => 'FmMessages',
			'joinType' => 'INNER',
			'where' => $messages->_table.".ID_OWNER = ? AND ".$messages->_table.".OwnerType = ? 
				AND ".$messages->_table.".ID_MSG = ".$topic->_table.".ID_FIRST_MSG 
				AND (".$messages->_table.".Subject LIKE ? OR ".$messages->_table.".Body LIKE ?)",
			'param' => array($id, $type, '%'.$query.'%', '%'.$query.'%')
		);

		$data = Doo::db()->find('FmTopics', $params);

		foreach($data as $d) {
			$d->lastMessage = $this->getLastMessage($type, $id, $d->ID_TOPIC);
		};

		return $data;
	}

	public function getTypeAttr($type) {
		switch($type) {
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
		};

		return array('model' => $model, 'fields' => $fields);
	}

	private function updateCacheForum($type, $id) {
		Cache::increase(CACHE_FORUM.$type.$id);
	}
	
	public function logVisitForum($type, $id, $user) {
		$rel = new FmPlayerForumRel();
		$rel->OwnerType = $type;
		$rel->ID_OWNER = $id;
		$rel->ID_PLAYER = $user->ID_PLAYER;
		$result = $rel->getOne();

		if($result != null) {
			$rel->update(array('where' => 'ID_OWNER = ? AND OwnerType = ? AND ID_PLAYER = ?', 
				'param' => array($id, $type, $user->ID_PLAYER)));
		} else {
			$rel->insert();
		};
	}

	public function logVisitBoard($type, $id, $board, $user) {
		$rel = new FmPlayerBoardRel();
		$rel->OwnerType = $type;
		$rel->ID_OWNER = $id;
		$rel->ID_BOARD = $board;
		$rel->ID_PLAYER = $user->ID_PLAYER;
		$result = $rel->getOne();

		if($result != null) {
			$rel->update(array('where' => 'ID_OWNER = ? AND OwnerType = ? AND ID_BOARD = ? AND ID_PLAYER = ?', 
				'param' => array($id, $type, $board, $user->ID_PLAYER)));
		} else {
			$rel->insert();
		};
	}

	public function logVisitTopic($type, $id, $topic, $user) {
		$rel = new FmPlayerTopicRel();
		$rel->OwnerType = $type;
		$rel->ID_OWNER = $id;
		$rel->ID_TOPIC = $topic;
		$rel->ID_PLAYER = $user->ID_PLAYER;
		$result = $rel->getOne();
		if($result != null) {
			$rel->update(array('where' => 'ID_OWNER = ? AND OwnerType = ? AND ID_TOPIC = ? AND ID_PLAYER = ?', 
				'param' => array($id, $type, $topic, $user->ID_PLAYER)));
		} else {
			$rel->insert();
		};
	}

	public function collapseCategory($type, $id, $cid, $user) {
		$collapsed = new FmCollapsedCategories();
		$collapsed->OwnerType = $type;
		$collapsed->ID_OWNER = $id;
		$collapsed->ID_CAT = $cid;
		$collapsed->ID_PLAYER = $user->ID_PLAYER;
		$collapsed->insert();
		return true;
	}

	public function expandCategory($type, $id, $cid, $user) {
		$collapsed = new FmCollapsedCategories();
		$collapsed->OwnerType = $type;
		$collapsed->ID_OWNER = $id;
		$collapsed->ID_CAT = $cid;
		$collapsed->ID_PLAYER = $user->ID_PLAYER;
		$collapsed->delete();
		$data = $this->getCategoryBoards($type, $id, $cid);
		return $data;
	}

	public function saveCategory($model, $post) {
		if(!empty($post)) {
			$cat = new FmCategories();
			$cat->ID_OWNER = $model->UNID;
			$cat->CategoryName = ContentHelper::handleContentInput($post['cat_name']);
			$cat->OwnerType = $post['type'];

			if(isset($post['cat_id'])) {
				$cat->ID_CAT = $post['cat_id'];
				$q = "UPDATE {$cat->_table} SET CategoryName = ? WHERE ID_CAT = ? AND ID_OWNER = ? AND OwnerType = ?";
				$param = array($cat->CategoryName, $cat->ID_CAT, $cat->ID_OWNER, $cat->OwnerType);
				Doo::db()->query($q, $param);
			} else {
				$cat->insert();
			};
			return true;
		}
		return false;
	}

	public function saveBoard($model, $post) {
		if (!empty($post)) {
			$brd = new FmBoards();
			$brd->ID_OWNER = $model->UNID;
			$brd->BoardName = ContentHelper::handleContentInput($post['board_name']);
			$brd->OwnerType = $post['type'];
			$brd->ID_CAT = $post['cat_id'];

			if(isset($post['board_id'])) {
				$brd->ID_BOARD = $post['board_id'];- 
				$q = "UPDATE {$brd->_table} SET BoardName = ?, ID_CAT = ? WHERE ID_BOARD = ? AND ID_OWNER = ? AND OwnerType = ?";
				$param = array($brd->BoardName, $brd->ID_CAT, $brd->ID_BOARD, $brd->ID_OWNER, $brd->OwnerType);
				Doo::db()->query($q, $param);
			} else {
				$brd->insert();
			};
            return true;
        };
        return false;
	}
	
	public function getCategory($type, $owner, $catId) {
		$category = new FmCategories;
		$category->ID_CAT = $catId;
		$category->ID_OWNER = $owner;
		$category->OwnerType = $type;
		$c = $category->getOne();
		return $c;
	}

	public function getBoardByID($type, $owner, $brdId) {
		$board = new FmBoards();
		$board->ID_BOARD = $brdId;
		$board->ID_OWNER = $owner;
		$board->OwnerType = $type;
		$b = $board->getOne();
		return $b;
	}

	public static function getModelByUrl($type, $url) {
		switch($type) {
			case 'game':
				$OwnerType = URL_GAME;
				break;
			case 'company':
				$OwnerType = URL_COMPANY;
				break;
			case 'group':
				$OwnerType = URL_GROUP;
				break;
		};

		$key = $url;

		$url = new SnUrl();
		$url->OwnerType = $OwnerType;
		$url->URL = $key;
		$url = $url->getOne();

		if($url) {
			switch($type) {
				case 'game':
					$games = new Games;
					$model = $games->getGameByID($url->ID_OWNER);
					$name = $model->GameName;
					break;
				case 'company':
					$companies = new Companies;
					$model = $companies->getCompanyByID($url->ID_OWNER);
					$name = $model->CompanyName;
					break;
				case 'group':
					$groups = new Groups;
					$model = $groups->getGroupByID($url->ID_OWNER);
					$name = $model->GroupName;
					break;
			};
		} else {
			DooUriRouter::redirect(Doo::conf()->APP_URL);
			return false;
		};

		if(isset($model) and $model != false) {
			$model->UNID = $url->ID_OWNER;
			$model->UNNAME = $name;
			return $model;
		} else {
			DooUriRouter::redirect(Doo::conf()->APP_URL);
			return false;
		};

		// var_dump($model);
	}

	public static function getModelByID($type, $id) {
		switch($type) {
			case 'game':
				$model = Games::getGameByID($id);
				$name = $model->GameName;
				break;
			case 'company':
				$model = Companies::getCompanyByID($id);
				$name = $model->CompanyName;
				break;
			case 'group':
				$model = Groups::getGroupByID($id);
				$name = $model->GroupName;
				break;
		};

		if(isset($model) and $model != false) {
			$model->UNID = $id;
			$model->UNNAME = $name;
			return $model;
		} else {
			DooUriRouter::redirect(Doo::conf()->APP_URL);
			return false;
		};
	}

	public static function getMiniModel($type, $id) {
		$owner = null;
		switch($type) {
			case URL_GAME:
				$owner = new SnGames;
				$owner->ID_GAME = $id;
				break;
			case URL_COMPANY:
				$owner = new SnCompanies();
				$owner->ID_COMPANY = $id;
				break;
			case URL_GROUP:
				$owner = new SnGroups();
				$owner->ID_GROUP = $id;
				break;
		};
		return $owner;
	}

	public static function pinLockThread($pl_type, $ownerID, $type, $board, $topic) {
		if ($topic > 0) {
			$fmTopic = new FmTopics();
			$fmTopic->OwnerType = $type;
			$fmTopic->ID_TOPIC = $topic;
			$fmTopic->ID_BOARD = $board;
			$fmTopic->ID_OWNER = $ownerID;
	
			if ($pl_type == "pin" || $pl_type == "unpin") {
				$ispinned = ($pl_type == "pin") ? 1 : 0;
				$fmTopic->isSticky = $ispinned;
	
				$q = "UPDATE {$fmTopic->_table} SET isSticky = ? WHERE ID_OWNER = ? and OwnerType = ? and ID_BOARD = ? and ID_TOPIC =?";
				$param = array($fmTopic->isSticky,$fmTopic->ID_OWNER,$fmTopic->OwnerType,$fmTopic->ID_BOARD,$fmTopic->ID_TOPIC);
			} else {
				$islocked = ($pl_type == "lock") ? 1 : 0;
				$fmTopic->isLocked = $islocked;
				$q = "UPDATE {$fmTopic->_table} SET islocked = ? WHERE ID_OWNER = ? and OwnerType = ? and ID_BOARD = ? and ID_TOPIC =?";
				$param = array($fmTopic->isLocked,$fmTopic->ID_OWNER,$fmTopic->OwnerType,$fmTopic->ID_BOARD,$fmTopic->ID_TOPIC);
			}
		
			Doo::db()->query($q, $param);
			return true;
		}
		return false;
	}

	public static function deactivateBan($id_suspend){
		if ($id_suspend > 0) {
			$bans = new FmBannedPlayerBoardRel;
			$today = date('Y-m-d');
	
			$q = "UPDATE {$bans->_table} SET EndDate = ?, Unlimited = 0 WHERE ID_SUSPEND = ?";
			$param = array($today, $id_suspend);
			Doo::db()->query($q, $param);
	
			return true;
		}
		return false;
	}

	public static function moveBanToHistory($id_suspend){
		if ($id_suspend > 0) {
			$bans = new FmBannedPlayerBoardRel;
			
			$q = "UPDATE {$bans->_table} SET isHistory = 1 WHERE ID_SUSPEND = ?";
			$param = array($id_suspend);
			Doo::db()->query($q, $param);
	
			return true;
		}
		return false;
	}

}
?>