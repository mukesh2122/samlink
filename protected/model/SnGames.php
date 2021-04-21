<?php

Doo::loadCore('db/DooSmartModel');

class SnGames extends DooSmartModel {

	public $ID_GAME;
	public $GameName;
	public $ImageURL;
	public $CreationDate;
	public $ESRB;
	public $URL;
	public $GameDesc;
	public $Tags;
	public $ID_GAMETYPE;
	public $GameType;
	public $isBuyable;
	public $isFreePlay;
	public $FreePlayLink;
	public $ID_PRODUCT;
	public $FanCount;
	public $ForumMemberCount;
	public $PlayersCount;
	public $ESportPlayersCount;
	public $ExpansionCount;
	public $DownloadableItems;
	public $CompanyCount;
	public $GroupCount;
	public $NewsCount;
	public $EventCount;
	public $EventParticipantCount;
	public $ShareCount;
	public $LikeCount;
	public $CurrentTop;
	public $CurrentPop;
	public $HistoryTop;
	public $HistoryPop;
	public $NewsCurrentTop;
	public $NewsCurrentPop;
	public $NewsHistoryTop;
	public $NewsHistoryPop;
	public $NewsSortTop;
	public $NewsSortPop;
	public $SocialRating;

	//external use
	private $NEWS_URL; //used for news
	private $GAME_URL;
	private $FORUM_URL;
	private $EVENTS_URL;
        
        //esport
        public $GameRatings;

	public $_table = 'sn_games';
	public $_primarykey = 'ID_GAME';
	public $_fields = array(
		'ID_GAME',
		'GameName',
		'ImageURL',
		'CreationDate',
		'ESRB',
		'URL',
		'GameDesc',
		'Tags',
		'ID_GAMETYPE',
		'GameType',
		'isBuyable',
		'isFreePlay',
		'FreePlayLink',
		'ID_PRODUCT',
		'FanCount',
		'ForumMemberCount',
		'PlayersCount',
		'ESportPlayersCount',
		'ExpansionCount',
		'DownloadableItems',
		'CompanyCount',
		'GroupCount',
		'NewsCount',
		'EventCount',
		'EventParticipantCount',
		'ShareCount',
		'LikeCount',
		'CurrentTop',
		'CurrentPop',
		'HistoryTop',
		'HistoryPop',
		'SortTop',
		'SortPop',
		'NewsCurrentTop',
		'NewsCurrentPop',
		'NewsHistoryTop',
		'NewsHistoryPop',
		'NewsSortTop',
		'NewsSortPop',
		'SocialRating',
	);

	//used for translation
	public function __get($attr) {
		switch ($attr) {
			case 'NEWS_URL':
				$this->$attr = Url::getUrl($this, "NEWS_URL");
				break;
			case 'GAME_URL':
				$this->$attr = Url::getUrl($this, "GAME_URL");
				break;
			case 'FORUM_URL':
				$this->$attr = Url::getUrl($this, "FORUM_URL");
				break;
			case 'EVENTS_URL':
				$this->$attr = Url::getUrl($this, "EVENTS_URL");
				break;
		}
		return $this->$attr;
	}

	/**
	 * Checks if player is subscribed to game news
	 *
	 * @return unknown
	 */
	public function isSubscribed() {
		$p = User::getUser();
		if($p) {
			$games = new Games();
			$relation = $games->getPlayerGameRel($this, $p);
			if (isset($relation) and !empty($relation) and $relation->isSubscribed == 1)
				return TRUE;
		}
		return FALSE;
	}

	public function isForumAdmin($id = "") { 
        $user = $id == "" ?  User::getUser() : User::getById($id); 
		if($user){
			if($user->canAccess('Super Admin Interface') === TRUE) {
				return TRUE;
			}

			$model = new SnPlayerGameRel;

			$params['where'] = $model->_table.".ID_GAME = ? AND ".$model->_table.".ID_PLAYER = ?";
			$params['param'] = array($this->ID_GAME, $user->ID_PLAYER);
			$params['limit'] = 1;

			$data = Doo::db()->find($model, $params);
			if($data != null and ($data->isAdmin == 1 or $data->isForumAdmin == 1 or $data->isForumModerator == 1)){
				return true;
			}
		}
		return false;
	}


	/**
	 * Checks if player likes game
	 * @return type boolean
	 */
	public function isLiked() {
		$p = User::getUser();
		if($p) {
			$games = new Games();
			$relation = $games->getPlayerGameRel($this, $p);
			if (isset($relation) and !empty($relation) and $relation->isLiked == 1)
				return TRUE;
		}
		return FALSE;
	}


	public function isSubscribedForum() {
		$p = User::getUser();
		if ($p) {
			$relation = new SnPlayerGameRel();
			$relation->ID_GAME = $this->ID_GAME;
			$relation->ID_PLAYER = $p->ID_PLAYER;
			$relation->isMember = 1;

			$relation = $relation->getOne();

			if ($relation)
				return TRUE;
		}
		return FALSE;
	}

	public function isSubscribedBoard($board) {
		$p = User::getUser();
		if ($p) {
			$relation = new FmNotify();
			$relation->ID_OWNER = $this->ID_GAME;
			$relation->OwnerType = 'game';
			$relation->ID_PLAYER = $p->ID_PLAYER;
			$relation->ID_BOARD = $board;
			$relation->ID_TOPIC = 0;

			$relation = $relation->getOne();

			if ($relation)
				return TRUE;
		}
		return FALSE;
	}
	public function isSubscribedTopic($topic) {
		$p = User::getUser();
		if ($p) {
			$relation = new FmNotify();
			$relation->ID_OWNER = $this->ID_GAME;
			$relation->OwnerType = 'game';
			$relation->ID_PLAYER = $p->ID_PLAYER;
			$relation->ID_TOPIC = $topic;

			$relation = $relation->getOne();

			if ($relation)
				return TRUE;
		}
		return FALSE;
	}

	/**
	 * Checks if player is subscribed to game news
	 *
	 * @return unknown
	 */
	public function isPlaying() {
		$p = User::getUser();
		if($p) {
			$games = new Games();
			$relation = $games->getPlayerGameRel($this, $p);
			if (isset($relation) and !empty($relation) and $relation->isPlaying == 1)
				return TRUE;
		}
		return FALSE;
	}

	/**
	 * returns Platform/Game url
	 *
	 * @return string
	 */
	public function getPURL($plarform) {

		$url = new SnUrl();
		$url->ID_OWNER = $this->ID_GAME;
		$url->OwnerType = 'game';
		$url = $url->getOne();
		if ($url) {
			return MainHelper::site_url('news/pgame/' . $plarform->PLAIN_URL . '/' . $url->URL);
		} else {
			return MainHelper::site_url('news/pgame/' . $plarform->PLAIN_URL . '/' . $this->ID_GAME);
		}
	}

	/**
	 * returns Platforms
	 *
	 * @return string
	 */
	public function getPlatforms() {

		$rel = new SnGamesPlatformsRel();
		$params = array();
		$params['asc'] = 'PlatformName';
		$params['filters'][] = array('model' => "SnGamesPlatformsRel",
			'joinType' => 'INNER',
			'where' => "{$rel->_table}.ID_GAME = ?",
			'param' => array($this->ID_GAME)
		);

		$platforms = Doo::db()->find('SnPlatforms', $params);
		return $platforms;
	}

	/**
	 * Checks if player is subscribed to company news
	 *
	 * @return unknown
	 */
	public function isAdmin($id = "") { 
        $p = $id == "" ?  User::getUser() : User::getById($id);
		if($p) {
			if($p->canAccess('Super Admin Interface') === TRUE) { return TRUE; };
			$games = new Games();
			$relation = $games->getPlayerGameRel($this, $p);

            if(isset($relation) && (!empty($relation)) && ($relation->isAdmin == 1)) { return TRUE; };
		};
		return FALSE;
	}

	public function isEditor() {
		$admin = $this->isAdmin();
		if($admin) { return TRUE; };
		$user = User::getUser();
		if($user) {
			$games = new Games();
			$relation = $games->getPlayerGameRel($this, $user);

            if((isset($relation)) && (!empty($relation)) && ($relation->isEditor == 1)) { return TRUE; };
		};
		return FALSE;
	}

	public function isBoardAdmin($id = "") { 
		$admin = $this->isAdmin();
		if($admin) {
			return TRUE;
		}
		$user = $id == "" ?  User::getUser() : User::getById($id); 
		if($user) {
			$games = new Games();
			$relation = $games->getPlayerGameRel($this, $user);

			if (isset($relation) && !empty($relation) && $relation->isForumAdmin == 1)
				return TRUE;
		}
		return FALSE;
	}

	public function isForumMod($id = "") { 
        $p = $id == "" ?  User::getUser() : User::getById($id);
        if($p){
           $games = new Games();
            $rel = $games->getPlayerGameRel($this, $p);

            if(isset($rel) and !empty($rel) and $rel->isForumModerator == 1)
                return TRUE;
        }
        return FALSE;
    }

    public function isBoardMod($type, $id, $board, $player){
        
        $mod = new FmBoardModeratorRel;

        $params['where'] = $mod->_table.'.OwnerType = ? AND '.$mod->_table.'.ID_OWNER = ? AND '.$mod->_table.'.ID_BOARD = ? and '.$mod->_table.'.ID_PLAYER = ?';
        $params['param'] = array( $type, $id, $board, $player);

        $result = Doo::db()->find('FmBoardModeratorRel',$params);

        if(isset($result) AND !empty($result)){
            return TRUE;
        }else{
            return FALSE;
        }
       

    }

    public function isMember($id = "") {
        $p = $id == "" ?  User::getUser() : User::getById($id);
        if ($p) {
           	$games = new Games();
         	$relation = $games->getPlayerGameRel($this, $p);

            if (isset($relation) and !empty($relation) and $relation->isMember == 1)
                return TRUE;
        }
        return FALSE;
    }


	public function getCompanyRel(){
		$relations = new SnCompanyGameRel();
		$data['distributors'] = array();
		$data['developers'] = array();

		$params['SnCompanies']['where'] = $relations->_table.".ID_GAME = ? AND {$relations->_table}.isDistributor = 1";
		$params['SnCompanies']['param'] = array($this->ID_GAME);
		$params['SnCompanies']['joinType'] = 'INNER';
		$params['SnCompanies']['where'] = $relations->_table.".ID_GAME = ? AND {$relations->_table}.isDistributor = 1";

		$data['distributors'] = Doo::db()->relateMany('SnCompanyGameRel', array('SnCompanies'), $params);

		$params['SnCompanies']['where'] = $relations->_table.".ID_GAME = ? AND {$relations->_table}.isDeveloper = 1";
		$data['developers'] = Doo::db()->relateMany('SnCompanyGameRel', array('SnCompanies'), $params);

		return (object)$data;
	}

	// returns true if was rated by user
	public function isRated(){
		$ratings = new SnRatings();

		$ratings->ID_OWNER = $this->ID_GAME;

		$ratings->OwnerType = 'game';
		$player = User::getUser();
		if($player){
			$ratings->ID_FROM = $player->ID_PLAYER;
			if($ratings->getOne())
				return true;
		}

		return false;
	}

	public function getRatingsCount(){
		$ratings = new SnRatings();

		$params['select'] = "COUNT(1) as 'cnt'";
		$params['where'] = "ID_OWNER = ? and OwnerType = ?";
		$params['param'] = array($this->ID_GAME, 'game');
		$params['limit'] = 1;

		$results = Doo::db()->find('SnRatings', $params);
		return $results->cnt;
	}

	public function getLastMessageOfEntireBoard($type, $id, $ID_MSG){
        $topics = new FmTopics();
        $messages = new FmMessages;

        $params['where'] = $messages->_table.".OwnerType = ? AND ".$messages->_table.".ID_OWNER = ? AND ". $messages->_table.".ID_MSG = ? ";
        $params['param'] = array($type, $id, $ID_MSG); 
        $data = Doo::db()->getOne('FmMessages', $params);
        
        $params['select'] = $topics->_table.'.ID_POLL';
        $params['where'] =  $topics->_table.'.OwnerType = ? and '.$topics->_table.'.ID_OWNER = ? and '.$topics->_table.'.ID_TOPIC = ?';
        $params['param'] = array($type, $id, $data->ID_TOPIC);
        $poll_id = Doo:: db()->getOne('FmTopics', $params);

       if(isset($poll_id->ID_POLL) && $poll_id->ID_POLL > 0){
           $data->ID_POLL  = $poll_id->ID_POLL;
       }else{
            $data->ID_POLL  = 0;
       }
        return $data;
    }

}
?>