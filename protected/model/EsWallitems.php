<?php
Doo::loadCore('db/DooSmartModel');

class EsWallitems extends DooSmartModel{

    public $ID_WALLITEM;
    public $ID_ALBUM;
    public $ItemType;
    public $ID_OWNER;
    public $OwnerType;
    public $ID_WALLOWNER;
    public $WallOwnerType;
    public $ID_TO_PLAYER;
    public $PosterDisplayName;
    public $Avatar;
    public $PostingTime;
    public $LastActivityTime;
    public $Headline;
    public $Message;
    public $isShared;
    public $ID_SHAREOWNER;
    public $ShareOwnerType;
    public $ID_EVENT;
    public $Replies;
    public $NewReplies;
    public $Public;
    public $LastReplyNum;
    public $LikeCount;
    public $NewLikeCount;
    public $DislikeCount;
    public $NewDislikeCount;

    public $_table = 'es_wallitems';
    public $_primarykey = 'ID_WALLITEM';
    public $_fields = array(
		'ID_WALLITEM',
		'ID_ALBUM',
		'ItemType',
		'ID_OWNER',
		'OwnerType',
		'ID_WALLOWNER',
		'WallOwnerType',
		'ID_TO_PLAYER',
		'PosterDisplayName',
		'Avatar',
		'PostingTime',
		'LastActivityTime',
		'Headline',
		'Message',
		'isShared',
		'ID_SHAREOWNER',
		'ShareOwnerType',
		'ID_EVENT',
		'Replies',
		'NewReplies',
		'Public',
		'LastReplyNum',
		'LikeCount',
		'NewLikeCount',
		'DislikeCount',
		'NewDislikeCount',
	);

    public function fillWithValues($array) {
        $array = (array)$array;
        foreach ($this->_fields as $field) {
            if(!is_object($field) and isset($array[$field])) {
                $this->{$field} = $array[$field];
            }
        }
    }

    /**
     * Checks if user is owner of the post
	 * or owner of owner of the post(eg. company, game...)
     *
     * @return boolean
     */
    public function isOwner() {
		if($this->OwnerType == WALL_OWNER_PLAYER){		// Owner is player
			$p = User::getUser();

			if($p and $this->ID_OWNER == $p->ID_PLAYER)
				return TRUE;
		}
		elseif($this->OwnerType == WALL_OWNER_COMPANY){	// Owner is company
			$company = Companies::getCompanyByID($this->ID_OWNER);

			if($company and $company->isAdmin()){
				return true;
			}
		}
		elseif($this->OwnerType == WALL_OWNER_GAME){	// Owner is game
			$game = Games::getGameByID($this->ID_OWNER);

			if($game and $game->isAdmin()){
				return true;
			}
		}
		elseif($this->OwnerType == WALL_OWNER_GROUP){	// Owner is group
			$group = Groups::getGroupByID($this->ID_OWNER);

			if($group and $group->isAdmin()){
				return true;
			}
		}
		elseif($this->OwnerType == WALL_OWNER_EVENT){	// Owner is event
			$event = Event::getEvent($this->ID_OWNER);

			if($event and $event->isAdmin()){
				return true;
			}
		}


        return FALSE;
    }

	public function isWallOwner(){
		switch($this->WallOwnerType){
			case WALL_OWNER_PLAYER:

				$p = User::getUser();
				if($p and $this->ID_WALLOWNER == $p->ID_PLAYER)
					return TRUE;

				break;
			case WALL_OWNER_COMPANY:

				$company = Companies::getCompanyByID($this->ID_WALLOWNER);
				if($company and $company->isAdmin()){
					return true;
				}

				break;
			case WALL_OWNER_GAME:
				$game = Games::getGameByID($this->ID_WALLOWNER);
				if($game and $game->isAdmin()){
					return true;
				}

				break;
			case WALL_OWNER_GROUP:
				$group = Groups::getGroupByID($this->ID_WALLOWNER);

				if($group and $group->isAdmin()){
					return true;
				}

				break;
			case WALL_OWNER_EVENT:
				$event = Event::getEvent($this->ID_WALLOWNER);

				if($event and $event->isAdmin()){
					return true;
				}

				break;
		}

		return FALSE;
	}

	public function isLiked() {
                $player = User::getUser()->ID_PLAYER;
            
		$like = Doo::db()->getOne('EsLikes', array(
                    'where' => "ID_WALLITEM = {$this->ID_WALLITEM} AND ID_PLAYER = {$player} AND ReplyNumber = 0"
                ));
		if($like) {
			if($like->Likes == 1) {
				return true;
			}
		}
		return false;
	}


	/**
     * Deletes item
     *
     * @return boolean
     */
    public function deletePost() {
        if($this->isOwner() == TRUE or $this->isWallOwner() == true) {
            $this->delete();
            $this->purgeCache();
            return TRUE;
        }

        return FALSE;
    }

    /**
     * Gets poster object of current wallitem
     *
     * @return Players
     */
    public function getPoster() {
        $poster = new Players();
        $poster->ID_PLAYER = $this->ID_OWNER;
        $poster = $poster->getOne();

        return $poster;
    }
    
    public function getReplies($order = 'desc') {
        
        $items = Doo::db()->find('EsWallreplies', array(
                'where' =>  "ID_WALLITEM = {$this->ID_WALLITEM}",
                $order =>   'ReplyNumber'        
        ));

        return $items;
    }

}
?>