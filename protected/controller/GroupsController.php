<?php

class GroupsController extends SnController {

	public function beforeRun($resource, $action) {
		parent::beforeRun($resource, $action);
//        $this->addCrumb($this->__('Groups'), MainHelper::site_url('groups'));
	}

	public function moduleOff()
	{
		$notAvailable = MainHelper::TrySetModuleNotAvailableByTag('groups');
		if ($notAvailable)
		{
			$data['title'] = $this->__('Groups');
			$data['body_class'] = 'index_groups';
			$data['selected_menu'] = 'groups';
			$data['left'] = PlayerHelper::playerLeftSide();
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

		$groups = new Groups();
		$list = array();
		$list['CategoryType'] = GROUP_ALL;
		$list['infoBox'] = MainHelper::loadInfoBox('Groups', 'index', true);
		$groupsTotal = $groups->getTotal();
		$pager = $this->appendPagination($list, $groups, $groupsTotal, MainHelper::site_url('groups/page'), Doo::conf()->groupsLimit);
		$list['groupList'] = $groups->getAllGroups($pager->limit);

		$data['title'] = $this->__('Groups');
		$data['body_class'] = 'index_groups';
		$data['selected_menu'] = 'groups';
		$data['left'] = PlayerHelper::playerLeftSide();
		$data['right'] = PlayerHelper::playerRightSide();
		$data['content'] = $this->renderBlock('groups/index', $list);
		$data['footer'] = MainHelper::bottomMenu();
		$data['header'] = MainHelper::topMenu();
		$this->render3Cols($data);
	}

	public function recent() {
		$this->moduleOff();

		$groups = new Groups();
		$list = array();
		$list['CategoryType'] = GROUP_RECENT;
		$list['infoBox'] = MainHelper::loadInfoBox('Groups', 'index', true);
		$groupsTotal = $groups->getTotal();
		$pager = $this->appendPagination($list, $groups, $groupsTotal, MainHelper::site_url('groups/page'), Doo::conf()->groupsLimit);
		$list['groupList'] = $groups->getAllRecentGroups($pager->limit);

		$data['title'] = $this->__('Recent Groups');
		$data['body_class'] = 'recent_groups';
		$data['selected_menu'] = 'groups';
		$data['left'] = PlayerHelper::playerLeftSide();
		$data['right'] = PlayerHelper::playerRightSide();
		$data['content'] = $this->renderBlock('groups/recentGroups', $list);
		$data['footer'] = MainHelper::bottomMenu();
		$data['header'] = MainHelper::topMenu();
		$this->render3Cols($data);
	}

	/**
	 * Main website
	 *
	 */
	public function groupView() {
		$this->moduleOff();

		$group = $this->getGroup();
		$groups = new Groups();
		$list = array();
		$wall = new Wall();
		$list['CategoryType'] = GROUP_INFO;
		$list['infoBox'] = MainHelper::loadInfoBox('Groups', 'index', true);
		$list['companyHeader'] = $group->GroupName;
		$list['group'] = $group;
		$list['alliances'] = $groups->getAlliances($group);
		MainHelper::getWallPosts($list, $group);

		$data['title'] = $group->GroupName;
		$data['body_class'] = 'group_view';
		$data['selected_menu'] = 'groups';
		$data['left'] = MainHelper::groupsLeftSide($group);
		$data['right'] = PlayerHelper::playerRightSide();
		$data['content'] = $this->renderBlock('groups/groupView', $list);
		$data['footer'] = MainHelper::bottomMenu();
		$data['header'] = MainHelper::topMenu();
		$this->render3Cols($data);
	}

	/**
	 * Main website
	 *
	 */
	public function newsView() {
		$this->moduleOff();

		$group = $this->getGroup();
		$news = new News();
		$list = array();
		$list['CategoryType'] = GROUP_NEWS;
		$list['infoBox'] = MainHelper::loadInfoBox('Groups', 'index', true);

		$list['isAdmin'] = $group->isAdmin();
		$list['group'] = $group;
		$pager = $this->appendPagination($list, $news, $news->getTotalByType($group->ID_GROUP, POSTRERTYPE_GROUP), $group->GROUP_URL.'/news/page');
		$list['newsList'] = $news->getNewsByType($group->ID_GROUP, POSTRERTYPE_GROUP, $pager->limit);
		$data['content'] = $this->renderBlock('groups/newsView', $list);

		$data['title'] = $this->__('Group News');
		$data['body_class'] = 'group_news';
		$data['selected_menu'] = 'groups';
		$data['left'] = MainHelper::groupsLeftSide($group);
		$data['right'] = PlayerHelper::playerRightSide();
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

		$group = $this->getGroup();
		$search = new Search();
		$list = array();
		$list['CategoryType'] = GROUP_NEWS;
		$list['infoBox'] = MainHelper::loadInfoBox('Groups', 'index', true);
		$list['group'] = $group;
		$list['isAdmin'] = $group->isAdmin();
		$list['searchText'] = urldecode($this->params['searchText']);
		$newsTotal = $search->getSearchTotal(urldecode($this->params['searchText']), SEARCH_NEWS, SEARCH_GROUP, $group->ID_GROUP);
		$pager = $this->appendPagination($list, $group, $newsTotal, $group->GROUP_URL.'/news/search/'.urlencode($list['searchText']).'/page');
		$list['newsList'] = $search->getSearch(urldecode($this->params['searchText']), SEARCH_NEWS, $pager->limit, SEARCH_GROUP, $group->ID_GROUP);
		$list['searchTotal'] = $newsTotal;

		$data['title'] = $this->__('Search results');
		$data['body_class'] = 'search_groups';
		$data['selected_menu'] = 'groups';
		$data['left'] = MainHelper::groupsLeftSide($group);
		$data['right'] = PlayerHelper::playerRightSide();
		$data['content'] = $this->renderBlock('groups/newsView', $list);

		$data['footer'] = MainHelper::bottomMenu();
		$data['header'] = MainHelper::topMenu();
		$this->render3Cols($data);
	}

	public function newsItemView() {
		$this->moduleOff();

		$group = $this->getGroup();
		if (!isset($this->params['article'])) {
			DooUriRouter::redirect($group->GROUP_URL);
			return FALSE;
		}
		$key = $this->params['article'];
		$lang = array_search($this->params['lang'], Doo::conf()->lang);
		$list = array();
		$news = new News();
		$groups = new Groups();
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

		$list['CategoryType'] = GROUP_NEWS;
		$list['infoBox'] = MainHelper::loadInfoBox('Groups', 'index', true);
		$list['group'] = $group;
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

		$data['title'] = $this->__('News').' '.$article->Headline;
		$data['body_class'] = 'group_news';
		$data['selected_menu'] = 'groups';
		$data['left'] = MainHelper::groupsLeftSide($group);
		$data['right'] = PlayerHelper::playerRightSide();
		$data['content'] = $this->renderBlock('groups/articleView', $list);
		$data['footer'] = MainHelper::bottomMenu();
		$data['header'] = MainHelper::topMenu();
		$this->render3Cols($data);
	}

	/**
	 * Main website
	 *
	 */
	public function membersView() {
		$this->moduleOff();


        $group = $this->getGroup();  // return a row from sngroup 
        $groups = new Groups(); // calls the group class 
        $list = array();
        $list['CategoryType'] = GROUP_MEMBER;
		$list['infoBox'] = MainHelper::loadInfoBox('Groups', 'index', true);
        $list['group'] = $group;
        $list['groups'] = $groups;
        $list['globalAdmin'] = $group->isAdmin(); // a global admin  - usergroup.
        $list['memberStatus'] = 'current';
        
		$list['activeSub'] = 1;

        $memberCount = $groups->getTotalMembers($group); // returns members that are visible
        $pager = $this->appendPagination($list, $groups, $memberCount, $group->GROUP_URL.'/members/page', Doo::conf()->groupMemberLimit);
        $list['memberList'] = $groups->getMembers($group, $pager->limit);
        $list['memberCount'] = $memberCount;

        $data['title'] = $this->__('Members');
        $data['body_class'] = 'index_groups_members';
        $data['selected_menu'] = 'groups';
        $data['left'] = MainHelper::groupsLeftSide($group);
        $data['right'] = PlayerHelper::playerRightSide();
        $data['content'] = $this->renderBlock('groups/membersView', $list);
        $data['footer'] = MainHelper::bottomMenu();
        $data['header'] = MainHelper::topMenu();
        $this->render3Cols($data);
    }

    /**
     * Main website
     *
     */

	
	 	public function membersApplicationsView() {

		$group = $this->getGroup();
		if(!$group->isAdmin()) {
			DooUriRouter::redirect($group->GROUP_URL.'/members');
			return FALSE;
		}

		$groups = new Groups();
		$list = array();
		$list['CategoryType'] = GROUP_MEMBER;
		$list['infoBox'] = MainHelper::loadInfoBox('Groups', 'index', true);
		$list['group'] = $group;
		$list['isAdmin'] = $group->isAdmin();
        $list['groups'] = $groups;
        $list['globalAdmin'] = $group->isAdmin(); // a global admin  - usergroup.
        $list['memberStatus'] = 'applying';

        $list['activeSub'] = 2;

		$memberCount = $groups->getTotalApplicantMembers($group);
		$pager = $this->appendPagination($list, $groups, $memberCount, $group->GROUP_URL.'/members-applications/page', Doo::conf()->groupMemberLimit);
		$list['memberCount'] = $memberCount;

		$list['memberList'] = $groups->getApplicantMembers($group, $pager->limit);

		$data['title'] = $this->__('Member Applications');
		$data['body_class'] = 'index_groups_members';
		$data['selected_menu'] = 'groups';
		$data['left'] = MainHelper::groupsLeftSide($group);
		$data['right'] = PlayerHelper::playerRightSide();
		$data['content'] = $this->renderBlock('groups/membersView', $list);
		$data['footer'] = MainHelper::bottomMenu();
		$data['header'] = MainHelper::topMenu();
		$this->render3Cols($data);
	}
	/**
	 * Main website
	 *
	 */
	public function membersInvitationsView() {
		$this->moduleOff();

		$group = $this->getGroup();
		if(!$group->isAdmin()) {
			DooUriRouter::redirect($group->GROUP_URL.'/members');
			return FALSE;
		}

		$groups = new Groups();
		$list = array();
		$list['CategoryType'] = GROUP_MEMBER;
		$list['infoBox'] = MainHelper::loadInfoBox('Groups', 'index', true);
		$list['group'] = $group;
		$list['isAdmin'] = $group->isAdmin();
        $list['groups'] = $groups;
        $list['globalAdmin'] = $group->isAdmin(); // a global admin  - usergroup.
        $list['memberStatus'] = 'invited';

        $list['activeSub'] = 3;

		$memberCount = $groups->getTotalInvitedMembers($group);
		$pager = $this->appendPagination($list, $groups, $memberCount, $group->GROUP_URL.'/members-applications/page', Doo::conf()->groupMemberLimit);
		$list['memberCount'] = $memberCount;

		$list['memberList'] = $groups->getInvitedMembers($group, $pager->limit);

		$data['title'] = $this->__('Member Invitations');
		$data['body_class'] = 'index_groups_members';
		$data['selected_menu'] = 'groups';
		$data['left'] = MainHelper::groupsLeftSide($group);
		$data['right'] = PlayerHelper::playerRightSide();
		$data['content'] = $this->renderBlock('groups/membersView', $list);
		$data['footer'] = MainHelper::bottomMenu();
		$data['header'] = MainHelper::topMenu();
		$this->render3Cols($data);
	}

	/**
	 * Deletes member from group
	 */
	public function ajaxDeleteMember() {
		if ($this->isAjax()) {
			$groups = new Groups();
			$group = $groups->getGroupByID($_POST['group_id']);
			if (isset($group) and $group->isAdmin() === TRUE) {
				$result['result'] = $groups->deleteMember($group, $_POST['member_id']);
				$this->toJSON($result, true);
			}
		}
	}
	/**
	 * Deletes application from group
	 */
	public function ajaxDeleteApplication() {
		if ($this->isAjax()) {
			$groups = new Groups();
			$group = $groups->getGroupByID($_POST['group_id']);

			$player = User::getUser();
			if (isset($group) and $group and $player) {
				$result['result'] = $groups->deleteMember($group, $player->ID_PLAYER);
				$this->toJSON($result, true);
			}
		}
	}

	/**
	 * searches groups
	 *
	 */
	public function search() {
		$this->moduleOff();

		if (!isset($this->params['searchText'])) {
			DooUriRouter::redirect(Doo::conf()->APP_URL);
			return FALSE;
		}

		$groups = new Groups();
		$search = new Search();
		$list = array();
		$list['CategoryType'] = $this->params['type'];
		$list['infoBox'] = MainHelper::loadInfoBox('Groups', 'index', true);
		$list['searchText'] = urldecode($this->params['searchText']);
		$groupsTotal = $search->getSearchTotal(urldecode($this->params['searchText']), SEARCH_GROUP);;
		$pager = $this->appendPagination($list, $groups, $groupsTotal, MainHelper::site_url('groups/search/'.$this->params['type'].'/'.urlencode($list['searchText']).'/page'), Doo::conf()->groupsLimit);
		$list['groupList'] = $search->getSearch(urldecode($this->params['searchText']), SEARCH_GROUP, $pager->limit);
		$list['searchTotal'] = $groupsTotal;

		$data['title'] = $this->__('Search results');
		$data['body_class'] = 'search_groups';
		$data['selected_menu'] = 'groups';
		$data['left'] = PlayerHelper::playerLeftSide();
		$data['right'] = PlayerHelper::playerRightSide();

		if($this->params['type'] == GROUP_ALL) {
			$data['content'] = $this->renderBlock('groups/index', $list);
		} else if($this->params['type'] == GROUP_RECENT) {
			$data['content'] = $this->renderBlock('groups/recentGroups', $list);
		}

		$data['footer'] = MainHelper::bottomMenu();
		$data['header'] = MainHelper::topMenu();
		$this->render3Cols($data);
	}

	/**
	 * Upload image
	 *
	 * @return JSON
	 */
	public function ajaxUploadPhoto() {
		$c = new Groups();
		if (!isset($this->params['group_id']))
			return false;

		$upload = $c->uploadPhoto(intval($this->params['group_id']));

		if ($upload['filename'] != '') {
			$file = MainHelper::showImage($upload['c'], THUMB_LIST_200x300, true, array('width', 'no_img' => 'noimage/no_group_200x300.png'));
			echo $this->toJSON(array('success' => TRUE, 'img' => $file));
		} else {
			echo $this->toJSON(array('error' => $upload['error']));
		}
	}

	/**
	 * Upload multi images to media
	 *
	 * @return JSON
	 */
	public function ajaxUploadMultiPhoto() {
		$c = new Groups();
		if (!isset($this->params['group_id']))
			return false;

		$tabs = array();
		$tabs[MEDIA_SCREENSHOT_URL] = MEDIA_SCREENSHOT;
		$tabs[MEDIA_CONCEPTART_URL] = MEDIA_CONCEPTART;
		$tabs[MEDIA_WALLPAPER_URL] = MEDIA_WALLPAPER;

		$upload = $c->uploadMedias(intval($this->params['group_id']), 0, $tabs[$_POST['selected-tab']]);

		if ($upload['filename'] != '') {
			echo 1;
		} else {
			echo 'Error';
		}
	}

	public function ajaxUploadMultiVideo() {
		$g = new Groups();
		if (!isset($this->params['group_id']))
			return false;

		$videos = explode("\n", $_POST['media_videos']);

		if(!empty($videos)) {
			foreach($videos as $video) {
				$v = ContentHelper::parseYoutubeVideo($video);
				if($v) {
					$g->addVideo($this->params['group_id'], $v);
				}
			}
			$result['result'] = true;
		} else {
			$result['result'] = false;
		}
		$this->toJSON($result, true);
	}

	public function editGroupInfo() {
		if ($this->isAjax()) {
			$group = $this->getGroup();
			if (isset($group) and $group->isAdmin() === TRUE) {
				$data['group'] = $group;
				$groups = new Groups();
				$data['group_types'] = $groups->getTypes();
				$data['members'] = $groups->getMembers($group, 99999);
				echo $this->renderBlock('groups/admin/editGroupInfo', $data);
			}
		} else {
			$group = $this->getGroup();
			if (isset($group) and $group->isAdmin() === TRUE) {
				$data['group'] = $group;
				$groups = new Groups();
				$data['group_types'] = $groups->getTypes();
				$data['members'] = $groups->getMembers($group, 99999);
//				echo $this->renderBlock('groups/admin/newEditGroupInfo', $data);

		$cols['title'] = $this->__('Edit group');
//		$data['body_class'] = 'edit_players';
//		$data['selected_menu'] = 'players';
//		$data['left'] = $this->renderBlock('players/edit_profile_menu', $list);
//		$data['right'] = PlayerHelper::playerRightSide();
		$cols['content'] = $this->renderBlock('groups/admin/editGroupInfo', $data);
		$cols['footer'] = MainHelper::bottomMenu();
		$cols['header'] = MainHelper::topMenu();

		$this->render3Cols($cols);

			}
		}
	}

	public function createGroup() {
		if ($this->isAjax()) {
			$groups = new Groups();
			$data['group_types'] = $groups->getTypes();
			echo $this->renderBlock('groups/admin/addGroup', $data);
		}
	}

	public function saveGroup() {
		if ($this->isAjax() and Membership::isValidFeature('createGroup') === TRUE) {
			$groups = new Groups();
			$groupID = $groups->saveGroup($_POST);
			if($groupID > 0){
				$g = Groups::getGroupByID($groupID);
				$result['result'] = true;
				$result['newUrl'] = $g->GROUP_URL;
			}
			else{
				$result['result'] = false;
			}
			$this->toJSON($result, true);
		}
	}

	public function updateGroupInfo() {
		if ($this->isAjax()) {
			$groups = new Groups();
			$group = $groups->getGroupByID($_POST['group_id']);
			if (isset($group) and $group->isAdmin() === TRUE) {

				$result['result'] = $groups->updateGroupInfo($group, $_POST);
				$this->toJSON($result, true);
			}
		}
	}

	public function addAlliance() {
		if ($this->isAjax()) {
			$group = $this->getGroup();
			if (isset($group) and $group->isAdmin() === TRUE) {
				$data['group'] = $group;
				echo $this->renderBlock('groups/admin/addAlliances', $data);
			}
		}
	}

	public function editAlliance() {
		if ($this->isAjax()) {
			$group = $this->getGroup();
			if (isset($group) and $group->isAdmin() === TRUE) {
				$groups = new Groups();
				$data['group'] = $group;
				$data['alliance'] = $groups->getAlliance($group, $this->params['alliance_id']);
				echo $this->renderBlock('groups/admin/editAlliance', $data);
			}
		}
	}

	public function saveAlliance() {
		if ($this->isAjax()) {
			$groups = new Groups();
			$group = $groups->getGroupByID($this->params['group']);
			if (isset($group) and $group->isAdmin() === TRUE) {
				$groups = new Groups();
				$result['result'] = $groups->saveAlliance($group, $_POST);
				$this->toJSON($result, true);
			}
		}
	}

	public function removeAlliance() {
		if ($this->isAjax()) {
			$group = Groups::getGroupByID($this->params['group']);
			if (isset($group) and $group->isAdmin() === TRUE) {
				$groups = new Groups();
				$result['result'] = $groups->removeAlliance($group, $_POST['alliance_id']);
				$this->toJSON($result, true);
			}
		}
	}

	/**
	 * searches for friend in send message field
	 *
	 * @return JSON
	 */
	public function ajaxFindGroup() {
		if ($this->isAjax()) {

			$groups = new Groups();
			$group = $groups->getGroupByID($this->params['group']);
			$data = array();
			if($group->isAdmin() === TRUE) {
				$groups = new Groups();
				$result = $groups->getSearchGroups($_GET['q']);
				if(!empty($result)) {
					foreach ($result as $r) {
						$img = MainHelper::showImage($r, THUMB_LIST_60x60, TRUE, array('no_img' => 'noimage/no_group_60x60.png'));
						$data[] = array("id" => $r->ID_GROUP, "img" => $img, "name" => $r->GroupName);
					}
				}
			}

			$this->toJSON($data, true);
		}
	}

	public function addMedia() {
		if ($this->isAjax()) {
			$group = $this->getGroup();
			if (isset($group) and $group->isAdmin() === TRUE) {
				$data['group'] = $group;
				$tabs = array();
				$tabs[MEDIA_VIDEO_URL] = $this->__('Videos');
				$tabs[MEDIA_SCREENSHOT_URL] = $this->__('Screenshots');
				$tabs[MEDIA_CONCEPTART_URL] = $this->__('Concept Art');
				$tabs[MEDIA_WALLPAPER_URL] = $this->__('Wallpapers');

				$data['tabs'] = $tabs;
				echo $this->renderBlock('groups/admin/addMedia', $data);
			}
		}
	}

	public function editMedia() {
		if ($this->isAjax()) {
			$group = $this->getGroup();
			if (isset($group) and $group->isAdmin() === TRUE) {
				$grups = new Groups();
				$data['group'] = $group;
				$media = $grups->getMedia($this->params['media_id']);
				$tabs = array();
				$tabs1 = array();

				if($media->MediaType == MEDIA_VIDEO) {
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
				echo $this->renderBlock('groups/admin/editMedia', $data);
			}
		}
	}

	public function saveMedia() {
		if ($this->isAjax()) {
			if (!isset($this->params['group']))
					return;
			$group = Groups::getGroupByID($this->params['group']);
			if (isset($group) and $group->isAdmin() === TRUE) {
			   $groups = new Groups();
			   $result['result'] = $groups->saveMedia($_POST);
			   $this->toJSON($result, true);
			}
		}
	}

	public function deleteMedia() {
		if ($this->isAjax()) {
			if (!isset($this->params['group']))
					return;
			$group = Groups::getGroupByID($this->params['group']);
			if (isset($group) and $group->isAdmin() === TRUE) {
			   $groups = new Groups();
			   $result['result'] = $groups->deleteMedia($_POST['media_id']);
			   $this->toJSON($result, true);
			}
		}
	}

	public function addMember() {
		if ($this->isAjax()) {
			$group = $this->getGroup();
			if (isset($group) and $group->isAdmin() === TRUE) {
				$data['group'] = $group;
				echo $this->renderBlock('groups/admin/addMember', $data);
			}
		}
	}

	public function inviteMembers() {
		if ($this->isAjax() and MainHelper::validatePostFields(array('group_id'))) {
			$groups = new Groups();
			$group = $groups->getGroupByID($this->params['group']);
			if (isset($group) and $group->isAdmin() === TRUE) {
				$groups = new Groups();
				$data['group'] = $group;
				$result['result'] = $groups->inviteMembers($group, $_POST);
				$this->toJSON($result, true);
			}
		}
	}

	//accept from member notification list
	public function ajaxAcceptInvitation() {
		if ($this->isAjax()) {
			$groups = new Groups();
			$group = $groups->getGroupByID($_POST['group_id']);
			$player = null;
			if(isset ($_POST['player'])) {
				$player = User::getFriend($_POST['player']);
			}
			$result['result'] = $groups->acceptInvitation($group, $player);
			$this->toJSON($result, true);
		}
	}

	//reject from member notification list
	public function ajaxRejectInvitation() {
		if ($this->isAjax()) {
			$groups = new Groups();
			$group = $groups->getGroupByID($_POST['group_id']);
			$player = null;
			if(isset ($_POST['player'])) {
				$player = User::getFriend($_POST['player']);
			}

			$result['result'] = $groups->rejectInvitation($group, $player);
			$this->toJSON($result, true);
		}
	}

	/**
	 * opens application form for group join
	 */
	public function requestToJoin() {
		if ($this->isAjax()) {
			$group = $this->getGroup();
			$data['group'] = $group;
			echo $this->renderBlock('groups/requestToJoin', $data);
		}
	}

	public function sendRequestToJoin() {
		if ($this->isAjax()) {
			$groups = new Groups();
			$group = $groups->getGroupByID($_POST['group_id']);
			if($group) {
				$result['result'] = $groups->sendRequestToJoin($group, $_POST);
				$result['id'] = $group->ID_GROUP;
				$this->toJSON($result, true);
			}
		}
	}

	public function deleteGroup() {
		if ($this->isAjax()) {
			$groups = new Groups();
			$group = $groups->getGroupByID($this->params['group']);
			if($group) {
				$result['result'] = $groups->deleteGroup($group);
				$this->toJSON($result, true);
			}
		}
	}

	public function leaveGroup() {
		if ($this->isAjax()) {
			$groups = new Groups();
			$group = $groups->getGroupByID($this->params['group']);
			if($group) {
				$result['result'] = $groups->leaveGroup($group);
				$this->toJSON($result, true);
			}
		}
	}

	/**
	 * Toggles like/unlike for group
	 *
	 * @return JSON
	 */
	public function ajaxToggleLike() {
		if ($this->isAjax()) {
			$player = User::getUser();
			if ($player) {
				$result['result'] = $player->toggleLikeGroup($_POST['id']);
				$player->purgeCache();
				$this->toJSON($result, true);
			}
		}
	}

	public function toggleMemberRank() {
		$result['result'] = false;
		if ($this->isAjax()) {
			$player = User::getFriend($_POST['member']);
			if($player) {
				$groups = new Groups();
				$group = $groups->getGroupByID($_POST['group_id']);

				if($group->isAdmin()) {
					$result['result'] = $groups->toggleMemberRank($group, $player);
					$result['rank'] = PlayerHelper::showRank($groups->getPlayerGroupRel($group, $player));
					$player->purgeCache();
				}
			}
		}
		$this->toJSON($result, true);
	}

	private function getGroup() {
		if (!isset($this->params['group'])) {
			DooUriRouter::redirect(Doo::conf()->APP_URL);
			return FALSE;
		}

		$key = $this->params['group'];
		$groups = new Groups();
		$url = Url::getUrlByName($key, URL_GROUP);
		if ($url) {
			$group = $groups->getGroupByID($url->ID_OWNER);
		} else {
			DooUriRouter::redirect(Doo::conf()->APP_URL);
			return FALSE;
		}
		if (!$group) {
			DooUriRouter::redirect(Doo::conf()->APP_URL);
			return FALSE;
		}

		return $group;
	}

	public function addNews() {
		$this->moduleOff();

		$group = $this->getGroup();
		if(!$group || $group->isAdmin() == false) {
			DooUriRouter::redirect($group->GROUP_URL);
			return FALSE;
		}

		$list = array();

		if(isset($_POST) and !empty($_POST)) {
			$news = new News();
			$result = $news->saveNews($_POST,0,0,1);
			if($result instanceof NwItems) {
				$translated = current($result->NwItemLocale);
				$LID = $translated->ID_LANGUAGE;
				DooUriRouter::redirect($group->GROUP_URL.'/admin/edit-news/'.$result->ID_NEWS.'/'.$LID);
				return FALSE;
			} else {
				$list['post'] = $_POST;
			}
		}

		$list['group'] = $group;
		$list['language'] = 1;
		$list['languages'] = Lang::getLanguages();
		$list['CategoryType'] = false;
		$list['infoBox'] = MainHelper::loadInfoBox('Groups', 'index', true);
		$player = User::getUser();

		$data['title'] = $this->__('Add News');
		$data['body_class'] = 'recent_games';
		$data['selected_menu'] = 'groups';
		$data['left'] = MainHelper::groupsLeftSide($group);
		$data['right'] = PlayerHelper::playerRightSide();
		$data['content'] = $this->renderBlock('groups/admin/addEditNews', $list);
		$data['footer'] = MainHelper::bottomMenu();
		$data['header'] = MainHelper::topMenu();
		$this->render3Cols($data);
	}
        
        public function chooseLang() {
            $this->moduleOff();
            if($this->isAjax()) {
                $group = $this->getGroup();
                if(!$group or !isset($this->params['news_id'])) {
                    DooUriRouter::redirect($group->GROUP_URL);
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

		$group = $this->getGroup();
		if(!$group || $group->isAdmin() == false || !isset($this->params['news_id'])) {
			DooUriRouter::redirect($group->GROUP_URL);
			return FALSE;
		}

		if(isset($_POST) and !empty($_POST)) {
			$news = new News();
			$result = $news->updateNews($_POST);
			if($result instanceof NwItems) {
				$translated = current($result->NwItemLocale);
				$LID = $translated->ID_LANGUAGE;
				DooUriRouter::redirect($group->GROUP_URL.'/admin/edit-news/'.$result->ID_NEWS.'/'.$LID);
				return FALSE;
			} else {
				$list['post'] = $_POST;
			}
		}

		$news = new News();
		$list = array();
		$list['group'] = $group;
		$newsItem = $news->getArticleByID($this->params['news_id'], $this->params['lang_id']);
		$translated = null;
		if(isset($newsItem->NwItemLocale)) {
			$translated = current($newsItem->NwItemLocale);
		}

		if(!isset($translated)) {
			DooUriRouter::redirect($group->GROUP_URL.'/news');
			return FALSE;
		}

		$list['newsItem'] = $newsItem;
		$list['language'] = $this->params['lang_id'];
		$list['languages'] = Lang::getLanguages();
		$list['translated'] = $translated;
		$list['CategoryType'] = false;
		$list['infoBox'] = MainHelper::loadInfoBox('Groups', 'index', true);

		$data['title'] = $this->__('Edit News');
		$data['body_class'] = 'recent_games';
		$data['selected_menu'] = 'groups';
		$data['left'] = MainHelper::groupsLeftSide($group);
		$data['right'] = PlayerHelper::playerRightSide();
		$data['content'] = $this->renderBlock('groups/admin/addEditNews', $list);
		$data['footer'] = MainHelper::bottomMenu();
		$data['header'] = MainHelper::topMenu();
		$this->render3Cols($data);
	}

	public function ajaxSearchGroups(){
		if($this->isAjax()){
			$s = '';
			$g = new Groups();
			if(isset($_POST['q']) and strlen($_POST['q']) >= 3){
				$groups = $g->searchGroups($_POST['q']);

				if(!empty($groups)){
					foreach($groups as $group){
						$s .= $this->renderBlock('common/groupSmall', array('group' => $group, 'id' => 'F_addGroup'));
					}
				}
			}

			$this->toJSON($s, true);
		}
	}

    public function downloadsView() {
		$this->moduleOff();

		$group = $this->getGroup();
		$groups = new Groups();
		$news = new News();
		$list = array();
		$list['CategoryType'] = GAME_DOWNLOADS;
		// $list['CategoryType'] = GROUP_DOWNLOADS;
		$list['infoBox'] = MainHelper::loadInfoBox('Groups', 'index', true);
		$list['group'] = $group;

        $list['tabsD'] = $groups->getFiletypes($group->ID_GROUP);
		if (!empty($list['tabsD'])) {
			$list['downloads'] = array();
			foreach ($list['tabsD'] as $tab) {
				$list['downloads'] = array_merge($list['downloads'], $tab->getDownloads());
			}
		}

		$pager = $this->appendPagination($list, $groups, $group->DownloadableItems, $group->GROUP_URL . '/downloads/page', Doo::conf()->groupsLimit);

		$data['title'] = $this->__('Downloads');
		$data['body_class'] = 'group_downloads';
		$data['selected_menu'] = 'groups';
		$data['left'] = MainHelper::groupsLeftSide($group);
		$data['right'] = PlayerHelper::playerRightSide();
		$data['content'] = $this->renderBlock('groups/downloadsView', $list);
		$data['footer'] = MainHelper::bottomMenu();
		$data['header'] = MainHelper::topMenu();
		$this->render3Cols($data);
	}
    
	/**
	 * opens add download window
	 */
	public function addDownload() {
		$p = User::getUser();
		if ($this->isAjax() and $p) {
			$group = $this->getGroup();
			if (isset($group) and $p->canAccess('Edit group information')) {
				$data['group'] = $group;
				$groups = new Groups();
				$data['tabs'] = $groups->getFiletypes($group->ID_GROUP);
				echo $this->renderBlock('groups/admin/addDownload', $data);
			}
		}
	}

	/**
	 * saves download to specified tab
	 */
	public function saveDownload() {
		$p = User::getUser();
		if ($this->isAjax() and $p) {
    		$groups = new Groups();
			$group = $groups->getGroupByID($_POST['group_id']);
			if (isset($group) and $p->canAccess('Edit group information')) {
				$result['result'] = $groups->saveDownload($group, $_POST);
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
			$groups = new Groups();
			$group = $groups->getGroupByID($_POST['group_id']);
			if (isset($group) and $p->canAccess('Edit group information')) {
				$result['result'] = $groups->deleteDownload($_POST['download_id']);
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
			$group = $this->getGroup();
			if (isset($group) and $p->canAccess('Edit group information')) {
				$data['group'] = $group;
				echo $this->renderBlock('groups/admin/addDownloadTab', $data);
			}
		}
	}

	/**
	 * saves tab
	 */
	public function saveDownloadTab() {
		$p = User::getUser();
		if ($this->isAjax() and $p) {
    		$groups = new Groups();
			$group = $groups->getGroupByID($_POST['group_id']);
			if (isset($group) and $p->canAccess('Edit group information')) {
				$result['result'] = $groups->saveDownloadTab($group, $_POST);
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
			$group = $this->getGroup();
			if (isset($group) and $p->canAccess('Edit group information')) {
				$data['group'] = $group;
				$groups = new Groups();
				$data['tabs'] = $groups->getFiletypes($group->ID_GROUP);
				$data['first_tabs'] = $data['tabs'][0];

				echo $this->renderBlock('groups/admin/editDownloadTab', $data);
			}
		}
	}

	public function deleteDownloadTab() {
		$p = User::getUser();
		if ($this->isAjax() and isset($this->params['group']) and MainHelper::validatePostFields(array('tab_id')) and $p) {
			$group = Groups::getGroupByID($this->params['group']);
			if (isset($group) and $p->canAccess('Edit group information')) {
				$groups = new Groups();
				$result['result'] = $groups->deleteDownloadTab($_POST['tab_id']);
				$this->toJSON($result, true);
			}
		}
	}
}