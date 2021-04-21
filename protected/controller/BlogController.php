<?php

class BlogController extends SnController {

    public function beforeRun($resource, $action) {
        parent::beforeRun($resource, $action);
        $this->addCrumb($this->__('Blog'), MainHelper::site_url('blog'));
    }

    /**
     * Main websitei
     *
     */
    public function index() {
        $blog = new Blog();
        $list = array();
                //Redirect if blogs not enabled
		if (MainHelper::IsModuleEnabledByTag('blogs') == 0)
			DooUriRouter::redirect(MainHelper::site_url());
		$list['BlogCategoriesType'] = false;
                $settings = new SySettings;
		$result = $settings->getone(array(
			'select' => 'ValueInt'
		,	'where'  => 'ID_SETTING = "NwNewsLimit"'
		));
		if ($result) {
			$newsPerPage = $result->ValueInt;
		}
		else {
			$newsPerPage = -1;
		}
		$list['infoBox'] = MainHelper::loadInfoBox('Blog', 'index', true);
		$list['featuredBlog'] = $blog->getRandomBlog(60);
		$blogTotal = $blog->getBlogTotal();
		$pager = $this->appendPagination($list, $blog, $blogTotal, MainHelper::site_url('blog/page'), $newsPerPage);
		$list['recentBlog'] = $blog->getLatestBlog($pager->limit);
        $list['mostReadList'] = $blog->getMostReadBlog();

        $data['title'] = $this->__('Blog');
		$data['body_class'] = 'index_blog';
		$data['selected_menu'] = 'blog';
		
		$data['content'] = $this->renderBlock('blog/index', $list);
		$data['right'] = PlayerHelper::playerRightSide();
		$data['footer'] = MainHelper::bottomMenu();
		$data['header'] = MainHelper::topMenu();
                $this->render2ColsRight($data);
    }

	public function recentBlog() {
        $blog = new News();
        $list = array();
		$list['BlogCategoriesType'] = NEWS_RECENT;
		$list['infoBox'] = MainHelper::loadInfoBox('Blog', 'index', true);
		$blogTotal = $blog->getBlogTotal();
		$pager = $this->appendPagination($list, $blog, $blogTotal, MainHelper::site_url('blog/recent/page'));
		$list['recentBlog'] = $blog->getLatestBlog($pager->limit);
		$data['content'] = $this->renderBlock('blog/recentBlog', $list);
		$data['title'] = $this->__('Recent Posts');
		$data['body_class'] = 'recent_blog';
		$data['selected_menu'] = 'blog';
		$data['left'] = PlayerHelper::playerLeftSide();
		$data['right'] = PlayerHelper::playerRightSide();
		$data['footer'] = MainHelper::bottomMenu();
		$data['header'] = MainHelper::topMenu();
		$this->render3Cols($data);
    }
    
    public function AllBlogs() {
        $blog = new News();
        $list = array();
		$list['BlogCategoriesType'] = NEWS_ALL;
		$list['infoBox'] = MainHelper::loadInfoBox('Blog', 'index', true);
		$blogTotal = $blog->getBlogTotal();
		$pager = $this->appendPagination($list, $blog, $blogTotal, MainHelper::site_url('blog/recent/page'));
		$list['recentBlog'] = $blog->getLatestBlog($pager->limit);
		$data['content'] = $this->renderBlock('blog/recentBlog', $list);
		$data['title'] = $this->__('All Blogs');
		$data['body_class'] = 'all_blogs';
		$data['selected_menu'] = 'blog';
		$data['left'] = PlayerHelper::playerLeftSide();
		$data['right'] = PlayerHelper::playerRightSide();
		$data['footer'] = MainHelper::bottomMenu();
		$data['header'] = MainHelper::topMenu();
		$this->render3Cols($data);
    }

	public function popularBlog() {
        $blog = new News();
        $list = array();
		$list['BlogCategoriesType'] = NEWS_POPULAR;
		$list['infoBox'] = MainHelper::loadInfoBox('Blog', 'index', true);
		$list['topBlog'] = $blog->getPopularBlog(0, true);
		$blogTotal = $blog->getPopularBlogTotal();
		$pager = $this->appendPagination($list, $blog, $blogTotal, MainHelper::site_url('blog/popular/page'));
		$list['popularBlog'] = $blog->getPopularBlog($pager->limit);

		$data['content'] = $this->renderBlock('blog/popularBlog', $list);

		$data['title'] = $this->__('Popular Posts');
		$data['body_class'] = 'popular_news';
		$data['selected_menu'] = 'blog';
		$data['left'] = PlayerHelper::playerLeftSide();
		$data['right'] = PlayerHelper::playerRightSide();
		$data['footer'] = MainHelper::bottomMenu();
		$data['header'] = MainHelper::topMenu();
		$this->render3Cols($data);
    }
    
    public function addBlog() {
        $list = array();
        $input = filter_input_array(INPUT_POST);
		if(!empty($input)) {
            $input['prefix'] = 2;
			$news = new News();
			$result = $news->saveNews($input,0,1);
			if($result instanceof NwItems) {
				DooUriRouter::redirect(MainHelper::site_url('blog/editblog/'.$result->ID_NEWS));
				return FALSE;
			} else {
				$list['post'] = $input;
			}
		}
                
                $list['function'] = 'add';
		$data['title'] = $this->__('Add Blog');
		$data['body_class'] = 'add_blog';
		$data['selected_menu'] = 'blog';
		$data['left'] = PlayerHelper::playerLeftSide();
		$data['right'] = PlayerHelper::playerRightSide();
		$data['content'] = $this->renderBlock('blog/admin/addEditBlog', $list);
		$data['footer'] = MainHelper::bottomMenu();
		$data['header'] = MainHelper::topMenu();
		$this->render3Cols($data);
    }
    
    public function editBlog() {
        $list = array();
                $blog = new News();
		if(isset($_POST) and !empty($_POST)) {
                        $ownerID = $_POST['ownerID'];
			$result = $blog->updateNews($_POST,$ownerID,1);
			if($result instanceof NwItems) {
				DooUriRouter::redirect(MainHelper::site_url('players/wall/blog'));
				return FALSE;
			} else {
				$list['post'] = $_POST;
			}
		}
                $key = $this->params['news_id'];
		$url = Url::getUrlById($key, URL_NEWS);
		if (!$url) {
			DooUriRouter::redirect(Doo::conf()->APP_URL);
			return FALSE;
		}

		$item = $blog->getArticleByID($url->ID_OWNER,1);
                $list['item'] = $item;
                $list['function'] = 'edit';

		$data['title'] = $this->__('Edit Blog');
		$data['body_class'] = 'edit_blog';
		$data['selected_menu'] = 'blog';
		$data['left'] = PlayerHelper::playerLeftSide();
		$data['right'] = PlayerHelper::playerRightSide();
		$data['content'] = $this->renderBlock('blog/admin/addEditBlog', $list);
		$data['footer'] = MainHelper::bottomMenu();
		$data['header'] = MainHelper::topMenu();
		$this->render3Cols($data);
    }

	/**
     * Shows all games by specified platform
     *
     */
    public function platformNews() {
		$blog = new News();
        $list = array();
		$list['NewsCategoriesType'] = NEWS_PLATFORM;
		$list['infoBox'] = MainHelper::loadInfoBox('News', 'index', true);
		$blogTotal = $news->getNewsTotal();
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

    public function platformBlog() {
		$blog = new News();
        $list = array();
		$list['BlogCategoriesType'] = NEWS_PLATFORM;
		$list['infoBox'] = MainHelper::loadInfoBox('Blog', 'index', true);
		$blogTotal = $blog->getBlogTotal();
		$pager = $this->appendPagination($list, $blog, $blogTotal, MainHelper::site_url('blog/platforms/page'));
		$list['recentBlog'] = $blog->getLatestBlog($pager->limit);
        $list['platforms'] = $blog->getCategoriesByType(NEWS_PLATFORM);

        $data['title'] = $this->__('Platform Blog');
        $data['body_class'] = 'platform_news';
        $data['selected_menu'] = 'blog';
        $data['left'] = PlayerHelper::playerLeftSide();
        $data['right'] = PlayerHelper::playerRightSide();
        $data['content'] = $this->renderBlock('blog/platformBlog', $list);
        $data['footer'] = MainHelper::bottomMenu();
        $data['header'] = MainHelper::topMenu();
        $this->render3Cols($data);
    }

    public function specificPlatformNews() {
        $platform = $this->getPlatform();
        if (!$platform) {
            DooUriRouter::redirect(Doo::conf()->APP_URL);
            return FALSE;
        }
		$blog = new News();
        $list = array();
		$list['NewsCategoriesType'] = NEWS_PLATFORM;
		$list['infoBox'] = MainHelper::loadInfoBox('News', 'index', true);

		$blogTotal = $news->getPlatformNewsTotal($platform->ID_PLATFORM);
		$pager = $this->appendPagination($list, $news, $newsTotal, $platform->NEWS_URL.'/page');
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
		$blog = new News();
		$companies = new Companies();
        $list = array();
		$list['NewsCategoriesType'] = NEWS_COMPANIES;
		$list['infoBox'] = MainHelper::loadInfoBox('News', 'index', true);

		$companiesTotal = $companies->getTotal();
		$pager = $this->appendPagination($list, $blog, $companiesTotal, MainHelper::site_url('blog/companies/page'));
		$list['companiesTop'] = $blog->getAllCompanies(5, true);
		$list['companies'] = $blog->getAllCompanies($pager->limit);

        $data['title'] = $this->__('Companies');
        $data['body_class'] = 'companies_news';
        $data['selected_menu'] = 'blog';
        $data['left'] = PlayerHelper::playerLeftSide();
        $data['right'] = PlayerHelper::playerRightSide();
        $data['content'] = $this->renderBlock('blog/allCompanies', $list);
        $data['footer'] = MainHelper::bottomMenu();
        $data['header'] = MainHelper::topMenu();
        $this->render3Cols($data);
    }

	public function searchCompanies() {
		if (!isset($this->params['searchText'])) {
            DooUriRouter::redirect(Doo::conf()->APP_URL);
            return FALSE;
        }

		$blog = new News();
        $list = array();
		$search = new Search();
		$list['NewsCategoriesType'] = NEWS_COMPANIES;
		$list['infoBox'] = MainHelper::loadInfoBox('News', 'index', true);

		$companiesTotal = $search->getSearchTotal(urldecode($this->params['searchText']), SEARCH_COMPANY);

		$pager = $this->appendPagination($list, $news, $companiesTotal, MainHelper::site_url('news/companies/search/'.urlencode($this->params['searchText']).'/page'));
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
    public function companyBlog() {
        if (!isset($this->params['company'])) {
            DooUriRouter::redirect(Doo::conf()->APP_URL);
            return FALSE;
        }
        $key = $this->params['company'];
		$list = array();
		$blog = new News();
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

		$list['BlogCategoriesType'] = NEWS_COMPANIES;
		$list['infoBox'] = MainHelper::loadInfoBox('Blog', 'index', true);
		$list['company'] = $company;

		$blogTotal = $blog->getTotalByType($company->ID_COMPANY, COMPANY);
		$pager = $this->appendPagination($list, $blog, $blogTotal, $company->NEWS_URL.'/page');
		$list['companyBlog'] = $blog->getNewsByType($company->ID_COMPANY, COMPANY, $pager->limit);

        $data['title'] = $this->__('Company Blog');
        $data['body_class'] = 'company_news';
        $data['selected_menu'] = 'news';
        $data['left'] = PlayerHelper::playerLeftSide();
        $data['right'] = PlayerHelper::playerRightSide();
        $data['content'] = $this->renderBlock('blog/companyBlog', $list);
        $data['footer'] = MainHelper::bottomMenu();
        $data['header'] = MainHelper::topMenu();
        $this->render3Cols($data);
    }




    public function bloggersBlog() {
		$players = new User();
                $blog = new Blog();
		
        $list = array();
		$list['BlogCategoriesType'] = NEWS_GAMES;
		$list['infoBox'] = MainHelper::loadInfoBox('Bloggers', 'index', true);

		$playersTotal = $players->getTotalBloggers();

		$pager = $this->appendPagination($list, $players, $playersTotal, MainHelper::site_url('blog/bloggers/page'), Doo::conf()->bloggersLimit);


		$list['players'] = $blog->mergeBloggerBlogs($pager->limit);

        $data['title'] = $this->__('Bloggers');
        $data['body_class'] = 'bloggers';
        $data['selected_menu'] = 'blog';
        $data['left'] = PlayerHelper::playerLeftSide();
        $data['right'] = PlayerHelper::playerRightSide();
        $data['content'] = $this->renderBlock('blog/bloggersBlog', $list);
        $data['footer'] = MainHelper::bottomMenu();
        $data['header'] = MainHelper::topMenu();
        $this->render3Cols($data);
    }




	/**
     * Shows all games
     *
     */
    public function allGames() {
		$blog = new News();
		$games = new Games();
        $list = array();
		$list['BlogCategoriesType'] = NEWS_GAMES;
		$list['infoBox'] = MainHelper::loadInfoBox('Blog', 'index', true);

		$gamesTotal = $games->getTotal();
		$pager = $this->appendPagination($list, $blog, $gamesTotal, MainHelper::site_url('blog/games/page'));
		$list['gamesTop'] = $blog->getAllGames(5, true);
		$list['games'] = $blog->getAllGames($pager->limit);

        $data['title'] = $this->__('Games');
        $data['body_class'] = 'games_news';
        $data['selected_menu'] = 'blog';
        $data['left'] = PlayerHelper::playerLeftSide();
        $data['right'] = PlayerHelper::playerRightSide();
        $data['content'] = $this->renderBlock('blog/allGames', $list);
        $data['footer'] = MainHelper::bottomMenu();
        $data['header'] = MainHelper::topMenu();
        $this->render3Cols($data);
    }



public function searchGames() {
		if (!isset($this->params['searchText'])) {
            DooUriRouter::redirect(Doo::conf()->APP_URL);
            return FALSE;
        }

		$blog = new News();
        $list = array();
		$search = new Search();
		$list['NewsCategoriesType'] = NEWS_GAMES;
		$list['infoBox'] = MainHelper::loadInfoBox('News', 'index', true);

		$gamesTotal = $search->getSearchTotal(urldecode($this->params['searchText']), SEARCH_GAME);

		$pager = $this->appendPagination($list, $news, $gamesTotal, MainHelper::site_url('news/games/search/'.urlencode($this->params['searchText']).'/page'));
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
		$game = $this->getGame();
		if (!$game) {
            DooUriRouter::redirect(Doo::conf()->APP_URL);
            return FALSE;
        }
		$list = array();
		$blog = new News();
		$list['NewsCategoriesType'] = NEWS_GAMES;
		$list['infoBox'] = MainHelper::loadInfoBox('News', 'index', true);
		$list['game'] = $game;

		$blogTotal = $news->getTotalByType($game->ID_GAME, GAME);
		$pager = $this->appendPagination($list, $news, $newsTotal, $game->NEWS_URL.'/page');
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

    public function gameBlog() {
		$game = $this->getGame();
		if (!$game) {
            DooUriRouter::redirect(Doo::conf()->APP_URL);
            return FALSE;
        }
		$list = array();
		$blog = new News();
		$list['NewsCategoriesType'] = NEWS_GAMES;
		$list['infoBox'] = MainHelper::loadInfoBox('blog', 'index', true);
		$list['game'] = $game;

		$blogTotal = $blog->getTotalByType($game->ID_GAME, GAME);
		$pager = $this->appendPagination($list, $blog, $blogTotal, $game->NEWS_URL.'/page');
		$list['gameBlog'] = $blog->getNewsByType($game->ID_GAME, GAME, $pager->limit);

        $data['title'] = $this->__('Game Blogs');
        $data['body_class'] = 'game_news';
        $data['selected_menu'] = 'news';
        $data['left'] = PlayerHelper::playerLeftSide();
        $data['right'] = PlayerHelper::playerRightSide();
        $data['content'] = $this->renderBlock('blog/gameBlog', $list);
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
        if (!isset($this->params['article'])) {
            DooUriRouter::redirect(Doo::conf()->APP_URL);
            return FALSE;
        }
		$key = $this->params['article'];
		$lang = array_search($this->params['lang'], Doo::conf()->lang);
		$blog = new News();
		$list = array();
		$url = Url::getUrlByName($key, URL_NEWS, $lang);
		if (!$url) {
			DooUriRouter::redirect(Doo::conf()->APP_URL);
			return FALSE;
		}

		$item = $blog->getArticleByID($url->ID_OWNER, $lang);
                //Redirect if blogs not enabled
		if (MainHelper::IsModuleEnabledByTag('blogs') == 0 && $item->isBlog==1)
			DooUriRouter::redirect(MainHelper::site_url());
		Url::updateVisitCount($url);
        $f = User::getById($item->ID_OWNER);
                
        if (!$item) {
            DooUriRouter::redirect(Doo::conf()->APP_URL);
            return FALSE;
        }
		$list['NewsCategoriesType'] = false;
		$list['infoBox'] = MainHelper::loadInfoBox('News', 'index', true);

		$list['item'] = $item;
		$list['lang'] = $lang;
		$rlist = $blog->getRepliesList($item->ID_NEWS, $lang, Doo::conf()->defaultShowRepliesLimit);
        $replies = '';
        if (!empty($rlist)) {
            $num = 0;
            foreach ($rlist as $nwitem) {
                $val = array('poster' => $nwitem->Players, 'item' => $nwitem, 'num' => $num);
                $replies .= $this->renderBlock('blog/comment', $val);
                $num++;
            }
        }
        $list['replies'] = $replies;

        $data['title'] = $item->Headline;
        $data['body_class'] = 'item_news';
        $data['selected_menu'] = 'blog';
        $data['left'] = PlayerHelper::playerLeftSide('wall',$f->URL,'blog');
        $data['right'] = PlayerHelper::playerRightSide();
        $data['content'] = $this->renderBlock('blog/articleView', $list);
        $data['footer'] = MainHelper::bottomMenu();
        $data['header'] = MainHelper::topMenu();
        $this->render3Cols($data);
    }

    /**
     * Shows game news for specific platform and game
     *
     */
    public function search() {
        if (!isset($this->params['searchText'])) {
            DooUriRouter::redirect(Doo::conf()->APP_URL);
            return FALSE;
        }
        $blog = new News();

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
        $letter = isset($this->params['letter']) ? $this->params['letter'] : 'a';
        $blog = new News();
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
		if(!empty($this->params['news_id'])){
			$item = News::getArticleByID($this->params['news_id']);

			if($item){
				$p = User::getUser();
				if($p and ($p->canAccess('Delete news') === TRUE or ($item->isReview == 1 and ($item->ID_AUTHOR == $p->ID_PLAYER or $p->canAccess('Delete review'))) or ($item->OwnerType == POSTRERTYPE_GROUP and Groups::getGroupByID($item->ID_OWNER)->isAdmin()))) {
					$news = new News();
					$result['result'] = $news->deleteNewsItem($this->params['news_id']);
					$this->toJSON($result, true);
				}
			}
		}
    }

    /**
     * Toggles like dislike for news item
     *
     */
    public function ajaxLikeToggle() {
        if ($this->isAjax()) {

            $news = new News();
            $totalLikes = $news->setLike('news', $_POST['pid'], $_POST['replyNumber'], $_POST['like']);

            $result['total'] = 0;
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
                $blog = new News();
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

        $upload = $c->uploadPhoto(intval($this->params['news_id']),true);

        if ($upload['filename'] != '') {
            $file = MainHelper::showImage($upload['c'], THUMB_LIST_200x300, true, array('width', 'no_img' => 'noimage/no_game_200x300.png'));
            echo $this->toJSON(array('success' => TRUE, 'img' => $file));
        } else {
            echo $this->toJSON(array('error' => $upload['error']));
        }
    }
}

?>
