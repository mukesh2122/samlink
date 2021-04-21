<?php
Doo::loadCore('db/DooSmartModel');

class SnCompanies extends DooSmartModel{

    public $ID_COMPANY;
    public $CompanyName;
    public $ImageURL;
    public $CompanyAddress;
    public $Founded;
    public $Ownership;
    public $Employees;
    public $URL;
    public $CompanyDesc;
    public $Tags;
    public $ID_COMPANYTYPE;
    public $CompanyType;
    public $CreatedTime;
    public $FanCount;
    public $ForumMemberCount;
    public $DownloadableItems;
    public $GameCount;
    public $NewsCount;
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
    
    //external
    private $NEWS_URL; //used for news
    private $COMPANY_URL;
    private $FORUM_URL;
    private $EVENTS_URL;

    public $_table = 'sn_companies';
    public $_primarykey = 'ID_COMPANY';
    public $_fields = array(
                            'ID_COMPANY',
                            'CompanyName',
                            'ImageURL',
                            'CompanyAddress',
                            'Founded',
                            'Ownership',
                            'Employees',
                            'URL',
							'CompanyDesc',
							'Tags',
							'ID_COMPANYTYPE',
							'CompanyType',
							'CreatedTime',
							'FanCount',
							'ForumMemberCount',
							'DownloadableItems',
							'GameCount',
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
            case 'COMPANY_URL':
                $this->$attr = Url::getUrl($this, "COMPANY_URL");
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
     * Checks if player is subscribed to company news
     *
     * @return boolean
     */
    public function isSubscribed() {
        $p = User::getUser();
        if($p) {
            $companies = new Companies();
            $relation = $companies->getPlayerCompanyRel($this, $p);
            if (isset($relation) and !empty($relation) and $relation->isSubscribed == 1)
                return TRUE;
        }
        return FALSE;
    }
	
	public function isForumAdmin($id = "") { 
        $user = $id == "" ?  User::getUser() : User::getById($id); 
		
		if ($user) {
			if($user->canAccess('Super Admin Interface') === TRUE) {
				return TRUE;
			}
			
			$model = new SnPlayerCompanyRel;

			$params['where'] = $model->_table.".ID_COMPANY = ? AND ".$model->_table.".ID_PLAYER = ?";
			$params['param'] = array($this->ID_COMPANY, $user->ID_PLAYER);
			$params['limit'] = 1;

			$data = Doo::db()->find($model, $params);
			if($data != null and ($data->isAdmin == 1 or $data->isForumAdmin == 1)){
				return true;
			}
		}
		return false;
	}
	
	/**
	 * Checks if player likes company
	 * @return type boolean
	 */
    public function isLiked() {
        $p = User::getUser();
        if($p) {
            $companies = new Companies();
            $relation = $companies->getPlayerCompanyRel($this, $p);
            if (isset($relation) and !empty($relation) and $relation->isLiked == 1)
                return TRUE;
        }
        return FALSE;
    }
	
	public function isSubscribedForum() {
        $p = User::getUser();
        if ($p) {
			$companies = new Companies();
            $relation = $companies->getPlayerCompanyRel($this, $p);
            if (isset($relation) and !empty($relation) and $relation->isMember == 1)
                return TRUE;
        }
        return FALSE;
    }
	
	public function isSubscribedBoard($board) {
        $p = User::getUser();
        if ($p) {
            $relation = new FmNotify();
			$relation->ID_OWNER = $this->ID_COMPANY;
			$relation->OwnerType = 'company';
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
			$relation->ID_OWNER = $this->ID_COMPANY;
			$relation->OwnerType = 'company';
			$relation->ID_PLAYER = $p->ID_PLAYER;
			$relation->ID_TOPIC = $topic;
			
			$relation = $relation->getOne();
			
            if ($relation)
                return TRUE;
        }
        return FALSE;
    }
    
    /**
     * Checks if player is subscribed to company news
     *
     * @return unknown
     */
    public function isAdmin($id = "") { 
        $p = $id == "" ?  User::getUser() : User::getById($id); 
        
        if($p) {
            if($p->canAccess('Super Admin Interface') === TRUE) {
                return TRUE;
            }
            $companies = new Companies();
            $relation = $companies->getPlayerCompanyRel($this, $p);
            
            if (isset($relation) and !empty($relation) and $relation->isAdmin == 1)
                return TRUE;
        }
        return FALSE;
    }
    
    public function isEditor() {
		$admin = $this->isAdmin();
		if($admin) {
			return TRUE;
		}
		$user = User::getUser();
		if($user) {
			$companies = new Companies();
                        $relation = $companies->getPlayerCompanyRel($this, $p);

			if (isset($relation) && !empty($relation) && $relation->isEditor == 1)
				return TRUE;
		}
		return FALSE;
	}

	public function isBoardAdmin($id = "") { 
       
		$admin = $this->isAdmin();
		if($admin) {
			return TRUE;
		}
		$user = $id == "" ?  User::getUser() : User::getById($id); 
		if($user) {
			$companies = new Companies();
                        $relation = $companies->getPlayerCompanyRel($this, $user);

			if (isset($relation) && !empty($relation) && $relation->isForumAdmin == 1)
				return TRUE;
		}
		return FALSE;
	}

    public function isForumMod($id = "") { 
        $p = $id == "" ?  User::getUser() : User::getById($id); 
        
        if($p){
            $companies = new companies();
            $rel = $companies->getPlayerCompanyRel($this, $p);

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
            $companies = new Companies();
            $relation = $companies->getPlayerCompanyRel($this, $p);

            if (isset($relation) and !empty($relation) and $relation->isMember == 1)
                return TRUE;
        }
        return FALSE;
    }

    
	// returns true if was rated by user
	public function isRated(){
		$ratings = new SnRatings();
		
		$ratings->ID_OWNER = $this->ID_COMPANY;
		
		$ratings->OwnerType = 'company';
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
		$params['param'] = array($this->ID_COMPANY, 'company');
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