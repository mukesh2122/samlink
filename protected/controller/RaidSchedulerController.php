<?php
class RaidSchedulerController extends SnController {

    public function beforeRun($resource, $action) {
		parent::beforeRun($resource, $action);
		$this->addCrumb($this->__('Events'), MainHelper::site_url('events'));
		$this->data['type'] = !empty($this->params['type']) ? $this->params['type'] : 'game';
		$this->data['user'] = User::getUser();
	}

	public function moduleOff($menusel)	{
		$notAvailable = MainHelper::TrySetModuleNotAvailableByTag('raidscheduler');
		if($notAvailable) {
			$data['title'] = $this->__('RaidScheduler');
			$data['body_class'] = 'index_raidscheduler';
			$data['selected_menu'] = $menusel;
			$data['left'] = PlayerHelper::playerLeftSide();
			$data['footer'] = MainHelper::bottomMenu();
			$data['header'] = MainHelper::topMenu();
			$data['right'] = PlayerHelper::playerRightSide();
			$data['content'] = $notAvailable;
			$this->render3Cols($data);
			exit;
		};
        return TRUE;
	}

    private function sendData($data) {
        echo json_encode($data);
        return TRUE;
    }

    public function getAllComments() {
        $Player = 0;
        if(Auth::isUserLogged()) { $Player = User::getUser(); }
        else { DooUriRouter::redirect(MainHelper::site_url('login/loginfirst')); };
        $RSinstance = new RaidScheduler();
        $commentlist = $RSinstance->fetchRaidComments($Player->ID_PLAYER, 3);
        if(empty($commentlist)) { return FALSE; };
        if($this->sendData($commentlist)) { return TRUE; };
        return FALSE;
    }
    public function getPlayerComments() {
        $Player = 0;
        if(Auth::isUserLogged()) { $Player = User::getUser(); }
        else { DooUriRouter::redirect(MainHelper::site_url('login/loginfirst')); };
        if(!isset($_GET)) { return FALSE; };
        $RaidID = $_GET["RaidID"];
        if(empty($RaidID)) { return FALSE; };
        $RSinstance = new RaidScheduler();
        $commentlist = $RSinstance->fetchRaidComments($RaidID, 4);
        if(empty($commentlist)) { return FALSE; };
        if($this->sendData($commentlist)) { return TRUE; };
        return FALSE;
    }
    public function getGroupComments() {
        $Player = 0;
        if(Auth::isUserLogged()) { $Player = User::getUser(); }
        else { DooUriRouter::redirect(MainHelper::site_url('login/loginfirst')); };
        if(!isset($_GET)) { return FALSE; };
        $GroupID = $_GET["GroupID"];
        if(empty($GroupID)) { return FALSE; };
        $Group = Groups::getGroupByID($GroupID);
        if(empty($Group)) { return FALSE; };
        if(!$Group->isMember()) { return FALSE; };
        $RaidID = $_GET["RaidID"];
        if(empty($RaidID)) { return FALSE; };
        $RSinstance = new RaidScheduler();
        $commentlist = $RSinstance->fetchRaidComments($RaidID, 4);
        if(empty($commentlist)) { return FALSE; };
        if($this->sendData($commentlist)) { return TRUE; };
        return FALSE;
    }
    public function getAllRaids() {
        $Player = 0;
        if(Auth::isUserLogged()) { $Player = User::getUser(); }
        else { DooUriRouter::redirect(MainHelper::site_url('login/loginfirst')); };
        $RSinstance = new RaidScheduler();
        $raidlist = $RSinstance->fetchRaidList($Player->ID_PLAYER, 3);
        if(empty($raidlist)) { return FALSE; };
        if($this->sendData($raidlist)) { return TRUE; };
        return FALSE;
    }
    public function getPlayerRaids() {
        $Player = 0;
        if(Auth::isUserLogged()) { $Player = User::getUser(); }
        else { DooUriRouter::redirect(MainHelper::site_url('login/loginfirst')); };
        $RSinstance = new RaidScheduler();
        $raidlist = $RSinstance->fetchRaidList($Player->ID_PLAYER, 1);
        if(empty($raidlist)) { return FALSE; };
        if($this->sendData($raidlist)) { return TRUE; };
        return FALSE;
    }
    public function getGroupRaids() {
        $Player = 0;
        if(Auth::isUserLogged()) { $Player = User::getUser(); }
        else { DooUriRouter::redirect(MainHelper::site_url('login/loginfirst')); };
        if(!isset($_GET)) { return FALSE; };
        $GroupID = $_GET["GroupID"];
        if(empty($GroupID)) { return FALSE; };
        $Group = Groups::getGroupByID($GroupID);
        if(empty($Group)) { return FALSE; };
        if(!$Group->isMember()) { return FALSE; };
        $RSinstance = new RaidScheduler();
        $raidlist = $RSinstance->fetchRaidList($GroupID, 2);
        if(empty($raidlist)) { return FALSE; };
        if($this->sendData($raidlist)) { return TRUE; };
        return FALSE;
    }

    public function getAllStartData() {
        $Player = 0;
        if(Auth::isUserLogged()) { $Player = User::getUser(); }
        else { DooUriRouter::redirect(MainHelper::site_url('login/loginfirst')); };
        $RSinstance = new RaidScheduler();
        $PlayerID = $Player->ID_PLAYER;
        $ClientData["Game"] = $RSinstance->fetchGameList($PlayerID, 3);
        $ClientData["Role"] = $RSinstance->fetchGameRoles($PlayerID, 3);
        $ClientData["Server"] = $RSinstance->fetchGameServers($PlayerID, 3);
        $ClientData["Raid"] = $RSinstance->fetchRaidList($PlayerID, 3);
        $ClientData["Comment"] = $RSinstance->fetchRaidComments($PlayerID, 3);
        $ClientData["Friends"] = $RSinstance->fetchFriendlist($PlayerID, 3);
        $ClientData["Groups"] = $RSinstance->fetchGroupsList($PlayerID, 3);
        $ClientData["PlayerName"] = PlayerHelper::showName($Player);
        if($this->sendData($ClientData)) { return TRUE; };
        return FALSE;
    }
    public function getPlayerStartData() {
        $Player = 0;
        if(Auth::isUserLogged()) { $Player = User::getUser(); }
        else { DooUriRouter::redirect(MainHelper::site_url('login/loginfirst')); };
        $RSinstance = new RaidScheduler();
        $PlayerID = $Player->ID_PLAYER;
        $ClientData["Game"] = $RSinstance->fetchGameList($PlayerID, 1);
        $ClientData["Role"] = $RSinstance->fetchGameRoles($PlayerID, 1);
        $ClientData["Server"] = $RSinstance->fetchGameServers($PlayerID, 1);
        $ClientData["Raid"] = $RSinstance->fetchRaidList($PlayerID, 1);
        $ClientData["Comment"] = $RSinstance->fetchRaidComments($PlayerID, 1);
        $ClientData["Friends"] = $RSinstance->fetchFriendlist($PlayerID, 1);
        $ClientData["Groups"] = $RSinstance->fetchGroupsList($PlayerID, 1);
        $ClientData["PlayerName"] = PlayerHelper::showName($Player);
        if($this->sendData($ClientData)) { return TRUE; };
        return FALSE;
    }
    public function getGroupStartData() {
        $Player = 0;
        if(Auth::isUserLogged()) { $Player = User::getUser(); }
        else { DooUriRouter::redirect(MainHelper::site_url('login/loginfirst')); };
        if(!isset($_GET)) { return FALSE; };
        $GroupID = $_GET["GroupID"];
        if(empty($GroupID)) { return FALSE; };
        $Group = Groups::getGroupByID($GroupID);
        if(empty($Group)) { return FALSE; };
        if(!$Group->isMember()) { return FALSE; };
        $PlayerID = $Player->ID_PLAYER;
        $RSinstance = new RaidScheduler();
        $ClientData["Game"] = $RSinstance->fetchGameList($GroupID, 2);
        $ClientData["Role"] = $RSinstance->fetchGameRoles($GroupID, 2);
        $ClientData["Server"] = $RSinstance->fetchGameServers($GroupID, 2);
        $ClientData["Raid"] = $RSinstance->fetchRaidList($GroupID, 2);
        $ClientData["Comment"] = $RSinstance->fetchRaidComments($PlayerID, 2);
        $ClientData["Members"] = $RSinstance->fetchMemberlist($GroupID, 2);
        $ClientData["GroupName"] = $Group->GroupName;
        if($this->sendData($ClientData)) { return TRUE; };
        return FALSE;
    }

    private function MonCalendar() {
        $daysInMonthList = array(31,28,31,30,31,30,31,31,30,31,30,31);
        $tmpdato = getdate();
        $CalData['currentMonthName'] = $tmpdato['month'];
        $CalData['currentYear'] = $tmpdato['year'];
        $tmpdato['prevmonth'] = ($tmpdato['mon'] === 1) ? 12 : $tmpdato['mon'] - 1;
        $tmpdato['nextmonth'] = ($tmpdato['mon'] === 12) ? 1 : $tmpdato['mon'] + 1;
        $tmpdato['daysInMonth'] = (date("L", $tmpdato['year']) && $tmpdato['mon'] === 2) ? $daysInMonthList[$tmpdato['mon'] - 1] + 1 : $daysInMonthList[$tmpdato['mon'] - 1] ;
        $tmpdato['daysInPrevMonth'] = (date("L", $tmpdato['year']) && $tmpdato['prevmonth'] === 2) ? $daysInMonthList[$tmpdato['prevmonth'] - 1] + 1 : $daysInMonthList[$tmpdato['prevmonth'] - 1] ;
        $tmpdato['daysInNextMonth'] = (date("L", $tmpdato['year']) && $tmpdato['nextmonth'] === 2) ? $daysInMonthList[$tmpdato['nextmonth'] - 1] + 1 : $daysInMonthList[$tmpdato['nextmonth'] - 1] ;
        if($tmpdato['mday'] === 1) {
            $tmpdato['prevday'] = $tmpdato['daysInPrevMonth'];
            $tmpdato['nextday'] = $tmpdato['mday'] + 1;
        } else if($tmpdato['mday'] === $tmpdato['daysInMonth']) {
            $tmpdato['prevday'] = $tmpdato['mday'] - 1;
            $tmpdato['nextday'] = 1;
        } else {
            $tmpdato['prevday'] = $tmpdato['mday'] - 1;
            $tmpdato['nextday'] = $tmpdato['mday'] + 1;
        };
        $tmpcalc = mktime(12, 12, 12, $tmpdato['mon'], 0, $tmpdato['year']);
        $firstOfMonth = getdate($tmpcalc);
        $CalData['htmlcaldays'] = '';
        for($i = $tmpdato['daysInPrevMonth'] - $firstOfMonth['wday'] + 1; $i <= $tmpdato['daysInPrevMonth']; ++$i) {
            $CalData['htmlcaldays'] .= '<li id="' . ($tmpdato['year'] . "-" . sprintf("%02d", $tmpdato['prevmonth']) . "-" . sprintf("%02d", $i)) . '" class="inactive">' . $i . '</li>';
        };
        for($i = 1; $i <= $tmpdato['daysInMonth']; ++$i) {
            $CalData['htmlcaldays'] .= '<li id="' . ($tmpdato['year'] . "-" . sprintf("%02d", $tmpdato['mon']) . "-" . sprintf("%02d", $i)) . '"><span>' . $i . '</span></li>';
        };
        for($c = 1, $i = $tmpdato['daysInMonth'] + ($firstOfMonth['wday']); $i < 35; ++$i, ++$c) {
            $CalData['htmlcaldays'] .= '<li id="' . ($tmpdato['year'] . "-" . sprintf("%02d", $tmpdato['nextmonth']) . "-" . sprintf("%02d", $c)) . '" class="inactive">' . $c . '</li>';
        };
        return $CalData;
    }

    public function index_groups() {
        header("Cache-Control: no-cache, must-revalidate");

        $this->moduleOff("groups");

        $Player = 0;
        if(Auth::isUserLogged()) { $Player = User::getUser(); }
        else { DooUriRouter::redirect(MainHelper::site_url('login/loginfirst')); };

        $param = (string)$this->params['group'];
        if(empty($param)) { return FALSE; };
        $tmpgroup = new SnGroups();
        $tmpgroup->GroupName = $param;
        $mygroup = $tmpgroup->getOne();
        if(empty($mygroup)) { return FALSE; };

        $list['MonCalendar'] = $this->MonCalendar();
        $list['type'] = $this->data['type'];
        $list['title'] = $this->__('RaidScheduler');
        $list['page'] = 'raidscheduler';
        $list['group'] = $data['group'] = $mygroup;
        $list['pagetitle'] = $param . "'s";
        $list['CategoryType'] = GROUP_RAIDS;
        $list['PlayerID'] = $Player->ID_PLAYER;

		$data['selected_menu'] = $list["menu_selection"] = "groups";
        $data['title'] = $this->__('RaidScheduler');
		$data['body_class'] = 'index_raidscheduler';
		$data['header'] = MainHelper::topMenu();
        $data['left'] = MainHelper::groupsLeftSide($mygroup);
		$data['right'] = PlayerHelper::playerRightSide();
		$data['footer'] = MainHelper::bottomMenu();

        $data['content'] = $this->renderBlock('raidscheduler/index', $list);
		$this->render3Cols($data);
        return TRUE;
    }

    public function index_events() {
        header("Cache-Control: no-cache, must-revalidate");
        $this->moduleOff("events");

        $Player = 0;
        if(Auth::isUserLogged()) { $Player = User::getUser(); }
        else { DooUriRouter::redirect(MainHelper::site_url('login/loginfirst')); };

        $list['MonCalendar'] = $this->MonCalendar();
        $list['type'] = $this->data['type'];
        $list['title'] = $this->__('RaidScheduler');
        $list['page'] = 'raidscheduler';
        $list['pagetitle'] = "All " . PlayerHelper::showName($Player) . "s " . $this->__('and groups');
        $list['PlayerID'] = $Player->ID_PLAYER;

		$data['selected_menu'] = $list["menu_selection"] = "events";
        $data['title'] = $this->__('RaidScheduler');
		$data['body_class'] = 'index_raidscheduler';
		$data['header'] = MainHelper::topMenu();
        $data['left'] = PlayerHelper::playerLeftSide();
		$data['right'] = PlayerHelper::playerRightSide();
		$data['footer'] = MainHelper::bottomMenu();

        $data['content'] = $this->renderBlock('raidscheduler/index', $list);
		$this->render3Cols($data);
        return TRUE;
    }

    public function index_players() {
        header("Cache-Control: no-cache, must-revalidate");
        $this->moduleOff("players");

        $Player = 0;
        if(Auth::isUserLogged()) { $Player = User::getUser(); }
        else { DooUriRouter::redirect(MainHelper::site_url('login/loginfirst')); };

        $list["MonCalendar"] = $this->MonCalendar();
        $list["type"] = $this->data["type"];
        $list["title"] = $this->__("RaidScheduler");
        $list["page"] = "raidscheduler";
        $list["pagetitle"] = PlayerHelper::showName($Player) . "'s ";
        $list["PlayerID"] = $Player->ID_PLAYER;

		$data["selected_menu"] = $list["menu_selection"] = "players";
        $data["title"] = $this->__("RaidScheduler");
		$data["body_class"] = "index_raidscheduler";
		$data["header"] = MainHelper::topMenu();
        $data["left"] = PlayerHelper::playerLeftSide("raids");
		$data["right"] = PlayerHelper::playerRightSide();
		$data["footer"] = MainHelper::bottomMenu();

        $data["content"] = $this->renderBlock("raidscheduler/index", $list);
		$this->render3Cols($data);
        return TRUE;
    }

    public function index_signup() {
        header("Cache-Control: no-cache, must-revalidate");
        $this->moduleOff("players");

        $Player = 0;
        if(Auth::isUserLogged()) { $Player = User::getUser(); }
        else { DooUriRouter::redirect(MainHelper::site_url('login/loginfirst')); };

        $param = (int)$this->params['raid'];
        if(empty($param)) { return FALSE; };
        $RaidInst = new RaidScheduler();
        $Raid = $RaidInst->getRaidByID($param);
        if(empty($Raid)) { return FALSE; };
        $RaidVals = $RaidInst->fetchSignUpData($Raid);

        $list["RaidVals"] = $RaidVals;
        $list["type"] = $this->data["type"];
        $list["title"] = $this->__("RaidScheduler");
        $list["page"] = "raidscheduler";
        $list["PlayerID"] = $Player->ID_PLAYER;
        $list["SignUpPage"] = TRUE;

		$data["selected_menu"] = $list["menu_selection"] = "players";
        $data["title"] = $this->__("RaidScheduler");
		$data["body_class"] = "index_raidscheduler";
		$data["header"] = MainHelper::topMenu();
        $data["left"] = PlayerHelper::playerLeftSide("raids");
		$data["right"] = PlayerHelper::playerRightSide();
		$data["footer"] = MainHelper::bottomMenu();

        $data["content"] = $this->renderBlock("raidscheduler/Signup", $list);
		$this->render3Cols($data);
        return TRUE;
    }

    public function raidSignup() {
        $Player = 0;
        if(Auth::isUserLogged()) { $Player = User::getUser(); }
        else { DooUriRouter::redirect(MainHelper::site_url('login/loginfirst')); };
        if(!isset($_POST)) { return FALSE; };
        $data = $_POST;
        if(empty($data)) { return FALSE; };
        $RaidID = $this->checkInt($data["RaidID"]);
        if(empty($RaidID)) { return FALSE; };
        $RaidInst = new RaidScheduler();
        $Raid = $RaidInst->getRaidByID($RaidID);
        if(empty($Raid)) { return FALSE; };
        if(!$RaidInst->isInvited($RaidID)) { return FALSE; };
        $Status = $this->checkInt($data["Status"]);
        if(empty($Status)) { return FALSE; };
        $Char = $this->checkString($data["Char"]);
        $Role = $this->checkInt($data["Role"]);
        $Comment = $this->checkString($data["Comment"]);

//        if($Status !== "rejected") {
//            if(empty($Char)) { return FALSE; };
//            if(empty($Role)) { return FALSE; };
//            if(empty($Comment)) { return FALSE; };
//        };

        $signupData = array(
            "Character" => $Char,
            "Role"      => $Role,
            "Comment"   => $Comment,
            "Status"    => $Status,
            "RaidID"    => $RaidID,
        );
        if(!$RaidInst->setSignUpRaid($signupData)) { return FALSE; };
        return TRUE;
    }

    public function raidDecline() {
        $Player = 0;
        if(Auth::isUserLogged()) { $Player = User::getUser(); }
        else { DooUriRouter::redirect(MainHelper::site_url('login/loginfirst')); };
        if(!isset($_POST)) { return FALSE; };
        $RaidID = $this->checkInt($_POST["RaidID"]);
        if(empty($RaidID)) { return FALSE; };
        $RaidInst = new RaidScheduler();
        $Raid = $RaidInst->getRaidByID($RaidID);
        if(empty($Raid)) { return FALSE; };
        if(!$RaidInst->isInvited($RaidID)) { return FALSE; };
        if(!$RaidInst->SetDeclineRaid($RaidID)) { return FALSE; };
        return TRUE;
    }

    private function checkInt($tmpInt) { if((isset($tmpInt)) && (ctype_digit($tmpInt))) { return (int)$tmpInt; } else { return NULL; }; }
    private function checkString($tmpStr) { if((isset($tmpStr)) && (is_string($tmpStr)) ) { return (string)$tmpStr; } else { return NULL; }; }
    private function checkArray($tmpArr) { if((isset($tmpArr)) && (is_array($tmpArr)) ) { return (array)$tmpArr; } else { return NULL; }; }
    public function createGroupRaid() {
        if(!Auth::isUserLogged()) { DooUriRouter::redirect(MainHelper::site_url('login/loginfirst')); };
        if(!isset($_POST)) { return FALSE; };
        $data = $_POST;
        $GroupID = $this->checkInt($data["GroupID"]);
        $tmpGroup = Groups::getGroupByID($GroupID);
        if(empty($tmpGroup)) { return FALSE; };
        if(!$tmpGroup->isMember()) { return FALSE; };
        if(!(($tmpGroup->isCreator()) || ($tmpGroup->isAdmin()) || ($tmpGroup->isOfficer()))) { return FALSE; };
        switch($this->checkInt($data["InviteType"])) {
            case 1:
                $invitetype = "open";
                break;
            case 2:
                $invitetype = "members";
                break;
            case 3:
                $invitetype = "groups";
                break;
            case 4:
                $invitetype = "friends";
                break;
            case 5:
                $invitetype = "mixed";
                break;
            default:
        };
        $raiddata = array(
            "OwnerType"       => 2,
            "FK_OWNER"        => $GroupID,
            "StartTime"       => $this->checkInt($data["StartTime"]),
            "EndTime"         => $this->checkInt($data["EndTime"]),
            "Recurring"       => $this->checkInt($data["Recurring"]),
            "FK_GAME"         => $this->checkInt($data["Game"]),
            "FK_SERVER"       => $this->checkInt($data["Server"]),
            "Location"        => $this->checkString($data["Location"]),
            "Size"            => $this->checkInt($data["Size"]),
            "RaidDesc"        => $this->checkString($data["RaidDesc"]),
            "InviteType"      => $invitetype,
            "Finalized"       => $this->checkInt($data["Finalized"]),
            "RemindInterval"  => $this->checkInt($data["RemindInterval"]),
        );
        $roledata = $this->checkArray($data["RoleList"]);
        $invitelist = $this->checkArray($data["Invitees"]);
        $RSinstance = new RaidScheduler();
        if($RSinstance->CreateNewRaid($raiddata, $roledata, $invitelist)) { return TRUE; };
        return FALSE;
    }

    public function createPlayerRaid() {
        $Player = 0;
        if(Auth::isUserLogged()) { $Player = User::getUser(); }
        else { DooUriRouter::redirect(MainHelper::site_url('login/loginfirst')); };
        if(!isset($_POST)) { return FALSE; };
        $data = $_POST;
        switch($this->checkInt($data["InviteType"])) {
            case 1:
                $invitetype = "open";
                break;
            case 2:
                $invitetype = "members";
                break;
            case 3:
                $invitetype = "groups";
                break;
            case 4:
                $invitetype = "friends";
                break;
            case 5:
                $invitetype = "mixed";
                break;
            default:
        };
        $raiddata = array(
            "OwnerType"       => 1,
            "FK_OWNER"        => $Player->ID_PLAYER,
            "StartTime"       => $this->checkInt($data["StartTime"]),
            "EndTime"         => $this->checkInt($data["EndTime"]),
            "Recurring"       => $this->checkInt($data["Recurring"]),
            "FK_GAME"         => $this->checkInt($data["Game"]),
            "FK_SERVER"       => $this->checkInt($data["Server"]),
            "Location"        => $this->checkString($data["Location"]),
            "Size"            => $this->checkInt($data["Size"]),
            "RaidDesc"        => $this->checkString($data["RaidDesc"]),
            "InviteType"      => $invitetype,
            "Finalized"       => $this->checkInt($data["Finalized"]),
            "RemindInterval" => $this->checkInt($data["RemindInterval"]),
        );
        $roledata = $this->checkArray($data["RoleList"]);
        $invitelist = ($invitetype === "open") ? "" : $this->checkArray($data["Invitees"]);
        $RSinstance = new RaidScheduler();
        if($RSinstance->CreateNewRaid($raiddata, $roledata, $invitelist)) { return TRUE; };
        return FALSE;
    }

    public function createComment() {
        $Player = 0;
        if(Auth::isUserLogged()) { $Player = User::getUser(); }
        else { DooUriRouter::redirect(MainHelper::site_url('login/loginfirst')); };
        if(!isset($_POST)) { return FALSE; };
        $data = $_POST;
        $RSinstance = new RaidScheduler();
        $RaidID = $this->checkInt($data["RaidID"]);
        if(empty($RaidID)) { return FALSE; };
        $tmpRaid = RaidScheduler::getRaidByID($RaidID);
        if(empty($tmpRaid)) { return FALSE; };
        $GroupID = $this->checkInt($data["GroupID"]);
        if(empty($GroupID)) {
            $Owner = $Player->ID_PLAYER;
            $OwnerType = 1;
        } else {
            $tmpGroup = Groups::getGroupByID($GroupID);
            if(empty($tmpGroup)) { return FALSE; }
            else if(!$tmpGroup->isMember()) { return FALSE; };
            if(($tmpRaid->OwnerType === "group") && ($tmpRaid->FK_OWNER === $tmpGroup->ID_GROUP) && ($tmpGroup->isAdmin() || $tmpGroup->isCreator() || $tmpGroup->isOfficer())) {
                $Owner = $tmpGroup->ID_GROUP;
                $OwnerType = 2;
            } else {
                $Owner = $Player->ID_PLAYER;
                $OwnerType = 1;
            };
        };
        $commentdata = array(
            "FK_OWNER"  => $Owner,
            "OwnerType" => $OwnerType,
            "Comment"   => $this->checkString($data["Comment"]),
            "TimeStamp" => 0,
        );
        if($RSinstance->CreateNewComment($commentdata, $RaidID)) { return TRUE; };
        return FALSE;
    }

    public function deleteRaid() {
        $Player = 0;
        if(Auth::isUserLogged()) { $Player = User::getUser(); }
        else { DooUriRouter::redirect(MainHelper::site_url('login/loginfirst')); };
        if(!isset($_POST)) { return FALSE; };
        $data = $_POST;
        $RaidID = $this->checkInt($data["RaidID"]);
        if(empty($RaidID)) { return FALSE; };
        $RSinstance = new RaidScheduler();
        if(!$RSinstance->getRaidByID($RaidID)) { return FALSE; };
        $GroupID = $this->checkInt($data["GroupID"]);
        if(empty($GroupID)) {
            if(!$RSinstance->isOwner($RaidID)) { return FALSE; };
        } else {
            $tmpGroup = Groups::getGroupByID($GroupID);
            if(empty($tmpGroup)) { return FALSE; };
            if(!$tmpGroup->isMember()) { return FALSE; };
            if(!($tmpGroup->isCreator() || $tmpGroup->isAdmin() || $tmpGroup->isOfficer())) { return FALSE; };
        };
        if($RSinstance->DeleteRaid($RaidID)) { return TRUE; };
        return FALSE;
    }
};
?>