<?php
class Search{
	/**
	 * Returns number of results
	 *
	 * @param String $phrase
	 * @return int
	 */
	public function getTopSearchTotal($phrase) {
		if($phrase and mb_strlen($phrase) >= 3) {
			$player = User::getUser();
			if($player) {
				$lang = $player->ID_LANGUAGE;
			} else {
				$lang = 1;
			}
			$params = array();
			$params['limit'] = 1;
			$params['select'] = "COUNT(1) as cnt";
			$params['where'] = "Data Like ? AND FieldType IN (?,?,?,?,?,?,?,?,?,?)"; // AND ID_LANGUAGE = ?";
			$params['param'] = array('%'.$phrase.'%', SEARCH_PLAYER, SEARCH_COMPANY, SEARCH_GAME, SEARCH_GROUP, SEARCH_NEWS,
									 SEARCH_EVENT, SEARCH_PRODUCT, SEARCH_BLOG, SEARCH_REVIEW, SEARCH_DOWNLOAD); //, $lang);

			$result = Doo::db()->find('SnSearch', $params);
			return $result->cnt;
		}

		return 0;
	}

	/**
	 * Returns search results
	 *
	 * @param String $phrase
	 * @return collection of SnSearch
	 */
	public function getTopSearch($phrase, $limit = 10, $live=0) {
		if(!empty($phrase) && mb_strlen($phrase) >= 3) {
            $search = new SnSearch();
            $params = array(
                'limit' => $limit,
                'param' => array('%'.$phrase.'%'),
                'where' => "Data Like ?",
            );
            if($live === 0) {
                $params['asc'] = 'FieldType';
                array_push($params['param'], SEARCH_PLAYER, SEARCH_COMPANY, SEARCH_GAME, SEARCH_GROUP, SEARCH_NEWS,
										 SEARCH_EVENT, SEARCH_PRODUCT, SEARCH_BLOG, SEARCH_REVIEW, SEARCH_DOWNLOAD);
                $params['where'] .= " AND FieldType IN (?,?,?,?,?,?,?,?,?,?)";
            };
            if(Auth::isUserLogged()) {
                $langs = User::getUser()->ID_LANGUAGE . ',' . User::getUser()->OtherLanguages;
                $params['where'] .= " AND ID_LANGUAGE IN ({$langs})";
            } else {
                $curLang = Lang::getCurrentLangID();
                array_push($params['param'], $curLang);
                $params['where'] .= " AND ID_LANGUAGE = ?";
            };
			return $search->find($params);
//            $player = User::getUser();
//            if($player) {
//                    $lang = $player->ID_LANGUAGE;
//            } else {
//                    $lang = 1;
//            }
//			$params = array();
//			$params['limit'] = $limit;
//			if($live === 0) {
//				$params['asc'] = 'FieldType';
//				$params['param'] = array('%'.$phrase.'%', SEARCH_PLAYER, SEARCH_COMPANY, SEARCH_GAME, SEARCH_GROUP, SEARCH_NEWS,
//										 SEARCH_EVENT, SEARCH_PRODUCT, SEARCH_BLOG, SEARCH_REVIEW, SEARCH_DOWNLOAD);
//			} else {
//				$params['param'] = array($phrase.'%', SEARCH_PLAYER, SEARCH_COMPANY, SEARCH_GAME, SEARCH_GROUP, SEARCH_NEWS,
//										 SEARCH_EVENT, SEARCH_PRODUCT, SEARCH_BLOG, SEARCH_REVIEW, SEARCH_DOWNLOAD);
//				$params['param'] = array($phrase.'%');
//			}
//			$params['where'] = "Data Like ? AND FieldType IN (?,?,?,?,?,?,?,?,?,?)";
//			$params['where'] = "Data Like ?"; // AND FieldType IN (?,?,?,?,?,?,?,?,?,?)";
//			$search = Doo::db()->find('SnSearch', $params);
//			return $search;
		}
		return array();
	}

	/**
	 * Returns number of results
	 *
	 * @param String $phrase
	 * @return int
	 */
	public function getSearchTotal($phrase, $type, $owner = "", $ownerID = 0) {
		if ($phrase and mb_strlen($phrase) >= 3) {

			if ($type == SEARCH_PRODUCT)
			{
				$result = $this->getSearch($phrase, $type, "0,1000000", $owner, $ownerID);
				return count($result);
			}

			$contentchildFunctions = MainHelper::GetModuleFunctionsByTag('contentchild');

			if ($contentchildFunctions['contentchildFreeToPlay']==0 && $type==SEARCH_GAME)
			{
				$query = "SELECT COUNT(*) as cnt FROM sn_games WHERE (GameName LIKE '%$phrase%' OR GameDesc LIKE '%$phrase%') AND isFreePlay=0";
				$totalNum = (object) Doo::db()->fetchRow($query);
				return $totalNum->cnt;
			}

			if ($type==SEARCH_PLAYER)
			{
//				$params['where'] .= MainHelper::getSuspendQuery("player");
				$query = "SELECT DISTINCT COUNT(*) as cnt FROM sn_players
					WHERE (FirstName LIKE '%$phrase%' OR LastName LIKE '%$phrase%' OR NickName LIKE '%$phrase%' OR DisplayName LIKE '%$phrase%') ". MainHelper::getSuspendQuery("sn_players.ID_PLAYER");
				$totalNum = (object) Doo::db()->fetchRow($query);
				return $totalNum->cnt;
			}
						if ($type==SEARCH_ACHIEVEMENT)
			{
				$query = "SELECT COUNT(*) as cnt FROM ac_achievements WHERE (Name LIKE '%$phrase%' OR Description LIKE '%$phrase%')";
				$totalNum = (object) Doo::db()->fetchRow($query);
				return $totalNum->cnt;
			}

			$params = array();
						$params['limit'] = 1;
			$params['select'] = "COUNT(1) as cnt";
						$params['where'] = "Data Like ? AND FieldType = ?";
						$params['param'] = array('%'.$phrase.'%', $type);

			if(strlen($owner) > 0 and $ownerID > 0) {
				$params['where'] .= " AND ID_OWNER = ? AND OwnerType = ?";
				$params['param'][] = $ownerID;
				$params['param'][] = $owner;
			}



			$search = Doo::db()->find('SnSearch', $params);

			return $search->cnt;
		}

		return 0;
	}

	/**
	 * Returs search results
	 *
	 * @param String $phrase
	 * @return collection of NwItems
	 */
	public function getSearch($phrase, $type, $limit, $owner = "", $ownerID = 0) {
		if ($phrase and mb_strlen($phrase) >= 3) {
			$params = array();
			$params['select'] = 'ID_ITEM';
			$params['asc'] = 'FieldType';
			$params['where'] = "Data Like ? AND FieldType = ?";
			$params['param'] = array('%'.$phrase.'%', $type);


			if(strlen($owner) > 0 and $ownerID > 0) {
				$params['where'] .= " AND ID_OWNER = ? AND OwnerType = ?";
				$params['param'][] = $ownerID;
				$params['param'][] = $owner;
			}

			$search = Doo::db()->find('SnSearch', $params);

			$contentchildFunctions = MainHelper::GetModuleFunctionsByTag('contentchild');

			$result = array();
			if(!empty($search)) {
				$ids = array();
				foreach($search as $s) {
					$ids[] = $s->ID_ITEM;
				}
				if($type == SEARCH_COMPANY) {
					$companies = new SnCompanies();
					$query = "SELECT * FROM {$companies->_table} WHERE ID_COMPANY IN ('".implode("','", $ids)."') ORDER BY CompanyName ASC LIMIT $limit";
					$q = Doo::db()->query($query);
					$result = $q->fetchAll(PDO::FETCH_CLASS, 'SnCompanies');
				} else if ($type == SEARCH_GAME) {
					$games = new SnGames();
					$notFree = "";
					if ($contentchildFunctions['contentchildFreeToPlay']==0)
						$notFree = "AND isFreePlay=0";
					$query = "SELECT * FROM {$games->_table} WHERE ID_GAME IN ('".implode("','", $ids)."') {$notFree} ORDER BY GameName ASC LIMIT $limit";
					$q = Doo::db()->query($query);
					$result = $q->fetchAll(PDO::FETCH_CLASS, 'SnGames');
				} else if ($type == SEARCH_GROUP) {
					$groups = new SnGroups();
					$query = "SELECT * FROM {$groups->_table} WHERE ID_GROUP IN ('".implode("','", $ids)."') ORDER BY GroupName ASC LIMIT $limit";
					$q = Doo::db()->query($query);
					$result = $q->fetchAll(PDO::FETCH_CLASS, 'SnGroups');
				} else if ($type == SEARCH_PLAYER) {
					$players = new Players();
					$query = "SELECT * FROM {$players->_table} WHERE ID_PLAYER IN ('".implode("','", $ids)."') ".MainHelper::getSuspendQuery("{$players->_table}.ID_PLAYER")." ORDER BY Nickname ASC LIMIT $limit";
					$q = Doo::db()->query($query);
					$result = $q->fetchAll(PDO::FETCH_CLASS, 'Players');
				} else if ($type == SEARCH_NEWS) {
					//FIX THIS
					$newsTable = new NwItems;
					$newsTableLocale = new NwItemLocale;
					$params['NwItemLocale'] = array(
						'select' => "{$newsTable->_table}.*, {$newsTableLocale->_table}.*", //, {$locale->_table}.Headline as THeadline, {$locale->_table}.NewsText as TNewsText, {$locale->_table}.ID_LANGUAGE as TID
						'limit' => Doo::conf()->topNewsLimit,
						'desc' => "{$newsTableLocale->_table}.Headline",
						'where' => "{$newsTable->_table}.isInternal = 0 AND {$newsTable->_table}.Published = 1 AND {$newsTable->_table}.ID_NEWS IN (?)",
						'param'=> array(implode("','", $ids)),
						'joinType' => 'LEFT',
					);
					$result = Doo::db()->relateMany('NwItems', array('NwItemLocale'), $params);
					News::applyPathAndLang($result);
				} else if ($type == SEARCH_PRODUCT) {
					$products = new FiProducts();

					if (MainHelper::IsModuleEnabledByTag('memberships') == 0)
						$isSpecialPremOffer = " AND {$products->_table}.isSpecialPremOffer <> 1 AND {$products->_table}.isFeatured <> 1 ";

					$query = "SELECT * FROM {$products->_table} WHERE ID_PRODUCT IN ('".implode("','", $ids)."') {$isSpecialPremOffer} ORDER BY ProductName ASC LIMIT $limit";
					$q = Doo::db()->query($query);
					$result = $q->fetchAll(PDO::FETCH_CLASS, 'FiProducts');
				} else if ($type == SEARCH_ACHIEVEMENT) {
					$achievements = new AcAchievements();

					$query = "SELECT * FROM {$achievements->_table} WHERE ID_ACHIEVEMENT IN ('".implode("','", $ids)."') ORDER BY Name ASC LIMIT $limit";
					$q = Doo::db()->query($query);
					$result = $q->fetchAll(PDO::FETCH_CLASS, 'AcAchievements');
				}
			}

			return $result;
		}

		return array();
	}

	public function getSubPageSearch($phrase, $type, $limit = 10) {
		if($phrase && mb_strlen($phrase) >= 3) {
			$params = array();
			$params['limit'] = $limit;
            $params['asc'] = 'FieldType';
            $params['param'] = array('%'.$phrase.'%', $type);
            $params['where'] = "Data Like ? AND FieldType = ?";

			$search = Doo::db()->find('SnSearch', $params);

			return $search;
		}
	}
}
?>