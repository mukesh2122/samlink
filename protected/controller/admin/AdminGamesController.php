<?php

class AdminGamesController extends AdminController {

    /**
     * Main website
     *
     */
    public function index() {
        $player = User::getUser();
        if ($player->canAccess('Edit game information') === FALSE) {
            DooUriRouter::redirect(MainHelper::site_url('admin'));
        }

        $games = new Games();
        $list = array();

        $gameTypeID = isset($this->params['type_id']) ? $this->params['type_id'] : 0;
        $sortType = isset($this->params['sortType']) ? $this->params['sortType'] : 'Status';
        $sortDir = isset($this->params['sortDir']) ? $this->params['sortDir'] : 'asc';
        $pager = $this->appendPagination($list, new stdClass(), $games->getTotal($gameTypeID), MainHelper::site_url('admin/games' . (isset($sortType) ? ('/sort/' . $sortType . '/' . $sortDir) : '') . (isset($gameTypeID) ? ('/type/' . $gameTypeID) : '') . '/page'), Doo::conf()->adminGamesLimit);
        $list['games'] = $games->getAllGames($pager->limit, $sortType, $sortDir, $gameTypeID);
        $list['gameTypes'] = $games->getTypes();
        $list['sortType'] = $sortType;
        $list['sortDir'] = $sortDir;

        $data['title'] = $this->__('Games');
        $data['body_class'] = 'index_games';
        $data['selected_menu'] = 'games';
        $data['left'] = $this->renderBlock('games/common/leftColumn', $list);
        $data['right'] = 'right';
        $data['content'] = $this->renderBlock('games/index', $list);
        $data['header'] = $this->getMenu();
        $this->render3Cols($data);
    }

    public function search() {
        if (!isset($this->params['searchText'])) {
            DooUriRouter::redirect(MainHelper::site_url('admin/games'));
            return FALSE;
        }

        $games = new Games();
        $search = new Search();
        $list = array();
        $player = User::getUser();
        if ($player->canAccess('Edit game information') === FALSE) {
            DooUriRouter::redirect(MainHelper::site_url('admin'));
        }

        $list['searchText'] = urldecode($this->params['searchText']);

        $gamesTotal = $search->getSearchTotal(urldecode($this->params['searchText']), SEARCH_GAME);
        $pager = $this->appendPagination($list, $games, $gamesTotal, MainHelper::site_url('admin/games/search/' . urlencode($list['searchText']) . '/page'), Doo::conf()->adminGamesLimit);
        $list['games'] = $search->getSearch(urldecode($this->params['searchText']), SEARCH_GAME, $pager->limit);
        $list['searchTotal'] = $gamesTotal;
        $list['gameTypes'] = $games->getTypes();

        $data['title'] = $this->__('Search results');
        $data['body_class'] = 'search_games';
        $data['selected_menu'] = 'games';
        $data['left'] = $this->renderBlock('games/common/leftColumn', $list);
        $data['right'] = 'right';
        $data['content'] = $this->renderBlock('games/index', $list);
        $data['header'] = $this->getMenu();
        $this->render3Cols($data);
    }

    public function edit() {
        $player = User::getUser();
        if ($player->canAccess('Edit game information') === FALSE) {
            DooUriRouter::redirect(MainHelper::site_url('admin'));
        }

        $games = new Games();
        $companies = new Companies();
        $list = array();
        $game = $games->getGameByID($this->params['game_id']);
        if (!$game) {
            DooUriRouter::redirect(MainHelper::site_url('admin/games'));
        }
        $contentchildFunctions = MainHelper::GetModuleFunctionsByTag('contentchild');

        $gameDownloads = $games->getDownloadsByGameId($game->ID_GAME);
        $gameMedia = $games->getMedias($game->ID_GAME);
        $gameTypes = $games->getTypes();
        $gameAllPlatforms = $games->getGamePlatforms();
        if (isset($_POST) and !empty($_POST)) {
            $_POST['isFreePlay'] = isset($_POST['isFreePlay']) ? 1 : 0;
            $_POST['isFreePlay'] = ($contentchildFunctions['contentchildFreeToPlay'] == 1) ? $_POST['isFreePlay'] : 0;
            $_POST['isBuyable'] = isset($_POST['isBuyable']) ? 1 : 0;
            $_POST['isBuyable'] = ($contentchildFunctions['contentchildBuyable'] == 1) ? $_POST['isBuyable'] : 0;
            $games->updateGameInfo($game, $_POST);
            MainHelper::UpdateExtrafieldsByPOST('game', $game->ID_GAME);
            DooUriRouter::redirect(MainHelper::site_url('admin/games/edit/' . $game->ID_GAME));
        }

        $list['game'] = $game;
        $list['gameTypes'] = $gameTypes;
        $list['gameAllPlatforms'] = $gameAllPlatforms;

        $list['gamePlatforms'] = $games->getAssignedPlatforms($game);
        $list['companies'] = $companies->getAllCompanies(99999, 0, 'asc');

        $relations = $game->getCompanyRel();
        $developer = array();
        if (isset($relations) and !empty($relations->developers) and is_array($relations->developers)) {
            $developer = array();
            foreach ($relations->developers as $d) {
                $developer[] = $d->SnCompanies->ID_COMPANY;
            }
        }

        $distributor = array();
        if (isset($relations) and !empty($relations->distributors) and is_array($relations->distributors)) {
            $distributor = array();
            foreach ($relations->distributors as $d) {
                $distributor[] = $d->SnCompanies->ID_COMPANY;
            }
        }

        $list['developers'] = $developer;
        $list['distributors'] = $distributor;
        $list['gameMedia'] = $gameMedia;
        $list['gameDownloads'] = $gameDownloads;
        $list['gameDownloadTabs'] = $games->getFiletypes($game->ID_GAME);

        //Possible extrafields for this company
        $extrafields = MainHelper::GetExtraFieldsByOwnertype('game', $game->ID_GAME);
        $list['extrafields'] = $extrafields;

        $data['title'] = $this->__('Edit Game');
        $data['body_class'] = 'index_games';
        $data['selected_menu'] = 'games';
        $data['left'] = $this->renderBlock('games/common/leftColumn', $list);
        $data['right'] = $this->renderBlock('games/common/rightColumn', $list);
        $data['content'] = $this->renderBlock('games/edit', $list);
        $data['header'] = $this->getMenu();
        $this->render3Cols($data);
    }

    public function newGame() {
        $player = User::getUser();
        if ($player->canAccess('Edit game information') === FALSE) {
            DooUriRouter::redirect(MainHelper::site_url('admin'));
        }

        $contentchildFunctions = MainHelper::GetModuleFunctionsByTag('contentchild');

        $games = new Games();
        $companies = new Companies();
        $list = array();
        $gameTypes = $games->getTypes();
        $gameAllPlatforms = $games->getGamePlatforms();
        if (isset($_POST) and !empty($_POST)) {
            $_POST['isFreePlay'] = isset($_POST['isFreePlay']) ? 1 : 0;
            $_POST['isFreePlay'] = ($contentchildFunctions['contentchildFreeToPlay'] == 1) ? $_POST['isFreePlay'] : 0;
            $_POST['isBuyable'] = isset($_POST['isBuyable']) ? 1 : 0;
            $_POST['isBuyable'] = ($contentchildFunctions['contentchildBuyable'] == 1) ? $_POST['isBuyable'] : 0;
            $game = $games->createGame($_POST);
            if ($game) {
                MainHelper::UpdateExtrafieldsByPOST('game', $game->ID_GAME);
                DooUriRouter::redirect(MainHelper::site_url('admin/games/edit/' . $game->ID_GAME));
            }
        }

        $list['gameTypes'] = $gameTypes;
        $list['gameAllPlatforms'] = $gameAllPlatforms;

        $list['gamePlatforms'] = array();
        $list['companies'] = $companies->getAllCompanies(99999, 0, 'asc');

        $list['developers'] = array();
        $list['distributors'] = array();

        //Possible extrafields for this game
        $extrafields = MainHelper::GetExtraFieldsByOwnertype('game');
        $list['extrafields'] = $extrafields;

        $data['title'] = $this->__('New Game');
        $data['body_class'] = 'index_games';
        $data['selected_menu'] = 'games';
        $data['left'] = $this->renderBlock('games/common/leftColumn', $list);
        $data['right'] = 'right';
        $data['content'] = $this->renderBlock('games/new', $list);
        $data['header'] = $this->getMenu();
        $this->render3Cols($data);
    }

    public function allGameTypes() {
        $player = User::getUser();
        if ($player->canAccess('Edit game information') === FALSE) {
            DooUriRouter::redirect(MainHelper::site_url('admin'));
        }

        $games = new Games();
        $list = array();

        $pager = $this->appendPagination($list, new stdClass(), $games->getTotalGameTypes(), MainHelper::site_url('admin/games/types/page'), Doo::conf()->adminGamesLimit);
        $list['gameTypes'] = $games->getTypes();

        $data['title'] = $this->__('Games');
        $data['body_class'] = 'index_games';
        $data['selected_menu'] = 'games';
        $data['left'] = $this->renderBlock('games/common/leftColumn', $list);
        $data['right'] = 'right';
        $data['content'] = $this->renderBlock('games/gameTypes', $list);
        $data['header'] = $this->getMenu();
        $this->render3Cols($data);
    }

    public function newGameType() {
        $player = User::getUser();
        if ($player->canAccess('Edit game information') === FALSE) {
            DooUriRouter::redirect(MainHelper::site_url('admin'));
        }

        $games = new Games();
        if (isset($_POST) and !empty($_POST)) {
            $gameType = $games->createGameType($_POST);
            if ($gameType) {
                DooUriRouter::redirect(MainHelper::site_url('admin/games/types'));
            }
        }
        $list = array();

        $list['gameTypes'] = $games->getTypes();

        $data['title'] = $this->__('New Game Type');
        $data['body_class'] = 'index_games';
        $data['selected_menu'] = 'games';
        $data['left'] = $this->renderBlock('games/common/leftColumn', $list);
        $data['right'] = 'right';
        $data['content'] = $this->renderBlock('games/newType');
        $data['header'] = $this->getMenu();
        $this->render3Cols($data);
    }

    public function editGameType() {
        $player = User::getUser();
        if ($player->canAccess('Edit game information') === FALSE) {
            DooUriRouter::redirect(MainHelper::site_url('admin'));
        }

        $games = new Games();
        $list = array();
        $gameType = $games->getGameTypeByID($this->params['type_id']);
        if (!$gameType) {
            DooUriRouter::redirect(MainHelper::site_url('admin/games/types'));
        }

        if (isset($_POST) and !empty($_POST)) {
            $games->updateGameType($gameType, $_POST);
            DooUriRouter::redirect(MainHelper::site_url('admin/games/types'));
        }

        $list['gameType'] = $gameType;
        $list['gameTypes'] = $games->getTypes();

        $data['title'] = $this->__('Edit Game Type');
        $data['body_class'] = 'index_games';
        $data['selected_menu'] = 'games';
        $data['left'] = $this->renderBlock('games/common/leftColumn', $list);
        $data['right'] = 'right';
        $data['content'] = $this->renderBlock('games/editType', $list);
        $data['header'] = $this->getMenu();
        $this->render3Cols($data);
    }

    public function deleteGameType() {
        $player = User::getUser();
        if ($player->canAccess('Edit game information') === FALSE) {
            DooUriRouter::redirect(MainHelper::site_url('admin'));
        }

        $games = new Games();
        $gameType = $games->getGameTypeByID($this->params['type_id']);
        if (!$gameType) {
            DooUriRouter::redirect(MainHelper::site_url('admin/games/types'));
        } else {
            $result = $games->deleteGameType($gameType->ID_GAMETYPE);
            if ($result === TRUE) {
                DooUriRouter::redirect(MainHelper::site_url('admin/games/types'));
            }
        }
    }

    public function mergeGameTypes() {
        $player = User::getUser();
        if ($player->canAccess('Edit game information') === FALSE) {
            DooUriRouter::redirect(MainHelper::site_url('admin'));
        }

        $games = new Games();
        $list = array();
        $gameType = $games->getGameTypeByID($this->params['type_id']);
        if (!$gameType) {
            DooUriRouter::redirect(MainHelper::site_url('admin/games/types'));
        }

        if (isset($_POST) and !empty($_POST)) {
            $games->mergeGameTypes($_POST);
            DooUriRouter::redirect(MainHelper::site_url('admin/games/types'));
        }

        $list['typeItem'] = $gameType;
        $list['gameTypes'] = $games->getTypes();

        $data['title'] = $this->__('Merge Game Types');
        $data['body_class'] = 'index_games';
        $data['selected_menu'] = 'games';
        $data['left'] = $this->renderBlock('games/common/leftColumn', $list);
        $data['right'] = 'right';
        $data['content'] = $this->renderBlock('games/mergeTypes', $list);
        $data['header'] = $this->getMenu();
        $this->render3Cols($data);
    }

    public function addMedia() {
        $games = new Games();
        $player = User::getUser();
        $game = $games->getGameByID($this->params['game_id']);
        if (!$game || $player->canAccess('Edit game information') === FALSE) {
            DooUriRouter::redirect(MainHelper::site_url('admin'));
        }
        $tabs = array();
        $tabs[MEDIA_VIDEO] = $this->__('Videos');
        $tabs[MEDIA_SCREENSHOT] = $this->__('Screenshots');
        $tabs[MEDIA_CONCEPTART] = $this->__('Concept Art');
        $tabs[MEDIA_WALLPAPER] = $this->__('Wallpapers');

        $gameDownloads = $games->getDownloadsByGameId($game->ID_GAME);
        $gameMedia = $games->getMedias($game->ID_GAME);

        if (isset($_POST) and !empty($_POST)) {
            $check = false;
            $mediaType = $_POST['MediaType'];
            if ($mediaType == MEDIA_VIDEO) {
                $mediaParsed = ContentHelper::parseYoutubeVideo($_POST['media_videos']);
                $media = $games->addVideo($game->ID_GAME, $mediaParsed, $_POST['media_videos']);
                if (isset($media) && !empty($media))
                    $check = true;
            }
            else {
                $media = $games->uploadMedias($game->ID_GAME, 0, $_POST['MediaType'], $_FILES['Filedata']);
                if ($media['media'])
                    $check = true;
            }
            if ($check === true) {
                DooUriRouter::redirect(MainHelper::site_url('admin/games/edit/' . $game->ID_GAME));
            }
        }

        $list = array();
        $list['game'] = $game;
        $list['tabs'] = $tabs;
        $list['gameMedia'] = $gameMedia;
        $list['gameDownloads'] = $gameDownloads;
        $list['gameDownloadTabs'] = $games->getFiletypes($game->ID_GAME);
        $list['gameTypes'] = $games->getTypes();
        $list['prefixes'] = Prefix::getPrefixes(); // test


        $data['title'] = $this->__('Add Media');
        $data['body_class'] = 'index_media';
        $data['selected_menu'] = 'games';
        $data['left'] = $this->renderBlock('games/common/leftColumn', $list);
        $data['right'] = $this->renderBlock('games/common/rightColumn', $list);
        $data['content'] = $this->renderBlock('games/addMedia', $list);
        $data['header'] = $this->getMenu();
        $this->render3Cols($data);
    }

    public function editMedia() {
        $games = new Games();
        $prefix = new Prefixes();
        $player = User::getUser();
        $game = $games->getGameByID($this->params['game_id']);
        $medium = $games->getMedia($this->params['media_id']);
        if (!$game || !$medium || $player->canAccess('Edit game information') === FALSE) {
            DooUriRouter::redirect(MainHelper::site_url('admin'));
        }
        $tabs = array();
        $tabs[MEDIA_SCREENSHOT] = $this->__('Screenshots');
        $tabs[MEDIA_CONCEPTART] = $this->__('Concept Art');
        $tabs[MEDIA_WALLPAPER] = $this->__('Wallpapers');

        $gameDownloads = $games->getDownloadsByGameId($game->ID_GAME);
        $gameMedia = $games->getMedias($game->ID_GAME);

        if (isset($_POST) and !empty($_POST)) {
            $check = false;
            $mediaType = $_POST['MediaType'];
            $media = $games->updateMedia($_POST);
            if ($media === true) {
                DooUriRouter::redirect(MainHelper::site_url('admin/games/edit/' . $game->ID_GAME));
            }
        }

        $list = array();
        $list['game'] = $game;
        $list['tabs'] = $tabs;
        $list['gameMedia'] = $gameMedia;
        $list['gameDownloads'] = $gameDownloads;
        $list['gameDownloadTabs'] = $games->getFiletypes($game->ID_GAME);
        $list['gameTypes'] = $games->getTypes();
        $list['mediaItem'] = $medium;
        $list['prefixes'] = $prefix->getPrefixName($prefix->ID_PREFIX);
        //$list['prefixes'] = Prefix::getPrefixes(); //test


        $data['title'] = $this->__('Edit Media');
        $data['body_class'] = 'index_media';
        $data['selected_menu'] = 'games';
        $data['left'] = $this->renderBlock('games/common/leftColumn', $list);
        $data['right'] = $this->renderBlock('games/common/rightColumn', $list);
        $data['content'] = $this->renderBlock('games/editMedia', $list);
        $data['header'] = $this->getMenu();
        $this->render3Cols($data);
    }

    public function deleteMedia() {
        $games = new Games();
        $player = User::getUser();
        $game = $games->getGameByID($this->params['game_id']);
        $medium = $games->getMedia($this->params['media_id']);
        if (!$game || !$medium || $player->canAccess('Edit game information') === FALSE) {
            DooUriRouter::redirect(MainHelper::site_url('admin'));
        } else {
            $result = $games->deleteMedia($medium->ID_MEDIA);
            if ($result === TRUE) {
                DooUriRouter::redirect(MainHelper::site_url('admin/games/edit/' . $game->ID_GAME . '/media'));
            }
        }
    }

    public function allMedia() {
        $player = User::getUser();
        $games = new Games();
        $game = $games->getGameByID($this->params['game_id']);
        if (!$game || $player->canAccess('Edit game information') === FALSE) {
            DooUriRouter::redirect(MainHelper::site_url('admin'));
        }


        $list = array();
        $pager = $this->appendPagination($list, new stdClass(), $games->getTotalMediaByGameId($game->ID_GAME), MainHelper::site_url('admin/companies/edit/' . $game->ID_GAME . '/media/page'), Doo::conf()->adminGamesLimit);

        $list['game'] = $games->getGameByID($this->params['game_id']);
        $list['gameMedia'] = $games->getMedias($game->ID_GAME);
        $list['gameDownloads'] = $games->getDownloadsByGameId($game->ID_GAME);
        $list['gameDownloadTabs'] = $games->getFiletypes($game->ID_GAME);
        $list['gameTypes'] = $games->getTypes();

        $data['title'] = $this->__('All Media');
        $data['body_class'] = 'index_media';
        $data['selected_menu'] = 'games';
        $data['left'] = $this->renderBlock('games/common/leftColumn', $list);
        $data['right'] = $this->renderBlock('games/common/rightColumn', $list);
        $data['content'] = $this->renderBlock('games/allMedia', $list);
        $data['header'] = $this->getMenu();
        $this->render3Cols($data);
    }

    public function allFiletypes() {
        $player = User::getUser();
        $games = new Games();
        $game = $games->getGameByID($this->params['game_id']);
        if (!$game || $player->canAccess('Edit game information') === FALSE) {
            DooUriRouter::redirect(MainHelper::site_url('admin'));
        }


        $list = array();
        $pager = $this->appendPagination($list, new stdClass(), $games->getTotalFiletypesByGameId($game->ID_GAME), MainHelper::site_url('admin/companies/edit/' . $game->ID_GAME . '/downloadtabs/page'), Doo::conf()->adminGamesLimit);

        $list['game'] = $games->getGameByID($this->params['game_id']);
        $list['gameMedia'] = $games->getMedias($game->ID_GAME);
        $list['gameDownloads'] = $games->getDownloadsByGameId($game->ID_GAME);
        $list['gameDownloadTabs'] = $games->getFiletypes($game->ID_GAME);
        $list['gameTypes'] = $games->getTypes();

        $data['title'] = $this->__('All Filetypes');
        $data['body_class'] = 'index_filetypes';
        $data['selected_menu'] = 'games';
        $data['left'] = $this->renderBlock('games/common/leftColumn', $list);
        $data['right'] = $this->renderBlock('games/common/rightColumn', $list);
        $data['content'] = $this->renderBlock('games/allFiletypes', $list);
        $data['header'] = $this->getMenu();
        $this->render3Cols($data);
    }

    public function addFiletype() {
        $player = User::getUser();
        $games = new Games();
        $game = $games->getGameByID($this->params['game_id']);
        if (!$game || $player->canAccess('Edit game information') === FALSE) {
            DooUriRouter::redirect(MainHelper::site_url('admin'));
        }

        if (isset($_POST) and !empty($_POST)) {
            $filetype = $games->saveDownloadTab($game, $_POST);
            if ($filetype) {
                DooUriRouter::redirect(MainHelper::site_url('admin/games/edit/' . $game->ID_GAME));
            }
        }
        $list = array();

        $list['game'] = $game;
        $list['gameMedia'] = $games->getMedias($game->ID_GAME);
        $list['gameDownloads'] = $games->getDownloadsByGameId($game->ID_GAME);
        $list['gameDownloadTabs'] = $games->getFiletypes($game->ID_GAME);
        $list['gameTypes'] = $games->getTypes();
        $list['function'] = 'add';

        $data['title'] = $this->__('New Filetype');
        $data['body_class'] = 'index_filetypes';
        $data['selected_menu'] = 'games';
        $data['left'] = $this->renderBlock('games/common/leftColumn', $list);
        $data['right'] = $this->renderBlock('games/common/rightColumn', $list);
        $data['content'] = $this->renderBlock('games/addEditFiletypes', $list);
        $data['header'] = $this->getMenu();
        $this->render3Cols($data);
    }

    public function editFiletype() {
        $player = User::getUser();
        $games = new Games();
        $game = $games->getGameByID($this->params['game_id']);
        $filetype = $games->getDownloadTab($this->params['tab_id']);
        if (!$game || !$filetype || $player->canAccess('Edit game information') === FALSE) {
            DooUriRouter::redirect(MainHelper::site_url('admin'));
        }

        if (isset($_POST) and !empty($_POST)) {
            $filetype = $games->saveDownloadTab($game, $_POST);
            if ($filetype) {
                DooUriRouter::redirect(MainHelper::site_url('admin/games/edit/' . $game->ID_GAME));
            }
        }
        $list = array();

        $list['filetypeItem'] = $filetype;
        $list['game'] = $game;
        $list['gameMedia'] = $games->getMedias($game->ID_GAME);
        $list['gameDownloads'] = $games->getDownloadsByGameId($game->ID_GAME);
        $list['gameDownloadTabs'] = $games->getFiletypes($game->ID_GAME);
        $list['gameTypes'] = $games->getTypes();
        $list['function'] = 'edit';

        $data['title'] = $this->__('Edit Filetype');
        $data['body_class'] = 'index_filetypes';
        $data['selected_menu'] = 'games';
        $data['left'] = $this->renderBlock('games/common/leftColumn', $list);
        $data['right'] = $this->renderBlock('games/common/rightColumn', $list);
        $data['content'] = $this->renderBlock('games/addEditFiletypes', $list);
        $data['header'] = $this->getMenu();
        $this->render3Cols($data);
    }

    public function deleteFiletype() {
        $player = User::getUser();
        $games = new Games();
        $game = $games->getGameByID($this->params['game_id']);
        $filetype = $games->getDownloadTab($this->params['tab_id']);
        if (!$game || !$filetype || $player->canAccess('Edit game information') === FALSE) {
            DooUriRouter::redirect(MainHelper::site_url('admin'));
        } else {
            $result = $games->deleteDownloadTab($filetype->ID_FILETYPE);
            if ($result === TRUE) {
                DooUriRouter::redirect(MainHelper::site_url('admin/games/edit/' . $game->ID_GAME . '/downloadtabs'));
            }
        }
    }

    public function allDownloads() {
        $player = User::getUser();
        $games = new Games();
        $game = $games->getGameByID($this->params['game_id']);
        if (!$game || $player->canAccess('Edit game information') === FALSE) {
            DooUriRouter::redirect(MainHelper::site_url('admin'));
        }


        $list = array();
        $pager = $this->appendPagination($list, new stdClass(), $games->getTotalDownloadsByGameId($game->ID_GAME), MainHelper::site_url('admin/companies/edit/' . $game->ID_GAME . '/downloads/page'), Doo::conf()->adminGamesLimit);

        $list['game'] = $games->getGameByID($this->params['game_id']);
        $list['gameMedia'] = $games->getMedias($game->ID_GAME);
        $list['gameDownloads'] = $games->getDownloadsByGameId($game->ID_GAME);
        $list['gameDownloadTabs'] = $games->getFiletypes($game->ID_GAME);
        $list['gameTypes'] = $games->getTypes();

        $data['title'] = $this->__('All Downloads');
        $data['body_class'] = 'index_downloads';
        $data['selected_menu'] = 'games';
        $data['left'] = $this->renderBlock('games/common/leftColumn', $list);
        $data['right'] = $this->renderBlock('games/common/rightColumn', $list);
        $data['content'] = $this->renderBlock('games/allDownloads', $list);
        $data['header'] = $this->getMenu();
        $this->render3Cols($data);
    }

    public function addDownload() {
        $player = User::getUser();
        $games = new Games();
        $game = $games->getGameByID($this->params['game_id']);
        if (!$game || $player->canAccess('Edit game information') === FALSE) {
            DooUriRouter::redirect(MainHelper::site_url('admin'));
        }

        if (isset($_POST) and !empty($_POST)) {
            $download = $games->saveDownload($game, $_POST);
            if ($download) {
                DooUriRouter::redirect(MainHelper::site_url('admin/games/edit/' . $game->ID_GAME));
            }
        }
        $list = array();

        $list['game'] = $game;
        $list['gameMedia'] = $games->getMedias($game->ID_GAME);
        $list['gameDownloads'] = $games->getDownloadsByGameId($game->ID_GAME);
        $list['gameDownloadTabs'] = $games->getFiletypes($game->ID_GAME);
        $list['gameTypes'] = $games->getTypes();
        $list['function'] = 'add';

        $data['title'] = $this->__('New Download');
        $data['body_class'] = 'index_downloads';
        $data['selected_menu'] = 'games';
        $data['left'] = $this->renderBlock('games/common/leftColumn', $list);
        $data['right'] = $this->renderBlock('games/common/rightColumn', $list);
        $data['content'] = $this->renderBlock('games/addEditDownloads', $list);
        $data['header'] = $this->getMenu();
        $this->render3Cols($data);
    }

    public function editDownload() {
        $player = User::getUser();
        $games = new Games();
        $game = $games->getGameByID($this->params['game_id']);
        $download = $games->getDownload($this->params['download_id']);
        if (!$game || !$download || $player->canAccess('Edit game information') === FALSE) {
            DooUriRouter::redirect(MainHelper::site_url('admin'));
        }

        if (isset($_POST) and !empty($_POST)) {
            $download = $games->saveDownload($game, $_POST);
            if ($download) {
                DooUriRouter::redirect(MainHelper::site_url('admin/games/edit/' . $game->ID_GAME));
            }
        }
        $list = array();

        $list['downloadItem'] = $download;
        $list['game'] = $game;
        $list['gameMedia'] = $games->getMedias($game->ID_GAME);
        $list['gameDownloads'] = $games->getDownloadsByGameId($game->ID_GAME);
        $list['gameDownloadTabs'] = $games->getFiletypes($game->ID_GAME);
        $list['gameTypes'] = $games->getTypes();
        $list['function'] = 'edit';

        $data['title'] = $this->__('Edit Download');
        $data['body_class'] = 'index_downloads';
        $data['selected_menu'] = 'games';
        $data['left'] = $this->renderBlock('games/common/leftColumn', $list);
        $data['right'] = $this->renderBlock('games/common/rightColumn', $list);
        $data['content'] = $this->renderBlock('games/addEditDownloads', $list);
        $data['header'] = $this->getMenu();
        $this->render3Cols($data);
    }

    public function deleteDownload() {
        $player = User::getUser();
        $games = new Games();
        $game = $games->getGameByID($this->params['game_id']);
        $download = $games->getDownload($this->params['download_id']);
        if (!$game || !$download || $player->canAccess('Edit game information') === FALSE) {
            DooUriRouter::redirect(MainHelper::site_url('admin'));
        } else {
            $result = $games->deleteDownload($download->ID_DOWNLOAD);
            if ($result === TRUE) {
                DooUriRouter::redirect(MainHelper::site_url('admin/games/edit/' . $game->ID_GAME . '/downloads'));
            }
        }
    }

}
