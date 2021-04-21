<?php
Doo::loadCore('db/DooSmartModel');

class SnWallreplies extends DooSmartModel{

    public $ID_WALLITEM;
    public $ID_OWNER;
    public $OwnerType;
    public $ID_ORGOWNER;
    public $OrgOwnerType;
    public $ReplyNumber;
    public $PostingTime;
    public $LastActivityTime;
    public $PosterDisplayName;
    public $Avatar;
    public $Message;
    public $isShared;
    public $ID_SHAREOWNER;
    public $ShareOwnerType;
    public $LikeCount;
    public $NewLikeCount;
    public $DislikeCount;
    public $NewDislikeCount;

    public $_table = 'sn_wallreplies';
    public $_primarykey = 'ReplyNumber';
    public $_fields = array(
		'ID_WALLITEM',
		'ID_OWNER',
		'OwnerType',
		'ID_ORGOWNER',
		'OrgOwnerType',
		'ReplyNumber',
		'PostingTime',
		'LastActivityTime',
		'PosterDisplayName',
		'Avatar',
		'Message',
		'isShared',
		'ID_SHAREOWNER',
		'ShareOwnerType',
		'LikeCount',
		'NewLikeCount',
		'DislikeCount',
		'NewDislikeCount',
	);

	public function isLiked() {
		$like = Wall::getPlayerLikeRel($this, null, $this->ReplyNumber);
		if($like) {
			if($like->Likes == 1) {
				return true;
			}
		}
		return false;
	}
	
	public function isDisliked() {
		$like = Wall::getPlayerLikeRel($this, null, $this->ReplyNumber);
		if($like) {
			if($like->Likes == '0') {
				return true;
			}
		}
		return false;
	}

    /**
     * Checks if user is owner
     *
     * @return boolean
     */
    public function isOwner() {
        $p = User::getUser();

        if(!$p) {
            return FALSE;
        }

        if($this->ID_OWNER == $p->ID_PLAYER)
            return TRUE;

        return FALSE;
    }

	/*
	 * if to check post owner
	 */
	public function isPostOwner(){
		$p = User::getUser();

        if(!$p) {
            return FALSE;
        }

		switch($this->OrgOwnerType){
			case PLAYER:
				if($this->ID_ORGOWNER == $p->ID_PLAYER)
					return true;
				break;

			case GROUP:
				$group = Groups::getGroupByID($this->ID_ORGOWNER);

				if($group and $group->isAdmin())
					return true;
				break;

			case EVENT:
				$event = Event::getEvent($this->ID_ORGOWNER);

				if($event and $event->isAdmin())
					return true;
				break;
		}

        return FALSE;
	}

	public function isWallOwner(){
		$p = User::getUser();

        if(!$p) {
            return FALSE;
        }

		$item = new SnWallitems;

		$item->ID_WALLITEM = $this->ID_WALLITEM;

		$item = $item->getOne();

		if($item){
			switch($item->WallOwnerType){
				case PLAYER:
					if($item->ID_WALLOWNER == $p->ID_PLAYER)
						return true;
					break;

				case GROUP:
					$group = Groups::getGroupByID($item->ID_WALLOWNER);

					if($group and $group->isAdmin())
						return true;
					break;

				case EVENT:
					$event = Event::getEvent($item->ID_WALLOWNER);

					if($event and $event->isAdmin())
						return true;
					break;
			}
		}

        return FALSE;
	}

    /**
     * Deletes item
     *
     * @return boolean
     */
    public function deleteReply() {
        if($this->isOwner() == TRUE or $this->isWallOwner() == true) {
            $this->delete();
            $this->purgeCache();
            return TRUE;
        }

        return FALSE;
    }

}
?>