<?php
	class Walltags {

		public static function addTaggedItems(array &$items, $viewerID = 0, $album = 0){
			$taggedItems = self::getTaggedItems($viewerID, $album);
			if (!empty($taggedItems)){
				$items = array_merge($items, $taggedItems);
				uasort($items, function($a, $b){   // Re-sort items by postingtime descending
					return $b->PostingTime - $a->PostingTime;
				});
			}
		}
		
		public function buildMessage(array $names){
			$count = count($names);
			switch($count){
				case 0:
					$message = '';
					break;
				case 1:
					$message = $names[0];
					break;
				case 2:
					$message = $names[0].' and '.$names[1];
					break;
				case 3:
					$message = $names[0].', '.$names[1].' and '.$names[2];
					break;
				default:
					$title = implode("\n", array_slice($names, 2));
					$message = $names[0].', '.$names[1].' and '
					.	'<a href="javascript:void(0);" title=\''.$title.'\'>'.($count-2).' others</a>';
			}
			return $message;
		}
		
		public function deleteTags(array $walltags){
			if (isset($walltags)){
				foreach($walltags as $walltag){
					$walltag->delete();
				}
			}
		}
		
		public function getAllTagNames($idWallitem){
			$walltags = $this->getAllTags($idWallitem);
			$names = array();
			if (!empty($walltags)){
				foreach($walltags as $walltag){
					$names[] = $walltag->DisplayName;
				}
				natcasesort($names);
			}
			return $names;
		}

		public function getAllTagNamesString($idWallitem){
			$names = $this->getAllTagNames($idWallitem);
			$delimiter = ', ';
			$str = implode($delimiter, $names);
			$pos = strrpos($str, $delimiter);
			if ($pos !== false){
				$str = substr_replace($str, ' '.SnController::__('and').' ', $pos, strlen($delimiter));
			}
			return $str;
		}
		
		public function getAllTags($idWallitem){
			$walltags = new SnWalltags;
			$walltags->ID_WALLITEM = $idWallitem;
			$walltags->Untagged = 0;
			return Doo::db()->find($walltags, array('asc' => 'DisplayName'));
		}
		
		// Finding friends who are not tagged by other than player and who are not untagged for this wallitem
		public function getFriendsList($wallitem, $type, $player){
			$message = unserialize($wallitem->Message);
			$content = unserialize($message['content']);
			$filename = $content['content'];
			if ($type == 'player') {
				$stm = Doo::db()->query(
					'SELECT DISTINCT a.ID_FRIEND, a.FriendName, b.* '
				.	'FROM sn_friends_rel AS a LEFT JOIN sn_walltags AS b ' 
				.	'ON a.ID_FRIEND = b.ID_TAGGED AND b.ID_WALLITEM = "'.$wallitem->ID_WALLITEM.'" '
				.	'WHERE (a.ID_PLAYER = '.$player->ID_PLAYER.' OR a.ID_FRIEND = '.$player->ID_PLAYER.') '
				.	'AND (isnull(b.Untagged) OR b.Untagged = 0) '
				.	'AND (isnull(b.ID_TAGGEDBY) OR b.ID_TAGGEDBY = '.$player->ID_PLAYER.') '
				.	'ORDER BY a.FriendName '
				);
				return $stm->fetchAll();
			}
		}
		
		// Finding friends who are tagged by other than player and who are not untagged for this wallitem
		public function getTaggedByOthersList($wallitem, $type, $player){
			if ($type == 'player') {
				$stm = Doo::db()->query(
					'SELECT * FROM sn_walltags ' 
				.	'WHERE ID_WALLITEM = "'.$wallitem->ID_WALLITEM.'" '
				.	'AND Untagged = 0 '
				.	'AND ID_TAGGEDBY != '.$player->ID_PLAYER.' '
				.	'ORDER BY DisplayName '
				);
				return $stm->fetchAll();
			}
		}

		public static function getTaggedItems($viewerID = 0, $album = 0){
			if ($viewerID == 0){
				$viewerID = User::getUser()->ID_PLAYER;
			}
			$sql = 'SELECT a.*, b.ID_ALBUM AS tagAlbum '
			.	'FROM sn_wallitems a LEFT JOIN sn_walltags b ' 
			.	'ON a.ID_WALLITEM = b.ID_WALLITEM ' 
			.	'LEFT JOIN sn_mywallitems c ' 
			.	'ON a.ID_WALLITEM = c.ID_WALLITEM AND b.ID_TAGGED = c.ID_VIEWER '
			.	'WHERE c.ID_VIEWER = '.$viewerID.' '
			.	'AND a.ID_OWNER != '.$viewerID.' '
			.	'AND b.ID_ALBUM = '.$album;
			$taggedItems = Doo::db()->fetchAll($sql);
			$items = array();
			if(!empty($taggedItems)) {
				foreach ($taggedItems as $key=>$item) {
					$item['ID_ALBUM'] = $item['tagAlbum'];
					$wallitem = new SnWallitems();
					$wallitem->fillWithValues($item);
					$items[] = $wallitem;
				}
				return $items;
			}
			return false;
		}
		
		public function getTagTypes(){
			$walltags = new SnWalltags;
			$result = Doo::db()->query("SHOW COLUMNS FROM {$walltags->_table} WHERE Field = 'OwnerType'");
			foreach ($result as $row)
				$type = $row{'Type'};
			preg_match('/^enum\((.*)\)$/', $type, $matches);
			foreach (explode(',', $matches[1]) as $value)
				 $enum[] = trim($value, "'");
			return $enum;
		}

		public function insertTag(SnWallitems $wallitem, array $guiTags, array $tag){
			$walltag = new SnWalltags;
			$walltag->ID_WALLITEM = $guiTags['idwallitem'];
			$walltag->ID_TAGGED   = $tag['id'];
			$walltag->ID_TAGGEDBY = $guiTags['idtaggedby'];
			$walltag->ID_ALBUM    = $wallitem->ID_OWNER == $tag['id'] ? $wallitem->ID_ALBUM : 0;
			$walltag->OwnerType   = $guiTags['ownertype'];
			$walltag->DisplayName = PlayerHelper::showName(User::getById($tag['id']));
//			$walltag->DisplayName = $tag['friendname'];
			$walltag->Frame       = $tag['frame'];
			return $walltag->insert();
		}
		
		public function insertTags(SnWallitems $wallitem, array $guiTags, array $tags){
			if (isset($tags) && !empty($tags)){
				$walltags = new SnWalltags;
				$walltags->ID_WALLITEM = $guiTags['idwallitem'];
				$firstTag = $walltags->count() == 0;
				$names = array();
				foreach($tags as $tag){
					$this->insertTag($wallitem, $guiTags, $tag);
//					$names[] = $tag['friendname'];
                    $names[] = PlayerHelper::showName(User::getById($tag['id']));
					if (!self::knowOwner($wallitem, $tag)){
						//---- insert into MyWallitems ----
						$myWallitems = new SnMyWallItems;
						$myWallitems->ID_WALLITEM = $wallitem->ID_WALLITEM;
						$myWallitems->ID_VIEWER = $tag['id'];
						$myWallitems->ID_OWNER = $wallitem->ID_OWNER;
						$myWallitems->OwnterType = $guiTags['ownertype'];
						$myWallitems->insert();
					}
				}
				if ($firstTag){
					//---- insert message in wallitem ----
					$wallitems = new SnWallitems;
					$wallitems->ID_WALLITEM = $guiTags['idwallitem'];
					$wallitem = Doo::db()->find($wallitems, array('limit' => 1));
					$message = unserialize($wallitem->Message);
					$content = unserialize($message['content']);
					$content['message'] = 'with '.self::buildMessage($names);   // Add new datafield to content
					$message['content'] = serialize($content);
					$wallitem->Message = serialize($message);
					$wallitem->update();
				}
				else {
					//---- insert message in wallreplies ----
					$wallreplies = new SnWallreplies;
					$wallreplies->ID_WALLITEM = $guiTags['idwallitem'];
					$wallreplies->ID_OWNER = $guiTags['idtaggedby'];
					$wallreplies->OwnerType = $guiTags['ownertype'];
					$wallreplies->Message = 'tagged '.self::buildMessage($names);
					$wallreplies->insert();
				}
			}
		}
		
		public static function isTagged(SnWallitems $wallitem, Players $player){
			$walltags = new SnWalltags;
			$walltags->ID_WALLITEM = $wallitem->ID_WALLITEM;
			$walltags->ID_TAGGED   = $player->ID_PLAYER;
			$walltags->Untagged    = 0;
			return ($walltags->count() > 0);
		}
		
		public function knowOwner(SnWallitems $wallitem, array $tag){
			$friends = new SnFriendsRel;
			$friends->ID_PLAYER = $wallitem->ID_OWNER;
			$friends->ID_FRIEND = $tag['id'];
			return ($friends->count() > 0);
		}
		
		public function untag(array $ids){
			$player   = isset($ids['player'])   ? $ids['player']   : 0;
			$wallitem = isset($ids['wallitem']) ? $ids['wallitem'] : 0;
			if ($player > 0 && $wallitem > 0){
				$walltags = new SnWalltags;
				$walltags->ID_WALLITEM = $wallitem;
				$walltags->ID_TAGGED   = $player;
				$walltag = Doo::db()->find($walltags, array('limit' => 1));
				$walltag->Untagged = 1;
				$walltag->update();
				return self::getAllTagNamesString($wallitem);
			}
		}
		
		public function updateTagSet($guiTags){
            $tagged = (isset($guiTags['tagged'])) ? $guiTags['tagged'] : NULL;
			$player = User::getUser();
			//---- Find info for current item ----
			$wallitems = new SnWallitems();
			$wallitems->ID_WALLITEM = $guiTags['idwallitem'];
			$wallitem = $wallitems->getOne();
//			$wallitem = Doo::db()->find($wallitems, array('limit' => 1));
			
			//---- Find players own tags for current item ----
			$walltags = new SnWalltags();
			$walltags->ID_WALLITEM = $guiTags['idwallitem'];
			$walltags->ID_TAGGEDBY = $player->ID_PLAYER;
			$walltags->Untagged = 0;
            $dbTags = $walltags->find();
//			$dbTags = Doo::db()->find($walltags);

			//---- Search database for tags to update or delete ----
//			$firstTag = (count($dbTags) == 0);
			$toInsert = $toDelete = $toUpdate = array();
			if(isset($dbTags) && !empty($tagged)) {
				foreach($dbTags as $dbTag) {
//					if(!empty($tagged)) {
						$inDataSet = FALSE;
						foreach($tagged as $tag) {
							if($dbTag->ID_TAGGED == $tag['id']) {      // Tag exists in new data set
								if($dbTag->Frame != $tag['frame']) {   // Update if frame has changed
									$toUpdate[] = array_merge(array('idwalltag' => $dbTag->ID_WALLTAG), $tag);
								};
								$inDataSet = TRUE;
								break;
							};
						};
                        // Delete tag from database if not in data set
						if(!$inDataSet) { $toDelete[] = $dbTag; };
//					};
				};
			};
			//---- Search dataset for new tags to insert ----
			if(isset($tagged)) {
				foreach($tagged as $tag) {
					$inDatabase = FALSE;
					if(isset($dbTags)) {
						foreach($dbTags as $dbTag) {  // Check if tag already exists in database
							if($dbTag->ID_TAGGED == $tag['id']) {
								$inDatabase = TRUE;
								break;
							};
						};
					};
                    // Insert tag into database if not already exists
					if(!$inDatabase) { $toInsert[] = $tag; }
				};
			} else {   // No tags at all, delete all not untagged
				$walltags = new SnWalltags();
				$walltags->ID_WALLITEM = $guiTags['idwallitem'];
				$walltags->ID_TAGGEDBY = $player->ID_PLAYER;
				$walltags->Untagged = 0;
				$walltags->delete();
			};
			$this->insertTags($wallitem, $guiTags, $toInsert);
			$this->updateTags($toUpdate);
			$this->deleteTags($toDelete);
			return $this->getAllTagNamesString($wallitem->ID_WALLITEM);
		}

		public function updateTags(array $tags){
			if (isset($tags)){
				foreach($tags as $tag){
					$walltags = new SnWalltags;
					$walltags->ID_WALLTAG = $tag['idwalltag'];
					$walltags->Frame = $tag['frame'];
					$walltags->update();
				}
			}
		}
		
	}
?>
