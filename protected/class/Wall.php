<?php
class Wall {

    /**
     * Inserts post into db
     *
     * @param Players $objFrom
     * @param String $message
     * @param enum $type
     * @return int
     */
    public function setPost(&$objFrom, $objTo, $message, $type = WALL_HOME, $shared = false) {
		if($shared === false){
			$processResult = ContentHelper::managePostEnter($message);
		}
		else{
			$processResult = ContentHelper::manageShareEnter($message, $shared['otype'], $shared['oid'], $shared['olang']);
		}

		$message = $processResult->content;
		$ItemType = $processResult->type;

		$ID_OWNER = 0;
		$OwnerType = "";
		$ID_WALLOWNER = 0;
		$ID_TO_PLAYER = 0;
		$WallOwnerType = "";
                $ID_EVENT = 0;
		$public = 0;

		if(strlen($message) > 0) {
			if($objFrom instanceof EvEvents){
				$ID_OWNER = $objFrom->ID_EVENT;
				$OwnerType = WALL_OWNER_EVENT;
				$ID_WALLOWNER = $objFrom->ID_EVENT;
				$WallOwnerType = WALL_OWNER_EVENT;
                                $ID_EVENT = $objFrom->ID_EVENT;
				$public = 1;

			} else if($objFrom instanceof Players or isset($objFrom->ID_PLAYER)) {
				if($objFrom->ID_PLAYER && strlen($message) > 0) {

					if($objTo instanceof Players and $objFrom->ID_PLAYER != $objTo->ID_PLAYER and !$objFrom->isFriend($objTo->ID_PLAYER)){
						return 0;
					}

					$ID_OWNER = $objFrom->ID_PLAYER;
					$OwnerType = WALL_OWNER_PLAYER;
					$ID_WALLOWNER = $objFrom->ID_PLAYER;
					$WallOwnerType = WALL_OWNER_PLAYER;

					if($objTo instanceof Players and $objFrom->ID_PLAYER != $objTo->ID_PLAYER) {
						$ID_TO_PLAYER = $objTo->ID_PLAYER;
						$ID_WALLOWNER = $objTo->ID_PLAYER;
					} else if($objTo instanceof SnGroups) {
						if(!$objTo->isMember()){
							return 0;
						}
						$ID_WALLOWNER = $objTo->ID_GROUP;
						$WallOwnerType = WALL_OWNER_GROUP;
					} else if($objTo instanceof EvEvents) {
						$ID_WALLOWNER = $objTo->ID_EVENT;
                                                $ID_EVENT = $objTo->ID_EVENT;
						$WallOwnerType = WALL_OWNER_EVENT;
                                                $public = 1;
					} else if($objTo instanceof SnGames) {
						$ID_WALLOWNER = $objTo->ID_GAME;
						$WallOwnerType = WALL_OWNER_GAME;
					}
				}
			} else if($objFrom instanceof SnGroups) {
				if(!$objFrom->isMember()){
					return 0;
				}
				$ID_OWNER = $objFrom->ID_GROUP;
				$OwnerType = WALL_OWNER_GROUP;
				$ID_WALLOWNER = $objFrom->ID_GROUP;
				$WallOwnerType = WALL_OWNER_GROUP;
				$public = 1;
			}

			$wall = new SnWallitems();
			$wall->ID_OWNER = $ID_OWNER;
			$wall->OwnerType = $OwnerType;
			$wall->ID_WALLOWNER = $ID_WALLOWNER;
			$wall->ID_TO_PLAYER = $ID_TO_PLAYER;
			$wall->WallOwnerType = $WallOwnerType;
                        $wall->ID_EVENT = $ID_EVENT;
			$wall->Message = ContentHelper::handleContentInput($message);
			$wall->ItemType = $ItemType;
			$wall->Public = $public;

			if($shared !== false){
				$wall->isShared = 1;
				$wall->ShareOwnerType = $shared['otype'];
				$wall->ID_SHAREOWNER = $shared['oid'];
			}

			$id = $wall->insert();

			$objFrom->purgeCache();
			return $id;
		}
        return 0;
    }


    /**
     * Returs post by id
     *
     * @param int $id
     * @return SnWallitems
     */
    public function getPost($id, $clearCache = false) {
        if($id) {
            $wallItem = new SnWallitems();
            $wallItem->ID_WALLITEM = $id;
            if($clearCache) {
                $wallItem->purgeCache();
            }
            $wallItem = $wallItem->getOne();

			if($wallItem) {
				if($wallItem->WallOwnerType == WALL_OWNER_PLAYER) {
					$p = User::getUser();
					if($p) {
						//check if is friend and can see content
						if ($p->isFriend($wallItem->ID_OWNER) or $wallItem->ID_OWNER == $p->ID_PLAYER or 
						  $wallItem->ID_WALLOWNER == $p->ID_PLAYER or Walltags::isTagged($wallItem, $p)){
							return $wallItem;
						}
					}
				} elseif($wallItem->WallOwnerType == WALL_OWNER_GROUP) {
					$group = Groups::getGroupByID($wallItem->ID_WALLOWNER);
					if($group and $group->isMember()) {
						return $wallItem;
					}
				} elseif($wallItem->WallOwnerType == WALL_OWNER_EVENT) {
					$event = Event::getEvent($wallItem->ID_WALLOWNER);
					if($event and $event->isParticipating()) {
						return $wallItem;
					}
				} elseif($wallItem->WallOwnerType == WALL_OWNER_GAME) {
					$game = Games::getGameByID($wallItem->ID_WALLOWNER);
					if($game) {
						return $wallItem;
					}
				}

				//if post is public then i can be seen
				if($wallItem->Public == 1) {
					return $wallItem;
				}
			}
        }
        return null;
    }

    /**
     * Returs list of posts by type
     *
     * @param Players $owner
     * @param enum $type
     * @return Object $post_list
     */
    public function getPostList(&$owner, $type = WALL_HOME, $offset = 0, $friendUrl = '', $phrase = '', $album = 0) {
        $friend = null;
		$showAllPosts = false;

        //getting lists of friends
		if($owner instanceof Players) {
			$friendRelation = $this->getFriendAndRelation($owner, $friendUrl);
			$friend = $friendRelation->friend;
			$relation = $friendRelation->relation;
			$viewerID = $owner->ID_PLAYER;
			$wallOwnerType = WALL_OWNER_PLAYER;
			if($relation and $friend and $relation->Mutual == 1) {
				$showAllPosts = true;
			} else if(isset($owner) and !isset($friend)) { //this our
				$showAllPosts = true;
			}
		} else if($owner instanceof SnGroups) {
			$viewerID = $owner->ID_GROUP;
			$wallOwnerType = WALL_OWNER_GROUP;
			if($owner->isMember()) {
				$showAllPosts = true;
			}
		} else if($owner instanceof EvEvents) {
			$viewerID = $owner->ID_EVENT;
			$wallOwnerType = WALL_OWNER_EVENT;
			if($owner->isParticipating()) {
				$showAllPosts = true;
			}
		} else if($owner instanceof SnGames) {
			$viewerID = $owner->ID_GAME;
			$wallOwnerType = WALL_OWNER_GAME;
			$showAllPosts = true;
		}

        if($friend) {
            $viewerID = $friend->ID_PLAYER;
        }

        //this wall is personal
        if($type == WALL_MAIN) {
            $wi = new SnWallitems();
            $mwi = new SnMyWallItems();
            $pl = new Players();

            $query = 'SELECT SQL_CALC_FOUND_ROWS wi.*, pl.ID_PLAYER, pl.NickName, pl.FirstName, pl.Avatar, pl.URL ';
            $query .='FROM `'.$wi->_table.'` as wi ';
            $query .='LEFT JOIN `'.$mwi->_table.'` as mwi ON wi.ID_WALLITEM = mwi.ID_WALLITEM ';
            $query .='INNER JOIN `'.$pl->_table.'` as pl ON wi.ID_WALLOWNER = pl.ID_PLAYER ';
            $query .='WHERE mwi.ID_VIEWER = ? AND wi.WallOwnerType = ? ';
            $query .='GROUP BY wi.ID_WALLITEM ';
            $query .='ORDER BY wi.PostingTime DESC ';
            $query .='LIMIT '.$offset.','.Doo::conf()->postnum;

            $wall_itemsArr = Doo::db()->fetchAll( $query, array($owner->ID_PLAYER, $wallOwnerType));

            $wall_items = array();
            if(!empty($wall_itemsArr)) {
                foreach ($wall_itemsArr as $key=>$item) {
                    $player = new Players();
                    $player->fillWithValues($item);

                    $wallitem = new SnWallitems();
                    $wallitem->fillWithValues($item);
                    $wallitem->Players = $player;
                    $wall_items[] = $wallitem;
                }
            }
			Walltags::addTaggedItems($wall_items, $viewerID, $album);

        } else {
            if($type == WALL_HOME) {

                $params = array();
                $params['select'] = 'SQL_CALC_FOUND_ROWS *';
                $params['limit'] = $offset.','.Doo::conf()->postnum;
                $params['desc'] = 'PostingTime';
                $params['where'] = 'ID_WALLOWNER = ? AND WallOwnerType = ?';

                if($showAllPosts == false) {
					$params['where'] .=' AND Public = 1';
                }

                $params['param'] = array($viewerID, $wallOwnerType);
                if($phrase != '') {
                    $params['where'] .=' AND Message LIKE ?';
                    $params['param'][] = '%'.$phrase.'%';
                }

                $items = Doo::db()->find('SnWallitems', $params);
				Walltags::addTaggedItems($items, $viewerID, $album);
            } else {
				if($type == WALL_PHOTO)
					$limit = Doo::conf()->photonum;
				elseif($type == WALL_VIDEO)
					$limit = Doo::conf()->videonum;
				else
					$limit = Doo::conf()->postnum;

                $params = array();
                $params['select'] = 'SQL_CALC_FOUND_ROWS *';
                $params['limit'] = $offset.','.$limit;
                $params['desc'] = 'PostingTime';
                $params['where'] = 'ID_WALLOWNER = ? AND ItemType = ? AND WallOwnerType = ? AND ID_ALBUM = ?';

                if($showAllPosts == false) {
					$params['where'] .=' AND Public = 1';
                }
                $params['param'] = array($viewerID, $type, $wallOwnerType, $album);
                if($phrase != '') {
                    $params['where'] .=' AND Message LIKE ?';
                    $params['param'][] = '%'.$phrase.'%';
                }
                $items = Doo::db()->find('SnWallitems', $params);
				Walltags::addTaggedItems($items, $viewerID, $album);
			}

            //adds friend inseat of player for avatar and info show
            $wall_items = array();
            if($friend and $items) {
                foreach ($items as $item) {
                    $item->Players = $friend;
                    $wall_items[] = $item;
                }
            } else {
                $wall_items = $items;
            }

        }
        return $wall_items;
    }

	public function getTotalRows($player, $type, $friendUrl){
		$friendRelation = $this->getFriendAndRelation($player, $friendUrl);
        $friend = $friendRelation->friend;
        $relation = $friendRelation->relation;

		$viewerID = $player->ID_PLAYER;

        if($friend) {
            $viewerID = $friend->ID_PLAYER;
        }

		$params = array();
		$params['select'] = 'COUNT(1) as `cnt`';
		$params['desc'] = 'PostingTime';
		$params['where'] = 'ID_OWNER = ? AND ItemType = ?';

		if($friendUrl != '') {
			if (!$friend or !$relation or $relation->Mutual == 0) {
				$params['where'] .=' AND Public = 1';
			}
		}
		$params['param'] = array($viewerID, $type);
		$items = Doo::db()->find('SnWallitems', $params);

		return $items[0]->cnt;
	}

    /**
     * Gets friend object and relation between player
     *
     * @param String $friendUrl
     * @return array
     */
    private function getFriendAndRelation(Players &$p, $friendUrl = '') {
        //getting lists of friends
        static $result = array();

        $friend = null;
        $relation = null;
        if($friendUrl != '') {
            if(isset($result[$friendUrl]))
                return $result[$friendUrl];

            $friend = User::getFriend($friendUrl);

            //we need to know what relation friend and player has
            if($friend and $p->ID_PLAYER) {
                $relation = new FriendsRel();
                $relation->ID_FRIEND = $friend->ID_PLAYER;
                $relation->ID_PLAYER = $p->ID_PLAYER;
                $relation = $relation->getOne();
            }

            return $result[$friendUrl] = (object)array('friend' => $friend, 'relation' => $relation);
        }

        return (object)array('friend' => $friend, 'relation' => $relation);
    }

    /**
     * Returns amount of posts in current section
     *
     * @return int
     */
    public function getTotalPostsByType() {
        $rs = Doo::db()->query('SELECT FOUND_ROWS() as total');
        $total = $rs->fetch();
        return $total['total'];
    }

    /**
     * Inserts wall reply
     *
     * @param Players $p
     * @param int $postID
     * @param String $comment
     * @return int - post id
     */
    public function setComment(Players &$p, $postID, $comment) {
        $wall = new SnWallitems();
        $wall->ID_WALLITEM = $postID;
        $wall->purgeCache();
        $wall = $wall->getOne();
        if($p->ID_PLAYER && strlen($comment) > 0 && !empty($wall)) {
            $wallreply = new SnWallreplies();
            $wallreply->ID_WALLITEM = $postID;
            $wallreply->ID_OWNER = $p->ID_PLAYER;
            $wallreply->OrgOwnerType = WALL_OWNER_PLAYER;
            $wallreply->Message = ContentHelper::handleContentInput(trim($comment));
            $wallreply->insert();

            $wallreply->purgeCache();
            $p->purgeCache();
            return $postID;
        }
        return 0;
    }

    /**
     * Returs reply by id
     *
     * @param int $id
     * @return SnWallitems
     */
    public function getReply($id) {
        $id = (int)$id;
        if($id) {
            $wr = Doo::db()->find('SnWallreplies', array('limit'=>1, 'desc' => 'ReplyNumber', 'where' => 'ID_WALLITEM = '.$id));
            return $wr;
        }
        return new SnWallitems();
    }

    /**
     * Returs list of comments by post id
     *
     * @param int $type
     * @return Object $post_list
     */
    public function getRepliesList($id, $limit = 0) {
        $id = (int)$id;
		$order = 'asc';
        if ($limit == 0) {
            $limit = 99999;
        } else {
			$order = 'desc';
		}
        if($id) {
            $SnWallreplies = Doo::db()->relate('SnWallreplies', 'Players', array(
                'limit' => '0,'.$limit,
                $order =>'ReplyNumber',
                'where' => 'ID_WALLITEM = ? AND OwnerType = ?',
                'param' => array($id, WALL_OWNER_PLAYER),
                'match' => true
            ));

            return $SnWallreplies;
        }

        return array();
    }

    /**
     * Returns amount of replies in current post
     *
     * @param int $pid
     * @return int
     */
    public function getTotalRepliesByPostID($pid) {
        $totalNum = 0;

        $wr = new SnWallreplies();
        $totalNum = (object)Doo::db()->fetchRow( 'SELECT COUNT(1) as cnt FROM `'.$wr->_table.'` as wr
                                        WHERE wr.ID_WALLITEM = ?
                                        LIMIT 1', array($pid));

        return $totalNum->cnt;
    }

    /**
     * Sets like
     *
     * @param String $type
     * @param int $id
     * @param int $replyNumber
     * @param int $l
     * @return array
     */
    public function toggleLike($type, $id, $replyNumber = 0, $l = 0) {
        $p = User::getUser();

		if($type == 'reply') {
			$wall = new SnWallreplies();
			$wall->ReplyNumber = $replyNumber;
		} else {
			$wall = new SnWallitems();
		}

		$wall->ID_WALLITEM = $id;
		$wall = $wall->getOne();
		
        if(isset($p) && $wall->ID_OWNER != $p->ID_PLAYER) {
            $like = new SnLikes();

            $like->ID_WALLITEM = $id;
            $like->ReplyNumber = $replyNumber;
            $like->ID_PLAYER = $p->ID_PLAYER;
            $like->purgeCache();

            $newLike = $like->getOne();
            if(empty($newLike)) {
				$like->Likes = $l;
                $like->insert();
            } else {
				$like->ID_LIKE = $newLike->ID_LIKE;
				if ($newLike->Likes == 1 && $l == 0) {
					$like->Likes = 0;
					$like->update(array('field' => 'Likes'));
				} else if ($newLike->Likes == 0 && $l == 1) {
					$like->Likes = 1;
					$like->update(array('field' => 'Likes'));
				} else {
					$like->delete();
				}
			}
			if($type == 'reply') {
				$newWall = new SnWallreplies();
				$newWall->ReplyNumber = $replyNumber;
			} else {
				$newWall = new SnWallitems();
			}
	
			$newWall->ID_WALLITEM = $id;
			$newWall = $newWall->getOne();
            return array($newWall->LikeCount, $newWall->DislikeCount);
        }
		return false;
    }

	/**
     * Returns relation between player and game
     * @param type $gameID
     * @return SnPlayerGameRel
     */
	public static function getPlayerLikeRel($wallItem, Players $player = null, $replyNumber = 0) {
        if($player == null) {
            $player = User::getUser();
        }

        if($player) {
            $pgr = new SnLikes();
            $pgr->ID_PLAYER = $player->ID_PLAYER;
            $pgr->ID_WALLITEM = $wallItem->ID_WALLITEM;
            $pgr->ReplyNumber = $replyNumber;
            $result = $pgr->getOne();

            return $result;
        }
    }

    /**
     * Toggle public/private
     *
     * @param int $id
     * @return int
     */
    public function setPublic($id) {
        $p = User::getUser();
        if($p) {
            $wallitem = new SnWallitems();
            $wallitem->ID_WALLITEM = $id;
            $wallitem->ID_PLAYER = $p->ID_PLAYER;
            $wallitem->purgeCache();
            $wallitem = $wallitem->getOne();

            if(!empty($wallitem)) {
                if($wallitem->Public == 1) {
                    $wallitem->Public = 0;
                    $wallitem->update(array('field' => 'Public'));
                    return 0;
                } else {
                    $wallitem->Public = 1;
                    $wallitem->update(array('field' => 'Public'));
                    return 1;
                }
            }
        }
    }

	public function uploadPhoto($friend, $id_album = 0) {
        $p = User::getUser();
        if ($p) {
			//membership permissions
			if($p->ImageLimit <= $p->WallPhotoCount) {
				return false;
			}

			if($friend != '')
				$to = User::getFriend ($friend);


			if((isset($to) and $to and $p->isFriend($to->ID_PLAYER)) or !isset($to)){
				$image = new Image();
				$photo = $image->uploadImage(FOLDER_WALL_PHOTOS);

				if($photo['filename'] != ''){
					$wall = new SnWallitems();
					$wall->ID_ALBUM = $id_album;
					$wall->ID_OWNER = $p->ID_PLAYER;
					$wall->OwnerType = WALL_OWNER_PLAYER;
					$wall->ID_WALLOWNER = $p->ID_PLAYER;
					if(isset($to)) {
						$wall->ID_TO_PLAYER = $to->ID_PLAYER;
						$wall->ID_WALLOWNER = $to->ID_PLAYER;
					}
					$wall->Message = serialize(array('content' => serialize(array('content' => $photo['filename']))));
					$wall->ItemType = WALL_PHOTO;

					$id = $wall->insert();

					$p->purgeCache();
				}

				return $photo;
			}
        }

		return false;
    }

}
?>