<?php

class AdminNewsController extends AdminController {

    /**
     * Main website
     *
     */
    public function index() {
		$player = User::getUser();
		if($player->canAccess('Approve news') === FALSE) {
			DooUriRouter::redirect(MainHelper::site_url('admin'));
		};

		//Delete news action
		$this->DeleteNewsActionPost();

		$news = new News();
        $list = array();
        $params = $this->params;
        $sortType = isset($params['sortType']) ? $params['sortType'] : 'by-date-added';
		$sortDir = isset($params['sortDir']) ? $params['sortDir'] : 'desc';
        $newsTotal = $news->getNewsTotal(TRUE);
        $pager = $this->appendPagination($list, $news, $newsTotal, MainHelper::site_url('admin/news/page'), Doo::conf()->adminNewsLimit);

		$list['newsList'] = $news->getLatestNews($pager->limit, $sortType, $sortDir, TRUE);
		$list['sortType'] = $sortType;
		$list['sortDir'] = $sortDir;
		$data['title'] = $this->__('News');
		$data['body_class'] = 'index_news';
		$data['selected_menu'] = 'news';
		$data['left'] =  $this->renderBlock('news/common/leftColumn');
		$data['right'] = 'right';
		$data['content'] = $this->renderBlock('news/index', $list);
		$data['footer'] = MainHelper::bottomMenu();
		$data['header'] = $this->getMenu();
		$this->render3Cols($data);
	}

	public function DeleteNewsActionPost() {
        $input = filter_input_array(INPUT_POST);
		//Delete news action
		if(isset($input['action']) && $input['action'] == "delete") { //Delete news
            $news = new News();
            foreach ($input as $k => $v) {
                if (strpos($k, "ID_") === 0) {
                    $ID_NEWS = str_replace("ID_", "", $k);
                    $news->deleteNewsItem($ID_NEWS);
                };
            };
        };
    }

    public function PublishNewsActionPost() {
        $input = $_POST;
        //Publish news action
        if (isset($input['action']) && $input['action'] == "publish") { //Publish news
            $news = new News();
            foreach ($input as $k => $v) {
                if (strpos($k, "ID_") === 0) {
                    $ID_NEWS = str_replace("ID_", "", $k);
                    $query = "UPDATE nw_items SET Published=1 WHERE ID_NEWS = {$ID_NEWS};
                              UPDATE nw_itemlocales SET Published=1 WHERE ID_NEWS = {$ID_NEWS}";
                    Doo::db()->query($query);
                };
            };
        };
    }

    public function unpublished() {
        $player = User::getUser();
        $news = new News();
        if ($player->canAccess('Approve news') === FALSE) {
            DooUriRouter::redirect(MainHelper::site_url('admin'));
        };
        //Publish news action
        $this->PublishNewsActionPost();
        //Delete news action
        $this->DeleteNewsActionPost();
        //Publish unpublished item before showing whole list
        if (isset($this->params['publishid'])) {
            $ID_NEWS = $this->params['publishid'];
            $query = "	UPDATE nw_items SET Published=1 WHERE ID_NEWS = {$ID_NEWS};
						UPDATE nw_itemlocales SET Published=1 WHERE ID_NEWS = {$ID_NEWS}";
            Doo::db()->query($query);
        };
        $list = array();
        $newsTotal = $news->getUnpublishedNewsTotal();
        $pager = $this->appendPagination($list, $news, $newsTotal, MainHelper::site_url('admin/news/unpublished/page'), Doo::conf()->adminNewsLimit);
        $sortType = isset($this->params['sortType']) ? $this->params['sortType'] : 'date';
        $sortDir = isset($this->params['sortDir']) ? $this->params['sortDir'] : 'desc';
        $newsList = $news->getUnpublishedNews($pager->limit, $sortType, $sortDir);
        $data['title'] = $this->__('Unpublished News');
        $data['body_class'] = 'index_news';
        $data['left'] = $this->renderBlock('news/common/leftColumn');
        $data['selected_menu'] = 'news';
        $data['right'] = 'right';
        $list['newsList'] = $newsList;
        $list['sortDir'] = $sortDir;
        $list['sortType'] = $sortType;
        $data['content'] = $this->renderBlock('news/unpublished', $list);
        $data['footer'] = MainHelper::bottomMenu();
        $data['header'] = $this->getMenu();
        $this->render3Cols($data);
    }

    public function local() {
        $player = User::getUser();
        $news = new News();

        if ($player->canAccess('Approve news') === FALSE) {
            DooUriRouter::redirect(MainHelper::site_url('admin'));
        }

        $filter = $this->params['filter'];
        if (!$filter)
            $filter = "off";

        if (isset($_POST['filter'])) {
            if ($_POST['filter'] == "unseen")
                $filter = "on";
            elseif ($_POST['filter'] == "off")
                $filter = "off";
        }

        $list = array();
        $newsTotal = $news->getLocalNewsTotal($filter);
        $pager = $this->appendPagination($list, $news, $newsTotal, MainHelper::site_url('admin/news/local/page'), Doo::conf()->adminNewsLimit);

        $newsList = $news->getLocalNews($pager->limit, $filter);

        $list['newsList'] = $newsList;
        $list['filter'] = $filter;

        $data['title'] = $this->__('Local News');
        $data['body_class'] = 'index_news';
        $data['left'] = $this->renderBlock('news/common/leftColumn');
        $data['selected_menu'] = 'news';
        $data['right'] = 'right';

        $data['content'] = $this->renderBlock('news/local', $list);

        $data['footer'] = MainHelper::bottomMenu();
        $data['header'] = $this->getMenu();
        $this->render3Cols($data);
    }

    public function publishLocal() {
        $player = User::getUser();
        $news = new News();

        if ($player->canAccess('Approve news') === FALSE) {
            DooUriRouter::redirect(MainHelper::site_url('admin'));
        }

        $newsItem = $news->getArticleByID($this->params['news_id']);
        $filter = $this->params['filter'];
        if (!$filter)
            $filter = "off";

        if (!$newsItem) {
            DooUriRouter::redirect(MainHelper::site_url('admin/news/local'));
        } else {
            $result = $news->publishLocalNews($newsItem);
            if ($result === TRUE) {
                DooUriRouter::redirect(MainHelper::site_url('admin/news/local/' . $filter));
            }
        }
    }

    public function seenLocal() {
        $player = User::getUser();
        $news = new News();

        if ($player->canAccess('Approve news') === FALSE) {
            DooUriRouter::redirect(MainHelper::site_url('admin'));
        }

        $newsItem = $news->getArticleByID($this->params['news_id']);
        $status = $this->params['seen'];
        $filter = $this->params['filter'];
        if (!$filter)
            $filter = "off";
        if (!$newsItem || !$status) {
            DooUriRouter::redirect(MainHelper::site_url('admin/news/local'));
        } else {
            if ($status == "seen" || $status == "unseen") {
                $result = $news->statusLocalNews($newsItem, $status);
            } else {
                $result = FALSE;
            }
            if ($result === TRUE) {
                DooUriRouter::redirect(MainHelper::site_url('admin/news/local/' . $filter));
            } else {
                DooUriRouter::redirect(MainHelper::site_url('admin'));
            }
        }
    }

    public function unpublishedReviews() {
        $player = User::getUser();
        $news = new News();

        if ($player->canAccess('Approve news') === FALSE) {
            DooUriRouter::redirect(MainHelper::site_url('admin'));
        }

        $list = array();
        $newsTotal = $news->getUnpublishedReviewsTotal();
        $pager = $this->appendPagination($list, $news, $newsTotal, MainHelper::site_url('admin/news/unpublished-reviews/page'), Doo::conf()->adminNewsLimit);

        $newsList = $news->getAllUnpublishedReviews($pager->limit);

        $list['newsList'] = $newsList;

        $data['title'] = $this->__('Unpublished Reviews');
        $data['body_class'] = 'index_news';
        $data['left'] = $this->renderBlock('news/common/leftColumn');
        $data['selected_menu'] = 'news';
        $data['right'] = 'right';

        $data['content'] = $this->renderBlock('news/unpublishedReviews', $list);

        $data['footer'] = MainHelper::bottomMenu();
        $data['header'] = $this->getMenu();
        $this->render3Cols($data);
    }

    public function publishReview() {
        $player = User::getUser();
        $news = new News();

        if ($player->canAccess('Approve news') === FALSE) {
            DooUriRouter::redirect(MainHelper::site_url('admin'));
        }

        $newsItem = $news->getArticleByID($this->params['news_id']);

        if (!$newsItem) {
            DooUriRouter::redirect(MainHelper::site_url('admin/news/unpublished-reviews'));
        } else {
            $result = $news->publishReview($newsItem->ID_NEWS);
            if ($result === TRUE) {
                DooUriRouter::redirect(MainHelper::site_url('admin/news/unpublished-reviews'));
            }
        }
    }

    public function deleteReview() {
        $player = User::getUser();
        $news = new News();

        if ($player->canAccess('Delete news') === FALSE) {
            DooUriRouter::redirect(MainHelper::site_url('admin'));
        }

        $newsItem = $news->getArticleByID($this->params['news_id']);

        if (!$newsItem) {
            DooUriRouter::redirect(MainHelper::site_url('admin/news/unpublished-reviews'));
        } else {
            $result = $news->deleteNewsItem($newsItem->ID_NEWS);
            if ($result === TRUE) {
                DooUriRouter::redirect(MainHelper::site_url('admin/news/unpublished-reviews'));
            }
        }
    }

    /*     * ********** */
    /* Frontpage */
    /*     * ********** */

    public function frontpage() {
        $player = User::getUser();
        if ($player->canAccess('Approve news') === FALSE) {
            DooUriRouter::redirect(MainHelper::site_url('admin'));
        }

        $frontpage = new NwFrontpage();
        $list = array();

        if (isset($_POST) && !empty($_POST)) {
            $modules = $frontpage->getAllModules();
            foreach ($modules as $module) {
                $module->Frontpage = isset($_POST[$module->ID_FRONTPAGE . '_Frontpage']) ? 1 : 0;
                $module->News = isset($_POST[$module->ID_FRONTPAGE . '_News']) ? 1 : 0;
                $module->FTU = isset($_POST[$module->ID_FRONTPAGE . '_FTU']) ? 1 : 0;
                $module->update();
            }
        }

        $list['modules'] = $frontpage->getAllModules();

        $data['title'] = $this->__('News Frontpage');
        $data['body_class'] = 'index_news';
        $data['left'] = $this->renderBlock('news/common/leftColumn');
        $data['selected_menu'] = 'news';
        $data['right'] = 'right';
        $data['content'] = $this->renderBlock('news/frontpage', $list);
        $data['footer'] = MainHelper::bottomMenu();
        $data['header'] = $this->getMenu();
        $this->render3Cols($data);
    }

    /*     * *********** */
    /* Highlights */
    /*     * *********** */

    public function highlights() {
        $player = User::getUser();
        if ($player->canAccess('Approve news') === FALSE) {
            DooUriRouter::redirect(MainHelper::site_url('admin'));
        }
        $highlights = new NewsHighlights;
        $list = array();

        $list['highlights'] = $highlights->getAllHighlights();

        $data['title'] = $this->__('News Frontpage');
        $data['body_class'] = 'index_news';
        $data['left'] = $this->renderBlock('news/common/leftColumn');
        $data['selected_menu'] = 'news';
        $data['right'] = 'right';
        $data['content'] = $this->renderBlock('news/highlights', $list);
        $data['footer'] = MainHelper::bottomMenu();
        $data['header'] = $this->getMenu();
        $this->render2ColsLeft($data);
    }

    public function deleteHighlight() {
        if (isset($this->params['id'])) {
            $highlights = new NewsHighlights;
            $highlights->deleteHighlight($this->params['id']);
        }
        header('Location: ' . MainHelper::site_url('admin/news/frontpage/highlights'));
    }

    public function editHighlight() {
        $player = User::getUser();
        if ($player->canAccess('Approve news') === FALSE) {
            DooUriRouter::redirect(MainHelper::site_url('admin'));
        }
        $highlights = new NewsHighlights;
        $list = array();

        if (isset($_POST) && !empty($_POST)) {
            $highlight = new NewsHighlights;
            foreach ($_POST as $key => $value) {
                $highlight->$key = $value;
            }
            $highlight->updateHighlight();
            header('Location: ' . MainHelper::site_url('admin/news/frontpage/highlights'));
            exit;
        }

        if (isset($this->params['id'])) {
            if ($this->params['id'] > 0) {
                $list['highlights'] = $highlights->getHighlight($this->params['id']);
            } else {
                // Set default values for new record
                $highlight = new NwHighlights;
                $highlight->ID_HIGHLIGHT = 0;
                $highlight->Priority = 1;
                $highlight->isActive = 1;
                $list['highlights'][] = $highlight;
            }
        }

        $list['files'] = $highlights->getAllFiles();

        $data['title'] = $this->__('News Frontpage');
        $data['body_class'] = 'index_news';
        $data['left'] = $this->renderBlock('news/common/leftColumn');
        $data['selected_menu'] = 'news';
        $data['right'] = 'right';
        $data['content'] = $this->renderBlock('news/edithighlight', $list);
        $data['footer'] = MainHelper::bottomMenu();
        $data['header'] = $this->getMenu();
        $this->render2ColsLeft($data);
    }

    /*     * ******* */
    /* Slider */
    /*     * ******* */

    public function slider() {
        $player = User::getUser();
        if ($player->canAccess('Approve news') === FALSE) {
            DooUriRouter::redirect(MainHelper::site_url('admin'));
        }
        $slider = new NewsSlider;
        $list = array();

        $list['slides'] = $slider->getAllSlides();

        $data['title'] = $this->__('News Frontpage');
        $data['body_class'] = 'index_news';
        $data['left'] = $this->renderBlock('news/common/leftColumn');
        $data['selected_menu'] = 'news';
        $data['right'] = 'right';
        $data['content'] = $this->renderBlock('news/slider', $list);
        $data['footer'] = MainHelper::bottomMenu();
        $data['header'] = $this->getMenu();
        $this->render2ColsLeft($data);
    }

    public function deleteSlider() {
        if (isset($this->params['id'])) {
            $slider = new NewsSlider;
            $slider->deleteSlide($this->params['id']);
        }
        header('Location: ' . MainHelper::site_url('admin/news/frontpage/slider'));
    }

    public function editSlider() {
        $player = User::getUser();
        if ($player->canAccess('Approve news') === FALSE) {
            DooUriRouter::redirect(MainHelper::site_url('admin'));
        }
        $slider = new NewsSlider;
        $list = array();

        if (isset($_POST) && !empty($_POST)) {
            $slide = new NewsSlider;
            foreach ($_POST as $key => $value) {
                $slide->$key = $value;
            }
            $slide->updateSlide();
            header('Location: ' . MainHelper::site_url('admin/news/frontpage/slider'));
            exit;
        }

        if (isset($this->params['id'])) {
            if ($this->params['id'] > 0) {
                $list['slides'] = $slider->getSlide($this->params['id']);
            } else {
                // Set default values for new record
                $slide = new NwSlides;
                $slide->ID_SLIDE = 0;
                $slide->Priority = 1;
                $slide->isActive = 1;
                $list['slides'][] = $slide;
            }
        }

        $list['files'] = $slider->getAllFiles();

        $data['title'] = $this->__('News Frontpage');
        $data['body_class'] = 'index_news';
        $data['left'] = $this->renderBlock('news/common/leftColumn');
        $data['selected_menu'] = 'news';
        $data['right'] = 'right';
        $data['content'] = $this->renderBlock('news/editslider', $list);
        $data['footer'] = MainHelper::bottomMenu();
        $data['header'] = $this->getMenu();
        $this->render2ColsLeft($data);
    }

    /*     * ******** */
    /* Crawler */
    /*     * ******** */

    public function crawlerSubscriptions() {
        $player = User::getUser();
        if ($player->canAccess('Approve news') === FALSE) {
            DooUriRouter::redirect(MainHelper::site_url('admin'));
        }

        //---- Ensure that klient server know its own ID and subscription table exists ----
        $sySettings = new SySettings;
        $paramName = 'NwOwnIdSite';
        $sySettings->ID_SETTING = $paramName;
        if ($sySettings->count() == 0) {
            $db = Doo::db()->getDefaultDbConfig()[1];
            Doo::db()->reconnect('news');
            $glSites = new GlSites;
            $glSites->ID_LANGUAGE = 1;
            $glSites->Name = ucfirst($db);
            $glSites->isInternal = 1;
            $glSites->isActive = 0;
            $idSite = $glSites->Insert();
            Doo::db()->reconnect(Doo::conf()->APP_MODE);
            $sySettings = new SySettings;
            $sySettings->ID_SETTING = $paramName;
            $sySettings->ValueInt = $idSite;
            $sySettings->Insert();
            Doo::db()->query('CALL nw_SitesUpdate');
        }

        if (isset($_POST) && !empty($_POST)) {
            $active = implode(',', array_keys($_POST));
            $sites = new NwSites;
            Doo::db()->query('UPDATE ' . $sites->_table . ' SET isActive = 1 WHERE ID_SITE IN (' . $active . ')');
            Doo::db()->query('UPDATE ' . $sites->_table . ' SET isActive = 0 WHERE ID_SITE NOT IN (' . $active . ')');
        }
        $list = array();
        $list['sites'] = Doo::db()->find('NwSites', array('asc' => 'Name'));
        $data['title'] = $this->__('News Crawler');
        $data['body_class'] = 'index_news';
        $data['left'] = $this->renderBlock('news/common/leftColumn');
        $data['selected_menu'] = 'news';
        $data['content'] = $this->renderBlock('news/crawlersubscriptions', $list);
        $data['footer'] = MainHelper::bottomMenu();
        $data['header'] = $this->getMenu();
        $this->render3Cols($data);
    }

    public function crawlerSites() {
        $player = User::getUser();
        if ($player->canAccess('Approve news') === FALSE) {
            DooUriRouter::redirect(MainHelper::site_url('admin'));
        }

        $list = array();
        Doo::db()->reconnect('news');
        $list['sites'] = Doo::db()->find('GlSites', array('asc' => 'Name'));
        Doo::db()->reconnect(Doo::conf()->APP_MODE);
        $data['title'] = $this->__('News Crawler');
        $data['body_class'] = 'index_news';
        $data['left'] = $this->renderBlock('news/common/leftColumn');
        $data['selected_menu'] = 'news';
        $data['content'] = $this->renderBlock('news/crawlersites', $list);
        $data['footer'] = MainHelper::bottomMenu();
        $data['header'] = $this->getMenu();
        $this->render3Cols($data);
    }

    public function deleteCrawlerSite() {
        if (isset($this->params['id'])) {
            Doo::db()->reconnect('news');
            Doo::db()->delete('GlSites', array('where' => 'ID_SITE=' . $this->params['id']));
            Doo::db()->reconnect(Doo::conf()->APP_MODE);
        }
        header('Location: ' . MainHelper::site_url('admin/news/crawlersites'));
    }

    public function editCrawlerSite() {
        $player = User::getUser();
        if ($player->canAccess('Approve news') === FALSE) {
            DooUriRouter::redirect(MainHelper::site_url('admin'));
        }

        if (isset($_POST) && !empty($_POST)) {
            Doo::db()->reconnect('news');
            $glSites = new GlSites();
            foreach ($_POST as $key => $value) {
                if ($key == 'LoginPassword') {
                    $glSites->$key = CrawlerLogin::encryptPassword($value);
                } else {
                    $glSites->$key = $value;
                }
            }
            if ($glSites->ID_SITE == 0) {
                $glSites->insert();
            } else {
                $glSites->update();
            }
            Doo::db()->reconnect(Doo::conf()->APP_MODE);
            header('Location: ' . MainHelper::site_url('admin/news/crawlersites'));
            exit;
        }

        $list = array();
        if (isset($this->params['id'])) {
            if ($this->params['id'] > 0) {
                Doo::db()->reconnect('news');
                $list['sites'] = Doo::db()->find('GlSites', array('where' => 'ID_SITE=' . $this->params['id']));
                Doo::db()->reconnect(Doo::conf()->APP_MODE);
            } else {
                // Set default values for new record
                $glSite = new GlSites();
                $glSite->ID_SITE = 0;
                $glSite->ID_LANGUAGE = 1;
                $glSite->isActive = 1;
                $list['sites'][] = $glSite;
            }
        }

        $data['title'] = $this->__('News Crawler');
        $data['body_class'] = 'index_news';
        $data['left'] = $this->renderBlock('news/common/leftColumn');
        $data['selected_menu'] = 'news';
        $data['content'] = $this->renderBlock('news/editcrawlersite', $list);
        $data['footer'] = MainHelper::bottomMenu();
        $data['header'] = $this->getMenu();
        $this->render3Cols($data);
    }

    public function crawlerGlobals() {
        $player = User::getUser();
        if ($player->canAccess('Approve news') === FALSE) {
            DooUriRouter::redirect(MainHelper::site_url('admin'));
        }

        // ---- Build crawler parameter list ----
        $crawlerParams = array(
            'NwFollowMode' => array('type' => 'ValueInt', 'value' => '')
            , 'NwObeyNoFollow' => array('type' => 'ValueBool', 'value' => '')
            , 'NwObeyNoIndex' => array('type' => 'ValueBool', 'value' => '')
            , 'NwObeyRobotsTxt' => array('type' => 'ValueBool', 'value' => '')
            , 'NwPageLimit' => array('type' => 'ValueInt', 'value' => '')
            , 'NwProcessTimeLimit' => array('type' => 'ValueInt', 'value' => '')
            , 'NwPublishCrawlerFindings' => array('type' => 'ValueBool', 'value' => '')
            , 'NwScanInterval' => array('type' => 'ValueInt', 'value' => '')
            , 'NwSitePageLimit' => array('type' => 'ValueInt', 'value' => '')
            , 'NwSiteTrafficLimit' => array('type' => 'ValueInt', 'value' => '')
            , 'NwTrafficLimit' => array('type' => 'ValueInt', 'value' => '')
        );
        ksort($crawlerParams);

        // ---- Update SySettings if posted ----
        Doo::db()->reconnect('news');
        if (isset($_POST) && !empty($_POST)) {
            $glSettings = Doo::db()->find('GlSettings', array('where' => 'ID_SETTING IN ("' . implode('","', array_keys($crawlerParams)) . '")'));
            $glSettingsExists = array();                                   // array holds existing params
            foreach ($glSettings as $glSetting) {
                $glSettingsExists[] = $glSetting->ID_SETTING;
            }
            $toDelete = array();
            foreach ($_POST as $key => $value) {
                $glSettings = new GlSettings;
                $glSettings->ID_SETTING = $key;
                $value = trim($value);
                if (!is_numeric($value)) {                                // Ensure numeric or empty values
                    $value = '';
                }
                if ($value == '') {                                       // No value present
                    if (in_array($key, $glSettingsExists)) {              // Remove param if exists
                        $glSettings->delete();
                    }
                } else {                                                    // Value present
                    $glSettings->$crawlerParams[$key]['type'] = $value;
                    if (in_array($key, $glSettingsExists)) {              // Do update if param exists
                        $glSettings->update();
                    } else {                                                // Do insert if param doesn't exists
                        $glSettings->insert();
                    }
                }
            }
        }

        // ---- Preset crawler parameter list with values from SySettings ----
        $glSettings = Doo::db()->find('GlSettings', array('where' => 'ID_SETTING IN ("' . implode('","', array_keys($crawlerParams)) . '")'));
        Doo::db()->reconnect(Doo::conf()->APP_MODE);
        if (isset($glSettings)) {
            foreach ($glSettings as $glSetting) {
                $crawlerParams[$glSetting->ID_SETTING]['value'] = $glSetting->$crawlerParams[$glSetting->ID_SETTING]['type'];
            }
        }

        // ---- View configuration page ----
        $list['crawlerParams'] = $crawlerParams;
        $data['title'] = $this->__('News Crawler');
        $data['body_class'] = 'index_news';
        $data['left'] = $this->renderBlock('news/common/leftColumn');
        $data['selected_menu'] = 'news';
        $data['content'] = $this->renderBlock('news/crawlerglobals', $list);
        $data['footer'] = MainHelper::bottomMenu();
        $data['header'] = $this->getMenu();
        $this->render3Cols($data);
    }

    public function crawlerLogs() {
        Doo::db()->reconnect('news');
        $list['logs'] = Doo::db()->find('GlCrawlerLog', array('desc' => 'LogStartTime'));
        Doo::db()->reconnect(Doo::conf()->APP_MODE);
        $data['title'] = $this->__('News Crawler');
        $data['left'] = $this->renderBlock('news/common/leftColumn');
        $data['content'] = $this->renderBlock('news/crawlerlogs', $list);
        $data['footer'] = MainHelper::bottomMenu();
        $data['header'] = $this->getMenu();
        $this->render2ColsLeft($data);
    }

    public function ajaxDeleteCrawlerLog() {
        if ($this->isAjax()) {
            if (isset($_POST['crawlerlog']) && !empty($_POST['crawlerlog'])) {
                Doo::db()->reconnect('news');
                $log = new GlCrawlerLog;
                $log->ID_LOG = $_POST['crawlerlog']['id'];
                $log->delete();
                Doo::db()->reconnect(Doo::conf()->APP_MODE);
            }
        }
    }

    public function ajaxGetNewsLocale() {
        if ($this->isAjax()) {
            $newsID = isset($_POST['news_id']) ? $_POST['news_id'] : false;
            $langID = isset($_POST['lang_id']) ? $_POST['lang_id'] : false;

            if ($newsID && $langID) {
                $news = new News();
                $data = $news->getArticleByID($newsID, $langID);
                if (isset($data->NwItemLocale)) {
                    $result['result'] = current($data->NwItemLocale);
                    $this->toJSON($result, true);
                }
            }
        }
    }

    public function addNews() {
        $player = User::getUser();
        $games = new Games();
        $companies = new Companies();

        if (!$player or $player->canAccess('Create news') === FALSE) {
            DooUriRouter::redirect(MainHelper::site_url('admin'));
            return FALSE;
        }

        $list = array();
        if (isset($_POST) and !empty($_POST)) {
            $news = new News();
            $result = $news->saveNews($_POST);
            if ($result instanceof NwItems) {
                $translated = current($result->NwItemLocale);
                $LID = $translated->ID_LANGUAGE;
                if ($result->OwnerType == 'game') {
                    $game = $games->getGameByID($result->ID_OWNER);
                    DooUriRouter::redirect($game->GAME_URL . '/admin/edit-news/' . $result->ID_NEWS . '/' . $LID);
                    return FALSE;
                } elseif ($result->OwnerType == 'company') {
                    $company = $companies->getCompanyByID($result->ID_OWNER);
                    DooUriRouter::redirect($company->COMPANY_URL . '/admin/edit-news/' . $result->ID_NEWS . '/' . $LID);
                    return FALSE;
                }
            } else {
                $list['post'] = $_POST;
            }
        }

        $news = new News();
        $companyOwners = $companies->getAllCompanies(10000, 1, "ASC"); // List of Companies / Games
        $gameOwners = $games->getAllGames(10000, 1, "ASC"); // Alternate List of Companies / Games
        $companyKeys = array(array('TypeID', 'ID_COMPANYTYPE'),
            array('OwnerID', 'ID_COMPANY'),
            array('Name', 'CompanyName'));
        $gameKeys = array(array('TypeID', 'ID_GAMETYPE'),
            array('OwnerID', 'ID_GAME'),
            array('Name', 'GameName'));
        $companytypeKeys = array(array('TypeID', 'ID_COMPANYTYPE'),
            array('Name', 'CompanyTypeName'));
        $gametypeKeys = array(array('TypeID', 'ID_GAMETYPE'),
            array('Name', 'GameTypeName'));
        $companytypes = $companies->getTypes(); // Company Types / Game Types
        $gametypes = $games->getTypes(); // Alternate Company Types / Game Types
        $list['companyOwnerArray'] = $news->populateArrayNewsAdmin($companyOwners, $companyKeys);
        $list['gameOwnerArray'] = $news->populateArrayNewsAdmin($gameOwners, $gameKeys);
        $list['companytypes'] = $news->populateArrayNewsAdmin($companytypes, $companytypeKeys);
        $list['gametypes'] = $news->populateArrayNewsAdmin($gametypes, $gametypeKeys);
        $list['function'] = 'add';
        $list['adminPanel'] = 1;
        $list['ownerType'] = 'game';
        $list['platforms'] = $games->getGamePlatforms();
        $list['language'] = 1;
        $list['languages'] = Lang::getLanguages();
        $list['prefixes'] = Prefix::getPrefixes();
        $list['CategoryType'] = false;
        $list['infoBox'] = MainHelper::loadInfoBox('Games', 'index', true);

        $data['title'] = $this->__('Add News');
        $data['body_class'] = 'add_news';
        $data['selected_menu'] = 'news';
        $data['left'] = $this->renderBlock('news/common/leftColumn');
        $data['right'] = 'right';
        $data['content'] = $this->renderBlock('news/addEditNews', $list);
        $data['footer'] = MainHelper::bottomMenu();
        $data['header'] = $this->getMenu();
        $this->render3Cols($data);
    }
    
     public function playerNews(){
		$player=User::getUser();
		if($player->canAccess('Approve news') === FALSE)
			DooUriRouter::redirect(MainHelper::site_url('admin'));
		$list=array();$news = new News();
		$params=$this->params;	$filter=$params['filter'];
		
		$newstotal=$news->getPlayerNewsTotal($player->ID_PLAYER,$filter);
		$url='admin/news/player-news/'.$params['filter'].'/page';$adminlimit=Doo::conf()->adminNewsLimit;
		$pager=$this->appendPagination($list,$news,$newstotal,MainHelper::site_url($url),$adminlimit);
		
		$list['newsList'] = $news->getPlayerNews($player->ID_PLAYER,$filter,$pager->limit);
		$list['filter'] = $filter;$list['page']=$params['page'];
		$data['title'] = $this->__('Player News');
		$data['body_class'] = 'index_news';
		$data['selected_menu'] = 'news';
		$data['left'] = $this->renderBlock('news/common/leftColumn');
		$data['right'] = 'right';
		$data['content'] = $this->renderBlock('news/playernews',$list);
		$data['footer'] = MainHelper::bottomMenu();
		$data['header'] = $this->getMenu();
		$this->render3Cols($data);
	}
	
	public function playerNewsNotes(){
		$player=User::getUser();
		if($player->canAccess('Approve news') === FALSE)
			DooUriRouter::redirect(MainHelper::site_url('admin'));
		$params=$this->params;
		$newsid=$params['news_id'];$languageid=$params['language_id'];
		
		$news=new News();
		$list['newsList'] = $news->getPlayerNewsNotes($newsid,$languageid);
		$data['title']=$this->__('Player News Notes');
		$data['body_class']= 'index_news';
		$data['selected_menu'] = 'news';
		$data['left']= $this->renderBlock('news/common/leftColumn');
		$data['right']='right';
		$data['content']=$this->renderBlock('news/playernewsnotes',$list);
		$data['footer']=MainHelper::bottomMenu();
		$data['header']=$this->getMenu();
		$this->render3Cols($data);	
	}


    public function editNewsPrefixes() {

        $list = array();


        $prefix = Prefix::getPrefixesAll();
        $list['prefixes'] = $prefix;

        $data['title'] = $this->__('Edit Prefixes');
        $data['body_class'] = 'add_news';
        $data['selected_menu'] = 'news';
        $data['left'] = $this->renderBlock('news/common/leftColumn');
        $data['right'] = 'right';
        $data['content'] = $this->renderBlock('news/editPrefixes', $list);
        $data['footer'] = MainHelper::bottomMenu();
        $data['header'] = $this->getMenu();
        $this->render3Cols($data);
    }

    public function editNewsPrefix() {
        $list = array();

        $input = filter_input_array(INPUT_GET);
        if (empty($input)) { /* nothing */
        };

        // isset
        $prefixId = isset($input["prefixId"]) ? $input["prefixId"] : "";
        $prefixName = isset($input["prefixName"]) ? $input["prefixName"] : "";
        $prefixColor = isset($input["prefixColor"]) ? $input["prefixColor"] : "";
        $option = isset($input["submit"]) ? $input["submit"] : "";

        Doo::loadModel('NwPrefixes');

        $prefix = new NwPrefixes;
        $prefix->ID_PREFIX = $prefixId;

        $options['limit'] = 1;

        $prefix = Doo::db()->find($prefix, $options);

        $prefix->PrefixName = $prefixName;

        $prefix->PrefixColor = $prefixColor;

        if ($option == $this->__('Delete')) {
            Doo::db()->delete($prefix);
        } else if ($option == $this->__('Save')) {
            Doo::db()->update($prefix);
        }




        $url = MainHelper::site_url('admin/news/edit-prefixes');
        header('Location: ' . $url);
    }

    public function addNewsPrefixes() {
        $list = array();

        $input = filter_input_array(INPUT_GET);
        if (empty($input)) { /* nothing */
        };

        $prefixId = isset($input["prefixId"]) ? $input["prefixId"] : "";
        $prefixName = isset($input["prefixName"]) ? $input["prefixName"] : "";
        $prefixColor = isset($input["prefixColor"]) ? $input["prefixColor"] : "";

        Doo::loadModel('NwPrefixes');

        $prefix = new NwPrefixes;
        //$prefix->ID_PREFIX = $prefixId;

        $prefix->PrefixName = $prefixName;
        $prefix->PrefixColor = $prefixColor;


        Doo::db()->insert($prefix);

        $url = MainHelper::site_url('admin/news/edit-prefixes');
        header('Location: ' . $url);
    }
    
    public function filemanager() {
		$_SESSION['fmFileRoot'] = Doo::conf()->SITE_PATH.'global/pub_img/'.FOLDER_CUSTOMVIEW.'/';
		$url = MainHelper::site_url('global/js/ckeditor4.3.3/Filemanager/index.html');
		DooUriRouter::redirect($url);
    }

}
