<?php
Doo::loadCore('db/DooSmartModel');

class NwReplies extends DooSmartModel{
    
    public $ID_NEWS;
    public $ID_OWNER;
    public $ReplyNumber;
    public $ID_LANGUAGE;
    public $PostingTime;
    public $LastActivityTime;
    public $PosterDisplayName;
    public $Avatar;
    public $Message;
    public $LikeCount;
    public $DislikeCount;

    public $_table = 'nw_replies';
    public $_primarykey = 'ID_NEWS';
    public $_fields = array('ID_NEWS','ID_OWNER','ReplyNumber','ID_LANGUAGE','PostingTime','LastActivityTime','PosterDisplayName','Avatar','Message','LikeCount','DislikeCount');

    
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
    
    /**
     * Deletes item
     *
     * @return boolean
     */
    public function deleteReply() {
        if($this->isOwner() == TRUE) {
            $this->delete();
            $this->purgeCache();
            return TRUE;
        }
            
        return FALSE;
    }

	public function isLiked() {
		$like = News::getPlayerLikeRel($this, null, $this->ReplyNumber);
		if($like) {
			if($like->Likes == 1) {
				return true;
			}
		}
		return false;
	}
	
	public function isDisliked() {
		$like = News::getPlayerLikeRel($this, null, $this->ReplyNumber);
		if($like) {
			if($like->Likes == '0') {
				return true;
			}
		}
		return false;
	}

}
?>