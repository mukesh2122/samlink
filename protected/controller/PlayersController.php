<?php

class PlayersController extends SnController {

	public function beforeRun($resource, $action) {
        if($rs = parent::beforeRun($resource, $action)) { return $rs; };

		$ftuBlockedActions = array(
			'myGames',
			'myEvents',
			'myGroups',
			'myFriends',
			'mySubscriptions',
			'notifications',
			'messages',
			'wall'
		);
		$player = User::getUser();
		if(isset($this->params['player_url'])) {
			//Avoid looking at banned or deactivated profile, except yourself
			$profilePlayer = User::getFriend($this->params['player_url']);
			if(!empty($player) && $profilePlayer->ID_PLAYER != $player->ID_PLAYER) {
				$suspendLevel = ($profilePlayer) ? $profilePlayer->getSuspendLevel() : 0;
				$notVisible = ($suspendLevel==4 || $suspendLevel==5);
                if($notVisible) { DooUriRouter::redirect(MainHelper::site_url('player/disabled')); };
			};
		};
		if($player && $player->IntroSteps < Doo::conf()->FTUsteps && in_array($action, $ftuBlockedActions)) {
			$this->forcedFtu();
		};
	}

	public function disabled() {
		$this->moduleOff();

		$data['title'] = $this->__('Disabled user');
		$data['body_class'] = 'index_players';
		$data['selected_menu'] = 'players';
		$data['left'] = '';
		$data['right'] = PlayerHelper::playerRightSide();
		$data['content'] = $this->renderBlock('players/disabled', array());
		$data['footer'] = MainHelper::bottomMenu();
		$data['header'] = MainHelper::topMenu();

		$this->render3Cols($data);
	}

	public function moduleOff() {
		$notAvailable = MainHelper::TrySetModuleNotAvailableByTag('reguser');
		if($notAvailable) {
			$data['title'] = $this->__('All Players');
			$data['body_class'] = 'index_players';
			$data['selected_menu'] = 'players';
			$data['left'] = PlayerHelper::playerLeftSide();
			$data['right'] = PlayerHelper::playerRightSide();
			$data['content'] = $notAvailable;
			$data['footer'] = MainHelper::bottomMenu();
			$data['header'] = MainHelper::topMenu();
			$this->render3Cols($data);
			exit;
		};
	}

	public function forcedFtu() {
		$this->moduleOff();

		$data = array();
		$data['title'] = $this->__('First time user form');
		$data['body_class'] = 'index_forced_ftu';
		$data['selected_menu'] = 'players';
		$data['left'] = PlayerHelper::playerLeftSide('wall');
		$data['right'] = PlayerHelper::playerRightSide();
		$data['content'] = $this->renderBlock('players/content/forcedFtu', array());
		$data['footer'] = MainHelper::bottomMenu();
		$data['header'] = MainHelper::topMenu();
		$this->render3Cols($data);
		exit;
	}

	public function inviteFriends() {
		$this->moduleOff();

		$data = array();
		$data['title'] = $this->__('Invite friends');
		$data['body_class'] = 'index_invite';
		$data['selected_menu'] = 'players';
		$data['left'] = PlayerHelper::playerLeftSide('wall');
		$data['right'] = PlayerHelper::playerRightSide();
		$data['content'] = $this->renderBlock('players/content/invite', array());
		$data['footer'] = MainHelper::bottomMenu();
		$data['header'] = MainHelper::topMenu();
		$this->render3Cols($data);
	}

	public function index() {
		$this->moduleOff();

		$order = isset($this->params['order']) ? $this->params['order'] : '';
		if($order != 'asc' && $order != 'desc') { $order = 'desc'; };

		$tmpTab = isset($this->params['tab']) ? $this->params['tab'] : '';
        switch($tmpTab) {
            case 'my-games';
                $tab = 2;
                break;
            case 'my-groups';
                $tab = 3;
                break;
            case 'my-location';
                $tab = 4;
                break;
            default:
                $tab = 1;
        };

		$users = new User();
		$list = array();

        //Category tabs
        $list['selectedCategory'] = $ID_CATEGORY = (isset($this->params['ID_CATEGORY'])) ? $this->params['ID_CATEGORY'] : 0;

		$list['playerList'] = $users->sortPlayers(0, $tab, $order, $ID_CATEGORY);
		$list['tab'] = $tab;
		$list['order'] = $order;
		$list['total'] = $users->getTotal();

		$data['title'] = $this->__('All Players');
		$data['body_class'] = 'index_players';
		$data['selected_menu'] = 'players';
		$data['left'] = PlayerHelper::playerLeftSide();
		$data['right'] = PlayerHelper::playerRightSide();
		$data['content'] = $this->renderBlock('players/playerList', $list);
		$data['footer'] = MainHelper::bottomMenu();
		$data['header'] = MainHelper::topMenu();

		$this->render3Cols($data);
	}
	
    public function topList() {
        $this->moduleOff();
        $player = User::getUser();

		$users = new User();
		$list = array();

		$order = isset($this->params['order']) ? strtoupper($this->params['order']) : 'DESC';
		if(!($order === 'ASC' || $order === 'DESC')) { $order = 'DESC'; }

		$tmpTab = isset($this->params['tab']) ? $this->params['tab'] : '';

		switch($tmpTab) {
            case 'rating':
                $tab = 2;
                break;
            case 'this-week':
                $tab = 3;
                break;
            case 'all-time':
                $tab = 4;
                break;
            default:
                $tab = 1;
        };

		//Category tabs
                $ID_CATEGORY = (isset($this->params['ID_CATEGORY'])) ? $this->params['ID_CATEGORY'] : 0;

                $list['selectedCategory'] = $ID_CATEGORY;
		$list['playerList'] = $users->sortPlayers(0, $tab, $order, $ID_CATEGORY);
		$list['tab'] = $tab;
		$list['order'] = $order;
		$list['total'] = $users->getTotal();

		$data['title'] = $this->__('All Players');
		$data['body_class'] = 'index_players';
		$data['selected_menu'] = 'players';
		$data['left'] = PlayerHelper::playerLeftSide();
		$data['right'] = PlayerHelper::playerRightSide();
		$data['content'] = $this->renderBlock('players/topList', $list);
		$data['footer'] = MainHelper::bottomMenu();
		$data['header'] = MainHelper::topMenu();

		$this->render3Cols($data);
	}
	
	public function getPlayersAjax() {
		$player = $viewer = User::getUser();

		if($player and $this->isAjax() and MainHelper::validatePostFields(array('type', 'offset', 'id'))) {
			$users = new User();
			$list = array();
			$result = array();

			$tab = intval($_POST['id']);
			$order = ContentHelper::handleContentInput($_POST['type']);

			if($tab < 0 or $tab > 4) {
				$tab = 1;
			}

			//Category tabs
			if (isset($this->params['ID_CATEGORY']))
				$ID_CATEGORY = $this->params['ID_CATEGORY'];
			else
				$ID_CATEGORY = 0;

			$offset = isset($_POST['offset']) ? $_POST['offset'] : 0;
			$playerList = $users->getAllPlayers($offset, $tab, $order, $ID_CATEGORY);
			$result['total'] = $users->getTotal();
			$playersContent = '';

			if($playerList) {
				foreach ($playerList as $item) {
					$playersContent .= $this->renderBlock('common/player', array('player' => (object) $item, 'owner' => $player, 'viewer' => $viewer));
				}
			}

			$result['content'] = $playersContent;
			$this->toJSON($result, true);
		}
	}

	public function editProfile(){
		$this->moduleOff();

		$player = User::getUser();
		if(!$player) {
			DooUriRouter::redirect(MainHelper::site_url());
			return FALSE;
		}

		$membership = new Membership();
		$currentMemebership = $membership->getCurrentPackage();
		$nextMembership = $membership->getQueue();
		$currentFeatures = $membership->getCurrentFeatures();
		$list['user'] = $player;
		$list['currentMembership'] = $currentMemebership;
		$list['nextMembership'] = $nextMembership;
		$list['currentFeatures'] = $currentFeatures;
		$list['section'] = $this->params['section'];

		if(isset($this->params['order'])) {
			$list['orderWidgetsBy'] = $this->params['order'];
		}

		$data['title'] = $this->__('Edit profile');
		$data['body_class'] = 'edit_players';
		$data['selected_menu'] = 'players';
		$data['left'] = $this->renderBlock('players/edit_profile_menu', $list);
		$data['right'] = PlayerHelper::playerRightSide();
		$data['content'] = $this->renderBlock('players/edit_profile', $list);
		$data['footer'] = MainHelper::bottomMenu();
		$data['header'] = MainHelper::topMenu();

		$this->render3Cols($data);
	}

	public function editProfileAction(){
		$section = isset($this->params['section']) ? $this->params['section'] : 'personalinfo';
		$sectionLink = isset($this->params['section']) ? '/'.$this->params['section'] : '';
		$p = User::getUser();
		if ($p) {
			$p->updateProfile($_POST);
			if ($section=="personalinfo")
			{
				MainHelper::UpdateExtrafieldsByPOST('player',$p->ID_PLAYER);
				MainHelper::UpdateCategoryByPOST('player',$p->ID_PLAYER);
				MainHelper::UpdatePersonalInfo($p->ID_PLAYER);
			}
			if ($section=="privatesettings")
			{
				$SnPrivacy = new SnPrivacy;
				$SnPrivacy->UpdatePrivacySettingsByPost($p->ID_PLAYER);
			}
			if ($section=="widgets")
			{
				$user = $_POST['user'];
				$output = array_slice($_POST, 1);
				$visibleWidgets = array();
				$currentPos = array();

				foreach ($output as $key => $value) {
					$cleanName = str_replace('_', ' ', $key);
					if (strstr($cleanName, 'vcb')) {
						$widgetName = substr($cleanName, 4);
						$visibleWidgets[$widgetName] = $value;
					} else {
						$currentPos[$cleanName] = $value;
					}
				}

				$query = "UPDATE sn_playerwidget_rel SET isVisible = 0 WHERE ID_PLAYER = " . $user;
				Doo::db()->query($query);

				foreach ($visibleWidgets as $key => $value) {
					$widgetItem = MainHelper::getWidget($user, $key);

					$query = "UPDATE sn_playerwidget_rel SET isVisible = 1 WHERE ID_PLAYER = " . $user . " AND ID_WIDGET = " . $widgetItem['ID_WIDGET'];
					Doo::db()->query($query);
				}

				foreach ($currentPos as $key => $value) {
					$widgetItem = MainHelper::getWidget($user, $key);

					$query = "UPDATE sn_playerwidget_rel SET WidgetOrder = $value WHERE ID_PLAYER = " . $user . " AND ID_WIDGET = " . $widgetItem['ID_WIDGET'];
					Doo::db()->query($query);
				}
			}
		}
		DooUriRouter::redirect(MainHelper::site_url('players/edit'.$sectionLink));
	}
	/**
	 * searches companies
	 *
	 */
	public function search() {
		$this->moduleOff();

		if (!isset($this->params['searchText'])) {
			DooUriRouter::redirect(MainHelper::site_url());
			return FALSE;
		}
		$list = array();
		$search = new Search();

		$list['searchText'] = urldecode($this->params['searchText']);
		$totalResults = $search->getSearchTotal(urldecode($this->params['searchText']), SEARCH_PLAYER);
		$pager = $this->appendPagination($list, new stdClass(), $totalResults, MainHelper::site_url('players/search/' . urlencode($list['searchText'])), Doo::conf()->playersLimit);


		$list['searchTotal'] = $totalResults;
		$list['playerList'] = $search->getSearch(urldecode($this->params['searchText']), SEARCH_PLAYER, $pager->limit);

		$data['title'] = $this->__('Search results');
		$data['body_class'] = 'index_players';
		$data['selected_menu'] = 'players';
		$data['left'] = PlayerHelper::playerLeftSide();
		$data['right'] = PlayerHelper::playerRightSide();
		$data['content'] = $this->renderBlock('players/playerList', $list);
		$data['footer'] = MainHelper::bottomMenu();
		$data['header'] = MainHelper::topMenu();
		$this->render3Cols($data);
	}

	public function wall() {
		$this->moduleOff();

		$player = User::getUser();
		if (!$player) {
			DooUriRouter::redirect(MainHelper::site_url());
			return FALSE;
		}

		//Redirect if walls not enabled
		if (MainHelper::IsModuleEnabledByTag('walls') == 0)
			DooUriRouter::redirect(MainHelper::site_url('players'));

		$wall = new Wall();
		$list = array();

		if(!isset($this->params['player_url'])){
			$friendUrl = '';
		} else {
			$friendUrl = $this->params['player_url'];
		}

		if(!isset($this->params['type'])){
			$type = WALL_HOME;
			if($friendUrl == '')
				$type = WALL_MAIN;
		} else {
			$type = $this->params['type'];
			if($friendUrl != '' and $type == WALL_MAIN)
				$type = WALL_HOME;
		}

		if($friendUrl == "") {
			$list['infoBox'] = MainHelper::loadInfoBox('Players', $type, true);
		}

		$poster = $friendUrl == '' ? $player : User::getFriend($friendUrl);
		$idAlbum = isset($this->params['id_album']) ? $this->params['id_album'] : 0;
		MainHelper::getWallPosts($list, $player, 0, $type, $friendUrl, $idAlbum);

		$list['poster']    = $poster;
		$list['friendUrl'] = $friendUrl;
		$list['wallType']  = $type;

		$data['title'] = $this->__('Profile Page');
		$data['body_class'] = 'index_players';
		$data['selected_menu'] = 'players';
		$data['left']   = PlayerHelper::playerLeftSide('wall', $friendUrl);
		$data['right']  = PlayerHelper::playerRightSide();
		$data['footer'] = MainHelper::bottomMenu();
		$data['header'] = MainHelper::topMenu();
		
		 PlayerHelper::updateVisitCountPlayer($poster->ID_PLAYER);

		if ($type == WALL_PHOTO) {
			$album = new Album;
			$albums = $album->getAlbumsByUser($poster);       // Get own wallitem in albums
			$taggedItems = $album->getAlbumsByTag($poster);   // Get wallitems in albums on which the player is tagged
			if (!empty($taggedItems) && !empty($albums)){
				foreach($taggedItems as $item){
					foreach($albums as $key=>$alb){
						if ($item->ID_ALBUM == $alb->ID_ALBUM){
							$albums[$key]->SnWallitems[] = $item;   // Merge tagged items with own items
							break;
						}
					}
				}
				//---- Resort albums by descending postingtime----
				foreach($albums as $key=>$alb){
					uasort($albums[$key]->SnWallitems, function($a, $b){
						return $b->PostingTime - $a->PostingTime;
					});
				}
			}

			$list['albums'] = $albums;
			$list['currentAlbum'] = $album->getById($idAlbum);
			$data['content'] = $this->renderBlock('players/albums', $list);
		}
		elseif ($type == WALL_BLOG) {
			$blog = new Blog;
			$list['blogs'] = $blog->getLatestBlog(10000,$poster->ID_PLAYER);
						$data['left']   = PlayerHelper::playerLeftSide('wall', $friendUrl, 'blog');
			$data['content'] = $this->renderBlock('players/blogs', $list);
		}
		else {
			$data['content'] = $this->renderBlock('players/wall', $list);
		}

		$this->render3Cols($data);
	}

	public function editAlbum() {
		$this->moduleOff();

		$player = User::getUser();
		if (!$player) {
			DooUriRouter::redirect(MainHelper::site_url());
			return FALSE;
		}

		//Redirect if walls not enabled
		if (MainHelper::IsModuleEnabledByTag('walls') == 0)
			DooUriRouter::redirect(MainHelper::site_url('players'));

		$idAlbum = $this->params['id'];
		if (isset($_POST) && !empty($_POST)) {
			$album = new Album;
			if ($idAlbum == 0) {
				$idAlbum = $album->create($player, $_POST);
				header('Location: '.MainHelper::site_url('players/wall/'.WALL_PHOTO.'/'.$idAlbum));
				exit;
			}
			else {
				$album->update($idAlbum, $_POST);
			}
			header('Location: '.MainHelper::site_url('players/wall/'.WALL_PHOTO));
			exit;
		}

		if(!isset($this->params['player_url'])){
			$friendUrl = '';
		} else {
			$friendUrl = $this->params['player_url'];
		}

		if(!isset($this->params['type'])){
			$type = WALL_HOME;
			if($friendUrl == '')
				$type = WALL_MAIN;
		} else {
			$type = $this->params['type'];
			if($friendUrl != '' and $type == WALL_MAIN)
				$type = WALL_HOME;
		}

		$list = array();
		$album = new Album;

		if($friendUrl == "") {
			$list['infoBox'] = MainHelper::loadInfoBox('Players', $type, true);
		}

		$poster = $friendUrl == '' ? $player : User::getFriend($friendUrl);

		$list['poster'] = $poster;
		$list['friendUrl'] = $friendUrl;
		$list['wallType'] = $type;

		if ($idAlbum == 0) {
			$list['title'] = $this->__('New Album');
			$data['title'] = $this->__('New Album');
			$album->ID_ALBUM = 0;
			$album->AlbumName = '';
			$album->AlbumDescription = '';
			$list['album'] = $album;
		}
		else {
			$list['title'] = $this->__('Edit Album');
			$data['title'] = $this->__('Edit Album');
			$list['album'] = $album->getById($idAlbum);
		}

		$data['body_class'] = 'index_players';
		$data['selected_menu'] = 'players';
		$data['left']    = PlayerHelper::playerLeftSide('wall', $friendUrl);
		$data['right']   = PlayerHelper::playerRightSide();
		$data['content'] = $this->renderBlock('players/edit_album', $list);
		$data['footer']  = MainHelper::bottomMenu();
		$data['header']  = MainHelper::topMenu();

		$this->render3Cols($data);
	}

	public function removeAlbum() {
		$this->moduleOff();

		$player = User::getUser();
		if (!$player) {
			DooUriRouter::redirect(MainHelper::site_url());
			return FALSE;
		}

		//Redirect if walls not enabled
		if (MainHelper::IsModuleEnabledByTag('walls') == 0)
			DooUriRouter::redirect(MainHelper::site_url('players'));

		$album = new Album;
		$album->remove($player->ID_PLAYER, $this->params['id']);

		header('Location: '.MainHelper::site_url('players/wall/'.$this->params['type']));
		exit;
	}

	public function editPost() {
		$this->moduleOff();

		$player = User::getUser();
		if (!$player) {
			DooUriRouter::redirect(MainHelper::site_url());
			return FALSE;
		}

		//Redirect if walls not enabled
		if (MainHelper::IsModuleEnabledByTag('walls') == 0)
			DooUriRouter::redirect(MainHelper::site_url('players'));

		//---- Update post album and description, then return to previous album ----
		if (isset($_POST) && !empty($_POST)) {
			$wallItems = new SnWallitems;
			$wallItems->ID_WALLITEM = $this->params['id'];
			$wallItems->ItemType = $this->params['type'];
			$post = Doo::db()->find($wallItems, array('limit' => 1));
			$idAlbum = $post->ID_ALBUM;
			if ($post->ID_OWNER == $player->ID_PLAYER){
				$message = unserialize($post->Message);
				if (isset($_POST['description'])){
					$message['description'] = $_POST['description'];
					$wallItems->Message = serialize($message);
				}
				$wallItems->ID_ALBUM = isset($_POST['newalbum']) ? $_POST['newalbum'] : 0;
				$wallItems->update();
			}
			$walltags = new SnWalltags;
			$walltags->ID_WALLITEM = $this->params['id'];
			$walltags->ID_TAGGED = $player->ID_PLAYER;
			$walltag = Doo::db()->find($walltags, array('limit' => 1));
			if (!empty($walltag)){
				$idAlbum = $walltag->ID_ALBUM;
				$walltag->ID_ALBUM = isset($_POST['newalbum']) ? $_POST['newalbum'] : 0;
				$walltag->update();
			}
			Album::imageCountMove($_POST['oldalbum'], $_POST['newalbum']);
			header('Location: '.MainHelper::site_url('players/wall/'.WALL_PHOTO.'/'.$idAlbum));
			exit;
		}

		if(!isset($this->params['player_url'])){
			$friendUrl = '';
		} else {
			$friendUrl = $this->params['player_url'];
		}

		if(!isset($this->params['type'])){
			$type = WALL_HOME;
			if($friendUrl == '')
				$type = WALL_MAIN;
		} else {
			$type = $this->params['type'];
			if($friendUrl != '' and $type == WALL_MAIN)
				$type = WALL_HOME;
		}
		$list = array();
		if($friendUrl == "") {
			$list['infoBox'] = MainHelper::loadInfoBox('Players', $type, true);
		}

		$poster = $friendUrl == '' ? $player : User::getFriend($friendUrl);

		$albums = new Album;
		$list['albums'] = $albums->getAlbumsByUser($poster);
		$wallItems  = new SnWallitems;
		$wallItems->ID_WALLITEM = $this->params['id'];
		$wallItems->ItemType = $this->params['type'];
		$post = Doo::db()->find($wallItems, array('limit' => 1));
		$message = isset($post->Message) ? unserialize($post->Message) : '';
		$description = isset($message['description']) ? $message['description'] : '';

		//--- get ID_ALBUM from walltags if player is tagged ---
		$walltags = new SnWalltags;
		$walltags->ID_WALLITEM = $this->params['id'];
		$walltags->ID_TAGGED = $player->ID_PLAYER;
		$walltag = Doo::db()->find($walltags, array('limit' => 1));
		if (!empty($walltag)){
			$post->ID_ALBUM = $walltag->ID_ALBUM;
		}

		$list['post'] = $post;
		$list['description'] = $description;
		$list['poster'] = $poster;
		$list['friendUrl'] = $friendUrl;
		$list['wallType'] = $type;
		$list['title'] = $this->__('Edit image');

		$data['title'] = $this->__('Edit image');
		$data['body_class'] = 'index_players';
		$data['selected_menu'] = 'players';
		$data['left']    = PlayerHelper::playerLeftSide('wall', $friendUrl);
		$data['right']   = PlayerHelper::playerRightSide();
		$data['content'] = $this->renderBlock('players/edit_post', $list);
		$data['footer']  = MainHelper::bottomMenu();
		$data['header']  = MainHelper::topMenu();

		$this->render3Cols($data);
	}

	/**
	 * Renders iframe with photo/video and comments
	 *
	 * @return String
	 */
	public function iframeShowPhoto() {
		$id = $this->params['id_wallitem'];
		$type = $this->params['item_type'];
		if ($id > 0 and $type) {
			$wall = new Wall();
			$wallitem = $wall->getPost($id, true);

			if ($wallitem) {
				$val = array('poster' => $wallitem->getPoster(), 'item' => $wallitem, 'num' => 0);
				echo $this->renderBlock('wall/' . $type . '_full', $val);
			}
		}
	}

	/**
	 * Renders iframe with photo/video popus and comments
	 *
	 * @return String
	 */
	public function iframeShowPhotoPopup() {
		$id = $this->params['id_wallitem'];
		$type = $this->params['item_type'];
		if ($id > 0 and $type) {
			$wall = new Wall();
			$wallitem = $wall->getPost($id, true);

			if ($wallitem) {
				$val = array('poster' => $wallitem->getPoster(), 'item' => $wallitem, 'num' => 0);
				echo $this->renderBlock('wall/' . $type . '_popup', $val);
			}
		}
	}

	/**
	 * Renders iframe with photo/video popus and comments
	 *
	 * @return String
	 */
	public function iframeShowPhotoTag() {
		$id = $this->params['id_wallitem'];
		$type = $this->params['item_type'];
		if ($id > 0 and $type) {
			$wall = new Wall();
			$wallitem = $wall->getPost($id, true);

			if ($wallitem) {
				$val = array('poster' => $wallitem->getPoster(), 'item' => $wallitem, 'num' => 0);
				echo $this->renderBlock('wall/' . $type . '_tag', $val);
			}
		}
	}

	/**
	 * Tag individuals in photos
	 *
	 * @return JSON
	 */
	public function ajaxPhotoTag() {
        if(!Auth::isUserLogged()) { DooUriRouter::redirect(MainHelper::site_url('login/loginfirst')); };
		if($this->isAjax()) {
            $postVals = filter_input_array(INPUT_POST);
			if(!empty($postVals)) {
				$wallTags = new Walltags();
                $result = $wallTags->updateTagSet($postVals['tag']);
//				$result['tagnames'] = $wallTags->updateTagSet($postVals['tag']);
            } else { $result['error'] = 'Empty request, no tags'; };
        } else { $result['error'] = 'Not an AJAX request'; }
        $this->toJSON($result, TRUE);
	}

	/**
	 * Untag/Block individuals in photos
	 *
	 * @return JSON
	 */
	public function ajaxPhotoUntag() {
		if($this->isAjax()) {
            $postVals = filter_input_array(INPUT_POST);
			if(!empty($postVals)) {
				$walltags = new Walltags();
				$result['tagnames'] = $walltags->untag($postVals['untag']);
				$this->toJSON($result, TRUE);
			}
		}
	}

	/**
	 * Toggle public/private post
	 *
	 * @return JSON
	 */
	public function ajaxTogglePublic() {
		if($this->isAjax()) {
            $postVals = filter_input_array(INPUT_POST);
			if(!empty($postVals)) {
                $wall = new Wall();
                $result['result'] = $wall->setPublic($postVals['pid']);
                $this->toJSON($result, TRUE);
            }
		}
	}

	/**
	 * Upload photo
	 *
	 * @return JSON
	 */
	public function ajaxUploadPhoto() {
		$user = new User();
		$userID = 0;
		if(isset($this->params['user_id'])) {
			$userID = intval($this->params['user_id']);
		}
		$upload = $user->uploadPhoto($userID);

		if ($upload['filename'] != '') {
			$file = MainHelper::showImage($upload['p'], THUMB_LIST_200x300, true, array('width', 'no_img' => 'noimage/no_player_200x300.png'));
			$small = MainHelper::showImage($upload['p'], THUMB_LIST_100x100, true, array('width', 'no_img' => 'noimage/no_player_100x100.png'));
			echo $this->toJSON(array('success' => TRUE, 'img' => $file, 'img100x100' => $small));
		} else {
			echo $this->toJSON(array('error' => $upload['error']));
		}
	}

	public function ajaxWallUploadPhoto() {
		$wall = new Wall();
		$id_album = 0;
		if (isset($_GET['id_album']) && !empty($_GET['id_album'])) {
			$id_album = $_GET['id_album'];
		}
		$upload = $wall->uploadPhoto($_GET['friend'], $id_album);
		Album::imageCountInc($id_album);
		if(!isset($this->params['empty'])){
			if($upload != false){
				if ($upload['filename'] != '') {
					echo $this->toJSON(array('success' => TRUE));
				} else {
					echo $this->toJSON(array('error' => $upload['error']));
				}
			}
		}
	}

	/**
	 * Update profile
	 *
	 * @return JSON
	 */
	public function ajaxUpdateProfile() {
		if ($this->isAjax()) {
			$p = User::getUser();
			if ($p) {
				$p->updateProfile($_POST);

				$result['year'] = PlayerHelper::calculateAge($p->DateOfBirth);
				$result['dob'] = $p->DateOfBirth;
				$result['country'] = PlayerHelper::getCountry($p->Country);
				$this->toJSON($result, true);
			}
		}
	}

	public function updateLang() {
		if(isset($this->params['langID'])){
			$referrer = $_SERVER['HTTP_REFERER'];
			$lang = intval($this->params['langID']);
			if(isset(Doo::conf()->lang[$lang])) {
				$p = User::getUser();
				if ($p) {
					$p->updateProfile(array('mainLanguage' => $lang));
				} else {
					Lang::setLang(Doo::conf()->lang[$lang]);
				}

				DooUriRouter::redirect($referrer);
				return false;
			}
		}
		DooUriRouter::redirect(MainHelper::site_url());
		return false;
	}

	public function UpdateFriendCategoriesByPost($ID_PLAYER)
	{
		if (isset($_POST['ID_FRIEND']) && isset($_POST['UpdateFriendCategories']))
		{
			$ID_FRIEND = $_POST['ID_FRIEND'];

			//Delete categories relation between player and friend
			Doo::db()->query("DELETE FROM sn_playerfriendcat_rel WHERE ID_FRIEND={$ID_FRIEND} AND ID_PLAYER={$ID_PLAYER}");

			if (isset($_POST['ID_CAT']))
			{
				$PosetedCateogies = $_POST['ID_CAT'];

				//Insert relations
				foreach ($PosetedCateogies as $c)
				{
					$query = "
						INSERT INTO sn_playerfriendcat_rel
						(ID_PLAYER,ID_FRIEND,ID_CAT)
						VALUES
						({$ID_PLAYER},{$ID_FRIEND},{$c})";
					Doo::db()->query($query);
				}
			}
		}
	}

	public function DeleteFriendCategoryByParams($ID_PLAYER)
	{
		//Add new user friend category
		if (isset($this->params['cat']))
		{
			if (strpos($this->params['cat'],'delete_') === 0)
			{
				$ID_CAT = str_replace('delete_','',$this->params['cat']);
				$query = "
					SELECT @n := Native FROM sn_playerfriendcat WHERE ID_PLAYER={$ID_PLAYER} AND ID_CAT={$ID_CAT};
					DELETE FROM sn_playerfriendcat WHERE ID_PLAYER={$ID_PLAYER} AND ID_CAT={$ID_CAT} AND NOT (@n);
					DELETE FROM sn_playerfriendcat_rel WHERE ID_PLAYER={$ID_PLAYER} AND ID_CAT={$ID_CAT} AND NOT (@n)";
					Doo::db()->query($query);
					DooUriRouter::redirect(MainHelper::site_url('players/my-friends/cat/0'));
			}
		}
	}

	public function AddFriendCategoryByParams($ID_PLAYER)
	{
		//Add new user friend category
		if (isset($this->params['cat']))
		{
			if ($this->params['cat']=='add')
			{
				$query = "
					SELECT @MAX_CAT := IF(MAX(ID_CAT) IS NULL,0,MAX(ID_CAT))+1 FROM sn_playerfriendcat WHERE ID_PLAYER={$ID_PLAYER};
					INSERT INTO sn_playerfriendcat
					(CategoryName,ID_PLAYER,Native,ID_CAT )
					VALUES
					( CONCAT ('New',@MAX_CAT ), {$ID_PLAYER}, 0, @MAX_CAT )";

				Doo::db()->query($query);

				$query = "SELECT @MAX_CAT := MAX(ID_CAT) as NEWID FROM sn_playerfriendcat WHERE ID_PLAYER={$ID_PLAYER}";
				$rs = Doo::db()->query($query)->fetchall();
				$NEWID = isset($rs[0]) ? $rs[0]['NEWID'] : "0";

				DooUriRouter::redirect(MainHelper::site_url('players/my-friends/cat/'.$NEWID));
			}
		}
	}

	public function UpdateFriendCategoryRenameByPost($ID_PLAYER)
	{
		if (isset($_POST['renamefriendcategory']))
		{
			if (isset($this->params['cat']))
			{
				$ID_CAT = $this->params['cat'];
				$newName = $_POST['renamefriendcategory'];
				$query = "UPDATE sn_playerfriendcat SET CategoryName='{$newName}' WHERE ID_CAT={$ID_CAT} AND ID_PLAYER={$ID_PLAYER}";
				Doo::db()->query($query);
				DooUriRouter::redirect(MainHelper::site_url('players/my-friends/cat/'.$ID_CAT));
			}
		}
	}

	/**
	 * Displays blocks list
	 *
	 */
	public function myBlocks() {
		$this->moduleOff();

		$player = User::getUser();
		if (!$player) {
			DooUriRouter::redirect(MainHelper::site_url());
			return FALSE;
		}
		$list = array();

		$list['blockedUsers'] = $player->getBlockedUsersList($player->ID_PLAYER);

		$data['title'] = $this->__('My blocks');
		$data['body_class'] = 'index_my_blocks';
		$data['selected_menu'] = 'players';
		$data['left'] = PlayerHelper::playerLeftSide('blocks');
		$data['right'] = PlayerHelper::playerRightSide();
		$data['content'] = $this->renderBlock('players/content/myBlocks', $list);
		$data['footer'] = MainHelper::bottomMenu();
		$data['header'] = MainHelper::topMenu();
		$this->render3Cols($data);
	}


	/**
	 * Displays friend list
	 *
	 */
	public function myFriends() {
		$this->moduleOff();

		$player = User::getUser();
		if (!$player) {
			DooUriRouter::redirect(MainHelper::site_url());
			return FALSE;
		}
		$list = array();

		//Delete user friend category
		$this->DeleteFriendCategoryByParams($player->ID_PLAYER);
		//Add new user friend category
		$this->AddFriendCategoryByParams($player->ID_PLAYER);

		//Update possible changes in selected friends categories
		$this->UpdateFriendCategoriesByPost($player->ID_PLAYER);
		$selectedfriendcatid = isset($this->params['cat']) ? $this->params['cat'] : '';
		$list['selectedfriendcatid'] = $selectedfriendcatid;

		//Update possible category rename
		$this->UpdateFriendCategoryRenameByPost($player->ID_PLAYER);

		$search = isset($this->params['search']) ? urldecode($this->params['search']) : '';
		$friendCount = $player->getFriendsCount($search, $selectedfriendcatid);
		$url = $search != "" ? MainHelper::site_url('players/my-friends/search/'.  urlencode($search).'/page') : MainHelper::site_url('players/my-friends/page');
		$pager = $this->appendPagination($list, $player, $friendCount, $url, Doo::conf()->playersLimit);

		$list['searchTotal'] = $friendCount;
		$list['searchText'] = $search;
		$list['friends'] = $player->getFriendsList($search, true, 0, $pager->limit, $selectedfriendcatid);
		$list['blockedUsers'] = $player->getBlockedUsersList($player->ID_PLAYER);

		$data['title'] = $this->__('My friends');
		$data['body_class'] = 'index_my_friends';
		$data['selected_menu'] = 'players';
		$data['left'] = PlayerHelper::playerLeftSide('friends');
		$data['right'] = PlayerHelper::playerRightSide();
		$data['content'] = $this->renderBlock('players/content/myFriends', $list);
		$data['footer'] = MainHelper::bottomMenu();
		$data['header'] = MainHelper::topMenu();
		$this->render3Cols($data);
	}

	public function playerFriends() {
		$this->moduleOff();

		$viewer = User::getUser();
		$player = User::getFriend($this->params['player_url']);

		if (!$player or !$viewer) {
			DooUriRouter::redirect(MainHelper::site_url());
			return FALSE;
		}
		$list = array();

		$selectedfriendcatid = isset($this->params['cat']) ? $this->params['cat'] : '';
		$list['selectedfriendcatid'] = $selectedfriendcatid;

		$search = isset($this->params['search']) ? urldecode($this->params['search']) : '';
		$friendCount = $player->getFriendsCount($search, $selectedfriendcatid);
		$url = !empty($search) ? MainHelper::site_url('player/' . $player->URL . '/friends/search/'.  urlencode($search).'/page') : MainHelper::site_url('player/' . $player->URL . '/friends/page');
		$pager = $this->appendPagination($list, $player, $friendCount, $url, Doo::conf()->playersLimit);

		$list['searchTotal'] = $friendCount;
		$list['searchText'] = $search;
		$list['playerList'] = $player->getFriendsList($search, false, $viewer->ID_PLAYER, $pager->limit, $selectedfriendcatid);

		$list['player'] = $viewer;
		$list['friendUrl'] = $player->URL;
		$list['friend'] = $player;
		$list['poster'] = $player;

		$data['title'] = $this->__('Friends');
		$data['body_class'] = 'index_my_friends';
		$data['selected_menu'] = 'players';
		$data['left'] = PlayerHelper::playerLeftSide('friends', $player->URL);
		$data['right'] = PlayerHelper::playerRightSide();
		$data['content'] = $this->renderBlock('players/content/playerFriends', $list);
		$data['footer'] = MainHelper::bottomMenu();
		$data['header'] = MainHelper::topMenu();
		$this->render3Cols($data);
	}

	/**
	 * Returns friends list
	 *
	 * @return JSON
	 */
	public function ajaxGetFriends() {
		if ($this->isAjax()) {
			$player = User::getUser();
			if ($player) {
				$offset = isset($_POST['offset']) ? $_POST['offset'] : 0;
				if (isset($_POST['friend_url'])) {
					$friend = User::getFriend($_POST['friend_url']);
					$plist = $friend->getFriends($offset, "", FALSE, $player->ID_PLAYER);
				} else {
					$plist = $player->getFriends($offset);
				}

				$result['total'] = $plist->total;
				$string = '';

				if (isset($plist->list) and !empty($plist->list)) {
					$data = array('friends' => $plist->list, 'player' => $player, "offset" => $offset);
					if (isset($_POST['friend_url'])) {
						$data['friend'] = $friend;
					}

					$string = $this->renderBlock('players/content/friend_container', $data);
				}

				$result['content'] = $string;
				$this->toJSON($result, true);
			}
		}
	}

	/**
	 * Complete delete of friend
	 *
	 * @return JSON
	 */
	public function ajaxDeleteFriend() {
		if ($this->isAjax()) {
			$player = User::getUser();

			if ($player) {
				$result['result'] = $player->friendDelete($_POST['fid']);
				$player->purgeCache();
				$this->toJSON($result, true);
			}
		}
	}

	/**
	 * Deletes suggestion in players list
	 *
	 * @return JSON
	 */
	public function ajaxHidePlayerSuggestion() {
		if ($this->isAjax() and MainHelper::validatePostFields(array('url'))) {
			$player = User::getUser();

			if ($player) {
				$url = ContentHelper::handleContentInput($_POST['url']);
				$suggestedPlayer = User::getFriend($url);
				if($suggestedPlayer) {
					$result['result'] = $player->playerSuggestionHide($suggestedPlayer->ID_PLAYER);
					$player->purgeCache();
					$this->toJSON($result, true);
				}
			}
		}
	}

	/**
	 * Add friend request
	 *
	 * @return JSON
	 */
	public function ajaxInsertFriend() {
		if ($this->isAjax()) {
			$player = User::getUser();
			if ($player) {

				$result['result'] = $player->sendFriendRequest($_POST['fid']);
				$player->purgeCache();
				$result['content'] = '';
				if ($player->isFriend($_POST['fid'])) {
					$friend = new Players();
					$friend->ID_PLAYER = $_POST['fid'];
					$friend = $friend->getOne();
					$friend->Mutual = 1;

					$data['item'] = $friend;
					$data['isLogged'] = Auth::isUserLogged();
					$data['num'] = 1;
					$result['content'] = $this->renderBlock('players/content/friend', $data);
				}

				$this->toJSON($result, true);
			}
		}
	}

	/**
	 * Reject friend request
	 *
	 * @return JSON
	 */
	public function ajaxRejectFriend() {
		if ($this->isAjax()) {
			$player = User::getUser();
			if ($player) {
				$result['result'] = $player->rejectFriend($_POST['fid']);
				$player->purgeCache();
				$this->toJSON($result, true);
			}
		}
	}

	/**
	 * Toggle isplaying game
	 *
	 * @return JSON
	 */
	public function ajaxToggleIsPlayingGame() {
		if ($this->isAjax()) {
			$player = User::getUser();
			if ($player) {
				$result['result'] = $player->toggleIsPlayingGame($_POST['gid']);
				$player->purgeCache();
				$this->toJSON($result, true);
			}
		}
	}

	/**
	 * Public player profile
	 *
	 */
	public function playerProfile() {
		if ($this->params['player_url']) {
			if (!User::getFriend($this->params['player_url'])) {
				DooUriRouter::redirect(MainHelper::site_url());
				return false;
			}
			$data['title'] = $this->__('Profile Page');
			$data['body_class'] = 'index_player_profile';
			$data['selected_menu'] = 'players';
			$data['left'] = PlayerHelper::playerLeftSide('', $this->params['player_url']);
			$data['right'] = PlayerHelper::playerRightSide();
			$data['content'] = $this->renderBlock('players/tabs', array('posts' => '&nbsp;', 'friend_profile' => TRUE));
			$data['footer'] = MainHelper::bottomMenu();
			$data['header'] = MainHelper::topMenu();

			$this->render3Cols($data);
		} else {
			DooUriRouter::redirect(Doo::conf()->APP_URL);
		}
	}

	public function mySubscriptions() {
		$this->moduleOff();

		$player = User::getUser();
		if (!$player) {
			DooUriRouter::redirect(MainHelper::site_url());
			return FALSE;
		}
		$list = array();
		$user = new User();
		$list['infoBox'] = MainHelper::loadInfoBox('Players', 'mySubscriptions', true);
		$list['generalList'] = $user->getSubscriptionsTypes($player->ID_PLAYER);

		$search = isset($this->params['search']) ? urldecode($this->params['search']) : '';
		$type = isset($this->params['type']) ? $this->params['type'] : '';
		$typeURL = isset($this->params['type']) ? '/'.$this->params['type'] : '';
		$url = isset($this->params['search']) ? MainHelper::site_url('players/my-subscriptions/search/'.  urlencode($search).'/page') : MainHelper::site_url('players/my-subscriptions'.$typeURL.'/page');

		$subscriptionsCount = $user->getSubscriptionsCount($player->ID_PLAYER, $type, $search);
		$pager = $this->appendPagination($list, $user, $subscriptionsCount, $url, Doo::conf()->subscriptionsLimit);

		$list['searchTotal'] = $subscriptionsCount;
		$list['searchText'] = $search;

		$list['list'] = $user->getSubscriptions($player->ID_PLAYER, $type, $search, $pager->limit);
		$list['itemType'] = $type;
		$list['search'] = $search;
		$list['total'] = $subscriptionsCount;

		$data['title'] = $this->__('My Subscriptions');
		$data['body_class'] = 'index_subscriptions';
		$data['selected_menu'] = 'players';
		$data['left'] = PlayerHelper::playerLeftSide('subscription');
		$data['right'] = PlayerHelper::playerRightSide();

		$data['content'] = $this->renderBlock('players/content/subscriptions', $list);
		$data['footer'] = MainHelper::bottomMenu();
		$data['header'] = MainHelper::topMenu();
		$this->render3Cols($data);
	}

	public function myGroups() {
		$this->moduleOff();

		$player = User::getUser();
		if (!$player) {
			DooUriRouter::redirect(MainHelper::site_url());
			return FALSE;
		}
		$groups = new Groups();
		$list = array();
		$list['infoBox'] = MainHelper::loadInfoBox('Players', 'myGroups', true);

		$search = isset($this->params['search']) ? urldecode($this->params['search']) : '';
		$groupsCount = $groups->getTotalPlayerGroups($player, $search);
		$url = $search != "" ? MainHelper::site_url('players/my-groups/search/'.  urlencode($search).'/page') : MainHelper::site_url('players/my-groups/page');
		$pager = $this->appendPagination($list, $groups, $groupsCount, $url, Doo::conf()->playerGroupsLimit);

		$list['searchTotal'] = $groupsCount;
		$list['searchText'] = $search;

		if($search == ''){
			$list['groups'] = $groups->getPlayerGroups($player, $pager->limit);
		} else{
			$list['groups'] = $groups->getSearchPlayerGroups($search, $player, $pager->limit);
		}

		$data['title'] = $this->__('My Groups');
		$data['body_class'] = 'index_my_groups';
		$data['selected_menu'] = 'players';
		$data['left'] = PlayerHelper::playerLeftSide('groups');
		$data['right'] = PlayerHelper::playerRightSide();
		$data['content'] = $this->renderBlock('players/content/myGroups', $list);
		$data['footer'] = MainHelper::bottomMenu();
		$data['header'] = MainHelper::topMenu();
		$this->render3Cols($data);
	}

	public function playerGroups() {
		$this->moduleOff();

		$player = User::getFriend($this->params['player_url']);
		if (!$player) {
			DooUriRouter::redirect(MainHelper::site_url());
			return FALSE;
		}

		$groups = new Groups();
		$list = array();

		$list['player'] = $player;
		$list['friendUrl'] = $player->URL;

		$search = isset($this->params['search']) ? urldecode($this->params['search']) : '';
		$groupsCount = $groups->getTotalPlayerGroups($player, $search);
		$url = $search != "" ? MainHelper::site_url('player/' . $player->URL . '/groups/search/'.  urlencode($search).'/page') : MainHelper::site_url('player/' . $player->URL . '/groups/page');
		$pager = $this->appendPagination($list, $groups, $groupsCount, $url, Doo::conf()->playerGroupsLimit);

		$list['searchTotal'] = $groupsCount;
		$list['searchText'] = $search;

		if($search == ''){
			$list['groups'] = $groups->getPlayerGroups($player, $pager->limit);
		} else{
			$list['groups'] = $groups->getSearchPlayerGroups($search, $player, $pager->limit);
		}

		$poster = $player->URL == '' ? $player : User::getFriend($player->URL);
		$list['poster'] = $poster;

		$data['title'] = $this->__('Groups');
		$data['body_class'] = 'index_my_groups';
		$data['selected_menu'] = 'players';
		$data['left'] = PlayerHelper::playerLeftSide('groups', $player->URL);
		$data['right'] = PlayerHelper::playerRightSide();
		$data['content'] = $this->renderBlock('players/content/playerGroups', $list);
		$data['footer'] = MainHelper::bottomMenu();
		$data['header'] = MainHelper::topMenu();
		$this->render3Cols($data);
	}

	public function myGames() {
		$this->moduleOff();

		$player = User::getUser();
		if (!$player) {
			DooUriRouter::redirect(MainHelper::site_url());
			return FALSE;
		}
		$games = new Games();
		$list = array();
		$list['infoBox'] = MainHelper::loadInfoBox('Players', 'myGames', true);

		$search = isset($this->params['search']) ? urldecode($this->params['search']) : '';

/*		if($search == ''){
			$list['games'] = $games->getPlayerGames($player, $pager->limit);
		} else{
			$list['games'] = $games->getSearchPlayerGames($search, $player, $pager->limit);
		}*/
		$gamesCount = $games->getTotalPlayerGames($player, $search);

		$url = $search != "" ? MainHelper::site_url('players/my-games/search/'.  urlencode($search).'/page') : MainHelper::site_url('players/my-games/page');
		$pager = $this->appendPagination($list, $games, $gamesCount, $url, Doo::conf()->playerGamesLimit);

		$list['searchTotal'] = $gamesCount;
		$list['searchText'] = $search;

		if($search == ''){
			$list['games'] = $games->getPlayerGames($player, $pager->limit);
		} else{
			$list['games'] = $games->getSearchPlayerGames($search, $player, $pager->limit);
		}


		$data['title'] = $this->__('My Games');
		$data['body_class'] = 'index_my_games';
		$data['selected_menu'] = 'players';
		$data['left'] = PlayerHelper::playerLeftSide('games');
		$data['right'] = PlayerHelper::playerRightSide();
		$data['content'] = $this->renderBlock('players/content/myGames', $list);
		$data['footer'] = MainHelper::bottomMenu();
		$data['header'] = MainHelper::topMenu();
		$this->render3Cols($data);
	}

	public function playerGames() {
		$this->moduleOff();

		$player = User::getFriend($this->params['player_url']);
		if (!$player) {
			DooUriRouter::redirect(MainHelper::site_url());
			return FALSE;
		}
		$games = new Games();
		$list = array();

		$search = isset($this->params['search']) ? urldecode($this->params['search']) : '';
		$gamesCount = $games->getTotalPlayerGames($player, $search);
		$url = $search != "" ? MainHelper::site_url('player/' . $player->URL . '/games/search/'.  urlencode($search).'/page') : MainHelper::site_url('player/' . $player->URL . '/games/page');
		$pager = $this->appendPagination($list, $games, $gamesCount, $url, Doo::conf()->playerGamesLimit);

		$list['searchTotal'] = $gamesCount;
		$list['searchText'] = $search;
		$list['player'] = $player;
		$list['friendUrl'] = $player->URL;

		$poster = $player->URL == '' ? $player : User::getFriend($player->URL);
		$list['poster'] = $poster;

		if($search == ''){
			$list['games'] = $games->getPlayerGames($player, $pager->limit);
		} else{
			$list['games'] = $games->getSearchPlayerGames($search, $player, $pager->limit);
		}

		$data['title'] = $this->__('Games');
		$data['body_class'] = 'index_my_games';
		$data['selected_menu'] = 'players';
		$data['left'] = PlayerHelper::playerLeftSide('games', $player->URL);
		$data['right'] = PlayerHelper::playerRightSide();
		$data['content'] = $this->renderBlock('players/content/playerGames', $list);
		$data['footer'] = MainHelper::bottomMenu();
		$data['header'] = MainHelper::topMenu();
		$this->render3Cols($data);

	}

	public function notifications() {
		$this->moduleOff();

		$player = User::getUser();

		if (!$player) {
			DooUriRouter::redirect(MainHelper::site_url());
			return FALSE;
		}
		$games = new Games();
		$list = array();
		$match = array();

		$list['infoBox'] = MainHelper::loadInfoBox('Players', 'notifications', true);

		$search = isset($this->params['search']) ? urldecode($this->params['search']) : '';
		if($search != ''){
			$phrase[NOTIFICATION_REPLY_MY_WALL] = $this->__('Notification_ReplyMyWall');
			$phrase[NOTIFICATION_POST_ON_MY_WALL] = $this->__('Notification_PostOnMyWall');
			$phrase[NOTIFICATION_REPLY_POST_MY_WALL] = $this->__('Notification_ReplyPostMyWall');
			$phrase[NOTIFICATION_REPLY_POST_OTHER_WALL] = $this->__('Notification_ReplyPostOtherWall');
			$phrase[NOTIFICATION_REPLY_MY_REPLY] = $this->__('Notification_ReplyMyReply');
			$phrase[NOTIFICATION_PUBLIC_BY_SUBSCRIBE] = $this->__('Notification_PublicBySubscribe');
			$phrase[NOTIFICATION_LIKE] = $this->__('Notification_Like');
			$phrase[NOTIFICATION_DISLIKE] = $this->__('Notification_Dislike');
			$phrase[NOTIFICATION_SUBSCRIBE_PLAYER] = $this->__('Notification_SubscribePlayer');
			$phrase[NOTIFICATION_FRIEND_REQUEST] = $this->__('Notification_FriendRequest');
			$phrase[NOTIFICATION_FRIEND_REPLY] = $this->__('Notification_FriendReply');
			$phrase[NOTIFICATION_NEW_FORUM_POST] = $this->__('Notification_NewForumPost');
			$phrase[NOTIFICATION_NEW_FORUM_TOPIC] = $this->__('Notification_NewForumTopic');
			$phrase[NOTIFICATION_COMPANY_NEWS] = $this->__('Notification_CompanyNews');
			$phrase[NOTIFICATION_GAME_NEWS] = $this->__('Notification_GameNews');
			$phrase[NOTIFICATION_GROUP_NEWS] = $this->__('Notification_GroupNews');
			$phrase[NOTIFICATION_NEWS_REPLY] = $this->__('Notification_NewsReply');
			$phrase[NOTIFICATION_ACHIEVEMENT] = $this->__('Notification_Achievement');

			$phrasePost = trim($search);

			if (strlen($phrasePost) == 0) {
				return;
			}

			foreach ($phrase as $k => $ph) {
				if(strlen($ph) != strlen(str_replace(strtolower($phrasePost), "", strtolower($ph)))) {
					$match[] = $k;
				}
			}
			if (empty($match)) {
				$match[] = "not found sorry";
			}
		}
		$url = $search == "" ? MainHelper::site_url('players/notifications/page') : MainHelper::site_url('players/notifications/search/'.  urlencode($search).'/page');

		$notificationsCount = $player->getNotificationsCount($match);
		$pager = $this->appendPagination($list, $player, $notificationsCount, $url, Doo::conf()->notificationsLimit);
		$list['notifications'] = $player->getNotifications($pager->limit, $match);

		$list['searchTotal'] = $notificationsCount;
		$list['searchText'] = $search;
		$list['player'] = $player;

		$data['title'] = $this->__('Notifications');
		$data['body_class'] = 'index_my_notifications';
		$data['selected_menu'] = 'players';
		$data['left'] = PlayerHelper::playerLeftSide('notifications');
		$data['right'] = PlayerHelper::playerRightSide();
		$data['content'] = $this->renderBlock('players/content/notifications', $list);
		$data['footer'] = MainHelper::bottomMenu();
		$data['header'] = MainHelper::topMenu();
		$this->render3Cols($data);
	}

	public function messageRead(){
		$this->moduleOff();

		$player = User::getUser();
		if(!isset($this->params['url']) or $this->params['url'] == "" or !$player) {
			DooUriRouter::redirect(MainHelper::site_url('players/messages'));
			return FALSE;
		}
		$messageUrl = $this->params['url'];

		$url = MainHelper::site_url('players/messages/read/'.$messageUrl.'/page');
		$list['total'] = $player->getMessagesCountConversation($messageUrl);
		$pager = $this->appendPagination($list, new FmPersonalMessages(), $list['total'], $url, Doo::conf()->messagesConversationLimit);
		$list['messages'] = $player->getMessageConversation($messageUrl, $pager->limit);

		$list['friendUrl'] = $messageUrl;

		$data['title'] = $this->__('Messages');
		$data['body_class'] = 'index_messages';
		$data['selected_menu'] = 'players';
		$data['left'] = PlayerHelper::playerLeftSide('messages');
		$data['right'] = PlayerHelper::playerRightSide();
		$data['content'] = $this->renderBlock('players/readMessage', $list);
		$data['footer'] = MainHelper::bottomMenu();
		$data['header'] = MainHelper::topMenu();

		$this->render3Cols($data);
	}

	public function messages() {
		$this->moduleOff();

		$player = User::getUser();
		if(!$player) {
			DooUriRouter::redirect(MainHelper::site_url());
			return FALSE;
		}
		$string = '';
		$list = array();
		$url = MainHelper::site_url('players/messages/page');
		$totalMessages = $player->getMessagesCountGrouped();
		$pager = $this->appendPagination($list, new FmPersonalMessages(), $totalMessages, $url, Doo::conf()->messagesLimit);
		$messages = $player->getMessages('inbox', $pager->limit);

		$messageList['total'] = $totalMessages;
		$messageList['messages'] = $messages;
		$messageList['player'] = $player;
		$messageList['type'] = MESSAGES_INBOX;

		$list['mTab'] = MESSAGES_INBOX;
		$list['messages'] = $this->renderBlock('players/content/messages_container', $messageList);;
		$list['total'] = $totalMessages;

		$data['title'] = $this->__('Messages');
		$data['body_class'] = 'index_messages';
		$data['selected_menu'] = 'players';
		$data['left'] = PlayerHelper::playerLeftSide('messages');
		$data['right'] = PlayerHelper::playerRightSide();
		$data['content'] = $this->renderBlock('players/messages', $list);
		$data['footer'] = MainHelper::bottomMenu();
		$data['header'] = MainHelper::topMenu();

		$this->render3Cols($data);
	}

	public function messagesSent() {
		$this->moduleOff();

		$string = '';
		$player = User::getUser();
		if ($player) {
			$list['total'] = $player->MessageSentCount;
			$limit = Doo::conf()->messagesLimit;
			$url = MainHelper::site_url('players/messages/sent/page');
			$pager = $this->appendPagination($list, new FmPersonalMessages(), $list['total'], $url, $limit);

			$offset = explode(',', $pager->limit);
			$messages = $player->getMessages('sent', $offset[0]);

			$d['total'] = $player->MessageCount;
			$d['messages'] = $messages;
			$d['player'] = $player;
			$d['limit'] = $limit;
			$d['type'] = MESSAGES_SENT;

			$string = $this->renderBlock('players/content/messages_container', $d);
		}

		$list['mTab'] = MESSAGES_SENT;
		$list['messages'] = $string;

		$data['title'] = $this->__('Messages');
		$data['body_class'] = 'index_messages';
		$data['selected_menu'] = 'players';
		$data['left'] = PlayerHelper::playerLeftSide('messages');
		$data['right'] = PlayerHelper::playerRightSide();
		$data['content'] = $this->renderBlock('players/messages', $list);
		$data['footer'] = MainHelper::bottomMenu();
		$data['header'] = MainHelper::topMenu();

		$this->render3Cols($data);
	}

	/**
	 * Prints send message block
	 *
	 * @return JSON
	 */
	public function ajaxGetSendMessage() {
		if ($this->isAjax()) {
			$player = User::getUser();
			if ($player) {
				$data = array();
				if (isset($this->params['friend_url']))
					$friend = User::getFriend($this->params['friend_url']);

				if (isset($this->params['message_id'])) {
					$message = new FmPersonalMessages();
					$message->ID_PM = intval($this->params['message_id']);
					$message = $message->getOne();

					if ($message) {
						$messArr = (object) unserialize($message->Body);
						$content = $messArr->content;
						$description = ContentHelper::handleContentOutput($messArr->description);

						$messageText = ($messArr->type != WALL_VIDEO) ? $content : $description;

						if($messArr->type == WALL_VIDEO) {
							$content = (object) unserialize($messArr->content);
							$messageText .= "\n";
							$messageText .= "http://www.youtube.com/watch?v=".$content->id;
						}
						$data['message'] = htmlspecialchars($messageText);
					}
				}

				if (isset($this->params['friend_url'])) { $data['friend'] = $friend; };

//				$string = $this->renderBlock('players/ajaxGetSendMessage', $data);
//              $this->toJSON($string, true);
				/* CHANGED SINCE FANCYBOX UPDATED */

				echo $this->renderBlock('players/ajaxGetSendMessage', $data);
				return TRUE;
			}
		}
	}

	public function ajaxblockUser()
	{
		//Block a user/friend
		if ($this->isAjax())
		{
			$player = User::getUser();
			if ($player)
			{
				$ID_SENDER = $player->ID_PLAYER;
				$ID_FRIEND = $_POST['ID_PLAYER'];
				$blockmode = $_POST['blockmode'];

				//Block User
				if ($blockmode=="block")
				{
					$query = "SELECT COUNT(*) as cnt FROM sn_playerfriendcat WHERE ID_PLAYER={$ID_SENDER} AND Native=2";
					$o = (object) Doo::db()->fetchRow($query);
					if ($o->cnt==0)
					{
						//Create block category, if not exists
						$query = "SELECT @MAX_CAT := IF(MAX(ID_CAT) IS NULL,0,MAX(ID_CAT))+1 FROM sn_playerfriendcat WHERE ID_PLAYER={$ID_SENDER};
							INSERT INTO sn_playerfriendcat
							(CategoryName,ID_PLAYER,Native,ID_CAT )
							VALUES
							( 'block', {$ID_SENDER}, 2, @MAX_CAT )";
						Doo::db()->query($query);
					}

					//Insert player->cat<-friend relation
					$query = "INSERT INTO sn_playerfriendcat_rel
						(ID_PLAYER,ID_FRIEND,ID_CAT)
						VALUES
						({$ID_SENDER},{$ID_FRIEND}, (SELECT ID_CAT FROM sn_playerfriendcat WHERE ID_PLAYER={$ID_SENDER} AND Native=2) )";
					Doo::db()->query($query);


					$data['result'] = "User (" . $ID_SENDER . ") blocks friend (" . $ID_FRIEND . ") " . $query;
					$this->toJSON($data, true);
				}
				//Unblock User
				if ($blockmode=="unblock")
				{
					$query = "SELECT @cat := sn_playerfriendcat.ID_CAT
								FROM sn_playerfriendcat
								RIGHT JOIN sn_playerfriendcat_rel ON sn_playerfriendcat.ID_CAT=sn_playerfriendcat_rel.ID_CAT
								WHERE sn_playerfriendcat_rel.ID_PLAYER={$ID_SENDER} AND sn_playerfriendcat_rel.ID_FRIEND={$ID_FRIEND}
								AND Native=2;
							DELETE FROM sn_playerfriendcat_rel
								WHERE ID_PLAYER={$ID_SENDER} AND ID_FRIEND={$ID_FRIEND}
								AND ID_CAT = @cat;";
					Doo::db()->query($query);

					$data['result'] = "User (" . $ID_SENDER . ") UNblocks friend (" . $ID_FRIEND . ") " . $query;
					$this->toJSON($data, true);
				}
			}
		}
	}

	/**
	 * Sends message to selected players
	 *
	 * @return JSON
	 */
	public function ajaxSendMessage() {
		if ($this->isAjax() and isset($_POST['message']) and isset($_POST['recipients'])) {
			$player = User::getUser();
			if ($player) {
				$message = $_POST['message'];
				$recipients = $_POST['recipients'];
//				$data['result'] = $player->sendMessage($recipients, $message);
				$messClass = new Messages();
				$data['result'] = $messClass->sendNewMessage($recipients, $message);
				$this->toJSON($data, true);
			}
		}
	}

	public function ajaxReplyMessage() {
		if ($this->isAjax() and isset($_POST['message']) and isset($_POST['friendUrl'])) {
			$player = User::getUser();
			if ($player) {
				$message = $_POST['message'];
				$friend = $_POST['friendUrl'];
				$data['result'] = $player->replyMessage($friend, $message);
				$this->toJSON($data, true);
			}
		}
	}

	/**
	 * searches for friend in send message field
	 *
	 * @return JSON
	 */
	public function ajaxFindFriend() {
		if ($this->isAjax() and isset($_GET['q'])) {
			$player = User::getUser();
			$data = array();
			if ($player) {
				$result = $player->getSearchFriends($_GET['q']);
				if (!empty($result)) {
					foreach ($result as $r) {
						$img = MainHelper::showImage($r, THUMB_LIST_60x60, TRUE, array('no_img' => 'noimage/no_player_60x60.png'));
						$data = array("id" => $r->URL, "img" => $img, "name" => PlayerHelper::showName($r));
					}
				}
			}
			$this->toJSON($data, true);
		}
	}

	/**
	 * Deletes message
	 *
	 * @return JSON
	 */
	public function ajaxDeleteMessageItem() {
		if ($this->isAjax() and isset($_POST['pid']) and MainHelper::validatePostFields(array('type'))) {
			$player = User::getUser();
			if ($player) {
				$messageIDS = $_POST['pid'];
				$type = intval($_POST['type']);
				if (count($_POST['pid']) == 1 and !is_array($_POST['pid'])) {
					$messageIDS = array($messageIDS);
				}
				$data['result'] = $player->deleteMessages($messageIDS, $type);

				$this->toJSON($data, true);
			}
		}
	}

	/**
	 * Deletes message
	 *
	 * @return JSON
	 * @deprecated
	 */
	public function ajaxDeleteAllMessages() {
		return;
		if ($this->isAjax() and MainHelper::validatePostFields(array('type'))) {
			$player = User::getUser();
			if ($player) {
				$type = intval($_POST['type']);
				$player->deleteAllMessages($type);
				$data['player'] = $player;

				if ($type == 1) {
					$messages = $player->getMessages();
					$result['total'] = $player->MessageCount;
					$string = $this->renderBlock('players/content/messages_container', $data);
				} else {
					$messages = $player->getMessages('sent');
					$result['total'] = $player->MessageSentCount;
					$string = $this->renderBlock('players/content/messages_container_sent', $data);
				}

				$data['messages'] = $messages;

				$result['content'] = $string;
				$result['result'] = true;
				$this->toJSON($result, true);
			}
		}
	}

	public function myEvents() {
		$this->moduleOff();

		$player = User::getUser();
		if (!$player) {
			DooUriRouter::redirect(MainHelper::site_url());
			return FALSE;
		}
		$events = new Event();
		$list = array();
		$list['infoBox'] = MainHelper::loadInfoBox('Players', 'myEvents', true);

		$search = isset($this->params['search']) ? urldecode($this->params['search']) : '';
		$eventsCount = $events->getPlayerEventsCount($player, true, $search);
		$url = $search != "" ? MainHelper::site_url('players/my-events/search/'.  urlencode($search).'/page') : MainHelper::site_url('players/my-events/page');
		$pager = $this->appendPagination($list, $events, $eventsCount, $url, Doo::conf()->playerEventsLimit);

		$list['searchTotal'] = $eventsCount;
		$list['searchText'] = $search;

		if($search == ''){
			$list['events'] = $events->getPlayerEvents($player, $pager->limit, true);
		} else{
			$list['events'] = $events->getSearchPlayerEvents($search, $player, $pager->limit, true);
		}

		$data['title'] = $this->__('My Events');
		$data['body_class'] = 'index_my_events';
		$data['selected_menu'] = 'players';
		$data['left'] = PlayerHelper::playerLeftSide('events');
		$data['right'] = PlayerHelper::playerRightSide();
		$data['content'] = $this->renderBlock('players/content/myEvents', $list);
		$data['footer'] = MainHelper::bottomMenu();
		$data['header'] = MainHelper::topMenu();
		$this->render3Cols($data);
	}

	public function playerEvents() {
		$this->moduleOff();

		$player = User::getFriend($this->params['player_url']);
		if (!$player) {
			DooUriRouter::redirect(MainHelper::site_url());
			return FALSE;
		}
		$events = new Event();
		$list = array();

		$search = isset($this->params['search']) ? urldecode($this->params['search']) : '';
		$eventsCount = $events->getPlayerEventsCount($player, false, $search);
		$url = $search != "" ? MainHelper::site_url('player/'.$player->URL.'/events/search/'.  urlencode($search).'/page') : MainHelper::site_url('player/'.$player->URL.'/events/page');
		$pager = $this->appendPagination($list, $events, $eventsCount, $url, Doo::conf()->playerEventsLimit);

		$list['searchTotal'] = $eventsCount;
		$list['searchText'] = $search;
		$list['player'] = $player;
		$list['friendUrl'] = $player->URL;

		if($search == ''){
			$list['events'] = $events->getPlayerEvents($player, $pager->limit, false);
		} else{
			$list['events'] = $events->getSearchPlayerEvents($search, $player, $pager->limit, false);
		}

		$poster = $player->URL == '' ? $player : User::getFriend($player->URL);
		$list['poster'] = $poster;

		$data['title'] = $this->__('Events');
		$data['body_class'] = 'index_my_events';
		$data['selected_menu'] = 'players';
		$data['left'] = PlayerHelper::playerLeftSide('events', $player->URL);
		$data['right'] = PlayerHelper::playerRightSide();
		$data['content'] = $this->renderBlock('players/content/playerEvents', $list);
		$data['footer'] = MainHelper::bottomMenu();
		$data['header'] = MainHelper::topMenu();
		$this->render3Cols($data);
	}

	public function addGameDescription() {
		if ($this->isAjax()) {
			$games = new Games();
			$game = Games::getGameByID($this->params['game']);
			$gameRel = $games->getPlayerGameRel($game);
			if (!empty($gameRel)) {
				$data['gameRel'] = $gameRel;
				echo $this->renderBlock('players/content/addGameDescription', $data);
			}
		}
	}

	public function saveGameDescription() {
		if ($this->isAjax()) {
			$games = new Games();
			$result['result'] = $games->savePlayerGameDescription($_POST);
			$this->toJSON($result, true);
		}
	}

	public function invite() {
		$this->moduleOff();

		$list = array();
		$this->addCrumb($this->__('Players'), MainHelper::site_url('players'));
		$this->addCrumb($this->__('Invite Friends'));
		$list['crumb'] = $this->getCrumb();
		$list['playerHeader'] = $this->__('Invite Friends');

//		$invitation = new Invitation('user', 'pass');
//		$invitation->inviteFromGmail();

		$data['title'] = $this->__('Invite Friends');
		$data['body_class'] = 'index_players';
		$data['selected_menu'] = 'players';
		$data['left'] = PlayerHelper::playerLeftSide();
		$data['right'] = PlayerHelper::playerRightSide();
		$data['content'] = $this->renderBlock('players/invite', $list);
		$data['footer'] = MainHelper::bottomMenu();
		$data['header'] = MainHelper::topMenu();

		$this->render3Cols($data);
	}

	public function ajaxGetContactList() {
		if($this->isAjax() and !empty($_POST)) {
			$invitation = new Invitation($_POST['user'], $_POST['pass']);
			$result['content'] = '';
			switch ($_POST['mail_system']) {
				case 'gmail':
					$list = $invitation->inviteFromGmail();
					break;
				case 'yahoo':
					$list = $invitation->inviteFromYahoo();
					break;
			}
			if(isset($list->error) and !empty($list->error)) {
				 $result['content'] = $list->error;
			}
			else if(isset($list->list) ) {
				$result['content'] = $this->renderBlock('players/ajaxContactList', array('contacts' => $list->list));
			} else {
				$result['content'] = 'No contacts found';
			}
			$this->toJSON($result, true);
		}

	}

	public function ajaxRate() {
		if($this->isAjax() and !empty($_POST) and Auth::isUserLogged()) {
			$ratings = new Ratings();
			$result['result'] = true;
			$result['rating'] = $ratings->rate('player', $_POST['ourl'], $_POST['rating']);
			if(!$result['rating']){
				$result['result'] = false;
			}
			$this->toJSON($result, true);
		}
				elseif(!Auth::isUserLogged()) {
					$result['redirect'] = true;
					$this->toJSON($result, true);
				}
	}

	public function ajaxGetRating(){
		if($this->isAjax()) {
			$vote = false;

			// user looks someones, or his own rating
			if(!isset($_POST['ourl'])){
				$user = User::getUser();
				$isSelf = true;
			}
			else{
				$user = User::getFriend($_POST['ourl']);
				$isSelf = false;

				// rating is enabled or disabled
				if(isset($_POST['vote'])){
					$vote = $_POST['vote'];
				}
			}

			if(!$user)
				return false;

			$result['content'] = $this->renderBlock('players/common/rating_info',
					array('user' => $user,
						'isSelf' => $isSelf,
						'vote' => $vote
						));
			$result['result'] = true;
			$this->toJSON($result, true);
		}
	}

	public function finishStep($step = 0){
		if($step == 0){
			if(isset($_POST['step'])){
				$step = $_POST['step'];
			}
		}

		$p = User::getUser();
		if ($p) {
			if($step > 0 and $step <= Doo::conf()->FTUsteps){
				$p->IntroSteps = ContentHelper::handleContentInput($step);
				$p->update();
				$p->purgeCache();
			}
		}

		DooUriRouter::redirect(MainHelper::site_url('players/wall'));
	}

	public function updateProfile(){
		$p = User::getUser();
		if ($p) {
			$p->updateProfile($_POST);
			MainHelper::UpdateExtrafieldsByPOST('player',$p->ID_PLAYER);
			MainHelper::UpdateCategoryByPOST('player',$p->ID_PLAYER);
			//Also done at this step??
			//MainHelper::UpdatePersonalInfo($p->ID_PLAYER);
			//$SnPrivacy = new SnPrivacy;
			//$SnPrivacy->UpdatePrivacySettingsByPost($p->ID_PLAYER);
		$this->finishStep(1);
		}
	}

	public function ajaxSearchPlayers(){
		if($this->isAjax()){
			$p = User::getUser();
			$s = '';

			if($p and isset($_POST['q']) and strlen($_POST['q']) >= 3){
				$players = User::searchPlayers($_POST['q']);

				if(!empty($players)){
					foreach($players as $player){
						$s .= $this->renderBlock('common/playerSmall', array('player' => $player, 'id' => 'F_addFriend'));
					}
				}
			}

			$this->toJSON($s, true);
		}
	}

	public function ajaxAddFriends(){
		if($this->isAjax()){
			$p = User::getUser();

			if($p and isset($_POST['ids']) and $_POST['ids'] != ''){
				$ids = explode(',', $_POST['ids']);

				foreach($ids as $id){
					$p->sendFriendRequest($id);
				}

			}
		}
	}

	public function ajaxAddGames(){
		if($this->isAjax()){
			$p = User::getUser();

			if($p and isset($_POST['ids']) and $_POST['ids'] != ''){
				$ids = explode(',', $_POST['ids']);

				foreach($ids as $id){
					$p->toggleIsPlayingGame($id);
				}

			}
		}
	}

	public function ajaxAddGroups(){
		if($this->isAjax()){
			$p = User::getUser();

			if($p and isset($_POST['ids']) and $_POST['ids'] != ''){
				$ids = explode(',', $_POST['ids']);

				foreach($ids as $id){
					$p->applyGroup($id);
				}

			}
		}
	}

	public function ajaxOpenInviter(){
		if($this->isAjax()){
			$p = User::getUser();
			if($p){
				MainHelper::showInviter($_POST);
			}
		}
	}

	public function ajaxSiteInvite(){
		$inv = array();
		if($this->isAjax()){
			$p = User::getUser();
			if($p and isset($_POST['emails']) and !empty($_POST['emails'])){
				$emails = explode(',', $_POST['emails']);

				foreach($emails as $email){
					$inv[0][0] = $email;
					$inv[0][1] = $p->inviteToSite($email);
				}

				$data['inviter'] = MainHelper::showInviter(array(), false);
				$data['results'] = $inv;

				$this->toJSON($data, true);
			}
		}
	}

	public function ajaxGetFTUStep(){
		$p = User::getUser();
		if($this->isAjax() and $p and MainHelper::validatePostFields(array('step'))){
			$step = $_POST['step'];
			if($step >= 0 and $step < Doo::conf()->FTUsteps){
				$p->IntroSteps = ContentHelper::handleContentInput($step);
				$p->update();
				$p->purgeCache();

				$data = $this->renderBlock('common/FTUform', array('step' => $step));
				echo $data;
			}
		}
	}
	public function ajaxSimpleInvite(){
		$p = User::getUser();
		$inv = array();
		if($this->isAjax() and $p and MainHelper::validatePostFields(array('fieldsCount')) and intval($_POST['fieldsCount']) > 0){
			$count = $_POST['fieldsCount'];
			for($i = 1; $i <= $count; $i++){
				$key = 'inviteByEmail_'.$i;
				if(isset($_POST[$key]) and !empty($_POST[$key]) and PlayerHelper::isValidEmail($_POST[$key])){
					$inv[$i-1][0] = $_POST[$key];
					$inv[$i-1][1] = $p->inviteToSite($_POST[$key]);
				}
			}

			$data['inviter'] = MainHelper::showInviter(array(), false);
			$data['results'] = $inv;

			$this->toJSON($data, true);
		}
	}

	public function fblogin(){
		$fb = new FacebookSDK(array(
			'appId' => Doo::conf()->fb_appid,
			'secret' => Doo::conf()->fb_secret
		));

		$user = $fb->getUser();

		if($user==0){
			$loginParams = array(
				'scope' => 'email, user_birthday, user_location',
				'display' => 'page'
			);

			$loginUrl = $fb->getLoginUrl($loginParams);
			echo '<META HTTP-EQUIV="Refresh" Content="0; url='.urlencode($loginUrl).'">';
			/*printf("<script>location.href='".$loginUrl."';</script>");
			header("Location: ".urlencode($loginUrl), true);*/
			echo "<script>window.location='".$loginUrl."';</script>";
		}else{
			try{
				$profile = $fb->api('/me');
				if($profile){
					$this->fbRegister($profile);
				}else{return;}

			}catch(Exception $e){
				echo($e->getMessage());
			}
		}
	}

	private function fbRegister($profile){

		$_POST['nickName'] = ContentHelper::handleContentInput($profile['first_name'].$profile['last_name']);
		$_POST['email'] = ContentHelper::handleContentInput($profile['email']);
		$_POST['password'] = "playnationTest";
		$_POST['confirmPassword'] = "playnationTest";
		$_POST['terms'] = 1;

		$this->register();
		/*
		$birthday = strtotime(ContentHelper::handleContentInput($profile['birthday']));   // user_birthday AT required

		$player = new Players();
		$player->EMail = ContentHelper::handleContentInput($profile['email']);            // email AT required
		//echo(PHP_EOL."MAIL: ".$player->EMail);
		//exit();
		$player->FirstName = ContentHelper::handleContentInput($profile['first_name']);   //No access_token required
		$player->LastName = ContentHelper::handleContentInput($profile['last_name']);     //No access_token required
		$player->NickName = ContentHelper::handleContentInput($profile['username']);      //No access_token required
		//$player->City = ContentHelper::handleContentInput($profile['location']['name']);  // user_location AT required
		$player->Gender = ucfirst(ContentHelper::handleContentInput($profile['gender'])); //No access_token required
		$player->DateOfBirth = date('Y-m-d', $birthday);
		$player->Password = md5(md5(microtime()-time()).$profile['first_name'].sha1($profile['last_name'].$profile['first_name']));
		//$player->VerificationCode = md5(md5(time() * microtime()) . md5($player->NickName . $player->Password));
		$player->ID_PLAYER = $player->insert();

		$player->GroupLimit = MainHelper::GetSetting('GroupLimit','ValueInt');
		$player->ImageLimit = MainHelper::GetSetting('ImageLimit','ValueInt');
		$player->update(array('field' => 'GroupLimit'));
		$player->update(array('field' => 'ImageLimit'));
		$SnPrivacy = new SnPrivacy;
		$SnPrivacy->CreateUserPrivacy($player->ID_PLAYER);
		MainHelper::CreatePersonalInformation($player->ID_PLAYER);
		MainHelper::CreateFriendCategoriesPlayer($player->ID_PLAYER);

		$player->URL = md5($player->ID_PLAYER);
		$player->update(array('field' => 'URL'));

		Auth::logInFb($profile);

		//$mail = new EmailNotifications();
		//$mail->registrationConfirmation($player);
		*/
	}


	public function ajaxFindPlayerGroups() {
		if ($this->isAjax() and Auth::isUserLogged()) {
			$groups = new Groups();
			$result = $groups->getSearchPlayerGroups($_GET['q']);

			if(!empty($result)) {
				foreach ($result as $r) {
					$img = MainHelper::showImage($r, THUMB_LIST_60x60, TRUE, array('no_img' => 'noimage/no_group_60x60.png'));
					$data[] = array("id" => $r->ID_GROUP, "img" => $img, "name" => $r->GroupName);
				}
			}

			$this->toJSON($data, true);
		}
	}

	/* Functions for the conversation based message interface */


	/**
	 *
	 * Shows all conversations for the player
	 *
	 */
	public function conversations()
	{
		$this->moduleOff();

		$player = User::getUser();
		if(!$player) {
			DooUriRouter::redirect(MainHelper::site_url('signin'));
			return FALSE;
		}
		$string = '';
		$list = array();
		$url = MainHelper::site_url('players/conversations/page');
		$messClass = new Messages();
		$totalConversations = $messClass->getConversationCount($player->ID_PLAYER);
		$pager = $this->appendPagination($list, new MeConversations(), $totalConversations, $url, Doo::conf()->conversationsLimit);
		$conversations = $messClass->getConversations($pager->limit);
		foreach ($conversations as $conversation)
		{
			foreach (explode(',', $conversation->Participants) as $p)
			{
				if ($p != $player->ID_PLAYER)
				{
					$params['select'] = "ID_PLAYER, FirstName, LastName, NickName, DisplayName, Avatar, URL";
					$params['limit'] = 1;
					$params['where'] = "{$player->_table}.ID_PLAYER = ?";
					$params['param'] = array($p);
					$conversation->players[] = Doo::db()->find('Players', $params);
				}
			}
		}
		$conversationList['total'] = $totalConversations;
		$conversationList['conversations'] = $conversations;
		$conversationList['player'] = $player;
		$conversationList['type'] = MESSAGES_INBOX;

		$list['mTab'] = MESSAGES_INBOX;
		$list['conversations'] = $this->renderBlock('players/content/conversation_container', $conversationList);;
		$list['total'] = $totalConversations;

		$data['title'] = $this->__('Conversations');
		$data['body_class'] = 'index_messages';
		$data['selected_menu'] = 'players';
		$data['left'] = PlayerHelper::playerLeftSide('messages');
		$data['right'] = PlayerHelper::playerRightSide();
		$data['content'] = $this->renderBlock('players/conversations', $list);
		$data['footer'] = MainHelper::bottomMenu();
		$data['header'] = MainHelper::topMenu();

		$this->render3Cols($data);
	}

	/**
	 *
	 * Shows all messages for selected conversation
	 *
	 */
	public function conversationRead(){
		$this->moduleOff();

		$player = User::getUser();
		if(!$player) {
			DooUriRouter::redirect(MainHelper::site_url('signin'));
			return FALSE;
		}
		if(!isset($this->params['id']) or $this->params['id'] == "") {
			DooUriRouter::redirect(MainHelper::site_url('players/conversations'));
			return FALSE;
		}
		$messages = new Messages();
		$conversationID = $this->params['id'];

		$url = MainHelper::site_url('players/conversations/read/'.$conversationID.'/page');
		$list['total'] = $messages->getConversationMessageCount($conversationID);
		$pager = $this->appendPagination($list, new MeMessages(), $list['total'], $url, Doo::conf()->messagesConversationLimit);
		$list['messages'] = $messages->getConversationMessages($conversationID, $pager->limit);
		$list['conversationID'] = $conversationID;

		$participant = new MeParticipants();
		$participant = Doo::db()->getOne('MeParticipants', array(
			'where' => 'ID_PLAYER = ? AND ID_CONVERSATION = ?',
			'param' => array($player->ID_PLAYER, $conversationID),
			));
		if ($participant->NewMessageCount > 0)
		{
			$player->NewMessageCount -= $participant->NewMessageCount;
			$player->update();
			$participant->NewMessageCount = 0;
		}
		$participant->LastReadTime = time();
		$participant->update(array(
			'field' => 'LastReadTime, NewMessageCount',
			'where' => 'ID_PLAYER = ? AND ID_CONVERSATION = ?',
			'param' => array($player->ID_PLAYER, $conversationID),
		));

		$data['title'] = $this->__('Messages');
		$data['body_class'] = 'index_messages';
		$data['selected_menu'] = 'players';
		$data['left'] = PlayerHelper::playerLeftSide('messages');
		$data['right'] = PlayerHelper::playerRightSide();
		$data['content'] = $this->renderBlock('players/readConversation', $list);
		$data['footer'] = MainHelper::bottomMenu();
		$data['header'] = MainHelper::topMenu();

		$this->render3Cols($data);
	}

	// Ajax functions for conversation based message system

	/**
	 *
	 * Handles personal message to be send
	 *
	 * @return JSON
	 */
	public function ajaxReplyConvMessage() {
		if ($this->isAjax() and isset($_POST['message']) and isset($_POST['conversation'])) {
			$player = User::getUser();
			$messClass = new Messages();
			if ($player) {
				$message = $_POST['message'];
				$conversation = $_POST['conversation'];
				$data['result'] = $messClass->sendMessage($conversation, $message);

				$this->toJSON($data, true);
			}
		}
	}

	public function ajaxChangeEmail()
	{
		if ($this->isAjax())
		{
			$player = User::getUser();
			if ($player)
			{
				$data = array();
				$data['player'] = $player;
				$string = $this->renderBlock('players/ajaxChangeEmail', $data);
				$this->toJSON($string, true);
			}
		}

	}

	public function ajaxChangeemailSubmit()
	{
		if ($this->isAjax() and isset($_POST['ID_PLAYER']) and isset($_POST['newemail'])) {
			$player = User::getUser();
			if ($player) {
				$success = 0;

				$ID_PLAYER = $_POST['ID_PLAYER'];
				$newemail = $_POST['newemail'];

				$validEmail = PlayerHelper::isValidEmail($newemail);
				$emailExists = PlayerHelper::emailExists($newemail);

				if ($validEmail==1 && $emailExists==0)
				{
					//Update this new email and create new verification code, and send varification email
					$player->EMail = $newemail;
					$player->VerificationCode = md5(md5(time() * microtime()) . md5($player->NickName . $player->Password));
					$player->update(array('field' => 'EMail'));
					$player->update(array('field' => 'VerificationCode'));
					$mail = new EmailNotifications();
					$mail->registrationConfirmation($player);

					$success = 1;
				}
				$data['comment'] = $newemail . " isvalid: ". $validEmail . " exists: ". $emailExists;

				$data['validEmail'] = $validEmail;
				$data['emailExists'] = $emailExists;
				$data['result'] = $success;

				$this->toJSON($data, true);
			}
		}
	}

	public function ajaxChangeemailDone()
	{
		//Changing email was a success. Now logOtu and goto mainpage.
		Auth::logOut();
		DooUriRouter::redirect(MainHelper::site_url());
	}



	/**
	 * Prints send message block
	 *
	 * @return JSON
	 */
	public function ajaxSendConvMessage()
	{
		if ($this->isAjax())
		{
			$player = User::getUser();
			if ($player)
			{
				$data = array();
				if (isset($this->params['conversation_id']))
				{
					$conversation = new MeConversations();
					$conversation->ID_CONVERSATION = intval($this->params['conversation_id']);
					$conversation = $conversation->getOne();
					$data['conversation'] = $conversation;

					if (isset($this->params['message_id']))
					{
						$message = new FmPersonalMessages();
						$message->ID_PM = intval($this->params['message_id']);
						$message = $message->getOne();

						if ($message)
						{
							$messArr = (object) unserialize($message->messageText);
							$content = $messArr->content;
							$description = ContentHelper::handleContentOutput($messArr->description);

							$messageText = ($messArr->type != WALL_VIDEO) ? $content : $description;

							if($messArr->type == WALL_VIDEO) {
								$content = (object) unserialize($messArr->content);
								$messageText .= "\n";
								$messageText .= "http://www.youtube.com/watch?v=".$content->id;
							}
							$data['message'] = htmlspecialchars($messageText);
						}
					}
					$friendArray = explode(',', $conversation->Participants);
					$friends = array();
					foreach ($friendArray as $p)
					{
						if ((int) $p != $player->ID_PLAYER)
						{
							$friends[] = User::getById((int)$p);
						}
					}
					$data['friends'] = $friends;
				}
				$string = $this->renderBlock('players/ajaxSendConvMessage', $data);

				$this->toJSON($string, true);
			}
		}
	}

	/**
	 * Sends message to selected players
	 *
	 * @return JSON
	 */
	public function ajaxSendOutsideConvMessage()
	{
		if ($this->isAjax() and isset($_POST['message']) and isset($_POST['conversation']))
		{
			$player = User::getUser();
			$messClass = new Messages();
			if ($player)
			{
				$message = $_POST['message'];
				$conversation = $_POST['conversation'];
				$data['result'] = $messClass->sendMessage($conversation, $message);
				$this->toJSON($data, true);
			}
		}
	}

	public function enableProfile() {
		if (Auth::isUserLogged()) {
			$user = User::getUser();
			$query = "UPDATE sn_playersuspend SET isHistory = 1 WHERE ID_PLAYER={$user->ID_PLAYER};";
			Doo::db()->query($query);
		}

		DooUriRouter::redirect(MainHelper::site_url('players'));
	}

	public function disableProfile() {
		if (Auth::isUserLogged())
		{
			$user = User::getUser();
			$StartDate = date('Y-m-d');
			$Days = 0;
			$Level = 4;
			$Reason = "Deactivated by user";
			$Public = 0;
			$Unlimited = 1;
			$EndDate = $StartDate;

			//Make all his suspensions history and add new
			$query = "
					UPDATE sn_playersuspend SET isHistory = 1 WHERE ID_PLAYER={$user->ID_PLAYER};
					INSERT INTO sn_playersuspend (ID_PLAYER,StartDate,EndDate,Days,Level,Reason,Public,Unlimited,isHistory) VALUES
					({$user->ID_PLAYER},'{$StartDate}','{$EndDate}',$Days,$Level,'{$Reason}',$Public,$Unlimited,0)";
			//echo $query;exit;
			Doo::db()->query($query);
		}

		DooUriRouter::redirect(MainHelper::site_url('players'));
	}

	public function myAchievements() {
		$this->moduleOff();

		$player = User::getUser();
		$achievements = new Achievement();
		$achievementInfo = "";

		if($this->params['ach_id']){
			$achievementInfo = $achievements->GetLevelByID($this->params['ach_id']);
		}
		if (!$player) {
			DooUriRouter::redirect(MainHelper::site_url());
			return FALSE;
		}
		if($player->NewNotificationCount > 0){
			$player->AchievementsRead();
		}
		$list = array();

		$latestAchievements = $achievements->getLatestAchievementsByID($player->ID_PLAYER);
		$branches = $achievements->getAllBranches();

		$list['latestAchievements'] = $latestAchievements;
		$list['branches'] = $branches;
		$list['player'] = $player;
		$list['achievementInfo'] = $achievementInfo;

		$data['title'] = $this->__('My Achievements');
		$data['body_class'] = 'index_my_achievements';
		$data['selected_menu'] = 'players';
		$data['left'] = PlayerHelper::playerLeftSide('achievements');
		$data['right'] = PlayerHelper::playerRightSide();
		$data['content'] = $this->renderBlock('players/content/myAchievements', $list);
		$data['footer'] = MainHelper::bottomMenu();
		$data['header'] = MainHelper::topMenu();
		$this->render3Cols($data);
	}

	public function AchievementsRanking() {
		$this->moduleOff();

		$player = User::getUser();
		$achievements = new Achievement();

		if (!$player) {
			DooUriRouter::redirect(MainHelper::site_url());
			return FALSE;
		}

		$list = array();
		$pager = $this->appendPagination($list, new stdClass(), $achievements->getTotalRankings(), MainHelper::site_url('player/my-achievements/rankings/page'), Doo::conf()->achievementsLimit);

		$rankings = $achievements->getRankings($pager->limit);

		$list['rankings'] = $rankings;
		$list['player'] = $player;

		$data['title'] = $this->__('Rankings');
		$data['body_class'] = 'index_my_achievements';
		$data['selected_menu'] = 'players';
		$data['left'] = PlayerHelper::playerLeftSide('achievements');
		$data['right'] = PlayerHelper::playerRightSide();
		$data['content'] = $this->renderBlock('achievements/rankings', $list);
		$data['footer'] = MainHelper::bottomMenu();
		$data['header'] = MainHelper::topMenu();
		$this->render3Cols($data);
	}

	public function AchievementsFriendsRanking() {
		$this->moduleOff();

		$player = User::getUser();
		$achievements = new Achievement();

		if (!$player) {
			DooUriRouter::redirect(MainHelper::site_url());
			return FALSE;
		}

		$list = array();

		$list['player'] = $player;
		$pager = $this->appendPagination($list, new stdClass(), $achievements->getTotalRankings(), MainHelper::site_url('player/my-achievements/friends-ranking/page'), Doo::conf()->achievementsLimit);

		$rankings = $achievements->getFriendRankings($player, $pager->limit);

		$list['rankings'] = $rankings;
		$list['player'] = $player;

		$data['title'] = $this->__('Rankings');
		$data['body_class'] = 'index_my_achievements';
		$data['selected_menu'] = 'players';
		$data['left'] = PlayerHelper::playerLeftSide('achievements');
		$data['right'] = PlayerHelper::playerRightSide();
		$data['content'] = $this->renderBlock('achievements/friends_ranking', $list);
		$data['footer'] = MainHelper::bottomMenu();
		$data['header'] = MainHelper::topMenu();
		$this->render3Cols($data);
	}

	public function playerAchievements() {
		$this->moduleOff();
				$achievements = new Achievement();
		$player = User::getFriend($this->params['player_url']);

		if (!$player) {
			DooUriRouter::redirect(MainHelper::site_url());
			return FALSE;
		}

		$list = array();

		$latestAchievements = $achievements->getLatestAchievementsByID($player->ID_PLAYER);

		$branches = $achievements->getAllBranches();

		$list['player'] = $player;
		$list['friendUrl'] = $player->URL;

		$poster = $player->URL == '' ? $player : User::getFriend($player->URL);
		$list['poster'] = $poster;
		$list['latestAchievements'] = $latestAchievements;
		$list['branches'] = $branches;

		$data['title'] = $this->__('Achievements');
		$data['body_class'] = 'index_my_achievements';
		$data['selected_menu'] = 'players';
		$data['left'] = PlayerHelper::playerLeftSide('achievements', $player->URL);
		$data['right'] = PlayerHelper::playerRightSide();
		$data['content'] = $this->renderBlock('players/content/playerAchievements', $list);
		$data['footer'] = MainHelper::bottomMenu();
		$data['header'] = MainHelper::topMenu();
		$this->render3Cols($data);
	}

	public function ajaxChangeWidgetStatus() {
		if ($this->isAjax()) {
			$p = User::getUser();
			$userId = $p->ID_PLAYER;

			if (isset($_POST['isOpen'])) {
				$isOpen = ($_POST['isOpen'] == 1) ? 0 : 1;
				$widgetId = $_POST['widgetId'];

				$query = "UPDATE sn_playerwidget_rel SET isOpen = $isOpen WHERE ID_PLAYER = " . $userId . " AND ID_WIDGET = " . $widgetId;
				Doo::db()->query($query);

				if ($isOpen == 0) {
					$output = array('isOpen' => false);
					$this->toJSON($output, true);
				} else {
					$output = array('isOpen' => true);
					$this->toJSON($output, true);
				}
			}
		}
	}

	public function ajaxChangeWidgetVisibility() {
		if ($this->isAjax()) {
			$p = User::getUser();
			$userId = $p->ID_PLAYER;

			if (isset($_POST['widgetId'])) {
				$widgetId = $_POST['widgetId'];

				$query = "UPDATE sn_playerwidget_rel SET isVisible = 0, isOpen = 1 WHERE ID_PLAYER = " . $userId . " AND ID_WIDGET = " . $widgetId;
				Doo::db()->query($query);

				$output = array('isVisible' => false);
				$this->toJSON($output, true);
			}
		}
	}

}
?>
