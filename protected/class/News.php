<?php

class News {

    public function getTopNews() {
        $locale = new NwItemLocale;
        $items = new NwItems;
        $player = User::getUser();
        if ($player)
            $langID = $player->ID_LANGUAGE . ',' . $player->OtherLanguages;
        else
            $langID = Lang::getCurrentLangID() . ',1';

        $params['NwItemLocale'] = array(
            'select' => "{$items->_table}.*, {$locale->_table}.*", //, {$locale->_table}.Headline as THeadline, {$locale->_table}.NewsText as TNewsText, {$locale->_table}.ID_LANGUAGE as TID
            'limit' => Doo::conf()->topNewsLimit,
            'desc' => "{$items->_table}.Featured",
            'where' => "{$items->_table}.isInternal = 0 AND " .
            "{$items->_table}.Published = 1 AND " .
            "{$locale->_table}.Published = 1 AND " .
            "{$locale->_table}.ID_LANGUAGE IN (" . $langID . ") AND " .
            "{$items->_table}.OwnerType <> 'group' AND " .
            "{$items->_table}.isReview = 0 AND " .
            "{$items->_table}.isBlog = 0",
            'joinType' => 'LEFT',
        );

        $list = Doo::db()->relateMany('NwItems', array('NwItemLocale'), $params);
        $this->applyPathAndLang($list);

        return $list;
    }

    public function getTopBlog() {
        $locale = new NwItemLocale;
        $items = new NwItems;
        $player = User::getUser();
        if ($player)
            $langID = $player->ID_LANGUAGE . ',' . $player->OtherLanguages;
        else
            $langID = Lang::getCurrentLangID() . ',1';

        $params['NwItemLocale'] = array(
            'select' => "{$items->_table}.*, {$locale->_table}.*", //, {$locale->_table}.Headline as THeadline, {$locale->_table}.NewsText as TNewsText, {$locale->_table}.ID_LANGUAGE as TID
            'limit' => Doo::conf()->topBlogLimit,
            'desc' => "{$items->_table}.Featured",
            'where' => "{$items->_table}.isInternal = 0 AND " .
            "{$items->_table}.Published = 1 AND " .
            "{$locale->_table}.Published = 1 AND " .
            "{$locale->_table}.ID_LANGUAGE IN (" . $langID . ") AND " .
            "{$items->_table}.OwnerType <> 'group' AND " .
            "{$items->_table}.isReview = 0 AND " .
            "{$items->_table}.isBlog = 1",
            'joinType' => 'LEFT',
        );

        $list = Doo::db()->relateMany('NwItems', array('NwItemLocale'), $params);
        $this->applyPathAndLang($list);

        return $list;
    }

    public function getMostReadNews($limit = 5, $review = 0) {
        $locale = new NwItemLocale();
        $items = new NwItems();
        $mostRead = new NwMostRead();
        $player = User::getUser();

        $langID = ($player) ? $player->ID_LANGUAGE . ',' . $player->OtherLanguages : Lang::getCurrentLangID() . ',1';

        $mostReadTable = $mostRead->_table;
        $itemsTable = $items->_table;
        $localeTable = $locale->_table;
        $params = array(
            'NwItemLocale' => array(
                'select' => "{$mostReadTable}.*, SUM({$mostReadTable}.ShowCount) AS TotalShowCount, {$localeTable}.* "
                , 'joinType' => 'LEFT'
                , 'where' => "{$mostReadTable}.ReadDate >= DATE_SUB(CURDATE(), INTERVAL 7 DAY) AND
                    {$localeTable}.Published = 1 AND
                    {$localeTable}.isBlog = 0 AND
                    {$localeTable}.isReview = {$review} AND
                    {$localeTable}.ID_LANGUAGE IN (" . $langID . ")"
                , 'groupby' => "{$mostReadTable}.ID_NEWS"
                , 'desc' => "TotalShowCount"
                , 'limit' => $limit,
            )
            , 'NwItems' => array(
                'select' => "{$mostReadTable}.*, SUM({$mostReadTable}.ShowCount) AS TotalShowCount, {$itemsTable}.* "
                , 'joinType' => 'LEFT'
                , 'where' => "{$mostReadTable}.ReadDate >= DATE_SUB(CURDATE(), INTERVAL 7 DAY) AND
                    {$itemsTable}.isBlog = 0 AND
                    {$itemsTable}.isInternal = 0 AND
                    {$itemsTable}.isReview = {$review} AND
                    {$itemsTable}.Published = 1"
                , 'groupby' => "{$mostReadTable}.ID_NEWS"
                , 'desc' => "TotalShowCount"
            )
        );
        $list = $mostRead->relateMany(array('NwItemLocale', 'NwItems'), $params);
        $this->applyPathAndLang($list);

        return $list;
    }

    /**
     * Returns categories with subcategories due to defined type
     *
     * @return
     */
    public function getCategoriesByType($type) {
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
    public function toggleLike($type, $id, $replyNumber = 0, $l = 0) {
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

            if ($type == 'newsreply') {
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
     * Returns relation between player and game
     * @param type $gameID
     * @return SnPlayerGameRel
     */
    public static function getPlayerLikeRel($nwItem, Players $player = null, $replyNumber = 0) {
        if ($player == null) {
            $player = User::getUser();
        }

        if ($player) {
            $pgr = new NwLikes();
            $pgr->ID_PLAYER = $player->ID_PLAYER;
            $pgr->ID_NEWS = $nwItem->ID_NEWS;
            $pgr->ReplyNumber = $replyNumber;
            $result = $pgr->getOne();

            return $result;
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

    public function getSearchAdvTotal($headline = "", $desc = "", $author = "") {
        if (!empty($headline) || !empty($desc) || !empty($author)) {
            $nwItem = new NwItems();
            $nwItemLoc = new NwItemLocale();
            $snPlayers = new Players();
            $params = array(
                'desc' => "{$nwItem->_table}.PostingTime",
                'where' => "{$nwItem->_table}.Published = 1 AND {$nwItemLoc->_table}.Published = 1",
            );
            $params['NwItemLocale'] = array(
                'joinType' => 'INNER',
                'where' => "{$nwItemLoc->_table}.Published = 1",
            );
            if (!empty($headline)) {
                $params['NwItemLocale']['where'] .= " AND {$nwItemLoc->_table}.Headline LIKE '%{$headline}%'";
            };
            if (!empty($desc)) {
                $params['NwItemLocale']['where'] .= " AND {$nwItemLoc->_table}.IntroText LIKE '%{$desc}%' OR {$nwItemLoc->_table}.NewsText LIKE '%{$desc}%'";
            };

            if (!empty($author)) {
                $params['NwItemLocale']['where'] .= " AND {$nwItemLoc->_table}.ID_PLAYER = $author";
            };

            $news = Doo::db()->relateMany('NwItems', array('NwItemLocale'), $params);
            return count($news);
        }
        return 0;
    }

    public function getAuthors() {

        $news = new News();

        $locale = new NwItemLocale();
        $items = new NwItems();
        $players = new Players();

        $params = array(
            'select' => "{$items->_table}.ID_AUTHOR",
            'groupby' => "{$items->_table}.ID_AUTHOR",
            'where' => "{$items->_table}.Published = 1 AND " .
            "{$locale->_table}.Published = 1",
        );
        $params['NwItemLocale'] = array(
            'joinType' => 'left'
        );

        $list = Doo::db()->relate('NwItems', 'NwItemLocale', $params);
        $author = array();
        $i = 0;
        foreach ($list as $test => $test2) {

            $tmp = $test2->ID_AUTHOR;
            $id = user::getById($tmp);
            $name = 'unknown';
            if (FALSE !== $id) {
                $name = PlayerHelper::showName($id);
            };
            $author[++$i] = array(
                'id' => $tmp,
                'name' => $name
            );
        }
        return $author;
    }


    public function getSearchAdv($headline = "", $desc = "", $author = "", $limit = 20) {
        if (!empty($headline) || !empty($desc) || !empty($author)) {
            $nwItem = new NwItems();
            $nwItemLoc = new NwItemLocale();
            $snPlayers = new Players();
            $params = array(
                'limit' => $limit,
                'desc' => "{$nwItem->_table}.PostingTime",
                'where' => "{$nwItem->_table}.Published = 1 AND {$nwItemLoc->_table}.Published = 1",
            );
            $params['NwItemLocale'] = array(
                'joinType' => 'INNER',
                'where' => "{$nwItemLoc->_table}.Published = 1",
            );
            if (!empty($headline)) {
                $params['NwItemLocale']['where'] .= " AND {$nwItemLoc->_table}.Headline LIKE '%{$headline}%'";
            };
            if (!empty($desc)) {
                $params['NwItemLocale']['where'] .= " AND {$nwItemLoc->_table}.IntroText LIKE '%{$desc}%' OR {$nwItemLoc->_table}.NewsText LIKE '%{$desc}%'";
            };

            if (!empty($author)) {
                $params['NwItemLocale']['where'] .= " AND {$nwItemLoc->_table}.ID_PLAYER = $author";
            };

            $news = Doo::db()->relateMany('NwItems', array('NwItemLocale'), $params);
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
    public function saveNews($post, $isReview = 0, $isBlog = 0, $isInternal = 0) {
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
        if (isset($isAdminPanel) && $isAdminPanel == 0) {
            $news->ID_OWNER = isset($hiddenOwnerID) ? $hiddenOwnerID : 0;
        } else {
            $news->ID_OWNER = isset($ownerID) ? $ownerID : 0;
        }
        $news->OwnerType = $ownerType;
        $news->ID_PLATFORM = isset($platform) && $ownerType == 'game' ? $platform : 0;
        $news->Published = ((isset($publishMainArticle) && $publishMainArticle == 1 && $player->canAccess('Approve news') === TRUE) || ($news->OwnerType == POSTRERTYPE_GROUP || ($isReview == 1 && $published == 1) || ($isBlog == 1 && $published == 1))) ? 1 : 0;
        $news->isReview = $isReview;
        $news->isBlog = $isBlog;
        $news->ID_EVENT = isset($eventID) ? $eventID : 0;
        $news->isInternal = $isInternal;
        $news->ID_AUTHOR = $player->ID_PLAYER;
        $news->ID_PREFIX = (isset($prefix)) ? $prefix : 1; //test
        $newsID = $news->insert();

        $post['newsID'] = $newsID;
        $post['imageUrl'] = $imageUrl;
        $this->createUpdateLocale($post, $news->ID_AUTHOR, $isBlog, $isReview);
        Url::createUpdateURL($name, URL_NEWS, $newsID, $language);

        if (isset($rating) && $rating != 0 && isset($ownerID) && !empty($ownerType)) {
            $ratings = new Ratings();
            $ratings->rate($ownerType, $ownerID, $rating);
        }
        $news = $this->getArticleByID($newsID, $language);
        return $news;
    }

    private function createUpdateLocale($params, $author = 0, $isBlog = 0, $isReview = 0) {
        extract($params);
        $player = User::getUser();

        $locale = new NwItemLocale();
        $locale->ID_NEWS = $newsID;
        $locale->ID_LANGUAGE = $language;
        $locale->purgeCache();

        $localeCheck = $locale->getOne();

        if ($author != 0) {
            $locale->ID_PLAYER = $author;
        } else {
            $news = new News();
            $item = $news->getArticleByID($newsID, $language);
            $locale->ID_PLAYER = $item->ID_AUTHOR;
        }
        $locale->Headline = $name;
        $locale->IntroText = $messageIntro;
        $locale->NewsText = $messageText;
        $locale->isBlog = $isBlog;
        $locale->isReview = $isReview;
        
        if(ltrim($editornote) != ''){
     	  		$previousChange = (object) Doo::db()->fetchRow("select EditorNote from $locale->_table 
     	  									where ID_NEWS=? and ID_LANGUAGE=?", 
     	  									array($locale->ID_NEWS,$locale->ID_LANGUAGE));						
				$locale->EditorNote = $previousChange->EditorNote . time()."|comma|".$player->DisplayName."|comma|".$editornote."|semicolon|";
		  }
       
        $locale->isReady=isset($isReady) ? 1 : 0;

        if (isset($imageUrl))
            $locale->Image = $imageUrl;

        $locale->Published = ((isset($publishLangArticle) and $publishLangArticle == 1 and $player->canAccess('Approve news') === TRUE) or $ownerType == POSTRERTYPE_GROUP or (isset($published) && $published == 1)) ? 1 : 0;

        if (isset($localeCheck) and !empty($localeCheck)) {
            $locale->update(array(
                'where' => 'ID_NEWS = ? AND ID_LANGUAGE = ?',
                'param' => array($newsID, $language)
            ));
            $locale->purgeCache();
        } else {
            //$locale->EditorNote = '';
            $locale->insert();
        }
        return $locale;
    }

    /**
     * Updates news item
     * @param array $post
     * @return NwItem
     */
    public function updateNews($post, $isReview = 0, $isBlog = 0) {
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

            $this->createUpdateLocale($post, 0, $isBlog, $isReview);

            if ($isReview == 1 or $isBlog == 1) {
                $article->Published = 1;
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

            if ($isReview == 0 and $isBlog == 0) {
                if ($player->canAccess('Approve news') === TRUE) {
                    $article->Published = isset($publishMainArticle) ? 1 : 0;
                } else {
                    if ($published == false) {
                        $article->Published = 0;
                    }
                }
            }
            if (isset($ownerID) && !empty($ownerID)) {
                $article->ID_OWNER = $ownerID;
            }
            if (isset($ownerType) && !empty($ownerType)) {
                $article->OwnerType = $ownerType;
            }
            if ((isset($prefix))) {
                $article->ID_PREFIX = $prefix;
            }
            $article->ID_PLATFORM = isset($platform) && $ownerType == 'game' ? $platform : 0;
            $article->SocialRating = isset($rating) ? $rating : 0;
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
    public function getLatestNews($limit = 4, $tab = 3, $order = 'desc', $allLang = FALSE) {
        $locale = new NwItemLocale();
        $localeTable = $locale->_table;
        $items = new NwItems();
        $itemsTable = $items->_table;
        $players = new Players();
        $playersTable = $players->_table;
        $player = User::getUser();
        $orderby = $itemsTable;


        // test
        $prefix = new NwPrefixes();
        $prefixTable = $prefix->_table;



        $langID = ($player) ? $player->ID_LANGUAGE . ',' . $player->OtherLanguages : Lang::getCurrentLangID() . ',1';

        switch ($tab) {
            case 1:
                $orderby .= '.isPopular';
                break;
            case 2:
                $orderby .= '.ratingCur';
                break;
            case 3:
                $orderby .= '.postingTime';
                break;
            default:
                $orderby .= '.postingTime';
        };

//Get all languages or specific language
        if(TRUE === $allLang) {
            $langFilter = '';
        } else {
            $langID = ($player) ? $player->ID_LANGUAGE . ',' . $player->OtherLanguages : Lang::getCurrentLangID() . ',1';
            $langFilter = " AND {$localeTable}.ID_LANGUAGE IN (" . $langID . ")";
        };

        $params = array(
            'select' => "{$itemsTable}.*, "
            . "{$localeTable}.*, "
            . "(SELECT {$playersTable}.DisplayName FROM {$playersTable} WHERE {$playersTable}.ID_PLAYER = {$itemsTable}.ID_AUTHOR) as Author",
            'joinType' => 'LEFT',
            'where' =>
            "{$itemsTable}.Published = 1 AND " .
            "{$localeTable}.Published = 1 AND " .
            "{$itemsTable}.isReview = 0 AND " .
            "{$itemsTable}.isBlog = 0 AND " .
            "{$itemsTable}.isInternal = 0 AND " .
            "{$itemsTable}.OwnerType != 'group'" .
            $langFilter,
//            'limit' => $limit, DO NOT ACTIVATE !!!!!
            "{$order}" => "{$orderby}",
			'limitFix' => "(SELECT * FROM {$itemsTable} WHERE {$itemsTable}.isInternal = 0 AND {$itemsTable}.Published = 1 AND {$itemsTable}.isReview = 0 AND {$itemsTable}.isBlog = 0 AND {$itemsTable}.OwnerType != 'group'
                            AND exists (SELECT {$localeTable}.ID_NEWS FROM {$localeTable} WHERE {$localeTable}.ID_NEWS = {$itemsTable}.ID_NEWS AND {$localeTable}.Published = 1".$langFilter.")
                           order by {$orderby} {$order} limit ".$limit.") ",
        );
        $list = $items->relate('NwItemLocale', $params);
        $this->applyPathAndLang($list);

        return $list;
    }

    /**
     * returns list of latest/recent news
     * @param int $limit
     * @return NwItems
     */
    public function getLatestReviews($limit = 4, $allLang = false, $sortType = "", $order = "desc", $tab = 1) {
        $locale = new NwItemLocale;
        $items = new NwItems;
        $players = new Players();
        $player = User::getUser();
        $orderby = "";

        if ($player)
            $langID = $player->ID_LANGUAGE . ',' . $player->OtherLanguages;
        else
            $langID = Lang::getCurrentLangID() . ',1';

        switch ($sortType) {
            case "news":
                $orderby = $locale->_table . '.Headline';
                break;
            case "author" :
                $orderby = 'Author';
                break;
            case "languages" :
                $orderby = $locale->_table . '.ID_LANGUAGE';
                break;
            default :
                $orderby = $items->_table . '.PostingTime';
        }


//Get all languages or specific language
        $langFilter = (!$allLang) ? "{$locale->_table}.ID_LANGUAGE IN (" . $langID . ") AND " : " ";

        $params['NwItemLocale'] = array(
            'select' => "{$items->_table}.*, {$locale->_table}.*, (SELECT {$players->_table}.DisplayName FROM {$players->_table} WHERE {$players->_table}.ID_PLAYER = {$items->_table}.ID_AUTHOR) as Author", //, {$locale->_table}.Headline as THeadline, {$locale->_table}.NewsText as TNewsText, {$locale->_table}.ID_LANGUAGE as TID
            'limit' => $limit,
            "{$order}" => "{$orderby}",
            'where' => "{$items->_table}.isInternal = 0 AND " .
            "{$items->_table}.Published = 1 AND " .
            "{$locale->_table}.Published = 1 AND " .
            $langFilter . //"{$locale->_table}.ID_LANGUAGE IN (".$langID.") AND ".
            "{$items->_table}.OwnerType <> 'group' AND " .
            "{$items->_table}.isReview = 1 AND " .
            "{$items->_table}.isBlog = 0",
            'joinType' => 'LEFT',
        );



        $list = Doo::db()->relateMany('NwItems', array('NwItemLocale'), $params);
        $this->applyPathAndLang($list);

        return $list;
    }

    public function getLatestBlog($limit = 4) {
        $locale = new NwItemLocale;
        $items = new NwItems;
        $player = User::getUser();
        if ($player)
            $langID = $player->ID_LANGUAGE . ',' . $player->OtherLanguages;
        else
            $langID = Lang::getCurrentLangID() . ',1';

        $params['NwItemLocale'] = array(
            'select' => "{$items->_table}.*, {$locale->_table}.*", //, {$locale->_table}.Headline as THeadline, {$locale->_table}.NewsText as TNewsText, {$locale->_table}.ID_LANGUAGE as TID
            'limit' => $limit,
            'desc' => "{$items->_table}.PostingTime",
            'where' => "{$items->_table}.isInternal = 0 AND " .
            "{$items->_table}.Published = 1 AND " .
            "{$locale->_table}.Published = 1 AND " .
            "{$locale->_table}.ID_LANGUAGE IN (" . $langID . ") AND " .
            "{$items->_table}.OwnerType <> 'group' AND " .
            "{$items->_table}.isReview = 0 AND " .
            "{$items->_table}.isBlog = 1",
            'joinType' => 'LEFT',
        );

        $list = Doo::db()->relateMany('NwItems', array('NwItemLocale'), $params);
        $this->applyPathAndLang($list);

        return $list;
    }

    public function getNewsTotal($allLang = false) {
        $totalNum = 0;
        $locale = new NwItemLocale;
        $items = new NwItems;
        $player = User::getUser();
        if ($player)
            $langID = $player->ID_LANGUAGE . ',' . $player->OtherLanguages;
        else
            $langID = Lang::getCurrentLangID() . ',1';

//Get all languages or specific language
        $langFilter = (!$allLang) ? "{$locale->_table}.ID_LANGUAGE IN (" . $langID . ") AND " : " ";

		$query = "SELECT COUNT(*) as cnt ".
				 "FROM (SELECT DISTINCT {$items->_table}.ID_NEWS ".
				        "FROM {$items->_table}, {$locale->_table} ".
				        "WHERE {$locale->_table}.ID_NEWS = {$items->_table}.ID_NEWS ".
				          "AND {$items->_table}.isInternal = 0 AND ".
				              "{$items->_table}.isReview = 0 AND ".
				              "{$items->_table}.isBlog = 0 AND ".
				              "{$items->_table}.Published = 1 AND ".
				              "{$locale->_table}.Published = 1 AND ".
				              $langFilter.//"{$locale->_table}.ID_LANGUAGE IN (".$langID.") AND ".
				              "{$items->_table}.OwnerType <> 'group') {$items->_table} ".
				 "LIMIT 1";

        $totalNum = (object) Doo::db()->fetchRow($query);

        return $totalNum->cnt;
    }

    public function getReviewsTotal($allLang = false) {
        $totalNum = 0;
        $locale = new NwItemLocale;
        $items = new NwItems;
        $player = User::getUser();
        if ($player)
            $langID = $player->ID_LANGUAGE . ',' . $player->OtherLanguages;
        else
            $langID = Lang::getCurrentLangID() . ',1';

//Get all languages or specific language
        $langFilter = (!$allLang) ? "{$locale->_table}.ID_LANGUAGE IN (" . $langID . ") AND " : " ";

        $query = "SELECT COUNT(1) as cnt " .
                "FROM {$items->_table} " .
                "LEFT JOIN {$locale->_table} ON {$locale->_table}.ID_NEWS = {$items->_table}.ID_NEWS " .
                "WHERE {$items->_table}.isInternal = 0 AND " .
                "{$items->_table}.isReview = 1 AND " .
                "{$items->_table}.isBlog = 0 AND " .
                "{$items->_table}.Published = 1 AND " .
                "{$locale->_table}.Published = 1 AND " .
                $langFilter . //"{$locale->_table}.ID_LANGUAGE IN (".$langID.") AND ".
                "{$items->_table}.OwnerType <> 'group'" .
                "LIMIT 1";

        $totalNum = (object) Doo::db()->fetchRow($query);

        return $totalNum->cnt;
    }

    public function getBlogTotal() {
        $totalNum = 0;
        $locale = new NwItemLocale;
        $items = new NwItems;
        $player = User::getUser();
        if ($player)
            $langID = $player->ID_LANGUAGE . ',' . $player->OtherLanguages;
        else
            $langID = Lang::getCurrentLangID() . ',1';

        $query = "SELECT COUNT(1) as cnt " .
                "FROM {$items->_table} " .
                "LEFT JOIN {$locale->_table} ON {$locale->_table}.ID_NEWS = {$items->_table}.ID_NEWS " .
                "WHERE {$items->_table}.isInternal = 0 AND " .
                "{$items->_table}.isReview = 0 AND " .
                "{$items->_table}.isBlog = 1 AND " .
                "{$items->_table}.Published = 1 AND " .
                "{$locale->_table}.Published = 1 AND " .
                "{$locale->_table}.ID_LANGUAGE IN (" . $langID . ") AND " .
                "{$items->_table}.OwnerType <> 'group'" .
                "LIMIT 1";

        $totalNum = (object) Doo::db()->fetchRow($query);

        return $totalNum->cnt;
    }

    public function getPopularNewsTotal() {
        $totalNum = 0;
        $ni = new NwItems();
        $totalNum = (object) Doo::db()->fetchRow('SELECT COUNT(1) as cnt FROM `' . $ni->_table . '`
										WHERE isInternal = 0 AND isReview = 0 AND isBlog = 0 AND Published = 1 AND isPopular = 2  AND OwnerType <> \'group\'
                                        LIMIT 1');

        return $totalNum->cnt;
    }

    public function getPopularBlogTotal() {
        $totalNum = 0;
        $ni = new NwItems();
        $totalNum = (object) Doo::db()->fetchRow('SELECT COUNT(1) as cnt FROM `' . $ni->_table . '`
										WHERE isInternal = 0 AND isReview = 0 AND isBlog = 1 AND Published = 1 AND isPopular = 2  AND OwnerType = \'player\'
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

    public function getTotalByType($posterID, $OwnerType) {
        $totalNum = 0;
        $locale = new NwItemLocale;
        $items = new NwItems;
        $player = User::getUser();
        if ($player)
            $langID = $player->ID_LANGUAGE . ',' . $player->OtherLanguages;
        else
            $langID = Lang::getCurrentLangID() . ',1';

        $query = "SELECT COUNT(1) as cnt " .
                "FROM {$items->_table} " .
                "LEFT JOIN {$locale->_table} ON {$locale->_table}.ID_NEWS = {$items->_table}.ID_NEWS " .
                "WHERE {$items->_table}.ID_OWNER = ? AND " .
                "{$items->_table}.OwnerType = ? AND " .
                "{$items->_table}.isInternal = 0 AND " .
                "{$items->_table}.isReview = 0 AND " .
                "{$items->_table}.isBlog = 0 AND " .
                "{$items->_table}.Published = 1 AND " .
                "{$locale->_table}.Published = 1 AND " .
                "{$locale->_table}.ID_LANGUAGE IN (" . $langID . ") AND " .
                "{$items->_table}.OwnerType <> 'group'" .
                "LIMIT 1";
        $totalNum = (object) Doo::db()->fetchRow($query, array($posterID, $OwnerType));

        return $totalNum->cnt;
    }

    public function getNewsByType($posterID, $OwnerType, $limit = 4, $includeIsInternal = 0, $isRandom = 0) {
        $locale = new NwItemLocale;
        $items = new NwItems;
        $player = User::getUser();
        if ($player)
            $langID = $player->ID_LANGUAGE . ',' . $player->OtherLanguages;
        else
            $langID = Lang::getCurrentLangID() . ',1';
        if ($includeIsInternal == 0) {
            $isInternal = "{$items->_table}.isInternal = 0 AND ";
        } else {
            $isInternal = "";
        }
        if ($player && ($player->canAccess('Approve news') === true || $player == $posterID)) {
            $paramWhere = "{$items->_table}.ID_OWNER = ?  AND " .
                    "{$items->_table}.OwnerType = ? AND " .
                    $isInternal .
                    "{$locale->_table}.ID_LANGUAGE IN (" . $langID . ") AND " .
                    "{$items->_table}.isReview = 0 AND " .
                    "{$items->_table}.isBlog = 0";
        } else {
            $paramWhere = "{$items->_table}.ID_OWNER = ?  AND " .
                    "{$items->_table}.OwnerType = ? AND " .
                    $isInternal .
                    "{$items->_table}.Published = 1 AND " .
                    "{$locale->_table}.Published = 1 AND " .
                    "{$locale->_table}.ID_LANGUAGE IN (" . $langID . ") AND " .
                    "{$items->_table}.isReview = 0 AND " .
                    "{$items->_table}.isBlog = 0";
        }

        if ($isRandom == 1)
            $paramOrder = "RAND()";
        else
            $paramOrder = "{$items->_table}.PostingTime";

        $params['NwItemLocale'] = array(
            'select' => "{$items->_table}.*, {$locale->_table}.*", //, {$locale->_table}.Headline as THeadline, {$locale->_table}.NewsText as TNewsText, {$locale->_table}.ID_LANGUAGE as TID
            'limit' => $limit,
            'desc' => $paramOrder,
            'where' => $paramWhere,
            'param' => array($posterID, $OwnerType),
            'joinType' => 'LEFT',
        );

        $list = Doo::db()->relateMany('NwItems', array('NwItemLocale'), $params);
        $this->applyPathAndLang($list);

        return $list;
    }

    public function getNewsByAuthor($authorID, $limit = 4, $isRandom = 0) {
        $locale = new NwItemLocale;
        $items = new NwItems;
        $player = User::getUser();
        if ($player)
            $langID = $player->ID_LANGUAGE . ',' . $player->OtherLanguages;
        else
            $langID = Lang::getCurrentLangID() . ',1';
        if ($player && ($player->canAccess('Approve news') === true || $player = $authorID)) {
            $paramWhere = "{$items->_table}.ID_AUTHOR = ?  AND " .
                    "{$items->_table}.isInternal = 0 AND " .
                    "{$locale->_table}.ID_LANGUAGE IN (" . $langID . ") AND " .
                    "{$items->_table}.isReview = 0 AND " .
                    "{$items->_table}.isBlog = 0";
        } else {
            $paramWhere = "{$items->_table}.ID_AUTHOR = ?  AND " .
                    "{$items->_table}.isInternal = 0 AND " .
                    "{$items->_table}.Published = 1 AND " .
                    "{$locale->_table}.Published = 1 AND " .
                    "{$locale->_table}.ID_LANGUAGE IN (" . $langID . ") AND " .
                    "{$items->_table}.isReview = 0 AND " .
                    "{$items->_table}.isBlog = 0";
        }
        if ($isRandom == 1)
            $paramOrder = "RAND()";
        else
            $paramOrder = "{$items->_table}.PostingTime";

        $params['NwItemLocale'] = array(
            'select' => "{$items->_table}.*, {$locale->_table}.*", //, {$locale->_table}.Headline as THeadline, {$locale->_table}.NewsText as TNewsText, {$locale->_table}.ID_LANGUAGE as TID
            'limit' => $limit,
            'desc' => $paramOrder,
            'where' => $paramWhere,
            'param' => array($authorID),
            'joinType' => 'LEFT',
        );

        $list = Doo::db()->relateMany('NwItems', array('NwItemLocale'), $params);
        $this->applyPathAndLang($list);

        return $list;
    }

    public function getNewsByCategory($posterID, $newsID, $ownerType, $limit = 4, $isRandom = 0) {
        $locale = new NwItemLocale;
        $items = new NwItems;
        $companies = new SnCompanies;
        $games = new SnGames;
        $player = User::getUser();
        if ($player)
            $langID = $player->ID_LANGUAGE . ',' . $player->OtherLanguages;
        else
            $langID = Lang::getCurrentLangID() . ',1';
        switch ($ownerType) {
            case "game":
                $ownerSql = "(SELECT {$games->_table}.ID_GAMETYPE FROM {$games->_table}
                                     WHERE {$games->_table}.ID_GAME = {$items->_table}.ID_OWNER LIMIT 1)";
                $columnName = "{$games->_table}.ID_GAMETYPE";
                $relatedTables = array('NwItemLocale', 'SnGames');
                $tableName = "SnGames";
                break;

            case "company":
                $ownerSql = "(SELECT {$companies->_table}.ID_COMPANYTYPE FROM {$companies->_table}
                                     WHERE {$companies->_table}.ID_COMPANY = {$items->_table}.ID_OWNER LIMIT 1)";
                $columnName = "{$companies->_table}.ID_COMPANYTYPE";
                $relatedTables = array('NwItemLocale', 'SnCompanies');
                $tableName = "SnCompanies";
                break;

            default:
        }
        if ($player && ($player->canAccess('Approve news') === true || $player = $posterID)) {
            $published = "";
        } else {
            $published = "{$items->_table}.Published = 1 AND " .
                    "{$locale->_table}.Published = 1 AND ";
        }
        if ($isRandom == 1)
            $paramOrder = "RAND()";
        else
            $paramOrder = "{$items->_table}.PostingTime";
        $params = array(
            'NwItemLocale' => array(
                'select' => "{$items->_table}.*, {$locale->_table}.* "
                , 'joinType' => 'LEFT'
                , 'where' => "{$items->_table}.ID_NEWS <> ?  AND " .
                "{$items->_table}.ID_OWNER = ?  AND " .
                "{$items->_table}.OwnerType = ? AND " .
                "{$items->_table}.isInternal = 0 AND " .
                "{$locale->_table}.ID_LANGUAGE IN (" . $langID . ") AND " .
                $published .
                "{$items->_table}.isReview = 0 AND " .
                "{$items->_table}.isBlog = 0"
                , 'param' => array($newsID, $posterID, $ownerType)
                , 'limit' => $limit
                , 'desc' => $paramOrder
            )
            , $tableName => array(
                'select' => "{$items->_table}.*"
                , 'joinType' => 'LEFT'
                , 'where' => "{$items->_table}.ID_NEWS <> ?  AND " .
                "{$items->_table}.ID_OWNER = ?  AND " .
                "{$items->_table}.OwnerType = ? AND " .
                "{$items->_table}.isInternal = 0 AND " .
                "{$columnName} = {$ownerSql} AND " .
                "{$items->_table}.isReview = 0 AND " .
                "{$items->_table}.isBlog = 0"
                , 'param' => array($newsID, $posterID, $ownerType)
                , 'limit' => $limit
                , 'desc' => $paramOrder
            )
        );

        $list = Doo::db()->relateMany('NwItems', $relatedTables, $params);
        $this->applyPathAndLang($list);

        return $list;
    }

    public function getNewsByEvent($eventID, $limit = 4) {
        $locale = new NwItemLocale;
        $items = new NwItems;
        $event = new EvEvents;
        $player = User::getUser();
        if ($player)
            $langID = $player->ID_LANGUAGE . ',' . $player->OtherLanguages;
        else
            $langID = Lang::getCurrentLangID() . ',1';
        if ($player && ($player->canAccess('Approve news') === true || $event->isAdmin())) {
            $paramWhere = "{$items->_table}.ID_EVENT = ?  AND " .
                    "{$locale->_table}.ID_LANGUAGE IN (" . $langID . ") AND " .
                    "{$items->_table}.isReview = 0 AND " .
                    "{$items->_table}.isBlog = 0";
        } else {
            $paramWhere = "{$items->_table}.ID_EVENT = ?  AND " .
                    "{$items->_table}.Published = 1 AND " .
                    "{$locale->_table}.Published = 1 AND " .
                    "{$locale->_table}.ID_LANGUAGE IN (" . $langID . ") AND " .
                    "{$items->_table}.isReview = 0 AND " .
                    "{$items->_table}.isBlog = 0";
        }

        $params['NwItemLocale'] = array(
            'select' => "{$items->_table}.*, {$locale->_table}.*", //, {$locale->_table}.Headline as THeadline, {$locale->_table}.NewsText as TNewsText, {$locale->_table}.ID_LANGUAGE as TID
            'limit' => $limit,
            'desc' => "{$items->_table}.PostingTime",
            'where' => $paramWhere,
            'param' => array($eventID),
            'joinType' => 'LEFT',
        );

        $list = Doo::db()->relateMany('NwItems', array('NwItemLocale'), $params);
        $this->applyPathAndLang($list);

        return $list;
    }

    public function getTotalByEvent($eventID) {
        $totalNum = 0;
        $locale = new NwItemLocale;
        $items = new NwItems;
        $player = User::getUser();
        if ($player)
            $langID = $player->ID_LANGUAGE . ',' . $player->OtherLanguages;
        else
            $langID = Lang::getCurrentLangID() . ',1';

        $query = "SELECT COUNT(1) as cnt " .
                "FROM {$items->_table} " .
                "LEFT JOIN {$locale->_table} ON {$locale->_table}.ID_NEWS = {$items->_table}.ID_NEWS " .
                "WHERE {$items->_table}.ID_EVENT = ? AND " .
                "{$items->_table}.isReview = 0 AND " .
                "{$items->_table}.isBlog = 0 AND " .
                "{$items->_table}.Published = 1 AND " .
                "{$locale->_table}.Published = 1 AND " .
                "{$locale->_table}.ID_LANGUAGE IN (" . $langID . ")" .
                "LIMIT 1";
        $totalNum = (object) Doo::db()->fetchRow($query, array($eventID));

        return $totalNum->cnt;
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
            'where' => "{$items->_table}.isInternal = 0 AND {$items->_table}.isReview = 0 AND {$items->_table}.isBlog = 0 AND {$items->_table}.Published = 1 AND {$items->_table}.isPopular = ? AND {$items->_table}.OwnerType <> 'group'",
            'param' => array($isPopular),
            'joinType' => 'LEFT',
        );

        $list = Doo::db()->relateMany('NwItems', array('NwItemLocale'), $params);
        $this->applyPathAndLang($list);

        return $list;
    }

    public function getPopularBlog($limit = 5, $topOnly = false) {
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
            'where' => "{$items->_table}.isInternal = 0  AND {$items->_table}.isReview = 0 AND {$items->_table}.isBlog = 1 AND {$items->_table}.Published = 1 AND {$items->_table}.isPopular = ? AND {$items->_table}.OwnerType = 'player'",
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
            'where' => "{$items->_table}.isInternal = 0 AND {$items->_table}.isReview = 0 AND {$items->_table}.isBlog = 0 AND {$items->_table}.Published = 1 AND ({$items->_table}.ID_PLATFORM = ? OR ({$items->_table}.ID_PLATFORM = 0 AND {$items->_table}.OwnerType = ? AND {$items->_table}.ID_OWNER IN (SELECT {$gameplatrel->_table}.ID_GAME FROM {$gameplatrel->_table} WHERE {$gameplatrel->_table}.ID_PLATFORM = ?))) AND {$items->_table}.OwnerType <> 'group'",
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
										WHERE n.isReview = 0 AND n.isBlog = 0 AND (l.Published = 0 OR n.Published = 0) AND n.isInternal IN (0,1,2)
                                        LIMIT 1");
//										WHERE n.isInternal = 0  AND (l.Published = 0 OR n.Published = 0)

        return $totalNum->cnt;
    }

    public function getUnpublishedNews($limit = 4, $sortType = '', $sortDir = 'desc') {
        $locale = new NwItemLocale;
        $items = new NwItems;
        $player = new Players();
        $orderby = "";
        switch ($sortType) {
            case "news":
                $orderby = $locale->_table . '.Headline';
                break;
            case "author":
                $orderby = 'Author';
                break;
            case "languages":
                $orderby = $locale->_table . '.ID_LANGUAGE';
                break;
            default:
                $orderby = $items->_table . '.PostingTime';
        };

        $params['NwItemLocale'] = array(
            'select' => "{$items->_table}.*, {$locale->_table}.*, (SELECT {$player->_table}.DisplayName FROM {$player->_table} WHERE {$player->_table}.ID_PLAYER = {$items->_table}.ID_AUTHOR) as Author", //, {$locale->_table}.Headline as THeadline, {$locale->_table}.NewsText as TNewsText, {$locale->_table}.ID_LANGUAGE as TID
            "{$sortDir}" => "{$orderby}",
            'limit' => $limit,
            'where' => "{$items->_table}.isReview = 0 AND {$items->_table}.isBlog = 0 AND ({$items->_table}.Published = 0 OR {$locale->_table}.Published = 0) AND {$items->_table}.isInternal IN (0,1,2)",
//			'where' => "{$items->_table}.isReview = 0 AND {$items->_table}.isBlog = 0 AND {$items->_table}.isInternal = 0 AND ({$items->_table}.Published = 0 OR {$locale->_table}.Published = 0)",
            'joinType' => 'LEFT',
        );

        $list = Doo::db()->relateMany('NwItems', array('NwItemLocale', 'Players'), $params);
        if ($list and !empty($list)) {
//adds related platforms, games, companies
            foreach ($list as &$l) {
                $l->applyUserLangs(true);
            };
        };
        return $list;
    }

    public function getLocalNewsTotal($filter) {
        $totalNum = 0;
        $ni = new NwItems();
        $locale = new NwItemLocale;
        if ($filter == "on")
            $internal = "n.isInternal = 1";
        else
            $internal = "n.isInternal > 0";
        $totalNum = (object) Doo::db()->fetchRow("SELECT COUNT(1) as cnt FROM `{$ni->_table}` n
										WHERE {$internal} AND n.Published = 1
                                        LIMIT 1");

        return $totalNum->cnt;
    }

    public function getLocalNews($limit = 4, $filter) {
        $locale = new NwItemLocale;
        $items = new NwItems;
        $player = new Players();
        if ($filter == "on")
            $internal = "{$items->_table}.isInternal = 1";
        else
            $internal = "{$items->_table}.isInternal > 0";

        $params['NwItemLocale'] = array(
            'select' => "{$items->_table}.*, {$locale->_table}.*, (SELECT {$player->_table}.DisplayName FROM {$player->_table} WHERE {$player->_table}.ID_PLAYER = {$items->_table}.ID_AUTHOR) as Author", //, {$locale->_table}.Headline as THeadline, {$locale->_table}.NewsText as TNewsText, {$locale->_table}.ID_LANGUAGE as TID
            'desc' => "{$items->_table}.ID_NEWS",
            'limit' => $limit,
            'where' => "{$items->_table}.isReview = 0 AND {$items->_table}.isBlog = 0 AND {$internal} AND {$items->_table}.Published = 1",
            'joinType' => 'LEFT',
        );


        $list = Doo::db()->relateMany('NwItems', array('NwItemLocale', 'Players'), $params);
        if ($list and !empty($list)) {
//adds related platforms, games, companies
            foreach ($list as &$l) {

                $l->applyUserLangs(true);
            }
        }

        return $list;
    }

    public function getUnpublishedReviewsTotal() {
        $totalNum = 0;
        $ni = new NwItems();
        $locale = new NwItemLocale();
        $totalNum = (object) Doo::db()->fetchRow("SELECT COUNT(1) as cnt FROM `{$ni->_table}` n LEFT JOIN
										{$locale->_table} as l ON l.ID_NEWS = n.ID_NEWS
										WHERE n.isReview = 1 AND l.Published = 0;
                                        LIMIT 1");

        return $totalNum->cnt;
    }

    public function getAllUnpublishedReviews($limit = 4) {
        $locale = new NwItemLocale;
        $items = new NwItems;
        $player = new Players();

        $params['NwItemLocale'] = array(
            'select' => "{$items->_table}.*, {$locale->_table}.*, (SELECT {$player->_table}.DisplayName FROM {$player->_table} WHERE {$player->_table}.ID_PLAYER = {$items->_table}.ID_AUTHOR) as Author", //, {$locale->_table}.Headline as THeadline, {$locale->_table}.NewsText as TNewsText, {$locale->_table}.ID_LANGUAGE as TID
            'desc' => "{$items->_table}.ID_NEWS",
            'limit' => $limit,
            'where' => "{$items->_table}.isReview = 1 AND {$locale->_table}.Published = 0",
            'joinType' => 'LEFT',
        );


        $list = Doo::db()->relateMany('NwItems', array('NwItemLocale', 'Players'), $params);
        if ($list and !empty($list)) {
//adds related platforms, games, companies
            foreach ($list as &$l) {

                $l->applyUserLangs(true);
            }
        }

        return $list;
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

    public function publishLocalNews(NwItems $news) {
        $news->isInternal = 0;
        $news->update();
        return TRUE;
    }

    public function statusLocalNews(NwItems $news, $status) {
        if ($status == "seen")
            $news->isInternal = 2;
        elseif ($status == "unseen")
            $news->isInternal = 1;
        $news->update();
        return TRUE;
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

    public function getTotalReviews($gameId) {
        $totalNum = 0;
        $ni = new NwItems();
        $totalNum = (object) Doo::db()->fetchRow('SELECT COUNT(1) as cnt FROM `' . $ni->_table . '`
										WHERE isReview = 1 AND isBlog = 0 AND Published = 1 AND OwnerType = \'game\' AND ID_OWNER = ?
                                        LIMIT 1', array($gameId));

        return $totalNum->cnt;
    }

    public function getTotalUnpublishedReviews($gameId) {
        $totalNum = 0;
        $ni = new NwItems();
        $u = User::getUser();

        if ($u) {
            $totalNum = (object) Doo::db()->fetchRow('SELECT COUNT(1) as cnt FROM `' . $ni->_table . '`
											WHERE isReview = 1 AND isBlog = 0 AND Published = 0 AND OwnerType = \'game\' AND ID_OWNER = ? AND ID_AUTHOR = ?
											LIMIT 1', array($gameId, $u->ID_PLAYER));

            return $totalNum->cnt;
        }

        return 0;
    }

    public function getReviews($gameId, $limit = 4) {
        $locale = new NwItemLocale;
        $items = new NwItems;

        $params['NwItemLocale'] = array(
            'select' => "{$items->_table}.*, {$locale->_table}.*",
            'limit' => $limit,
            'desc' => "{$items->_table}.PostingTime",
            'where' => "{$items->_table}.ID_OWNER = ? AND {$items->_table}.isReview = 1 AND {$items->_table}.isBlog = 0 AND {$items->_table}.Published = 1 AND {$items->_table}.OwnerType = ?",
            'param' => array($gameId, GAME),
            'joinType' => 'LEFT',
        );

        $list = Doo::db()->relateMany('NwItems', array('NwItemLocale'), $params);
        $this->applyPathAndLang($list);

        return $list;
    }

    public function getReviewsRating($gameId) {
        $reviews = News::getReviews($gameId);
        $total = 0;
        $numbers = 0;
        $rating = 0;

        if (isset($reviews)):
            foreach ($reviews as $review) {
                if ((int) $review->SocialRating != 0) {
                    $total = $total + (int) $review->SocialRating;
                    $numbers++;
                }
            }
            $rating = $numbers > 0 ? $total / $numbers : 0;
        endif;

        return $rating;
    }

    public function getUnpublishedReviews($gameId, $limit = 4) {
        $locale = new NwItemLocale;
        $items = new NwItems;

        $u = User::getUser();

        if ($u) {
            if ($u->canAccess('Super Admin Interface') === TRUE) {
                $where = "{$items->_table}.ID_OWNER = ? AND {$items->_table}.isReview = 1 AND {$items->_table}.isBlog = 0 AND {$items->_table}.Published = 0 AND {$items->_table}.OwnerType = ?";
                $param = array($gameId, GAME);
            } else {
                $where = "{$items->_table}.ID_OWNER = ? AND {$items->_table}.isReview = 1 AND {$items->_table}.isBlog = 0 AND {$items->_table}.Published = 0 AND {$items->_table}.OwnerType = ? AND {$items->_table}.ID_AUTHOR = ?";
                $param = array($gameId, GAME, $u->ID_PLAYER);
            }
            $params['NwItemLocale'] = array(
                'select' => "{$items->_table}.*, {$locale->_table}.*", //, {$locale->_table}.Headline as THeadline, {$locale->_table}.NewsText as TNewsText, {$locale->_table}.ID_LANGUAGE as TID
                'limit' => $limit,
                'desc' => "{$items->_table}.PostingTime",
                'where' => $where,
                'param' => $param,
                'joinType' => 'LEFT',
            );

            $list = Doo::db()->relateMany('NwItems', array('NwItemLocale'), $params);
            $this->applyPathAndLang($list);

            return $list;
        } else {
            return array();
        }
    }

    public function updateCache(NwItems $news) {
        Cache::increase(CACHE_NEWS . $news->ID_NEWS);
    }

    /**
     * Upload handler
     *
     * @return array
     */
    public function uploadPhoto($id, $isBlog = false) {
        $p = User::getUser();

        if ($p and $p->canAccess('Add news image')) {
            $c = Doo::db()->getOne('NwItemLocale', array(
                'limit' => 1,
                'where' => 'ID_NEWS = ?',
                'param' => array($id)
            ));

            $image = new Image();
            if ($isBlog == true)
                $result = $image->uploadImage(FOLDER_BLOG, $c->Image);
            else
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

    /**
     * Converts arrays of objects to be handled by JSON for NewsAdmin
     *
     * @return array
     */
    public function populateArrayNewsAdmin($owners, $keys) {
        $array = array();
        foreach ($owners as $key => $owner) {
            $array[$key] = (object) array();
            foreach ($keys as $node) {
                $array[$key]->$node[0] = $owner->$node[1];
            }
        }
        return $array;
    }

    public function unpublishReview($newsID, $langID, $note) {
        $article = $this->getArticleByID($newsID);
        $locale = $article->getLangById($langID);
        $table = $locale->_table;
        if ($locale) {
            $Opts = array(
                "limit" => 1,
                "param" => array($locale->ID_NEWS),
                "where" => "{$table}.ID_NEWS = ?",
            );
            $locale->updateAttributes(array("Published" => 0, "EditorNote" => $note), $Opts);
            return TRUE;
        } else {
            return FALSE;
        };
    }

    public function publishReview($newsID) {
        $article = $this->getArticleByID($newsID);
        if ($article) {
            $article->Published = 1;
            $article->update();
            return TRUE;
        } else
            return FALSE;
    }

    public static function getNewsAdminCounters() {
        $news = new News();
        $total = (object) array();
        $total->News = $news->getNewsTotal();
        $total->UnpubNews = $news->getUnpublishedNewsTotal();
        $total->LocalNewsAll = $news->getLocalNewsTotal("off");
        $total->LocalNewsUnseen = $news->getLocalNewsTotal("on");
        $total->UnpubReviews = $news->getUnpublishedReviewsTotal();
        return $total;
    }

    public function saveTranslation($post) {
        extract($post);
        $author = User::getUser();
        $locale = $this->createUpdateLocale($post, $author->ID_PLAYER);
        Url::createUpdateURL($name, URL_NEWS, $newsID, $language);
        return $locale;
    }

    private function urlExists($key) {
        $url = Url::getUrlByName($key, URL_NEWS);

        return isset($url);
    }

    public function getRelatedNews($id, $limit = 3) {
        $player = User::getUser();

        if ($player)
            $langID = $player->ID_LANGUAGE . ',' . $player->OtherLanguages;
        else
            $langID = Lang::getCurrentLangID() . ',1';

        $item = $this->getArticleByID($id, $langID = 0);

        $LatestNews = $this->getLatestNews($limit);
        $TypeNews = $this->getNewsByType($item->ID_OWNER, $item->OwnerType, $limit, 1, 1);
        $TypeAuthor = $this->getNewsByAuthor($item->ID_AUTHOR, $limit, 1);
        $TypeSameTypeCat = "";
        switch ($item->OwnerType) {
            case "game":
                $TypeSameTypeCat = $this->getNewsByCategory($item->ID_OWNER, $item->ID_NEWS, $item->OwnerType, $limit, 1);
                break;

            case "company":
                $TypeSameTypeCat = $this->getNewsByCategory($item->ID_OWNER, $item->ID_NEWS, $item->OwnerType, $limit, 1);
                break;
        }

        $RelatedList = array('Type' => $TypeNews, 'Latest' => $LatestNews, 'Author' => $TypeAuthor, 'Category' => $TypeSameTypeCat);

        return $RelatedList;
    }

    public function getRelatedNewsTableRows($newsID, $relatedLimit = 3) {
        $list = $this->getRelatedNews($newsID, $relatedLimit);
        $textLimit = 150;
        $output = '';
        $relatedPerRow = Doo::conf()->relatedPerRow;
        $tdFormat = '<td><a href="%4$s"><img src="%1$s"></a><span><h3>%2$s</h3><p>' . DooTextHelper::limitChar('%3$s', $textLimit, '') . '<a href="%4$s">Read&nbsp;More</a></p></span></td>';
        $tdLastFormat = '<td class="related_links_last"><a href="%4$s"><img src="%1$s"></a><span><h3>%2$s</h3><p>' . DooTextHelper::limitChar('%3$s', $textLimit, '') . ' <a href="%4$s">Read&nbsp;More</a></p></span></td>';
        $tdFirstLastFormat = '<td class="related_links_first_last"><a href="%4$s"><img src="%1$s"></a><span><h3>%2$s</h3><p>' . DooTextHelper::limitChar('%3$s', $textLimit, '') . ' <a href="%4$s">Read&nbsp;More</a></p></span></td>';
        foreach ($list as $newsType) {
            if (is_array($newsType)):
                foreach ($newsType as $key => $item) {
                    $firstInRow = ($key % $relatedPerRow == 0);
                    $lastInRow = (($key + 1) % $relatedPerRow == 0);
                    $lastInSet = ($key == count($newsType) - 1);
                    if ($firstInRow) {
                        $output .= '<table class="related_links"><tr>';
                    }
                    $src = MainHelper::showImage($item, THUMB_LIST_110x83, true, array('no_img' => 'noimage/no_news_110x83.png'));
                    if ($this->urlExists($src)) {
                        if ($firstInRow && $lastInSet) {
                            $output .= sprintf($tdFirstLastFormat, $src, $item->Headline, $item->IntroText, $item->URL);
                        } elseif ($lastInRow || $lastInSet) {
                            $output .= sprintf($tdLastFormat, $src, $item->Headline, $item->IntroText, $item->URL);
                        } else {
                            $output .= sprintf($tdFormat, $src, $item->Headline, $item->IntroText, $item->URL);
                        }
                    }
                }
            endif;
        }
        if ($lastInRow || $lastInSet) {
            $output .= '</tr></table>';
        }
        echo $output;
    }
    
    //get added news by who is logged in the admin
    public function getPlayerNews($ID_PLAYER,$filter,$limit){
		$item = new NwItems();$itemsTable = $item->_table;
		$itemlocale = new NwItemLocale();$itemlocaleTable = $itemlocale->_table;
		
		$searchcriteria = '';
		if($filter == 'pub') 
			$searchcriteria = " AND {$itemlocaleTable}.Published = 1";
		elseif($filter == 'unpub')
			 $searchcriteria = " AND {$itemlocaleTable}.Published = 0";
			    
    	$params['NwItemLocale'] = array(
    						'select' 	=> "{$itemsTable}.*,{$itemlocaleTable}.*",
    						'joinType' 	=> 'INNER',
    						'where' 		=> "{$itemlocaleTable}.isBlog = 0 AND {$itemlocaleTable}.isReview = 0 " .
    										"AND {$itemsTable}.ID_AUTHOR = " . $ID_PLAYER . $searchcriteria,
    						'desc' 		=> "{$itemlocaleTable}.PostingTime",
    						'limit'		=> $limit
    	);
    	
    	$list = Doo::db()->relateMany('NwItems',array('NwItemLocale'),$params);
    	$this->applyPathAndLang($list);
    	return $list;
    }
   
   //get editor note of one article in admin
	public function getPlayerNewsNotes($ID_NEWS,$ID_LANGUAGE){
		$item=new NwItems();$itemtable=$item->_table;
		$itemlocale= new NwItemLocale(); $itemlocaletable=$itemlocale->_table;
		
		$params['NwItemLocale']= array(
			'select'	=> "$itemtable.*,$itemlocaletable.*",
			'joinType'	=> 'INNER',
			'where'	=> "$itemlocaletable.ID_NEWS=".$ID_NEWS." AND $itemlocaletable.ID_LANGUAGE=".$ID_LANGUAGE
		);
		
		$list = Doo::db()->relateMany('NwItems',array('NwItemLocale'),$params);
		$this->applyPathAndLang($list);
		return $list;
	}
	
	//get total af a player added news
	public function getPlayerNewsTotal($ID_PLAYER,$filter){
		
        $itemlocale=new NwItemLocale();$itemlocaletable=$itemlocale->_table;
        $params=array();
        $searchcriteria='';
        if($filter=='unpub')
        	$searchcriteria= " AND $itemlocaletable.Published = 0";
        elseif($filter=='pub')
        	$searchcriteria= " AND $itemlocaletable.Published = 1";
        
        $query = "select count($itemlocaletable.ID_NEWS) as pnt from $itemlocaletable 
        				where $itemlocaletable.isBlog = 0 and $itemlocaletable.isReview = 0 
        				and $itemlocaletable.ID_PLAYER = ".$ID_PLAYER.$searchcriteria;
        $result = (object) Doo::db()->fetchRow($query);
        return $result->pnt;        
				
	}

    public function getNewsByPrefix($id) {
        $news = new News();

        $locale = new NwItemLocale();
        $items = new NwItems();

        $params = array(
            'select' => "{$items->_table}.*, {$locale->_table}.*",
            'where' => "{$items->_table}.Published = 1 AND {$locale->_table}.Published = 1 AND {$items->_table}.ID_PREFIX = $id",
        );
        $params['NwItemLocale'] = array(
            'joinType' => 'inner'
        );

        $list = Doo::db()->relate('NwItems', 'NwItemLocale', $params);

       return $list;
    }

}

?>