<?php

class RecruitmentController extends SnController {

	public function moduleOff()
	{
		$notAvailable = MainHelper::TrySetModuleNotAvailableByTag('recruitment');
		if ($notAvailable)
		{
			$data['title'] = $this->__('Recruitment');
			$data['body_class'] = 'index_recruitment';
			$data['selected_menu'] = 'recruitment';
			$data['left'] = PlayerHelper::playerLeftSide();
			$data['right'] = PlayerHelper::playerRightSide();
			$data['content'] = $notAvailable;
			$data['footer'] = MainHelper::bottomMenu();
			$data['header'] = MainHelper::topMenu();
			$this->render3Cols($data);
			exit;
		}
	}//catia

	/**
	 * Main website
	 *
	 */
	public function index() {
		$this->moduleOff();
		
		$recruitments = new Recruitment();
		$languages = new Lang();
		$list = array();
		$noticesTotal = $recruitments->getNoticesTotal();
		$pager = $this->appendPagination($list, $recruitments, $noticesTotal, MainHelper::site_url(RECRUITMENT_NOTICES.'/page'), Doo::conf()->noticesLimit);
		$limit = $pager->limit;
		$player = User::getUser();

		if (isset($this->params['ownertype'])) {
			$ownertype = $this->params['ownertype'];
			if ($ownertype != '') {
				$ok = $recruitments->setOwnerType($ownertype);
			}
		} else {
			$ownertype = $recruitments->getOwnerType();
			if ($ownertype == '') {
				$ownertype = 'player';
				$ok = $recruitments->setOwnerType($ownertype);
			}
		}
		if (isset($this->params['region'])) {
			$region = $this->params['region'];
			if ($region != '') {
				$ok = $recruitments->setRegion($region);
			}
		} else {
			$region = $recruitments->getSetRegion();
		}
		if (isset($this->params['faction'])) {
			$faction = $this->params['faction'];
			if ($faction != '') {
				$ok = $recruitments->setFaction($faction);
			}
		} else {
			$faction = $recruitments->getSetFaction();
		}
		if (isset($this->params['role'])) {
			$role = $this->params['role'];
			if ($role != '') {
				$ok = $recruitments->setRole($role);
			}
		} else {
			$role = $recruitments->getSetRole();
		}
		if (isset($this->params['mode'])) {
			$mode = $this->params['mode'];
			if ($mode != '') {
				$ok = $recruitments->setMode($mode);
			}
		} else {
			$mode = $recruitments->getSetMode();
		}
		if (isset($this->params['level'])) {
			$level = $this->params['level'];
			if ($level != '') {
				$ok = $recruitments->setLevel($level);
			}
		} else {
			$level = $recruitments->getSetLevel();
		}
		if (isset($this->params['server'])) {
			$server = $this->params['server'];
			if ($server != '') {
				$ok = $recruitments->setServer($server);
			}
		} else {
			$server = $recruitments->getSetServer();
		}
		if (isset($this->params['lang'])) {
			$lang = $this->params['lang'];
			if ($lang != '') {
				$ok = $recruitments->setLang($lang);
			}
		} else {
			$lang = $recruitments->getSetLang();
		}
		if (isset($this->params['game'])) {
			$game_id = $this->params['game'];
			if ($game_id!='') {
				$ok = $recruitments->setGame($game_id);
			}
		} else {
			$game_id = $recruitments->getSetGames();
		}
		if(isset($_GET['typeGame'])) 
		{
			$typeGame = $_GET['typeGame'];
		} else {
			$typeGame = '';
		}
		if(isset($_GET['type']))
		{
			$type = $_GET['type'];
		} else {
			$type = '';
		}
		if(isset($_GET['order']))
		{
			$order = $_GET['order'];
		} else {
			$order = '1';
		}
		if(isset($_GET['typeKeywords'])) 
		{
			$typeKeywords = $_GET['typeKeywords'];
		} else {
			$typeKeywords = '';
		}
		//die($type.'strg');
		
		
		
		$list['gameList'] = $recruitments->getGames();
		$list['regionList'] = $recruitments->getRegions();
		$list['langList'] = $languages->getLanguages();
		$list['serverList'] = $recruitments->getServer();
		$list['factionList'] = $recruitments->getFaction($game_id);
		$list['roleList'] = $recruitments->getRoles($game_id);
		$list['levelList'] = $recruitments->getLevel($game_id);
		$list['modeList'] = $recruitments->getMode($game_id);
		$list['serverList'] = $recruitments->getServer($game_id);

		$list['noticesList'] = $recruitments->getNotices($ownertype,$game_id,$level,$mode,$role,$faction,$region,$server,$lang,$limit,$typeGame,$type,$order,$typeKeywords);
		
		$list['top5player'] = $recruitments->getTop5Notices('player');
		$list['top5group'] = $recruitments->getTop5Notices('group');
		$list['type'] = $type;
		$list['order'] = $order;
		
		$list['noticesTotal'] = $noticesTotal;
		$list['noticesLimit'] = Doo::conf()->noticesLimit;
		$list['game_id'] = $game_id;
		$list['ownertype'] = $ownertype;
		$list['region'] = $region;
		$list['faction'] = $faction;
		$list['role'] = $role;
		$list['mode'] = $mode;
		$list['level'] = $level;
		$list['server'] = $server;
		$list['lang'] = $lang;
		$list['ownerid'] = ($player ? $player->ID_PLAYER : '');
		$list['headerName'] = $this->__('List Notices');

		$data['title'] = $this->__('recruitment');
		$data['body_class'] = 'index_groups';
		$data['selected_menu'] = 'recruitment';
		$data['left'] = PlayerHelper::playerLeftSide();
		$data['right'] = PlayerHelper::playerRightSide();
		$data['content'] = $this->renderBlock('recruitment/listNotices', $list);
		$data['footer'] = MainHelper::bottomMenu();
		$data['header'] = MainHelper::topMenu();
		$this->render3Cols($data);
	}

	public function my_notices() {
		$this->moduleOff();
		
		$recruitments = new Recruitment();
		$lang = new Lang();
		$list = array();
		$player = User::getUser();

		if (isset($this->params['ownertype'])) {
			$ownertype = $this->params['ownertype'];
			if ($ownertype != '') {
				$ok = $recruitments->setOwnerType($ownertype);
			}
		} else {
			$ownertype = $recruitments->getOwnerType();
			if ($ownertype == '') {
				$ownertype = 'player';
				$ok = $recruitments->setOwnerType($ownertype);
			}
		}
		if (isset($this->params['ownertype'])) {
			$ownertype = $this->params['ownertype'];
			if ($ownertype != '') {
				$ok = $recruitments->setOwnerType($ownertype);
			}
		} else {
			$ownertype = $recruitments->getOwnerType();
			if ($ownertype == '') {
				$ownertype = 'player';
				$ok = $recruitments->setOwnerType($ownertype);
			}
		}
		if (isset($this->params['region'])) {
			$region = $this->params['region'];
			if ($region != '') {
				$ok = $recruitments->setRegion($region);
			}
		} else {
			$region = $recruitments->getSetRegion();
		}
		if (isset($this->params['faction'])) {
			$faction = $this->params['faction'];
			if ($faction != '') {
				$ok = $recruitments->setFaction($faction);
			}
		} else {
			$faction = $recruitments->getSetFaction();
		}
		if (isset($this->params['role'])) {
			$role = $this->params['role'];
			if ($role != '') {
				$ok = $recruitments->setRole($role);
			}
		} else {
			$role = $recruitments->getSetRole();
		}
		if (isset($this->params['mode'])) {
			$mode = $this->params['mode'];
			if ($mode != '') {
				$ok = $recruitments->setMode($mode);
			}
		} else {
			$mode = $recruitments->getSetMode();
		}
		if (isset($this->params['level'])) {
			$level = $this->params['level'];
			if ($level != '') {
				$ok = $recruitments->setLevel($level);
			}
		} else {
			$level = $recruitments->getSetLevel();
		}
		if (isset($this->params['type'])) {
			$type = $this->params['type'];
			if ($type!='') {
				$ok = $recruitments->setType($type);
			}
		} else {
			$type = $recruitments->getSetType();
			if ($type == '') {
				$type = 'notices';
				$ok = $recruitments->setType($type);
			}
		}
		if (isset($this->params['game'])) {
			$game_id = $this->params['game'];
			if ($game_id!='') {
				$ok = $recruitments->setGame($game_id);
			}
		} else {
			$game_id = $recruitments->getSetGames();
		}

		$list['gameList'] = $recruitments->getGames();
		$list['regionList'] = $recruitments->getRegions();
		$list['langList'] = $lang->getLanguages();
		$list['serverList'] = $recruitments->getServer();
		$list['factionList'] = $recruitments->getFaction($game_id);
		$list['roleList'] = $recruitments->getRoles($game_id);
		$list['levelList'] = $recruitments->getLevel($game_id);
		$list['modeList'] = $recruitments->getMode($game_id);

		$list['type'] = $type;
		$list['game_id'] = $game_id;
		$list['ownertype'] = $ownertype;
		$list['region'] = $region;
		$list['faction'] = $faction;
		$list['role'] = $role;
		$list['mode'] = $mode;
		$list['level'] = $level;
		$list['ownerid'] = ($player ? $player->ID_PLAYER : '');

		//$noticesTotal = $recruitments->getMyNoticesTotal($ownertype,($player ? $player->ID_PLAYER : ''));
//		$pager = $this->appendPagination($list, $recruitments, $noticesTotal, MainHelper::site_url(RECRUITMENT_NOTICES.'/'.RECRUITMENT_MY_NOTICES.'/page'), Doo::conf()->mynoticesLimit);
//		$limit = $pager->limit;
		$limit = '';
		$list['noticesList'] = $recruitments->getMyNotices($ownertype,($player ? $player->ID_PLAYER : ''),$type,$limit);


		$list['headerName'] = $this->__('List Notices');

		$data['title'] = $this->__('recruitment');
		$data['body_class'] = 'index_groups';
		$data['selected_menu'] = 'recruitment';
		$data['left'] = PlayerHelper::playerLeftSide();
		$data['right'] = PlayerHelper::playerRightSide();
		$data['content'] = $this->renderBlock('recruitment/myNoticesResponses', $list);
		$data['footer'] = MainHelper::bottomMenu();
		$data['header'] = MainHelper::topMenu();
		$this->render3Cols($data);

	}

	 public function create_notices() {
	 	$this->moduleOff();
		
		$recruitments = new Recruitment();
		$languages = new Lang();
		$list = array();
		$player = User::getUser();
		
		$game_class = new Games();
		
		if (isset($this->params['ownertype'])) {
			$ownertype = $this->params['ownertype'];
			if ($ownertype != '') {
				$ok = $recruitments->setOwnerType($ownertype);
			}
		} else {
			$ownertype = $recruitments->getOwnerType();
			if ($ownertype == '') {
				$ownertype = 'player';
				$ok = $recruitments->setOwnerType($ownertype);
			}
		}
		if (isset($this->params['region'])) {
			$region = $this->params['region'];
			if ($region != '') {
				$ok = $recruitments->setRegion($region);
			}
		} else {
			$region = $recruitments->getSetRegion();
		}
		if (isset($this->params['faction'])) {
			$faction = $this->params['faction'];
			if ($faction != '') {
				$ok = $recruitments->setFaction($faction);
			}
		} else {
			$faction = $recruitments->getSetFaction();
		}
		if (isset($this->params['role'])) {
			$role = $this->params['role'];
			if ($role != '') {
				$ok = $recruitments->setRole($role);
			}
		} else {
			$role = $recruitments->getSetRole();
		}
		if (isset($this->params['mode'])) {
			$mode = $this->params['mode'];
			if ($mode != '') {
				$ok = $recruitments->setMode($mode);
			}
		} else {
			$mode = $recruitments->getSetMode();
		}
		if (isset($this->params['level'])) {
			$level = $this->params['level'];
			if ($level != '') {
				$ok = $recruitments->setLevel($level);
			}
		} else {
			$level = $recruitments->getSetLevel();
		}
		if (isset($this->params['server'])) {
			$server = $this->params['server'];
			if ($server != '') {
				$ok = $recruitments->setServer($server);
			}
		} else {
			$server = $recruitments->getSetServer();
		}
		if (isset($this->params['lang'])) {
			$lang = $this->params['lang'];
			if ($lang != '') {
				$ok = $recruitments->setLang($lang);
			}
		} else {
			$lang = $recruitments->getSetLang();
		}
		if (isset($this->params['game'])) {
			$game_id = $this->params['game'];
			if ($game_id!='') {
				$ok = $recruitments->setGame($game_id);
			}
		} else {
			$game_id = $recruitments->getSetGames();
		}
//		echo "<pre>";
// 	print_r($_POST);
//  	echo "</pre>";
//  	die('test ');
		if(isset($_GET['game'])) 
        {
			$id_game = $_GET['game'];
		} else {
			$id_game = '';
		}
		if ($id_game == '') {
			if(isset($_POST['game'])) 
			{
				$id_game = $_POST['game'];
			}
		}
		$region = '';
		if(isset($_POST['region'])) 
        {
			$region = $_POST['region'];
		}
		$lang = '';
		if(isset($_POST['language'])) 
        {
			$lang = $_POST['language'];
		}
		$server = '';
		if(isset($_POST['server'])) 
        {
			$server = $_POST['server'];
		}
		$faction = '';
		if(isset($_POST['faction'])) 
        {
			$faction = $_POST['faction'];
		}
		if(isset($_POST['role'])) 
        {
			$role = $_POST['role'];
		} else {
			$role = '';
		}
		$level = '';
		if(isset($_POST['gplvl'])) 
        {
			$level = $_POST['gplvl'];
		}
		$mode = '';
		if(isset($_POST['gpmode'])) 
        {
			$mode = $_POST['gpmode'];
		}

		$gamedescription = '';
		if(isset($_POST['gamedescription'])) 
        {
			//echo "<script> alert('testdescr'); 
			$gamedescription = $_POST['gamedescription'];
//			die($_POST['gamedescription']);//	
		}
		$ownerid = '';
		if(isset($_POST['ownerid'])) 
        {
			//echo "<script> alert('testdescr'); 
			$ownerid = $_POST['ownerid'];
//			die($_POST['gamedescription']);//	
		}
		$type = '';
		if(isset($_GET['type'])) 
        {
			//echo "<script> alert('testdescr'); 
			$type = $_GET['type'];
//			die($_POST['gamedescription']);//	
		}
//die($type.'test '.$ownerid);
		if ($ownerid != '') {
			if ($player) {
				 if (($type=='group') && ($ownerid!=$player->ID_PLAYER)) {
				 	$group = Groups::getGroupByID($ownerid);
				 }
			}
		}
		//die($level);
		$list['gameinfo'] = $game_class->getGameByID($id_game);
		$list['gamedescription'] = $gamedescription;
		$list['gameList'] = $recruitments->getGames();
		$list['regionList'] = $recruitments->getRegions();
		$list['langList'] = $languages->getLanguages();
		$list['serverList'] = $recruitments->getServer();
		$list['factionList'] = $recruitments->getFaction($id_game);
		$list['roleList'] = $recruitments->getRoles($id_game);
		$list['levelList'] = $recruitments->getLevel($id_game);
		$list['modeList'] = $recruitments->getMode($id_game);
		$list['serverList'] = $recruitments->getServer($id_game);
		$list['userid'] = ($player ? $player->ID_PLAYER : '');
		if (($type=='player') || ($type=='')) {
			$list['ownerid'] = ($player ? $player->ID_PLAYER : '');
			$list['owneusername'] = ($player ? $player->NickName : '');
			$list['playerinfo'] = ($player ? $player : '');
		} else {
			$list['ownerid'] = ($ownerid);
			$list['owneusername'] = ($player ? $player->NickName : '');
			$list['playerinfo'] = ($player ? $player : '');
		}
		$list['step'] = '';
		$list['details'] = '';
		$list['description'] = '';
		$list['type'] = $type;
		$list['game_id'] = $game_id;
		$list['ownertype'] = $ownertype;
		$list['region'] = $region;
		$list['faction'] = $faction;
		$list['role'] = $role;
		$list['gpmode'] = $mode;
		$list['gplvl'] = $level;
		$list['server'] = $server;
		$list['language'] = $lang;
		$list['weapon'] = '';
		$list['headerName'] = $this->__('List Notices');
		
		$list['mode'] = $mode;
		$list['level'] = $level;

		$data['title'] = $this->__('recruitment');
		$data['body_class'] = 'index_groups';
		$data['selected_menu'] = 'recruitment';
		$data['left'] = PlayerHelper::playerLeftSide();
		$data['right'] = PlayerHelper::playerRightSide();
		$data['content'] = $this->renderBlock('recruitment/createNotices', $list);
		$data['footer'] = MainHelper::bottomMenu();
		$data['header'] = MainHelper::topMenu();
		$this->render3Cols($data);

	}
	
	public function save_notices() {
		$this->moduleOff();
		
		$recruit = new Recruitment();
		$noticeID = $recruit->saveNotice($_POST);
		if($noticeID > 0){
			$result['result'] = true;
			$result['newUrl'] =  MainHelper::site_url(RECRUITMENT_NOTICES);

			setcookie('game', '', (time() + (3600 * 24 * 365)), "/");
			setcookie('mode', '', (time() + (3600 * 24 * 365)), "/");
			setcookie('level', '', (time() + (3600 * 24 * 365)), "/");
			setcookie('role', '', (time() + (3600 * 24 * 365)), "/");
			setcookie('faction', '', (time() + (3600 * 24 * 365)), "/");
			setcookie('server', '', (time() + (3600 * 24 * 365)), "/");
			$link=MainHelper::site_url(RECRUITMENT_NOTICES);
			DooUriRouter::redirect($link);
		}
		else{
			$result['result'] = false;
		}
	}

	public function save_response() {
		$this->moduleOff();
		
		$recruit = new Recruitment();
//echo "<pre>";
// 	print_r($_POST);
//  	echo "</pre>";
//  	die('test ');
		$nid = $_POST['nid'];
		$ownertype = $_POST['ownertype'];
		$responseID = $recruit->saveResponse($_POST);
		if($responseID > 0){
			$result['result'] = true;
			
			$result['newUrl'] =  MainHelper::site_url(RECRUITMENT_NOTICES.'/'.RECRUITMENT_RESPOND_NOTICES.'/'.$nid.'/'.$ownertype);

			setcookie('game', '', (time() + (3600 * 24 * 365)), "/");
			setcookie('mode', '', (time() + (3600 * 24 * 365)), "/");
			setcookie('level', '', (time() + (3600 * 24 * 365)), "/");
			setcookie('role', '', (time() + (3600 * 24 * 365)), "/");
			setcookie('faction', '', (time() + (3600 * 24 * 365)), "/");
			setcookie('server', '', (time() + (3600 * 24 * 365)), "/");

			$link=MainHelper::site_url(RECRUITMENT_NOTICES.'/'.RECRUITMENT_RESPOND_NOTICES.'/'.$nid.'/'.$ownertype);

			DooUriRouter::redirect($link);

		}
		else{
			$result['result'] = false;
		}
	}

	public function update_response() {
		$this->moduleOff();
		
		$recruit = new Recruitment();
		if (isset($this->params['rid'])) {
			$responseid = $this->params['rid'];
		}
		if (isset($this->params['status'])) {
			$statusid = $this->params['status'];
		}
		if (isset($this->params['owner'])) {
			$owner = $this->params['owner'];
		}
		if (isset($this->params['notice'])) {
			$notice = $this->params['notice'];
		}
		$responseID = $recruit->updateResponse($responseid,$statusid,$owner,$notice);

		if($responseID > 0){

			$result['result'] = true;
			$result['newUrl'] =  MainHelper::site_url(RECRUITMENT_NOTICES.'/'.RECRUITMENT_MY_NOTICES);

			setcookie('game', '', (time() + (3600 * 24 * 365)), "/");
			setcookie('mode', '', (time() + (3600 * 24 * 365)), "/");
			setcookie('level', '', (time() + (3600 * 24 * 365)), "/");
			setcookie('role', '', (time() + (3600 * 24 * 365)), "/");
			setcookie('faction', '', (time() + (3600 * 24 * 365)), "/");
			setcookie('server', '', (time() + (3600 * 24 * 365)), "/");

			$this->index();
		}
		else{
			$result['result'] = false;
		}
	}

	public function respond_notices() {
		$this->moduleOff();
		
		$recruitments = new Recruitment();
		$list = array();
		$player = User::getUser();

		if (isset($this->params['ownertype'])) {
			$ownertype = $this->params['ownertype'];

		} else {
			$ownertype = '';
		}
		if (isset($this->params['nid'])) {
			$nid = $this->params['nid'];
		} else {
			$nid = '';
		}
		//$not = $recruitments->getNoticeById($nid,$ownertype);
//		if(isset($not) and !empty($not)) {
//			$originalcount = $not->ViewCount;
//		}
////		
		$countplus = $recruitments->NoticeCountViews($nid);
		$count = $recruitments->updateNoticeViews($nid,$countplus);
//		
		$list['listresponses'] = $recruitments->getResponsesByNotices($nid);
		$list['totalresponses'] = $recruitments->getResponsesTotal($nid);
		$list['noticeList'] = $recruitments->getNoticeById($nid,$ownertype);
		
		
		$list['ownertype'] = $ownertype;
		$list['nid'] = $nid;
		$list['ownerid'] = ($player ? $player->ID_PLAYER : '');
		$oid=($player ? $player->ID_PLAYER : '');
		$list['committer'] = $recruitments->getownerinfo($oid,$ownertype);

		$list['headerName'] = $this->__('Create Response');

		$data['title'] = $this->__('recruitment');
		$data['body_class'] = 'index_groups';
		$data['selected_menu'] = 'recruitment';
		$data['left'] = PlayerHelper::playerLeftSide();
		$data['right'] = PlayerHelper::playerRightSide();
		$data['content'] = $this->renderBlock('recruitment/createResponse', $list);
		$data['footer'] = MainHelper::bottomMenu();
		$data['header'] = MainHelper::topMenu();
		$this->render3Cols($data);
	}
}

?>
