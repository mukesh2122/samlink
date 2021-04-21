<?php

class NewsController extends SnController {

    public function beforeRun($resource, $action) {
        if ($rs = parent::beforeRun($resource, $action)) {
            return $rs;
        }
        $this->addCrumb($this->__('News'), MainHelper::site_url('news'));
    }

    public function moduleOff() {
        $notAvailable = MainHelper::TrySetModuleNotAvailableByTag('news');
        if ($notAvailable) {
            $data['title'] = $this->__('News');
            $data['body_class'] = 'index_news';
            $data['selected_menu'] = 'news';
            $data['right'] = PlayerHelper::playerRightSide();
            $data['content'] = $notAvailable;
            $data['footer'] = MainHelper::bottomMenu();
            $data['header'] = MainHelper::topMenu();
            $this->render2ColsRight($data);
            exit;
        }
    }

    /**
     * Main website
     *
     */
    public function index() {
        $this->moduleOff();

        $news = new News();

        $newsPerPage = Doo::conf()->get('newsLimit');
        $params = $this->params;
        $order = isset($params['order']) ? $params['order'] : 'desc';
        if($order != 'asc' && $order != 'desc') {
            $order = 'desc';
        };
        $tabParam = isset($params['tab']) ? $params['tab'] : 'by-date-added';
        switch($tabParam) {
            case 'by-popularity':
                $tab = 1;
                break;
            case 'by-rating':
                $tab = 2;
                break;
            case 'by-date-added':
                $tab = 3;
                break;
            default:
                $tab = 3;
        };

        $frontpage = new NwFrontpage();
        $moduleState = $frontpage->getModuleStates();

        $list = array();
        $list['NewsCategoriesType'] = FALSE;
        $list['order'] = $order;
        $list['tab'] = $tab;
        $newsTotal = $news->getNewsTotal();
        $pager = $this->appendPagination($list, $news, $newsTotal, MainHelper::site_url('news/page'), $newsPerPage);
        $list['recentNews'] = $news->getLatestNews($pager->limit, $tab, $order);
        $list['showEvents'] = $moduleState['Upcoming Events']['News'];
        $list['url'] = MainHelper::site_url('news/search');
        $list['label'] = $this->__('Search for news...');
        $xlist['mostReadList'] = $news->getMostReadNews();

        $data['title'] = $this->__('News');
        $data['body_class'] = 'index_news';
        $data['selected_menu'] = 'news';
        $data['right'] = PlayerHelper::playerRightSide($list);
        $data['content'] = $this->renderBlock('news/header');
        if ($moduleState['Slider']['News']) {
            $data['content'] .= $this->renderBlock('news/slider');
        };
        if ($moduleState['Highlights']['News']) {
            $data['content'] .= $this->renderBlock('news/highlights');
        };
        $data['content'] .= '<div id="news_border"> </div>';
        $data['content'] .= $this->renderBlock('news/mostRead', $xlist);
        $data['content'] .= $this->renderBlock('news/index', $list);
        $data['footer'] = MainHelper::bottomMenu();
        $data['header'] = MainHelper::topMenu();
        $this->render2ColsRight($data);
    }

    public function recentNews() {
        $this->moduleOff();

        $news = new News();
        $list = array();
        $list['NewsCategoriesType'] = NEWS_RECENT;
        $list['infoBox'] = MainHelper::loadInfoBox('News', 'index', true);
        $newsTotal = $news->getNewsTotal();
        $pager = $this->appendPagination($list, $news, $newsTotal, MainHelper::site_url('news/recent/page'));
        $list['recentNews'] = $news->getLatestNews($pager->limit);
        $data['content'] = $this->renderBlock('news/recentNews', $list);
        $data['title'] = $this->__('Recent News');
        $data['body_class'] = 'recent_news';
        $data['selected_menu'] = 'news';
        $data['left'] = PlayerHelper::playerLeftSide();
        $data['right'] = PlayerHelper::playerRightSide();
        $data['footer'] = MainHelper::bottomMenu();
        $data['header'] = MainHelper::topMenu();
        $this->render3Cols($data);
    }

    public function popularNews() {
        $this->moduleOff();

        $news = new News();
        $list = array();
        $list['NewsCategoriesType'] = NEWS_POPULAR;
        $list['infoBox'] = MainHelper::loadInfoBox('News', 'index', true);
        $list['topNews'] = $news->getPopularNews(0, true);
        $newsTotal = $news->getPopularNewsTotal();
        $pager = $this->appendPagination($list, $news, $newsTotal, MainHelper::site_url('news/popular/page'));
        $list['popularNews'] = $news->getPopularNews($pager->limit);
        $data['content'] = $this->renderBlock('news/popularNews', $list);
        $data['title'] = $this->__('Popular News');
        $data['body_class'] = 'popular_news';
        $data['selected_menu'] = 'news';
        $data['left'] = PlayerHelper::playerLeftSide();
        $data['right'] = PlayerHelper::playerRightSide();
        $data['footer'] = MainHelper::bottomMenu();
        $data['header'] = MainHelper::topMenu();
        $this->render3Cols($data);
    }

    /**
     * Shows all games by specified platform
     *
     */
    public function platformNews() {
        $this->moduleOff();
        $news = new News();
        $list = array();
        $list['showClosed'] = FALSE;
        $list['NewsCategoriesType'] = NEWS_PLATFORM;
        $list['infoBox'] = MainHelper::loadInfoBox('News', 'index', true);
        $newsTotal = $news->getNewsTotal();
        $pager = $this->appendPagination($list, $news, $newsTotal, MainHelper::site_url('news/platforms/page'));
        $list['recentNews'] = $news->getLatestNews($pager->limit);
        $list['platforms'] = $news->getCategoriesByType(NEWS_PLATFORM);

        $data['title'] = $this->__('Platform News');
        $data['body_class'] = 'platform_news';
        $data['selected_menu'] = 'news';
        $data['left'] = PlayerHelper::playerLeftSide();
        $data['right'] = PlayerHelper::playerRightSide();
        $data['content'] = $this->renderBlock('news/platformNews', $list);
        $data['footer'] = MainHelper::bottomMenu();
        $data['header'] = MainHelper::topMenu();
        $this->render3Cols($data);
    }

    public function reviews() {
        $this->moduleOff();

        $news = new News();
        $list = array();
        //$list['NewsCategoriesType'] = false;
        $settings = new SySettings;
        $result = $settings->getone(array(
            'select' => 'ValueInt'
            , 'where' => 'ID_SETTING = "NwNewsLimit"'
        ));
        if ($result) {
            $newsPerPage = $result->ValueInt;
        } else {
            $newsPerPage = -1;
        }

        $frontpage = new NwFrontpage;
        $moduleState = $frontpage->getModuleStates();

        $reviewsTotal = $news->getReviewsTotal();
        $pager = $this->appendPagination($list, $news, $reviewsTotal, MainHelper::site_url('reviews/page'), $newsPerPage);
        $list['recentReviews'] = $news->getLatestReviews($pager->limit);
        $list['showEvents'] = $moduleState['Upcoming Events']['News'];

        $data['title'] = $this->__('Reviews');
        $data['body_class'] = 'index_reviews';
        $data['selected_menu'] = 'reviews';
        $data['right'] = PlayerHelper::playerRightSide($list);

        $data['content'] = $this->renderBlock('news/header');

        $data['content'] .= $this->renderBlock('reviews/mostRead');
        $data['content'] .= $this->renderBlock('reviews/reviews', $list);

        $data['footer'] = MainHelper::bottomMenu();
        $data['header'] = MainHelper::topMenu();
        $this->render2ColsRight($data);
    }

    public function unpublishReview() {
        if ($this->isAjax() && !empty($this->params['news_id']) && !empty($this->params['lang_id'])) {
            $item = News::getArticleByID($this->params['news_id']);
            $note = $_POST['text'];
            if ($item) {
                $p = User::getUser();
                $games = new SnGames();
                $isEditor = $games->isEditor();
                if ($p && ($item->isReview == 1) && ($isEditor || $p->ID_PLAYER == $item->ID_AUTHOR)) {
                    $news = new News();
                    $result['result'] = $news->unpublishReview($this->params['news_id'], $this->params['lang_id'], $note);
                    $this->toJSON($result, true);
                };
            };
        };
    }

    public function specificPlatformNews() {
        $this->moduleOff();

        $platform = $this->getPlatform();
        if (!$platform) {
            DooUriRouter::redirect(Doo::conf()->APP_URL);
            return FALSE;
        };
        $news = new News();
        $list = array();
        $list['showClosed'] = (isset($this->params['close'])) ? TRUE : FALSE;
        $list['NewsCategoriesType'] = NEWS_PLATFORM;
        $list['infoBox'] = MainHelper::loadInfoBox('News', 'index', true);

        $newsTotal = $news->getPlatformNewsTotal($platform->ID_PLATFORM);
        $pager = $this->appendPagination($list, $news, $newsTotal, $platform->NEWS_URL . '/page');
        $list['recentNews'] = $news->getPlatformNews($platform->ID_PLATFORM, $pager->limit);
        $list['platforms'] = $news->getCategoriesByType(NEWS_PLATFORM);
        $list['activePlatform'] = $platform;

        $data['title'] = $this->__('Platform News');
        $data['body_class'] = 'platform_news';
        $data['selected_menu'] = 'news';
        $data['left'] = PlayerHelper::playerLeftSide();
        $data['right'] = PlayerHelper::playerRightSide();
        $data['content'] = $this->renderBlock('news/platformNews', $list);
        $data['footer'] = MainHelper::bottomMenu();
        $data['header'] = MainHelper::topMenu();
        $this->render3Cols($data);
    }

    /**
     * Shows all companies
     *
     */
    public function allCompanies() {
        $this->moduleOff();

        $news = new News();
        $companies = new Companies();
        $list = array();
        $list['NewsCategoriesType'] = NEWS_COMPANIES;
        $list['infoBox'] = MainHelper::loadInfoBox('News', 'index', true);

        $companiesTotal = $companies->getTotal();
        $pager = $this->appendPagination($list, $news, $companiesTotal, MainHelper::site_url('news/companies/page'));
        $list['companiesTop'] = $news->getAllCompanies(5, true);
        $list['companies'] = $news->getAllCompanies($pager->limit);

        $data['title'] = $this->__('Companies');
        $data['body_class'] = 'companies_news';
        $data['selected_menu'] = 'news';
        $data['left'] = PlayerHelper::playerLeftSide();
        $data['right'] = PlayerHelper::playerRightSide();
        $data['content'] = $this->renderBlock('news/allCompanies', $list);
        $data['footer'] = MainHelper::bottomMenu();
        $data['header'] = MainHelper::topMenu();
        $this->render3Cols($data);
    }

    public function searchCompanies() {
        $this->moduleOff();

        if (!isset($this->params['searchText'])) {
            DooUriRouter::redirect(Doo::conf()->APP_URL);
            return FALSE;
        }

        $news = new News();
        $list = array();
        $search = new Search();
        $list['NewsCategoriesType'] = NEWS_COMPANIES;
        $list['infoBox'] = MainHelper::loadInfoBox('News', 'index', true);

        $companiesTotal = $search->getSearchTotal(urldecode($this->params['searchText']), SEARCH_COMPANY);

        $pager = $this->appendPagination($list, $news, $companiesTotal, MainHelper::site_url('news/companies/search/' . urlencode($this->params['searchText']) . '/page'));
        $list['companiesTop'] = $news->getAllCompanies(5, true);
        $list['companies'] = $search->getSearch(urldecode($this->params['searchText']), SEARCH_COMPANY, $pager->limit);
        $list['searchText'] = $this->params['searchText'];
        $list['searchTotal'] = $companiesTotal;

        $data['title'] = $this->__('Companies Search Results');
        $data['body_class'] = 'companies_search_results';
        $data['selected_menu'] = 'news';
        $data['left'] = PlayerHelper::playerLeftSide();
        $data['right'] = PlayerHelper::playerRightSide();
        $data['content'] = $this->renderBlock('news/allCompanies', $list);
        $data['footer'] = MainHelper::bottomMenu();
        $data['header'] = MainHelper::topMenu();
        $this->render3Cols($data);
    }

    /**
     * Shows news from specified company
     *
     * @param int $id
     * @return unknown
     */
    public function companyNews() {
        $this->moduleOff();

        if (!isset($this->params['company'])) {
            DooUriRouter::redirect(Doo::conf()->APP_URL);
            return FALSE;
        }
        $key = $this->params['company'];
        $list = array();
        $news = new News();
        $url = Url::getUrlByName($key, URL_COMPANY);
        if (!$url) {
            DooUriRouter::redirect(Doo::conf()->APP_URL);
            return FALSE;
        }
        $company = Companies::getCompanyByID($url->ID_OWNER);
        if (!$company) {
            DooUriRouter::redirect(Doo::conf()->APP_URL);
            return FALSE;
        }

        $settings = new SySettings;
        $result = $settings->getone(array(
            'select' => 'ValueInt'
            , 'where' => 'ID_SETTING = "NwNewsLimit"'
        ));
        $newsPerPage = ($result) ? $result->ValueInt : Doo::conf()->newsLimit;

        $list['NewsCategoriesType'] = NEWS_COMPANIES;
        $list['infoBox'] = MainHelper::loadInfoBox('News', 'index', true);
        $list['company'] = $company;

        $newsTotal = $news->getTotalByType($company->ID_COMPANY, COMPANY);
        $pager = $this->appendPagination($list, $news, $newsTotal, $company->NEWS_URL . '/page', $newsPerPage);
        $list['companyNews'] = $news->getNewsByType($company->ID_COMPANY, COMPANY, $pager->limit);

        $data['title'] = $this->__('Company News');
        $data['body_class'] = 'company_news';
        $data['selected_menu'] = 'news';
        $data['left'] = PlayerHelper::playerLeftSide();
        $data['right'] = PlayerHelper::playerRightSide();
        $data['content'] = $this->renderBlock('news/companyNews', $list);
        $data['footer'] = MainHelper::bottomMenu();
        $data['header'] = MainHelper::topMenu();
        $this->render3Cols($data);
    }

    /**
     * Shows all games
     *
     */
    public function allGames() {
        $this->moduleOff();

        $news = new News();
        $games = new Games();
        $list = array();
        $list['NewsCategoriesType'] = NEWS_GAMES;
        $list['infoBox'] = MainHelper::loadInfoBox('News', 'index', true);

        $gamesTotal = $games->getTotal();
        $pager = $this->appendPagination($list, $news, $gamesTotal, MainHelper::site_url('news/games/page'));
        $list['gamesTop'] = $news->getAllGames(5, true);
        $list['games'] = $news->getAllGames($pager->limit);

        $data['title'] = $this->__('Games');
        $data['body_class'] = 'games_news';
        $data['selected_menu'] = 'news';
        $data['left'] = PlayerHelper::playerLeftSide();
        $data['right'] = PlayerHelper::playerRightSide();
        $data['content'] = $this->renderBlock('news/allGames', $list);
        $data['footer'] = MainHelper::bottomMenu();
        $data['header'] = MainHelper::topMenu();
        $this->render3Cols($data);
    }

    public function searchGames() {
        $this->moduleOff();

        if (!isset($this->params['searchText'])) {
            DooUriRouter::redirect(Doo::conf()->APP_URL);
            return FALSE;
        }

        $news = new News();
        $list = array();
        $search = new Search();
        $list['NewsCategoriesType'] = NEWS_GAMES;
        $list['infoBox'] = MainHelper::loadInfoBox('News', 'index', true);

        $gamesTotal = $search->getSearchTotal(urldecode($this->params['searchText']), SEARCH_GAME);

        $pager = $this->appendPagination($list, $news, $gamesTotal, MainHelper::site_url('news/games/search/' . urlencode($this->params['searchText']) . '/page'));
        $list['gamesTop'] = $news->getAllGames(5, true);
        $list['games'] = $search->getSearch(urldecode($this->params['searchText']), SEARCH_GAME, $pager->limit);
        $list['searchText'] = $this->params['searchText'];
        $list['searchTotal'] = $gamesTotal;

        $data['title'] = $this->__('Games Search Results');
        $data['body_class'] = 'games_search_results';
        $data['selected_menu'] = 'news';
        $data['left'] = PlayerHelper::playerLeftSide();
        $data['right'] = PlayerHelper::playerRightSide();
        $data['content'] = $this->renderBlock('news/allGames', $list);
        $data['footer'] = MainHelper::bottomMenu();
        $data['header'] = MainHelper::topMenu();
        $this->render3Cols($data);
    }

    /**
     * Shows news from specified game
     *
     * @param int $id
     * @return unknown
     */
    public function gameNews() {
        $this->moduleOff();

        $game = $this->getGame();
        if (!$game) {
            DooUriRouter::redirect(Doo::conf()->APP_URL);
            return FALSE;
        }
        $list = array();
        $news = new News();
        $settings = new SySettings;
        $result = $settings->getone(array(
            'select' => 'ValueInt'
            , 'where' => 'ID_SETTING = "NwNewsLimit"'
        ));
        $newsPerPage = ($result) ? $result->ValueInt : Doo::conf()->newsLimit;
        $list['NewsCategoriesType'] = NEWS_GAMES;
        $list['infoBox'] = MainHelper::loadInfoBox('News', 'index', true);
        $list['game'] = $game;

        $newsTotal = $news->getTotalByType($game->ID_GAME, GAME);
        $pager = $this->appendPagination($list, $news, $newsTotal, $game->NEWS_URL . '/page', $newsPerPage);
        $list['gameNews'] = $news->getNewsByType($game->ID_GAME, GAME, $pager->limit);

        $data['title'] = $this->__('Game News');
        $data['body_class'] = 'game_news';
        $data['selected_menu'] = 'news';
        $data['left'] = PlayerHelper::playerLeftSide();
        $data['right'] = PlayerHelper::playerRightSide();
        $data['content'] = $this->renderBlock('news/gameNews', $list);
        $data['footer'] = MainHelper::bottomMenu();
        $data['header'] = MainHelper::topMenu();
        $this->render3Cols($data);
    }

    /**
     * Shows news article
     *
     * @param int $id
     * @return unknown
     */
    public function articleView() {
        $this->moduleOff();

        if (!isset($this->params['article'])) {
            DooUriRouter::redirect(Doo::conf()->APP_URL);
            return FALSE;
        }
        $key = $this->params['article'];
        $lang = isset($this->params['lang']) ? array_search($this->params['lang'], Doo::conf()->lang) : 1;
//        $lang = array_search($this->params['lang'], Doo::conf()->lang);
        $news = new News();
        $list = array();
        $url = Url::getUrlByName($key, URL_NEWS, $lang);
        if (!$url) {
            DooUriRouter::redirect(Doo::conf()->APP_URL);
            return FALSE;
        }

        $item = $news->getArticleByID($url->ID_OWNER, $lang);
        Url::updateVisitCount($url);

        if (!$item) {
            DooUriRouter::redirect(Doo::conf()->APP_URL);
            return FALSE;
        }
        $list['NewsCategoriesType'] = false;
        $list['infoBox'] = MainHelper::loadInfoBox('News', 'index', true);

        $list['item'] = $item;
        $list['lang'] = $lang;
        $rlist = $news->getRepliesList($item->ID_NEWS, $lang, Doo::conf()->defaultShowRepliesLimit);
        $replies = '';
        if (!empty($rlist)) {
            $num = 0;
            foreach ($rlist as $nwitem) {
                $val = array('poster' => $nwitem->Players, 'item' => $nwitem, 'num' => $num);
                $replies .= $this->renderBlock('news/comment', $val);
                $num++;
            }
        }
        $list['replies'] = $replies;
        $list['newsID'] = $item->ID_NEWS;
        $list['relatedLimit'] = 3;

        $data['title'] = $item->Headline;
        $data['body_class'] = 'item_news';
        $data['selected_menu'] = 'news';
        $data['left'] = PlayerHelper::playerLeftSide();
        $data['right'] = PlayerHelper::playerRightSide();
        $data['content'] = $this->renderBlock('news/articleView', $list);
        $data['footer'] = MainHelper::bottomMenu();
        $data['header'] = MainHelper::topMenu();
        $this->render3Cols($data);
    }

    public function searchAdvIndex() {
        $this->moduleOff();
        $list = array();
        $list['NewsCategoriesType'] = false;

        $frontpage = new NwFrontpage;
        $moduleState = $frontpage->getModuleStates();

        $news = new News();
        $list['authors'] = $news->getAuthors();


        $list['url'] = MainHelper::site_url('news/searchAdv');

        $data['title'] = $this->__('News');
        $data['body_class'] = 'index_news';
        $data['selected_menu'] = 'news';
        $data['right'] = PlayerHelper::playerRightSide($list);

        $data['content'] = $this->renderBlock('news/header');

        if ($moduleState['Slider']['News']) {
            $data['content'] .= $this->renderBlock('news/slider');
        };
        if ($moduleState['Highlights']['News']) {
            $data['content'] .= $this->renderBlock('news/highlights');
        };

        $data['content'] .= '<div id="news_border"> </div>';
        $data['content'] .= $this->renderBlock('news/mostRead');
        //$data['content'] .= $this->renderBlock('news/search', $list);

        $data['content'] .= $this->renderBlock('news/searchAdv', $list);

        $data['footer'] = MainHelper::bottomMenu();
        $data['header'] = MainHelper::topMenu();
        $this->render2ColsRight($data);
    }

    public function searchAdv() {
        $this->moduleOff();
        $input = filter_input_array(INPUT_GET);
        if (empty($input)) { /* kajdhkhad */
        };

        $data['title'] = $this->__('Advanced search results');
        $data['body_class'] = 'index_search';
        $data['selected_menu'] = 'search';
        $data['left'] = PlayerHelper::playerLeftSide();
        $data['right'] = PlayerHelper::playerRightSide();

        $news = new News();
        $list = array();
        $this->appendCategories($list, $news, false);

        //crumb adding
        $this->addCrumb($this->__('Search results'));
        $list['crumb'] = $this->getCrumb();


        $headline = isset($input["searchAdv_headline"]) ? $input["searchAdv_headline"] : "";
        $desc = isset($input["searchAdv_description"]) ? $input["searchAdv_description"] : "";
        //$author = ('test' == $input["searchAdv_author"]) ? "" : $input["searchAdv_author"];

        $author = ('-' == $input["searchAdv_author"]) ? "" : $input["searchAdv_author"];
        $list['searchTotal'] = $list['resultCount'] = $totalResults = $news->getSearchAdvTotal($headline, $desc, $author);
        //$list['searchText'] = $tmpTxt = empty($headline) ? "" : "Headline : {$headline} " . empty($desc) ? "" : " Description : {$desc} " . ($author == '-') ? "" : " Author : {$author}";
        $list['searchText'] = $tmpTxt = empty($headline) ? "" : "Headline : {$headline} " . empty($desc) ? "" : " Description : {$desc} " . empty($author) ? "" : " Author : {$author}";
        $list['hideHeader'] = true;
        $headlineTmp = empty($headline) ? "" : "{$headline}";
        $descriptionTmp = empty($desc) ? "" : "{$desc}";
        $authorTmp = empty($author) ? "" : "{$author}";

        $tmpTxt = $headlineTmp . "/" . $descriptionTmp . "/" . $authorTmp; //test
        $list['test'] = $tmpTxt; //test

        $pager = $this->appendPagination($list, new stdClass(), $totalResults > 0 ? $totalResults : 1, MainHelper::site_url('news/searchAdv/' . $tmpTxt));


        $list['pager'] = $pager;
        $list['newsList'] = $news->getSearchAdv($headline, $desc, $author, $pager->limit);

        $data['content'] = $this->renderBlock('news/searchResults', $list);

        $data['footer'] = MainHelper::bottomMenu();
        $data['header'] = MainHelper::topMenu();
        $this->render3Cols($data);
    }

    /**
     * Shows game news for specific platform and game
     *
     */
    public function search() {
        $this->moduleOff();

        if (!isset($this->params['searchText'])) {
            DooUriRouter::redirect(Doo::conf()->APP_URL);
            return FALSE;
        }
        $news = new News();

        $data['title'] = $this->__('Search results');
        $data['body_class'] = 'index_news';
        $data['selected_menu'] = 'news';
        $data['left'] = PlayerHelper::playerLeftSide();
        $data['right'] = PlayerHelper::playerRightSide();

        $list = array();
        $this->appendCategories($list, $news, false);

        //crumb adding
        $this->addCrumb($this->__('Search results'));
        $list['crumb'] = $this->getCrumb();

        $totalResults = $news->getSearchTotal(urldecode($this->params['searchText']));
        $pager = $this->appendPagination($list, new stdClass(), $totalResults > 0 ? $totalResults : 1, MainHelper::site_url('news/search/' . urlencode($this->params['searchText'])));

        $list['hideHeader'] = true;
        $list['searchText'] = urldecode($this->params['searchText']);
        $list['resultCount'] = $totalResults;
        $list['searchTotal'] = $totalResults;
        $list['newsList'] = $news->getSearch(urldecode($this->params['searchText']), $pager->limit);

        $data['content'] = $this->renderBlock('news/searchResults', $list);

        $data['footer'] = MainHelper::bottomMenu();
        $data['header'] = MainHelper::topMenu();
        $this->render3Cols($data);
    }

    /**
     * Shows all countries
     *
     */
    public function allCountries() {
        $this->moduleOff();

        $letter = isset($this->params['letter']) ? $this->params['letter'] : 'a';
        $news = new News();
        $countries = $news->getAllCountries($letter);

        $data['title'] = $this->__('Countries');
        $data['selected_menu'] = 'news';
        $data['left'] = PlayerHelper::playerLeftSide();
        $data['right'] = PlayerHelper::playerRightSide();

        $list = array();
        $this->appendCategories($list, $news, false);

        $this->addCrumb($this->__('Countries'));
        $list['crumb'] = $this->getCrumb();

        $list['hideHeader'] = true;
        $list['activeLetter'] = strtoupper($letter);
        $list['countries'] = $countries;
        $data['content'] = $this->renderBlock('news/allCountries', $list);

        $data['footer'] = MainHelper::bottomMenu();
        $data['header'] = MainHelper::topMenu();
        $this->render3Cols($data);
    }

    public function deleteNews() {
        if (!empty($this->params['news_id'])) {
            $item = News::getArticleByID($this->params['news_id']);

            if ($item) {
                $p = User::getUser();
                if ($p and ($p->canAccess('Delete news') === TRUE or ($item->isReview == 1 and ($item->ID_AUTHOR == $p->ID_PLAYER or $p->canAccess('Delete review'))) or ($item->OwnerType == POSTRERTYPE_GROUP and Groups::getGroupByID($item->ID_OWNER)->isAdmin()))) {
                    $news = new News();
                    $result['result'] = $news->deleteNewsItem($this->params['news_id']);
                    $this->toJSON($result, true);
                }
            }
        }
    }

    /**
     * Like action of post or reply
     *
     * @return JSON
     */
    public function ajaxLikeToggle() {
        if ($this->isAjax()) {
            $news = new News();
            $totalLikes = $news->toggleLike($_POST['type'], $_POST['pid'], $_POST['replyNumber'], $_POST['like']);

            $result['totalLikes'] = 0;
            $result['totalDislikes'] = 0;
            $result['result'] = false;
            if (count($totalLikes) == 2) {
                $result['totalLikes'] = $totalLikes[0];
                $result['totalDislikes'] = $totalLikes[1];
                $result['result'] = true;
            }

            $this->toJSON($result, true);
        }
    }

    /**
     * Sets reply for specified post
     *
     * @return JSON
     */
    public function ajaxSetReply() {
        if ($this->isAjax()) {
            $p = User::getUser();
            if ($p) {
                $news = new News();
                $id = $news->setReply($p, $_POST['pid'], $_POST['langID'], $_POST['comment']);
                $item = $news->getReply($id, $_POST['langID']);
                $string = '';
                if ($item->ID_NEWS) {
                    $val = array('poster' => $p, 'item' => $item, 'num' => 0);
                    $string .= $this->renderBlock('news/comment', $val);
                }

                $result['total'] = $news->getTotalRepliesByPostID($_POST['pid'], $_POST['langID']);
                $result['content'] = $string;
                $this->toJSON($result, true);
            }
        }
    }

    /**
     * Prints replies list
     *
     * @return JSON
     */
    public function ajaxGetRepliesList() {
        if ($this->isAjax()) {
            $news = new News();
            $offset = isset($_POST['offset']) ? $_POST['offset'] : 0;
            $rlist = $news->getRepliesList($_POST['pid'], $_POST['langID'], $offset);

            $string = '';
            if (!empty($rlist)) {
                $num = 0;
                foreach ($rlist as $item) {
                    $val = array('poster' => $item->Players, 'item' => $item, 'num' => $num);
                    $string .= $this->renderBlock('news/comment', $val);
                    $num++;
                }
            }

            $result['total'] = $news->getTotalRepliesByPostID($_POST['pid'], $_POST['langID']);
            $result['content'] = $string;
            $this->toJSON($result, true);
        }
    }

    /**
     * Delete reply from post
     *
     * @return JSON
     */
    public function ajaxDeleteReply() {
        if ($this->isAjax()) {
            $newsreply = new NwReplies();
            $newsreply->ID_NEWS = $_POST['pid'];
            $newsreply->ReplyNumber = $_POST['rid'];
            $newsreply = $newsreply->getOne();
            if ($newsreply && $newsreply->deleteReply() == TRUE) {
                $news = new News();
                $result['total'] = $news->getTotalRepliesByPostID($_POST['pid'], $_POST['langID']);
                $result['result'] = TRUE;
                $this->toJSON($result, true);
            } else {
                $this->toJSON(array('result' => FALSE), true);
            }
        }
    }

    /**
     * Used to track game
     *
     * @return unknown
     */
    private function getGame() {
        if (!isset($this->params['game'])) {
            DooUriRouter::redirect(Doo::conf()->APP_URL);
            return FALSE;
        }

        $key = $this->params['game'];
        $game = new SnGames();
        $url = Url::getUrlByName($key, URL_GAME);

        if ($url) {
            $game->ID_GAME = $url->ID_OWNER;
        } else {
            DooUriRouter::redirect(Doo::conf()->APP_URL);
            return FALSE;
        }

        $game = $game->getOne();

        return $game;
    }

    /**
     * Used to track game
     *
     * @return unknown
     */
    private function getPlatform() {
        if (!isset($this->params['platform'])) {
            DooUriRouter::redirect(Doo::conf()->APP_URL);
            return FALSE;
        }
        $platform = new SnPlatforms();
        $url = Url::getUrlByName($this->params['platform'], URL_PLATFORM);

        if ($url) {
            $platform->ID_PLATFORM = $url->ID_OWNER;
        } else {
            DooUriRouter::redirect(Doo::conf()->APP_URL);
            return FALSE;
        }

        $platform = $platform->getOne();
        return $platform;
    }

    /**
     * Adds platforms/games/companies to news items
     *
     * @param unknown_type $list
     * @param unknown_type $news
     */
    private function appendCategories(&$list, &$news, $showExpanded = true) {
        if (Auth::isUserLogged()) {
            $types = array(NEWS_COMPANIES, NEWS_GAMES, NEWS_LOCAL, NEWS_PLATFORM);
            if (isset($this->params['type']) and in_array($this->params['type'], $types)) {
                $newsType = $this->params['type'];
                setcookie('news_category', $newsType, (time() + (3600 * 24 * 365)), '/');
            } else {
                if (isset($_COOKIE['news_category'])) {
                    if (in_array($_COOKIE['news_category'], $types)) {
                        $newsType = $_COOKIE['news_category'];
                    } else {
                        $newsType = NEWS_PLATFORM;
                    }
                } else {
                    $newsType = NEWS_PLATFORM;
                }
            }

            if ($showExpanded == false) {
                $list['showNewsCategories'] = false;
                $list['NewsCategoriesType'] = false;
            } else {
                $list['newsCategories'] = $news->getCategoriesByType($newsType);
                $list['showNewsCategories'] = true;
                $list['NewsCategoriesType'] = $newsType;
            }
        }
    }

    /**
     * Upload image
     *
     * @return JSON
     */
    public function ajaxUploadPhoto() {
        $c = new News();
        if (!isset($this->params['news_id']))
            return false;

        $upload = $c->uploadPhoto(intval($this->params['news_id']));

        if ($upload['filename'] != '') {
            $file = MainHelper::showImage($upload['c'], THUMB_LIST_200x300, true, array('width', 'no_img' => 'noimage/no_game_200x300.png'));
            echo $this->toJSON(array('success' => TRUE, 'img' => $file));
        } else {
            echo $this->toJSON(array('error' => $upload['error']));
        }
    }

    /**
     * Update platforms by gameID
     *
     * @return JSON
     */
    public function ajaxUpdatePlatforms() {
        $games = new Games();
        if (!isset($this->params['game_id']))
            return false;

        $platforms = $games->getAssignedPlatformsByGameId($this->params['game_id']);

        if (!isset($platforms['error'])) {
            echo $this->toJSON(array('success' => TRUE, 'platforms' => $platforms));
        } else {
            echo $this->toJSON(array('error' => $platforms['error']));
        }
    }

    public function searchPrefix() { //test
        $this->moduleOff();
        if (!isset($this->params['searchText'])) {
            DooUriRouter::redirect(Doo::conf()->APP_URL);
            return FALSE;
        }

        $data['title'] = $this->__('Advanced search results');
        $data['body_class'] = 'index_search';
        $data['selected_menu'] = 'search';
        $data['left'] = PlayerHelper::playerLeftSide();
        $data['right'] = PlayerHelper::playerRightSide();

        $news = new News();
        $list = array();
        $list['ID_PREFIX'] = $searchText = $this->params['searchText'];

        $list['newsList'] = $news->getNewsByPrefix($searchText);
        
        




        $list['hideHeader'] = true;


        $data['content'] = $this->renderBlock('news/searchPrefix', $list);

        $data['footer'] = MainHelper::bottomMenu();
        $data['header'] = MainHelper::topMenu();
        $this->render3Cols($data);
    }

}

?>
