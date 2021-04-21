<?php

Doo::loadCore('db/DooSmartModel');

class GlGroups extends DooSmartModel {

    public $ID_GROUP;
    public $ID_CREATOR;
    public $ID_LANGUAGE;
    public $GroupName;
    public $GroupDesc;
    public $Tags;
    public $ImageURL;
    public $ID_GAME;
    public $GameName;
    public $Server;
    public $Faction;
    public $ID_GROUPTYPE1;
    public $GroupType1;
    public $ID_GROUPTYPE2;
    public $GroupType2;
    public $InviteCount;
    public $ApplicantCount;
    public $MemberCount;
    public $ForumMemberCount;
    public $DownloadableItems;
    public $NewsCount;
    public $EventCount;
    public $EventParticipantCount;
    public $ShareCount;
    public $LikeCount;
    public $CreatedTime;
    
    //external use
    private $URL;
    private $GROUP_URL;
    private $FORUM_URL;
    private $EVENTS_URL;
    private $RAIDS_URL;
    public $_table = 'gl_groups';
    public $_primarykey = 'ID_GROUP';
    public $_fields = array(
        'ID_GROUP',
		'ID_CREATOR',
		'ID_LANGUAGE',
		'GroupName',
		'GroupDesc',
		'Tags',
		'ImageURL',
		'ID_GAME',
		'GameName',
		'Server',
		'Faction',
		'ID_GROUPTYPE1',
		'GroupType1',
		'ID_GROUPTYPE2',
		'GroupType2',
		'InviteCount',
		'ApplicantCount',
		'MemberCount',
		'ForumMemberCount',
		'DownloadableItems',
		'NewsCount',
		'EventCount',
		'EventParticipantCount',
		'ShareCount',
		'LikeCount',
		'CreatedTime',
    );

    //used for translation    
    public function __get($attr) {

        switch ($attr) {
            case 'URL':
                $this->$attr = Url::getUrl($this, "URL");
                break;
            case 'GROUP_URL':
                $this->$attr = Url::getUrl($this, "GROUP_URL");
                break;
            case 'FORUM_URL':
                $this->$attr = Url::getUrl($this, "FORUM_URL");
                break;
            case 'EVENTS_URL':
                $this->$attr = Url::getUrl($this, "EVENTS_URL");
                break;
            case 'RAIDS_URL':
                $this->$attr = Url::getUrl($this, "RAIDS_URL");
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
        if ($p) {
            $groups = new Groups();
            $relation = $groups->getPlayerGroupRel($this, $p);
            if (isset($relation) and !empty($relation) and $relation->isSubscribed == 1)
                return TRUE;
        }
        return FALSE;
    }
	
	public function isForumAdmin(){
		$user = User::getUser();
		
		if ($user) {
			if($user->canAccess('Super Admin Interface') === TRUE) {
				return TRUE;
			}
			
			$model = new SnPlayerGroupRel;

			$params['where'] = $model->_table.".ID_GROUP = ? AND ".$model->_table.".ID_PLAYER = ?";
			$params['param'] = array($this->ID_GROUP, $user->ID_PLAYER);
			$params['limit'] = 1;

			$data = Doo::db()->find($model, $params);
			if($data != null and ($data->isAdmin == 1 or $data->isForumAdmin == 1 or $data->isForumModerator == 1)){
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
            $groups = new Groups();
            $relation = $groups->getPlayerGroupRel($this, $p);
            if (isset($relation) and !empty($relation) and $relation->isLiked == 1)
                return TRUE;
        }
        return FALSE;
    }
	
	public function isSubscribedForum() {
        $p = User::getUser();
        if ($p) {
            $relation = new SnPlayerGroupRel();
			$relation->ID_GROUP = $this->ID_GROUP;
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
			$relation->ID_OWNER = $this->ID_GROUP;
			$relation->OwnerType = 'group';
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
			$relation->ID_OWNER = $this->ID_GROUP;
			$relation->OwnerType = 'group';
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
    public function isAdmin() {
        $p = User::getUser();
        if ($p) {
			if($p->canAccess('Super Admin Interface') === TRUE) {
				return TRUE;
			}

			$groups = new Groups();
            $relation = $groups->getPlayerGroupRel($this, $p);
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
                    $groups = new Groups();
                    $relation = $groups->getPlayerGroupRel($this, $p);

                    if (isset($relation) && !empty($relation) && $relation->isEditor == 1)
                            return TRUE;
            }
            return FALSE;
    }

    public function isBoardAdmin() {
            $admin = $this->isAdmin();
            if($admin) {
                    return TRUE;
            }
            $user = User::getUser();
            if($user) {
                    $groups = new Groups();
                    $relation = $groups->getPlayerGroupRel($this, $p);

                    if (isset($relation) && !empty($relation) && $relation->isForumAdmin == 1)
                            return TRUE;
            }
            return FALSE;
    }

    //invitation not accepted yet
    public function isPending() {
        $p = User::getUser();
        if ($p) {
            $groups = new Groups();
            $relation = $groups->getPlayerGroupRel($this, $p);

            if (isset($relation) and !empty($relation) and $relation->isInvited == 1)
                return TRUE;
        }
        return FALSE;
    }

    /**
     * returns leader
     *
     * @return Players
     */
    public function getLeader() {
        $pgr = new SnPlayerGroupRel();
        $params = array();
        $params['filters'][] = array('model' => "SnPlayerGroupRel",
            'joinType' => 'INNER',
            'where' => "{$pgr->_table}.ID_GROUP = ? AND isLeader = 1",
            'param' => array($this->ID_GROUP)
        );

        $params['limit'] = 1;
        $leader = Doo::db()->find('Players', $params);
        return $leader;
    }

    public function isMember() {
        $p = User::getUser();
        if ($p) {
            $groups = new Groups();
            $relation = $groups->getPlayerGroupRel($this, $p);

            if (isset($relation) and !empty($relation) and $relation->isMember == 1)
                return TRUE;
        }
        return FALSE;
    }
    
    public function isOfficer() {
        $p = User::getUser();
        if ($p) {
            $groups = new Groups();
            $relation = $groups->getPlayerGroupRel($this, $p);

            if (isset($relation) and !empty($relation) and $relation->isOfficer == 1)
                return TRUE;
        }
        return FALSE;
    }

    public function isCreator() {
        $p = User::getUser();
        if ($p) {
            if ($p->ID_PLAYER == $this->ID_CREATOR)
                return TRUE;
        }
        return FALSE;
    }

    public function hasApplied(Players $player = null) {
        if ($player != null) {
            $p = $player;
        } else {
            $p = User::getUser();
        }

        if ($p) {
            $groups = new Groups();
            $relation = $groups->getPlayerGroupRel($this, $p);

            if (isset($relation) and !empty($relation) and $relation->hasApplied == 1)
                return TRUE;
        }
        return FALSE;
    }

    /**
     * Leave group
     * @return boolean 
     */
    public function leave() {
        $p = User::getUser();
        if ($p) {
            $relation = new SnPlayerGroupRel();
            $relation->ID_GROUP = $this->ID_GROUP;
            $relation->ID_PLAYER = $p->ID_PLAYER;
            $relation->delete();
            return TRUE;
        }
        return FALSE;
    }

    public function getMembers() {
        $relation = new SnPlayerGroupRel();
        $params = array();
        $params['filters'][] = array('model' => "SnPlayerGroupRel",
            'joinType' => 'INNER',
            'where' => "{$relation->_table}.ID_GROUP = ? AND isSubscribed = 1",
            'param' => array($this->ID_GROUP)
        );

        $members = Doo::db()->find('Players', $params);
        return $members;
    }

}
?>