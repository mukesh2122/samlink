<?php

class Blog {

	public function getTopBlog() {
		$locale = new NwItemLocale;
		$items = new NwItems;
		$player = User::getUser();
		if ($player)
			$langID = $player->ID_LANGUAGE.','.$player->OtherLanguages;
		else
			$langID = Lang::getCurrentLangID().',1';

		$params['NwItemLocale'] = array(
			'select' => "{$items->_table}.*, {$locale->_table}.*", //, {$locale->_table}.Headline as THeadline, {$locale->_table}.NewsText as TNewsText, {$locale->_table}.ID_LANGUAGE as TID
			'limit' => Doo::conf()->topNewsLimit,
			'desc' => "{$items->_table}.Featured",
			'where' => "{$items->_table}.isInternal = 0 AND ".
					   "{$items->_table}.Published = 1 AND ".
					   "{$locale->_table}.Published = 1 AND ".
					   "{$locale->_table}.ID_LANGUAGE IN (".$langID.") AND ".
					   "{$items->_table}.OwnerType = 'player' AND ".
					   "{$items->_table}.isReview = 0",
					   "{$items->_table}.isBlog = 1",
			'joinType' => 'LEFT',
		);

		$list = Doo::db()->relateMany('NwItems', array('NwItemLocale'), $params);
		$this->applyPathAndLang($list);

		return $list;
	}
        
        public function getMostReadBlog($limit = 5) {
		$locale = new NwItemLocale;
		$items = new NwItems;
		$mostRead = new NwMostRead;
		$player = User::getUser();
		if ($player)
			$langID = $player->ID_LANGUAGE.','.$player->OtherLanguages;
		else
			$langID = Lang::getCurrentLangID().',1';

		$params = array(
			'NwItemLocale' => array(
				'select'   => "{$mostRead->_table}.*, SUM({$mostRead->_table}.ShowCount) AS TotalShowCount, {$locale->_table}.* "
			,	'joinType' => 'LEFT'
			,	'where'    => "{$mostRead->_table}.ReadDate >= DATE_SUB(CURDATE(), INTERVAL 7 DAY) AND "
				.             "{$locale->_table}.Published = 1 AND "
                                .             "{$locale->_table}.isBlog = 1 AND "
				.             "{$locale->_table}.ID_LANGUAGE IN (".$langID.")"
			,	'groupby'  => "{$mostRead->_table}.ID_NEWS"
			,	'desc'     => "TotalShowCount"
			,	'limit'    => Doo::conf()->mostReadNewsLimit,
			)
		,	'NwItems' => array(
				'select'   => "{$mostRead->_table}.*, SUM({$mostRead->_table}.ShowCount) AS TotalShowCount, {$items->_table}.* "
			,	'joinType' => 'LEFT'
			,	'where'    => "{$mostRead->_table}.ReadDate >= DATE_SUB(CURDATE(), INTERVAL 7 DAY) AND "
                                .             "{$items->_table}.isBlog = 1 AND "
				.             "{$items->_table}.Published = 1"
			,	'groupby'  => "{$mostRead->_table}.ID_NEWS"
			,	'desc'     => "TotalShowCount"
			)
		);

		$list = Doo::db()->relateMany('NwMostRead', array('NwItemLocale','NwItems'), $params);
		$this->applyPathAndLang($list);

		return $list;
	}
        
        public function getMostPopularBlog($limit = 5) {
		$locale = new NwItemLocale;
		$items = new NwItems;
                $replies = new NwReplies;
                
                $params = array(
			'NwItemLocale' => array(
				'select'   => "COUNT(nw_replies.ReplyNumber) as cnt, {$locale->_table}.* "
			,	'joinType' => 'LEFT'
			,	'where'    => "{$replies->_table}.PostingTime >= UNIX_TIMESTAMP(UTC_TIMESTAMP()) - 604800 AND "
				.             "{$locale->_table}.Published = 1 AND "
                                .             "{$locale->_table}.isBlog = 1 "
			,	'groupby'  => "{$replies->_table}.ID_NEWS"
			,	'desc'     => "cnt"
			)
		,	'NwItems' => array(
				'select'   => "COUNT(nw_replies.ReplyNumber) as cnt, {$items->_table}.* "
			,	'joinType' => 'LEFT'
			,	'where'    => "{$replies->_table}.PostingTime >= UNIX_TIMESTAMP(UTC_TIMESTAMP()) - 604800 AND "
				.             "{$items->_table}.Published = 1 AND "
                                .             "{$items->_table}.isBlog = 1 AND "
                                .             "{$items->_table}.Replies >= 1 "
			,	'groupby'  => "{$replies->_table}.ID_NEWS"
			,	'desc'     => "cnt"
			)
		);

		$list = Doo::db()->relateMany('NwReplies', array('NwItemLocale','NwItems'), $params);
		$this->applyPathAndLang($list);
                
		return $list;
	}
        
        // $age = number of days to go back from current timestamp
        public function getRandomBlog($age = 60, $limit = 1) {
		$locale = new NwItemLocale;
		$items = new NwItems;
                $itemAge = time() - (60 * 60 * 24 * $age); // UNIX_timestamp - (60 seconds * 60 minutes * 24 hours * $age days)

		$params['NwItemLocale'] = array(
			'select' => "{$items->_table}.*, {$locale->_table}.*", //, {$locale->_table}.Headline as THeadline, {$locale->_table}.NewsText as TNewsText, {$locale->_table}.ID_LANGUAGE as TID
			'limit' => "{$limit}",
			'asc' => "RAND()",
			'where' => "{$locale->_table}.Published = 1 AND ".
					   "{$items->_table}.isReview = 0 AND ".
					   "{$items->_table}.isBlog = 1 AND ".
                                           "{$items->_table}.PostingTime>={$itemAge} AND ".
                                           "{$items->_table}.ID_NEWS >= (SELECT FLOOR( MAX({$items->_table}.ID_NEWS) * RAND()) FROM {$items->_table} )", 
			'joinType' => 'LEFT',
		);

		$list = Doo::db()->relateMany('NwItems', array('NwItemLocale',), $params);
		$this->applyPathAndLang($list);
		return $list;
	}
        
        public function getTotalBlogsByUser($userID) {
        $blogs = new NwItems;

        $rs = Doo::db()->query("SELECT COUNT(1) as total FROM {$blogs->_table} WHERE ID_AUTHOR = $userID AND isBlog = 1");
        $total = $rs->fetch();
        return $total['total'];
        }
        
        public function getBlogDescriptionByUser($userID) {
        $field = MainHelper::GetExtraFieldByFieldName('player', 'Blog description');
        $query = Doo::db()->query("SELECT sn_playersextra_rel.* 
                                FROM sn_playersextra_rel 
                                WHERE ID_OWNER = $userID 
                                AND ID_FIELD = {$field[0]['ID_FIELD']}");
        $rs = $query->fetch();
        return $rs['ValueText'];
        }
        
        public function mergeBloggerBlogs($limit) {
            $players = new User();
            $blog = new Blog();
            $bloggers = $players->getAllBloggers($limit);
            foreach($bloggers as $key => $item) {
                $bloggers[$key]['BlogCount'] = $blog->getTotalBlogsByUser($item['ID_PLAYER']);
                $bloggers[$key]['BlogDescription'] = "";
                $f = $blog->getBlogDescriptionByUser($item['ID_PLAYER']);
                if(!empty($f)) $bloggers[$key]['BlogDescription'] = $f;
                else $bloggers[$key]['BlogDescription'] = "";
            }
            return $bloggers;
        }
        
        
	/**
	 * Returns categories with subcategories due to defined type
	 *
	 * @return
	 */
	public function getCategoriesByType($type)
	{
		$currentDBconf = Doo::db()->getDefaultDbConfig();
		if ($type == NEWS_PLATFORM) {
			if (Doo::conf()->cache_enabled == TRUE) {
				if (Doo::cache('apc')->get(CACHE_PLATFORMS . '_' . $currentDBconf[0] . '_' . $currentDBconf[1])) {
					return Doo::cache('apc')->get(CACHE_PLATFORMS . '_' . $currentDBconf[0] . '_' . $currentDBconf[1]);
				}
			}
			$platforms = Doo::db()->find('SnPlatforms', array('asc' => 'PlatformName'));
			if (Doo::conf()->cache_enabled == TRUE) {
				Doo::cache('apc')->set(CACHE_PLATFORMS . '_' . $currentDBconf[0] . '_' . $currentDBconf[1], $platforms, CACHETIME_NEWS_CATEGORY);
			}

			return $platforms;
		} else if ($type == NEWS_GAMES) {
			$games = Doo::db()->find('SnGames', array(
				'limit' => Doo::conf()->newsCatsLimit,
				'desc' => 'NewsCount',
				'asc' => 'GameName',
					));

			if (Doo::conf()->cache_enabled == TRUE) {
				Doo::cache('apc')->set(CACHE_GAMES . '_' . $currentDBconf[0] . '_' . $currentDBconf[1], $games, CACHETIME_NEWS_CATEGORY);
			}

			return $games;
		} else if ($type == NEWS_COMPANIES) {
			$company = Doo::db()->find('SnCompanies', array(
				'limit' => Doo::conf()->newsCatsLimit,
				'desc' => 'NewsCount',
				'asc' => 'CompanyName',
					));

			if (Doo::conf()->cache_enabled == TRUE) {
				Doo::cache('apc')->set(CACHE_COMPANIES . '_' . $currentDBconf[0] . '_' . $currentDBconf[1], $company, CACHETIME_NEWS_CATEGORY);
			}

			return $company;
		} else if ($type == NEWS_LOCAL) {
			$countries = Doo::db()->find('GeCountries', array(
				'limit' => Doo::conf()->newsCatsLimit,
				'desc' => 'NewsCount',
				'asc' => 'Country',
				'where' => 'NewsCount > 0',
					));

			if (!empty($countries)) {
				foreach ($countries as &$c) {
					$params = array();
					$params['limit'] = Doo::conf()->newsCatsLimit;
					$params['desc'] = "NewsCount";
					$params['asc'] = 'AreaName';
					$params['where'] = "ID_COUNTRY = ? AND NewsCount > 0";
					$params['param'] = array($c->ID_COUNTRY);
					$areas = Doo::db()->find('GeAreas', $params);

					if ($areas) {
						$c->GeAreas = $areas;
					}
					$areas = null;
				}
			}
			if (Doo::conf()->cache_enabled == TRUE) {
				Doo::cache('apc')->set(CACHE_COUNTRIES . '_' . $currentDBconf[0] . '_' . $currentDBconf[1], $newCountries, CACHETIME_NEWS_CATEGORY);
			}

			return $countries;
		}
	}

	/**
	 * Returns article item
	 *
	 * @return NwItems object
	 */
	public static function getArticleByID($id, $langID = 0) {
		$items = new NwItems;
		$locale = new NwItemLocale;

		if ($langID > 0) {
			$params['NwItemLocale'] = array(
				'limit' => 100,
				'desc' => "{$items->_table}.PostingTime",
				'where' => "{$items->_table}.ID_NEWS = ? AND {$locale->_table}.ID_LANGUAGE = ?",
				'param' => array($id, $langID),
				'joinType' => 'LEFT',
			);

			$item = Doo::db()->relateMany('NwItems', array('NwItemLocale'), $params);

			//adds related platforms, games, companies
			if ($item) {
				$item[0]->addRelatedCategories();
				$item[0]->applyUserLangs();
			}
			return $item[0];
		} else {
			$item = Doo::db()->find('NwItems', array(
				'where' => 'ID_NEWS = ?',
				'param' => array($id),
				'limit' => 1
					));

			return $item;
		}
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
	public function setLike($type, $id, $replyNumber = 0, $l = 0) {
		$p = User::getUser();
		if ($p) {
			$like = new NwLikes();

			$like->ID_NEWS = $id;
			$like->ReplyNumber = $replyNumber;
			$like->ID_PLAYER = $p->ID_PLAYER;
			$like->purgeCache();

			$newLike = $like->getOne();
			if (empty($newLike)) {
				$like->Likes = $l;
				$like->insert();
			} else {
				//like
				$like->ID_LIKE = $newLike->ID_LIKE;
				if ($l == 1) {
					if ($newLike->Likes == 0) {
						$like->Likes = 1;
						$like->update(array('field' => 'Likes'));
					}
				} else {
					if ($newLike->Likes == 1) {
						$like->Likes = 0;
						$like->update(array('field' => 'Likes'));
					}
				}
			}

			if ($replyNumber > 0) {
				$nwItem = new NwReplies();
				$nwItem->ReplyNumber = $replyNumber;
			} else {
				$nwItem = new NwItems();
			}

			$nwItem->ID_NEWS = $id;
			$nwItem->purgeCache();
			$p->purgeCache();
			$nwItem = $nwItem->getOne();

			return array($nwItem->LikeCount, $nwItem->DislikeCount);
		}
	}

	/**
	 * Inserts news item reply
	 *
	 * @param Players $p
	 * @param int $postID
	 * @param String $comment
	 * @return int - post id
	 */
	public function setReply(Players &$p, $postID, $langID = 1, $comment) {
		$article = $this->getArticleByID($postID, $langID);

		if ($p->ID_PLAYER && strlen($comment) > 0 && !empty($article)) {

			$newsreply = new NwReplies();
			$newsreply->ID_NEWS = $postID;
			$newsreply->ID_OWNER = $p->ID_PLAYER;
			$newsreply->ID_LANGUAGE = $langID;
			$newsreply->Message = trim(ContentHelper::handleContentInput($comment));
			$newsreply->insert();

			$newsreply->purgeCache();
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
	public function getReply($id, $langID = 1) {
		$id = (int) $id;
		if ($id) {
			$wr = Doo::db()->find('NwReplies', array(
				'limit' => 1,
				'desc' => 'ReplyNumber',
				'where' => 'ID_NEWS = ? AND ID_LANGUAGE = ?',
				'param' => array($id, $langID)
					));
			return $wr;
		}
		return new SnWallitems();
	}

	/**
	 * Returns amount of replies in current post
	 *
	 * @param int $pid
	 * @return int
	 */
	public function getTotalRepliesByPostID($pid, $langID = 1) {
		$totalNum = 0;

		$nr = new NwReplies();
		$totalNum = (object) Doo::db()->fetchRow('SELECT COUNT(1) as cnt FROM `' . $nr->_table . '` as wr
                                        WHERE wr.ID_NEWS = ? AND ID_LANGUAGE = ?
                                        LIMIT 1', array($pid, $langID));

		return $totalNum->cnt;
	}

	/**
	 * Returs list of comments by post id
	 *
	 * @param int $type
	 * @return Object $post_list
	 */
	public function getRepliesList($id, $langID = 1, $offset = 0) {
		$id = (int) $id;
		if ($id) {
			$replies = new NwReplies;
			if ($offset > 0) {
				$newsreplies = Doo::db()->relate('NwReplies', 'Players', array(
					'limit' => $offset,
					'desc' => 'ReplyNumber',
					'where' => "ID_NEWS = ? AND {$replies->_table}.ID_LANGUAGE = ?",
					'param' => array($id, $langID),
					'match' => true
						));
				if (!empty($newsreplies))
					return array_reverse($newsreplies);
				return array();
			} else {
				$newsreplies = Doo::db()->relate('NwReplies', 'Players', array(
					'asc' => 'ReplyNumber',
					'where' => "ID_NEWS = ? AND {$replies->_table}.ID_LANGUAGE = ?",
					'param' => array($id, $langID),
					'match' => true
						));
				return $newsreplies;
			}
		}

		return array();
	}

	/**
	 * Returs list of games by first letter
	 *
	 * @param String $letter
	 * @return SnGames collection
	 */
	public function getAllGames($limit = 21, $topOnly = false) {
		$c = new SnGames();
		$params = array();
		$params['limit'] = $limit;
		$params['select'] = "{$c->_table}.*";

		if ($topOnly == true) {
			$params['where'] = "NewsCurrentTop > 0";
			$params['desc'] = 'NewsCurrentTop';
		} else {
			$params['asc'] = 'GameName';
		}
		$games = Doo::db()->find('SnGames', $params);
		return $games;
	}

	/**
	 * Returs list of companies by first letter
	 *
	 * @param String $letter
	 * @return SnGames collection
	 */
	public function getAllCompanies($limit = 21, $topOnly = false) {
		$c = new SnCompanies();
		$params = array();
		$params['limit'] = $limit;
		$params['select'] = "{$c->_table}.*";

		if ($topOnly == true) {
			$params['where'] = "NewsCurrentTop > 0";
			$params['desc'] = 'NewsCurrentTop';
		} else {
			$params['asc'] = 'CompanyName';
		}
		$companies = Doo::db()->find('SnCompanies', $params);
		return $companies;
	}

	/**
	 * Returs list of countries by first letter
	 *
	 * @param String $letter
	 * @return SnGames collection
	 */
	public function getAllCountries($letter) {
		if ($letter) {
			$c = new GeCountries();
			$params = array();
			$params['select'] = "{$c->_table}.*";
			$params['asc'] = 'Country';
			$params['where'] = "{$c->_table}.Country Like ?";
			$params['param'] = array($letter . '%');
			$countries = Doo::db()->find('GeCountries', $params);
			return $countries;
		}

		return array();
	}

	/**
	 * Returs number of results
	 *
	 * @param String $phrase
	 * @return int
	 */
	public function getSearchTotal($phrase) {
		if ($phrase and mb_strlen($phrase) >= 3) {
			$params = array();
			$params['limit'] = 1;
			$params['select'] = "COUNT(1) as cnt";
			$params['where'] = "(Headline Like ? OR NewsText Like ?) AND Published = 1";
			$params['param'] = array('%' . $phrase . '%', '%' . $phrase . '%');
			$result = Doo::db()->find('NwItems', $params);
			return $result->cnt;
		}

		return 0;
	}

	/**
	 * Returs search results
	 *
	 * @param String $phrase
	 * @return collection of NwItems
	 */
	public function getSearch($phrase, $limit) {
		if ($phrase and mb_strlen($phrase) >= 3) {
			$params = array();
			$params['limit'] = $limit;
			$params['desc'] = 'PostingTime';
			$params['where'] = "(Headline Like ? OR NewsText Like ?) AND Published = 1";
			$params['param'] = array('%' . $phrase . '%', '%' . $phrase . '%');
			$news = Doo::db()->find('NwItems', $params);

			$this->applyPathAndLang($news);

			return $news;
		}

		return array();
	}

	/**
	 * Creates news item
	 * @param array $post
	 * @return NwItem
	 */
	public function saveNews($post, $isReview = 0, $isBlog = 0) {
		extract($post);

//		if($language != 1) {
//			return false;
//		}

		$player = User::getUser();

		$imageUrl = "";
		if (!empty($_FILES['Filedata']) and $_FILES['Filedata']['size'] > 0) {
			$image = new Image();
			$result = $image->uploadImages(FOLDER_NEWSITEMS);
			if ($result['filename'] != '') {
				$imageUrl = $result['filename'];
			}
		}

		$news = new NwItems();
		$news->ID_OWNER = $ownerID;
		$news->OwnerType = $ownerType;
		$news->ID_PLATFORM = isset($platform) ? $platform : 0;
		$news->Published = ((isset($publishMainArticle) and $publishMainArticle == 1 and $player->canAccess('Approve news') === TRUE) or ($news->OwnerType == POSTRERTYPE_GROUP or ($isReview == 0 and $published == 1 and $isBlog == 0))) ? 1 : 0;
		$news->isReview = $isReview;
		$news->isBlog = $isBlog;
		$news->ID_AUTHOR = $player->ID_PLAYER;
		$newsID = $news->insert();

		$post['newsID'] = $newsID;
		$post['imageUrl'] = $imageUrl;
		$this->createUpdateLocale($post);
		Url::createUpdateURL($name, URL_NEWS, $newsID, $language);

		$news = $this->getArticleByID($newsID, $language);
		return $news;
	}

	private function createUpdateLocale($params) {
		extract($params);
		$player = User::getUser();

		$locale = new NwItemLocale();
		$locale->ID_NEWS = $newsID;
		$locale->ID_LANGUAGE = $language;
		$locale->purgeCache();

		$localeCheck = $locale->getOne();

		$locale->Headline = $name;
		$locale->IntroText = $messageIntro;
		$locale->NewsText = $messageText;
		if (isset($imageUrl))
			$locale->Image = $imageUrl;

		$locale->Published = ((isset($publishLangArticle) and $publishLangArticle == 1 and $player->canAccess('Approve news') === TRUE) or $ownerType == POSTRERTYPE_GROUP ) ? 1 : 0;

		if (isset($localeCheck) and !empty($localeCheck)) {
			$locale->update(array(
				'where' => 'ID_NEWS = ? AND ID_LANGUAGE = ?',
				'param' => array($newsID, $language)
			));
			$locale->purgeCache();
		} else {
			$locale->EditorNote = '';
			$locale->insert();
		}
		return $locale;
	}

	/**
	 * Updates news item
	 * @param array $post
	 * @return NwItem
	 */
	public function updateNews($post, $isReview = 0) {
		extract($post);
		$article = $this->getArticleByID($newsID);

		if ($article) {
			$player = User::getUser();

			$image = new Image();
			if (!empty($_FILES['Filedata']) and $_FILES['Filedata']['size'] > 0) {
				$locale = $article->getLangById($language);
				$image = new Image();
				$result = $image->uploadImages(FOLDER_NEWSITEMS, (isset($locale) and !empty($locale)) ? $locale->Image : '');
				if ($result['filename'] != '') {
					$imageUrl = $result['filename'];
					$post['imageUrl'] = $imageUrl;
				}
			} else if (isset($deleteImage)) {
				$locale = $article->getLangById($language);
				if (isset($locale) and !empty($locale)) {
					$image->deleteImage(FOLDER_NEWSITEMS, $locale->Image);
					$imageUrl = '';
					$post['imageUrl'] = $imageUrl;
				}
			}

			$this->createUpdateLocale($post);

			if($isReview == 0){
				$article->Published = $published;
			}

			//additional check if all languages are unpublished and main is published then main should not be published
			$locales = $article->getTranslatedLanguages(0, true);
			$published = false;
			if (!empty($locales)) {
				foreach ($locales as $l) {
					if ($l->Published == 1) {
						$published = true;
					}
				}
			}

			if($isReview == 0){
				if ($player->canAccess('Approve news') === TRUE) {
					$article->Published = isset($publishMainArticle) ? 1 : 0;
				} else {
					if ($published == false) {
						$article->Published = 0;
					}
				}
			}

			$article->ID_PLATFORM = isset($platform) ? $platform : 0;
			$article->update();
			$article->purgeCache();

			Url::createUpdateURL($name, URL_NEWS, $newsID, $language);
			$this->updateCache($article);
		}

		return $this->getArticleByID($newsID, $language);
	}

	/**
	 * Deletes news item
	 * @param int $newsID
	 * @return boolean
	 */
	public function deleteNewsItem($newsID) {
		$newsID = intval($newsID);

		if ($newsID > 0) {
			$article = $this->getArticleByID($newsID);

			$locales = $article->getTranslatedLanguages(0, true);
			if (!empty($locales)) {
				$image = new Image();
				foreach ($locales as $l) {
					$image->deleteImage(FOLDER_NEWSITEMS, $l->Image);
					$l->delete();
					Url::deleteURL(URL_NEWS, $newsID, $l->ID_LANGUAGE);
				}
			}

			$article->delete();
			return TRUE;
		}

		return FALSE;
	}

	/**
	 * returns list of latest/recent news
	 * @param int $limit
	 * @return NwItems
	 */
	public function getLatestBlog($limit = 4, $userID = "") {
		$locale = new NwItemLocale;
		$items = new NwItems;
		$player = User::getUser();
		if ($player)
			$langID = $player->ID_LANGUAGE.','.$player->OtherLanguages;
		else
			$langID = Lang::getCurrentLangID().',1';
                if(!empty($userID)) $paramUser = "{$items->_table}.ID_AUTHOR = $userID AND ";
                else $paramUser = "";
		$params['NwItemLocale'] = array(
			'select' => "{$items->_table}.*, {$locale->_table}.*", //, {$locale->_table}.Headline as THeadline, {$locale->_table}.NewsText as TNewsText, {$locale->_table}.ID_LANGUAGE as TID
			'limit' => $limit,
			'desc' => "{$items->_table}.PostingTime",
			'where' => "{$items->_table}.isInternal = 0 AND ".
                                           $paramUser.
					   "{$items->_table}.Published = 1 AND ".
					   "{$locale->_table}.Published = 1 AND ".
					   "{$locale->_table}.ID_LANGUAGE IN (".$langID.") AND ".
					   "{$items->_table}.OwnerType = 'player' AND ".
					   "{$items->_table}.isReview = 0",
					   "{$items->_table}.isBlog = 1",
			'joinType' => 'LEFT',
		);

		$list = Doo::db()->relateMany('NwItems', array('NwItemLocale'), $params);
		$this->applyPathAndLang($list);

		return $list;
	}

	public function getBlogTotal() {
		$totalNum = 0;
		$locale = new NwItemLocale;
		$items = new NwItems;
		$player = User::getUser();
		if ($player)
			$langID = $player->ID_LANGUAGE.','.$player->OtherLanguages;
		else
			$langID = Lang::getCurrentLangID().',1';

		$query = "SELECT COUNT(1) as cnt ".
				 "FROM {$items->_table} ".
				 "LEFT JOIN {$locale->_table} ON {$locale->_table}.ID_NEWS = {$items->_table}.ID_NEWS ".
				 "WHERE {$items->_table}.isInternal = 0 AND ".
					   "{$items->_table}.isReview = 0 AND ".
					   "{$items->_table}.isBlog = 1 AND ".
					   "{$items->_table}.Published = 1 AND ".
					   "{$locale->_table}.Published = 1 AND ".
					   "{$locale->_table}.ID_LANGUAGE IN (".$langID.") AND ".
					   "{$items->_table}.OwnerType = 'player'".
				 "LIMIT 1";

		$totalNum = (object) Doo::db()->fetchRow($query);

		return $totalNum->cnt;
	}

	public function getPopularNewsTotal() {
		$totalNum = 0;
		$ni = new NwItems();
		$totalNum = (object) Doo::db()->fetchRow('SELECT COUNT(1) as cnt FROM `' . $ni->_table . '`
										WHERE isInternal = 0  AND isReview = 0 AND isBlog = 0 AND Published = 1 AND isPopular = 2  AND OwnerType <> \'group\'
                                        LIMIT 1');

		return $totalNum->cnt;
	}

	public function getPlatformNewsTotal($platformID) {
		$totalNum = 0;
		$ni = new NwItems();
		$gameplatrel = new SnGamesPlatformsRel();
		$totalNum = (object) Doo::db()->fetchRow("SELECT COUNT(1) as cnt FROM {$ni->_table}
										WHERE {$ni->_table}.isInternal = 0 AND {$ni->_table}.isReview = 0 AND {$ni->_table}.isBlog = 0 AND {$ni->_table}.Published = 1 AND ({$ni->_table}.ID_PLATFORM = ? OR ({$ni->_table}.ID_PLATFORM = 0 AND {$ni->_table}.OwnerType = ? AND {$ni->_table}.ID_OWNER IN (SELECT {$gameplatrel->_table}.ID_GAME FROM {$gameplatrel->_table} WHERE {$gameplatrel->_table}.ID_PLATFORM = ?))) AND {$ni->_table}.OwnerType <> 'group' LIMIT 1", array($platformID, 'game', $platformID));

		return $totalNum->cnt;
	}

	public function getTotalByType($posterID, $OwnerType)
	{
		$totalNum = 0;
		$locale = new NwItemLocale;
		$items = new NwItems;
		$player = User::getUser();
		if ($player)
			$langID = $player->ID_LANGUAGE.','.$player->OtherLanguages;
		else
			$langID = Lang::getCurrentLangID().',1';

		$query = "SELECT COUNT(1) as cnt ".
				 "FROM {$items->_table} ".
				 "LEFT JOIN {$locale->_table} ON {$locale->_table}.ID_NEWS = {$items->_table}.ID_NEWS ".
				 "WHERE {$items->_table}.ID_OWNER = ? AND ".
					   "{$items->_table}.OwnerType = ? AND ".
					   "{$items->_table}.isInternal = 0 AND ".
					   "{$items->_table}.isReview = 0 AND ".
					   "{$items->_table}.isBlog = 0 AND ".
					   "{$items->_table}.Published = 1 AND ".
					   "{$locale->_table}.Published = 1 AND ".
					   "{$locale->_table}.ID_LANGUAGE IN (".$langID.") AND ".
					   "{$items->_table}.OwnerType <> 'group'".
				 "LIMIT 1";
		$totalNum = (object) Doo::db()->fetchRow($query, array($posterID, $OwnerType));

		return $totalNum->cnt;
	}

	public function getNewsByType($posterID, $OwnerType, $limit = 4) {
		$locale = new NwItemLocale;
		$items = new NwItems;
		$player = User::getUser();
		if ($player)
			$langID = $player->ID_LANGUAGE.','.$player->OtherLanguages;
		else
			$langID = Lang::getCurrentLangID().',1';

		$params['NwItemLocale'] = array(
			'select' => "{$items->_table}.*, {$locale->_table}.*", //, {$locale->_table}.Headline as THeadline, {$locale->_table}.NewsText as TNewsText, {$locale->_table}.ID_LANGUAGE as TID
			'limit' => $limit,
			'desc' => "{$items->_table}.PostingTime",
			'where' => "{$items->_table}.ID_OWNER = ?  AND ".
					   "{$items->_table}.OwnerType = ? AND ".
					   "{$items->_table}.isInternal = 0 AND ".
					   "{$items->_table}.Published = 1 AND ".
					   "{$locale->_table}.Published = 1 AND ".
					   "{$locale->_table}.ID_LANGUAGE IN (".$langID.") AND ".
					   "{$items->_table}.isReview = 0",
					   "{$items->_table}.isBlog = 0",
			'param' => array($posterID, $OwnerType),
			'joinType' => 'LEFT',
		);

		$list = Doo::db()->relateMany('NwItems', array('NwItemLocale'), $params);
		$this->applyPathAndLang($list);

		return $list;
	}

	public function getPopularNews($limit = 5, $topOnly = false) {
		$locale = new NwItemLocale;
		$items = new NwItems;

		if ($topOnly == true) {
			$limit = Doo::conf()->topNewsLimit;
			$isPopular = 1;
		} else {
			$isPopular = 2;
		}

		$params['NwItemLocale'] = array(
			'select' => "{$items->_table}.*, {$locale->_table}.*", //, {$locale->_table}.Headline as THeadline, {$locale->_table}.NewsText as TNewsText, {$locale->_table}.ID_LANGUAGE as TID
			'limit' => $limit,
			'desc' => "{$items->_table}.Featured",
			'where' => "{$items->_table}.isInternal = 0  AND {$items->_table}.isReview = 0 AND {$items->_table}.isBlog = 0 AND{$items->_table}.Published = 1 AND {$items->_table}.isPopular = ? AND {$items->_table}.OwnerType <> 'group'",
			'param' => array($isPopular),
			'joinType' => 'LEFT',
		);

		$list = Doo::db()->relateMany('NwItems', array('NwItemLocale'), $params);
		$this->applyPathAndLang($list);

		return $list;
	}

	public function getPlatformNews($platformID, $limit = 15) {
		$locale = new NwItemLocale;
		$items = new NwItems;
		$gameplatrel = new SnGamesPlatformsRel;

		$params['NwItemLocale'] = array(
			'select' => "{$items->_table}.*, {$locale->_table}.*", //, {$locale->_table}.Headline as THeadline, {$locale->_table}.NewsText as TNewsText, {$locale->_table}.ID_LANGUAGE as TID
			'limit' => $limit,
			'desc' => "{$items->_table}.PostingTime",
			'where' => "{$items->_table}.isInternal = 0  AND {$items->_table}.isReview = 0 AND {$items->_table}.isBlog = 0 AND{$items->_table}.Published = 1 AND ({$items->_table}.ID_PLATFORM = ? OR ({$items->_table}.ID_PLATFORM = 0 AND {$items->_table}.OwnerType = ? AND {$items->_table}.ID_OWNER IN (SELECT {$gameplatrel->_table}.ID_GAME FROM {$gameplatrel->_table} WHERE {$gameplatrel->_table}.ID_PLATFORM = ?))) AND {$items->_table}.OwnerType <> 'group'",
			'param' => array($platformID, 'game', $platformID),
			'joinType' => 'LEFT',
		);

		$list = Doo::db()->relateMany('NwItems', array('NwItemLocale'), $params);
		$this->applyPathAndLang($list);

		return $list;
	}

	public function getUnpublishedNewsTotal() {
		$totalNum = 0;
		$ni = new NwItems();
		$locale = new NwItemLocale;
		$totalNum = (object) Doo::db()->fetchRow("SELECT COUNT(1) as cnt FROM `{$ni->_table}` n LEFT JOIN
										{$locale->_table} as l ON l.ID_NEWS = n.ID_NEWS
										WHERE n.isInternal = 0  AND (l.Published = 0 OR n.Published = 0)
                                        LIMIT 1");

		return $totalNum->cnt;
	}

	public function getUnpublishedNews($limit = 4) {
		$locale = new NwItemLocale;
		$items = new NwItems;

		$params['NwItemLocale'] = array(
			'select' => "{$items->_table}.*, {$locale->_table}.*", //, {$locale->_table}.Headline as THeadline, {$locale->_table}.NewsText as TNewsText, {$locale->_table}.ID_LANGUAGE as TID
			'limit' => $limit,
			'desc' => "{$items->_table}.PostingTime",
			'where' => "{$items->_table}.isInternal = 0 AND ({$items->_table}.Published = 0 OR {$locale->_table}.Published = 0)",
			'joinType' => 'LEFT',
		);

		$list = Doo::db()->relateMany('NwItems', array('NwItemLocale'), $params);

		if ($list and !empty($list)) {
			//adds related platforms, games, companies
			foreach ($list as &$l) {
				$l->applyUserLangs(true);
			}
		}

		return $list;
	}

	public static function applyPathAndLang(&$list) {
		if ($list and !empty($list)) {
			//adds related platforms, games, companies
			foreach ($list as &$l) {
				$l->addRelatedCategories();
				$l->applyUserLangs();
			}
		}
	}

	public function getTotalReviews($gameId){
		$totalNum = 0;
		$ni = new NwItems();
		$totalNum = (object) Doo::db()->fetchRow('SELECT COUNT(1) as cnt FROM `' . $ni->_table . '`
										WHERE isReview = 0 AND isBlog = 0 AND Published = 1 AND OwnerType = \'game\' AND ID_OWNER = ?
                                        LIMIT 1', array($gameId));

		return $totalNum->cnt;
	}

	public function getTotalUnpublishedReviews($gameId){
		$totalNum = 0;
		$ni = new NwItems();
		$u = User::getUser();

		if($u){
			$totalNum = (object) Doo::db()->fetchRow('SELECT COUNT(1) as cnt FROM `' . $ni->_table . '`
											WHERE isReview = 0 AND isBlog = 0 AND Published = 0 AND OwnerType = \'game\' AND ID_OWNER = ? AND ID_AUTHOR = ?
											LIMIT 1', array($gameId, $u->ID_PLAYER));

			return $totalNum->cnt;
		}

		return 0;
	}


	public function getReviews($gameId, $limit = 4) {
		$locale = new NwItemLocale;
		$items = new NwItems;

		$params['NwItemLocale'] = array(
			'select' => "{$items->_table}.*, {$locale->_table}.*", //, {$locale->_table}.Headline as THeadline, {$locale->_table}.NewsText as TNewsText, {$locale->_table}.ID_LANGUAGE as TID
			'limit' => $limit,
			'desc' => "{$items->_table}.PostingTime",
			'where' => "{$items->_table}.ID_OWNER = ?  AND {$items->_table}.isReview = 0 AND {$items->_table}.isBlog = 0 AND{$items->_table}.Published = 1 AND {$items->_table}.OwnerType = ?",
			'param' => array($gameId, GAME),
			'joinType' => 'LEFT',
		);

		$list = Doo::db()->relateMany('NwItems', array('NwItemLocale'), $params);
		$this->applyPathAndLang($list);

		return $list;
	}

	public function getUnpublishedReviews($gameId, $limit = 4) {
		$locale = new NwItemLocale;
		$items = new NwItems;

		$u = User::getUser();

		if($u){
			$params['NwItemLocale'] = array(
				'select' => "{$items->_table}.*, {$locale->_table}.*", //, {$locale->_table}.Headline as THeadline, {$locale->_table}.NewsText as TNewsText, {$locale->_table}.ID_LANGUAGE as TID
				'limit' => $limit,
				'desc' => "{$items->_table}.PostingTime",
				'where' => "{$items->_table}.ID_OWNER = ?  AND {$items->_table}.isReview = 0 AND {$items->_table}.isBlog = 0 AND{$items->_table}.Published = 0 AND {$items->_table}.OwnerType = ? AND {$items->_table}.ID_AUTHOR = ?",
				'param' => array($gameId, GAME, $u->ID_PLAYER),
				'joinType' => 'LEFT',
			);

			$list = Doo::db()->relateMany('NwItems', array('NwItemLocale'), $params);
			$this->applyPathAndLang($list);

			return $list;
		}
		else{
			return array();
		}
	}

	public function updateCache(NwItems $news) {
		Cache::increase(CACHE_NEWS.$news->ID_NEWS);
	}
    
    /**
     * Upload handler
     *
     * @return array
     */
    public function uploadPhoto($id) {
        $p = User::getUser();
        
        if ($p and $p->canAccess('Add news image')) {
            $c = Doo::db()->getOne('NwItemLocale', array(
            'limit' => 1,
            'where' => 'ID_NEWS = ?',
            'param' => array($id)
            ));
            
            $image = new Image();
            $result = $image->uploadImage(FOLDER_NEWSITEMS, $c->Image);
            if ($result['filename'] != '') {
                $c->Image = ContentHelper::handleContentInput($result['filename']);
                $c->update(array(
                'field' => 'Image',
                'where' => 'ID_NEWS = ?',
                'param' => array($id)
                ));
                $c->purgeCache();
                $result['c'] = $c;
            }

            return $result;
        }
    }
}
?>
