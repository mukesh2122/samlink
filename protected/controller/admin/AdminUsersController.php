<?php

class AdminUsersController extends AdminController {

    /**
     * Main website
     *
     */
    public function index() {
		$users = new User();
        $list = array();
		$player = User::getUser();
		if($player->canAccess('Edit user information') === FALSE && $player->canAccess('Edit user info light') === FALSE) {
			DooUriRouter::redirect(MainHelper::site_url('admin'));
		}
		
		$pager = $this->appendPagination($list, new stdClass(), $users->getTotalPlayers($player), MainHelper::site_url('admin/users/page'), Doo::conf()->adminPlayersLimit);
        $sortType = isset($this->params['sortType']) ? $this->params['sortType'] : 'date';
		$sortDir = isset($this->params['sortDir']) ? $this->params['sortDir'] : 'desc';
		$list['users'] = $users->getAllUsers($pager->limit, $player, $sortType, $sortDir);
		$list['player'] = $player;
		$list['sortType'] = $sortType;
		$list['sortDir'] = $sortDir;
		
		$data['title'] = $this->__('Users');
		$data['body_class'] = 'index_users';
		$data['selected_menu'] = 'users';
		$data['left'] =  $this->renderBlock('users/common/leftColumn');
		$data['content'] = $this->renderBlock('users/index', $list);
		$data['header'] = $this->getMenu();
		$this->render2ColsLeft($data); 
	}
	
	/**
     * searches users
     *
     */
    public function search() {
        if (!isset($this->params['searchText'])) {
            DooUriRouter::redirect(MainHelper::site_url('admin/users'));
            return FALSE;
        }
		$users = new User();
		$search = new Search();
        $list = array();
		$player = User::getUser();
		if($player->canAccess('Edit user information') === FALSE && $player->canAccess('Edit user info light') === FALSE) {
			DooUriRouter::redirect(MainHelper::site_url('admin'));
		}

		$list['searchText'] = urldecode($this->params['searchText']);
        $totalResults = $search->getSearchTotal(urldecode($this->params['searchText']), SEARCH_PLAYER);
        $pager = $this->appendPagination($list, new stdClass(), $totalResults, MainHelper::site_url('admin/users/search/' . urlencode($list['searchText'])), Doo::conf()->adminPlayersLimit);


        $list['searchTotal'] = $totalResults;
        $list['users'] = $search->getSearch(urldecode($this->params['searchText']), SEARCH_PLAYER, $pager->limit);

		$data['title'] = $this->__('Users');
		$data['body_class'] = 'index_users';
		$data['selected_menu'] = 'users';
		$data['left'] =  $this->renderBlock('users/common/leftColumn');
		$data['right'] = 'right';
        $data['content'] = $this->renderBlock('users/index', $list);
        $data['header'] = $this->getMenu();
        $this->render3Cols($data);
    }

	public function cancelsuspend()
	{
		$users = new User();
		$player = User::getUser();
		if($player->canAccess('Edit user information') === FALSE && $player->canAccess('Edit user info light') === FALSE) {
			DooUriRouter::redirect(MainHelper::site_url('admin'));
		}

		if (isset($this->params['user_id']))
		{
			//Make his suspension history..
			$user_id = $this->params['user_id'];
			$users->CancelSuspend($user_id);
			DooUriRouter::redirect(MainHelper::site_url('admin/users/edit/'.$user_id));
		}
		DooUriRouter::redirect(MainHelper::site_url('admin/users'));
	}
	
	public function updateSuspendByPost($user)
	{
		if (isset($_POST['action']))
		{
			if ($_POST['action'] == "editsuspend")
			{
				$StartDate = $_POST['StartDate'];
/*				$StartDate = "0000-00-00";
				if (isset($_POST["StartDate_year"]) and isset($_POST["StartDate_month"]) and isset($_POST["StartDate_day"])) 
				{
					$year = $_POST["StartDate_year"];
					$month = $_POST["StartDate_month"];
					$day = $_POST["StartDate_day"];
					$y = '0000';
					$m = '00';
					$d = '00';
					if ($year > 0)
						$y = intval($year);
					if ($month > 0)
						$m = intval($month);
					if ($day > 0)
						$d = intval($day);

					$StartDate = $y . '-' . $m . '-' . $d;
				}*/


				$ID_SUSPEND = $_POST['ID_SUSPEND'];
				$Days = $_POST['Days'];
				$Level = $_POST['Level'];
				$Reason = $_POST['Reason'];
				$Public = isset($_POST['Public']) ? 1 : 0;
				$Unlimited = ($Level==4 || $Level==5) ? 1 : 0;
				
				//Calc enddate by startdate + days
				$Days = intval($Days);
				$Days = $Days>0 ? $Days : 1;
				$EndTime = strtotime("+{$Days} days",strtotime($StartDate));
				$EndDate = date('Y-m-d',$EndTime);
	
				$query = "UPDATE sn_playersuspend SET
						StartDate = '{$StartDate}',
						EndDate = '{$EndDate}',
						Days= $Days,
						Level = $Level,
						Reason = '{$Reason}',
						Public = $Public,
						Unlimited = $Unlimited
					WHERE ID_SUSPEND = {$ID_SUSPEND}";
				//echo $query;exit;
				Doo::db()->query($query);
				
				DooUriRouter::redirect(MainHelper::site_url('admin/users/edit/'.$user->ID_PLAYER));
			}
			if ($_POST['action'] == "newsuspend")
			{
				$StartDate = $_POST['StartDate'];

				$Days = $_POST['Days'];
				$Level = $_POST['Level'];
				$Reason = $_POST['Reason'];
				$Public = isset($_POST['Public']) ? 1 : 0;
				$Unlimited = ($Level==4 || $Level==5) ? 1 : 0;
				
				//Calc enddate by startdate + days
				$Days = intval($Days);
				$Days = $Days>0 ? $Days : 1;
				$EndTime = strtotime("+{$Days} days",strtotime($StartDate));
				$EndDate = date('Y-m-d',$EndTime);

				//Make all his suspensions history and add new
				$query = "
						UPDATE sn_playersuspend SET isHistory = 1 WHERE ID_PLAYER={$user->ID_PLAYER};
						INSERT INTO sn_playersuspend (ID_PLAYER,StartDate,EndDate,Days,Level,Reason,Public,Unlimited,isHistory) VALUES 
						({$user->ID_PLAYER},'{$StartDate}','{$EndDate}',$Days,$Level,'{$Reason}',$Public,$Unlimited,0)";
				//echo $query;exit;
				Doo::db()->query($query);

				DooUriRouter::redirect(MainHelper::site_url('admin/users/edit/'.$user->ID_PLAYER));
			}
		}
	}
	
	public function neweditsuspend() {
		$player = User::getUser();
		if($player->canAccess('Edit user information') === FALSE && $player->canAccess('Edit user info light') === FALSE) {
			DooUriRouter::redirect(MainHelper::site_url('admin'));
		}
		
		$users = new User();
		$user = $users->getById($this->params['user_id']);


		$this->updateSuspendByPost($user);


		$suspendStatus = $user->getSuspendStatus();

		$list = array();
		$list['user'] = $user;
		$list['suspendStatus'] = $suspendStatus;
		$data['title'] = $this->__('Suspension');
		$data['body_class'] = 'index_users';
		$data['selected_menu'] = 'users';
		$data['left'] =  $this->renderBlock('users/common/leftColumn');
		$data['content'] = $this->renderBlock('users/neweditsuspend', $list);
		$data['header'] = $this->getMenu();
		$this->render3Cols($data);		
	}

    public function activate() {
		//$this->moduleOff();
		
		$player = User::getUser();
		if($player->canAccess('Edit user information') === FALSE && $player->canAccess('Edit user info light') === FALSE) {
			DooUriRouter::redirect(MainHelper::site_url('admin'));
		}

        $users = new User();
		$result = $users->activate($this->params['user_id']);
        $text = 'failure';
        if($result !== FALSE) { $text = 'success'; };
        $this->toJSON($text, TRUE);
	}
	
	public function edit() {
		$player = User::getUser();
		if($player->canAccess('Edit user information') === FALSE && $player->canAccess('Edit user info light') === FALSE) {
			DooUriRouter::redirect(MainHelper::site_url('admin'));
		}
		
		$users = new User();
		$referral = new Referral();
        $list = array();
		$user = $users->getById($this->params['user_id']);
		$referrer = $referral->getFirstReferrerEntry($user->ID_PLAYER);
		if(isset($_POST) and !empty($_POST)) {
			if($player->canAccess('Edit user information') !== FALSE)
			{
				if(intval($_POST['comission']) > 0) {
					if(isset($referrer) and !empty($referrer)) {
						$referral->updateReferral($referrer->VoucherCode, $_POST['referrerName'], intval($_POST['comission']));
					} else {
						$referral->createReferral($user, $_POST['referrerName'], intval($_POST['comission']));
					}
				} 
				
				$_POST['isReferrer'] = isset($_POST['isReferrer']) ? 1 : 0;
				$_POST['canCreateReferrers'] = isset($_POST['canCreateReferrers']) ? 1 : 0;
			}
//                        echo "<pre>";
//                        print_r($_POST);
//                        echo "</pre>";
//                        RETURN FALSE;
			$user->updateProfile($_POST, false);

			MainHelper::UpdateExtrafieldsByPOST('player',$user->ID_PLAYER);
			MainHelper::UpdateCategoryByPOST('player',$user->ID_PLAYER);
	
			DooUriRouter::redirect(MainHelper::site_url('admin/users/edit/'.$user->ID_PLAYER));
		}
		
		$list['user'] = $user;
		$list['referrer'] = $referral->getFirstReferrerEntry($user->ID_PLAYER);

		//Possible extrafields for this user
		$extrafields = MainHelper::GetExtraFieldsByOwnertype('player',$user->ID_PLAYER);
		$list['extrafields'] = $extrafields;

		
		$data['title'] = $this->__('Edit User');
		$data['body_class'] = 'index_users';
		$data['selected_menu'] = 'users';
		$data['left'] =  $this->renderBlock('users/common/leftColumn');
		$data['right'] = $this->renderBlock('users/common/rightColumn',$list);
		if($player->canAccess('Edit user information') === FALSE)
			$data['content'] = $this->renderBlock('users/restrictededit', $list);
		else
			$data['content'] = $this->renderBlock('users/edit', $list);
		$data['header'] = $this->getMenu();
		$this->render3Cols($data);
	}



	public function newuser() {
		$player = User::getUser();
		if($player->canAccess('Edit user information') === FALSE && $player->canAccess('Edit user info light') === FALSE) {
			DooUriRouter::redirect(MainHelper::site_url('admin'));
		}
		
		$users = new User();
		$referral = new Referral();
        $list = array();
		$user = $users->getById($this->params['user_id']);
		$referrer = $referral->getFirstReferrerEntry($user->ID_PLAYER);
		if(isset($_POST) and !empty($_POST)) {

			//Insert new user in database
			extract($_POST);

			//Check email
			$query = "SELECT COUNT(*) as cnt FROM sn_players WHERE EMail='$email'";
			$totalNum = (object) Doo::db()->fetchRow($query);
			if ($totalNum->cnt == 0)
			{
				$GroupLimit = $player->GroupLimit = MainHelper::GetSetting('GroupLimit','ValueInt');
				$ImageLimit = $player->ImageLimit = MainHelper::GetSetting('ImageLimit','ValueInt');
				$password = md5(md5($password));	
				$query = "INSERT INTO sn_players (EMail,FirstName,LastName,NickName,DisplayName,Password,City,Address,
					Zip,Phone,Country,GroupLimit,ImageLimit) 
					VALUES 
					('$email','$firstName','$lastName','$nickname','$displayName','$password','$city',
					'$address','$zip','$phone','$country',$GroupLimit,$ImageLimit)
					";

				$rs = Doo::db()->query($query);
				DooUriRouter::redirect(MainHelper::site_url('admin/users'));
			}

			

		}
		
		$list['user'] = $user;
		$list['referrer'] = $referral->getFirstReferrerEntry($user->ID_PLAYER);
		
		$data['title'] = $this->__('Add User');
		$data['body_class'] = 'index_users';
		$data['selected_menu'] = 'users';
		$data['left'] =  '';
		$data['right'] = 'right';
		$data['content'] = $this->renderBlock('users/newuser', $list);
		$data['header'] = $this->getMenu();
		$this->render3Cols($data);
	}

    public function notapproved() {
		$users = new User();
        $list = array();
		$player = User::getUser();
		if($player->canAccess('Edit user information') === FALSE && $player->canAccess('Edit user info light') === FALSE) {
			DooUriRouter::redirect(MainHelper::site_url('admin'));
		}
		
		if (isset($_POST['actionType']) && $_POST['actionType']=='approve')
		{
			$ID_PLAYER = $_POST['ID_PLAYER'];
			MainHelper::ApproveOwner($ID_PLAYER,$player->ID_PLAYER);
		}

		$usersNotApproved = $users->GetNotApprovedUsers();
	
		$list['usersNotApproved'] = $usersNotApproved;
		$list['player'] = $player;
		
		$data['title'] = $this->__('Not approved users');
		$data['body_class'] = 'index_notapproved';
		$data['selected_menu'] = 'users';
		$data['left'] =  $this->renderBlock('users/common/leftColumn');
		$data['right'] = 'right';
		$data['content'] = $this->renderBlock('users/notapproved', $list);
		$data['header'] = $this->getMenu();
		$this->render3Cols($data);
	}

    public function selfdeactivated() {
		$users = new User();
        $list = array();
		$player = User::getUser();
		if($player->canAccess('Edit user information') === FALSE && $player->canAccess('Edit user info light') === FALSE) {
			DooUriRouter::redirect(MainHelper::site_url('admin'));
		}
		
		if (isset($_POST['actionType']) && $_POST['actionType']=='release')
		{
			$ID_PLAYER = $_POST['ID_PLAYER'];
			$users->CancelSuspend($ID_PLAYER);
		}

		$usersSelfdeactivated = $users->GetUsersBySuspendLevel(4);
		$list['usersSelfdeactivated'] = $usersSelfdeactivated;
		$list['player'] = $player;
		
		$data['title'] = $this->__('Self deactivated users');
		$data['body_class'] = 'index_selfdeactivated';
		$data['selected_menu'] = 'users';
		$data['left'] =  $this->renderBlock('users/common/leftColumn');
		$data['right'] = 'right';
		$data['content'] = $this->renderBlock('users/selfdeactivated', $list);
		$data['header'] = $this->getMenu();
		$this->render3Cols($data);
	}

    public function banned() {
		$users = new User();
        $list = array();
		$player = User::getUser();
		if($player->canAccess('Edit user information') === FALSE && $player->canAccess('Edit user info light') === FALSE) {
			DooUriRouter::redirect(MainHelper::site_url('admin'));
		}
		
		if (isset($_POST['actionType']) && $_POST['actionType']=='release')
		{
			$ID_PLAYER = $_POST['ID_PLAYER'];
			$users->CancelSuspend($ID_PLAYER);
		}

		$usersBanned = $users->GetUsersBySuspendLevel(5);
		$list['usersBanned'] = $usersBanned;
		$list['player'] = $player;
		
		$data['title'] = $this->__('Banned users');
		$data['body_class'] = 'index_banned';
		$data['selected_menu'] = 'users';
		$data['left'] =  $this->renderBlock('users/common/leftColumn');
		$data['right'] = 'right';
		$data['content'] = $this->renderBlock('users/banned', $list);
		$data['header'] = $this->getMenu();
		$this->render3Cols($data);
	}
	

    public function specialtools() {
		$users = new User();
        $list = array();
		$player = User::getUser();
		if($player->canAccess('Edit user information') === FALSE && $player->canAccess('Edit user info light') === FALSE) {
			DooUriRouter::redirect(MainHelper::site_url('admin'));
		}

		if (isset($_POST['tooltype']))
		{
			$toolType = $_POST['tooltype'];
			if ($toolType=='privacysettings')
			{
				MainHelper::InitPrivacySettingsAllPlayers();
			}
			if ($toolType=='personalinformation')
			{
				MainHelper::InitPersonalInfoAllPlayers();
			}

			DooUriRouter::redirect(MainHelper::site_url('admin/users/specialtools'));
		}


		
	
		$list['player'] = $player;
		
		$data['title'] = $this->__('Special user tools');
		$data['body_class'] = 'index_spceialtools';
		$data['selected_menu'] = 'users';
		$data['left'] =  $this->renderBlock('users/common/leftColumn');
		$data['right'] = 'right';
		$data['content'] = $this->renderBlock('users/specialtools', $list);
		$data['header'] = $this->getMenu();
		$this->render3Cols($data);
	}
	
    public function friendcat() {
		$users = new User();
        $list = array();
		$player = User::getUser();
		if($player->canAccess('Edit user information') === FALSE && $player->canAccess('Edit user info light') === FALSE) {
			DooUriRouter::redirect(MainHelper::site_url('admin'));
		}


		//Update changes
		if (isset($_POST['actiontype']))
		{
			if ($_POST['actiontype']=='rename')
			{
				foreach ($_POST as $k=>$v)
				{
					if (strpos($k,'ID_') === 0)
					{
						$ID_CAT = str_replace('ID_','',$k);
						$query = "UPDATE sn_playerfriendcat SET CategoryName='{$v}' WHERE ID_CAT={$ID_CAT}";
						Doo::db()->query($query);	
					}
				}
			}

			if ($_POST['actiontype']=='delete')
			{
				//Delete category AND relations
				$ID_CAT = $_POST['deleteID'];
				$query = "DELETE FROM sn_playerfriendcat WHERE ID_CAT={$ID_CAT};
							DELETE FROM sn_playerfriendcat_rel WHERE ID_CAT={$ID_CAT}";
				Doo::db()->query($query);	
			}

			if ($_POST['actiontype']=='new')
			{
				$CategoryName = $_POST['CategoryName'];
				//Add new native friend category AND owner relations
				$query = "
					SELECT @MAX_CAT := IF(MAX(ID_CAT) IS NULL,0,MAX(ID_CAT))+1 FROM sn_playerfriendcat;
					INSERT INTO sn_playerfriendcat
					(CategoryName,ID_PLAYER,Native,ID_CAT)
					SELECT '{$CategoryName}',ID_PLAYER,1,@MAX_CAT FROM sn_players";
				Doo::db()->query($query);	
			}
			
			DooUriRouter::redirect(MainHelper::site_url('admin/users/friendcat'));
		}


		//Create category list
		$query = "SELECT DISTINCT CategoryName,ID_CAT,Native FROM sn_playerfriendcat WHERE Native=1 ORDER BY ID_CAT";
		$friendcats = Doo::db()->query($query);	
		$list['friendcats'] = $friendcats;
		
		
		$list['player'] = $player;
		
		$data['title'] = $this->__('Friend categories');
		$data['body_class'] = 'index_friendcat';
		$data['selected_menu'] = 'users';
		$data['left'] =  $this->renderBlock('users/common/leftColumn');
		$data['right'] = 'right';
		$data['content'] = $this->renderBlock('users/friendcat', $list);
		$data['header'] = $this->getMenu();
		$this->render3Cols($data);
	}
	
}
