<?php
class ForumController extends SnController {

	private $data;
	private $forum;

	public function beforeRun($resource, $action) {

		parent::beforeRun($resource, $action);
		$this->data['type'] = !empty($this->params['type']) ? $this->params['type'] : 'game'; /* IF the type is not empty it selects the type, else it set it to be game*/ 
		$this->forum = new Forum;

		$this->addCrumb($this->__('Forum'), MainHelper::site_url('forum'));
		$this->data['user'] = User::getUser();
	}

	public function moduleOff()
	{
		$notAvailable = MainHelper::TrySetModuleNotAvailableByTag('forum');
		if ($notAvailable)
		{
			$list['infoBox'] = MainHelper::loadInfoBox('Forum', 'index', true);

			$data['title'] = $this->__('Forum');
			$data['body_class'] = 'index_forum_index forums';
			$data['selected_menu'] = 'forum';
			$data['left'] = PlayerHelper::playerLeftSide();
			$data['footer'] = MainHelper::bottomMenu();
			$data['header'] = MainHelper::topMenu();
			$data['right'] = PlayerHelper::playerRightSide();

			$data['content'] = $notAvailable;
			$this->render3Cols($data);
			exit;
		}
	}
	
	// overview total list of game/companies
	public function index() {
		$this->moduleOff();
        if(!Auth::isUserLogged()) { DooUriRouter::redirect(MainHelper::site_url('login/loginfirst')); };

        $params = $this->params;
        $search = isset($params['search']) ? urldecode($params['search']) : NULL;
        $type = $this->data['type'];
        $tmp = 'forum/' . $type . (empty($search) ? '' : '/search/'.urlencode($search)) . '/page';
        $url = MainHelper::site_url($tmp);

        $list['type'] = $this->data['type'];
        $list['searchText'] = $search;
        $list['searchTotal'] = $forumCount = $this->forum->getTotalType($type, $search);
        $pager = $this->appendPagination($list, NULL, $forumCount, $url, Doo::conf()->forumIndexLimit);
        $results = $this->forum->getIndex($type, $search, $pager->limit);
        $list['fields'] = $results['fields'];
        $list['model'] = $results['results'];
        $list['infoBox'] = MainHelper::loadInfoBox('Forum', 'index', TRUE);

        $data['title'] = $this->__('Forum');
        $data['body_class'] = 'index_forum_index forums';
        $data['selected_menu'] = 'forum';
        $data['left'] = PlayerHelper::playerLeftSide();
        $data['footer'] = MainHelper::bottomMenu();
        $data['header'] = MainHelper::topMenu();
        $data['right'] = PlayerHelper::playerRightSide();

        $data['content'] = $this->renderBlock('forum/forum_index', $list); // builds view forum_index
        $this->render3Cols($data);
	}

	public function forum() {

		switch ($this->data['type']) {
			case WALL_COMPANIES:
				$this->forumCompanies();
				break;
			case WALL_GAMES:
				$this->forumGames();
				break;
			case WALL_GROUPS:
				$this->forumGroups();
				break;
		}
	}

	private function forumCompanies() {
		$this->moduleOff();
		if(Auth::isUserLogged()){  
			$list['page'] = 'forum_forum';
			$data['body_class'] = 'index_forum_forum forums';

			$company = Forum::getModelByUrl('company', $this->params['id']);
			$name = $company->CompanyName;
			$data['title'] = $name;
			$this->addCrumb($name);
			
			$search = isset($this->params['search']) ? urldecode($this->params['search']) : NULL;
			$list['searchText'] = $search;

			$list['model'] = $company;
			
			$user = $this->data['user'];
			$list['user'] = $user;
			$list['isForumAdmin'] =  $company->isForumAdmin(); //just for the forum parts can be: isAdmin isForumAdmin 
			$list['isMember'] = $company->isMember();
			$list['isForumMod'] = $company-> isForumMod();

			$list['url'] = $this->params['id'];
			$list['categories'] = $this->forum->getForum($this->data['type'], $company->ID_COMPANY, FALSE, $search);
			$list['type'] = $this->data['type'];
			$list['ownerId'] = $company->ID_COMPANY;
			$list['crumb'] = $this->getCrumb();

			if($this->data['user']) {
				$this->forum->logVisitForum('company', $company->ID_COMPANY, $this->data['user']);
			};

			$list['bans'] = $this->forum->CheckBans($this->data['type'],  $company->ID_COMPANY);

			$allOnlineUsers = $this->forum->allOnlineUsers();
			$list['allOnlineUsers'] = $allOnlineUsers;
			$list['OnlineUsers'] = count($allOnlineUsers);

			$onlineMembers = 0;
			$onlineGuests = 0;
			foreach ($allOnlineUsers as $users) {
				$playerID = $users->ID_PLAYER;
				if($company->isMember($playerID) === true ){
					$onlineMembers ++; 

				}else{
					$onlineGuests ++; 
				}

			}

			$list['onlineGuests'] =$onlineGuests;
			$list['onlineMembers'] = $onlineMembers;
			$data['selected_menu'] = 'forum';
			$data['left'] = MainHelper::companiesLeftSide($company, 'forum');
			$data['right'] = PlayerHelper::playerRightSide();
			$data['footer'] = MainHelper::bottomMenu();
			$data['header'] = MainHelper::topMenu();

			$data['content'] = $this->renderBlock('forum/' . $list['page'], $list); // builds view - file: forum_forum
			$this->render3Cols($data);
		}else{
			DooUriRouter::redirect(MainHelper::site_url('login/loginfirst'));
		}
	}

	private function forumGames() {
		$this->moduleOff();
		if(Auth::isUserLogged()){ 
			$list['page'] = 'forum_forum';
			$data['body_class'] = 'index_forum_forum forums';

			$game = Forum::getModelByUrl('game', $this->params['id']);
			$name = $game->GameName;

			$data['title'] = $name;
			$this->addCrumb($name);
			
			$search = isset($this->params['search']) ? urldecode($this->params['search']) : NULL;
			$list['searchText'] = $search;

			$list['model'] = $game;
			
			$user = $this->data['user'];
			$list['user'] = $user;
			$list['isForumAdmin'] =  $game->isForumAdmin(); //just for the forum parts can be: isAdmin isForumAdmin 
			$list['isMember'] = $game->isMember();
			$list['isForumMod'] = $game-> isForumMod();
					
			$list['url'] = $this->params['id'];
			$list['categories'] = $this->forum->getForum($this->data['type'], $game->ID_GAME, FALSE, $search);
			$list['type'] = $this->data['type'];
			$list['ownerId'] = $game->ID_GAME;
			$list['crumb'] = $this->getCrumb();

			if($this->data['user']) {
				$this->forum->logVisitForum('game', $game->ID_GAME, $this->data['user']);
			}

			$list['bans'] = $this->forum->CheckBans($this->data['type'], $game->ID_GAME);

			$allOnlineUsers = $this->forum->allOnlineUsers();
			$list['allOnlineUsers'] = $allOnlineUsers;
			$list['OnlineUsers'] = count($allOnlineUsers);

			$onlineMembers = 0;
			$onlineGuests = 0;
			foreach ($allOnlineUsers as $users) {
				$playerID = $users->ID_PLAYER;
				if($game->isMember($playerID) === true ){
					$onlineMembers ++; 

				}else{
					$onlineGuests ++; 
				}

			}
			
			$list['onlineGuests'] =$onlineGuests;
			$list['onlineMembers'] = $onlineMembers;
			$data['selected_menu'] = 'forum';
			$data['left'] = MainHelper::gamesLeftSide($game, 'forum');
			$data['right'] = PlayerHelper::playerRightSide();
			$data['footer'] = MainHelper::bottomMenu();
			$data['header'] = MainHelper::topMenu();

			$data['content'] = $this->renderBlock('forum/' . $list['page'], $list);
			$this->render3Cols($data);
		}else{
			DooUriRouter::redirect(MainHelper::site_url('login/loginfirst'));
		}
	}

	private function forumGroups() {
		$this->moduleOff();
		if(Auth::isUserLogged()){ 
			$list['page'] = 'forum_forum';
			$data['body_class'] = 'index_forum_forum forums';

			$group = Forum::getModelByUrl('group', $this->params['id']);
			$name = $group->GroupName;
			$list['model'] = $group;

			$data['title'] = $name;
			$this->addCrumb($name);
			
			$search = isset($this->params['search']) ? urldecode($this->params['search']) : NULL;
			$list['searchText'] = $search;

			$user = $this->data['user'];
			$list['user'] = $user;
			$list['isForumAdmin'] =  $group->isForumAdmin(); //just for the forum parts can be: isAdmin isForumAdmin isForumModerator 
			$list['isMember'] = $group->isMember();
			$list['isForumMod'] = $group-> isForumMod();
					
			$list['url'] = $this->params['id'];

			$list['categories'] = $this->forum->getForum($this->data['type'], $group->ID_GROUP, FALSE, $search);
			$list['type'] = $this->data['type'];
			$list['ownerId'] = $group->ID_GROUP;
			$list['crumb'] = $this->getCrumb();

			if($this->data['user']){
				$this->forum->logVisitForum('group', $group->ID_GROUP, $this->data['user']);
			}

			$list['bans'] = $this->forum->CheckBans($this->data['type'],  $group->ID_GROUP);
			$allOnlineUsers = $this->forum->allOnlineUsers();
			$list['allOnlineUsers'] = $allOnlineUsers;
			$list['OnlineUsers'] = count($allOnlineUsers);

			$onlineMembers = 0;
			$onlineGuests = 0;
			foreach ($allOnlineUsers as $users) {
				$playerID = $users->ID_PLAYER;
				if($group->isMember($playerID) === true ){
					$onlineMembers ++; 

				}else{
					$onlineGuests ++; 
				}
			}
			$list['onlineGuests'] = $onlineGuests;
			$list['onlineMembers'] = $onlineMembers;
			$data['selected_menu'] = 'forum';
			$data['left'] = MainHelper::groupsLeftSide($group, 'forum');
			$data['right'] = PlayerHelper::playerRightSide();
			$data['footer'] = MainHelper::bottomMenu();
			$data['header'] = MainHelper::topMenu();

			$data['content'] = $this->renderBlock('forum/' . $list['page'], $list);
			$this->render3Cols($data);
		}else{
			DooUriRouter::redirect(MainHelper::site_url('login/loginfirst'));
		}
	}

	public function board() {
		switch ($this->data['type']) {
			case WALL_COMPANIES:
				$this->boardCompanies();
				break;
			case WALL_GAMES:
				$this->boardGames();
				break;
			case WALL_GROUPS:
				$this->boardGroups();
				break;
		}
	}

	private function boardCompanies() {
		$this->moduleOff();
		if(Auth::isUserLogged()){ 
			$company = Forum::getModelByUrl('company', $this->params['id']);
			$name = $company->CompanyName;
			$list['model'] = $company;
			$list['url'] = $this->params['id'];
			
			$search = isset($this->params['search']) ? urldecode($this->params['search']) : NULL;
			$list['searchText'] = $search;

			$list['page'] = 'forum_board';
			$data['body_class'] = 'index_forum_board forums';

			$user = $this->data['user'];
			$list['user'] = $user;
			
			$list['isForumAdmin'] =  $company->isForumAdmin(); //just for the forum parts can be: isAdmin isForumAdmin  
			$list['isMember'] = $company->isMember();
			$list['isForumMod'] = $company->isForumMod();
					
			
			$this->addCrumb($name, $company->FORUM_URL);

			$topicCount = $this->forum->getTotalTopics($this->data['type'], $company->ID_COMPANY, $this->params['board']);
			$list['total'] = $topicCount;

			if ($topicCount > 0) {
				$pagerUrl = $company->FORUM_URL. '/' . $this->params['board'] . '/page';
				$pager = $this->appendPagination($list, null, $topicCount, $pagerUrl, Doo::conf()->forumTopicsLimit);
				$list['pager'] = $pager;
			}

			$list['sort'] = isset($this->params['sortType']) ? $this->params['sortType'] : 'recently-updated';

			if (isset($pager)) {
				$list['topics'] = $this->forum->getBoard($this->data['type'], $company->ID_COMPANY, $this->params['board'], $list['sort'], $search, $pager->limit);
			} else {
				$list['topics'] = $this->forum->getBoard($this->data['type'], $company->ID_COMPANY, $this->params['board'], $list['sort'], $search);
			}

			$list['board'] = $this->forum->getBoardInfo($this->data['type'], $company->ID_COMPANY, $this->params['board']);
			if ($list['board']) {
				if ($list['board']->ChildLevel > 0) {
					$parents = $list['board']->getParentBoards();

					if (count($parents) > 0) {
						for ($i = 0; $i < count($parents); $i++) {
							$this->addCrumb($parents[$i]->BoardName, $company->FORUM_URL.'/'.$parents[$i]->ID_BOARD);
						}
					}
				}
				$catId = $list['board']->ID_CAT;
				$list['category'] = $this->forum->getCategory($this->data['type'], $company->UNID, $catId); 
				$catname = $list['category']->CategoryName;

				$this->addCrumb($list['category']->CategoryName, $company->FORUM_URL . '/' . $this->params['board']);
				$this->addCrumb($list['board']->BoardName);
			
				$data['title'] = $list['board']->BoardName;

				if($this->data['user']){
					$this->forum->logVisitBoard('company', $company->ID_COMPANY, $this->params['board'], $this->data['user']);
				}
			} else {
				$data['title'] = '';
			}

			$allOnlineUsers = $this->forum->allOnlineUsers();
			$list['allOnlineUsers'] = $allOnlineUsers;
			$list['OnlineUsers'] = count($allOnlineUsers);

			$onlineMembers = 0;
			$onlineGuests = 0;
			foreach ($allOnlineUsers as $users) {
				$playerID = $users->ID_PLAYER;
				if($company->isMember($playerID) === true ){
					$onlineMembers ++; 

				}else{
					$onlineGuests ++; 
				}
			}

			$list['onlineGuests'] =$onlineGuests;
			$list['onlineMembers'] = $onlineMembers;

			$list['crumb'] = $this->getCrumb();
			$list['boardId'] = $this->params['board'];
			$list['ownerId'] = $company->ID_COMPANY;
			$list['type'] = $this->data['type'];

			$data['selected_menu'] = 'forum';
			$data['left'] = MainHelper::companiesLeftSide($company, 'forum');
			$data['right'] = PlayerHelper::playerRightSide();
			$data['footer'] = MainHelper::bottomMenu();
			$data['header'] = MainHelper::topMenu();

			$data['content'] = $this->renderBlock('forum/' . $list['page'], $list);
			$this->render3Cols($data);
		}else{
			DooUriRouter::redirect(MainHelper::site_url('login/loginfirst'));
		}
	}

	private function boardGames() {
		$this->moduleOff();
		if(Auth::isUserLogged()){
			$game = Forum::getModelByUrl('game', $this->params['id']);
			$name = $game->GameName;
			$list['model'] = $game;
			$list['url'] = $this->params['id'];
			
			$search = isset($this->params['search']) ? urldecode($this->params['search']) : NULL;
			$list['searchText'] = $search;

			$list['page'] = 'forum_board';
			$data['body_class'] = 'index_forum_board forums';

			$user = $this->data['user'];
			$list['user'] = $user;
			
			$list['isForumAdmin'] =  $game->isForumAdmin(); //just for the forum parts can be: isAdmin isForumAdmin  
			$list['isMember'] = $game->isMember();
			$list['isForumMod'] = $game->isForumMod();
					
			
			$this->addCrumb($name, $game->FORUM_URL);

			$topicCount = $this->forum->getTotalTopics($this->data['type'], $game->ID_GAME, $this->params['board']);
			$list['total'] = $topicCount;

			if ($topicCount > 0) {
				$pagerUrl = $game->FORUM_URL. '/' . $this->params['board'] . '/page';
				$pager = $this->appendPagination($list, NULL, $topicCount, $pagerUrl, Doo::conf()->forumTopicsLimit);
				$list['pager'] = $pager;
			}

			$list['sort'] = isset($this->params['sortType']) ? $this->params['sortType'] : 'recently-updated';

			if (isset($pager)) {
				$list['topics'] = $this->forum->getBoard($this->data['type'], $game->ID_GAME, $this->params['board'], $list['sort'], $search, $pager->limit);
			} else {
				$list['topics'] = $this->forum->getBoard($this->data['type'], $game->ID_GAME, $this->params['board'], $list['sort'], $search);
			}

			$list['board'] = $this->forum->getBoardInfo($this->data['type'], $game->ID_GAME, $this->params['board']);
			if ($list['board']) {
				if ($list['board']->ChildLevel > 0) {
					$parents = $list['board']->getParentBoards();

					if (count($parents) > 0) {
						for ($i = 0; $i < count($parents); $i++) {
							$this->addCrumb($parents[$i]->BoardName, $game->FORUM_URL.'/'.$parents[$i]->ID_BOARD);
						}
					}
				}
				$catId = $list['board']->ID_CAT;
				$list['category'] = $this->forum->getCategory($this->data['type'], $game->ID_GAME, $catId); 
				$catname = $list['category']->CategoryName;

				$this->addCrumb($list['category']->CategoryName, $game->FORUM_URL . '/' . $this->params['board']);
				$this->addCrumb($list['board']->BoardName);
			
				$data['title'] = $list['board']->BoardName;

				if($this->data['user']){
					$this->forum->logVisitBoard('game', $game->ID_GAME, $this->params['board'], $this->data['user']);
				}
			} else {
				$data['title'] = '';
			}

			$allOnlineUsers = $this->forum->allOnlineUsers();
			$list['allOnlineUsers'] = $allOnlineUsers;
			$list['OnlineUsers'] = count($allOnlineUsers);

			$onlineMembers = 0;
			$onlineGuests = 0;
			foreach ($allOnlineUsers as $users) {
				$playerID = $users->ID_PLAYER;
				if($game->isMember($playerID) === true ){
					$onlineMembers ++; 

				}else{
					$onlineGuests ++; 
				}
			}

			$list['onlineGuests'] =$onlineGuests;
			$list['onlineMembers'] = $onlineMembers;

			$list['crumb'] = $this->getCrumb();
			$list['boardId'] = $this->params['board'];
			$list['ownerId'] = $game->ID_GAME;
			$list['type'] = $this->data['type'];

			$data['selected_menu'] = 'forum';
			$data['left'] = MainHelper::gamesLeftSide($game, 'forum');
			$data['right'] = PlayerHelper::playerRightSide();
			$data['footer'] = MainHelper::bottomMenu();
			$data['header'] = MainHelper::topMenu();

			$data['content'] = $this->renderBlock('forum/' . $list['page'], $list);
			$this->render3Cols($data);
		}else{
			DooUriRouter::redirect(MainHelper::site_url('login/loginfirst'));
		}
	}

	private function boardGroups() {
		$this->moduleOff();
		if(Auth::isUserLogged()){
			$GROUP = Forum::getModelByUrl('group', $this->params['id']);
			$name = $GROUP->GroupName;
			$list['model'] = $GROUP;
			$list['url'] = $this->params['id'];
			
			$search = isset($this->params['search']) ? urldecode($this->params['search']) : NULL;
			$list['searchText'] = $search;

			$list['page'] = 'forum_board';
			$data['body_class'] = 'index_forum_board forums';

			$user = $this->data['user'];
			$list['user'] = $user;
			if (isset($user) && $user == true) {
					$list['isForumAdmin'] =  $GROUP->isForumAdmin(); //just for the forum parts can be: isAdmin isForumAdmin isForumModerator 
					$list['isMember'] = $GROUP->isMember();
					$list['isForumMod'] = $GROUP->isForumMod();
					
			} else {
				$list['isForumAdmin'] = FALSE; //just for the forum parts can be: isAdmin isForumAdmin isForumModerator 
				$list['isMember'] =  FALSE;
				$list['isForumMod'] = FALSE;
				
			}

			$this->addCrumb($name, $GROUP->FORUM_URL);

			$topicCount = $this->forum->getTotalTopics($this->data['type'], $GROUP->ID_GROUP, $this->params['board']);
			$list['total'] = $topicCount;

			if ($topicCount > 0) {
				$pagerUrl = $GROUP->FORUM_URL. '/' . $this->params['board'] . '/page';
				$pager = $this->appendPagination($list, null, $topicCount, $pagerUrl, Doo::conf()->forumTopicsLimit);
				$list['pager'] = $pager;
			}

			$list['sort'] = isset($this->params['sortType']) ? $this->params['sortType'] : 'recently-updated';

			if (isset($pager)) {
				$list['topics'] = $this->forum->getBoard($this->data['type'], $GROUP->ID_GROUP, $this->params['board'], $list['sort'], $search, $pager->limit);
			} else {
				$list['topics'] = $this->forum->getBoard($this->data['type'], $GROUP->ID_GROUP, $this->params['board'], $list['sort'], $search);
			}

			$list['board'] = $this->forum->getBoardInfo($this->data['type'], $GROUP->ID_GROUP, $this->params['board']);
			if ($list['board']) {
				if ($list['board']->ChildLevel > 0) {
					$parents = $list['board']->getParentBoards();

					if (count($parents) > 0) {
						for ($i = 0; $i < count($parents); $i++) {
							$this->addCrumb($parents[$i]->BoardName, $GROUP->FORUM_URL.'/'.$parents[$i]->ID_BOARD);
						}
					}
				}
				$catId = $list['board']->ID_CAT;
				$list['category'] = $this->forum->getCategory($this->data['type'], $GROUP->ID_GROUP, $catId); 
				$catname = $list['category']->CategoryName;

				$this->addCrumb($list['category']->CategoryName, $GROUP->FORUM_URL . '/' . $this->params['board']);
				$this->addCrumb($list['board']->BoardName);
			
				$data['title'] = $list['board']->BoardName;

				if($this->data['user']){
					$this->forum->logVisitBoard('GROUP', $GROUP->ID_GROUP, $this->params['board'], $this->data['user']);
				}
			} else {
				$data['title'] = '';
			}

			$allOnlineUsers = $this->forum->allOnlineUsers();
			$list['allOnlineUsers'] = $allOnlineUsers;
			$list['OnlineUsers'] = count($allOnlineUsers);

			$onlineMembers = 0;
			$onlineGuests = 0;
			foreach ($allOnlineUsers as $user) {
				$playerID = $user->ID_PLAYER;
				if($GROUP->isMember($playerID) === true ){
					$onlineMembers ++; 

				}else{
					$onlineGuests ++; 
				}
			}

			$list['onlineGuests'] =$onlineGuests;
			$list['onlineMembers'] = $onlineMembers;

			$list['crumb'] = $this->getCrumb();
			$list['boardId'] = $this->params['board'];
			$list['ownerId'] = $GROUP->ID_GROUP;
			$list['type'] = $this->data['type'];

			$data['selected_menu'] = 'forum';
			$data['left'] = MainHelper::groupsLeftSide($GROUP, 'forum');
			$data['right'] = PlayerHelper::playerRightSide();
			$data['footer'] = MainHelper::bottomMenu();
			$data['header'] = MainHelper::topMenu();

			$data['content'] = $this->renderBlock('forum/' . $list['page'], $list);
			$this->render3Cols($data);
		}else{
			DooUriRouter::redirect(MainHelper::site_url('login/loginfirst'));
		}
	}


	// ok
	public function selectCreateForm(){
		if(Auth::isUserLogged()){
			$model = Forum::getModelByUrl($this->data['type'], $this->params['id']);
			$name = $model->UNNAME;

			if ($model->isMember()) {
				$list['type'] = $this->data['type'];
				$list['url'] = $this->params['id'];
				$list['id'] = $model->UNID;
				$list['board'] = $this->params['board'];

				echo $this->renderBlock('forum/common/selectCreateFormType', $list);
			} else {
				DooUriRouter::redirect($model->FORUM_URL);
			}
		}else{
			DooUriRouter::redirect(MainHelper::site_url('login/loginfirst'));
		}
	}

	//ok
	public function CreateForm(){
		if(Auth::isUserLogged()){
			$model = Forum::getModelByUrl($this->data['type'], $this->params['id']);
			$user = $this->data['user'];
			
			if($model->isMember() ) {
				
				$data['body_class'] = 'index_forum_create_topic forums';

				$list['user'] = $user;
								
				$list['board'] = $this->forum->getBoardInfo($this->data['type'], $model->UNID, $this->params['board']);
				
				$selected = $_POST['threadtype'];
				
				if( $selected == "thread"){
					$list['page'] = 'showCreateThread';
					$data['title'] = $this->__('Create Thread');
				}else{
					$list['page'] = 'showCreatePoll';
					$data['title'] = $this->__('Create Poll');
				}
				
				$this->addCrumb($model->UNNAME, $model->FORUM_URL);

				$this->addCrumb($list['board']->BoardName, $model->FORUM_URL . '/' . $this->params['board']);

				$this->addCrumb($data['title']);

				if($this->data['type'] =='company'){
					$data['left'] = MainHelper::companiesLeftSide($model, 'forum');
				}elseif ($this->data['type'] =='game') {				
					$data['left'] = MainHelper::gamesLeftSide($model, 'forum');
				}elseif ($this->data['type'] == 'group') {				
					$data['left'] = MainHelper::groupsLeftSide($model, 'forum');
				}

				$list['player'] = $this->data['user'];
				$list['crumb'] = $this->getCrumb();
				$list['type'] = $this->data['type'];
				$list['url'] = $this->params['id'];

				$data['selected_menu'] = 'forum';
				$data['right'] = PlayerHelper::playerRightSide();
				$data['footer'] = MainHelper::bottomMenu();
				$data['header'] = MainHelper::topMenu();

				$data['content'] = $this->renderBlock('forum/common/' . $list['page'], $list);
				$this->render3Cols($data);
			} else {
				DooUriRouter::redirect($model->FORUM_URL . '/' . $this->params['board']);
			}
		}else{
			DooUriRouter::redirect(MainHelper::site_url('login/loginfirst'));
		}
	}

	public function topic() {
		switch ($this->data['type']) {
			case WALL_COMPANIES:
				$this->topicCompanies();
				break;
			case WALL_GAMES:
				$this->topicGames();
				break;
			case WALL_GROUPS:
				$this->topicGroups();
				break;
		}
	}

	private function topicCompanies() {
		$this->moduleOff();
		if(Auth::isUserLogged()){
			$company = Forum::getModelByUrl('company', $this->params['id']);
			$name = $company->CompanyName;

			$list['model'] = $company;
			$list['page'] = 'forum_topic';
			$data['body_class'] = 'index_forum_topic forums';


			$user = $this->data['user'];
			$list['user'] = $user;
			$list['isForumAdmin'] =  $company->isForumAdmin(); //just for the forum parts can be: isAdmin isForumAdmin 
			$list['isMember'] = $company->isMember();
			$list['isForumMod'] = $company-> isForumMod();
			$list['isBoardMod'] = $company->isBoardMod($this->data['type'], $company->UNID, $this->params['board'], $user->ID_PLAYER);
					
			$list['url'] = $this->params['id'];
			
			$this->forum->addViewCount($this->data['type'], $company->ID_COMPANY, $this->params['topic']);

			$messagesCount = $this->forum->getTotalMessages($this->data['type'], $company->ID_COMPANY, $this->params['topic']);
			$pagerUrl = $company->FORUM_URL . '/' . $this->params['board'] . '/' . $this->params['topic'] . '/page';
			$pager = $this->appendPagination($list, null, $messagesCount, $pagerUrl, Doo::conf()->forumMessagesLimit);
			
			$list['pager'] = $pager;
			$list['total'] = $messagesCount;
			$list['boardInfo'] = $this->forum->getBoardInfo($this->data['type'], $company->ID_COMPANY, $this->params['board']);

			$list['messages'] = $this->forum->getTopic($this->data['type'], $company->ID_COMPANY, $this->params['topic'], $pager->limit);
			$list['topicId'] = $this->params['topic'];
			$list['topic'] = $this->forum->getTopicById($this->data['type'], $company->ID_COMPANY, $this->params['topic']);
			
			// get poll info
			$topic = $list['topic'];
			$poll_id = $topic->ID_POLL;
			
			$current_date = getdate();
			$day = $current_date['mday'];
			$month = $current_date['mon'];
			$year = $current_date['year'];

			$hour = $current_date['hours'];
			$min = $current_date['minutes'];
			$sec = $current_date['seconds']; 
			
			$timestamp =  mktime($hour,$min,$sec,$month,$day,$year);

			$list['servertime'] = $timestamp;

			if($poll_id >  0){
				if(isset($this->params['poll'])){
					$list['pollid'] = $this->params['poll'];
					if($this->data['user'] == true){
						$list['Poll_choices'] = $this->forum->getPollChoices($this->data['type'], $company->ID_COMPANY, $poll_id);
						$Poll_choices = $list['Poll_choices'];
						$pollbase = $this->forum->getPollbase($this->data['type'], $company->ID_COMPANY, $poll_id );
						$list['ExpireTime'] = $pollbase->ExpireTime;
						$list['playerVoted'] = $this->forum->checkIfVoted($this->data['type'], $company->ID_COMPANY, $poll_id, $this->data['user']->ID_PLAYER);
						$list['getplayervote'] = $this->forum-> getPlayersVotes($this->data['type'], $company->ID_COMPANY, $poll_id, $this->data['user']->ID_PLAYER );
						$list['totalvotes'] = $this->countTotalVotes($Poll_choices);
					}else{
						$list['Poll_choices'] = "";
						$list['ExpireTime'] = "";
						$list['playerVoted'] = "";
						$list['getplayervote'] =  "";
						$list['totalvotes'] = "";
					}
				}else{
					$list['Poll_choices'] = "";
					$list['ExpireTime'] = "";
					$list['pollid'] = "";
					$list['playerVoted'] = "";
					$list['getplayervote'] =  "";
					$list['totalvotes'] = "";
				}
			}else{
				$list['Poll_choices'] = "";
				$list['ExpireTime'] = "";
				$list['pollid'] = "";
				$list['playerVoted'] =  "";
				$list['getplayervote'] =  "";
				$list['totalvotes'] = "";
			}

			$catId = $list['boardInfo']->ID_CAT;
			$list['category'] = $this->forum->getCategory($this->data['type'], $company->ID_COMPANY, $catId); 

			$this->addCrumb($name, $company->FORUM_URL);
			$this->addCrumb($list['category']->CategoryName, $company->FORUM_URL . '/' . $this->params['board']);
			$this->addCrumb($list['boardInfo']->BoardName, $company->FORUM_URL . '/' . $this->params['board']);

			if (!empty($list['messages'])) {
				$this->addCrumb($list['topic']->TopicName);
			}

			$list['type'] = $this->data['type'];
			$list['ownerId'] = $company->ID_COMPANY;
			$list['crumb'] = $this->getCrumb();

			if (!empty($list['messages'])) {
				$data['title'] = $list['topic']->TopicName;
			} else {
				$data['title'] = 'Topic';
			}

			if($this->data['user']) {
				$this->forum->logVisitTopic('company', $company->ID_COMPANY, $this->params['topic'], $this->data['user']);
			}

			$allOnlineUsers = $this->forum->allOnlineUsers();
			$list['allOnlineUsers'] = $allOnlineUsers;
			$list['OnlineUsers'] = count($allOnlineUsers);

			$onlineMembers = 0;
			$onlineGuests = 0;
			foreach ($allOnlineUsers as $user) {
				$playerID = $user->ID_PLAYER;
				if($company->isMember($playerID) === true ){
					$onlineMembers ++; 

				}else{
					$onlineGuests ++; 
				}
			}

			$list['onlineGuests'] = $onlineGuests;
			$list['onlineMembers'] = $onlineMembers;
			$data['selected_menu'] = 'forum';
			$data['left'] = MainHelper::companiesLeftSide($company, 'forum');
			$data['right'] = PlayerHelper::playerRightSide();
			$data['footer'] = MainHelper::bottomMenu();
			$data['header'] = MainHelper::topMenu();

			$data['content'] = $this->renderBlock('forum/' . $list['page'], $list);
			$this->render3Cols($data);
		}else{
			DooUriRouter::redirect(MainHelper::site_url('login/loginfirst'));
		}
	}

	
	private function topicGames() {
		$this->moduleOff();
		if(Auth::isUserLogged()){
			$game = Forum::getModelByUrl('game', $this->params['id']);
			$name = $game->GameName;

			$list['model'] = $game;
			$list['page'] = 'forum_topic';
			$data['body_class'] = 'index_forum_topic forums';


			$user = $this->data['user'];
			$list['user'] = $user;
			$list['isForumAdmin'] =  $game->isForumAdmin(); //just for the forum parts can be: isAdmin isForumAdmin 
			$list['isMember'] = $game->isMember();
			$list['isForumMod'] = $game-> isForumMod();
			$list['isBoardMod'] = $game->isBoardMod($this->data['type'], $game->UNID, $this->params['board'], $user->ID_PLAYER);
					
			$list['url'] = $this->params['id'];
			
			$this->forum->addViewCount($this->data['type'], $game->ID_GAME, $this->params['topic']);

			$messagesCount = $this->forum->getTotalMessages($this->data['type'], $game->ID_GAME, $this->params['topic']);
			$pagerUrl = $game->FORUM_URL . '/' . $this->params['board'] . '/' . $this->params['topic'] . '/page';
			$pager = $this->appendPagination($list, null, $messagesCount, $pagerUrl, Doo::conf()->forumMessagesLimit);
			
			$list['pager'] = $pager;
			$list['total'] = $messagesCount;
			$list['boardInfo'] = $this->forum->getBoardInfo($this->data['type'], $game->ID_GAME, $this->params['board']);

			$list['messages'] = $this->forum->getTopic($this->data['type'], $game->ID_GAME, $this->params['topic'], $pager->limit);
			$list['topicId'] = $this->params['topic'];
			$list['topic'] = $this->forum->getTopicById($this->data['type'], $game->ID_GAME, $this->params['topic']);
			
			// get poll info
			$topic = $list['topic'];
			$poll_id = $topic->ID_POLL;
			
			$current_date = getdate();
			$day = $current_date['mday'];
			$month = $current_date['mon'];
			$year = $current_date['year'];

			$hour = $current_date['hours'];
			$min = $current_date['minutes'];
			$sec = $current_date['seconds']; 
			
			$timestamp =  mktime($hour,$min,$sec,$month,$day,$year);

			$list['servertime'] = $timestamp;

			if($poll_id >  0){
				if(isset($this->params['poll'])){
					$list['pollid'] = $this->params['poll'];
					if($this->data['user'] == true){
						$list['Poll_choices'] = $this->forum->getPollChoices($this->data['type'], $game->ID_GAME, $poll_id);
						$Poll_choices = $list['Poll_choices'];
						$pollbase = $this->forum->getPollbase($this->data['type'],$game->ID_GAME, $poll_id );
						$list['ExpireTime'] = $pollbase->ExpireTime;
						$list['playerVoted'] = $this->forum->checkIfVoted($this->data['type'], $game->ID_GAME, $poll_id, $this->data['user']->ID_PLAYER);
						$list['getplayervote'] = $this->forum-> getPlayersVotes($this->data['type'], $game->ID_GAME, $poll_id, $this->data['user']->ID_PLAYER );
						$list['totalvotes'] = $this->countTotalVotes($Poll_choices);
					}else{
						$list['Poll_choices'] = "";
						$list['ExpireTime'] = "";
						$list['playerVoted'] = "";
						$list['getplayervote'] =  "";
						$list['totalvotes'] = "";
					}
				}else{
					$list['Poll_choices'] = "";
					$list['ExpireTime'] = "";
					$list['pollid'] = "";
					$list['playerVoted'] = "";
					$list['getplayervote'] =  "";
					$list['totalvotes'] = "";
				}
			}else{
				$list['Poll_choices'] = "";
				$list['ExpireTime'] = "";
				$list['pollid'] = "";
				$list['playerVoted'] =  "";
				$list['getplayervote'] =  "";
				$list['totalvotes'] = "";
			}

			$catId = $list['boardInfo']->ID_CAT;
			$list['category'] = $this->forum->getCategory($this->data['type'], $game->ID_GAME, $catId); 

			$this->addCrumb($name, $game->FORUM_URL);
			$this->addCrumb($list['category']->CategoryName, $game->FORUM_URL . '/' . $this->params['board']);
			$this->addCrumb($list['boardInfo']->BoardName, $game->FORUM_URL . '/' . $this->params['board']);

			if (!empty($list['messages'])) {
				$this->addCrumb($list['topic']->TopicName);
			}

			$list['type'] = $this->data['type'];
			$list['ownerId'] = $game->ID_GAME;
			$list['crumb'] = $this->getCrumb();

			if (!empty($list['messages'])) {
				$data['title'] = $list['topic']->TopicName;
			} else {
				$data['title'] = 'Topic';
			}

			if($this->data['user']) {
				$this->forum->logVisitTopic('game', $game->ID_GAME, $this->params['topic'], $this->data['user']);
			}

			$allOnlineUsers = $this->forum->allOnlineUsers();
			$list['allOnlineUsers'] = $allOnlineUsers;
			$list['OnlineUsers'] = count($allOnlineUsers);

			$onlineMembers = 0;
			$onlineGuests = 0;
			foreach ($allOnlineUsers as $user) {
				$playerID = $user->ID_PLAYER;
				if($game->isMember($playerID) === true ){
					$onlineMembers ++; 

				}else{
					$onlineGuests ++; 
				}
			}

			$list['onlineGuests'] = $onlineGuests;
			$list['onlineMembers'] = $onlineMembers;
			$data['selected_menu'] = 'forum';
			$data['left'] = MainHelper::gamesLeftSide($game, 'forum');
			$data['right'] = PlayerHelper::playerRightSide();
			$data['footer'] = MainHelper::bottomMenu();
			$data['header'] = MainHelper::topMenu();

			$data['content'] = $this->renderBlock('forum/' . $list['page'], $list);
			$this->render3Cols($data);
		}else{
			DooUriRouter::redirect(MainHelper::site_url('login/loginfirst'));
		}
	}

	private function topicGroups() {
		$this->moduleOff();
		if(Auth::isUserLogged()){
			$group = Forum::getModelByUrl('group', $this->params['id']);
			$name = $group->GroupName;

			$list['model'] = $group;
			$list['page'] = 'forum_topic';
			$data['body_class'] = 'index_forum_topic forums';


			$user = $this->data['user'];
			$list['user'] = $user;
			$list['isForumAdmin'] =  $group->isForumAdmin(); //just for the forum parts can be: isAdmin isForumAdmin 
			$list['isMember'] = $group->isMember();
			$list['isForumMod'] = $group-> isForumMod();
			$list['isBoardMod'] = $group->isBoardMod($this->data['type'], $group->UNID, $this->params['board'], $user->ID_PLAYER);
					
			$list['url'] = $this->params['id'];
			
			$this->forum->addViewCount($this->data['type'], $group->ID_GROUP, $this->params['topic']);

			$messagesCount = $this->forum->getTotalMessages($this->data['type'], $group->ID_GROUP, $this->params['topic']);
			$pagerUrl = $group->FORUM_URL . '/' . $this->params['board'] . '/' . $this->params['topic'] . '/page';
			$pager = $this->appendPagination($list, null, $messagesCount, $pagerUrl, Doo::conf()->forumMessagesLimit);
			
			$list['pager'] = $pager;
			$list['total'] = $messagesCount;
			$list['boardInfo'] = $this->forum->getBoardInfo($this->data['type'], $group->ID_GROUP, $this->params['board']);

			$list['messages'] = $this->forum->getTopic($this->data['type'], $group->ID_GROUP, $this->params['topic'], $pager->limit);
			$list['topicId'] = $this->params['topic'];
			$list['topic'] = $this->forum->getTopicById($this->data['type'], $group->ID_GROUP, $this->params['topic']);
			
			// get poll info
			$topic = $list['topic'];
			$poll_id = $topic->ID_POLL;
			
			$current_date = getdate();
			$day = $current_date['mday'];
			$month = $current_date['mon'];
			$year = $current_date['year'];

			$hour = $current_date['hours'];
			$min = $current_date['minutes'];
			$sec = $current_date['seconds']; 
			
			$timestamp =  mktime($hour,$min,$sec,$month,$day,$year);

			$list['servertime'] = $timestamp;

			if($poll_id >  0){
				if(isset($this->params['poll'])){
					$list['pollid'] = $this->params['poll'];
					if($this->data['user'] == true){
						$list['Poll_choices'] = $this->forum->getPollChoices($this->data['type'], $group->ID_GROUP, $poll_id);
						$Poll_choices = $list['Poll_choices'];
						$pollbase = $this->forum->getPollbase($this->data['type'], $group->ID_GROUP, $poll_id );
						$list['ExpireTime'] = $pollbase->ExpireTime;
						$list['playerVoted'] = $this->forum->checkIfVoted($this->data['type'], $group->ID_GROUP, $poll_id, $this->data['user']->ID_PLAYER);
						$list['getplayervote'] = $this->forum-> getPlayersVotes($this->data['type'], $group->ID_GROUP, $poll_id, $this->data['user']->ID_PLAYER );
						$list['totalvotes'] = $this->countTotalVotes($Poll_choices);
					}else{
						$list['Poll_choices'] = "";
						$list['ExpireTime'] = "";
						$list['playerVoted'] = "";
						$list['getplayervote'] =  "";
						$list['totalvotes'] = "";
					}
				}else{
					$list['Poll_choices'] = "";
					$list['ExpireTime'] = "";
					$list['pollid'] = "";
					$list['playerVoted'] = "";
					$list['getplayervote'] =  "";
					$list['totalvotes'] = "";
				}
			}else{
				$list['Poll_choices'] = "";
				$list['ExpireTime'] = "";
				$list['pollid'] = "";
				$list['playerVoted'] =  "";
				$list['getplayervote'] =  "";
				$list['totalvotes'] = "";
			}

			$catId = $list['boardInfo']->ID_CAT;
			$list['category'] = $this->forum->getCategory($this->data['type'], $group->ID_GROUP, $catId); 

			$this->addCrumb($name, $group->FORUM_URL);
			$this->addCrumb($list['category']->CategoryName, $group->FORUM_URL . '/' . $this->params['board']);
			$this->addCrumb($list['boardInfo']->BoardName, $group->FORUM_URL . '/' . $this->params['board']);

			if (!empty($list['messages'])) {
				$this->addCrumb($list['topic']->TopicName);
			}

			$list['type'] = $this->data['type'];
			$list['ownerId'] = $group->ID_GROUP;
			$list['crumb'] = $this->getCrumb();

			if (!empty($list['messages'])) {
				$data['title'] = $list['topic']->TopicName;
			} else {
				$data['title'] = 'Topic';
			}

			if($this->data['user']) {
				$this->forum->logVisitTopic('group', $group->ID_GROUP, $this->params['topic'], $this->data['user']);
			}

			$allOnlineUsers = $this->forum->allOnlineUsers();
			$list['allOnlineUsers'] = $allOnlineUsers;
			$list['OnlineUsers'] = count($allOnlineUsers);

			$onlineMembers = 0;
			$onlineGuests = 0;
			foreach ($allOnlineUsers as $user) {
				$playerID = $user->ID_PLAYER;
				if($group->isMember($playerID) === true ){
					$onlineMembers ++; 

				}else{
					$onlineGuests ++; 
				}
			}

			$list['onlineGuests'] = $onlineGuests;
			$list['onlineMembers'] = $onlineMembers;
			$data['selected_menu'] = 'forum';
			$data['left'] = MainHelper::groupsLeftSide($group, 'forum');
			$data['right'] = PlayerHelper::playerRightSide();
			$data['footer'] = MainHelper::bottomMenu();
			$data['header'] = MainHelper::topMenu();

			$data['content'] = $this->renderBlock('forum/' . $list['page'], $list);
			$this->render3Cols($data);
		}else{
			DooUriRouter::redirect(MainHelper::site_url('login/loginfirst'));
		}
	}
		
	
	//ok
	public function createCategory() {
		if(Auth::isUserLogged()){
			$model = Forum::getModelByUrl($this->data['type'], $this->params['id']);
			$name = $model->UNNAME;

			if ($model->isForumAdmin() or $model->isForumMod() ) {
				$list['type'] = $this->data['type'];
				$list['id'] = $model->UNID;

				echo $this->renderBlock('forum/admin/addCategory', $list);
			} else {
				DooUriRouter::redirect($model->FORUM_URL);
			}
		}else{
			DooUriRouter::redirect(MainHelper::site_url('login/loginfirst'));
		}
	}

	//ok
	public function editCategory() {
		if(Auth::isUserLogged()){
			$model = Forum::getModelByUrl($this->data['type'], $this->params['id']);
			$name = $model->UNNAME;

			if ($model->isForumAdmin() or $model->isForumMod()) {
				$forum = new Forum();
				$list['type'] = $this->data['type'];		
				$list['id'] = $model->UNID;
				$list['category'] = $forum->getCategory($this->data['type'], $model->UNID, $this->params['cat_id']);

				echo $this->renderBlock('forum/admin/editCategory', $list);
			} else {
				DooUriRouter::redirect($model->FORUM_URL);
			}
		}else{
			DooUriRouter::redirect(MainHelper::site_url('login/loginfirst'));
		}
	}

	//ok
	public function saveCategory(){
		if(Auth::isUserLogged()){
			if ($this->isAjax()) {
				$input = filter_input_array(INPUT_POST);
				if(!empty($input) && !empty($input['type']) && !empty($input['id']) ){
					$model = Forum::getModelByID($input['type'], $input['id']);
					if ($model->isForumAdmin() or $model->isForumMod()) {
						$result['result'] = $this->forum->saveCategory($model, $input);
						$this->toJSON($result, true);
					}
				}
				else{
					$this->toJSON(array('result' => false), true);
				}
			}
		}else{
			DooUriRouter::redirect(MainHelper::site_url('login/loginfirst'));
		}
	}

	//ok
	public function createBoard() {
		if(Auth::isUserLogged()){
			$model = Forum::getModelByUrl($this->data['type'], $this->params['id']);
			if ($model->isForumAdmin() or $model->isForumMod()) {
				$list['type'] = $this->data['type'];
				$list['id'] = $model->UNID;
				$list['cat_id'] = $this->params['cat_id'];

				echo $this->renderBlock('forum/admin/addBoard', $list);
			} else {
				DooUriRouter::redirect($model->FORUM_URL);
			}
		}else{
			DooUriRouter::redirect(MainHelper::site_url('login/loginfirst'));
		}
	}
	
	//ok
	public function saveBoard(){
		if(Auth::isUserLogged()){
			if ($this->isAjax()) {
				$input = filter_input_array(INPUT_POST);
				if(!empty($input) && !empty($input['type']) && !empty($input['id']) ){
					$model = Forum::getModelByID($input['type'], $input['id']);
					if ($model->isForumAdmin() or $model->isForumMod() ) {
						$result['result'] = $this->forum->saveBoard($model, $input);
						$this->toJSON($result, true);
					}
				}
				else{
					$this->toJSON(array('result'=>false), true);
				}
			}
		}else{
			DooUriRouter::redirect(MainHelper::site_url('login/loginfirst'));
		}
	}

	//ok
	public function editBoard() {
		if(Auth::isUserLogged()){
			$model = Forum::getModelByUrl($this->data['type'], $this->params['id']);
			$name = $model->UNNAME;

			if ($model->isForumAdmin() or $model->isForumMod()) {
				$forum = new Forum();
				$list['type'] = $this->data['type'];
				$list['id'] = $model->UNID;
				$list['cat_id'] = $this->params['cat_id'];
				$list['board'] = $forum->getBoardByID($this->data['type'], $model->UNID, $this->params['board_id']);

				echo $this->renderBlock('forum/admin/editBoard', $list);
			} else {
				DooUriRouter::redirect($model->FORUM_URL);
			}
		}else{
			DooUriRouter::redirect(MainHelper::site_url('login/loginfirst'));
		}
	}
 
	//ok
	public function editBoardOrder(){
		if(Auth::isUserLogged()){
			$model = Forum::getModelByUrl($this->data['type'], $this->params['id']);
			$name = $model->UNNAME; // fx playnation
		 
			if ($model->isForumAdmin() or $model->isForumMod()) {
					$forum = new Forum();
					$list['type'] = $this->data['type']; // ex company
					$list['id'] = $model->UNID;  // 1
 					$list['cat_id'] = $this->params['cat_id'];
					$list['board_id'] = $this->params['board_id'];
					$list['board'] = $forum->getBoardByID($this->data['type'], $model->UNID, $this->params['board_id']);
				 
					echo $this->renderBlock('forum/admin/editBoardOrder', $list);		
			}else{
					DooUriRouter::redirect($model->FORUM_URL);
			}
		}else{
			DooUriRouter::redirect(MainHelper::site_url('login/loginfirst'));
		}
		
	}
	//ok
	public function deleteBoard() {
		if(Auth::isUserLogged()){
			$model = Forum::getModelByUrl($this->data['type'], $this->params['id']);
			if ($model->isForumAdmin() or $model->isForumMod()) {
				$forum = new Forum();
				$list['type'] = $this->data['type']; // ex company
				$list['name'] =  $this->params['id'];
				$list['id'] = $model->UNID;  // ex. 1
				$list['cat_id'] = $this->params['cat_id'];
				$list['board_id'] = $this->params['board_id'];
						
				echo $this->renderBlock('forum/admin/deleteBoard', $list);
			} else {
				DooUriRouter::redirect($model->FORUM_URL);
			}
		}else{
			DooUriRouter::redirect(MainHelper::site_url('login/loginfirst'));
		}
	}

	// ok
	public function ajaxMoveBoard(){
		if(Auth::isUserLogged()){
			if ($this->isAjax()) {		 
				$input = filter_input_array(INPUT_POST);
				if(!empty($input) && !empty($input['type']) && !empty($input['id'])&& !empty($input['cat_id'])&& !empty($input['board_id'])&& !empty($input['board_order']) ){
					$model = Forum::getModelByID($input['type'], $input['id']);
					if ($model->isForumAdmin() or $model->isForumMod()) {
						$result['result'] = $this->forum->moveBoardOrder($model, $input);
						$this->toJSON($result, true);
					}
				}
				else{
					$this->toJSON(array('result' => false), true);
				}
			}
		}else{
			DooUriRouter::redirect(MainHelper::site_url('login/loginfirst'));
		}
	}
	
	//ok
	public function ajaxCollapseCategory(){
		if(Auth::isUserLogged()){
			if ($this->isAjax()) {
				$success = false;
				$input = filter_input_array(INPUT_POST);
				if(!empty($input) && !empty($input['type']) && !empty($input['id'])&& !empty($input['cid'])){
					if($this->data['user'] != false){
						$success = $this->forum->collapseCategory($input['type'], $input['id'], $input['cid'], $this->data['user']);
					}
					else{
						$cookie = isset($_COOKIE['forum_collapse']) ? unserialize($_COOKIE['forum_collapse']) : array();

						$cookie[$input['type'].'-'.$input['id'].'-'.$input['cid']] = true;

						$success = setcookie('forum_collapse', serialize($cookie), time() + 60*60*24*100);
					}
				}

				if($success == true){
					$this->toJSON(array('result' => TRUE), true);
				} else{
					$this->toJSON(array('result' => FALSE), true);
				}
			}
		}else{
				DooUriRouter::redirect(MainHelper::site_url('login/loginfirst'));
		}
	}

	//ok
	public function ajaxExpandCategory(){
		if(Auth::isUserLogged()){
			if ($this->isAjax()) {
				$success = false;
				$boards = false;
				$input = filter_input_array(INPUT_POST);
				if(!empty($input) && !empty($input['type']) && !empty($input['id'])&& !empty($input['cid'])){
					
					if($this->data['user'] != false){
						$boards = $this->forum->expandCategory($input['type'], $input['id'], $input['cid'], $this->data['user']);
					}
					else{
						$cookie = isset($_COOKIE['forum_collapse']) ? unserialize($_COOKIE['forum_collapse']) : array();

						if(!empty($cookie)){
							$cookie[$input['type'].'-'.$input['id'].'-'.$input['cid']] = false;

							setcookie('forum_collapse', serialize($cookie), time() + 60*60*24*100);
						}

						$boards = $this->forum->getCategoryBoards($input['type'], $input['id'], $input['cid']);
					}


					if ($boards != false) {
						$data = '';
						$model = Forum::getModelByID($input['type'], $input['id']);

						$isAdmin = $model->isForumAdmin();


						if($model instanceof SnCompanies)
							$url = Url::getUrlById($model->ID_COMPANY, URL_COMPANY);
						elseif($model instanceof SnGames)
							$url = Url::getUrlById($model->ID_GAME, URL_GAME);
						elseif($model instanceof SnGroups)
							$url = Url::getUrlById($model->ID_GROUP, URL_GROUP);



							if(count($boards) > 0){
								
								$n = 0;
								foreach($boards as $b){
									$data .= $this->renderBlock('forum/common/boardItem',
										array('board' => $b,
											'model' => $model,
											'n' => $n,
											'ownerType' => $b->OwnerType, 'ownerID' => $model->UNID, 'isAdmin' => $isAdmin, 'url' => $url->URL
											));
									$n++;
								}
								
							}

						$success = true;
						$this->toJSON(array('result' => TRUE, 'data' => $data), true);
					}
				}

				if(!$success){
					$this->toJSON(array('result' => FALSE), true);
				}
			}
		}else{
				DooUriRouter::redirect(MainHelper::site_url('login/loginfirst'));
		}
	}

	//ok  - cat order
	public function editOrder() {
		if(Auth::isUserLogged()){
			$model = Forum::getModelByUrl($this->data['type'], $this->params['id']);
			$name = $model->UNNAME;
			if ($model->isForumAdmin() OR $model->isForumMod() ) {
				$forum = new Forum();
				$list['type'] = $this->data['type']; // ex company				
				$list['id'] = $model->UNID;  // ex. playnation
				$list['cat_id'] = $this->params['cat_id'];
				$list['category'] = $forum->getCategory($this->data['type'], $model->UNID, $this->params['cat_id']);
			
				echo $this->renderBlock('forum/admin/editCategoryOrder', $list);
			} else {
				DooUriRouter::redirect($model->FORUM_URL);
			}
		}else{
				DooUriRouter::redirect(MainHelper::site_url('login/loginfirst'));
		}
	}

	//ok
	public function ajaxMoveCategory(){
		if(Auth::isUserLogged()){
			if ($this->isAjax()) {
				$input = filter_input_array(INPUT_POST);
				if(!empty($input) && !empty($input['type']) && !empty($input['id'])&& !empty($input['cat_id'])&&  !empty($input['cat_order']) ){
					$model = Forum::getModelByID($input['type'], $input['id']);
					if ($model->isForumAdmin() OR $model->isForumMod() ) {
						$result['result'] = $this->forum->moveCat($model, $input);
						$this->toJSON($result, true);
					}
				}
				else{
					$this->toJSON(array('result' => false), true);
				}
			}
		}else{
				DooUriRouter::redirect(MainHelper::site_url('login/loginfirst'));
		}
	}

	//used where ??
	/*
		public function ajaxMoveCategoryUp(){
			if(Auth::isUserLogged()){
				if ($this->isAjax()) {
					if(MainHelper::validatePostFields(array('type', 'id', 'cid'))){
						if($this->data['user'] != false and $this->forum->checkIfAdmin($this->data['user'], 'forum', array(
								'type' => $_POST['type'],
								'id' => $_POST['id']
									))){
							if ($this->forum->moveCatUp($_POST['type'], $_POST['id'], $_POST['cid'])) {
								$this->toJSON(array('result' => TRUE), true);
							} else {
								$this->toJSON(array('result' => FALSE), true);
							}
						}
					}
					else{
						$this->toJSON(array('result' => FALSE), true);
					}
				}
			}else{
					DooUriRouter::redirect(MainHelper::site_url('login/loginfirst'));
			}
		}
		//used where???
		public function ajaxMoveCategoryDown(){
			if ($this->isAjax()) {
				if(MainHelper::validatePostFields(array('type', 'id', 'cid'))){
					if($this->data['user'] != false and $this->forum->checkIfAdmin($this->data['user'], 'forum', array(
							'type' => $_POST['type'],
							'id' => $_POST['id']
								))){
						if ($this->forum->moveCatDown($_POST['type'], $_POST['id'], $_POST['cid'])) {
							$this->toJSON(array('result' => TRUE), true);
						} else {
							$this->toJSON(array('result' => FALSE), true);
						}
					}
				}
				else{
					$this->toJSON(array('result' => FALSE), true);
				}
			}
		}
		*/
		// ok - is used where??
		/*
		public function editCategoryAction() {
			if ($this->data['isForumAdmin']) {
				if(MainHelper::validatePostFields(array('categoryName', 'categoryId')))
					$category = $this->forum->editCategory($this->data['type'], $this->params['id'], $_POST['categoryName'], $this->params['categoryId']);
			}

			DooUriRouter::redirect(MainHelper::site_url('forum/' . $this->data['type'] . '/' . $this->params['id']));
		}
	*/

	//ok
	public function ajaxdeletecategory() {
		if(Auth::isUserLogged()){
			if ($this->isAjax()) {
				$input = filter_input_array(INPUT_POST);
				if(!empty($input) && !empty($input['type']) && !empty($input['id']) && !empty($input['cid'])){
					$model = Forum::getModelByID($input['type'], $input['id']);
					if ($model->isForumAdmin() OR $model->isForumMod() ) {
						if ($this->forum->deleteCategory($input['type'], $input['id'], $input['cid'])) {
							$this->toJSON(array('result' => TRUE), true);
							
						} else {
							$this->toJSON(array('result' => FALSE), true);
						}
					}
				}
				else{
					$this->toJSON(array('result' => FALSE), true);
				}
			}
		}else{
				DooUriRouter::redirect(MainHelper::site_url('login/loginfirst'));
		}
	}
	// used where ??
	/*
	public function editBoardAction() {
		if ($this->data['isForumAdmin']) {
			if(MainHelper::validatePostFields(array('type', 'id', 'categoryName', 'categoryId'))){
				$category = $_POST['categoryId'];
				if ($category == 0) {
					$category = $this->forum->createCategory($this->data['type'], $this->params['id'], $_POST['categoryName']);
				}
			}
			if(MainHelper::validatePostFields(array('type', 'id', 'boardName', 'boardId', 'categoryId'))){
				$category = $_POST['categoryId'];
				if ($category != 0) {
					$board = $this->forum->editBoard($this->data['type'], $this->params['id'], $_POST['boardName'], $category, $this->params['boardId']);
				}
			}
		}
		DooUriRouter::redirect(MainHelper::site_url('forum/' . $this->data['type'] . '/' . $this->params['id']));
	}
	*/

	public function ajaxdeleteboard() {
		if(Auth::isUserLogged()){
			if ($this->isAjax()) {
				$input = filter_input_array(INPUT_POST);
				if(!empty($input) && !empty($input['type']) && !empty($input['id']) && !empty($input['cat_id'])&&  !empty($input['board_id']) ){
					if ($this->forum->deleteBoard($input['type'], $input['id'], $input['board_id'])) {
						$this->toJSON(array('result' => TRUE), true);
					}else{
						$this->toJSON(array('result' => FALSE), true);
					}
				}else{
					$this->toJSON(array('result' => FALSE), true);
				}
			}
		}else{
			DooUriRouter::redirect(MainHelper::site_url('login/loginfirst'));
		}
	}

	//ok
	public function deleteThread (){
		if(Auth::isUserLogged()){
			$this->moduleOff();
			
			$model = Forum::getModelByUrl($this->data['type'], $this->params['id']);
			$user = $this->data['user'];
			$list['user'] = $user;
					
			$createdBy = $this->forum->getPlayerIDfromMsgID($model->UNID, $this->data['type'] , $this->params['board'], $this->params['topic'], $this->params['msgid']);

			if($model->isForumAdmin() OR $model->isForumMod() OR  $model->isBoardMod($this->data['type'], $this->params['id'], $this->params['board'], $user->ID_PLAYER) OR  $user and ($user->ID_PLAYER == $createdBy)){
				
				$list['type'] 	= $this->data['type'];
				$list['id'] 	= $model->UNID;
				$list['board_id'] = $this->params['board'];
				$list['topic_id']= $this->params['topic'];
				$list['msg_id']	= $this->params['msgid'];
				$list['createdBy']	= $createdBy;
						
				$list['user'] = $this->data['user'];
						
				echo $this->renderBlock('forum/admin/deleteThread', $list);
						
			}else{
				DooUriRouter::redirect($model->FORUM_URL);
			}
		}else{
				DooUriRouter::redirect(MainHelper::site_url('login/loginfirst'));
		}
	}
	//ok
	public function deleteReply (){
		if(Auth::isUserLogged()){
			$this->moduleOff();
			
			$model = Forum::getModelByUrl($this->data['type'], $this->params['id']);
			$user = $this->data['user'];
			$list['user'] = $user;

			$createdBy = $this->forum->getPlayerIDfromMsgID($model->UNID, $this->data['type'] , $this->params['board'], $this->params['topic'], $this->params['msgid']);
						
			if ($model->isForumAdmin() OR $model->isForumMod() OR $model->isBoardMod($this->data['type'],$model->UNID,$this->params['board'],$user->ID_PLAYER) OR $user and ($user->ID_PLAYER == $createdBy)){
				
				$list['name'] = $model->UNNAME;  // fx playnation
				$list['type'] 	= $this->data['type'];
				$list['id'] 	= $model->UNID;
				$list['board_id'] = $this->params['board'];
				$list['topic_id']= $this->params['topic'];
				$list['msg_id']	= $this->params['msgid'];
						
				$name = $model->UNNAME;
				echo $this->renderBlock('forum/admin/deletePost', $list);
					
			}else{
				DooUriRouter::redirect($model->FORUM_URL);
			}
		}else{
				DooUriRouter::redirect(MainHelper::site_url('login/loginfirst'));
		}
	}

	public function ajaxdeletethread(){
		if(Auth::isUserLogged()){
			if ($this->isAjax()) {
				$input = filter_input_array(INPUT_POST);
				if(!empty($input) && !empty($input['type']) && !empty($input['id']) && !empty($input['board_id']) && !empty($input['topic_id']) && !empty($input['msg_id']) && !empty($input['createdBy'])) {
					$model =Forum::getModelByID($input['type'], $input['id']);
					
					$type = $input['type'];
					$id = $input['id'];
					$board = $input['board_id'];
					$topic = $input['topic_id'];
					$msg = $input['msg_id'];
					$createdBy = $input['createdBy'];
					
					$user = $this->data['user'];
					$playerID = $user->ID_PLAYER;
					
					if($playerID === $createdBy OR $model->isForumAdmin() OR $model->isForumMod() OR  $model->isBoardMod($type, $id, $board, $playerID)){
						$results = $this->forum->deleteMessage($type, $id, $board, $msg);
					
						if($results === true){
							$return['result'] = $this->forum->deleteTopic($type, $id, $board, $topic);
							$return['url'] = MainHelper::site_url('forum/'.$type.'/'.$model->UNNAME.'/'.$board);
						}else{
							$return = array('result' => FALSE, 'msg' => 'delete msg failed : ' . $results);
						}
					}

				}else{
					$return = array('result' => FALSE, 'msg' => 'not valid post');
				}
				
			}else{
				$return = array('result' => FALSE, 'msg' => 'not ajax');
			}
			$this->toJSON($return, TRUE);
		}else{
				DooUriRouter::redirect(MainHelper::site_url('login/loginfirst'));
		}
	}

	// ok
	public function ajaxdeletemessage() {
		
			if ($this->isAjax()) {
				$input = filter_input_array(INPUT_POST);
				if(!empty($input) && !empty($input['type']) && !empty($input['id']) && !empty($input['board_id']) && !empty($input['topic_id']) && !empty($input['msg_id'])) {
					$type = $input['type'];
					$id = $input['id'];
					$board = $input['board_id'];
					$topic = $input['topic_id'];
					$msg = $input['msg_id'];

					$user = $this->data['user'];
					
					$result['result'] = $this->forum->deleteMessage($type, $id, $board, $msg);
					$this->toJSON($result, true);
					//$this->toJSON(array('result' => true), true);
				}else{
					$this->toJSON(array('result' => FALSE), true);
				}
			}else{
				$this->toJSON(array('result' => FALSE), true);
			}
		
	}

	//ok
	public function editMessage (){
		if(Auth::isUserLogged()){
			$this->moduleOff();
			
			$model = Forum::getModelByUrl($this->data['type'], $this->params['id']);
			$user = User::getUser();
			
			$topicInfo= $this->forum->getTopicById($this->data['type'], $model->UNID, $this->params['topic']);
			$threadStarter = $topicInfo->ID_PLAYER_STARTED;

			$createdBy = $this->forum->getPlayerIDfromMsgID($model->UNID, $this->data['type'] , $this->params['board'], $this->params['topic'], $this->params['msgid']);

			if ($model->isForumAdmin() OR $model->isForumMod() or $model->isBoardMod($this->data['type'], $model->UNID, $this->params['board'], $user->ID_PLAYER) or  $user and ($user->ID_PLAYER == $createdBy) OR ($user->ID_PLAYER == $threadStarter) ){
				
				$list['type'] = $this->data['type'];

				$name = $model->UNNAME;
				$list['name'] = $model->UNNAME;  // fx playnation
				$list['id'] 	= $model->UNID;  // 1
				$list['board_id'] = $this->params['board'];
				$list['topic_id']= $this->params['topic'];
				$list['msg_id']	= $this->params['msgid'];
				$list['poll_id'] = $topicInfo->ID_POLL;

				$firstMsgID = $topicInfo->ID_FIRST_MSG;
				$list['firstMsgID'] = $firstMsgID;
				$list['threadStarter']  = $threadStarter; 

				$firstmessage = $this->forum->getMessage ($model->UNID, $this->data['type'],  $this->params['board'], $this->params['topic'],  $firstMsgID);
				$list['subject']  = $firstmessage->Subject;
				
				$messageInfo  = $this->forum->getMessage ($model->UNID, $this->data['type'],  $this->params['board'], $this->params['topic'],  $this->params['msgid']);
				$list['body'] = $messageInfo->Body;
			
				$data['title'] = $name;
				$this->addCrumb($name);

				$list['model'] = $model;
				$user = $this->data['user'];
				$list['user'] =  $user;
					
				$list['url'] = $this->params['id']; // 1
					
				
				$list['createdBy'] = $createdBy;
				
				echo $this->renderBlock('forum/admin/editMessage', $list);
			
			}else{
				DooUriRouter::redirect($model->FORUM_URL);
			}
		}else{
				DooUriRouter::redirect(MainHelper::site_url('login/loginfirst'));
		}
	}

	//ok
	public function ajaxeditmessage() {
		if(Auth::isUserLogged()){
			if ($this->isAjax()) {
				$input = filter_input_array(INPUT_POST);
				if(!empty($input)){
					$model =Forum::getModelByID($input['type'], $input['id']);
					
					$type = $input['type'];
					$id = $input['id'];
					$board = $input['board_id'];
					$topic = $input['topic_id'];
					$msg = $input['msg_id'];
					$body = $input['body'];
					$firstMsgID = $input['firstMsgID'];
					$threadStarter = $input['threadStarter'];
					$createdBy = $input['createdBy'];
					$subject = (empty($input['topicSubject'])) ? '' : $input['topicSubject'];

					$user = $this->data['user'];
					$playerID = $user->ID_PLAYER;
					$modifiedName  = $user->DisplayName;

					if($msg == $firstMsgID  AND ($model->isForumAdmin() OR $model->isForumMod() OR  $model->isBoardMod($type, $id, $board, $playerID))){
							$this->forum->editTopicSubject($type, $id, $board, $topic, $subject);
							
							//update subject in fmmessages
							$this->forum->editSubject($type, $id,$board, $topic, $msg, $subject, $modifiedName, $playerID);
							$this->forum->UpdateAllOtherMessagesSubject($type, $id, $board, $topic, $firstMsgID, $subject);
							
							// edit body in fmmessages
							$result['result'] = $this->forum->editMessage($type, $id,$board, $topic, $msg, $body, $modifiedName, $playerID);
							
							$this->toJSON($result, true);

					}elseif ($msg == $firstMsgID and ($playerID == $threadStarter )){
						$this->forum->editTopicSubject($type, $id, $board, $topic, $subject);
						//update subject in fmmessages
						$this->forum->editSubject($type, $id,$board, $topic, $msg, $subject, $modifiedName, $playerID);
						$this->forum->UpdateAllOtherMessagesSubject($type, $id, $board, $topic, $firstMsgID, $subject);
						
						// edit body in fmmessages
						$result['result'] = $this->forum->editMessage($type, $id,$board, $topic, $msg, $body, $modifiedName, $playerID);
						
						$this->toJSON($result, true);
							
					}else{
						
						$result['result'] = $this->forum->editMessage ($type, $id,$board, $topic, $msg, $body, $modifiedName, $playerID);
						$this->toJSON($result, true);
						
					}
		
				}else{
					$this->toJSON(array('result' => FALSE), true);
				}
			}else{
				$this->toJSON(array('result' => FALSE), true);
			}
		}else{
				DooUriRouter::redirect(MainHelper::site_url('login/loginfirst'));
		}	
	}

	// ok 
	public function createTopic() {
		
			$model = Forum::getModelByUrl($this->data['type'], $this->params['id']);
			$user = $this->data['user'];
			if( $model->isMember()) {
				$list['page'] = 'forum_create_topic';
				$data['title'] = $this->__('Create Thread');
				$data['body_class'] = 'index_forum_create_topic forums';

				$list['user'] = $this->data['user'];
				
				$list['isForumAdmin'] =  $model->isForumAdmin(); //just for the forum parts can be: isAdmin isForumAdmin  
				$list['isMember'] = $model->isMember();
								
				$list['boardInfo'] = $this->forum->getBoardInfo($this->data['type'], $model->UNID, $this->params['boardId']);

				if($list['boardInfo'] and $list['boardInfo']->isClosed == 1 ){
					DooUriRouter::redirect($model->FORUM_URL . '/' . $this->params['boardId']);
					return;
				}

				$this->addCrumb($model->UNNAME, $model->FORUM_URL);

				$this->addCrumb($list['boardInfo']->BoardName, $model->FORUM_URL . '/' . $this->params['boardId']);

				$this->addCrumb($data['title']);

				$list['player'] = $this->data['user'];
				$list['crumb'] = $this->getCrumb();
				$list['type'] = $this->data['type'];

				$data['selected_menu'] = 'forum';
				$data['left'] = PlayerHelper::playerLeftSide();
				$data['right'] = PlayerHelper::playerRightSide();
				$data['footer'] = MainHelper::bottomMenu();
				$data['header'] = MainHelper::topMenu();

				$data['content'] = $this->renderBlock('forum/' . $list['page'], $list);
				$this->render3Cols($data);
			} else {
				DooUriRouter::redirect($model->FORUM_URL . '/' . $this->params['boardId']);
			}
		
	}

	// ok
	public function createTopicAction() {
		if(Auth::isUserLogged()){
			$model = Forum::getModelByUrl($this->data['type'], $this->params['id']);
			
			if ($model->isMember() ) {	
				$input = filter_input_array(INPUT_POST);
				if(!empty($input)){
				//if(MainHelper::validatePostFields(array('topicName', 'messageText'))){
					$board = $this->forum->getBoardInfo($this->data['type'], $this->params['id'], $this->params['boardId']);
					if($board and $board->isClosed == 1 ){
						DooUriRouter::redirect($model->FORUM_URL . '/' . $this->params['boardId']);
						return;
					}

					$list['topic'] = $this->forum->createTopic($this->data['type'], $model->UNID, $this->params['boardId'], $input['topicName'], $this->data['user']->ID_PLAYER, $input['messageText']);
				}
			}
			DooUriRouter::redirect($model->FORUM_URL . '/' . $this->params['boardId']);
		}else{
				DooUriRouter::redirect(MainHelper::site_url('login/loginfirst'));
		}
	}

	// ok
	public function createPoll() {
		$model = Forum::getModelByUrl($this->data['type'], $this->params['id']);
			
		$user = $this->data['user'];
		if ($user) {
			$list['page'] = 'forum_create_poll';
			$data['title'] = $this->__('Create Poll');
			$data['body_class'] = 'index_forum_create_topic forums';

			$list['user'] = $this->data['user'];
			$list['isForumAdmin'] =  $model->isForumAdmin(); //just for the forum parts can be: isAdmin isForumAdmin  
			$list['isMember'] = $model->isMember();
			
			
			$list['boardInfo'] = $this->forum->getBoardInfo($this->data['type'], $model->UNID, $this->params['boardId']);

			$this->addCrumb($model->UNNAME, $model->FORUM_URL);

			$this->addCrumb($list['boardInfo']->BoardName, $model->FORUM_URL . '/' . $this->params['boardId']);

			$this->addCrumb($data['title']);

			$list['player'] = $this->data['user'];
			$list['crumb'] = $this->getCrumb();
			$list['type'] = $this->data['type'];

			$data['selected_menu'] = 'forum';
			$data['left'] = PlayerHelper::playerLeftSide();
			$data['right'] = PlayerHelper::playerRightSide();
			$data['footer'] = MainHelper::bottomMenu();
			$data['header'] = MainHelper::topMenu();

			$data['content'] = $this->renderBlock('forum/' . $list['page'], $list);
			$this->render3Cols($data);
		} else {
			DooUriRouter::redirect($model->FORUM_URL . '/' . $this->params['boardId']);
		}
		
	}
	// ok
	public function createPollAction() {
		if(Auth::isUserLogged()){
			$model = Forum::getModelByUrl($this->data['type'], $this->params['id']);
			$id = $model->UNID;

			$user = $this->data['user'];
			if ($user) {
				if(MainHelper::validatePostFields(array('topicName', 'messageText'))){
					$board = $this->forum->getBoardInfo($this->data['type'], $this->params['id'], $this->params['boardId']);
					if($board and $board->isClosed == 1 and !$model->isForumAdmin()){
						DooUriRouter::redirect($model->FORUM_URL . '/' . $this->params['boardId']);
						return;
					}
							
					// getting the counters - ok
					$counters = $this->forum->GetCounters($this->data['type'], $id);
					$topic_id = $counters->NextTopic; 
					$poll_id  = $counters->NextPoll;

					// create record in FM_messages and FM_topics  OK
					$list['Polltopic'] = $this->forum->createTopic($this->data['type'], $id , $this->params['boardId'], $_POST['topicName'], $this->data['user']->ID_PLAYER, $_POST['messageText']);
					
					// create record in FM_POLLS ok
					$list['Poll'] = $this->forum->createPoll($this->data['type'], $id, $poll_id, $this->data['user']->ID_PLAYER, $this->data['user']->DisplayName, $_POST ['enddate'], $_POST['hour'], $_POST['topicName']);
					
					// update NextPoll (id) in FM_Counters ok
					$this->forum->updateCounter($this->data['type'], $id, $poll_id);
									
					// update ID_POLL in Fm_topics ok
					$this->forum->updateTopicsPollid($this->data['type'], $id,  $topic_id, $poll_id);
					
				
					// create record in FM_Poll_choices, one foreach option - ok
					$choice_id = 1;
					foreach( $_POST['options'] as $choice){
						 if (! empty($choice )){
							$this->forum->createChoices($this->data['type'], $id, $poll_id, $choice_id, $choice);
							$choice_id++;
						 }
					}
				DooUriRouter::redirect($model->FORUM_URL . '/' . $this->params['boardId']);	
				}
			}else{
				DooUriRouter::redirect($model->FORUM_URL . '/' . $this->params['boardId']);
			}
		}else{
				DooUriRouter::redirect(MainHelper::site_url('login/loginfirst'));
		}
	}

	public function ajaxCastVote(){
		if(Auth::isUserLogged()){
			if ($this->isAjax()) {
				$input = filter_input_array(INPUT_POST);
				if(!empty($input) && !empty($input['pollchoice']) && !empty($input['poll_id'])){				
					$model = Forum::getModelByID($input['type'], $input['id']);
					if ($model->isMember() ) {
						$user = $this->data['user'];
						// add the vote to fm_poll_votes
						$this->forum->castVote($input['type'],$input['id'], $input['poll_id'], $user->ID_PLAYER, $input['pollchoice'] );
						
						// get current numbers of votes from fmpollchoices
						$curVotes = $this->forum->getCurrentVotes($input['type'],$input['id'], $input['poll_id'], $input['pollchoice'] );
					
						// add vote to counter in fmpollchoices
						$result['result'] = $this->forum->addVote($input['type'],$input['id'], $input['poll_id'], $input['pollchoice'], $curVotes);
						$this->toJSON($result, true);
					}
				
				}else{
					$this->toJSON(array('result' => false), true);
				}

			}else{
					$this->toJSON(array('result' => false), true);
			}
		}else{
				DooUriRouter::redirect(MainHelper::site_url('login/loginfirst'));
		}
	}

	//Add board moderator Ajax call.
	public function ajaxAddBoardMod(){
		if(Auth::isUserLogged()){
			if ($this->isAjax()) {
				$input = filter_input_array(INPUT_POST);
				if(!empty($input)){
					$model = Forum::getModelByID($input['type'], $input['id']);
					$user = $this->data['user'];
					if ($model->isForumAdmin() or $model->isForumMod() or $model->isBoardMod($input['type'], $input['id'], $input['board'],$user->ID_PLAYER ) ) {
						$result['result'] = $this->forum->addBoardModerator($input['type'], $input['id'], $input['board'], $input['id_player']);
						$this->toJSON($result, true);
					}
				}
				else{
					$this->toJSON(array('result' => false), true);
				}
			}
		}else{
				DooUriRouter::redirect(MainHelper::site_url('login/loginfirst'));
		}
	}

		// ok 
	public function deleteOldVote(){
		if(Auth::isUserLogged()){
			$model = Forum::getModelByUrl($this->data['type'], $this->params['id']);
			$id = $model->UNID;
			if($model->isMember() ){
				// get the players vote
				$choice_id = $this->forum-> getPlayersVotes($this->data['type'], $id, $this->params['poll'], $this->data['user']->ID_PLAYER );
						
				// get current numbers of votes from fmpollchoices
				$curVotes = $this->forum->getCurrentVotes($this->data['type'], $id, $this->params['poll'], $choice_id);
				
				// remove a votes from Votes in fmpollchoices
				$this->forum->removeVote($this->data['type'], $id, $this->params['poll'], $choice_id, $curVotes);

				// DELETE the players votes from fmpollvotes
				$this->forum->deleteVote($this->data['type'] ,$id, $this->params['poll'], $this->data['user']->ID_PLAYER );
				
				DooUriRouter::redirect($model->FORUM_URL . '/' . $this->params['board'].'/'.$this->params['topic'].'/'.$this->params['poll']);
			}else{
				DooUriRouter::redirect($model->FORUM_URL . '/' . $this->params['board'].'/'.$this->params['topic'].'/'.$this->params['poll']);
			}
		}else{
				DooUriRouter::redirect(MainHelper::site_url('login/loginfirst'));
		}
	
	}

	public function editPoll(){
		if(Auth::isUserLogged()){
			$this->moduleOff();
			$list['page'] = 'editPoll';
			$data['body_class'] = 'index_forum_forum forums';

			$model = Forum::getModelByUrl($this->data['type'], $this->params['id']);
			$user = User::getUser();
			
			$topicInfo= $this->forum->getTopicById($this->data['type'], $model->UNID, $this->params['topic']);
			$threadStarter = $topicInfo->ID_PLAYER_STARTED;
			
			if ($model->isForumAdmin() or $model->isForumMod() OR $model->isBoardMod($this->data['type'], $model->UNID, $this->params['board'],$user->ID_PLAYER) OR  $user and ($user->ID_PLAYER == $threadStarter) ){
				
				$list['type'] = $this->data['type'];
			
				if($this->data['type'] =='company'){
					$data['left'] = MainHelper::companiesLeftSide($model, 'forum');
				}elseif ($this->data['type'] =='game') {
				
					$data['left'] = MainHelper::gamesLeftSide($model, 'forum');
				}elseif ($this->data['type'] == 'group') {
					
					$data['left'] = MainHelper::groupsLeftSide($model, 'forum');
				}
				
				$list['isForumAdmin'] =  $model->isForumAdmin(); //just for the forum parts can be: isAdmin isForumAdmin  
				$list['isMember'] = $model->isMember();
				
				
				$name = $model->UNNAME;
				$list['name'] = $model->UNNAME;  // fx playnation
				$list['id'] 	= $model->UNID;
				$list['board_id'] = $this->params['board'];
				$list['topic_id']= $this->params['topic'];
				$list['poll_id'] = $this->params['poll'];

				$firstMsgID = $topicInfo->ID_FIRST_MSG;
				$list['firstMsgID'] = $firstMsgID;
				$list['threadStarter']  = $threadStarter; 

				$firstmessage = $this->forum->getMessage ($model->UNID, $this->data['type'],  $this->params['board'], $this->params['topic'],  $firstMsgID);
				$list['subject']  = $firstmessage->Subject;
				$list['body'] = $firstmessage->Body;
			
				$pollbase = $this->forum->getPollbase($this->data['type'], $model->UNID, $this->params['poll'] );
				
				$list['expiretime'] = $pollbase->ExpireTime;
				//$selected_date =  date('Y-m-d', $pollbase->ExpireTime);
				//$selected_time =  date('H:i', $pollbase->ExpireTime);
				//$list['selected_date'] = $selected_date;
				//$list['selected_time'] = $selected_time;

				$list['Poll_choices']  = $this->forum->getPollChoices($this->data['type'], $model->UNID, $this->params['poll']);
							
				$data['title'] = $name;
				$this->addCrumb($name);
				// add more crumb - boards name fx offtopic, add text [poll] and topics name fx laptop or pc, add current page - edit poll

				$list['model'] = $model;
				$list['user'] = $this->data['user']; 
				$list['url'] = $this->params['id']; // playnation
					
				$list['crumb'] = $this->getCrumb();
				
				
				$data['selected_menu'] = 'forum';
				$data['right'] = PlayerHelper::playerRightSide();
				$data['footer'] = MainHelper::bottomMenu();
				$data['header'] = MainHelper::topMenu();

				$data['content'] = $this->renderBlock('forum/admin/' . $list['page'], $list);
				$this->render3Cols($data);	
				//echo $this->renderBlock('forum/admin/editPoll', $list);
			}else{
				// the pollid is missing!
				DooUriRouter::redirect($model->FORUM_URL);
			}
		}else{
				DooUriRouter::redirect(MainHelper::site_url('login/loginfirst'));
		}
	}

	public function editPollAction(){
		if(Auth::isUserLogged()){
			$model = Forum::getModelByUrl($this->data['type'], $this->params['id']);
			$id = $model->UNID;

			if(MainHelper::validatePostFields(array('topicSubjectpoll', 'body'))){
				$type = $_POST['type'];
				$id = $_POST['id'];
				$board_id = $_POST['board_id'];
				$topic_id = $_POST['topic_id'];
				$poll_id = $_POST['poll_id'];
				$msg_id = $_POST['msg_id'];

				$subject = $_POST['topicSubjectpoll'];
				$body = $_POST['body'];

				$date = $_POST['enddate'];
				$time = $_POST['hour'];
				
				$enddate = ContentHelper:: handleContentInput($date); 
				$hour = ContentHelper:: handleContentInput($time);
				
				$user =$this->data['user'];
				$playerID = $user->ID_PLAYER;
				$modifiedName  = $user->DisplayName;
				// update fm topic 
				$this->forum->editTopicSubject ($type, $id, $board_id, $topic_id, $subject);
				
				// update fm message - ok 
				$this->forum->editSubject ($type, $id, $board_id, $topic_id, $msg_id, $subject, $modifiedName, $playerID);
				$this->forum->editMessage ($type, $id, $board_id, $topic_id, $msg_id, $body, $modifiedName, $playerID);
				
				// update fm_polls - ok
				$this->forum->updateQuestion( $type, $id, $poll_id, $subject);

				$pollbase = $this->forum->getPollbase($this->data['type'], $model->UNID, $this->params['poll'] );
				$selected_date =  date('d-m-Y', $pollbase->ExpireTime);;
				$selected_time =  date('H:i', $pollbase->ExpireTime);;
					
				// date is never empty - ok
				if(!empty($enddate) && empty($hour)){
					$hour = $selected_time;
					$this->forum->updateExpiretime( $type, $id, $poll_id, $enddate, $hour);
				}elseif(!empty($enddate) && !empty($hour)){
					$this->forum->updateExpiretime( $type, $id, $poll_id, $enddate, $hour);
				}

				// update fm_poll_choices ok
				$options = $_POST['options'] ;
				$count_OldChoices= count($options);
				$original_choiceIds = array_slice(array_keys($options), 0, $count_OldChoices); 

				if(isset($_POST['new_options'])){
					$new_options = $_POST['new_options'];
					$count_NewChoices =  count($new_options);
					$added_choices = array_slice(array_keys($new_options),0, $count_NewChoices );
				}else{
					$new_options = "";
					$count_NewChoices = "";
					$added_choices = "";
				}
				
				foreach ($original_choiceIds as $OC) {
					$choice_id = $OC;
					$choice =  $options[$choice_id];
					$this->forum->updatePollChoices($type, $id, $poll_id, $choice_id, $choice);	
					
				}
				
				if(isset($new_options) && $new_options != ""){
					foreach( $new_options as $choice){
					$choice_id += 1;
						if (! empty($choice )){
							$this->forum->createChoices($this->data['type'], $id, $poll_id, $choice_id, $choice);
						}
					}
				}				 

				DooUriRouter::redirect(MainHelper::site_url('forum/' . $type . '/' . $this->params['id'].'/'.$board_id.'/'.$topic_id.'/'.$poll_id));
			}
			
		}else{
				DooUriRouter::redirect(MainHelper::site_url('login/loginfirst'));
		}
	}

	public function deletePollChoice(){
		
			$model = Forum::getModelByUrl($this->data['type'], $this->params['id']);
			$type = $this->data['type'];
			$id = $model->UNID;
			$poll_id = $this->params['poll'];
			$choice_id = $this->params['choice'];

			$votes = $this->forum->getCurrentVotes($type, $id, $poll_id, $choice_id);

			if($votes > 0){
				$this->forum->deleteChoiceVotes($type ,$id, $poll_id, $choice_id );
				$this->forum->deletePollChoice($type, $id, $poll_id, $choice_id);
			}else{
				$this->forum->deletePollChoice($type, $id, $poll_id, $choice_id);
			}

			DooUriRouter::redirect(MainHelper::site_url('forum/'.$type .'/'.$this->params['id'].'/'.$this->params['board'].'/'.$this->params['topic'].'/'.$poll_id.'/editpoll'));
		
	}

	public function deletePoll(){
		
			$this->moduleOff();
		
			$model = Forum::getModelByUrl($this->data['type'], $this->params['id']);
			$user = User::getUser();

			$topicInfo= $this->forum->getTopicById($this->data['type'], $model->UNID, $this->params['topic']);
			$threadStarter = $topicInfo->ID_PLAYER_STARTED;
						
			if ($model->isForumAdmin() OR $model->isForumMod() OR $model->isBoardMod($this->data['type'], $model->UNID,$this->params['board_id'],$user->ID_PLAYER)OR  $user and ($user->ID_PLAYER == $threadStarter)){
				
				if($this->data['type'] =='company'){
					$data['left'] = MainHelper::companiesLeftSide($model, 'forum');
				}elseif ($this->data['type'] =='game') {
					$data['left'] = MainHelper::gamesLeftSide($model, 'forum');
				}elseif ($this->data['type'] == 'group') {
					$data['left'] = MainHelper::groupsLeftSide($model, 'forum');
				}
				
				
				$list['isAdmin'] = $model->isForumAdmin(); //just for the forum parts can be: isAdmin isForumAdmin 
				

				$name = $model->UNNAME;
				$list['name'] = $model->UNNAME;  // fx playnation
				$list['type'] = $this->data['type'];
				$list['id'] 	= $model->UNID;
				$list['board_id'] = $this->params['board'];
				$list['topic_id']= $this->params['topic'];
				$list['poll_id'] = $this->params['poll'];

				$firstMsgID = $topicInfo->ID_FIRST_MSG;
				$list['firstMsgID'] = $firstMsgID;
				$list['threadStarter']  = $threadStarter; 

					
				echo $this->renderBlock('forum/admin/deletePoll', $list);				
			}else{
				DooUriRouter::redirect($model->FORUM_URL);
			}
	
		
	}
	// new!
	public function ajaxdeletepoll(){
		if(Auth::isUserLogged()){
			if ($this->isAjax()) {
				$input = filter_input_array(INPUT_POST);
				if(!empty($input) ) {
					$model =Forum::getModelByID($input['type'], $input['id']);
					
					$type = $input['type'];
					$id = $input['id'];
					$board = $input['board_id'];
					$topic = $input['topic_id'];
					$msg = $input['msg_id'];
					$poll = $input['poll_id'];
					
					$user = $this->data['user'];
					$playerID = $user->ID_PLAYER;
					
					$topicInfo= $this->forum->getTopicById($type, $id, $topic);
					$threadStarter = $topicInfo->ID_PLAYER_STARTED;
					if( $playerID === $threadStarter  OR $model->isForumAdmin() OR $model->isForumMod() OR  $model->isBoardMod($type, $id, $board, $playerID)){
						$choices = $this->forum->getPollChoices($type, $id, $poll);

						foreach ($choices as $choice) {
							$choice_id = $choice->ID_CHOICE;
							$this->forum->deletePollChoice($type, $id, $poll, $choice_id);
						}
						$this->forum->deletePollbase($type, $id, $poll);
						$results = $this->forum->deleteMessage($type, $id, $board, $msg);
					
						if($results === true){
							$return['result'] = $this->forum->deleteTopic($type, $id, $board, $topic);
							$return['url'] = MainHelper::site_url('forum/'.$type.'/'.$model->UNNAME.'/'.$board);
						}else{
							$return = array('result' => FALSE, 'msg' => 'delete msg failed : ' . $results);
						}
					}

				}else{
					$return = array('result' => FALSE, 'msg' => 'not valid post');
				}
				
			}else{
				$return = array('result' => FALSE, 'msg' => 'not ajax');
			}
			$this->toJSON($return, TRUE);
		}else{
				DooUriRouter::redirect(MainHelper::site_url('login/loginfirst'));
		}
	}
	
	// ok
	public function reply() {
		if(Auth::isUserLogged()){
			$model = Forum::getModelByUrl($this->data['type'], $this->params['id']);
			if ($this->data['user'] != false) {
				if (MainHelper::validatePostFields(array('subject', 'messageText'))) {
					$this->forum->reply($this->data['type'], $model->UNID, $this->params['board'], $this->params['topic'], $_POST['subject'], $this->data['user']->ID_PLAYER, $_POST['messageText']);
				}
			}

			$topic = $this->forum->getTopicById($this->data['type'], $model->UNID, $this->params['topic']);

			if ($topic->ID_POLL == 0) {
				DooUriRouter::redirect($model->FORUM_URL .'/'. $this->params['board'] .'/'. $this->params['topic']);
			} else {
				DooUriRouter::redirect($model->FORUM_URL .'/'. $this->params['board'] .'/'. $this->params['topic'] .'/'. $topic->ID_POLL);
			}
		}else{
				DooUriRouter::redirect(MainHelper::site_url('login/loginfirst'));
		}
	}

	public function search() {
		if(Auth::isUserLogged()){
			$this->moduleOff();

			if(MainHelper::validatePostFields(array('search')) and strlen($_POST['search']) > Doo::conf()->forumSearchMinLength){
				$data['body_class'] = 'index_forum_search forums';
				if (isset($this->data['type']) and isset($this->params['id'])) {
					$list['page'] = 'forum_search';

					$list['topics'] = $this->forum->search($this->data['type'], $this->params['id'], $_POST['search']);

					$this->addCrumb($this->__($this->forum->getItemName($this->data['type'], $this->params['id'])), MainHelper::site_url('forum/' . $this->data['type'] . '/' . $this->params['id']));

					$this->addCrumb($_POST['search']);
					$list['ownerId'] = $this->params['id'];
					$list['type'] = $this->data['type'];
				} elseif (isset($this->data['type'])) {
					$results = $this->forum->searchIndex($this->data['type'], $_POST['search']);

					$this->addCrumb($_POST['search']);

					$list['page'] = 'forum_search_index';
					$list['fields'] = $results['fields'];
					$list['model'] = $results['results'];
				}

				$list['type'] = $this->data['type'];

				$list['crumb'] = $this->getCrumb();

				$data['title'] = $this->__('Search results');

				$data['selected_menu'] = 'forum';
				$data['left'] = PlayerHelper::playerLeftSide('wall');
				$data['right'] = PlayerHelper::playerRightSide();
				$data['footer'] = MainHelper::bottomMenu();
				$data['header'] = MainHelper::topMenu();

				$data['content'] = $this->renderBlock('forum/' . $list['page'], $list);
				$this->render3Cols($data);
			} else {
				$redirect = 'forum';

				if (isset($this->data['type']) and !empty($this->data['type'])) {
					$redirect .= '/' . $this->data['type'];
					if (isset($this->params['id']) and !empty($this->params['id'])) {
						$redirect .= '/' . $this->params['id'];

						if (isset($this->params['board']) and !empty($this->params['board'])) {
							$redirect .= '/' . $this->params['board'];

							if (isset($this->params['topic']) and !empty($this->params['topic'])) {
								$redirect .= '/' . $this->params['topic'];
							}
						}
					}
				}
				DooUriRouter::redirect(MainHelper::site_url($redirect));
			}
		}else{
				DooUriRouter::redirect(MainHelper::site_url('login/loginfirst'));
		}
	}


	public function adminforum(){
		$this->moduleOff();

		$list['page'] = 'forum_adminpage';
		$data['body_class'] = 'index_forum_forum forums';

		switch ($this->data['type']) {
			case WALL_COMPANIES:
				$this->adminCompanies();
				break;
			case WALL_GAMES:
				$this->adminGames();
				break;
			case WALL_GROUPS:
				$this->adminGroups();
				break;
		}

	}


	public function adminCompanies(){
		if(Auth::isUserLogged()){
			$this->moduleOff();
			$company = Forum::getModelByUrl('company', $this->params['id']);
			
			if($company->isForumAdmin() OR $company->isForumMod() ){ 	
				$list['page'] = 'forum_adminpage';
				$data['body_class'] = 'index_forum_forum forums';

				//$company = Forum::getModelByUrl('company', $this->params['id']);
				$name = $company->CompanyName;
				$data['title'] = $name;
				$this->addCrumb($name, $company->FORUM_URL);
				$this->addCrumb('Admin panel');

				$list['model'] = $company;

				$list['user'] = $this->data['user'];

				$list['url'] = $this->params['id'];

				$isOnAdminPage = (isset($this->params['admin'])) ? TRUE : FALSE;
				$list['categories'] = $this->forum->getForum($this->data['type'], $company->ID_COMPANY, $isOnAdminPage); /* get the cat list */
				$list['type'] = $this->data['type'];
				$list['ownerId'] = $company->ID_COMPANY;
				$list['crumb'] = $this->getCrumb();

				$data['selected_menu'] = 'forum';
				$data['left'] = MainHelper::companiesLeftSide($company, 'forum');
				$data['right'] = PlayerHelper::playerRightSide();
				$data['footer'] = MainHelper::bottomMenu();
				$data['header'] = MainHelper::topMenu();

				$data['content'] = $this->renderBlock('forum/' . $list['page'], $list); // builds view - file: forum_adminpage
				$this->render3Cols($data);
			}else{
				DooUriRouter::redirect($company->FORUM_URL);
			}
		}else{
				DooUriRouter::redirect(MainHelper::site_url('login/loginfirst'));
		}
	}


	public function adminGames(){
		if(Auth::isUserLogged()){
			$this->moduleOff();
			$game = Forum::getModelByUrl('game', $this->params['id']);
			if($game->isForumAdmin() OR $game->isForumMod() ){ 
				$list['page'] = 'forum_adminpage';
				$data['body_class'] = 'index_forum_forum forums';

				$name = $game->GameName;

				$data['title'] = $name;
				$this->addCrumb($name);

				$list['model'] = $game;
				$list['user'] = $this->data['user'];
				$list['isAdmin'] = $game->isForumAdmin();
				$list['url'] = $this->params['id'];

				$list['categories'] = $this->forum->getForum($this->data['type'], $game->ID_GAME);
				$list['type'] = $this->data['type'];
				$list['ownerId'] = $game->ID_GAME;
				$list['crumb'] = $this->getCrumb();


				$data['selected_menu'] = 'forum';
				$data['left'] = MainHelper::gamesLeftSide($game, 'forum');
				$data['right'] = PlayerHelper::playerRightSide();
				$data['footer'] = MainHelper::bottomMenu();
				$data['header'] = MainHelper::topMenu();

				$data['content'] = $this->renderBlock('forum/' . $list['page'], $list);
				$this->render3Cols($data);
			}else{
				DooUriRouter::redirect($game->FORUM_URL);
			}
		}else{
				DooUriRouter::redirect(MainHelper::site_url('login/loginfirst'));
		}
	}

	public function adminGroups(){
		if(Auth::isUserLogged()){
			$this->moduleOff();
			$group = Forum::getModelByUrl('group', $this->params['id']);
			
			if($group->isForumAdmin() OR $group->isForumMod() ){ 
				$list['page'] = 'forum_adminpage';
				$data['body_class'] = 'index_forum_forum forums';
				$name = $group->GroupName;
				$list['model'] = $group;

				$data['title'] = $name;
				$this->addCrumb($name);

				$list['user'] = $this->data['user'];
				$list['isAdmin'] = $group->isForumAdmin();
				$list['url'] = $this->params['id'];

				$list['categories'] = $this->forum->getForum($this->data['type'], $group->ID_GROUP);
				$list['type'] = $this->data['type'];
				$list['ownerId'] = $group->ID_GROUP;
				$list['crumb'] = $this->getCrumb();

				$data['selected_menu'] = 'forum';
				$data['left'] = MainHelper::groupsLeftSide($group, 'forum');
				$data['right'] = PlayerHelper::playerRightSide();
				$data['footer'] = MainHelper::bottomMenu();
				$data['header'] = MainHelper::topMenu();

				$data['content'] = $this->renderBlock('forum/' . $list['page'], $list);
				$this->render3Cols($data);
			}else{
				DooUriRouter::redirect($group->FORUM_URL);
			}
		}else{
				DooUriRouter::redirect(MainHelper::site_url('login/loginfirst'));
		}
	}

	public function countTotalVotes($Poll_choices){
		$i=0;
		foreach ($Poll_choices as $poll) {
			$votes  = $poll->Votes;
			$i+= $votes;
		}
		return $i;
	}

	public function pinLockThread() {
		if(Auth::isUserLogged()){
			$model = Forum::getModelByUrl($this->params['type'], $this->params['id']);
			$user = $this->data['user'];

			if($model->isForumMod() or $model->isForumAdmin() or $model->isBoardMod($this->data['type'], $this->params['id'], $this->params['board'], $user->ID_PLAYER) ){
			$thread = $this->forum->pinLockThread($this->params['action'], $model->UNID, $this->params['type'], $this->params['board'], $this->params['topic']);

			DooUriRouter::redirect(MainHelper::site_url('forum/' . $this->data['type'] . '/' . $this->params['id'] . '/' . $this->params['board']));
			}
		} else {
				DooUriRouter::redirect($model->FORUM_URL);
		}
	}

	public function markBoardAsRead() {
		if(Auth::isUserLogged()){
			$user = User::getUser();
			$model = Forum::getModelByUrl($this->params['type'], $this->params['id']);
			
			$listOfTopics = MainHelper::getListOfTopics($model->UNID, $this->params['type'], $this->params['board']); // returns topic_ids
			foreach ($listOfTopics as $list) {
				$this->forum->logVisitTopic($this->params['type'], $model->UNID,  $list['ID_TOPIC'], $user);
			}
			$this->forum->logVisitTopic($this->params['type'], $model->UNID,  $list['ID_TOPIC'], $user);
			DooUriRouter::redirect(MainHelper::site_url('forum/' . $this->data['type'] . '/' . $this->params['id'] . '/' . $this->params['board']));
		}else{
			DooUriRouter::redirect(MainHelper::site_url('login/loginfirst'));
		}
	}

	public function setBanUser(){
		if(Auth::isUserLogged()){
			$model = Forum::getModelByUrl($this->data['type'], $this->params['id']);
			$name = $model->UNNAME;
			$user = $this->data['user'];
			if ($model->isForumAdmin() OR $model->isForumMod() OR $model->isBoardMod($this->data['type'], $model->UNID, $this->params['board'], $user->ID_PLAYER) ) {
				$forum = new Forum();
			
				$list['user'] = $user;

				$list['type'] = $this->data['type']; 
				$list['id'] = $model->UNID;  
				$list['url'] = $model->UNNAME;
				$list['board_id'] = $this->params['board'];
				$list['topic_id'] = $this->params['topic'];
				$list['msgid'] = $this->params['msgid'];
				 
				$messageInfo  = $this->forum->getMessage ($model->UNID, $this->data['type'],  $this->params['board'], $this->params['topic'],  $this->params['msgid']);
				$list['id_player'] = $messageInfo->ID_PLAYER;
				$list['playersIP'] = $messageInfo->PosterIP;
				$list['playername'] = $messageInfo->PosterName;

				echo $this->renderBlock('forum/admin/addBanUser', $list);
			} else {
					DooUriRouter::redirect($model->FORUM_URL);
			}
		}else{
				DooUriRouter::redirect(MainHelper::site_url('login/loginfirst'));
		}
	}

	// ok
	public function ajaxBanUser() {
			if($this->isAjax()) {
				//if(MainHelper::validatePostFields(array('type','id','id_player','PosterIP','bantime','banfrom'))) {
					$model = Forum::getModelByID($_POST['type'], $_POST['id']);
					if ($model->isForumAdmin() OR $model->isForumMod() OR $model->isBoardMod($this->data['type'], $model->UNID, $this->params['board'], $user->ID_PLAYER) ) {
						$startDate = date('Y-m-d');

						if($_POST['bantime'] > -1) {
							// get current dato.
							$current_date = getdate();
							$day = $current_date['mday'];
							$month = $current_date['mon'];
							$year = $current_date['year'];

							$banTime = $_POST['bantime'];

							$banYear = floor($banTime / 365);
							$yearRemaining = ($banYear > 0) ? floor((($banTime / 365) - $banYear) * $banTime) : 0;
							$banMonth = ($yearRemaining >= 30) ? floor($yearRemaining / 30) : 0;
							$monthRemaining = ($yearRemaining >= 30) ? floor((($yearRemaining / 30) - $banMonth) * $banTime) : 0;

							if($monthRemaining > 0) {
								$banDay = $monthRemaining;
							}	elseif ($yearRemaining > 0) {
								$banDay = $yearRemaining;
							} else {
									$banDay = $banTime;
							}

							// DateTime object.
							$endDateObj = new DateTime();
							$endDateObj->setDate($year + $banYear, $month + $banMonth, $day + $banDay);
										 
							//banning ends date(sting)
							$endDate = $endDateObj->format("Y-m-d");
							$unlimited = 0;

							$result['result'] = $this->forum->forumBan($_POST['type'], $_POST['id'],  $_POST['id_player'],$_POST['banfrom'], $_POST['PosterIP'], $startDate, $endDate, $unlimited);
							$this->toJSON($result, true);
						} else {
							$endDate = 0000-00-00;
							$unlimited = 1;  

							$result['result'] = $this->forum->forumBan($_POST['type'], $_POST['id'],  $_POST['id_player'], $_POST['banfrom'], $_POST['PosterIP'], $startDate, $endDate, $unlimited);
							$this->toJSON($result, true);
						}
					}
				/*} else {
					$this->toJSON(array('result' => false), true);
				}*/
			} else {
				// if not ajax
				$this->toJSON(array('result' => false), true);
			}
	}

	// bannedmembers page

	public function bannedmembers(){
		if(Auth::isUserLogged()){
			$model = Forum::getModelByUrl($this->data['type'], $this->params['id']);

			if($model->isForumAdmin() or $model->isForumMod() ){
				$list['type'] = $this->data['type']; 
				$list['id'] = $model->UNID;
				$list['url'] = $this->params['id'];
				$list['model'] = $model;

				// get all ACTIVE BANS
				$list['activeBans'] = $this->forum->allActiveBans($this->data['type'], $model->UNID);
				// get all NON ACTIVE BANS
				$list['banHistory'] = $this->forum->banHistory($this->data['type'],$model->UNID);

				$this->addCrumb($model->UNNAME, $model->FORUM_URL);
				$this->addCrumb('Banned members');
				$list['crumb'] = $this->getCrumb();
				// page data
				$list['page'] = 'forum_bannedmembers';
				$data['body_class'] = 'index_forum_forum forums';
				$data['title']= 'Banned members';
				if($this->data['type'] =='company'){
					$data['left'] = MainHelper::companiesLeftSide($model, 'forum');
				}elseif ($this->data['type'] =='game') {				
					$data['left'] = MainHelper::gamesLeftSide($model, 'forum');
				}elseif ($this->data['type'] == 'group') {				
					$data['left'] = MainHelper::groupsLeftSide($model, 'forum');
				}
				$data['right'] = PlayerHelper::playerRightSide();
				$data['footer'] = MainHelper::bottomMenu();
				$data['header'] = MainHelper::topMenu();

				$data['content'] = $this->renderBlock('forum/' . $list['page'], $list);
				$this->render3Cols($data);


			}else{
				DooUriRouter::redirect($model->FORUM_URL);
			}
		}else{
				DooUriRouter::redirect(MainHelper::site_url('login/loginfirst'));
		}
	}

	public function ajaxDeactivateBan(){
		if(Auth::isUserLogged()){
			if($this->isAjax()) {
				$result['result'] = $this->forum->deactivateBan($_POST['ID_SUSPEND'] );
				$this->toJSON($result, true);;
			}else{
				$this->toJSON(array('result' => false), true);
			}
		}else{
				DooUriRouter::redirect(MainHelper::site_url('login/loginfirst'));
		}
	}

	public function ajaxMoveToHistory(){
		if(Auth::isUserLogged()){
			if($this->isAjax()) {
				$result['result'] = $this->forum->moveBanToHistory($_POST['ID_SUSPEND'] );
				$this->toJSON($result, true);;
			}else{
				$this->toJSON(array('result' => false), true);
			}
		}else{
				DooUriRouter::redirect(MainHelper::site_url('login/loginfirst'));
		}
	}


} // ends the forumcontroller 
?>
