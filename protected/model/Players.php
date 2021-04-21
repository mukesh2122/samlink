<?php

Doo::loadCore('db/DooSmartModel');

class Players extends DooSmartModel {

	public $ID_PLAYER;
	public $FirstName;
	public $LastName;
	public $NickName;
	public $DisplayName;
	public $EMail;
	public $Password;
	public $Avatar;
	public $DateOfBirth;
	public $Gender;
	public $isSuperUser;
	public $Address;
	public $City;
	public $Zip;
	public $Country;
	public $Phone;
	public $ID_LANGUAGE;
	public $OtherLanguages;
	public $ID_TIMEZONE;
	public $TimeOffset;
	public $DSTOffset;
	public $RegistrationTime;
	public $ID_TEAM;
	public $Credits;
	public $PlayCredits;
	public $ImageLimit;
	public $GroupLimit;
	public $FreeGameLimit;
	public $NoAdsTime;
	public $isReferrer;
	public $canCreateReferrers;
	public $FriendCount;
	public $FriendRequestsSent;
	public $FriendRequestsReceived;
	public $SubscribedToCount;
	public $SubscribedByCount;
	public $CompanyCount;
	public $CompanyForumCount;
	public $GameCount;
	public $GameForumCount;
	public $GamePlayedCount;
	public $ESportCount;
	public $GroupCount;
	public $GroupForumCount;
	public $GroupsOwnedCount;
	public $PostCount;
	public $SubscribedBoardTopicCount;
	public $WallPostCount;
	public $WallVideoCount;
	public $WallPhotoCount;
	public $WallLinkCount;
	public $MessageCount;
	public $NewMessageCount;
	public $MessageSentCount;
	public $EventCount;
	public $NewEventCount;
	public $NotificationCount;
	public $NewNotificationCount;
	public $SubscribedNewsCount;
	public $NewAchievementCount;
	public $ID_LASTVISITOR;
	public $LastVisitorInfo;
	public $LastVisitedTime;
	public $VisitCount;
	public $WallitemInterval;
	public $Hash;
	public $LastActivity;
	public $isDeveloper;
        
	// Chat
	public $isOnline;
    
	//Esport
	public $isCaptain;
	public $isPending;
	public $Role;
    //test API multi-login solution
    //public $isFacebookAuth;
    //public $isTwitterAuth;
    //public $isTwitchAuth;

	public $VerificationCode;
	public $URL;
	public $PassRequest;
	public $SocialRating;
	public $IntroSteps;
	public $TwitterID;
	public $isDeleted;
	public $ID_USERGROUP;
	public $hasBlog;
	public $_table = 'sn_players';
	public $_primarykey = 'ID_PLAYER';
	public $_fields = array(
		'ID_PLAYER',
		'FirstName',
		'LastName',
		'NickName',
		'DisplayName',
		'EMail',
		'Password',
		'Avatar',
		'DateOfBirth',
		'Gender',
		'isSuperUser',
		'Address',
		'City',
		'Zip',
		'Country',
		'Phone',
		'ID_LANGUAGE',
		'OtherLanguages',
		'RegistrationTime',
		'ID_TEAM',
		'Credits',
		'PlayCredits',
		'ImageLimit',
		'GroupLimit',
		'FreeGameLimit',
		'NoAdsTime',
		'isReferrer',
		'canCreateReferrers',
		'FriendCount',
		'FriendRequestsSent',
		'FriendRequestsReceived',
		'SubscribedToCount',
		'SubscribedByCount',
		'CompanyCount',
		'CompanyForumCount',
		'GameCount',
		'GameForumCount',
		'GamePlayedCount',
		'ESportCount',
		'GroupCount',
		'GroupForumCount',
		'GroupsOwnedCount',
		'PostCount',
		'SubscribedBoardTopicCount',
		'WallPostCount',
		'WallVideoCount',
		'WallPhotoCount',
		'WallLinkCount',
		'MessageCount',
		'NewMessageCount',
		'MessageSentCount',
		'EventCount',
		'NewEventCount',
		'NotificationCount',
		'NewNotificationCount',
		'SubscribedNewsCount',
		'NewAchievementCount',
		'ID_LASTVISITOR',
		'LastVisitorInfo',
		'LastVisitedTime',
		'VisitCount',
		'WallitemInterval',
		'Hash',
		'LastActivity',

		// Chat
		'isOnline',
        
        //test Oauth Solution
        //'isFacebookAuth',
        //'isTwitterAuth',
        //'isTwitchAuth',

		'VerificationCode',
		'URL',
		'PassRequest',
		'SocialRating',
		'IntroSteps',
		'TimeOffset',
		'DSTOffset',
		'TwitterID',
		'ID_TIMEZONE',
		'isDeleted',
		'ID_USERGROUP',
		'hasBlog',
		'isDeveloper'
	);

	function __construct() {
		parent::$className = __CLASS__;	 //a must if you are using static querying methods Food::_count(), Food::getById()
	}

	public function fillWithValues($array) {
		$array = (array) $array;
		foreach ($this->_fields as $field) {
			if (!is_object($field) and isset($array[$field])) {
				$this->{$field} = $array[$field];
			}
		}
	}

	public function getVRules() {
		return array(
			'ID_PLAYER' => array(
				array('integer'),
				array('min', 0),
				array('maxlength', 8),
				array('notnull'),
			),
			'FirstName' => array(
				array('maxlength', 80),
				array('notnull'),
			),
			'LastName' => array(
				array('maxlength', 80),
				array('notnull'),
			),
			'NickName' => array(
				array('maxlength', 80),
				array('notnull'),
			),
			'DisplayName' => array(
				array('maxlength', 240),
				array('notnull'),
			),
			'EMail' => array(
				array('maxlength', 120),
				array('notnull'),
			),
			'Password' => array(
				array('maxlength', 120),
				array('notnull'),
			),
			'Avatar' => array(
				array('maxlength', 200),
				array('notnull'),
			),
			'DateOfBirth' => array(
				array('date'),
				array('notnull'),
			),
			'Address' => array(
				array('notnull'),
			),
			'Country' => array(
				array('maxlength', 2),
				array('notnull'),
			),
			'FriendCount' => array(
				array('integer'),
				array('min', 0),
				array('maxlength', 8),
				array('notnull'),
			),
			'FollowingCount' => array(
				array('integer'),
				array('min', 0),
				array('maxlength', 8),
				array('notnull'),
			),
			'FollowersCount' => array(
				array('integer'),
				array('min', 0),
				array('maxlength', 8),
				array('notnull'),
			),
			'CompanyCount' => array(
				array('integer'),
				array('min', 0),
				array('maxlength', 8),
				array('notnull'),
			),
			'GameCount' => array(
				array('integer'),
				array('min', 0),
				array('maxlength', 8),
				array('notnull'),
			),
			'GroupCount' => array(
				array('integer'),
				array('min', 0),
				array('maxlength', 8),
				array('notnull'),
			),
			'WallitemInterval' => array(
				array('datetime'),
				array('notnull'),
			),
			'Hash' => array(
				array('maxlength', 40),
				array('null'),
			),
			'LastActivity' => array(
				array('integer'),
				array('min', 0),
				array('maxlength', 8),
				array('null'),
			),
		);
	}

	//Is user suspended now
	public function isSuspended()
	{
		$timeToday = strtotime(date("Y-m-d"));
		$query = "SELECT * FROM sn_playersuspend WHERE ID_PLAYER={$this->ID_PLAYER} AND isHistory=0";
		$playerSuspend = Doo::db()->fetchAll($query);
		if (isset($playerSuspend[0]))
		{
			$sus = $playerSuspend[0];
			$isHistory = $sus['isHistory'];
			$Unlimited = $sus['Unlimited'];
			$StartDate = $sus['StartDate'];
			$EndDate = $sus['EndDate'];
			$timeStart = strtotime($StartDate);
			$timeEnd = strtotime($EndDate);
			if ($Unlimited==0)
			{
				//Limited suspension
				if ($timeStart <= $timeToday && $timeToday <= $timeEnd) 
					return true;
			}
			else
			{
				//Unlimited suspension
				if ($timeStart <= $timeToday) 
					return true;
			}
		}
		return false;
	}

    public function isTranslator() {
        $transModel = new SyTranslators();
        $Opts = array(
            "limit" => 1,
            "param" => array($this->ID_PLAYER),
            "where" => "{$transModel->_table}.ID_PLAYER = ?",
        );
        $Result = $transModel->find($Opts);
        if(!empty($Result)) { return TRUE; };
        return FALSE;
    }
	
	//Get suspend status
	public function getSuspendStatus()
	{
		$timeToday = strtotime(date("Y-m-d"));
		$query = "SELECT * FROM sn_playersuspend WHERE ID_PLAYER={$this->ID_PLAYER} AND isHistory=0";
		$playerSuspend = Doo::db()->fetchAll($query);
		if (isset($playerSuspend[0]))
		{
			$sus = $playerSuspend[0];
			$isHistory = $sus['isHistory'];
			$Unlimited = $sus['Unlimited'];
			$StartDate = $sus['StartDate'];
			$EndDate = $sus['EndDate'];
			$timeStart = strtotime($StartDate);
			$timeEnd = strtotime($EndDate);
			if ($Unlimited==0)
			{
				//Limited suspension
				if ($timeStart <= $timeToday && $timeToday <= $timeEnd) 
					return $sus;
			}
			else
			{
				//Unlimited suspension
				if ($timeStart <= $timeToday) 
					return $sus;
			}
		}
		return null;
	}

	public function getSuspendLevel()
	{
		$status = $this->getSuspendStatus();
		$suspendLevel = ($status!=null) ? $status['Level'] : 0;
		return $suspendLevel;
	}
	
	//Get suspension history list
	public function getSuspendedHistory()
	{
		$query = "SELECT * FROM sn_playersuspend WHERE ID_PLAYER={$this->ID_PLAYER} ORDER BY ID_SUSPEND DESC";
		$playerSuspend = Doo::db()->fetchAll($query);
		return $playerSuspend;
	}
	
	//returns list of friends
	public function getFriends($offset = 0, $phrase = "", $personal = TRUE, $viewerID = 0) {
		$friendsRel = new FriendsRel();
		$offset = intval($offset);
		if ($personal === TRUE) {
			$where = ''.MainHelper::getSuspendQuery("p.ID_PLAYER");
			$params = array($this->ID_PLAYER, $this->ID_PLAYER, $this->ID_PLAYER);
			if ($phrase != '') {
				$where = " AND (p.FirstName LIKE ? OR p.NickName LIKE ?)";
				$params[] = "%" . $phrase . "%";
				$params[] = "%" . $phrase . "%";
			}
			
			$query = "SELECT SQL_CALC_FOUND_ROWS
                        	p.*, 
                        	r.Mutual,
                        	r.Subscribed,
                        	r.RequestPending
                        FROM
                        	`{$this->_table}` AS p,
                        	`{$friendsRel->_table}` AS r
                        WHERE
                        ((r.ID_FRIEND = ? AND r.RequestPending = 1) OR (r.ID_PLAYER = ? AND r.Mutual = 1))
                        AND p.ID_PLAYER IN(r.ID_FRIEND, r.ID_PLAYER)
                        AND p.ID_PLAYER != ?
                        $where
                        ORDER BY
                        	r.Mutual,
                        	p.FirstName ASC
                    	LIMIT $offset," . Doo::conf()->friendsLimit;

			$friends = Doo::db()->fetchAll($query, $params);

			$rs = Doo::db()->query('SELECT FOUND_ROWS() as total');
			$total = $rs->fetch();
		} else {
			$where = ''.MainHelper::getSuspendQuery("p.ID_PLAYER");
			$params = array($this->ID_PLAYER);
			if ($phrase != '') {
				$where = " AND (p.FirstName LIKE ? OR p.NickName LIKE ?)";
				$params[] = "%" . $phrase . "%";
				$params[] = "%" . $phrase . "%";
			}
			//get friends friends including relationship with viewer
			$query = "SELECT SQL_CALC_FOUND_ROWS
                    	p.*, r.Mutual, r.Subscribed, r.RequestPending
                    FROM
                    	`{$this->_table}` AS p
                    INNER JOIN `{$friendsRel->_table}` AS r ON p.ID_PLAYER = r.ID_FRIEND
                    WHERE r.ID_PLAYER = ? AND r.Mutual = 1 $where
                    ORDER BY r.Mutual, p.FirstName ASC
                    LIMIT $offset," . Doo::conf()->friendsLimit;

			$friends = Doo::db()->fetchAll($query, $params);

			$rs = Doo::db()->query('SELECT FOUND_ROWS() as total');
			$total = $rs->fetch();
		}
		/* THIS IS SHIT BY RICHARD AND NEED TO BE FIXED */
		if (!empty($friends)) {
			$ids = array();
			$friends2Extended = array();
			foreach ($friends as $fr) {
				$ids[] = $fr['ID_PLAYER'];
				$friends2Extended[$fr['ID_PLAYER']] = $fr;
			}
			$query = "SELECT
						p.ID_PLAYER, r.Mutual, r.Subscribed, r.RequestPending
					FROM
						`{$this->_table}` AS p
					INNER JOIN `{$friendsRel->_table}` AS r ON p.ID_PLAYER = r.ID_FRIEND
					WHERE r.ID_PLAYER = ? AND r.ID_FRIEND IN ('" . implode("','", $ids) . "')
					".MainHelper::getSuspendQuery("p.ID_PLAYER")."
					ORDER BY r.Mutual, p.FirstName ASC";

			$friendsRelationToViewer = Doo::db()->fetchAll($query, array($viewerID));

			if (!empty($friendsRelationToViewer)) {
				foreach ($friendsRelationToViewer as $fr) {
					if (isset($friends2Extended[$fr['ID_PLAYER']])) {
						$friends2Extended[$fr['ID_PLAYER']]['viewerRelation'] = (object) $fr;
					}
				}
				$friends = $friends2Extended;
				$friends2Extended = null;
			}
		}

		$return['total'] = $total['total'];
		$return['list'] = $friends;

		return (Object) $return;
	}

	public function getFriendsCount($phrase='', $friendcatID) {
		$friendsRel = new FriendsRel();
		$params['select'] = "COUNT(1) as cnt";
		$params['where'] = "{$friendsRel->_table}.ID_PLAYER = ? AND {$friendsRel->_table}.RequestPending = 0";
		$params['param'] = array($this->ID_PLAYER);
		$params['limit'] = 1;
		
		if(strlen($phrase) > 2) {
			$params['where'] .= ' AND FriendName LIKE ?';
			$params['param'][] = '%'.$phrase.'%';
		}

		if ($friendcatID!=0)
		{
			$params['where'] .= " AND {$friendsRel->_table}.ID_FRIEND in (select ID_FRIEND from sn_playerfriendcat_rel WHERE ID_PLAYER={$this->ID_PLAYER} AND ID_CAT={$friendcatID}) ";
		}

		//No blocked users
		$params['where'] .=  
		" AND (SELECT COUNT(*) FROM sn_playerfriendcat,sn_playerfriendcat_rel 
			WHERE sn_playerfriendcat_rel.ID_FRIEND={$friendsRel->_table}.ID_FRIEND 
			AND sn_playerfriendcat.ID_PLAYER={$this->ID_PLAYER}
			AND sn_playerfriendcat_rel.ID_PLAYER={$this->ID_PLAYER}
			AND sn_playerfriendcat_rel.ID_CAT=sn_playerfriendcat.ID_CAT 
			AND sn_playerfriendcat.Native=2) = 0 ";
		//Not blocked by users
		$params['where'] .=  
		" AND (SELECT COUNT(*) FROM sn_playerfriendcat,sn_playerfriendcat_rel 
			WHERE sn_playerfriendcat_rel.ID_FRIEND={$this->ID_PLAYER}
			AND sn_playerfriendcat.ID_PLAYER={$friendsRel->_table}.ID_FRIEND 
			AND sn_playerfriendcat_rel.ID_PLAYER={$friendsRel->_table}.ID_FRIEND 
			AND sn_playerfriendcat_rel.ID_CAT=sn_playerfriendcat.ID_CAT 
			AND sn_playerfriendcat.Native=2) = 0 ";
		//No invisible users
		$params['where'] .= MainHelper::getSuspendQuery("{$friendsRel->_table}.ID_FRIEND");
		
		$results = Doo::db()->find('FriendsRel', $params);
		return $results->cnt;
	}

	public function isPending($id) {
		$friendsRel = new FriendsRel();
		$params['select'] = "COUNT(1) as cnt";
		$params['where'] = "{$friendsRel->_table}.ID_PLAYER = ? AND {$friendsRel->_table}.ID_FRIEND = ? AND {$friendsRel->_table}.RequestPending = 1";
		$params['param'] = array($this->ID_PLAYER, $id);
		$params['limit'] = 1;

		$results = Doo::db()->find('FriendsRel', $params);

		if ($results->cnt == 1)
			return true;

		return false;
	}

	public function getBlockedUsersList($viewerID) 
	{
		$query = "SELECT sn_players.* 
			FROM sn_players
			RIGHT JOIN sn_playerfriendcat_rel ON sn_players.ID_PLAYER=sn_playerfriendcat_rel.ID_FRIEND
			RIGHT JOIN sn_playerfriendcat ON sn_playerfriendcat.ID_CAT=sn_playerfriendcat_rel.ID_CAT
			WHERE sn_playerfriendcat_rel.ID_PLAYER = {$viewerID}
			AND sn_playerfriendcat.ID_PLAYER = {$viewerID}
			AND sn_playerfriendcat.Native = 2".
			MainHelper::getSuspendQuery("sn_players.ID_PLAYER");

		$blockedUsers = Doo::db()->fetchAll($query);

		return $blockedUsers;
	}
	
	public function getFriendsList($phrase = "", $personal = TRUE, $viewerID = 0, $limit = 0, $friendcatID) {
		$friendsRel = new FriendsRel();
		$player = User::getUser();
		if ($personal === TRUE) {
			$where = '';
			$params = array($this->ID_PLAYER, $this->ID_PLAYER, $this->ID_PLAYER);
			if ($phrase != '') {
				$where = " AND (p.FirstName LIKE ? OR p.NickName LIKE ?)";
				$params[] = "%" . $phrase . "%";
				$params[] = "%" . $phrase . "%";
			}

			if ($friendcatID!=0)
			{
				$where .= " AND r.ID_FRIEND in (select ID_FRIEND from sn_playerfriendcat_rel WHERE ID_PLAYER={$player->ID_PLAYER} AND ID_CAT={$friendcatID}) ";
			}

			//No blocked users
			$where .= 
			" AND (SELECT COUNT(*) FROM sn_playerfriendcat,sn_playerfriendcat_rel 
				WHERE sn_playerfriendcat_rel.ID_FRIEND=r.ID_FRIEND 
				AND sn_playerfriendcat.ID_PLAYER={$player->ID_PLAYER}
				AND sn_playerfriendcat_rel.ID_PLAYER={$player->ID_PLAYER}
				AND sn_playerfriendcat_rel.ID_CAT=sn_playerfriendcat.ID_CAT 
				AND sn_playerfriendcat.Native=2) = 0 ";
			//Not blocked by users
			$where .= 
			" AND (SELECT COUNT(*) FROM sn_playerfriendcat,sn_playerfriendcat_rel 
				WHERE sn_playerfriendcat_rel.ID_FRIEND={$player->ID_PLAYER}
				AND sn_playerfriendcat.ID_PLAYER=r.ID_FRIEND 
				AND sn_playerfriendcat_rel.ID_PLAYER=r.ID_FRIEND 
				AND sn_playerfriendcat_rel.ID_CAT=sn_playerfriendcat.ID_CAT 
				AND sn_playerfriendcat.Native=2) = 0 ";
			//No invisible users
			$where .=  MainHelper::getSuspendQuery('r.ID_FRIEND');
			
			$query = "SELECT 
                        	p.*, 
                        	r.Mutual,
                        	r.Subscribed,
                        	r.RequestPending
                        FROM
                        	`{$this->_table}` AS p,
                        	`{$friendsRel->_table}` AS r
                        WHERE
                        ((r.ID_FRIEND = ? AND r.RequestPending = 1) OR (r.ID_PLAYER = ? AND r.Mutual = 1))
                        AND p.ID_PLAYER IN(r.ID_FRIEND, r.ID_PLAYER)
                        AND p.ID_PLAYER != ?
                        $where
                        ORDER BY
                        	r.Mutual,
                        	p.FirstName ASC
                    	";

			if ($limit != 0) {
				$query .= " LIMIT $limit";
			}
			

			$friends = Doo::db()->fetchAll($query, $params);
		} else {
			$where = '';

			if ($friendcatID!=0)
			{
				$where .= " AND r.ID_FRIEND in (select ID_FRIEND from sn_playerfriendcat_rel WHERE ID_PLAYER={$player->ID_PLAYER} AND ID_CAT={$friendcatID}) ";
			}

			//No blocked users
			$where .= 
			" AND (SELECT COUNT(*) FROM sn_playerfriendcat,sn_playerfriendcat_rel 
				WHERE sn_playerfriendcat_rel.ID_FRIEND=r.ID_FRIEND 
				AND sn_playerfriendcat.ID_PLAYER={$player->ID_PLAYER}
				AND sn_playerfriendcat_rel.ID_PLAYER={$player->ID_PLAYER}
				AND sn_playerfriendcat_rel.ID_CAT=sn_playerfriendcat.ID_CAT 
				AND sn_playerfriendcat.Native=2) = 0 ";
			//Not blocked by users
			$where .= 
			" AND (SELECT COUNT(*) FROM sn_playerfriendcat,sn_playerfriendcat_rel 
				WHERE sn_playerfriendcat_rel.ID_FRIEND={$player->ID_PLAYER}
				AND sn_playerfriendcat.ID_PLAYER=r.ID_FRIEND 
				AND sn_playerfriendcat_rel.ID_PLAYER=r.ID_FRIEND 
				AND sn_playerfriendcat_rel.ID_CAT=sn_playerfriendcat.ID_CAT 
				AND sn_playerfriendcat.Native=2) = 0 ";
			//No invisible users
			$where .= MainHelper::getSuspendQuery('r.ID_FRIEND');
			
			$params = array($this->ID_PLAYER);
			if ($phrase != '') {
				$where = " AND (p.FirstName LIKE ? OR p.NickName LIKE ?)";
				$params[] = "%" . $phrase . "%";
				$params[] = "%" . $phrase . "%";
			}
			//get friends friends including relationship with viewer
			$query = "SELECT SQL_CALC_FOUND_ROWS
                    	p.*, r.Mutual, r.Subscribed, r.RequestPending
                    FROM
                    	`{$this->_table}` AS p
                    INNER JOIN `{$friendsRel->_table}` AS r ON p.ID_PLAYER = r.ID_FRIEND
                    WHERE r.ID_PLAYER = ? AND r.Mutual = 1 $where
                    ORDER BY r.Mutual, p.FirstName ASC
                    ";

			if ($limit != 0) {
				$query .= " LIMIT $limit";
			}

			$friends = Doo::db()->fetchAll($query, $params);
		}
		/* THIS IS SHIT BY RICHARD AND NEED TO BE FIXED */
		if (!empty($friends) and ($player or !$personal)) {
			$ids = array();
			$friends2Extended = array();
			foreach ($friends as $fr) {
				$ids[] = $fr['ID_PLAYER'];
				$friends2Extended[$fr['ID_PLAYER']] = $fr;
			}

			$where = '';
			if ($friendcatID!=0)
			{
				$where .= " AND r.ID_FRIEND in (select ID_FRIEND from sn_playerfriendcat_rel WHERE ID_PLAYER={$player->ID_PLAYER} AND ID_CAT={$friendcatID}) ";
			}

			//No blocked users
			$where .= 
			" AND (SELECT COUNT(*) FROM sn_playerfriendcat,sn_playerfriendcat_rel 
				WHERE sn_playerfriendcat_rel.ID_FRIEND=r.ID_FRIEND 
				AND sn_playerfriendcat.ID_PLAYER={$player->ID_PLAYER}
				AND sn_playerfriendcat_rel.ID_PLAYER={$player->ID_PLAYER}
				AND sn_playerfriendcat_rel.ID_CAT=sn_playerfriendcat.ID_CAT 
				AND sn_playerfriendcat.Native=2) = 0 ";
			//Not blocked by users
			$where .= 
			" AND (SELECT COUNT(*) FROM sn_playerfriendcat,sn_playerfriendcat_rel 
				WHERE sn_playerfriendcat_rel.ID_FRIEND={$player->ID_PLAYER}
				AND sn_playerfriendcat.ID_PLAYER=r.ID_FRIEND 
				AND sn_playerfriendcat_rel.ID_PLAYER=r.ID_FRIEND 
				AND sn_playerfriendcat_rel.ID_CAT=sn_playerfriendcat.ID_CAT 
				AND sn_playerfriendcat.Native=2) = 0 ";
			//No invisible users
			$where .= MainHelper::getSuspendQuery('r.ID_FRIEND');
			
			$query = "SELECT
                        	p.ID_PLAYER, r.Mutual, r.Subscribed, r.RequestPending
                        FROM
                        	`{$this->_table}` AS p
                        INNER JOIN `{$friendsRel->_table}` AS r ON p.ID_PLAYER = r.ID_FRIEND
                        WHERE r.ID_PLAYER = ? AND r.ID_FRIEND IN ('" . implode("','", $ids) . "') 
						$where 
                        ORDER BY r.Mutual, p.FirstName ASC";

			$friendsRelationToViewer = Doo::db()->fetchAll($query, array($player->ID_PLAYER));


			if (!empty($friendsRelationToViewer)) {
				foreach ($friendsRelationToViewer as $fr) {
					if (isset($friends2Extended[$fr['ID_PLAYER']])) {
						$friends2Extended[$fr['ID_PLAYER']]['viewerRelation'] = (object) $fr;
					}
				}
				$friends = $friends2Extended;
				$friends2Extended = null;
			}
		}

		return $friends;
	}

	public function getMutual($friendId) {
		$friendsRel = new FriendsRel();
		$player = User::getUser();
		$mutuals = array();
		if ($player) {
			$params = array();
			$params['select'] = "{$friendsRel->_table}.ID_FRIEND";
			$params['where'] = "{$friendsRel->_table}.ID_PLAYER = ? AND {$friendsRel->_table}.Mutual = 1";
			$params['param'] = array($player->ID_PLAYER);

			$oIDs = Doo::db()->find('FriendsRel', $params);

			$params['param'] = array($friendId);
			$fIDs = Doo::db()->find('FriendsRel', $params);

			$mutualIDS = array();

			foreach ($oIDs as $id) {
				foreach ($fIDs as $fid) {
					if ($id->ID_FRIEND == $fid->ID_FRIEND)
						$mutualIDS[] = $id->ID_FRIEND;
				}
			}

			$params = array();
			//$params['select'] = "{$friendsRel->_table}.ID_PLAYER";
			$params['where'] = "{$player->_table}.ID_PLAYER IN ('" . implode("','", $mutualIDS) . "')";
			//$params['param'] = array($player->ID_PLAYER);

			$mutuals = Doo::db()->find('Players', $params);
		}

		return $mutuals;
	}

	/**
	 * Returns SnNotifications of player or viewers
	 *
	 * @return SnNotifications collection
	 */
	public function getNotifications($limit = 0, $phrase = array()) {
		$this->purgeCache();

		$where = 'ID_PLAYER = ? AND (isRead = 0 OR LastReadTime > ?)';
		$params = array($this->ID_PLAYER, Doo::conf()->notificationHistory);
		if (!empty($phrase)) {
			$where .= ' AND (NotificationType = "' . implode('" OR NotificationType = "', $phrase) . '")';
		}

		$p = array('select' => "*",
			'desc' => 'NotificationTime',
			'where' => $where,
			'param' => $params,
			'limit' => $limit
		);

		$notifications = Doo::db()->find('SnNotifications', $p);

		return $notifications;
	}

	/**
	 * Returns notifications count
	 *
	 * @return int
	 */
	public function getNotificationsCount($phrase = array()) {
		$this->purgeCache();

		$where = 'ID_PLAYER = ? AND (isRead = 0 OR LastReadTime > ?)';
		$params = array($this->ID_PLAYER, Doo::conf()->notificationHistory);
		if (!empty($phrase)) {
			$where .= ' AND (NotificationType = "' . implode('" OR NotificationType = "', $phrase) . '")';
		}

		$p = array('select' => "COUNT(1) as total",
			'where' => $where,
			'param' => $params,
			'limit' => 1
		);
		$notifications = Doo::db()->find('SnNotifications', $p);
		return $notifications->total;
	}

	/**
	 * Checks if players is friend 
	 *
	 * @param int $friendID
	 * @return boolean
	 */
	public function isFriend($friendID) {
		$friendsRel = new FriendsRel();
		$friendsRel->ID_PLAYER = $this->ID_PLAYER;
		$friendsRel->ID_FRIEND = $friendID;
		$friendsRel = $friendsRel->getOne();

		if ($friendsRel) {
			if ($friendsRel->Mutual == 1)
				return TRUE;

			//if friend request has been sent  
			if ($friendsRel->RequestPending == 1)
				return TRUE;
		}
		return FALSE;
	}

	/**
	 * Checks if player is subscribed to friend 
	 *
	 * @param int $friendID
	 * @return boolean
	 */
	public function isSubscribed($friendID) {
		$friendsRel = new FriendsRel();
		$friendsRel->ID_PLAYER = $this->ID_PLAYER;
		$friendsRel->ID_FRIEND = $friendID;
		$friendsRel->Subscribed = 1;
		$friendsRel = $friendsRel->getOne();

		if ($friendsRel) {
			return TRUE;
		}
		return FALSE;
	}

    /**
     * Checks if player is subscribed to platform
     *
     * @return unknown
     */
    public static function isPlatformSubscribed($id, $type) {
        $p = User::getUser();
        if ($p) {
            $relation = new SnPlayerSubscribtionRel();
            $relation->ID_PLAYER = $p->ID_PLAYER;
            $relation->ID_ITEM = $id;
            $relation->ItemType = $type;
            $relation = $relation->getOne();
            if ($relation)
                return TRUE;
        }
        return FALSE;
    }

	/**
	 * Updates players profile info
	 *
	 * @param array $params
	 * @return void
	 */
	public function updateProfile($params, $same = true) {
		extract($params);

		if (isset($firstName)) {
			$this->FirstName = ContentHelper::handleContentInput($firstName);
		}

		if (isset($lastName)) {
			$this->LastName = ContentHelper::handleContentInput($lastName);
		}
		
		if (isset($displayName)) {
			$this->DisplayName = ContentHelper::handleContentInput($displayName);
		}
		
		if (isset($email)) {
			$this->EMail = ContentHelper::handleContentInput($email);
		}

		if (isset($address)) {
			$this->Address = ContentHelper::handleContentInput($address);
		}

		if (isset($city)) {
			$this->City = ContentHelper::handleContentInput($city);
		}

		if (isset($zip)) {
			$this->Zip = ContentHelper::handleContentInput($zip);
		}

		if (isset($country)) {
			$this->Country = ContentHelper::handleContentInput($country);
		}

		if (isset($phone)) {
			$this->Phone = ContentHelper::handleContentInput($phone);
		}

		if (isset($nickname)) {
			$this->NickName = ContentHelper::handleContentInput($nickname);
		}

		if (isset($ID_TIMEZONE)) {

			$this->ID_TIMEZONE = ContentHelper::handleContentInput($ID_TIMEZONE);

			$zones = MainHelper::getTimeZoneList();
			foreach ($zones as $zone) {
				if ($zone->ID_TIMEZONE == $ID_TIMEZONE) {
					$timezone = $zone->Offset;
				}
			}
		}
		
		if (isset($timezone)) {
			$this->TimeOffset = ContentHelper::handleContentInput($timezone);
		}
		
		if(isset($daylight)){
			if(isset($dst) && $dst == 1){
				$this->DSTOffset = 3600;
			}
			else{
				$this->DSTOffset = 0;
			}
		}

		if (isset($groupLimit)) {
			$this->GroupLimit = intval($groupLimit);
		}
		
		if (isset($imageLimit)) {
			$this->ImageLimit = intval($imageLimit);
		}
		
		if (isset($freeGameLimit)) {
			$this->FreeGameLimit = intval($freeGameLimit);
		}
		
		if (isset($noAdsTime)) {
			$this->NoAdsTime = intval($noAdsTime);
		}
		
		if (isset($credits)) {
			$this->Credits = intval($credits);
		}

		if (isset($playCredits)) {
			$this->PlayCredits = intval($playCredits);
		}

		if (isset($pass) && mb_strlen($pass) >= 8) {
			$this->Password = md5(md5($pass));
		}

		if (isset($isReferrer)) {
			$this->isReferrer = $isReferrer;
		}

		if (isset($canCreateReferrers)) {
			$this->canCreateReferrers = $canCreateReferrers;
		}
		
		if (isset($usergroup)) {
			$this->ID_USERGROUP = intval($usergroup);
		}
                
                if (isset($blogger)) {
			if(isset($hasBlog) && $hasBlog == 1){
				$this->hasBlog = 1;
			}
			else{
				$this->hasBlog = 0;
			}
		}

		if (isset($mainLanguage) and intval($mainLanguage) > 0) {
			$language = Lang::getLanguages();
			foreach ($language as $l) {
				if ($l->ID_LANGUAGE == $mainLanguage) {
					$this->ID_LANGUAGE = $mainLanguage;
					if($same == TRUE) {
						Lang::setLang(Doo::conf()->lang[$l->ID_LANGUAGE]);
					}
					break;
				}
			}
		}

		if (isset($addLangs)) {
			$acceptedLangs = array();
			$language = Lang::getLanguages();
			$langIDS = array();
			foreach ($language as $l) {
				$langIDS[] = $l->ID_LANGUAGE;
			}
			foreach ($addLangs as $lang) {
				if (in_array(intval($lang), $langIDS)) {
					$acceptedLangs[] = $lang;
				}
			}
			$this->OtherLanguages = implode(",", $acceptedLangs);
		}

		if (isset($year) and isset($month) and isset($day)) {
			$y = '0000';
			$m = '00';
			$d = '00';
			if ($year > 0)
				$y = intval($year);
			if ($month > 0)
				$m = intval($month);
			if ($day > 0)
				$d = intval($day);

			$this->DateOfBirth = $y . '-' . $m . '-' . $d;
		}

		$this->update();
		$this->purgeCache();
	}

	/**
	 * Request for email change
	 *
	 */
	public function newPassRequest() {
		$this->PassRequest = md5(time() * microtime());
		$this->update(array('field' => 'PassRequest'));
	}

	/**
	 * Rejects friend request
	 *
	 * @return boolean
	 */
	public function rejectFriend($friendID) {
		$friendID = intval($friendID);
		if ($friendID <= 0)
			return FALSE;

		$friendRelDelete = new FriendsRelDelete();
		$friendRelDelete->ID_FRIEND = $friendID;
		$friendRelDelete->ID_PLAYER = $this->ID_PLAYER;
		$friendRelDelete->OtherRequest = 1;
		$friendRelDelete->insert();

		$friendRelDelete = new FriendsRelDelete();
		$friendRelDelete->ID_FRIEND = $friendID;
		$friendRelDelete->ID_PLAYER = $this->ID_PLAYER;
		$friendRelDelete->delete();

		$this->purgeCache();
		return TRUE;
	}

	/**
	 * Adds friend request
	 *
	 * @return boolean
	 */
	public function sendFriendRequest($friendID) {
		$friendID = intval($friendID);
		if ($friendID <= 0)
			return FALSE;

		$friendRelInsert = new FriendsRelInsert();
		$friendRelInsert->ID_FRIEND = $friendID;
		$friendRelInsert->ID_PLAYER = $this->ID_PLAYER;
		$friendRelInsert->Request = 1;
		$friendRelInsert->insert();

		$friendRelInsert = new FriendsRelInsert();
		$friendRelInsert->ID_FRIEND = $friendID;
		$friendRelInsert->ID_PLAYER = $this->ID_PLAYER;
		$friendRelInsert->delete();

		$this->purgeCache();
		return TRUE;
	}

	/**
	 * Toggles subscription to friend
	 * 
	 * @return boolean
	 */
	public function toggleSubscribeToFriend($friendID) {
		$friendID = intval($friendID);
		if ($friendID <= 0)
			return FALSE;

		$add = FALSE;
		$relation = new FriendsRel();
		$relation->ID_FRIEND = $friendID;
		$relation->ID_PLAYER = $this->ID_PLAYER;
		$relation = $relation->getOne();

		if ($relation) {
			if (!$relation->Subscribed == 1) {
				$add = TRUE;
			}
		} else {
			$add = TRUE;
		}

		if ($add == true) {
			$friendRelInsert = new FriendsRelInsert();
			$friendRelInsert->ID_FRIEND = $friendID;
			$friendRelInsert->ID_PLAYER = $this->ID_PLAYER;
			$friendRelInsert->Subscribed = 1;
			$friendRelInsert->insert();

			$friendRelInsert = new FriendsRelInsert();
			$friendRelInsert->ID_FRIEND = $friendID;
			$friendRelInsert->ID_PLAYER = $this->ID_PLAYER;
			$friendRelInsert->delete();
		} else {
			$friendRelDelete = new FriendsRelDelete();
			$friendRelDelete->ID_FRIEND = $friendID;
			$friendRelDelete->ID_PLAYER = $this->ID_PLAYER;
			$friendRelDelete->Subscribed = 1;
			$friendRelDelete->insert();

			$friendRelDelete = new FriendsRelDelete();
			$friendRelDelete->ID_FRIEND = $friendID;
			$friendRelDelete->ID_PLAYER = $this->ID_PLAYER;
			$friendRelDelete->delete();
		}
		$this->purgeCache();

		return TRUE;
	}

	/**
	 * Toggles subscription to newsitem
	 * 
	 * @return boolean
	 */
	public function toggleSubscribeToNewsItem($postID) {
		$postID = intval($postID);
		if ($postID <= 0)
			return FALSE;

		$add = TRUE;
		$relation = new NwPlayerNewsRel();
		$relation->ID_NEWS = $postID;
		$relation->ID_PLAYER = $this->ID_PLAYER;
		$relation = $relation->getOne();

		if ($relation) {
			$add = FALSE;
		}

		if ($add == true) {
			$relation = new NwPlayerNewsRel();
			$relation->ID_NEWS = $postID;
			$relation->ID_PLAYER = $this->ID_PLAYER;
			$relation->isSubscribed = 1;
			$relation->insert();
		} else {
			if ($relation->isSubscribed == 1) {
				$relation->isSubscribed = 0;
			} else {
				$relation->isSubscribed = 1;
			}

			$relation->update(array('field' => 'isSubscribed',
				'where' => 'ID_PLAYER = ? AND ID_NEWS = ?',
				'param' => array($this->ID_PLAYER, $postID)
			));
		}
		$this->purgeCache();

		return TRUE;
	}

	public function applyGroup($id) {
		$pgr = new SnPlayerGroupRel();

		$pgr->ID_GROUP = $id;
		$pgr->ID_PLAYER = $this->ID_PLAYER;

		$rel = $pgr->getOne();

		if ($rel) {
			$rel->hasApplied = 1;
			$rel->update(array(
				'where' => 'ID_PLAYER = ? AND ID_GROUP = ?',
				'param' => array($rel->ID_PLAYER, $rel->ID_GROUP)
			));
		} else {
			$pgr = new SnPlayerGroupRel();
			$pgr->ID_PLAYER = $this->ID_PLAYER;
			$pgr->ID_GROUP = $id;
			$pgr->hasApplied = 1;
			$pgr->insert();
		}
	}

	/**
	 * Toggles isPlaying to game 
	 * 
	 * @return boolean
	 */
	public function toggleIsPlayingGame($gameID) {
		$gameID = intval($gameID);
		if ($gameID <= 0)
			return FALSE;

		$add = TRUE;
		$relation = new SnPlayerGameRel();
		$relation->ID_GAME = $gameID;
		$relation->ID_PLAYER = $this->ID_PLAYER;
		$relation = $relation->getOne();

		if ($relation) {
			$add = FALSE;
		}

		if ($add == true) {
			$relation = new SnPlayerGameRel();
			$relation->ID_GAME = $gameID;
			$relation->ID_PLAYER = $this->ID_PLAYER;
			$relation->isPlaying = 1;
			$relation->insert();
		} else {
			if ($relation->isPlaying == 1) {
				$relation->isPlaying = 0;
			} else {
				$relation->isPlaying = 1;
			}
			$relation->Comments = '';

			$relation->update(array('field' => 'isPlaying,Comments',
				'where' => 'ID_PLAYER = ? AND ID_GAME = ?',
				'param' => array($this->ID_PLAYER, $gameID)
			));
		}
		$this->purgeCache();

		return TRUE;
	}

	/**
	 * Toggles subscription to game news
	 * 
	 * @return boolean
	 */
	public function toggleSubscribeToGame($gameID) {
		$gameID = intval($gameID);
		if ($gameID <= 0)
			return FALSE;

		$add = TRUE;
		$relation = new SnPlayerGameRel();
		$relation->ID_GAME = $gameID;
		$relation->ID_PLAYER = $this->ID_PLAYER;
		$relation = $relation->getOne();

		if ($relation) {
			$add = FALSE;
		}
		if ($add == true) {
			$relation = new SnPlayerGameRel();
			$relation->ID_GAME = $gameID;
			$relation->ID_PLAYER = $this->ID_PLAYER;
			$relation->isSubscribed = 1;
			$relation->insert();
		} else {
			if ($relation->isSubscribed == 0) {
				$relation->isSubscribed = 1;
			} else {
				$relation->isSubscribed = 0;
			}
			$relation->update(array('field' => 'isSubscribed',
				'where' => 'ID_PLAYER = ? AND ID_GAME = ?',
				'param' => array($this->ID_PLAYER, $gameID)
			));
			$relation->purgeCache();
		}
		$this->purgeCache();

		return TRUE;
	}

	/**
	 * Toggles subscription to game news by platform
	 * 
	 * @return boolean
	 */
	public function toggleSubscribeToPlatform($platformID) {
		$platformID = intval($platformID);
		if ($platformID <= 0)
			return FALSE;

		$add = TRUE;
		$relation = new SnPlayerSubscribtionRel();
		$relation->ID_PLAYER = $this->ID_PLAYER;
		$relation->ID_ITEM = $platformID;
		$relation->ItemType = 'platform';
		$relation = $relation->getOne();

		if ($relation) {
			$add = FALSE;
		}
		if ($add == true) {
			$relation = new SnPlayerSubscribtionRel();
			$relation->ID_PLAYER = $this->ID_PLAYER;
			$relation->ID_ITEM = $platformID;
			$relation->ItemType = 'platform';
			$relation->insert();
		} else {
			$relation->delete();
		}
		$this->purgeCache();

		return TRUE;
	}

	public function toggleSubscribeToEvent($eventID) {
		$eventID = intval($eventID);
		if ($eventID <= 0)
			return FALSE;

		$add = TRUE;


		$participants = new EvParticipants;
		$participants->ID_EVENT = $eventID;
		$participants->ID_PLAYER = $this->ID_PLAYER;
		$participants->purgeCache();
		$participants = $participants->getOne();

		if ($participants) {
			$add = FALSE;
		}
		if ($add == true) {
			$participants = new EvParticipants;
			$participants->ID_EVENT = $eventID;
			$participants->ID_PLAYER = $this->ID_PLAYER;
			$participants->isParticipating = 0;
			$participants->isSubscribed = 1;
			$participants->insert();
		} else {
			if ($participants->isSubscribed == 0) {
				$participants->isSubscribed = 1;
			} else {
				$participants->isSubscribed = 0;
			}
			$participants->update(array('field' => 'isSubscribed',
				'where' => 'ID_PLAYER = ? AND ID_EVENT = ?',
				'param' => array($this->ID_PLAYER, $eventID)
			));
			$participants->purgeCache();
		}
		$this->purgeCache();

		return TRUE;
	}

	/**
	 * Toggles like to company
	 * 
	 * @return boolean
	 */
	public function toggleLikeGame($gameID) {
		$gameID = intval($gameID);
		if ($gameID <= 0)
			return FALSE;

		$add = TRUE;
		$relation = new SnPlayerGameRel();
		$relation->ID_GAME = $gameID;
		$relation->ID_PLAYER = $this->ID_PLAYER;
		$relation->purgeCache();
		$relation = $relation->getOne();

		if ($relation) {
			$add = FALSE;
		}
		if ($add == true) {
			$relation = new SnPlayerGameRel();
			$relation->ID_GAME = $gameID;
			$relation->ID_PLAYER = $this->ID_PLAYER;
			$relation->isLiked = 1;
			$relation->insert();
		} else {
			if ($relation->isLiked == 0 or $relation->isLiked == -1) {
				$relation->isLiked = 1;
			} else {
				$relation->isLiked = -1;
			}
			$relation->update(array('field' => 'isLiked',
				'where' => 'ID_PLAYER = ? AND ID_GAME= ?',
				'param' => array($this->ID_PLAYER, $gameID)
			));
			$relation->purgeCache();
		}
		$this->purgeCache();

		return TRUE;
	}

	/**
	 * Toggles subscription to company news
	 * 
	 * @return boolean
	 */
	public function toggleSubscribeToCompany($companyID) {
		$companyID = intval($companyID);
		if ($companyID <= 0)
			return FALSE;

		$add = TRUE;
		$relation = new SnPlayerCompanyRel();
		$relation->ID_COMPANY = $companyID;
		$relation->ID_PLAYER = $this->ID_PLAYER;
		$relation->purgeCache();
		$relation = $relation->getOne();

		if ($relation) {
			$add = FALSE;
		}
		if ($add == true) {
			$relation = new SnPlayerCompanyRel();
			$relation->ID_COMPANY = $companyID;
			$relation->ID_PLAYER = $this->ID_PLAYER;
			$relation->isSubscribed = 1;
			$relation->insert();
		} else {
			if ($relation->isSubscribed == 0) {
				$relation->isSubscribed = 1;
			} else {
				$relation->isSubscribed = 0;
			}
			$relation->update(array('field' => 'isSubscribed',
				'where' => 'ID_PLAYER = ? AND ID_COMPANY = ?',
				'param' => array($this->ID_PLAYER, $companyID)
			));
			$relation->purgeCache();
		}
		$this->purgeCache();

		return TRUE;
	}

	/**
	 * Toggles like to company
	 * 
	 * @return boolean
	 */
	public function toggleLikeCompany($companyID) {
		$companyID = intval($companyID);
		if ($companyID <= 0)
			return FALSE;

		$add = TRUE;
		$relation = new SnPlayerCompanyRel();
		$relation->ID_COMPANY = $companyID;
		$relation->ID_PLAYER = $this->ID_PLAYER;
		$relation->purgeCache();
		$relation = $relation->getOne();

		if ($relation) {
			$add = FALSE;
		}
		if ($add == true) {
			$relation = new SnPlayerCompanyRel();
			$relation->ID_COMPANY = $companyID;
			$relation->ID_PLAYER = $this->ID_PLAYER;
			$relation->isLiked = 1;
			$relation->insert();
		} else {
			if ($relation->isLiked == 0 or $relation->isLiked == -1) {
				$relation->isLiked = 1;
			} else {
				$relation->isLiked = -1;
			}
			$relation->update(array('field' => 'isLiked',
				'where' => 'ID_PLAYER = ? AND ID_COMPANY = ?',
				'param' => array($this->ID_PLAYER, $companyID)
			));
			$relation->purgeCache();
		}
		$this->purgeCache();

		return TRUE;
	}
	/**
	 * Toggles subscription to fanclub news
	 * 
	 * @return boolean
	 */
	public function toggleSubscribeToFanclub($fanclubID) {
		$fanclubID = intval($fanclubID);
		if ($fanclubID <= 0)
			return FALSE;

		$add = TRUE;
		$relation = new SnPlayerFanclubRel();
		$relation->ID_FANCLUB = $fanclubID;
		$relation->ID_PLAYER = $this->ID_PLAYER;
		$relation->purgeCache();
		$relation = $relation->getOne();

		if ($relation) {
			$add = FALSE;
		}
		if ($add == true) {
			$relation = new SnPlayerFanclubRel();
			$relation->ID_FANCLUB = $fanclubID;
			$relation->ID_PLAYER = $this->ID_PLAYER;
			$relation->isSubscribed = 1;
			$relation->insert();
		} else {
			if ($relation->isSubscribed == 0) {
				$relation->isSubscribed = 1;
			} else {
				$relation->isSubscribed = 0;
			}
			$relation->update(array('field' => 'isSubscribed',
				'where' => 'ID_PLAYER = ? AND ID_FANCLUB = ?',
				'param' => array($this->ID_PLAYER, $fanclubID)
			));
			$relation->purgeCache();
		}
		$this->purgeCache();

		return TRUE;
	}

	/**
	 * Toggles like to company
	 * 
	 * @return boolean
	 */
	public function toggleLikeFanclub($fanclubID) {
		$fanclubID = intval($fanclubID);
		if ($fanclubID <= 0)
			return FALSE;

		$add = TRUE;
		$relation = new SnPlayerFanclubRel();
		$relation->ID_FANCLUB = $fanclubID;
		$relation->ID_PLAYER = $this->ID_PLAYER;
		$relation->purgeCache();
		$relation = $relation->getOne();

		if ($relation) {
			$add = FALSE;
		}
		if ($add == true) {
			$relation = new SnPlayerFanclubRel();
			$relation->ID_FANCLUB = $fanclubID;
			$relation->ID_PLAYER = $this->ID_PLAYER;
			$relation->isLiked = 1;
			$relation->insert();
		} else {
			if ($relation->isLiked == 0 or $relation->isLiked == -1) {
				$relation->isLiked = 1;
			} else {
				$relation->isLiked = -1;
			}
			$relation->update(array('field' => 'isLiked',
				'where' => 'ID_PLAYER = ? AND ID_FANCLUB = ?',
				'param' => array($this->ID_PLAYER, $fanclubID)
			));
			$relation->purgeCache();
		}
		$this->purgeCache();

		return TRUE;
	}

	public function toggleSubscribeToTopic($type, $id, $boardId, $topicID) {
		$topicID = intval($topicID);
		if ($topicID <= 0)
			return FALSE;

		$add = TRUE;
		$relation = new FmNotify();
		$relation->ID_TOPIC = $topicID;
		$relation->ID_PLAYER = $this->ID_PLAYER;
		$relation->ID_OWNER = $id;
		$relation->ID_BOARD = $boardId;
		$relation->OwnerType = $type;

		$relation = $relation->getOne();

		if ($relation) {
			$add = FALSE;
		}

		if ($add == true) {
			$relation = new FmNotify();
			$relation->ID_TOPIC = $topicID;
			$relation->ID_PLAYER = $this->ID_PLAYER;
			$relation->ID_OWNER = $id;
			$relation->OwnerType = $type;
			$relation->ID_BOARD = $boardId;
			$relation->insert();
		} else {
			$relation->delete();
		}
		$this->purgeCache();

		return TRUE;
	}

	public function toggleSubscribeToBoard($type, $id, $boardId) {
		$boardId = intval($boardId);
		if ($boardId <= 0)
			return FALSE;

		$add = TRUE;
		$relation = new FmNotify();
		$relation->ID_PLAYER = $this->ID_PLAYER;
		$relation->ID_OWNER = $id;
		$relation->ID_BOARD = $boardId;
		$relation->OwnerType = $type;

		$relation = $relation->getOne();

		if ($relation) {
			$add = FALSE;
		}

		if ($add == true) {
			$relation = new FmNotify();
			$relation->ID_PLAYER = $this->ID_PLAYER;
			$relation->ID_OWNER = $id;
			$relation->OwnerType = $type;
			$relation->ID_BOARD = $boardId;
			$relation->insert();
		} else {
			$relation->delete();
		}
		$this->purgeCache();

		return TRUE;
	}

	public function toggleSubscribeToGameForum($id) {
		$id = intval($id);
		if ($id <= 0)
			return FALSE;

		$add = TRUE;
		$relation = new SnPlayerGameRel();
		$relation->ID_GAME = $id;
		$relation->ID_PLAYER = $this->ID_PLAYER;
		$relation->purgeCache();
		$relation = $relation->getOne();

		if ($relation) {
			$add = FALSE;
		}
		if ($add == true) {
			$relation = new SnPlayerGameRel();
			$relation->ID_GAME = $id;
			$relation->ID_PLAYER = $this->ID_PLAYER;
			$relation->isMember = 1;
			$relation->insert();
		} else {
			if ($relation->isMember == 0) {
				$relation->isMember = 1;
			} else {
				$relation->isMember = 0;
			}
			$relation->update(array('field' => 'isMember',
				'where' => 'ID_PLAYER = ? AND ID_GAME = ?',
				'param' => array($this->ID_PLAYER, $id)
			));
			$relation->purgeCache();
		}
		$this->purgeCache();

		return TRUE;
	}

	public function toggleSubscribeToCompanyForum($id) {
		$id = intval($id);
		if ($id <= 0)
			return FALSE;

		$add = TRUE;
		$relation = new SnPlayerCompanyRel();
		$relation->ID_COMPANY = $id;
		$relation->ID_PLAYER = $this->ID_PLAYER;
		$relation->purgeCache();
		$relation = $relation->getOne();

		if ($relation) {
			$add = FALSE;
		}
		if ($add == true) {
			$relation = new SnPlayerCompanyRel();
			$relation->ID_COMPANY = $id;
			$relation->ID_PLAYER = $this->ID_PLAYER;
			$relation->isMember = 1;
			$relation->insert();
		} else {
			if ($relation->isMember == 0) {
				$relation->isMember = 1;
			} else {
				$relation->isMember = 0;
			}
			$relation->update(array('field' => 'isMember',
				'where' => 'ID_PLAYER = ? AND ID_COMPANY = ?',
				'param' => array($this->ID_PLAYER, $id)
			));
			$relation->purgeCache();
		}
		$this->purgeCache();

		return TRUE;
	}

	public function toggleSubscribeToGroupForum($id) {
		$id = intval($id);
		if ($id <= 0)
			return FALSE;

		$add = TRUE;
		$relation = new SnPlayerGroupRel();
		$relation->ID_GROUP = $id;
		$relation->ID_PLAYER = $this->ID_PLAYER;
		$relation->purgeCache();
		$relation = $relation->getOne();

		if ($relation) {
			$add = FALSE;
		}
		if ($add == true) {
			$relation = new SnPlayerGroupRel();
			$relation->ID_GROUP = $id;
			$relation->ID_PLAYER = $this->ID_PLAYER;
			$relation->isMember = 1;
			$relation->insert();
		} else {
			if ($relation->isMember == 0) {
				$relation->isMember = 1;
			} else {
				$relation->isMember = 0;
			}
			$relation->update(array('field' => 'isMember',
				'where' => 'ID_PLAYER = ? AND ID_GROUP = ?',
				'param' => array($this->ID_PLAYER, $id)
			));
			$relation->purgeCache();
		}
		$this->purgeCache();

		return TRUE;
	}

	/**
	 * Toggles subscription to company news
	 * 
	 * @return boolean
	 */
	public function toggleSubscribeToGroup($groupID) {
		$groupID = intval($groupID);
		if ($groupID <= 0)
			return FALSE;

		$add = TRUE;
		$relation = new SnPlayerGroupRel();
		$relation->ID_GROUP = $groupID;
		$relation->ID_PLAYER = $this->ID_PLAYER;
		$relation->purgeCache();
		$relation = $relation->getOne();

		if ($relation) {
			$add = FALSE;
		}
		if ($add == true) {
			$relation = new SnPlayerGroupRel();
			$relation->ID_GROUP = $groupID;
			$relation->ID_PLAYER = $this->ID_PLAYER;
			$relation->isSubscribed = 1;
			$relation->insert();
		} else {
			if ($relation->isSubscribed == 0) {
				$relation->isSubscribed = 1;
			} else {
				$relation->isSubscribed = 0;
			}
			$relation->update(array('field' => 'isSubscribed',
				'where' => 'ID_PLAYER = ? AND ID_GROUP = ?',
				'param' => array($this->ID_PLAYER, $groupID)
			));
			$relation->purgeCache();
		}
		$this->purgeCache();

		return TRUE;
	}

	/**
	 * Toggles like to company
	 * 
	 * @return boolean
	 */
	public function toggleLikeGroup($groupID) {
		$groupID = intval($groupID);
		if ($groupID <= 0)
			return FALSE;

		$add = TRUE;
		$relation = new SnPlayerGroupRel();
		$relation->ID_GROUP = $groupID;
		$relation->ID_PLAYER = $this->ID_PLAYER;
		$relation->purgeCache();
		$relation = $relation->getOne();

		if ($relation) {
			$add = FALSE;
		}
		if ($add == true) {
			$relation = new SnPlayerGroupRel();
			$relation->ID_GROUP = $groupID;
			$relation->ID_PLAYER = $this->ID_PLAYER;
			$relation->isLiked = 1;
			$relation->insert();
		} else {
			if ($relation->isLiked == 0 or $relation->isLiked == -1) {
				$relation->isLiked = 1;
			} else {
				$relation->isLiked = -1;
			}
			$relation->update(array('field' => 'isLiked',
				'where' => 'ID_PLAYER = ? AND ID_GROUP = ?',
				'param' => array($this->ID_PLAYER, $groupID)
			));
			$relation->purgeCache();
		}
		$this->purgeCache();

		return TRUE;
	}

	/**
	 * Delete friend
	 *
	 * @return boolean
	 */
	public function friendDelete($friendID) {
		$friendID = intval($friendID);
		if ($friendID <= 0)
			return FALSE;

		$friendRelDelete = new FriendsRelDelete();
		$friendRelDelete->ID_FRIEND = $friendID;
		$friendRelDelete->ID_PLAYER = $this->ID_PLAYER;
		$friendRelDelete->Mutual = 1;
		$friendRelDelete->insert();

		$friendRelDelete = new FriendsRelDelete();
		$friendRelDelete->ID_FRIEND = $friendID;
		$friendRelDelete->ID_PLAYER = $this->ID_PLAYER;
		$friendRelDelete->delete();

		$this->purgeCache();
		return TRUE;
	}
	
	/**
	 * Delete player suggestion
	 *
	 * @return boolean
	 */
	public function playerSuggestionHide($suggestedID) {
		
		$level2Players = new SnLevel2Friends();
		$level2Players->isHidden = 1;
		
		$level2Players->update(array(
			'field' => 'isHidden',
			'where' => 'ID_PLAYER = ? AND ID_LEVEL2FRIEND = ?',
			'param' => array($this->ID_PLAYER, $suggestedID)
		));
		
		return TRUE;
	}

	/**
	 * Returns messages by type (inbox, sent)
	 *
	 * @param String $type
	 * @return FmPersonalMessages collection
	 */
	public function getMessages($type = 'inbox', $limit = 0, $phrase = '') {
		$pmr = new FmPersonalMessagesRecipients();
		$pm = new FmPersonalMessages();

		$params['select'] = "{$this->_table}.*, {$pm->_table}.*, {$pmr->_table}.isRead, COUNT({$pm->_table}.ID_PLAYER_FROM) AS `cnt`";
		$params['desc'] = "{$pm->_table}.MsgTime";
		$params['limit'] = $limit;
		$params['groupby'] = "{$pm->_table}.ID_PLAYER_FROM";

		if ($type == 'inbox') {
			$where = "{$pmr->_table}.ID_PLAYER = ? AND {$pmr->_table}.isDeleted = 0";
			$param = array($this->ID_PLAYER);

			$params['filters'][] = array('model' => "FmPersonalMessagesRecipients",
				'joinType' => "INNER",
				'where' => $where,
				'param' => $param
			);

			$params['filters'][] = array('model' => "Players",
				'joinType' => "INNER"
			);
			$messages = Doo::db()->find('FmPersonalMessages', $params);

		} else {
			$where = "";
			$param = array($this->ID_PLAYER);
			if ($phrase != '') {
				$where .= " AND {$pm->_table}.Body LIKE ?";
				$param[] = '%' . $phrase . '%';
			}

			$query = "SELECT SQL_CALC_FOUND_ROWS 
                        	{$pm->_table}.*,  {$this->_table}.*
                        FROM
                        	`{$pm->_table}`
                        INNER JOIN {$pmr->_table} ON {$pm->_table}.ID_PM = {$pmr->_table}.ID_PM
                        INNER JOIN {$this->_table} ON {$pmr->_table}.ID_PLAYER = {$this->_table}.ID_PLAYER
                        WHERE
                        	{$pm->_table}.ID_PLAYER_FROM = ?
                        AND {$pm->_table}.DeletedBySender = 0
                        AND {$pmr->_table}.isDeleted = 0
                        AND {$this->_table}.ID_PLAYER = {$pmr->_table}.ID_PLAYER
                        {$where}
                        GROUP BY
                        	{$pm->_table}.ID_PM
                        ORDER BY {$pm->_table}.MsgTime DESC
                        LIMIT $limit, " . Doo::conf()->messagesLimit;
			$rs = Doo::db()->query($query, $param);
			$messages = $rs->fetchAll(PDO::FETCH_CLASS, 'FmPersonalMessages');
			if ($phrase != '') {
				$rs = Doo::db()->query('SELECT FOUND_ROWS() as total');
				$total = $rs->fetch();

				$return['total'] = $total['total'];
				$return['messages'] = $messages;

				return (object) $return;
			}
		}

		return $messages;
	}

	public function getMessagesCountGrouped() {
		$pmr = new FmPersonalMessagesRecipients();
		$pm = new FmPersonalMessages();

		$params['select'] = "COUNT(DISTINCT({$pm->_table}.ID_PLAYER_FROM)) as total";
		$params['limit'] = 1;
		$params['filters'][] = array('model' => "FmPersonalMessagesRecipients",
			'joinType' => "INNER",
			'where' => "{$pmr->_table}.ID_PLAYER = ? AND {$pmr->_table}.isDeleted = 0",
			'param' => array($this->ID_PLAYER)
		);
		$results = Doo::db()->find('FmPersonalMessages', $params);
		return $results->total;
	}

	public function getMessageConversation($recipientURL, $limit = 0) {
		$friend = User::getFriend($recipientURL);
		if($friend) {
			$pmr = new FmPersonalMessagesRecipients();
			$pm = new FmPersonalMessages();

			$params['select'] = "{$this->_table}.*, {$pm->_table}.*, {$pmr->_table}.isRead";
			$params['desc'] = "{$pm->_table}.MsgTime";
			$params['filters'][] = array('model' => "FmPersonalMessagesRecipients",
				'joinType' => "INNER",
				'param' => array($this->ID_PLAYER, $friend->ID_PLAYER)
			);
			$params['where'] = "(({$pmr->_table}.ID_PLAYER = ? AND {$pm->_table}.ID_PLAYER_FROM = ?) OR ({$pmr->_table}.ID_PLAYER = ? AND {$pm->_table}.ID_PLAYER_FROM = ?)) AND {$pmr->_table}.isDeleted = 0";
			$params['param'] = array($friend->ID_PLAYER, $this->ID_PLAYER, $this->ID_PLAYER, $friend->ID_PLAYER);
			$params['filters'][] = array('model' => "Players",
				'joinType' => "INNER"
			);
			if($limit) {
				$params['limit'] = $limit;
			}
			
			$messages = Doo::db()->find("FmPersonalMessages", $params);
			return $messages;
		}
	}

	public function getMessagesCountConversation($recipientURL) {
		$friend = User::getFriend($recipientURL);
		
		if($friend) {
			$pmr = new FmPersonalMessagesRecipients();
			$pm = new FmPersonalMessages();

			$params['select'] = "COUNT(1) as total";
			$params['filters'][] = array('model' => "FmPersonalMessagesRecipients",
				'joinType' => "INNER",
				'param' => array($this->ID_PLAYER, $friend->ID_PLAYER)
			);
			$params['where'] = "(({$pmr->_table}.ID_PLAYER = ? AND {$pm->_table}.ID_PLAYER_FROM = ?) OR ({$pmr->_table}.ID_PLAYER = ? AND {$pm->_table}.ID_PLAYER_FROM = ?)) AND {$pmr->_table}.isDeleted = 0";
			$params['param'] = array($friend->ID_PLAYER, $this->ID_PLAYER, $this->ID_PLAYER, $friend->ID_PLAYER);

			$params['filters'][] = array('model' => "Players",
				'joinType' => "INNER"
			);
			$params['limit'] = 1;

			$total = Doo::db()->find("FmPersonalMessages", $params);
			return $total->total;
		} else {
			return 0;
		}
	}

	/**
	 * Sends message to recipients
	 *
	 * @return boolean
	 */
	public function sendMessage($recipients, $message, $share = false) {
		if (!empty($recipients)) {
			$friends = array();
			foreach ($recipients as $url) {
				$friend = User::getFriend($url);
				if ($friend) {
					$friends[] = $friend->ID_PLAYER;
				}
			}
			if (!empty($friends)) {
				$isShared = 0;
				$shareType = '';
				$shareId = 0;
				if($share === false)
					$message = ContentHelper::managePostEnter(ContentHelper::handleContentInput($message));
				else{
					$message = ContentHelper::manageShareEnter($message, $share['otype'], $share['oid'], $share['olang']);
					$isShared = 1;
					$shareType = $share['otype'];
					$shareId = $share['oid'];
				}
				
				$query = "CALL SendPM({$this->ID_PLAYER}, '" . implode(",", $friends) . "', 'Subject', ?, ?, ?, ?)";
				Doo::db()->query($query, array($message->content, $isShared, $shareId, $shareType));
			} else {
				return FALSE;
			}
		} else {
			return FALSE;
		}
		$this->purgeCache();
		return TRUE;
	}

	public function replyMessage($friendUrl, $message) {
		if (!empty($friendUrl)) {
			$friend = User::getFriend($friendUrl);
			$message = ContentHelper::managePostEnter(ContentHelper::handleContentInput($message));
			$query = "CALL SendPM({$this->ID_PLAYER}, '" . $friend->ID_PLAYER . "', 'Subject', ?, 0, 0, '')";
			Doo::db()->query($query, array($message->content));

			$this->purgeCache();
			return TRUE;
		}
		return false;
	}

	/**
	 * Deletes messages
	 *
	 * @return boolean
	 */
	public function deleteMessages($recipients, $type=1) {
		$type = intval($type);
		foreach ($recipients as $recipientURL) {
			$messages = $this->getMessageConversation($recipientURL);
			if($messages) {
				foreach($messages as $message) {
					$query = "CALL DeletePM({$message->ID_PM}, {$this->ID_PLAYER}, {$type})";
					Doo::db()->query($query);
				}
			}
		}

		$this->purgeCache();
		return TRUE;
	}

	/**
	 * Deletes messages
	 *
	 * @return boolean
	 */
	public function deleteAllMessages($type=1) {
		$type = intval($type);

		if ($type == 0) {
			$messages = new FmPersonalMessages();
			$messages->ID_PLAYER_FROM = $this->ID_PLAYER;
			$messages = $messages->find();
		} else {
			$messages = new FmPersonalMessagesRecipients();
			$messages->ID_PLAYER = $this->ID_PLAYER;
			$messages = $messages->find();
		}

		if ($messages) {
			foreach ($messages as $message) {
				$query = "CALL DeletePM({$message->ID_PM}, {$this->ID_PLAYER}, {$type})";
				Doo::db()->query($query);
			}
		}

		$this->purgeCache();
		return TRUE;
	}

	/**
	 * Searches for friends by given string
	 *
	 * @return array
	 */
	public function getSearchFriends($search) {
		//TODO proper security for injections
		$params = array();
		$params['limit'] = 10;
		$params['where'] = "(FirstName Like ? OR NickName Like ?)";
		$params['param'] = array('%' . $search . '%', '%' . $search . '%');
		$params['groupby'] = 'ID_PLAYER';
		$rel = new FriendsRel();
		$params['filters'][] = array('model' => "FriendsRel",
			'joinType' => 'INNER',
			'where' => "{$rel->_table}.ID_FRIEND = ?",
			'param' => array($this->ID_PLAYER)
		);
		$result = Doo::db()->find('Players', $params);

		return $result;
	}

	public function getEventsCount() {
		$event = new EvEvents();
		$participant = new EvParticipants();

		$params['select'] = "COUNT(1) as cnt";
		$params['filters'][] = array(
			'model' => 'EvParticipants',
			'joinType' => 'INNER',
			'where' => $participant->_table . ".ID_PLAYER = ? AND (" . $participant->_table . ".isParticipating = 1
				OR " . $participant->_table . ".isParticipating IS NULL)",
			'param' => array($this->ID_PLAYER)
		);
		$params['where'] = $event->_table . ".EventTime > ?";
		$params['param'] = array(time());
		$params['limit'] = 1;

		$results = Doo::db()->find('EvEvents', $params);
		return $results->cnt;
	}

	public function getEventsInvitationsCount() {
		$event = new EvEvents();
		$participant = new EvParticipants();

		$params['select'] = "COUNT(1) as cnt";
		$params['filters'][] = array(
			'model' => 'EvParticipants',
			'joinType' => 'INNER',
			'where' => $participant->_table . ".ID_PLAYER = ? AND " . $participant->_table . ".isParticipating IS NULL",
			'param' => array($this->ID_PLAYER)
		);
		$params['where'] = $event->_table . ".EventTime > ?";
		$params['param'] = array(time());
		$params['limit'] = 1;

		$results = Doo::db()->find('EvEvents', $params);
		return $results->cnt;
	}

	public function getEventsPublicCount() {
		$event = new EvEvents();
		$participant = new EvParticipants();

		$params['select'] = "COUNT(1) as cnt";
		$params['filters'][] = array(
			'model' => 'EvParticipants',
			'joinType' => 'INNER',
			'where' => $participant->_table . ".ID_PLAYER = ? AND " . $participant->_table . ".isParticipating = 1",
			'param' => array($this->ID_PLAYER)
		);
		$params['where'] = $event->_table . ".EventTime > ? AND " . $event->_table . ".isPublic = 1";
		$params['param'] = array(time());
		$params['limit'] = 1;

		$results = Doo::db()->find('EvEvents', $params);
		return $results->cnt;
	}

	public function getEvents() {
		$event = new EvEvents();
		$participant = new EvParticipants();

		$params['filters'][] = array(
			'model' => 'EvParticipants',
			'joinType' => 'INNER',
			'where' => $participant->_table . ".ID_PLAYER = ? AND (" . $participant->_table . ".isParticipating = 1 
				OR " . $participant->_table . ".isParticipating IS NULL)",
			'param' => array($this->ID_PLAYER)
		);
		$params['where'] = $event->_table . ".EventTime > ?";
		$params['asc'] = $event->_table . ".EventTime";
		$params['param'] = array(time());

		$results = Doo::db()->find('EvEvents', $params);
		return $results;
	}

	public function getPublicEvents() {
		$event = new EvEvents();
		$participant = new EvParticipants();

		$params['filters'][] = array(
			'model' => 'EvParticipants',
			'joinType' => 'INNER',
			'where' => $participant->_table . ".ID_PLAYER = ? AND " . $participant->_table . ".isParticipating = 1",
			'param' => array($this->ID_PLAYER)
		);
		$params['where'] = $event->_table . ".EventTime > ? AND " . $event->_table . ".isPublic = 1";
		$params['asc'] = $event->_table . ".EventTime";
		$params['param'] = array(time());

		$results = Doo::db()->find('EvEvents', $params);
		return $results;
	}

	// returns true if was rated by user
	public function isRated() {
		$ratings = new SnRatings();

		$ratings->ID_OWNER = $this->ID_PLAYER;

		$ratings->OwnerType = 'player';
		$player = User::getUser();
		if ($player) {
			$ratings->ID_FROM = $player->ID_PLAYER;
			if ($ratings->getOne())
				return true;
		}

		return false;
	}

	public function getRatingsCount() {
		$params['select'] = "COUNT(1) as 'cnt'";
		$params['where'] = "ID_OWNER = ? and OwnerType = ?";
		$params['param'] = array($this->ID_PLAYER, 'player');
		$params['limit'] = 1;

		$results = Doo::db()->find('SnRatings', $params);
		return $results->cnt;
	}

	public function getFriendsSuggestions() {
		$rel = new FriendsRel();
		$notIn = " AND ID_PLAYER NOT IN (SELECT `ID_FRIEND` FROM {$rel->_table} WHERE {$rel->_table}.ID_PLAYER = ?)";
		$notIn .= MainHelper::getSuspendQuery("{$this->_table}.ID_PLAYER");

//		$params['filters'][] = array(
//			'model' => 'FriendsRel',
//			'joinType' => 'INNER',
//			'where' => "({$rel->_table}.ID_PLAYER <> ? AND {$rel->_table}.ID_FRIEND <> {$this->_table}.ID_PLAYER)",
//			'param' => array($this->ID_PLAYER)
//		);

		$params['where'] = "City LIKE ? AND Country = ? AND {$this->_table}.ID_PLAYER <> ?" . $notIn;
		$params['param'] = array($this->City, $this->Country, $this->ID_PLAYER, $this->ID_PLAYER);
		$params['limit'] = 10;

		$suggestions = Doo::db()->find('Players', $params);

		if (count($suggestions) > 0)
			return $suggestions;

		//$params = array();
		$params['where'] = "Country = ? AND {$this->_table}.ID_PLAYER <> ?" . $notIn;
		$params['param'] = array($this->Country, $this->ID_PLAYER, $this->ID_PLAYER);
		$params['limit'] = 10;

		$suggestions = Doo::db()->find('Players', $params);

		if (count($suggestions) > 0)
			return $suggestions;

		//$params = array();
		$params['where'] = "{$this->_table}.ID_PLAYER <> ?" . $notIn;
		$params['param'] = array($this->ID_PLAYER, $this->ID_PLAYER);
		$params['limit'] = 10;

		$suggestions = Doo::db()->find('Players', $params);

		return $suggestions;
	}

	public function inviteToSite($email) {
		if(!$this->isInvited($email) && !$this->isRegistered($email)){
			$invitation = new SnInvitations();
			$invitation->ID_PLAYER = $this->ID_PLAYER;
			$invitation->EMail = $email;

			$invitation->insert();

			$invitation = $invitation->getOne();
			if ($invitation) {
				$mail = new EmailNotifications();
				$mail->invitation($invitation);
				
				return true;
			}
		}
		return false;
	}
	
	public function isRegistered($email){
		$params['select'] = "COUNT(1) as cnt";
		$params['where'] = "EMail = ?";
		$params['param'] = array($email);
		$params['limit'] = 1;

		$results = Doo::db()->find('Players', $params);
		
		if ($results->cnt == 1)
			return true;
		return false;
	}
	
	public function isInvited($email) {
		$invitation = new SnInvitations();
		$invitation->ID_PLAYER = $this->ID_PLAYER;
		$invitation->EMail = $email;

		$params['select'] = "COUNT(1) as cnt";
		$params['where'] = "EMail = ?";
		$params['param'] = array($email);
		$params['limit'] = 1;

		$results = Doo::db()->find('SnInvitations', $params);

		if ($results->cnt == 1)
			return true;
		return false;
	}

	public function canAccess($area = '') {
		$permission = Doo::conf()->userGroups;

		if(isset($permission[$this->ID_USERGROUP])) {
			$conrete = $permission[$this->ID_USERGROUP];
			if(is_array($area)) { if(!empty($area)) { foreach($area as $val) { if(in_array('*', $conrete['allowed']) or in_array($val, $conrete['allowed'])) { return TRUE; }; }; }; }
            else { if(in_array('*', $conrete['allowed']) or in_array($area, $conrete['allowed'])) { return TRUE; }; };
		};
		return FALSE;
	}

    public function AchievementsRead() {
        $this->NewAchievementCount = 0;
        $this->update();
    }

    public function isDeveloper() { return $this->isDeveloper; }
    
    public function isEsportPlayer(){
        if($this->ID_TEAM == 0)
            return false;
        else
            return true;
    }
    
    public function hasTeam($single = false){
        $esport = new Esport();
        
        if($single){
            return $this->isEsportPlayer();
        }
        else{
            if($this->isEsportPlayer()){
                $team = $esport->getTeamByID($this->ID_TEAM);

                if($team->FK_GROUP != 0){
                    return true;
                }
                else
                    return false;
            }
            else return false;
        }
    }
    
    public function esportCheckStatus($state, $team){
       $esport = new Esport();
       
       if($this->isEsportPlayer()){
       
           $team = $esport->getTeamRelationsByTeam($team, $this->ID_TEAM);
           
           switch($state){
               case 'isCaptain':
                   return $team->isCaptain;
               break;
           
               case 'isPending':
                   return $team->isPending;
               break;
           
               default:
                   return false;
               break;
           }
       }
       else return false;
    }
        
    public function getMemberRoleType($ownerType, $ownerID, $player) {
        switch($ownerType) {
            case GAME:
                $games = new Games();
                $owner = Games::getGameByID($ownerID);
                $op_rel = $games->getPlayerGameRel($owner, $player);
                $id = $owner->ID_GAME;
                break;
            case COMPANY:
                $companies = new Companies();
                $owner = Companies::getCompanyByID($ownerID);
                $op_rel = $companies->getPlayerCompanyRel($owner, $player);
                $id = $owner->ID_COMPANY;
                break;
            case GROUP:
                $groups = new Groups();
                $owner = Groups::getGroupByID($ownerID);
                $op_rel = $groups->getPlayerGroupRel($owner, $player);
                $id = $owner->ID_GROUP;
                break;
            default:
                return FALSE;
        };
        if($op_rel) {
            $data = array(
                "owner" => $owner,
                "op_rel" => $op_rel,
                "id"    => $id,
            );
            return $data;
        } else { return FALSE; };
    }

    // $function: boolean - 0: Remove role; 1: Add role;
    public function updateMemberRole($op_rel, $role, $ownerType, $id, $function) {
        if($op_rel && $role && $ownerType && $id) {
            $name = "ID_" . $ownerType;
            $table = $op_rel->_table;
            $Opts = array(
                "limit" => 1,
                "param" => array($op_rel->ID_PLAYER, $id),
                "where" => "{$table}.ID_PLAYER = ? AND {$table}.{$name} = ?",
            );
            switch($role) {
                case ROLE_ADMIN:
                    if($op_rel->updateAttributes(array("isAdmin" => $function), $Opts)) { return TRUE; };
                    break;
                case ROLE_OFFICER:
                    if($ownerType === GROUP) {
                        if($op_rel->updateAttributes(array("isOfficer" => $function), $Opts)) { return TRUE; };
                    };
                    break;
                case ROLE_EDITOR:
                    if($op_rel->updateAttributes(array("isEditor" => $function), $Opts)) { return TRUE; };
                    break;
                case ROLE_FORUMADMIN:
                    if($op_rel->updateAttributes(array("isForumAdmin" => $function), $Opts)) { return TRUE; };
                    break;
            };
        };
        return FALSE;
    }
}
?>