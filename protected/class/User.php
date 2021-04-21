<?php

class User {

	/**
	 * Returns user object
	 *
	 * @return Players $user or false if no user
	 */
	public static function getUser() {
		static $user = array();
		static $check = array();

		if (isset($check['check'])) {
			if (isset($user['p']) and !empty($user['p'])) {
				if ($user['p']->LastActivity > time() - 300)
					return $user['p'];
			} else {
				return FALSE;
			}
		}

		$check['check'] = true;
		if ((isset($_SESSION['user']['id']) and $_SESSION['user']['id'] > 0) or isset($_COOKIE['u'])) {
			$player = new Players();
			if (isset($_SESSION['user']['id']) and $_SESSION['user']['id'] > 0) {
				$player->ID_PLAYER = $_SESSION['user']['id'];
			} else {
				$player->Hash = $_COOKIE['u'];
			}
			$player->purgeCache();
			$player = $player->getOne();

			if ($player) {
				if ($player->LastActivity < time() - 3600 * 5) {
					Auth::logOut();
					return FALSE;
				} else if ($player->LastActivity < time() - 300) {
					$auth = Auth::generateSecure($player);
					$player = $auth['player'];
				}
			}

			return $user['p'] = $player;
		} else {
			return FALSE;
		}
	}

	public static function canAccess($area){
		$user = self::getUser();
		if($user and $user->canAccess($area)){
			return true;
		}

		return false;
	}

	public static function getById($id) {
		$player = new Players();
		$player->ID_PLAYER = $id;
		return $player->getOne();
	}

	public static function getByEmail($email){
		$player = new Players();
		$player->EMail = $email;

		return $player->getOne();
	}

	/**
	 * Returns friend (Player) object
	 *
	 * @param String $url
	 * @return Players $user
	 */
	public static function getFriend($url, $cleanCache = false) {
		static $friend = array();

		if (isset($friend["$url"]) and !$cleanCache) {
			return $friend["$url"];
		}

		$p = new Players();
		$p->URL = $url;

		if ($cleanCache)
			$p->purgeCache();
		$p = $p->getOne();

		if (empty($friend['p'])) {
			$friend["$url"] = new Players();
		}
		$friend["$url"] = $p;

		return $friend["$url"];
	}

        public static function getTeam(){
            $player = self::getUser();
            $esport = new Esport();

            return $esport->getTeamByID($player->ID_TEAM);
        }

	public function uploadPhoto($userID = 0) {
		$p = $this->getUser();

		if($p and $userID > 0 and $p->canAccess('Super Admin Interface') === TRUE) {
			$p = $this->getById($userID);
		}

		if ($p) {
			$image = new Image();

			if ($p->Avatar != '') {
				$avatar = $image->uploadImage(FOLDER_PLAYERS, $p->Avatar);
			} else {
				$avatar = $image->uploadImage(FOLDER_PLAYERS);
			}

			if ($avatar['filename'] != '') {
				$p->Avatar = $avatar['filename'];
				$p->update(array('field' => 'Avatar'));
				$p->purgeCache();
				$avatar['p'] = $p;
			}

			return $avatar;
		}
	}

	/**
	 * Returns all player list
	 *
	 * @return Player list
	 */
	public function getAllPlayers($limit = 0, $tab = 1, $order = 'desc', $ID_CATEGORY) {
		$player = User::getUser();
		$level2 = new SnLevel2Friends;

		$order = strtoupper($order);

		if($tab == 2) {
			//Tab 2. Players who play the same games as you:
			$orderBy = "CommonGamesPlayedCount $order, CommonGroupsCount $order";
		} else if($tab == 3) {
			//Tab 3. Players who are members of the same groups as you:
			$orderBy = "CommonGroupsCount $order, CommonGamesPlayedCount $order";
		} else if($tab == 4) {
			//Tab 4. Players who live in your area:
			$orderBy = "sameCity $order, sameCountry $order, MutualCount $order";
		} else {
			//Tab 1. Players you may know:
			$orderBy = "MutualCount $order, CommonGamesPlayedCount $order";
		}


		$list = array();
		if ($player) {
			$suspendQuery = MainHelper::getSuspendQuery("{$player->_table}.ID_PLAYER");
			if ($ID_CATEGORY==0)
			{
				$query = "SELECT SQL_CALC_FOUND_ROWS
							{$player->_table}.*,  {$level2->getFields()}
						FROM
							`{$player->_table}`
						INNER JOIN {$level2->_table} ON {$player->_table}.ID_PLAYER = {$level2->_table}.ID_LEVEL2FRIEND
						WHERE
							{$level2->_table}.ID_PLAYER = ?
						AND {$level2->_table}.isHidden = 0
						AND {$level2->_table}.isFriends = 0
						{$suspendQuery}
						ORDER BY {$orderBy}
						LIMIT $limit, ".Doo::conf()->playersLimit;

						$rs = Doo::db()->query($query, array($player->ID_PLAYER));
				$list = $rs->fetchAll(PDO::FETCH_CLASS, 'Players');

				if(!$list) {
					//add random players for lonely users
					$query = "SELECT
								{$player->_table}.*
							FROM
								`{$player->_table}`
							WHERE 1 {$suspendQuery}
							ORDER BY RAND()
							LIMIT 0, ".Doo::conf()->playersLimit;

					$rs = Doo::db()->query($query);
					$list = $rs->fetchAll(PDO::FETCH_CLASS, 'Players');
				}

			}
			else
			{
				$query = "SELECT SQL_CALC_FOUND_ROWS
							{$player->_table}.*,  {$level2->getFields()}
						FROM
							`{$player->_table}`
						INNER JOIN {$level2->_table} ON {$player->_table}.ID_PLAYER = {$level2->_table}.ID_LEVEL2FRIEND
						INNER JOIN sn_playercategory_rel ON sn_playercategory_rel.ID_OWNER = {$player->_table}.ID_PLAYER
						WHERE
							{$level2->_table}.ID_PLAYER = ?
						AND {$level2->_table}.isHidden = 0
						AND {$level2->_table}.isFriends = 0
						AND sn_playercategory_rel.ID_CATEGORY = $ID_CATEGORY
						AND sn_playercategory_rel.Approved = 1
						{$suspendQuery}

						ORDER BY {$orderBy}
						LIMIT $limit, ".Doo::conf()->playersLimit;

				$rs = Doo::db()->query($query, array($player->ID_PLAYER));
				$list = $rs->fetchAll(PDO::FETCH_CLASS, 'Players');


				if(!$list) {
					//add random players for lonely users
					$query = "SELECT
								{$player->_table}.*
							FROM
								`{$player->_table}`
							INNER JOIN sn_playercategory_rel ON sn_playercategory_rel.ID_OWNER = {$player->_table}.ID_PLAYER
							AND sn_playercategory_rel.ID_CATEGORY = $ID_CATEGORY
							AND sn_playercategory_rel.Approved = 1
							{$suspendQuery}
							ORDER BY RAND()
							LIMIT 0, ".Doo::conf()->playersLimit;

					$rs = Doo::db()->query($query);
					$list = $rs->fetchAll(PDO::FETCH_CLASS, 'Players');
				}
			}
		}
		return $list;
	}
	
	/*public function sortPlayers($limit = 0, $tab = 1, $order = 'DESC', $ID_CATEGORY = 3) {
		$player = User::getUser();

        switch($tab) {
            case 2: //Tab 6 Top Rated Players:
                $orderBy = "SocialRating";
                break;
            case 3: //Tab 7. Top Vistited Players This Week:
                $orderBy = "LastVisitedTime >= (UNIX_TIMESTAMP(UTC_TIMESTAMP()))";
                break;
            case 4: //Tab 8. Top Visted Players All Time:
                $orderBy = "VisitCount";
                break;
            default: //Tab 5. Top Visited Players:
                $orderBy = "VisitCount";
                
        }

		$list = array();
		if($player !== FALSE) {
                    $playerModel = new Players();
                    $table = $playerModel->_table;
                    $playersLimit = Doo::conf()->playersLimit;
                    $catPlayer = new SnPlayerCategoryRel();
                    $catTable = $catPlayer->_table;

                    $query = "SELECT * FROM {$table} 
                        RIGHT JOIN {$catTable}
                        ON
                        {$table}.ID_PLAYER = {$catTable}.ID_OWNER
                        ORDER BY {$orderBy}
                        LIMIT $limit, ".Doo::conf()->playersLimit;
                       
                    $res = Doo::db()->query($query, array($player->ID_PLAYER));
                    
                    
                 /*   $Opts = array(
                        "limit" => "{$limit} , {$playersLimit}",
                        strtolower($order) => "{$table}.{$orderBy}",
                    );*/
/*                    $list = $res->fetchAll(PDO::FETCH_CLASS, 'Players');

                    if(empty($list)) {
                        $Opts = array(
                            "limit" => "0 , {$playersLimit}",
                            strtolower($order) => "RAND()",
                        );
                        $list = $res->fetchAll(PDO::FETCH_CLASS, 'Players');
                    };
               };
		return $list;
	}*/
	    public function sortPlayers($limit = 0, $tab = 1, $order = 'desc', $ID_CATEGORY = 0) {
		$player = User::getUser();
		$level2 = new SnLevel2Friends;

		$order = strtoupper($order);

		if($tab == 2) {
			//Tab 2 Top Rated Players:
			$orderBy = "SocialRating $order";
		} else if($tab == 3) {
			//Tab 3. Top Vistited Players This Week:
			$orderBy = "LastVisitedTime >= (UNIX_TIMESTAMP(UTC_TIMESTAMP())) $order";
		} else if($tab == 4) {
			//Tab 4. Top Visted Players All Time:
			$orderBy = "VisitCount $order";
		} else {
			//Tab 1. Top Visited Players:
			$orderBy = "VisitCount $order";
		}


		$list = array();
		if ($player) {
			$suspendQuery = MainHelper::getSuspendQuery("{$player->_table}.ID_PLAYER");
			
			if ($ID_CATEGORY==0)
			{
				$query = "SELECT SQL_CALC_FOUND_ROWS
							{$player->_table}.*,  {$level2->getFields()}
						FROM
							`{$player->_table}`
						INNER JOIN {$level2->_table} ON {$player->_table}.ID_PLAYER = {$level2->_table}.ID_LEVEL2FRIEND
						WHERE
                                                {$level2->_table}.ID_PLAYER = ''
						AND {$level2->_table}.isHidden = 0
						AND {$level2->_table}.isFriends = 0
						{$suspendQuery}
						ORDER BY {$orderBy}
						LIMIT $limit, ".Doo::conf()->playersLimit;

						$rs = Doo::db()->query($query, array($player->ID_PLAYER));
				$list = $rs->fetchAll(PDO::FETCH_CLASS, 'Players');

				if(!$list) {
					//add random players for lonely users
					$query = "SELECT
								{$player->_table}.*
							FROM
								`{$player->_table}`
							
							ORDER BY {$orderBy}
							LIMIT 0, ".Doo::conf()->playersLimit;

					$rs = Doo::db()->query($query);
					$list = $rs->fetchAll(PDO::FETCH_CLASS, 'Players');
				}

			}
			else
			{
				$query = "SELECT SQL_CALC_FOUND_ROWS
							{$player->_table}.*,  {$level2->getFields()}
						FROM
							`{$player->_table}`
						INNER JOIN {$level2->_table} ON {$player->_table}.ID_PLAYER = {$level2->_table}.ID_LEVEL2FRIEND
						INNER JOIN sn_playercategory_rel ON sn_playercategory_rel.ID_OWNER = {$player->_table}.ID_PLAYER
						WHERE
							{$level2->_table}.ID_PLAYER = ?
						AND {$level2->_table}.isHidden = 0
						AND {$level2->_table}.isFriends = 0
						AND sn_playercategory_rel.ID_CATEGORY = $ID_CATEGORY
						AND sn_playercategory_rel.Approved = 1
						{$suspendQuery}

						ORDER BY {$orderBy}
						LIMIT $limit, ".Doo::conf()->playersLimit;

				$rs = Doo::db()->query($query, array($player->ID_PLAYER));
				$list = $rs->fetchAll(PDO::FETCH_CLASS, 'Players');


				if(!$list) {
					//add random players for lonely users
					$query = "SELECT
								{$player->_table}.*
							FROM
								`{$player->_table}`
							INNER JOIN sn_playercategory_rel ON sn_playercategory_rel.ID_OWNER = {$player->_table}.ID_PLAYER
							AND sn_playercategory_rel.ID_CATEGORY = $ID_CATEGORY
							AND sn_playercategory_rel.Approved = 1
							{$suspendQuery}
							ORDER BY {$orderBy}
							LIMIT 0, ".Doo::conf()->playersLimit;

					$rs = Doo::db()->query($query);
					$list = $rs->fetchAll(PDO::FETCH_CLASS, 'Players');
				}
			}




		}

		return $list;
	}
	/**
	 * Returns amount of players
	 *
	 * @return int
	 */
	public function getTotal() {
		$rs = Doo::db()->query('SELECT FOUND_ROWS() as total');
        $total = $rs->fetch();
        return $total['total'];
	}

	public function getTotalPlayers($player) {
		$snPlayers = new Players;
		if($player->canAccess('Edit user information') === FALSE)
			$rs = Doo::db()->query('SELECT COUNT(1) as total FROM '.$snPlayers->_table.' WHERE ID_USERGROUP IN (0,3,4,5)');
		else
			$rs = Doo::db()->query('SELECT COUNT(1) as total FROM '.$snPlayers->_table);
        $total = $rs->fetch();
        return $total['total'];
	}

	/**
	 * Checks if user is returning
	 * @return boolean
	 */
	public static function isReturningVisitor() {
		static $check = null;

		if ($check != null) {
			return $check;
		}
		if (!isset($_COOKIE['rv'])) {
			setcookie('rv', session_id(), (time() + 31536000), '/');
			$check = false;
			return false;
		}
		$check = true;
		return true;
	}

	public static function initShowHideBlock() {
		static $check = null;

		if ($check != null) {
			return $check;
		}

		if (!isset($_COOKIE['pop'])) {
			$array[NEWS_TOP] = '1';
			$array[NEWS_POPULAR] = '1';
			$array[NEWS_PLATFORM] = '1';
			$array[NEWS_COMPANIES] = '1';
			setcookie('pop', serialize($array), (time() + 86400), '/');
			$check = false;
			return false;
		}
	}

	public static function isBlockVisible($block) {
		if (isset($_COOKIE['pop']) and !empty($_COOKIE['pop'])) {
			$result = unserialize($_COOKIE['pop']);
			if (isset($result["$block"])) {
				if($result["$block"] == 1) {
					return true;
				} else {
					return false;
				}
			} else {
				return true;
			}
			return false;
		}
		return true;
	}

	public static function setBlockVisibility($block, $val = 1) {
		if (isset($_COOKIE['pop']) and !empty($_COOKIE['pop'])) {
			$result = unserialize($_COOKIE['pop']);
			$result["$block"] = $val;
			setcookie('pop', serialize($result), (time() + 86400), '/');
		}
	}

	public function getSubscriptionsTypes($player_id) {
		$playerSubscribtion = new SnPlayerSubscribtionRel();
		$result = Doo::db()->find($playerSubscribtion, array(
					'select' => 'ItemType, COUNT(1) as total',
					'where' => 'ID_PLAYER = ?',
					'asc' => 'ItemType',
					'param' => array($player_id),
					'groupby' => 'ItemType'
				));
		return $result;
	}

	public function getSubscriptionsCount($player_id,  $type = '', $search = '') {
		$playerSubscribtion = new SnPlayerSubscribtionRel();

		$params = array(
			'select' => 'COUNT(1) as total',
			'where' => 'ID_PLAYER = ?',
			'param' => array($player_id),
			'limit' => 1
		);

		if($type != '') {
			$params['where'] .= ' AND ItemType = ?';
			$params['param'][] = $type;
		}

		if($search != '') {
			$params['where'] .= ' AND ItemName LIKE ?';
			$params['param'][] = '%'.$search.'%';
		}

		$result = Doo::db()->find($playerSubscribtion, $params);
		return $result->total;
	}

	public function getSubscriptions($player_id,  $type = '', $search = '', $limit = 0) {
		$playerSubscribtion = new SnPlayerSubscribtionRel();

		$params = array(
			'where' => 'ID_PLAYER = ?',
			'desc' => 'SubscriptionTime',
			'param' => array($player_id),
			'limit' => $limit
		);

		if($type != '') {
			$params['where'] .= ' AND ItemType = ?';
			$params['param'][] = $type;
		}

		if($search != '') {
			$params['where'] .= ' AND ItemName LIKE ?';
			$params['param'][] = '%'.$search.'%';
		}

		$result = Doo::db()->find($playerSubscribtion, $params);
		return $result;
	}

	//SLOW AS HELL, NEED TO FIX!!!
	public static function searchPlayers($query){
		$players = array();
		if(strlen($query) >= 3){
			$params = array();
			$params['where'] = "(FirstName LIKE ? OR LastName LIKE ? OR NickName LIKE ? OR EMail = ? OR City LIKE ?)";
			$params['where'] .= MainHelper::getSuspendQuery("sn_players.ID_PLAYER");
			$params['param'] = array('%'.$query.'%', '%'.$query.'%','%'.$query.'%', $query, '%'.$query.'%');
			$players = Doo::db()->find('Players', $params);
		}

		return $players;
	}

	public function getAllUsers($limit, $player, $sortType = 'email', $sortDir = 'asc') {
		$params = array();
		if ($sortType == 'id') {
			$params[$sortDir] = 'ID_PLAYER';
		} else if ($sortType == 'nick') {
			$params[$sortDir] = 'NickName';
		} else if ($sortType == 'real') {
			$params[$sortDir] = "concat(FirstName, ' ', LastName)";
		} else if ($sortType == 'email') {
			$params[$sortDir] = 'EMail';
		}
		$params['limit'] = $limit;
		if($player->canAccess('Edit user information') === FALSE)
			$params['where'] = 'ID_USERGROUP IN (0,3,4,5)';
		$result = Doo::db()->find('Players', $params);
		return $result;
	}

        public function getAllBloggers($limit) {
        $bloggers = new Players();
        $query = "SELECT {$bloggers->_table}.*
                    FROM {$bloggers->_table}
                    WHERE {$bloggers->_table}.hasBlog = 1
                    ORDER BY {$bloggers->_table}.NickName ASC
                    LIMIT $limit";
        $rs = Doo::db()->query($query)->fetchAll();
        return $rs;
        }

	public function getTotalBloggers() {
		$snPlayers = new Players;
		$params = array();

		$rs = Doo::db()->query('SELECT COUNT(1) as total FROM '.$snPlayers->_table.' WHERE hasBlog = 1');
        $total = $rs->fetch();
        return $total['total'];
	}

	public function GetNotApprovedUsers()
	{
		$query = "
			SELECT *
			FROM sn_players
			LEFT JOIN sn_playercategory_rel
			ON sn_players.ID_PLAYER=sn_playercategory_rel.ID_OWNER
			LEFT JOIN sy_categories
			ON sy_categories.ID_CATEGORY=sn_playercategory_rel.ID_CATEGORY
			WHERE ( (MBA_enabled = 1 AND Approved = 0) AND Approved IS NOT NULL ) = 1";

		return Doo::db()->query($query)->fetchall();
	}

	public function GetUsersBySuspendLevel($level)
	{
		$query = "SELECT sn_players.* FROM sn_players,sn_playersuspend
			WHERE sn_playersuspend.ID_PLAYER=sn_players.ID_PLAYER
			AND	sn_playersuspend.isHistory=0
			AND ( CURDATE()<=sn_playersuspend.EndDate AND sn_playersuspend.Level=$level)";
		return Doo::db()->query($query)->fetchall();
	}

	public function CancelSuspend($ID_PLAYER)
	{
		$query = "UPDATE sn_playersuspend SET isHistory = 1 WHERE ID_PLAYER={$ID_PLAYER};";
		Doo::db()->query($query);
	}

	public function activate($ID_PLAYER)
	{
		$query = "UPDATE sn_players SET VerificationCode = '' WHERE ID_PLAYER={$ID_PLAYER};";
		return Doo::db()->query($query);
	}

        public function UpdateUserRole($ID_PLAYER, $role){
            $player = new Players();

            $query = "UPDATE {$player->_table} SET {$player->_table}.ID_USERGROUP = {$role} WHERE {$player->_table}.ID_PLAYER = {$ID_PLAYER} ";
            Doo::db()->query($query);
        }
}

?>
