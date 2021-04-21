<?php
class Ratings{
	// takes url for players
	public function rate($type, $ownerId, $rating){
		$userPlayer = User::getUser();
		$suspendLevel = ($userPlayer) ? $userPlayer->getSuspendLevel() : 0;
		$noProfileFunctionality = MainHelper::GetNoProfileFunctionality($suspendLevel);
		$noSiteFunctionality = MainHelper::GetNoSiteFunctionality($suspendLevel);

		if ($noSiteFunctionality)
			return false;

		$ratings = new SnRatings();
		$r = $this->fillRating($type, $ownerId);
		if($r){
			$ratings->Rating = $rating;
			$ratings->ID_OWNER = $r->ID_OWNER;
			$ratings->OwnerType = $r->OwnerType;
			$ratings->ID_FROM = $r->ID_FROM;
			
			if($ratings->Rating >= 1 and $ratings->Rating <= 10){
				if($r->isRated){
					$q = "UPDATE {$ratings->_table} SET `Rating` = ? WHERE ID_OWNER = ? AND ID_FROM = ? AND OwnerType =?";
					$params = array($ratings->Rating, $ratings->ID_OWNER, $ratings->ID_FROM, $ratings->OwnerType);

					Doo::db()->query($q, $params);
				}
				else{
					$ratings->insert();
				}
				return $this->getNewRating($type, $ownerId);
			}
		}
		
		return false;
	}
	
	public function fillRating($type, $id){
		$ratings = new SnRatings();
		$ratings->OwnerType = $type;
		
		switch($type){
			case 'player':
				$player = User::getUser();
				$owner = User::getFriend($id);
				
				if($player and $owner and $player->isFriend($owner->ID_PLAYER)){
					$ratings->ID_OWNER = $owner->ID_PLAYER;
					$ratings->ID_FROM = $player->ID_PLAYER;
					$ratings->isRated = $owner->isRated();
				}
				break;
			case 'company':
				$player = User::getUser();
				$owner = Companies::getCompanyByID($id);
				if($player and $owner){
					$ratings->ID_OWNER = $owner->ID_COMPANY;
					$ratings->ID_FROM = $player->ID_PLAYER;
					$ratings->isRated = $owner->isRated();
				}
				break;
			case 'game':
				$player = User::getUser();
				$owner = Games::getGameByID($id);
				if($player and $owner){
					$ratings->ID_OWNER = $owner->ID_GAME;
					$ratings->ID_FROM = $player->ID_PLAYER;
					$ratings->isRated = $owner->isRated();
				}
				break;
		}
		
		return $ratings;
	}
	public function getUsersRating($type, $id, $author_id = -1){
            $ratings = new SnRatings();
            $player = User::getUser();
            
            
            if($player && $author_id == -1){
                
                $ratings->OwnerType = $type;   
                $ratings->ID_OWNER = $id;
                $ratings->ID_FROM = $player->ID_PLAYER;
                $rating = $ratings->getOne();
                return $rating;
            }
            else if($author_id){
                $ratings->OwnerType = $type;   
                $ratings->ID_OWNER = $id;
                $ratings->ID_FROM = $author_id;
                $rating = $ratings->getOne();
                return $rating;               
            }
            else
                return false;
            
           
	}	
	public function getNewRating($type, $id){
		switch($type){
			case 'player':
				return User::getFriend($id, true)->SocialRating;
				break;
			case 'company':
				return Companies::getCompanyByID($id)->SocialRating;
				break;
			case 'game':
				return Games::getGameByID($id)->SocialRating;
				break;
		}
	}

    public function getTotalRatings($ownerId, $ownerType = 'game') {
        $totalNum = 0;
        $ratings = new SnRatings();
        $totalNum = (object) Doo::db()->fetchRow('SELECT COUNT(1) as cnt FROM `' . $ratings->_table . '`
										WHERE OwnerType = ? AND ID_OWNER = ?
                                        LIMIT 1', array($ownerType, $ownerId));

        return $totalNum->cnt;
    }
}
?>
