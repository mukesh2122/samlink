<?php

class GamesController extends SnController {

	public function moduleOff()
	{
		$notAvailable = MainHelper::TrySetModuleNotAvailableByTag('contentchild');
		if ($notAvailable)
		{
			$data['title'] = $this->__('Games');
			$data['body_class'] = 'index_games';
			$data['selected_menu'] = 'games';
			$data['right'] = PlayerHelper::playerRightSide();
			$data['content'] = $notAvailable;
			$data['footer'] = MainHelper::bottomMenu();
			$data['header'] = MainHelper::topMenu();
			$this->render3Cols($data);
			exit;
		}
	}

	/**
	 * Main website
	 *
	 */
	public function index() {
		$this->moduleOff();

		$games = new Games();
		$list = array();
		$category = isset($this->params['category']) ? $this->params['category'] : GAME_INDEX;
		$list['CategoryType'] = $category;
		$list['infoBox'] = MainHelper::loadInfoBox('Games', 'index', true);
		$player = User::getUser();

		$order = isset($this->params['order']) ? $this->params['order'] : '';
		if ($order != 'asc' and $order != 'desc') {
			$order = 'desc'; // default by popularity desc
		}

		$genre = isset($this->params['genre']) ? $this->params['genre'] : 'all-games';
		$genre = ContentHelper::handleContentInput(urldecode(htmlspecialchars($genre)));

		$this->params['tab'] = isset($this->params['tab']) ? $this->params['tab'] : '';

		if ($this->params['tab'] == "") {
			$tabName = 'by-popularity'; // default by popularity
		} else {
			$tabName = $this->params['tab'];
		}
		if ($this->params['tab'] == 'by-popularity') {
			$tab = 2;
		} else if ($this->params['tab'] == 'by-rating') {
			$tab = 3;
		} else if ($this->params['tab'] == 'by-release-date') {
			$tab = 4;
		} else if ($this->params['tab'] == 'alphabetically') {
			$tab = 1;
		} else {
			$tab = 2; // default by popularity
		}

		$list['tab'] = $tab;
		$list['order'] = $order;
		$list['genreList'] = $games->getTypes();
		$genreID = 0;
		$genreTranslated = "";
		if ($genre != 'all-games' and count($list['genreList']) > 0) {
			foreach ($list['genreList'] as $genreItem) {
				if ($genreItem->GameTypeName == $genre) {
					$genreID = $genreItem->ID_GAMETYPE;
					$genreTranslated = $genreItem->NameTranslated;
					break;
				}
			}
		}
		$list['selectedGenre'] = $genre;
		$list['selectedGenreTranslated'] = $genreTranslated;
		$list['selectedGenreID'] = $genreID;

		$contentchildFunctions = MainHelper::GetModuleFunctionsByTag('contentchild');

		$isFreePlay = $category == GAME_FREE_TO_PLAY ? 1 : null;
		$isFreePlay = ($contentchildFunctions['contentchildFreeToPlay']==1) ? $isFreePlay : null;

		$isBuyable = $category == GAME_BUYABLE ? 1 : null;
		$isBuyable = ($contentchildFunctions['contentchildBuyable']==1) ? $isBuyable : null;

		//$isBuyable = ($contentchildFunctions['contentchildBuyable']==1) ? $isBuyable : null;
		if(isset($contentchildFunctions['contentchildBuyable']) && $contentchildFunctions['contentchildBuyable']==1){

		} else {
			$isBuyable=null;	
		}
		
		$gamesTotal = $games->getTotal($genreID, $isFreePlay, $isBuyable);
		$pager = $this->appendPagination($list, $games, $gamesTotal, MainHelper::site_url('games/' . urlencode($category) . '/' . urlencode($genre) . '/tab/' . $tabName . '/' . $order . '/page'), Doo::conf()->gamesLimit);
		$list['gameList'] = $games->getAllGames($pager->limit, $tab, $order, $genreID, $isFreePlay, $isBuyable);

		$data['title'] = $this->__('Games');
		$data['body_class'] = 'index_games';
		$data['selected_menu'] = 'games';
		$data['left'] = $this->renderBlock('games/common/genreList', $list);
		$data['right'] = PlayerHelper::playerRightSide();
		$data['content'] = $this->renderBlock('games/index', $list);
		$data['footer'] = MainHelper::bottomMenu();
		$data['header'] = MainHelper::topMenu();
		$this->render3Cols($data);
	}

	/**
	 * Game view section
	 *
	 */
	public function gameView() {
		$this->moduleOff();

		$game = $this->getGame();
		$events = new Event();
		$news = new News();
		$userRating = 0;

		$list = array();
		$list['CategoryType'] = GAME_INFO;
		$list['infoBox'] = MainHelper::loadInfoBox('Games', 'index', true);
		$list['gameHeader'] = $game->GameName;
		$list['game'] = $game;
		$list['url'] = $this->params['game'];
		$list['news'] = $news;
		$list['userRating'] = $userRating;


		$search = isset($this->params['search']) ? $this->params['search'] : '';
		$list['search'] = $search;

		if ($search == '') {
			$eventCount = $events->getTotalEvents('game', $game->ID_GAME);
			$list['total'] = $eventCount;

			$url = $game->GAME_URL . '/page';
			$pager = $this->appendPagination($list, null, $eventCount, $url, Doo::conf()->eventsLimit);

			$list['events'] = $events->getList('game', $game->ID_GAME, $search, $pager->limit);
		} else {
			$list['events'] = $events->getList('game', $game->ID_GAME, $search);
			$list['total'] = count($list['events']);
		}

		$dynCss = new DynamicCSS;
		$data['dynamicCss'] = $dynCss->getCustomCss('game', $this->params['game']);
		$data['title'] = $game->GameName;
		$data['body_class'] = 'game_view';
		$data['selected_menu'] = 'games';
		$data['left'] = MainHelper::gamesLeftSide($game);
		$data['right'] = PlayerHelper::playerRightSide();
		$data['content'] = $this->renderBlock('games/gameView', $list);
		// if($game->isFreePlay == 1) {
		// 	$data['content'] = $this->renderBlock('games/gameViewFreePlay', $list);
		// } else {
		// 	$data['content'] = $this->renderBlock('games/gameView', $list);
		// }

		$data['footer'] = MainHelper::bottomMenu();
		$data['header'] = MainHelper::topMenu();
		// if($game->isFreePlay == 1) {
		// 	$this->render1ColGame($data);
		// } else {
		// 	$this->render3Cols($data);
		// }
		$this->render3Cols($data);
	}

	/*
	 * Playable game view
	 */

	public function gamePlayView() {
		$this->moduleOff();

		$game = $this->getGame();

		$games = new Games();
		$list = array();
		$list['CategoryType'] = GAME_INFO;
		$list['infoBox'] = MainHelper::loadInfoBox('Games', 'index', true);
		$list['gameHeader'] = $game->GameName;
		$list['game'] = $game;

		$data['title'] = $game->GameName;
		$data['body_class'] = 'game_play_view';
		$data['selected_menu'] = 'games';
		$data['left'] = MainHelper::gamesLeftSide($game);
		$data['right'] = PlayerHelper::playerRightSide();
		$data['content'] = $this->renderBlock('games/gameViewFreePlay', $list);

		$data['footer'] = MainHelper::bottomMenu();
		$data['header'] = MainHelper::topMenu();
		$this->render1ColGame($data);
	}

	/**
	 * News view section
	 *
	 */
	public function newsView() {
		$this->moduleOff();

		$game = $this->getGame();
		$news = new News();
		$games = new Games();
		$p = User::getUser();
		$list = array();
		$list['CategoryType'] = GAME_NEWS;
		$list['infoBox'] = MainHelper::loadInfoBox('Games', 'index', true);

		$list['game'] = $game;
		$list['isAdmin'] = $p ? $p->canAccess('Edit News') : false;;
		$pager = $this->appendPagination($list, $game, $news->getTotalByType($game->ID_GAME, POSTRERTYPE_GAME), $game->GAME_URL . '/news/page');
		$list['newsList'] = $news->getNewsByType($game->ID_GAME, POSTRERTYPE_GAME, $pager->limit, 1);

		$dynCss = new DynamicCSS;
		$data['dynamicCss'] = $dynCss->getCustomCss('game', $this->params['game']);
		$data['title'] = $this->__('News') . ' ' . $game->GameName;
		$data['body_class'] = 'game_news';
		$data['selected_menu'] = 'games';
		$data['left'] = MainHelper::gamesLeftSide($game);
		$data['right'] = PlayerHelper::playerRightSide();
		$data['content'] = $this->renderBlock('games/newsView', $list);
		$data['footer'] = MainHelper::bottomMenu();
		$data['header'] = MainHelper::topMenu();
		$this->render3Cols($data);
	}


	/**
	 * News view section
	 *
	 */
	public function reviews() {
		$this->moduleOff();

		$game = $this->getGame();
		$news = new News();
		$games = new Games();
		$p = User::getUser();
		$list = array();
		$list['CategoryType'] = GAME_REVIEWS;
		$list['infoBox'] = MainHelper::loadInfoBox('Games', 'index', true);
		$list['game'] = $game;
		$list['news'] = $news;
		$list['isAdmin'] = $p ? $p->canAccess('Edit game information') : false;;
		$pager = $this->appendPagination($list, $game, $news->getTotalReviews($game->ID_GAME), $game->GAME_URL . '/reviews/page');
		$reviews = $news->getReviews($game->ID_GAME, $pager->limit);
		$list['reviews'] = $reviews;

		$dynCss = new DynamicCSS;
		$data['dynamicCss'] = $dynCss->getCustomCss('game', $this->params['game']);
		$data['title'] = $this->__('Reviews') . ' ' . $game->GameName;
		$data['body_class'] = 'game_reviews';
		$data['selected_menu'] = 'games';
		$data['left'] = MainHelper::gamesLeftSide($game);
		$data['right'] = PlayerHelper::playerRightSide();
		$data['content'] = $this->renderBlock('games/reviews', $list);
		$data['footer'] = MainHelper::bottomMenu();
		$data['header'] = MainHelper::topMenu();
		$this->render3Cols($data);
	}
	public function unpublishedReviews() {
		$this->moduleOff();

		$game = $this->getGame();
		$news = new News();
		$games = new Games();
		$p = User::getUser();
		$list = array();
		$list['CategoryType'] = GAME_REVIEWS;
		$list['infoBox'] = MainHelper::loadInfoBox('Games', 'index', true);

		$list['game'] = $game;
		$list['isAdmin'] = $p ? $p->canAccess('Edit game information') : false;;
		$pager = $this->appendPagination($list, $game, $news->getTotalUnpublishedReviews($game->ID_GAME), $game->GAME_URL . '/unpublished-reviews/page');
		$list['reviews'] = $news->getUnpublishedReviews($game->ID_GAME, $pager->limit);

		$data['title'] = $this->__('Unpublished reviews') . ' ' . $game->GameName;
		$data['body_class'] = 'game_reviews';
		$data['selected_menu'] = 'games';
		$data['left'] = MainHelper::gamesLeftSide($game);
		$data['right'] = PlayerHelper::playerRightSide();
		$data['content'] = $this->renderBlock('games/reviews', $list);
		$data['footer'] = MainHelper::bottomMenu();
		$data['header'] = MainHelper::topMenu();
		$this->render3Cols($data);
	}

	/**
	 * Searches for news inside company
	 * @return type
	 */
	public function searchNews() {
		$this->moduleOff();

		if (!isset($this->params['searchText'])) {
			DooUriRouter::redirect(Doo::conf()->APP_URL);
			return FALSE;
		}

		$game = $this->getGame();
		$search = new Search();
		$list = array();
		$list['CategoryType'] = GAME_NEWS;
		$list['infoBox'] = MainHelper::loadInfoBox('Games', 'index', true);
		$p = User::getUser();
		$list['game'] = $game;
		$list['isAdmin'] = $p ? $p->canAccess('Edit News') : false;;
		$list['searchText'] = urldecode($this->params['searchText']);
		$newsTotal = $search->getSearchTotal(urldecode($this->params['searchText']), SEARCH_NEWS, SEARCH_GAME, $game->ID_GAME);
		$pager = $this->appendPagination($list, $game, $newsTotal, $game->GAME_URL . '/news/search/' . urlencode($list['searchText']) . '/page');
		$list['newsList'] = $search->getSearch(urldecode($this->params['searchText']), SEARCH_NEWS, $pager->limit, SEARCH_GAME, $game->ID_GAME);
		$list['searchTotal'] = $newsTotal;

		$data['title'] = $this->__('Search results');
		$data['body_class'] = 'search_games';
		$data['selected_menu'] = 'games';
		$data['left'] = MainHelper::gamesLeftSide($game);
		$data['right'] = PlayerHelper::playerRightSide();
		$data['content'] = $this->renderBlock('games/newsView', $list);

		$data['footer'] = MainHelper::bottomMenu();
		$data['header'] = MainHelper::topMenu();
		$this->render3Cols($data);
	}

	public function newsItemView() {
		$this->moduleOff();

		$game = $this->getGame();
		if (!isset($this->params['article'])) {
			DooUriRouter::redirect($game->GAME_URL);
			return FALSE;
		}
		$key = $this->params['article'];
		$list = array();
		$news = new News();
		$games = new Games();
		$lang = array_search($this->params['lang'], Doo::conf()->lang);
		$url = Url::getUrlByName($key, URL_NEWS, $lang);
		if ($url) {
			$article = $news->getArticleByID($url->ID_OWNER, $lang);
		} else {
			DooUriRouter::redirect(Doo::conf()->APP_URL);
			return FALSE;
		}

		if (!$article) {
			DooUriRouter::redirect(Doo::conf()->APP_URL);
			return FALSE;
		}

		$list['CategoryType'] = GAME_NEWS;
		$list['infoBox'] = MainHelper::loadInfoBox('Games', 'index', true);
		$list['game'] = $game;
		$list['item'] = $article;
		$list['lang'] = $lang;
		$rlist = $news->getRepliesList($article->ID_NEWS, $lang, Doo::conf()->defaultShowRepliesLimit);
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

		$data['title'] = $this->__('News') . ' ' . $article->Headline;
		$data['body_class'] = 'game_news';
		$data['selected_menu'] = 'games';
		$data['left'] = MainHelper::gamesLeftSide($game);
		$data['right'] = PlayerHelper::playerRightSide();
		$data['content'] = $this->renderBlock('games/articleView', $list);
		$data['footer'] = MainHelper::bottomMenu();
		$data['header'] = MainHelper::topMenu();
		$this->render3Cols($data);
	}


	public function reviewItemView() {
		$this->moduleOff();

		$game = $this->getGame();
		if (!isset($this->params['article'])) {
			DooUriRouter::redirect($game->GAME_URL);
			return FALSE;
		}
		$key = $this->params['article'];
		$list = array();
		$news = new News();
		$games = new Games();
		$lang = array_search($this->params['lang'], Doo::conf()->lang);
		$url = Url::getUrlByName($key, URL_NEWS, $lang);
		if ($url) {
			$article = $news->getArticleByID($url->ID_OWNER, $lang);
		} else {
			DooUriRouter::redirect(Doo::conf()->APP_URL);
			return FALSE;
		}

		if (!$article) {
			DooUriRouter::redirect(Doo::conf()->APP_URL);
			return FALSE;
		}

		$list['CategoryType'] = GAME_REVIEWS;
		$list['infoBox'] = MainHelper::loadInfoBox('Games', 'index', true);
		$list['game'] = $game;
		$list['item'] = $article;
		$list['lang'] = $lang;
		$rlist = $news->getRepliesList($article->ID_NEWS, $lang, Doo::conf()->defaultShowRepliesLimit);
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

		$data['title'] = $this->__('Review') . ' ' . $article->Headline;
		$data['body_class'] = 'game_news';
		$data['selected_menu'] = 'games';
		$data['left'] = MainHelper::gamesLeftSide($game);
		$data['right'] = PlayerHelper::playerRightSide();
		$data['content'] = $this->renderBlock('games/reviewView', $list);
		$data['footer'] = MainHelper::bottomMenu();
		$data['header'] = MainHelper::topMenu();
		$this->render3Cols($data);
	}

	public function downloadsView() {
		$this->moduleOff();

		$game = $this->getGame();
		$news = new News();
		$games = new Games();
		$list = array();
		$list['CategoryType'] = GAME_DOWNLOADS;
		$list['infoBox'] = MainHelper::loadInfoBox('Games', 'index', true);
		$list['game'] = $game;
		$list['activeTabD'] = isset($this->params['tab_id']) ? $this->params['tab_id'] : 0;
		$list['activeTabMedia'] = GAME_DOWNLOADS;


		$tabs = array();

		$contentchildFunctions = MainHelper::GetModuleFunctionsByTag('contentchild');

		$mediasVideo = $games->getMedias($game->ID_GAME, MEDIA_VIDEO);
		$mediasScreenshot = $games->getMedias($game->ID_GAME, MEDIA_SCREENSHOT);
		$mediasConceptart = $games->getMedias($game->ID_GAME, MEDIA_CONCEPTART);
		$mediasWallpaper = $games->getMedias($game->ID_GAME, MEDIA_WALLPAPER);

		$list['tabsD'] = $games->getFiletypes($game->ID_GAME);
		if (!empty($list['tabsD'])) {
			$list['downloads'] = array();
			foreach ($list['tabsD'] as $tab) {
				$list['downloads'] = array_merge($list['downloads'], $tab->getDownloads());
			}
		}

		if ($contentchildFunctions['contentchildMediaVideos']==1 && count($mediasVideo)>0)
			$tabs[MEDIA_VIDEO_URL] = $this->__('Videos');
		if ($contentchildFunctions['contentchildMediaScreenshots']==1 && count($mediasScreenshot)>0)
			$tabs[MEDIA_SCREENSHOT_URL] = $this->__('Screenshots');
		if ($contentchildFunctions['contentchildMediaConceptArt']==1 && count($mediasConceptart)>0)
			$tabs[MEDIA_CONCEPTART_URL] = $this->__('Concept Art');
		if ($contentchildFunctions['contentchildMediaWallpapers']==1 && count($mediasWallpaper)>0)
			$tabs[MEDIA_WALLPAPER_URL] = $this->__('Wallpapers');
		if ($contentchildFunctions['contentchildMediaDownloads']==1 && count($list['tabsD'])>0)
			$tabs[GAME_DOWNLOADS] = $this->__('Download');

		$list['tabs'] = $tabs;


		$pager = $this->appendPagination($list, $games, $game->DownloadableItems, $game->GAME_URL . '/downloads/page', Doo::conf()->gamesLimit);

		$data['title'] = $this->__('Downloads');
		$data['body_class'] = 'game_downloads';
		$data['selected_menu'] = 'games';
		$data['left'] = MainHelper::gamesLeftSide($game);
		$data['right'] = PlayerHelper::playerRightSide();
		$data['content'] = $this->renderBlock('games/downloadsView', $list);
		$data['footer'] = MainHelper::bottomMenu();
		$data['header'] = MainHelper::topMenu();
		$this->render3Cols($data);
	}

	/**
	 * Main website
	 *
	 */
	public function playersView() {
		$this->moduleOff();

		$game = $this->getGame();
		$games = new Games();
		$p = User::getUser();
		$list = array();
		$list['CategoryType'] = GAME_PLAYERS;
		$list['infoBox'] = MainHelper::loadInfoBox('Games', 'index', true);
		$list['game'] = $game;
                $list['gameUrl'] = $game->GAME_URL;
		$list['isAdmin'] = $p ? $p->canAccess('Edit game information') : false;

		$memberCount = $games->getTotalPlayers($game);
		$pager = $this->appendPagination($list, $games, $memberCount, $game->GAME_URL . '/players/page', Doo::conf()->gameMemberLimit);
		$list['memberList'] = $games->getPlayers($game, $pager->limit);
		$list['memberCount'] = $memberCount;

		$dynCss = new DynamicCSS;
		$data['dynamicCss'] = $dynCss->getCustomCss('game', $this->params['game']);
		$data['title'] = $this->__('Players');
		$data['body_class'] = 'index_game_players';
		$data['selected_menu'] = 'games';
		$data['left'] = MainHelper::gamesLeftSide($game);
		$data['right'] = PlayerHelper::playerRightSide();
		$data['content'] = $this->renderBlock('games/playersView', $list);
		$data['footer'] = MainHelper::bottomMenu();
		$data['header'] = MainHelper::topMenu();
		$this->render3Cols($data);
	}
        
	public function membersView() {
		$this->moduleOff();

		$game = $this->getGame();
		$games = new Games();
        $SnGames = new SnGames();
		$p = User::getUser();
		$list = array();
		$list['CategoryType'] = GAME_MEMBERS;
		$list['infoBox'] = MainHelper::loadInfoBox('Games', 'index', true);
		$list['game'] = $game;
		$list['gameUrl'] = $game->GAME_URL;
        $list['games'] = $games;
		$list['isAdmin'] = $p ? $p->canAccess('Edit game information') : false;
        $list['globalAdmin'] = $SnGames->isAdmin();

		$memberCount = $games->getTotalSubscribed($game);
		$pager = $this->appendPagination($list, $games, $memberCount, $game->GAME_URL . '/members/page', Doo::conf()->gameMemberLimit);
		$list['memberList'] = $games->getSubscribed($game, $pager->limit);
		$list['memberCount'] = $memberCount;

		$dynCss = new DynamicCSS();
		$data['dynamicCss'] = $dynCss->getCustomCss('game', $this->params['game']);
		$data['title'] = $this->__('Members');
		$data['body_class'] = 'index_game_members';
		$data['selected_menu'] = 'games';
		$data['left'] = MainHelper::gamesLeftSide($game);
		$data['right'] = PlayerHelper::playerRightSide();
		$data['content'] = $this->renderBlock('games/membersView', $list);
		$data['footer'] = MainHelper::bottomMenu();
		$data['header'] = MainHelper::topMenu();
		$this->render3Cols($data);
	}

	/**
	 * Media view section
	 *
	 */
	public function mediaView() {
		$this->moduleOff();

		$game = $this->getGame();
		$games = new Games();
		$p = User::getUser();
		$list = array();
		$list['CategoryType'] = GAME_MEDIA;
		$list['infoBox'] = MainHelper::loadInfoBox('Games', 'index', true);
		$list['game'] = $game;
		$list['isAdmin'] = $p ? $p->canAccess('Edit game information') : false;

		$tabs = array();

		$contentchildFunctions = MainHelper::GetModuleFunctionsByTag('contentchild');

		$mediasVideo = $games->getMedias($game->ID_GAME, MEDIA_VIDEO);
		$mediasChannel = $games->getMedias($game->ID_GAME, MEDIA_CHANNEL);
		$mediasScreenshot = $games->getMedias($game->ID_GAME, MEDIA_SCREENSHOT);
		$mediasConceptart = $games->getMedias($game->ID_GAME, MEDIA_CONCEPTART);
		$mediasWallpaper = $games->getMedias($game->ID_GAME, MEDIA_WALLPAPER);

		$list['tabsD'] = $games->getFiletypes($game->ID_GAME);
		if (!empty($list['tabsD'])) {
			$list['downloads'] = array();
			foreach ($list['tabsD'] as $tab) {
				$list['downloads'] = array_merge($list['downloads'], $tab->getDownloads());
			}
		}

		if ($contentchildFunctions['contentchildMediaVideos']==1 && count($mediasVideo)>0)
			$tabs[MEDIA_VIDEO_URL] = $this->__('Videos');
		if ($contentchildFunctions['contentchildMediaScreenshots']==1 && count($mediasScreenshot)>0)
			$tabs[MEDIA_SCREENSHOT_URL] = $this->__('Screenshots');
		if ($contentchildFunctions['contentchildMediaConceptArt']==1 && count($mediasConceptart)>0)
			$tabs[MEDIA_CONCEPTART_URL] = $this->__('Concept Art');
		if ($contentchildFunctions['contentchildMediaWallpapers']==1 && count($mediasWallpaper)>0)
			$tabs[MEDIA_WALLPAPER_URL] = $this->__('Wallpapers');

		$defaultTab = MEDIA_VIDEO_URL;
		if ($contentchildFunctions['contentchildMediaVideos']!=1)
		{
				$defaultTab = MEDIA_SCREENSHOT_URL;
				if ($contentchildFunctions['contentchildMediaScreenshots']!=1)
				{
					$defaultTab = MEDIA_CONCEPTART_URL;
					if ($contentchildFunctions['contentchildMediaConceptArt']!=1)
					{
						$defaultTab = MEDIA_WALLPAPER_URL;
					}
				}
			}

		//Show downloads as default tab if all other tabs are empty
		if(empty($tabs) && !empty($list['downloads']))
		{
			DooUriRouter::redirect($game->GAME_URL .'/downloads');
		}

		$list['tabs'] = $tabs;
		$list['activeTab'] = !isset($this->params['tab']) ? $defaultTab : $this->params['tab'];

		switch ($list['activeTab']) {
			case MEDIA_VIDEO_URL:
				$medias = $games->getMedias($game->ID_GAME, MEDIA_VIDEO);
				$list['media'] = $this->renderBlock('games/media/video_container', array('medias' => $medias, 'game' => $game, 'isAdmin' => $list['isAdmin']));
				break;
			case MEDIA_CHANNEL_URL:
				$medias = $games->getMedias($game->ID_GAME, MEDIA_CHANNEL);
				$list['media'] = $this->renderBlock('games/media/channel_container', array('medias' => $medias, 'game' => $game, 'mediaType' => $list['activeTab']));
				break;
			case MEDIA_SCREENSHOT_URL:
				$medias = $games->getMedias($game->ID_GAME, MEDIA_SCREENSHOT);
				$list['media'] = $this->renderBlock('games/media/image_container', array('medias' => $medias, 'game' => $game, 'mediaType' => $list['activeTab'], 'isAdmin' => $list['isAdmin']));
				break;
			case MEDIA_CONCEPTART_URL:
				$medias = $games->getMedias($game->ID_GAME, MEDIA_CONCEPTART);
				$list['media'] = $this->renderBlock('games/media/image_container', array('medias' => $medias, 'game' => $game, 'mediaType' => $list['activeTab'], 'isAdmin' => $list['isAdmin']));
				break;
			case MEDIA_WALLPAPER_URL:
				$medias = $games->getMedias($game->ID_GAME, MEDIA_WALLPAPER);
				$list['media'] = $this->renderBlock('games/media/image_container', array('medias' => $medias, 'game' => $game, 'mediaType' => $list['activeTab'], 'isAdmin' => $list['isAdmin']));
				break;
			default:
				$list['activeTab'] = MEDIA_VIDEO_URL;
				$medias = $games->getMedias($game->ID_GAME, MEDIA_VIDEO);
				$list['media'] = $this->renderBlock('games/media/video_container', array('medias' => $medias, 'game' => $game));
				break;
		}

		$dynCss = new DynamicCSS;
		$data['dynamicCss'] = $dynCss->getCustomCss('game', $this->params['game']);
		$data['title'] = $this->__('Media');
		$data['body_class'] = 'game_media';
		$data['selected_menu'] = 'games';
		$data['left'] = MainHelper::gamesLeftSide($game);
		$data['right'] = PlayerHelper::playerRightSide();
		$data['content'] = $this->renderBlock('games/mediaView', $list);
		$data['footer'] = MainHelper::bottomMenu();
		$data['header'] = MainHelper::topMenu();
		$this->render3Cols($data);
	}

	/**
	 * Renders iframe
	 *
	 * @return String
	 */
	public function ajaxMediaView() {
		$game = $this->getGame();
		$id = $this->params['media_id'];
		if($this->params['tab'] == MEDIA_CHANNEL_URL){
			if(!empty($id)){
				$list['media'] = $this->renderBlock('games/media/youtubevideo', array('id' => $id));
			}
		}
		else {
			if ($id > 0) {
				$games = new Games();
				$media = $games->getMedia($id);
				$type = $media->MediaType;
				if (isset($media->ID_MEDIA)) {
					switch ($type) {
						case MEDIA_VIDEO:
							$list['media'] = $this->renderBlock('games/media/video', array('media' => $media));
							break;
						case MEDIA_SCREENSHOT:
						case MEDIA_CONCEPTART:
						case MEDIA_WALLPAPER:
							$list['media'] = $this->renderBlock('games/media/image', array('media' => $media));
							break;
					}
				}
			}
		}
		
		echo (isset($list['media']) && !empty($list['media'])) ? $list['media'] : "";
	}

	/**
	 * searches games
	 *
	 */

	/**
	 * searches companies
	 *
	 */
	public function search() {
		$this->moduleOff();

		if (!isset($this->params['searchText'])) {
			DooUriRouter::redirect(MainHelper::site_url('games'));
			return FALSE;
		}

		$games = new Games();
		$search = new Search();
		$list = array();
		$list['CategoryType'] = GAME_INDEX;
		$list['infoBox'] = MainHelper::loadInfoBox('Games', 'index', true);
		$list['searchText'] = urldecode($this->params['searchText']);

		$gamesTotal = $search->getSearchTotal(urldecode($this->params['searchText']), SEARCH_GAME);
		$pager = $this->appendPagination($list, $games, $gamesTotal, MainHelper::site_url('games/search/' . urlencode($list['searchText']) . '/page'), Doo::conf()->gamesLimit);
		$list['gameList'] = $search->getSearch(urldecode($this->params['searchText']), SEARCH_GAME, $pager->limit);
		$list['searchTotal'] = $gamesTotal;
		$list['genreList'] = $games->getTypes();
		$list['selectedGenreID'] = 0;

		$data['title'] = $this->__('Search results');
		$data['body_class'] = 'search_games';
		$data['selected_menu'] = 'games';
		$data['left'] = $this->renderBlock('games/common/genreList', $list);
		$data['right'] = PlayerHelper::playerRightSide();

		$data['content'] = $this->renderBlock('games/index', $list);

		$data['footer'] = MainHelper::bottomMenu();
		$data['header'] = MainHelper::topMenu();
		$this->render3Cols($data);
	}

	public function ajaxRate() {
		if ($this->isAjax() and !empty($_POST) and Auth::isUserLogged()) {
			$ratings = new Ratings();
			$result['result'] = true;
			$result['rating'] = $ratings->rate('game', $_POST['ourl'], $_POST['rating']);
			if (!$result['rating']) {
				$result['result'] = false;
			}
			$this->toJSON($result, true);
		}
		elseif(!Auth::isUserLogged()) {
			$result['redirect'] = true;
			$this->toJSON($result, true);
		}
	}

	public function ajaxGetRating() {
		if ($this->isAjax()) {
			$vote = false;
			$game = null;
			// user looks someones, or his own rating
			if (isset($_POST['ourl'])) {
				$game = Games::getGameByID($_POST['ourl']);
				$isSelf = true;
				// rating is enabled or disabled
				if (isset($_POST['vote'])) {
					$vote = $_POST['vote'];
				}
			}

			if (!$game)
				return false;

			$result['content'] = $this->renderBlock('games/common/rating_info', array('game' => $game,
				'isSelf' => $isSelf,
				'vote' => $vote
					));
			$result['result'] = true;
			$this->toJSON($result, true);
		}
	}

	/**
	 * Upload image
	 *
	 * @return JSON
	 */
	public function ajaxUploadPhoto() {
		$c = new Games();
		if (!isset($this->params['game_id']))
			return false;

		$upload = $c->uploadPhoto(intval($this->params['game_id']));

		if ($upload['filename'] != '') {
			$file = MainHelper::showImage($upload['c'], THUMB_LIST_200x300, true, array('width', 'no_img' => 'noimage/no_game_200x300.png'));
			echo $this->toJSON(array('success' => TRUE, 'img' => $file));
		} else {
			echo $this->toJSON(array('error' => $upload['error']));
		}
	}

	/**
	 * Crop image
	 *
	 * @return JSON
	 */
	public function ajaxCropPhoto() {
		$c = new Games();
		if (!isset($this->params['id']) || !isset($this->params['orientation']) || !isset($this->params['ownertype']))
			return false;
			
		//---- Ensure minimum image size ----
		$minX = 320;
		$minY = 320;
		$minSize = array(
			'portrait'  => THUMB_LIST_200x300
		,	'landscape' => THUMB_LIST_640x480
		,	'square'    => THUMB_LIST_320x320
		,	'banner'    => THUMB_LIST_600x200
		);
		if (!empty($minSize[$this->params['orientation']]) && preg_match('/(\d+)x(\d+)/i', $minSize[$this->params['orientation']], $matches)) {
			list( , $minX, $minY) = $matches;
			if (!empty($_FILES['qqfile'])) {
				list($imgX, $imgY) = getimagesize($_FILES['qqfile']['tmp_name']);
				if ($imgX < $minX || $imgY < $minY) {
					echo $this->toJSON(array('error' =>
						$this->__('Image').' '.$_FILES['qqfile']['name'].' '.$this->__('is too small').".\n"
					.	$imgX.' '.$this->__('pixels wide and').' '.$imgY.' '.$this->__('pixels high').".\n\n"
					.	$this->__('A '.$this->params['orientation'].' picture must be at least')."\n"
					.	$minX.' '.$this->__('pixels wide and').' '.$minY.' '.$this->__('pixels high').'.'
					));
					return;
				}
			}
		}

		$upload = $c->cropPhoto(intval($this->params['id']),$this->params['orientation'],$this->params['ownertype']);

		if ($upload['filename'] != '') {
			switch($this->params['orientation'])
			{
				case'portrait':
				$thumb = THUMB_LIST_100x150;
				break;
				case'landscape':
				$thumb = THUMB_LIST_100x75;
				break;
				case'square':
				$thumb = THUMB_LIST_100x100;
				break;
				case'banner':
				$thumb = THUMB_LIST_100x33;
				break;
			}
			$file1 = MainHelper::showImage($upload['c'], $thumb, true, array('width', 'no_img' => 'noimage/no_game_100x100.png'));

			$jsonArray = array('success' => TRUE, 'img' => $file1);
			if(!isset($_POST)||$_POST == array())
			{
				$jsonArray['img800x600'] = MainHelper::showImage($upload['c'], IMG_800x600, true, array('width', 'no_img' => 'noimage/no_game_800x600.png'));
				
				//---- Calculate minimum crop size ----
				list($cropImgX, $cropImgY) = getimagesize($jsonArray['img800x600']);
				$ratioX = $imgX / $cropImgX;
				$ratioY = $imgY / $cropImgY;
				if ($ratioX > $ratioY) {
					$cropMinX = ceil($minX / $ratioY);
					$cropMinY = ceil($minY / $ratioY);
				}
				else {
					$cropMinX = ceil($minX / $ratioX);
					$cropMinY = ceil($minY / $ratioX);
				}
				$jsonArray['minSize'] = array($cropMinX, $cropMinY);
			}

			echo $this->toJSON($jsonArray);
		} else {
			echo $this->toJSON(array('error' => $upload['error']));
		}
	}

	/**
	 * Opens game edit window
	 */
	public function editGameInfo() {
		$this->moduleOff();

		$game = $this->getGame();
		$p = User::getUser();
		if (isset($game) and $p and $p->canAccess('Edit game information')) {
			$games = new Games();
			$list['types'] = $games->getTypes();
			$list['platforms'] = $games->getGamePlatforms();
			$list['assigned_platforms'] = $games->getAssignedPlatforms($game);
			$list['CategoryType'] = GAME_INFO;
			$list['gameHeader'] = $game->GameName;
			$list['game'] = $game;

			$data['title'] = $game->GameName;
			$data['body_class'] = 'game_view';
			$data['selected_menu'] = 'games';
			$data['left'] = MainHelper::gamesLeftSide($game);
			$data['right'] = PlayerHelper::playerRightSide();
			$data['content'] = $this->renderBlock('games/admin/editGame', $list);

			$data['footer'] = MainHelper::bottomMenu();
			$data['header'] = MainHelper::topMenu();
			$this->render3Cols($data);
		} else {
			DooUriRouter::redirect(Doo::conf()->APP_URL);
		}
	}

	/**
	 * Updates game info
	 */
	public function updateGameInfo() {
		$p = User::getUser();
		if ($this->isAjax() and $p) {
			$games = new Games();
			$game = $games->getGameByID($_POST['game_id']);
			if (isset($game) and $p->canAccess('Edit game information')) {
				$result['result'] = $games->updateGameInfo($game, $_POST);
				MainHelper::UpdateExtrafieldsByPOST('game',$_POST['game_id']);
				$this->toJSON($result, true);
			}
		}
	}

	/**
	 * opens add tab window
	 */
	public function addDownloadTab() {
		$p = User::getUser();
		if ($this->isAjax() and $p) {
			$game = $this->getGame();
			if (isset($game) and $p->canAccess('Edit game information')) {
				$data['game'] = $game;
				echo $this->renderBlock('games/admin/addDownloadTab', $data);
			}
		}
	}

	/**
	 * saves tab
	 */
	public function saveDownloadTab() {
		$p = User::getUser();
		if ($this->isAjax() and $p) {
			$games = new Games();
			$game = $games->getGameByID($_POST['game_id']);
			if (isset($game) and $p->canAccess('Edit game information')) {
				$result['result'] = $games->saveDownloadTab($game, $_POST);
				$this->toJSON($result, true);
			}
		}
	}

	/**
	 * open edit tab window
	 */
	public function editDownloadTab() {
		$p = User::getUser();
		if ($this->isAjax() and $p) {
			$game = $this->getGame();
			if (isset($game) and $p->canAccess('Edit game information')) {
				$data['game'] = $game;
				$games = new Games();
				$data['tabs'] = $games->getFiletypes($game->ID_GAME);
				$data['first_tabs'] = $data['tabs'][0];

				echo $this->renderBlock('games/admin/editDownloadTab', $data);
			}
		}
	}

	public function deleteDownloadTab() {
		$p = User::getUser();
		if ($this->isAjax() and isset($this->params['game']) and MainHelper::validatePostFields(array('tab_id')) and $p) {
			$game = Games::getGameByID($this->params['game']);
			if (isset($game) and $p->canAccess('Edit game information')) {
				$games = new Games();
				$result['result'] = $games->deleteDownloadTab($_POST['tab_id']);
				$this->toJSON($result, true);
			}
		}
	}

	/**
	 * opens add download window
	 */
	public function addDownload() {
		$p = User::getUser();
		if ($this->isAjax() and $p) {
			$game = $this->getGame();
			if (isset($game) and $p->canAccess('Edit game information')) {
				$data['game'] = $game;
				$games = new Games();
				$data['tabs'] = $games->getFiletypes($game->ID_GAME);
				echo $this->renderBlock('games/admin/addDownload', $data);
			}
		}
	}

	/**
	 * saves download to specified tab
	 */
	public function saveDownload() {
		$p = User::getUser();
		if ($this->isAjax() and $p) {
			$games = new Games();
			$game = $games->getGameByID($_POST['game_id']);
			if (isset($game) and $p->canAccess('Edit game information')) {
				$result['result'] = $games->saveDownload($game, $_POST);
				$this->toJSON($result, true);
			}
		}
	}

	/**
	 * deletes selected download
	 */
	public function deleteDownload() {
		$p = User::getUser();
		if ($this->isAjax() and $p) {
			$games = new Games();
			$game = $games->getGameByID($_POST['game_id']);
			if (isset($game) and $p->canAccess('Edit game information')) {
				$result['result'] = $games->deleteDownload($_POST['download_id']);
				$this->toJSON($result, true);
			}
		}
	}

	public function editDownload() {
		$p = User::getUser();
		if ($this->isAjax() and $p) {
			$game = $this->getGame();
			if (isset($game) and $p->canAccess('Edit game information')) {
				$data['game'] = $game;
				$games = new Games();
				$data['download'] = $games->getDownload($this->params['download_id']);
				$data['tabs'] = $games->getFiletypes($game->ID_GAME);
				echo $this->renderBlock('games/admin/editDownload', $data);
			}
		}
	}

	/**
	 * opens add media window
	 */
	public function addMedia() {
		$p = User::getUser();
		if ($this->isAjax() and $p) {
			$game = $this->getGame();
			if (isset($game) and $p->canAccess('Edit game information')) {
				$tabs = array();
				$tabs[MEDIA_VIDEO_URL] = $this->__('Videos');
				$tabs[MEDIA_SCREENSHOT_URL] = $this->__('Screenshots');
				$tabs[MEDIA_CONCEPTART_URL] = $this->__('Concept Art');
				$tabs[MEDIA_WALLPAPER_URL] = $this->__('Wallpapers');

				$data['game'] = $game;
				$data['tabs'] = $tabs;
				echo $this->renderBlock('games/admin/addMedia', $data);
			}
		}
	}

	public function editMedia() {
		$p = User::getUser();
		if ($this->isAjax() and $p) {
			$game = $this->getGame();
			if (isset($game) and $p->canAccess('Edit game information')) {
				$games = new Companies();
				$data['game'] = $game;
				$media = $games->getMedia($this->params['media_id']);
				$tabs = array();
				$tabs1 = array();

				if ($media->MediaType == MEDIA_VIDEO) {
					$tabs[MEDIA_VIDEO_URL] = $this->__('Videos');
					$tabs1[MEDIA_VIDEO_URL] = MEDIA_VIDEO;
				} else {
					$tabs[MEDIA_SCREENSHOT_URL] = $this->__('Screenshots');
					$tabs[MEDIA_CONCEPTART_URL] = $this->__('Concept Art');
					$tabs[MEDIA_WALLPAPER_URL] = $this->__('Wallpapers');

					$tabs1[MEDIA_SCREENSHOT_URL] = MEDIA_SCREENSHOT;
					$tabs1[MEDIA_CONCEPTART_URL] = MEDIA_CONCEPTART;
					$tabs1[MEDIA_WALLPAPER_URL] = MEDIA_WALLPAPER;
				}

				$data['tabs'] = $tabs;
				$data['tabs1'] = $tabs1;
				$data['media'] = $media;
				echo $this->renderBlock('games/admin/editMedia', $data);
			}
		}
	}

	public function saveMedia() {
		$p = User::getUser();
		if ($this->isAjax() and $p) {
			$game = Games::getGameByID($this->params['game']);
			if (isset($game) and $p->canAccess('Edit game information')) {
				$games = new Games();
				$result['result'] = $games->saveMedia($_POST);
				$this->toJSON($result, true);
			}
		}
	}

	public function deleteMedia() {
		$p = User::getUser();
		if ($this->isAjax() and $p) {
			$game = Games::getGameByID($this->params['game']);
			if (isset($game) and $p->canAccess('Edit game information')) {
				$games = new Games();
				$result['result'] = $games->deleteMedia($_POST['media_id']);
				$this->toJSON($result, true);
			}
		}
	}

	/**
	 * Upload multi images to media
	 *
	 * @return JSON
	 */
	public function ajaxUploadMultiPhoto() {
		$g = new Games();
		if (!isset($this->params['game_id']))
			return false;

		$tabs = array();
		$tabs[MEDIA_SCREENSHOT_URL] = MEDIA_SCREENSHOT;
		$tabs[MEDIA_CONCEPTART_URL] = MEDIA_CONCEPTART;
		$tabs[MEDIA_WALLPAPER_URL] = MEDIA_WALLPAPER;

		$upload = $g->uploadMedias(intval($this->params['game_id']), 0, $tabs[$_POST['selected-tab']]);

		if ($upload['filename'] != '') {
			echo 1;
		} else {
			echo 'Error';
		}
	}

	public function ajaxUploadMultiVideo() {
		$g = new Games();
		if (!isset($this->params['game_id']))
			return false;

		$videos = explode("\n", $_POST['media_videos']);

		if (!empty($videos)) {
			foreach ($videos as $video) {
				$v = ContentHelper::parseYoutubeVideo($video);
				if ($v) {
					$g->addVideo($this->params['game_id'], $v);
				}
			}
			$result['result'] = true;
		} else {
			$result['result'] = false;
		}
		$this->toJSON($result, true);
	}

	/**
	 * counts download click
	 *
	 * @return JSON
	 */
	public function ajaxCountDownload() {
		if ($this->isAjax()) {
			$games = new Games();
			$games->addDownloadCount($_POST['id']);
		}
	}

	/**
	 * Toggles like/unlike for company
	 *
	 * @return JSON
	 */
	public function ajaxToggleLike() {
		if ($this->isAjax()) {
			$player = User::getUser();
			if ($player) {
				$result['result'] = $player->toggleLikeGame($_POST['id']);
				$player->purgeCache();
				$this->toJSON($result, true);
			}
		}
	}

	/**
	 * searches for friend in send message field
	 *
	 * @return JSON
	 */
	public function ajaxFindGame() {
		if ($this->isAjax()) {
			$games = new Games();
			$data = array();
			$result = $games->getSearchGames($_GET['q']);
			if (!empty($result)) {
				foreach ($result as $r) {
					$img = MainHelper::showImage($r, THUMB_LIST_60x60, TRUE, array('no_img' => 'noimage/no_game_60x60.png'));
					$data[] = array("id" => $r->ID_GAME, "img" => $img, "name" => $r->GameName);
				}
			}

			$this->toJSON($data, true);
		}
	}

	/**
	 * Gets SnGames from url
	 *
	 * @return SnGames
	 */
	private function getGame() {
		if (!isset($this->params['game'])) {
			DooUriRouter::redirect(Doo::conf()->APP_URL);
			return FALSE;
		}
		$key = $this->params['game'];
		$url = Url::getUrlByName($key, URL_GAME);
		if ($url) {
			$game = Games::getGameByID($url->ID_OWNER);
		} else {
			DooUriRouter::redirect(Doo::conf()->APP_URL);
			return FALSE;
		}
		if (!$game) {
			DooUriRouter::redirect(Doo::conf()->APP_URL);
			return FALSE;
		}

		return $game;
	}

	public function addNews() {
		$this->moduleOff();

		$game = $this->getGame();
		$player = User::getUser();
		if (!$game) {
			DooUriRouter::redirect($game->GAME_URL);
			return FALSE;
		}

		if (!$player or $player->canAccess('Create news') === FALSE) {
			DooUriRouter::redirect($game->GAME_URL);
			return FALSE;
		}

		$list = array();
		if (isset($_POST) and !empty($_POST)) {
			$news = new News();
			$result = $news->saveNews($_POST,0,0,1);
			if ($result instanceof NwItems) {
				$translated = current($result->NwItemLocale);
				$LID = $translated->ID_LANGUAGE;
				DooUriRouter::redirect($game->GAME_URL.'/admin/edit-news/'.$result->ID_NEWS.'/'.$LID);
				return FALSE;
			} else {
				$list['post'] = $_POST;
			}
		}

		$games = new Games();
		$companies = new Companies();
		$news = new News();
		$companyOwners=$companies->getAllCompanies(10000, 1, "ASC"); // List of Companies / Games
		$gameOwners=$games->getAllGames(10000, 1, "ASC"); // Alternate List of Companies / Games
		$companyKeys=array(array('TypeID','ID_COMPANYTYPE'),
						array('OwnerID','ID_COMPANY'),
						array('Name','CompanyName'));
		$gameKeys=array(array('TypeID','ID_GAMETYPE'),
						array('OwnerID','ID_GAME'),
						array('Name','GameName'));
		$companytypeKeys=array(array('TypeID','ID_COMPANYTYPE'),
						array('Name','CompanyTypeName'));
		$gametypeKeys=array(array('TypeID','ID_GAMETYPE'),
						array('Name','GameTypeName'));
		$companytypes = $companies->getTypes(); // Company Types / Game Types
		$gametypes = $games->getTypes(); // Alternate Company Types / Game Types
		$list['companyOwnerArray'] = $news->populateArrayNewsAdmin($companyOwners, $companyKeys);
		$list['gameOwnerArray'] = $news->populateArrayNewsAdmin($gameOwners, $gameKeys);
		$list['companytypes'] = $news->populateArrayNewsAdmin($companytypes, $companytypeKeys);
		$list['gametypes'] = $news->populateArrayNewsAdmin($gametypes, $gametypeKeys);
		$list['function'] = 'add';
		$list['game'] = $game;
		$list['adminPanel'] = 0;
		$list['ownerID'] = $game->ID_GAME;
		$list['type'] = $game->ID_GAMETYPE;
		$list['ownerType'] = 'game';
		$list['itemPlatforms'] = $games->getAssignedPlatformsByGameId($game->ID_GAME);
		$list['typeUrl'] = $game->GAME_URL;
		$list['platforms'] = $games->getGamePlatforms();
		$list['language'] = 1;
		$list['languages'] = Lang::getLanguages();
		$list['CategoryType'] = false;
		$list['infoBox'] = MainHelper::loadInfoBox('Games', 'index', true);
		$player = User::getUser();

		$data['title'] = $this->__('Add News');
		$data['body_class'] = 'recent_games';
		$data['selected_menu'] = 'games';
		$data['left'] = MainHelper::gamesLeftSide($game);
		$data['right'] = PlayerHelper::playerRightSide();
		$data['content'] = $this->renderBlock('admin/news/addEditNews', $list);
		$data['footer'] = MainHelper::bottomMenu();
		$data['header'] = MainHelper::topMenu();
		$this->render3Cols($data);
	}


	public function addReview() {
		$this->moduleOff();

		$game = $this->getGame();
		$player = User::getUser();
		if (!$game) {
			DooUriRouter::redirect($game->GAME_URL);
			return FALSE;
		}
		if (!$player) {
			DooUriRouter::redirect($game->GAME_URL);
			return FALSE;
		}

		$list = array();
		if (isset($_POST) and !empty($_POST)) {
			$_POST['publishLangArticle'] = 1;
			$_POST['platform'] = 0;
			$_POST['messageIntro'] = ContentHelper::handleContentInputWysiwyg($_POST['messageIntro']);
			$_POST['messageText'] = ContentHelper::handleContentInputWysiwyg($_POST['messageText']);

			$news = new News();
			$result = $news->saveNews($_POST, 1);
			if ($result instanceof NwItems) {
				$translated = current($result->NwItemLocale);
				$LID = $translated->ID_LANGUAGE;
				DooUriRouter::redirect($game->GAME_URL . '/edit-review/' . $result->ID_NEWS . '/' . $LID);
				return FALSE;
			} else {
				$list['post'] = $_POST;
			}
		}

		$games = new Games();
		$rating = new Ratings();

		$list['userRating'] = $rating->getUsersRating('game',$game->ID_GAME);
		$list['game'] = $game;
		$list['platforms'] = $games->getGamePlatforms();
		$list['platform'] = 0;
		$list['language'] = 1;
		$list['languages'] = Lang::getLanguages();
		$list['CategoryType'] = false;
		$list['infoBox'] = MainHelper::loadInfoBox('Games', 'addReview', true);
		$player = User::getUser();

		$data['title'] = $this->__('Add Review');
		$data['body_class'] = 'recent_games';
		$data['selected_menu'] = 'games';
		$data['left'] = MainHelper::gamesLeftSide($game);
		$data['right'] = PlayerHelper::playerRightSide();
		$data['content'] = $this->renderBlock('games/addEditReview', $list);
		$data['footer'] = MainHelper::bottomMenu();
		$data['header'] = MainHelper::topMenu();
		$this->render3Cols($data);
	}


    public function chooseLang() {
        $this->moduleOff();
        if ($this->isAjax()) {
            $game = $this->getGame();
            if (!$game or !isset($this->params['news_id'])) {
                DooUriRouter::redirect($game->GAME_URL);
                return FALSE;
            }
            $news = new News();
            $newsItem = $news->getArticleByID($this->params['news_id']);
            $data['lang'] = $newsItem->getTranslatedLanguages();
            $data['item'] = $newsItem;
            echo $this->renderBlock('admin/news/chooseLang', $data);
        }
    }

    public function editNews() {
        $this->moduleOff();

        $game = $this->getGame();
        $player = User::getUser();
        if (!$game or !isset($this->params['news_id'])) {
            DooUriRouter::redirect($game->GAME_URL);
            return FALSE;
        }

        if (!$player or $player->canAccess('Edit news') === FALSE) {
            DooUriRouter::redirect($game->GAME_URL);
            return FALSE;
        }

        $list = array();
        if (isset($_POST) and !empty($_POST)) {
            $news = new News();
            $result = $news->updateNews($_POST);
            if ($result instanceof NwItems) {
                $translated = current($result->NwItemLocale);
                $LID = $translated->ID_LANGUAGE;
                $lang = Lang::getLangById($LID);
                $langShort = strtolower($lang->A2);
                $url = Url::getUrlById($result->ID_NEWS, URL_NEWS, $LID);
                DooUriRouter::redirect(MainHelper::site_url('news/view/' . $langShort . '/' . $url->URL));
                return FALSE;
            } else {
                $list['post'] = $_POST;
            }
        }

        $games = new Games();
        $news = new News();
        $companies = new Companies();
        $prefix = new Prefix();

        $list['game'] = $game;
        $newsItem = $news->getArticleByID($this->params['news_id'], $this->params['lang_id']);

        $translated = null;
        if (isset($newsItem->NwItemLocale)) {
            $translated = current($newsItem->NwItemLocale);
        }

        if (!isset($translated)) {
            DooUriRouter::redirect($game->GAME_URL . '/news');
            return FALSE;
        }
        $type = $games->getGameByID($newsItem->ID_OWNER);
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
        $list['function'] = 'edit';
        $list['adminPanel'] = 1;
        $list['ownerID'] = $newsItem->ID_OWNER;
        $list['type'] = $type->ID_GAMETYPE;
        $list['newsItem'] = $newsItem;
        $list['ownerType'] = 'game';
        $list['itemPlatforms'] = $games->getAssignedPlatformsByGameId($newsItem->ID_OWNER);
        $list['platforms'] = $games->getGamePlatforms();
        $list['language'] = $this->params['lang_id'];
        $list['languages'] = Lang::getLanguages();

        $list['prefixes'] = Prefix::getPrefixes(); 
        $items = new NwItems(); 
        $selected = ($this->params['news_id']);
        $selected = $items->find(array('asc' => 'ID_PREFIX', 'where' => 'ID_NEWS =' . $selected));
        $selected = $selected[0]->ID_PREFIX;      
        $list['prefix'] = $selected;


//$list['prefixes'] = $prefix->getPrefixName($newsItem->ID_PREFIX);


        $list['typeUrl'] = $game->GAME_URL;
        $list['translated'] = $translated;
        $list['CategoryType'] = false;
        $list['infoBox'] = MainHelper::loadInfoBox('Games', 'index', true);



        $data['title'] = $this->__('Edit News');
        $data['body_class'] = 'recent_games';
        $data['selected_menu'] = 'games';
        $data['left'] = MainHelper::gamesLeftSide($game);
        $data['right'] = PlayerHelper::playerRightSide();
        $data['content'] = $this->renderBlock('admin/news/addEditNews', $list);
        $data['footer'] = MainHelper::bottomMenu();
        $data['header'] = MainHelper::topMenu();
        $this->render3Cols($data);
    }

    public function editReview() {
        $this->moduleOff();

        $game = $this->getGame();
        $player = User::getUser();

        $news = new News();
        $newsItem = $news->getArticleByID($this->params['news_id'], $this->params['lang_id']);
        if (!$game or !isset($this->params['news_id'])) {
            DooUriRouter::redirect($game->GAME_URL);
            return FALSE;
        }

        if (!$player or !$player->canAccess('Edit news') or !$newsItem->isAuthor()) {
            DooUriRouter::redirect($game->GAME_URL);
            return FALSE;
        }

        $list = array();
        if (isset($_POST) and !empty($_POST)) {
            $_POST['publishLangArticle'] = 1;
            $_POST['platform'] = 0;
            $_POST['messageIntro'] = ContentHelper::handleContentInputWysiwyg($_POST['messageIntro']);
            $_POST['messageText'] = ContentHelper::handleContentInputWysiwyg($_POST['messageText']);

            $result = $news->updateNews($_POST, 1);
            if ($result instanceof NwItems) {
                $translated = current($result->NwItemLocale);
                $LID = $translated->ID_LANGUAGE;
                DooUriRouter::redirect($game->GAME_URL . '/edit-review/' . $result->ID_NEWS . '/' . $LID);
                return FALSE;
            } else {
                $list['post'] = $_POST;
            }
        }

        $games = new Games();
        $news = new News();
        $rating = new Ratings();

        $list['game'] = $game;

        $translated = null;
        if (isset($newsItem->NwItemLocale)) {
            $translated = current($newsItem->NwItemLocale);
        }

        if (!isset($translated)) {
            DooUriRouter::redirect($game->GAME_URL . '/news');
            return FALSE;
        }

        $list['userRating'] = $rating->getUsersRating('game', $game->ID_GAME);
        $list['newsItem'] = $newsItem;
        $list['platforms'] = $games->getGamePlatforms();
        $list['language'] = $this->params['lang_id'];
        $list['languages'] = Lang::getLanguages();
        $list['translated'] = $translated;
        $list['CategoryType'] = false;
        $list['infoBox'] = MainHelper::loadInfoBox('Games', 'addReview', true);

        $data['title'] = $this->__('Edit Review');
        $data['body_class'] = 'recent_games';
        $data['selected_menu'] = 'games';
        $data['left'] = MainHelper::gamesLeftSide($game);
        $data['right'] = PlayerHelper::playerRightSide();
        $data['content'] = $this->renderBlock('games/addEditReview', $list);
        $data['footer'] = MainHelper::bottomMenu();
        $data['header'] = MainHelper::topMenu();
        $this->render3Cols($data);
    }

    public function ajaxSearchGames() {
        if ($this->isAjax()) {
            $s = '';
            $g = new Games();
            if (isset($_POST['q']) and strlen($_POST['q']) >= 3) {
                $games = $g->searchGames($_POST['q']);

                if (!empty($games)) {
                    foreach ($games as $game) {
                        $s .= $this->renderBlock('common/gameSmall', array('game' => $game, 'id' => 'F_addGame'));
                    }
                }
            }

            $this->toJSON($s, true);
        }
    }

    public function wall() {
        $this->moduleOff();

        $game = $this->getGame();
        $p = User::getUser();
        $groups = new Games();
        $list = array();
        $wall = new Wall();
        $list['CategoryType'] = GAME_WALL;
        $list['infoBox'] = MainHelper::loadInfoBox('Games', 'index', true);
        $list['companyHeader'] = $game->GameName;
        $list['game'] = $game;
        $list['isAdmin'] = $p ? $p->canAccess('Edit game information') : false;
        MainHelper::getWallPosts($list, $game);

        $dynCss = new DynamicCSS;
        $data['dynamicCss'] = $dynCss->getCustomCss('game', $this->params['game']);
        $data['title'] = $game->GameName;
        $data['body_class'] = 'index_game_wall';
        $data['selected_menu'] = 'games';
        $data['left'] = MainHelper::gamesLeftSide($game);
        $data['right'] = PlayerHelper::playerRightSide();
        $data['content'] = $this->renderBlock('games/wall', $list);
        $data['footer'] = MainHelper::bottomMenu();
        $data['header'] = MainHelper::topMenu();
        $this->render3Cols($data);
    }

    // ADDED 
    public function Memberslist() {
        $this->moduleOff();

        $data['title'] = $this->__('Members');
        $data['body_class'] = 'index_game_players';

        $list['CategoryType'] = GAME_PLAYERS;

        $game = $this->getGame(); // getting gameinformation
        $list['game'] = $game;


        $games = new Games(); // the model

        $p = User::getUser(); // info's about the user you are logged in with
        $list['user'] = $p;
        $list['isAdmin'] = $games->isForumAdmin();


        $memberCount = $games->getTotalPlayers($game);
        $pager = $this->appendPagination($list, $games, $memberCount, $game->GAME_URL . '/members/page', Doo::conf()->gameMemberLimit);
        $list['members'] = $games->getMembers($game, $pager->limit);
        $list['memberCount'] = $memberCount;


        $data['selected_menu'] = 'games';
        $data['left'] = MainHelper::gamesLeftSide($game);
        $data['right'] = PlayerHelper::playerRightSide();

        $data['content'] = $this->renderBlock('games/memberslist', $list);
        $data['footer'] = MainHelper::bottomMenu();
        $data['header'] = MainHelper::topMenu();
        $this->render3Cols($data);
    }

    public function translateNews() {
        $this->moduleOff();

        $game = $this->getGame();
        $player = User::getUser();
        if (!$game or !isset($this->params['news_id'])) {
            DooUriRouter::redirect($game->GAME_URL);
            return FALSE;
        }
        if ($game->isAdmin() === FALSE) {
            if (!$player or $player->canAccess('Translate news') === FALSE) {
                DooUriRouter::redirect($game->GAME_URL);
                return FALSE;
            }
        }

        $list = array();
        if (isset($_POST) and !empty($_POST)) {
            $news = new News();
            $result = $news->saveTranslation($_POST);
            if ($result instanceof NwItemLocale) {
                $LID = $result->ID_LANGUAGE;
                DooUriRouter::redirect($game->GAME_URL . '/admin/edit-news/' . $result->ID_NEWS . '/' . $LID);
                return FALSE;
            } else {
                $list['post'] = $_POST;
            }
        }

        $news = new News();

        $list['game'] = $game;
        $newsItem = $news->getArticleByID($this->params['news_id'], 1);
        $translated = null;
        if (isset($newsItem->NwItemLocale)) {
            $translated = current($newsItem->NwItemLocale);
        }
        if (!isset($translated)) {
            $newsItem = $news->getArticleByID($this->params['news_id']);
            if (!$newsItem) {
                DooUriRouter::redirect($game->GAME_URL);
            }
        }

        $list['newsItem'] = $newsItem;
        $list['translatedLangs'] = $newsItem->getTranslatedLanguages();
        $list['translated'] = $translated ? $translated : null;
        $list['languages'] = Lang::getLanguages();
        $list['infoBox'] = MainHelper::loadInfoBox('Games', 'index', true);

        $data['title'] = $this->__('Translate News');
        $data['body_class'] = 'translate_news';
        $data['selected_menu'] = 'games';
        $data['left'] = MainHelper::gamesLeftSide($game);
        $data['right'] = PlayerHelper::playerRightSide();
        $data['content'] = $this->renderBlock('admin/news/translateNews', $list);
        $data['footer'] = MainHelper::bottomMenu();
        $data['header'] = MainHelper::topMenu();
        $this->render3Cols($data);
    }

}
?>

