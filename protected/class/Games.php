<?php

class Games {

	/**
	 * Returns all game list
	 *
	 * @return SnGames list
	 */

	public function getAllGames($limit, $tab = 1, $order = 'desc', $gameTypeID = 0, $isFreePlay = null, $isBuyable = null) {
		$contentchildFunctions = MainHelper::GetModuleFunctionsByTag('contentchild');
		$isFreePlay = (isset($contentchildFunctions['contentchildFreeToPlay']) && $contentchildFunctions['contentchildFreeToPlay']==1) ? $isFreePlay : 0;
		$isBuyable = (isset($contentchildFunctions['contentchildBuyable']) && $contentchildFunctions['contentchildBuyable']==1) ? $isBuyable : 0;
		$gameTypeID = intval($gameTypeID);
		$game = new SnGames;
		$order = strtoupper($order);

		if($tab == 2) {
			$orderBy = "CurrentPop $order, HistoryPop $order";
		} else if($tab == 3) {
			$orderBy = "SocialRating $order";
		} else if($tab == 4) {
			$orderBy = "CreatedTime $order";
		} else if($tab == 11) {
			$orderBy = "ID_GAME $order";
		} else if($tab == 12) {
			$orderBy = "GameName $order";
		} else if($tab == 13) {
			$orderBy = "GameType $order";
		} else {
			$orderBy = "GameName $order";
		}

		$whereArr = array();
		$where = '';
		if($gameTypeID > 0) {
			$whereArr[] = "{$game->_table}.ID_GAMETYPE = $gameTypeID ";
		}
		if($isFreePlay !== null) {
			$whereArr[] = "{$game->_table}.isFreePlay = ".intval($isFreePlay);
		}
		if($isBuyable !== null) {
			$whereArr[] = "{$game->_table}.isBuyable = ".intval($isBuyable);
		}
		if(count($whereArr) > 0) {
			$where = 'WHERE '.implode("AND ", $whereArr);
		}
		$query = "SELECT
					{$game->_table}.*
				FROM
					`{$game->_table}`
				$where
				ORDER BY {$orderBy}
				LIMIT $limit";

		$rs = Doo::db()->query($query);
		$list = $rs->fetchAll(PDO::FETCH_CLASS, 'SnGames');

		return $list;
	}

	/**
	 * Returns game item
	 *
	 * @return SnGames object
	 */
	public static function getGameByID($id) {
		$item = Doo::db()->getOne('SnGames', array(
			'limit' => 1,
			'where' => 'ID_GAME = ?',
			'param' => array($id)
				));
		return $item;
	}

	/**
	 * Returns amount of games
	 *
	 * @return int
	 */
	public function getTotal($gameTypeID = 0, $isFreePlay = null, $isBuyable = null) {
		$contentchildFunctions = MainHelper::GetModuleFunctionsByTag('contentchild');
		$isFreePlay = ($contentchildFunctions['contentchildFreeToPlay']==1) ? $isFreePlay : 0;
		$isBuyable = ($contentchildFunctions['contentchildBuyable']==1) ? $isBuyable : 0;
		$gameTypeID = intval($gameTypeID);
		$nc = new SnGames();
		$whereArr = array();
		$where = '';
		if($gameTypeID > 0) {
			$whereArr[] = "ID_GAMETYPE = $gameTypeID ";
		}
		if($isFreePlay !== null) {
			$whereArr[] = "isFreePlay = ".intval($isFreePlay);
		}
		if($isBuyable !== null) {
			$whereArr[] = "isBuyable = ".intval($isBuyable);
		}
		if(count($whereArr) > 0) {
			$where = 'WHERE '.implode("AND ", $whereArr);
		}
		$totalNum = (object) Doo::db()->fetchRow('SELECT COUNT(1) as cnt FROM `' . $nc->_table . '` '.$where.' LIMIT 1');
		return $totalNum->cnt;
	}

	/**
	 * Returns amount of games
	 *
	 * @return int
	 */
	public function getGames($game) {
		$cgr = new SnPlayerGameRel();
		$params = array();
		$params['asc'] = 'GameName';
		$params['filters'][] = array('model' => "SnCompanyGameRel",
			'joinType' => 'INNER',
			'where' => "{$cgr->_table}.ID_COMPANY = ?",
			'param' => array($game->ID_COMPANY)
		);

		$games = Doo::db()->find('SnGames', $params);
		return $games;
	}

	/**
	 * Returns group members related with SnPlayerGameRel
	 *
	 * @return SnPlayer
	 */
	public function getPlayers(SnGames $game, $limit = 0) {
		$cgr = new SnPlayerGameRel();
		$params = array();

		$params = array('model' => "SnPlayerGameRel",
			'joinType' => 'INNER',
			'match' => TRUE,
			'where' => "{$cgr->_table}.ID_GAME = ? AND isPlaying = 1".MainHelper::getSuspendQuery("sn_playergame_rel.ID_PLAYER"),
			'param' => array($game->ID_GAME),

		);

		$params['limit'] = $limit;
		$params['asc'] = 'FirstName';

		$members = Doo::db()->relate('Players', 'SnPlayerGameRel', $params);

		return $members;
	}

	/**
	 * Returns number of players
	 *
	 * @return SnPlayer
	 */
	public function getTotalPlayers(SnGames $game) {
		$cgr = new SnPlayerGameRel();
		$params = array();
		$params['limit'] = 1;
		$params['select'] = 'COUNT(1) as total';

		$params['filters'][] = array('model' => "SnPlayerGameRel",
			'joinType' => 'INNER',
			'where' => "{$cgr->_table}.ID_GAME = ? AND isPlaying = 1".MainHelper::getSuspendQuery("sn_playergame_rel.ID_PLAYER"),
			'param' => array($game->ID_GAME)
		);

		$total = Doo::db()->find('Players', $params);
		return $total->total;
	}

	/**
	 * Returns group subscribed members related with SnPlayerGameRel
	 *
	 * @return SnPlayer
	 */
	public function getSubscribed(SnGames $game, $limit = 0) {
		$cgr = new SnPlayerGameRel();
		$params = array();

		$params = array('model' => "SnPlayerGameRel",
			'joinType' => 'INNER',
			'match' => TRUE,
			'where' => "{$cgr->_table}.ID_GAME = ? AND isSubscribed = 1".MainHelper::getSuspendQuery("sn_playergame_rel.ID_PLAYER"),
			'param' => array($game->ID_GAME),

		);

		$params['limit'] = $limit;
		$params['asc'] = 'FirstName';

		$members = Doo::db()->relate('Players', 'SnPlayerGameRel', $params);

		return $members;
	}

	/**
	 * Returns number of subscribed players
	 *
	 * @return SnPlayer
	 */
	public function getTotalSubscribed(SnGames $game) {
		$cgr = new SnPlayerGameRel();
		$params = array();
		$params['limit'] = 1;
		$params['select'] = 'COUNT(1) as total';

		$params['filters'][] = array('model' => "SnPlayerGameRel",
			'joinType' => 'INNER',
			'where' => "{$cgr->_table}.ID_GAME = ? AND isSubscribed = 1".MainHelper::getSuspendQuery("sn_playergame_rel.ID_PLAYER"),
			'param' => array($game->ID_GAME)
		);

		$total = Doo::db()->find('Players', $params);
		return $total->total;
	}

	/**
	 * Returns assigned roles by userID
	 *
	 * @return object
	 */
	public function getAssignedRolesByUser(SnGames $game, $userID) {
		$gameRel = new SnPlayerGameRel();

		$params =  array(
			'select' => "{$gameRel->_table}.*",
			'where' => "{$gameRel->_table}.ID_GAME = ? AND
						{$gameRel->_table}.ID_PLAYER = ? AND
						({$gameRel->_table}.isAdmin = 1 OR
						 {$gameRel->_table}.isEditor = 1 OR
						 {$gameRel->_table}.isForumAdmin = 1)",
			'param' => array($game->ID_GAME,$userID),
			'limit' => 1
		);
		$pgr = Doo::db()->find('SnPlayerGameRel', $params);

		if($pgr) {
			$result = (object) array();
			if($pgr->isAdmin==1) $result->isAdmin = true;
			if($pgr->isEditor==1) $result->isEditor = true;
			if($pgr->isForumAdmin==1) $result->isForumAdmin = true;
			return $result;
		}
		else {
			return false;
		}
	}

	/**
	 * Crop handler
	 *
	 * @return array
	 */
	public function cropPhoto($id,$orientation,$ownertype) {
		$c = $this->getGameByID($id);

//        if ($c->isAdmin()) {

			$SnImages = Doo::db()->getOne('SnImages', array(
			'limit' => 1,
			'where' => 'ID_OWNER = ? AND OwnerType = ? AND Orientation = ?',
			'param' => array($id,$ownertype,$orientation)
			));

			if(!is_object($SnImages))
			{
				$SnImages = new SnImages();
				$SnImages->ID_OWNER = $id;
				$SnImages->OwnerType = $ownertype;
				$SnImages->Orientation = $orientation;
				$SnImages->insert();
			}

			switch ($ownertype) {
				case 'company':
					$folder = FOLDER_COMPANIES;
				break;
				case 'game':
					$folder = FOLDER_GAMES;
				break;
				case 'group':
					$folder = FOLDER_GROUPS;
				break;
				case 'event':
					$folder = FOLDER_EVENTS;
				break;
				case 'news':
					$folder = FOLDER_NEWSITEMS;
				break;
				case 'product':
					$folder = FOLDER_SHOP;
				break;
				case 'blog':
					$folder = FOLDER_BLOG;
				break;
				default:
					exit();
				break;
			}

			$Image = new Image();
			if(!isset($_POST)||$_POST == array())
			{
				$result = $Image->uploadImage($folder, $SnImages->ImageUrl);
			}else{
				$result = $Image->cropImage($folder, $SnImages->ImageUrl);
			}

			if ($result['filename'] != '') {
				$SnImages->ImageUrl = ContentHelper::handleContentInput($result['filename']);
				$SnImages->update(array(
				'field' => 'ImageUrl',
				'where' => 'ID_OWNER = ? AND OwnerType = ? AND Orientation = ?',
				'param' => array($id,$ownertype,$orientation)
				));
				$SnImages->purgeCache();
			}

			$result['c'] = $SnImages;
			return $result;
//        }
	}

	/**
	 * Upload handler
	 *
	 * @return array
	 */
	public function uploadPhoto($id) {
		$p = User::getUser();

		if ($p and $p->canAccess('Add game image')) {
			$c = Doo::db()->getOne('SnGames', array(
			'limit' => 1,
			'where' => 'ID_GAME = ?',
			'param' => array($id)
			));

			$image = new Image();
			$result = $image->uploadImage(FOLDER_GAMES, $c->ImageURL);
			if ($result['filename'] != '') {
				$c->ImageURL = ContentHelper::handleContentInput($result['filename']);
				$c->update(array('field' => 'ImageURL'));
				$c->purgeCache();
				$result['c'] = $c;
			}

			return $result;
		}
	}

	/**
	 * Returns all games list used in admin ajax
	 *
	 * @return SnGames list
	 */
	public function getSearchGames($phrase) {
		if (strlen($phrase) > 2) {
			$list = Doo::db()->find('SnGames', array(
				'limit' => 10,
				'asc' => 'GameName',
				'where' => 'GameName LIKE ?',
				'param' => array('%'. $phrase . '%')
			));
		}

		return $list;
	}

	public function getFiletypes($ID_GAME) {
		if (intval($ID_GAME) > 0) {
			$params = array();
			$params['asc'] = 'FiletypeName';
			$params['where'] = "OwnerType = ? AND ID_OWNER = ?";
			$params['param'] = array(WALL_GAMES, $ID_GAME);
			$tabs = Doo::db()->find('SnFiletypes', $params);
			return $tabs;
		}

		return array();
	}

	/**
	 * Returns amount of media by gameID
	 *
	 * @return int
	 */
	public function getTotalMediaByGameId($gameID) {
		$media = new SnMedia();
		$totalNum = (object) Doo::db()->fetchRow('SELECT COUNT(1) as cnt FROM `' . $media->_table . '`
														  WHERE ID_OWNER = ' . $gameID . ' LIMIT 1');
		return $totalNum->cnt;
	}

	public function getMedias($ID_GAME, $type="") {
		if (intval($ID_GAME) > 0) {
			$params = array();
			$params['asc'] = 'MediaName';
			if($type!="") {
				$params['where'] = "OwnerType = ? AND ID_OWNER = ? AND MediaType = ?";
				$params['param'] = array(WALL_GAMES, $ID_GAME, $type);
			}
			else {
				$params['where'] = "OwnerType = ? AND ID_OWNER = ?";
				$params['param'] = array(WALL_GAMES, $ID_GAME);
			}
			$medias = Doo::db()->find('SnMedia', $params);
			return $medias;
		}

		return array();
	}

	public function getMedia($ID_MEDIA) {
		if (intval($ID_MEDIA) > 0) {
			$params = array();
			$params['limit'] = 1;
			$params['asc'] = 'MediaName';
			$params['where'] = "ID_MEDIA = ?";
			$params['param'] = array($ID_MEDIA);
			$media = Doo::db()->find('SnMedia', $params);
			return $media;
		}

		return array();
	}

	/**
	 * Upload handler uses uploadify - can be added only by admin, do check in controller
	 *
	 * @return array
	 */
	public function uploadMedias($id, $mediaID = 0, $type = MEDIA_VIDEO, $file='') {
		$g = $this->getGameByID($id);
		$image = new Image();
		if($file!='') $result = $image->uploadImages(FOLDER_GAMES, '', $file);
		else $result = $image->uploadImages(FOLDER_GAMES);
		if ($result['filename'] != '') {
			$media = new SnMedia();
			$media->ID_OWNER = $g->ID_GAME;
			$media->OwnerType = WALL_GAMES;
			$media->MediaType = ContentHelper::handleContentInput($type);
			$media->MediaDesc = ContentHelper::handleContentInput($result['filename']);
			$media->MediaName = ContentHelper::handleContentInput($result['original_name']);
			$media->insert();

			$result['media'] = $media;
		}

		return $result;
	}

	/**
	 * Adds video - can be added only by admin, do check in controller
	 * @param int $id
	 * @param String $video - serialized
	 * @return boolean
	 */
	public function addVideo($id, $video, $videoUrl='') {
		$g = $this->getGameByID($id);
		$p = User::getUser();
		if ($p and $p->canAccess('Edit game information')) {
			$media = new SnMedia();
			$media->ID_OWNER = $g->ID_GAME;
			$media->OwnerType = WALL_GAMES;
			$media->MediaType = MEDIA_VIDEO;
			$media->MediaDesc = ContentHelper::handleContentInput($video);
			$media->MediaName = '';
			if($videoUrl!='') $media->URL=$videoUrl;
			$media->insert();
			return true;
		}
		return false;
	}

	/**
	 * Deletes media by id - deleted can be only by admin, do check in controller
	 * @param int $id
	 * @return boolean
	 */
	public function deleteMedia($id) {
		if(intval($id) > 0) {
			$media = new SnMedia();
			$media->ID_MEDIA = $id;

			$media = $media->getOne();

			if($media->MediaType != MEDIA_VIDEO) {
				$image = new Image();
				$result = $image->deleteImage(FOLDER_GAMES, $media->MediaDesc);
			}

			$media->delete();
			return true;
		}
		return false;
	}

	/**
	 * Updates media info
	 * @param array $post
	 * @return boolean
	 */
	public function saveMedia($post) {
		if (!empty($post)) {

			$tabs = array();
			$tabs[MEDIA_SCREENSHOT_URL] = MEDIA_SCREENSHOT;
			$tabs[MEDIA_CONCEPTART_URL] = MEDIA_CONCEPTART;
			$tabs[MEDIA_WALLPAPER_URL] = MEDIA_WALLPAPER;

			$media = new SnMedia();
			$media->ID_MEDIA = $post['media_id'];
			$media->MediaType = $tabs[$post['tab']];
			$media->MediaName = ContentHelper::handleContentInput($post['media_name']);
			$media->update();
			return true;
		}
		return false;
	}

	/**
	 * Updates media info
	 * @param array $post
	 * @return boolean
	 */
	public function updateMedia($post) {
		if (!empty($post)) {

			$media = new SnMedia();
			$media->ID_MEDIA = $post['ID_MEDIA'];
			$media->MediaType = $post['MediaType'];
			$media->update();
			return true;
		}
		return false;
	}

	public function addDownloadCount($ID_DOWNLOAD) {
		if (intval($ID_DOWNLOAD) > 0) {
			$download = new SnDownloads();
			$download->ID_DOWNLOAD = $ID_DOWNLOAD;
			$download->purgeCache();
			$download = $download->getOne();

			if ($download) {
				$download->DownloadCount = $download->DownloadCount + 1;
				$download->update(array('field' => 'DownloadCount'));
			}
		}
	}

	public function createGame($post) {
		$player = User::getUser();

		if($player) {
			$game = new SnGames();
			if (isset($post['game_name'])) $game->GameName = ContentHelper::handleContentInput($post['game_name']);
			if (isset($post['game_type'])) $game->ID_GAMETYPE = intval($post['game_type']);
			if (isset($post['game_release'])) $game->CreationDate = ContentHelper::handleContentInput($post['game_release']);
			if (isset($post['game_esrb'])) $game->ESRB = ContentHelper::handleContentInput($post['game_esrb']);
			if (isset($post['game_description'])) $game->GameDesc = ContentHelper::handleContentInput($post['game_description']);
			if (isset($post['game_url'])) $game->URL = ContentHelper::handleContentInput($post['game_url']);
			if (isset($post['image_url'])) $game->ImageURL = isset($post['image_url']) ? $post['image_url'] : '';

			$contentchildFunctions = MainHelper::GetModuleFunctionsByTag('contentchild');

			if ($contentchildFunctions['contentchildFreeToPlay']==1)
			if(isset($post['isFreePlay'])) {
				$game->isFreePlay = $post['isFreePlay'];
			}

			if ($contentchildFunctions['contentchildFreeToPlay']==1)
			if(isset($post['FreePlayLink'])) {
				$game->FreePlayLink = $post['FreePlayLink'];
			}
			if ($contentchildFunctions['contentchildBuyable']==1)
			if(isset($post['isBuyable'])) {
				$game->isBuyable = $post['isBuyable'];
			}
			if ($contentchildFunctions['contentchildBuyable']==1)
			if(isset($post['BuyableLink'])) {
				$game->BuyableLink = $post['isBuyableLink'];
			}
			$game->ID_GAME = $game->insert();

			if (isset($post['developer_id']) && isset($post['distributor_id']))
			{
				if($post['developer_id'] == $post['distributor_id']) {
					$companyGame = new SnCompanyGameRel();
					$companyGame->ID_COMPANY = intval($post['developer_id']);
					$companyGame->ID_GAME = $game->ID_GAME;
					$companyGame->isDeveloper = 1;
					$companyGame->isDistributor = 1;
					$companyGame->insert();
				} else {
					$companyGame = new SnCompanyGameRel();
					$companyGame->ID_COMPANY = intval($post['developer_id']);
					$companyGame->ID_GAME = $game->ID_GAME;
					$companyGame->isDeveloper = 1;
					$companyGame->isDistributor = 0;
					$companyGame->insert();

					$companyGame = new SnCompanyGameRel();
					$companyGame->ID_COMPANY = intval($post['distributor_id']);
					$companyGame->ID_GAME = $game->ID_GAME;
					$companyGame->isDeveloper = 0;
					$companyGame->isDistributor = 1;
					$companyGame->insert();
				}
			}

			$playerGameRel = new SnPlayerGameRel();
			$playerGameRel->ID_GAME = $game->ID_GAME;
			$playerGameRel->ID_PLAYER = $player->ID_PLAYER;
			$playerGameRel->isAdmin = 1;
			$playerGameRel->isMember = 1;
			$playerGameRel->isSubscribed = 1;
			$playerGameRel->isForumAdmin = 1;
			$playerGameRel->insert();

			if (!empty($post['platforms'])) {
				foreach ($post['platforms'] as $platform) {
					$p = new SnGamesPlatformsRel();
					$p->ID_GAME = $game->ID_GAME;
					$p->ID_PLATFORM = intval($platform);
					$p->insert();
				}
			}

			Url::createUpdateURL($game->GameName, URL_GAME, $game->ID_GAME);
			return $game;
		}
		return false;
	}

	public function updateGameInfo(SnGames $game, $post) {
		if (!empty($post)) {

			if(isset($post['game_name'])) $game->GameName = ContentHelper::handleContentInput($post['game_name']);
			if(isset($post['game_type'])) $game->ID_GAMETYPE = ContentHelper::handleContentInput($post['game_type']);
			//if(isset($post['game_release'])) $game->CreationDate = ContentHelper::handleContentInput($post['game_release']);
			if(isset($post['game_esrb'])) $game->ESRB = ContentHelper::handleContentInput($post['game_esrb']);
			if(isset($post['game_description'])) $game->GameDesc = $post['game_description'];
			if(isset($post['game_url'])) $game->URL = ContentHelper::handleContentInput($post['game_url']);

			if (isset($post['game_release_year']) and isset($post['game_release_month']) and isset($post['game_release_day'])) {
				$game_release_year = $post['game_release_year'];
				$game_release_month = $post['game_release_month'];
				$game_release_day = $post['game_release_day'];
				$y = '0000';
				$m = '00';
				$d = '00';
				if ($game_release_year > 0)
					$y = intval($game_release_year);
				if ($game_release_month > 0)
					$m = intval($game_release_month);
				if ($game_release_day > 0)
					$d = intval($game_release_day);

				$game->CreationDate = $y . '-' . $m . '-' . $d;
			}


			if(isset($post['image_url'])) {
				$game->ImageURL = $post['image_url'];
			}

			$contentchildFunctions = MainHelper::GetModuleFunctionsByTag('contentchild');
			if ($contentchildFunctions['contentchildFreeToPlay']==1)
				if(isset($post['isFreePlay'])) {
					$game->isFreePlay = $post['isFreePlay'];
				}
			if ($contentchildFunctions['contentchildFreeToPlay']==1)
				if(isset($post['FreePlayLink'])) {
					$game->FreePlayLink = $post['FreePlayLink'];
				}

			if ($contentchildFunctions['contentchildBuyable']==1)
				if(isset($post['isBuyable'])) {
					$game->isBuyable = $post['isBuyable'];
				}
			if ($contentchildFunctions['contentchildBuyable']==1)
				if(isset($post['ID_PRODUCT'])) {
					$game->ID_PRODUCT = intval($post['ID_PRODUCT']);
				}

			if(isset($post['developer_id']) and isset($post['distributor_id'])) {
				$companyGame = new SnCompanyGameRel();
				$companyGame->ID_GAME = $game->ID_GAME;
                if($companyGame->getOne()) { $companyGame->delete(); };

				if($post['developer_id'] == $post['distributor_id']) {
					$companyGame = new SnCompanyGameRel();
					$companyGame->ID_COMPANY = intval($post['developer_id']);
					$companyGame->ID_GAME = $game->ID_GAME;
					$companyGame->isDeveloper = 1;
					$companyGame->isDistributor = 1;
					$companyGame->insert();
				} else {
					$companyGame = new SnCompanyGameRel();
					$companyGame->ID_COMPANY = intval($post['developer_id']);
					$companyGame->ID_GAME = $game->ID_GAME;
					$companyGame->isDeveloper = 1;
					$companyGame->isDistributor = 0;
					$companyGame->insert();

					$companyGame = new SnCompanyGameRel();
					$companyGame->ID_COMPANY = intval($post['distributor_id']);
					$companyGame->ID_GAME = $game->ID_GAME;
					$companyGame->isDeveloper = 0;
					$companyGame->isDistributor = 1;
					$companyGame->insert();
				}
			}

			$platform = new SnGamesPlatformsRel();
			$platform->ID_GAME = $game->ID_GAME;
			$platform->delete();

			if(!empty($post['platforms'])) {
				foreach ($post['platforms'] as $platform) {
					$p = new SnGamesPlatformsRel();
					$p->ID_GAME = $game->ID_GAME;
					$p->ID_PLATFORM = $platform;
					$p->insert();
				}
			}
			Url::createUpdateURL($post['game_name'], URL_GAME, $game->ID_GAME);
			$game->update();

			return true;
		}
		return false;
	}

	/**
	 * Returns array of assigned platforms IDS
	 *
	 * @param SnGames $game
	 * @return array
	 */
	public function getAssignedPlatforms(SnGames $game) {
		$platform = new SnGamesPlatformsRel();
		$platform->ID_GAME = $game->ID_GAME;
		$platform->purgeCache();
		$platforms = $platform->find();

		$result = array();
		if($platforms) {
			foreach ($platforms as $p) {
				$result[] = $p->ID_PLATFORM;
			}
		}

		return $result;
	}

	public function saveDownloadTab(SnGames $game, $post) {
		if (!empty($post)) {
			$tab = new SnFiletypes();
			$tab->FiletypeName = ContentHelper::handleContentInput($post['tab_name']);
			if(isset($post['tab_desc'])) $tab->FiletypeDesc = ContentHelper::handleContentInput($post['tab_desc']);

			if (isset($post['tab_id']) && !empty($post['tab_id'])) {
				$tab->ID_FILETYPE = $post['tab_id'];
				$tab->update();
			} else {
				$tab->ID_OWNER = $game->ID_GAME;
				$tab->OwnerType = WALL_GAMES;
				$tab->insert();
			}

			return true;
		}
		return false;
	}

	/**
	 * Deletes download tab by ID
	 * @param int $tabID
	 * @return boolean
	 */
	public function deleteDownloadTab($tabID) {
		if (intval($tabID) > 0) {
			$tab = new SnFiletypes();
			$tab->ID_FILETYPE = $tabID;
			$tab->delete();
			return true;
		}
		return false;
	}

	public function saveDownload(SnGames $game, $post) {
		if (!empty($post)) {
			$down = new SnDownloads();
			$down->DownloadName = ContentHelper::handleContentInput($post['download_filename']);
			$down->DownloadDesc = ContentHelper::handleContentInput($post['download_description']);
			$down->FileSize = ContentHelper::handleContentInput($post['download_filesize']);
			$down->URL = ContentHelper::handleContentInput($post['download_fileurl']);
			$down->ID_FILETYPE = $post['tab_id'];

			if (isset($post['download_id']) && !empty($post['download_id'])) {
				$down->ID_DOWNLOAD = $post['download_id'];
				$down->update();
			} else {
				$down->insert();
			}

			return true;
		}
		return false;
	}

	/**
	 * Returns specified download
	 * @param int $downloadID
	 * @return SnDownloads
	 */
	public function getDownload($downloadID) {
		if (intval($downloadID) > 0) {
			$down = new SnDownloads();
			$down->ID_DOWNLOAD = $downloadID;
			$down->purgeCache();
			$down = $down->getOne();
			return $down;
		}
		return array();
	}

	public function getDownloadsByGameId($ID_GAME) {
		if (intval($ID_GAME) > 0) {
			$params = array();
			$params['asc'] = 'DownloadName';
			$params['where'] = "OwnerType = ? AND ID_OWNER = ?";
			$params['param'] = array(WALL_GAMES, $ID_GAME);
			$downloads = Doo::db()->find('SnDownloads', $params);
			return $downloads;
		}
		return false;
	}

	public function deleteDownload($downloadID) {
		if (intval($downloadID) > 0) {
			$down = new SnDownloads();
			$down->ID_DOWNLOAD = $downloadID;
			$down->delete();
			return true;
		}
		return false;
	}

	/**
	 * Returns amount of downloads by gameID
	 *
	 * @return int
	 */
	public function getTotalDownloadsByGameId($gameID) {
		$downloads = new SnDownloads();
		$totalNum = (object) Doo::db()->fetchRow('SELECT COUNT(1) as cnt FROM `' . $downloads->_table . '`
														  WHERE ID_OWNER = ' . $gameID . ' LIMIT 1');
		return $totalNum->cnt;
	}

	/**
	 * Returns amount of filetypes by gameID
	 *
	 * @return int
	 */
	public function getTotalFiletypesByGameId($gameID) {
		$filetypes = new SnFiletypes();
		$totalNum = (object) Doo::db()->fetchRow('SELECT COUNT(1) as cnt FROM `' . $filetypes->_table . '`
														  WHERE ID_OWNER = ' . $gameID . ' LIMIT 1');
		return $totalNum->cnt;
	}

	/**
	 * Returns specified filetype / DownloadTab
	 * @param int $filetypeID
	 * @return SnFiletypes
	 */
	public function getDownloadTab($filetypeID) {
		if (intval($filetypeID) > 0) {
			$type = new SnFiletypes();
			$type->ID_FILETYPE = $filetypeID;
			$type->purgeCache();
			$type = $type->getOne();
			return $type;
		}
		return array();
	}

	/**
	 * Returns game types
	 *
	 * @return unknown
	 */
	public function getTypes() {
		$langID = Lang::getCurrentLangID();
		$type = new SnGameTypes;
		$typeLocale = new SnGameTypeLocale;

		$param = array($langID);
		$query = "SELECT {$type->_table}.*, {$typeLocale->_table}.GameTypeName as TypeNameTranslated, {$typeLocale->_table}.GameTypeDesc as TypeDescTranslated
					FROM {$type->_table}
					LEFT JOIN {$typeLocale->_table} ON {$type->_table}.ID_GAMETYPE = {$typeLocale->_table}.ID_GAMETYPE AND {$typeLocale->_table}.ID_LANGUAGE = ?
					ORDER BY {$type->_table}.GameTypeName ASC";

		$q = Doo::db()->query($query, $param);
		$types = $q->fetchAll(PDO::FETCH_CLASS, 'SnGameTypes');

		return $types;
	}

	/**
	 * Returns game types
	 *
	 * @return unknown
	 */
	public function getGamePlatforms() {
		$params = array();
		$params['asc'] = 'PlatformName';
		$platforms = Doo::db()->find('SnPlatforms', $params);
		return $platforms;
	}

	/**
	 * Returns amount of player games
	 *
	 * @return int
	 */
	public function getTotalPlayerGames(Players $player, $phrase = '') {
		$gameRel = new SnPlayerGameRel;

		$params =  array(
			'select' => 'COUNT(1) as cnt',
			'where' => "{$gameRel->_table}.isPlaying = 1 AND {$gameRel->_table}.ID_PLAYER = ?",
			'param' => array($player->ID_PLAYER),
			'limit' => 1
		);

		if(strlen($phrase) > 2) {
			$params['where'] .= ' AND GameName LIKE ?';
			$params['param'][] = '%'.$phrase.'%';
		}
		$totalNum = Doo::db()->find('SnPlayerGameRel', $params);
		return $totalNum->cnt;
	}

	/**
	 * Returns players games that he's playing
	 * @param Players $player
	 * @param string $limit
	 * @return SnGames
	 */
	public function getPlayerGames(Players $player, $limit = 0) {
		$params = array();
		$game = new SnGames;
		$gameRel = new SnPlayerGameRel;
		$params['limit'] = $limit;
		$params['select'] = "{$game->_table}.*, {$gameRel->_table}.isPlaying, {$gameRel->_table}.isAdmin, {$gameRel->_table}.Comments";

		$params['filters'][] =  array('model' => "SnPlayerGameRel",
			'joinType' => 'INNER',
			'where' => "{$gameRel->_table}.isPlaying = 1 AND {$gameRel->_table}.ID_PLAYER = ?",
			'param' => array($player->ID_PLAYER)
		);

		$games = Doo::db()->find('SnGames', $params);
		return $games;
	}

	public function getSearchPlayerGames($phrase, $player = null, $limit){
		$game = new SnGames;
		$gameRel = new SnPlayerGameRel;
		$list = array();
		if($player == null)
			$player = User::getUser();

		if (strlen($phrase) > 2 and $player) {
			$params = array(
				'limit' => $limit,
				'asc' => "{$game->_table}.GameName",
				'where' => "{$game->_table}.GameName LIKE ?",
				'param' => array('%'. $phrase . '%')
			);
			$params['select'] = "{$game->_table}.*, {$gameRel->_table}.isPlaying, {$gameRel->_table}.isAdmin, {$gameRel->_table}.Comments";

			$params['filters'][] =  array('model' => "SnPlayerGameRel",
				'joinType' => 'INNER',
				'where' => "{$gameRel->_table}.isPlaying = 1 AND {$gameRel->_table}.ID_PLAYER = ?",
				'param' => array($player->ID_PLAYER)
			);
			$list = Doo::db()->find('SnGames', $params);
		}

		return $list;
	}

	/**
	 * Returns relation between player and game
	 * @param type $gameID
	 * @return SnPlayerGameRel
	 */
	public function getPlayerGameRel(SnGames $game, Players $player = null) {
		if($player == null) { $player = User::getUser(); }

		if($player) {
			$pgr = new SnPlayerGameRel();
			$pgr->ID_PLAYER = $player->ID_PLAYER;
			$pgr->ID_GAME = $game->ID_GAME;
			$result = $pgr->getOne();

			return $result;
		}
        return NULL;
	}


	/**
	 * saves description writen by player to game he's playing
	 * @param type $gameID
	 * @return boolean
	 */
	public function savePlayerGameDescription($post) {
		$p = User::getUser();
		if($p and !empty($post)) {
			$gameRel = new SnPlayerGameRel;
			$gameRel->Comments = ContentHelper::handleContentInput($post['game_description']);

			$gameRel->update(array('field' => 'Comments',
									'where' => 'ID_PLAYER = ? AND ID_GAME = ?',
									'param' => array($p->ID_PLAYER, intval($post['game_id']))
									));

			return true;
		}

		return false;

	}

	public function searchGames($q){
		$p = User::getUser();

		if($p){
			$g = new SnGames();
			$rel = new SnPlayerGameRel();

			$params['where'] = "GameName LIKE ? AND {$g->_table}.ID_GAME
						NOT IN (SELECT {$rel->_table}.ID_GAME FROM {$rel->_table} WHERE {$rel->_table}.ID_PLAYER = ? AND {$rel->_table}.isPlaying = 1)";
			$params['param'] = array('%'.ContentHelper::handleContentInput($q).'%', $p->ID_PLAYER);

			return Doo::db()->find('SnGames', $params);
		}

		return array();
	}

	 /**
	 * Returns array of assigned platforms by ID_GAME
	 *
	 * @param SnGames $game
	 * @return array
	 */
	public function getAssignedPlatformsByGameId($gameID) {
		$rel = new SnGamesPlatformsRel();
		$platform = new SnPlatforms();

		$params = array(
			'SnPlatforms' => array(
				'select'   => "{$rel->_table}.*, {$platform->_table}.*"
			,	'joinType' => 'LEFT'
			,	'where'    => "{$rel->_table}.ID_GAME = $gameID"
			,	'asc'     => "{$platform->_table}.PlatformName"
			)
		);

		$list = Doo::db()->relateMany('SnGamesPlatformsRel', array('SnPlatforms'), $params);

				return $list;
	}

	/**
	 * Returns amount of game types
	 *
	 * @return int
	 */
	public function getTotalGameTypes() {
		$nc = new SnGameTypes();
		$totalNum = (object) Doo::db()->fetchRow('SELECT COUNT(1) as cnt FROM `' . $nc->_table . '` LIMIT 1');
		return $totalNum->cnt;
	}

	public function createGameType($post) {
			if (!empty($post)) {
					$type = new SnGameTypes();
					$type->GameTypeName = ContentHelper::handleContentInput($post['GameTypeName']);
					$type->GameTypeDesc = ContentHelper::handleContentInput($post['GameTypeDesc']);
					$type->insert();
					return $type;
			}
			return false;
	}

	public function updateGameType(SnGameTypes $type, $post) {
			if (!empty($post)) {
					$type->GameTypeName = ContentHelper::handleContentInput($post['GameTypeName']);
					$type->GameTypeDesc = ContentHelper::handleContentInput($post['GameTypeDesc']);
					$locales = Doo::db()->find('SnGameTypeLocale', array(
			'where' => 'ID_GAMETYPE = ?',
			'param' => array($type->ID_GAMETYPE)
					));
					if (!empty($locales)) {
						foreach ($locales as $l) {
								$l->delete();
						}
					}
					$type->update();

					return $type;
			}
			return false;
	}

	/**
	* Deletes game type item
	* @param int $typeID
	* @return boolean
	*/
	public function deleteGameType($typeID) {
			$typeID = intval($typeID);

			if ($typeID > 0) {
				$gameType = $this->getGameTypeByID($typeID);

				$locales = Doo::db()->find('SnGameTypeLocale', array(
			'where' => 'ID_GAMETYPE = ?',
			'param' => array($gameType->ID_GAMETYPE)
		));
				if (!empty($locales)) {
						foreach ($locales as $l) {
								$l->delete();
						}
				}

				$gameType->delete();
				return TRUE;
			}

			return FALSE;
	}

	/**
	* Merges game type items
	* @param int $typeID
	* @return boolean
	*/
	public function mergeGameTypes($post) {
			if (!empty($post)) {
				$gameType = $this->getGameTypeByID(ContentHelper::handleContentInput($post['ID_GAMETYPE']));

				$games = Doo::db()->find('SnGames', array(
			'where' => 'ID_GAMETYPE = ?',
			'param' => array($gameType->ID_GAMETYPE)
		));
				if (!empty($games)) {
						foreach ($games as $g) {
							$type = $this->getGameTypeByID(ContentHelper::handleContentInput($post['tab']));
							$g->ID_GAMETYPE = ContentHelper::handleContentInput($post['tab']);
							$g->GameType = $type->GameTypeName;
							$g->update();
						}
						return TRUE;
				}
				return TRUE;
			}

			return FALSE;
	}

	/**
	 * Returns gametype item
	 *
	 * @return SnGames object
	 */
	public static function getGameTypeByID($id) {
		$item = Doo::db()->getOne('SnGameTypes', array(
			'limit' => 1,
			'where' => 'ID_GAMETYPE = ?',
			'param' => array($id)
				));
		return $item;
	}

	// added
	public function getMembers(SnGames $group, $limit = 0) {
		$cgr = new SnPlayerGamesRel();
		$params = array();

		$params = array('model' => "SnPlayerGamesRel",
			'joinType' => 'INNER',
			'match' => TRUE,
			'where' => "{$cgr->_table}.ID_GROUP = ? AND isMember = 1".MainHelper::getSuspendQuery("sn_playergroup_rel.ID_PLAYER"),
			'param' => array($group->ID_GROUP),

		);

		$params['limit'] = $limit;
		$params['asc'] = 'FirstName';
		$members = Doo::db()->relate('Players', 'SnPlayerGroupRel', $params);

		return $members;
	}




}