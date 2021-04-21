<?php
Class RaidScheduler {

    public function fetchGameList($tmpID = 0, $tmpIDType = 0) {
        $MyID = $tmpID;
        $IDtype = $tmpIDType;
        if(empty($MyID) || empty($IDtype)) { return FALSE; };
        switch($IDtype) {
            case 3:
            case 1:
                $Query = "SELECT sn_games.ID_GAME, sn_games.GameName, sn_games.ImageURL
                          FROM sn_games
                          INNER JOIN sn_playergame_rel
                          ON sn_playergame_rel.ID_GAME = sn_games.ID_GAME
                          WHERE sn_playergame_rel.ID_PLAYER = {$MyID}
                          AND sn_playergame_rel.isPlaying = 1
                          ORDER BY GameName ASC";
                break;
            case 2:
                $Query = "SELECT sn_games.ID_GAME, sn_games.GameName, sn_games.ImageURL
                          FROM sn_games
                          INNER JOIN sn_groups
                          ON sn_groups.ID_GAME = sn_games.ID_GAME
                          WHERE sn_groups.ID_GROUP = {$MyID}
                          ORDER BY sn_games.GameName ASC";
                break;
//            case 3:
                // get both player and group
//                break;
            default:
                return FALSE;
        };
        $Result = Doo::db()->query($Query);
        if(empty($Result)) { return NULL; };
        $iEnd = $Result->rowCount();
        $GameList = $Result->fetchAll();
        if(empty($GameList)) { return FALSE; };
        $HtmlGamelist = array("Html" => "", "Image" => [], "ID" => []);
        for($i = 0; $i < $iEnd; ++$i) {
            $CurNum = $GameList[$i];
            $GameID = $CurNum["ID_GAME"];
            $GameModel = new SnGames();
            $GameModel->ID_GAME = $GameID;
            $GameModel->ImageURL = $CurNum["ImageURL"];
            $Img = MainHelper::showImage($GameModel, THUMB_LIST_40x40, FALSE, array('both', 'no_img' => 'noimage/no_game_40x40.png'));
            $HtmlGamelist["Html"] .= '<option value="' . $GameID . '">' . $CurNum["GameName"] . '</option>';
            $HtmlGamelist["Image"][$i] = $Img;
            $HtmlGamelist["ID"][$i] = $GameID;
        };
        return $HtmlGamelist;

//        $Games = new SnGames();
//        $GameTable = $Games->_table;
//        $GameRel = ($IDtype === 1) ? new SnPlayerGameRel() : new SnGroups();
//        $GameRelTable = $GameRel->_table;
//        $Params["select"] = "{$GameTable}.ID_GAME, {$GameTable}.GameName, {$GameTable}.ImageURL";
//        $Params["joinType"] = "INNER";
//        $Params["where"] = ($IDtype === 1) ? "{$GameRelTable}.ID_PLAYER = ? AND {$GameRelTable}.isPlaying = 1" : "{$GameRelTable}.ID_GROUP = ?";
//        $Params["param"] = array($MyID);
//        $Params["match"] = true;
//        $Params["asArray"] = true;
//        $Params["asc"] = "{$GameTable}.GameName";
//        $Result = $Games->relate($GameRel, $Params);
//        if(!$Result) { return FALSE; };
//        return $Result;
    }

    public function fetchGameRoles($tmpID = 0, $tmpIDType = 0) {
        $MyID = $tmpID;
        $IDtype = $tmpIDType;
        if(empty($MyID) || empty($IDtype)) { return FALSE; };
        switch($IDtype) {
            case 3:
            case 1:
                $Query = "SELECT rs_gamerole_rel.FK_GAME, rs_roles.RoleName, rs_roles.ID_ROLE
                          FROM rs_roles
                          INNER JOIN rs_gamerole_rel
                          ON rs_gamerole_rel.FK_ROLE = rs_roles.ID_ROLE
                          INNER JOIN sn_playergame_rel
                          ON sn_playergame_rel.ID_GAME = rs_gamerole_rel.FK_GAME
                          WHERE sn_playergame_rel.ID_PLAYER = {$MyID}";
                break;
            case 2:
                $Query = "SELECT rs_gamerole_rel.FK_GAME, rs_roles.RoleName, rs_roles.ID_ROLE
                          FROM rs_roles
                          INNER JOIN rs_gamerole_rel
                          ON rs_gamerole_rel.FK_ROLE = rs_roles.ID_ROLE
                          INNER JOIN sn_groups
                          ON sn_groups.ID_GAME = rs_gamerole_rel.FK_GAME
                          WHERE sn_groups.ID_GROUP = {$MyID}";
                break;
//            case 3:
                // get both player and group
//                break;
            default:
                return FALSE;
        };
        $Result = Doo::db()->query($Query);
        if(empty($Result)) { return NULL; };
        $iEnd = $Result->rowCount();
        $tmpRoleList = $Result->fetchAll();
        if(empty($tmpRoleList)) { return FALSE; };
        $RoleList = array();
        for($i = 0; $i < $iEnd; ++$i) {
            $CurNum = $tmpRoleList[$i];
            $RoleList[$i] = array(
                "FK_GAME"   => $CurNum["FK_GAME"],
                "RoleName"  => SnController::__($CurNum["RoleName"]),
                "ID_ROLE"   => $CurNum["ID_ROLE"],
            );
        };
        return $RoleList;
    }

    public function fetchGameServers($tmpID = 0, $tmpIDType = 0) {
        $MyID = $tmpID;
        $IDtype = $tmpIDType;
        if(empty($MyID) || empty($IDtype)) { return FALSE; };
        switch($IDtype) {
            case 3:
            case 1:
                $Query = "SELECT rs_gameserver_rel.FK_GAME, rs_gameserver_rel.FK_SERVER, rs_servers.ServerName
                          FROM rs_servers
                          INNER JOIN rs_gameserver_rel
                          ON rs_gameserver_rel.FK_SERVER = rs_servers.ID_SERVER
                          INNER JOIN sn_playergame_rel
                          ON sn_playergame_rel.ID_GAME = rs_gameserver_rel.FK_GAME
                          WHERE sn_playergame_rel.ID_PLAYER = {$MyID}
                          ORDER BY rs_servers.ServerName ASC";
                break;
            case 2:
                $Query = "SELECT rs_gameserver_rel.FK_GAME, rs_gameserver_rel.FK_SERVER, rs_servers.ServerName
                          FROM rs_servers
                          INNER JOIN rs_gameserver_rel
                          ON rs_gameserver_rel.FK_SERVER = rs_servers.ID_SERVER
                          INNER JOIN sn_groups
                          ON sn_groups.ID_GAME = rs_gameserver_rel.FK_GAME
                          WHERE sn_groups.ID_GROUP = {$MyID}
                          ORDER BY rs_servers.ServerName ASC";
                break;
//            case 3:
                // get both player and group
//                break;
            default:
                return FALSE;
        };
        $Result = Doo::db()->query($Query);
        if(empty($Result)) { return NULL; };
        $iEnd = $Result->rowCount();
        $ServerList = $Result->fetchAll();
        if(empty($ServerList)) { return FALSE; };
        $HtmlServerList = array();
        for($i = 0; $i < $iEnd; ++$i) {
            $CurNum = $ServerList[$i];
            $HtmlServerList[$i] = array(
                "GameID"    => $CurNum["FK_GAME"],
                "HtmlCode"  => '<option value="' . $CurNum["FK_SERVER"] . '">' . $CurNum["ServerName"] . '</option>',
            );
        };
        return $HtmlServerList;
    }

    public function fetchRaidComments($tmpID = 0, $tmpIDType = 0) {
        $MyID = $tmpID;
        $IDtype = $tmpIDType;
        if(empty($MyID) || empty($IDtype)) { return FALSE; };
        $Player = User::getUser();
        $PlayerID = $Player->ID_PLAYER;
        switch($IDtype) {
            case 1: // player
            case 2: // group
            case 3: // get both player and group
                $tmpQuery = "SELECT DISTINCT rs_comments.ID_COMMENT,rs_comments.FK_OWNER,rs_comments.OwnerType,rs_comments.Comment,rs_comments.TimeStamp,rs_raids.ID_RAID
                             FROM rs_comments
                             INNER JOIN rs_raidcomment_rel
                             ON rs_raidcomment_rel.FK_COMMENT = rs_comments.ID_COMMENT
                             INNER JOIN rs_raids
                             ON rs_raids.ID_RAID = rs_raidcomment_rel.FK_RAID
                             INNER JOIN sn_playergroup_rel
                             ON sn_playergroup_rel.ID_PLAYER = {$PlayerID}
                             WHERE rs_comments.FK_OWNER = {$PlayerID}
                             OR rs_raids.FK_OWNER = {$PlayerID}
                             OR sn_playergroup_rel.ID_GROUP = rs_raids.FK_OWNER
                             OR rs_raids.InviteType = 1
                             ORDER BY rs_comments.TimeStamp ASC";
                break;
            case 4: // get by raid id
                $tmpQuery = "SELECT DISTINCT rs_comments.ID_COMMENT,rs_comments.FK_OWNER,rs_comments.OwnerType,rs_comments.Comment,rs_comments.TimeStamp,rs_raids.ID_RAID
                             FROM rs_comments
                             INNER JOIN rs_raidcomment_rel
                             ON rs_raidcomment_rel.FK_COMMENT = rs_comments.ID_COMMENT
                             INNER JOIN rs_raids
                             ON rs_raids.ID_RAID = rs_raidcomment_rel.FK_RAID
                             WHERE rs_raids.ID_RAID = {$MyID}
                             OR rs_comments.FK_OWNER = {$PlayerID}
                             OR rs_raids.FK_OWNER = {$PlayerID}
                             ORDER BY rs_comments.TimeStamp ASC";
                break;
            default:
                return FALSE;
        };
        $Query = Doo::db()->query($tmpQuery);
        if(empty($Query)) { return NULL; };
        $iEnd = $Query->rowCount();
        $Result = $Query->fetchAll();
        $CommentList = array();
        for($i = 0; $i < $iEnd; ++$i) {
            $CurNum = $Result[$i];
            $OwnerType = $CurNum["OwnerType"];
            if($OwnerType === "player") {
                $Creator = User::getById($CurNum["FK_OWNER"]);
                $Owner = PlayerHelper::showName($Creator);
                $OwnerUrl = MainHelper::site_url('player/' . $Creator->URL);
            } else if($OwnerType === "group") {
                $Creator = Groups::getGroupByID($CurNum["FK_OWNER"]);
                $Owner = $Creator->GroupName;
                $OwnerUrl = $Creator->GROUP_URL;
            };
            $CommentList[$i] = array(
                "CommentID" => $CurNum["ID_COMMENT"],
                "Comment"   => $CurNum["Comment"],
                "RaidID"    => "RaidID" . $CurNum["ID_RAID"],
                "Sender"    => $Owner,
                "SenderUrl" => $OwnerUrl,
                "TimeStamp" => getdate(MainHelper::calculateTime($CurNum["TimeStamp"], "U")),
            );
        };
        return $CommentList;
    }

//    public function fetchRaidRoles($PlayerID = 0, $PlayerType = 0) {
//        if(($PlayerID === 0) || ($PlayerType === 0)) { return FALSE; };
//        $MyID = $PlayerID;
//        $IDtype = $PlayerType;
//        $Query = Doo::db()->query("SELECT FK_ROLE,RoleCount,Remaining,rs_raids.ID_RAID,rs_roles.RoleName
//                                   FROM rs_raidrole_rel
//                                   INNER JOIN rs_roles
//                                   ON rs_roles.ID_ROLE = rs_raidrole_rel.FK_ROLE
//                                   INNER JOIN rs_raids
//                                   ON rs_raidrole_rel.FK_RAID = rs_raids.ID_RAID
//                                   WHERE rs_raids.FK_OWNER = {$MyID}");
//        if(!$Query) { return FALSE; };
//        $iEnd = $Query->rowCount();
//        $Result = $Query->fetchAll();
//        $GameRoleList = [];
//        for($i = 0; $i < $iEnd; ++$i) {
//            $CurNum = $Result[$i];
//            
//        };
//    }

    public function fetchFriendlist($tmpID = 0, $tmpIDType = 0) {
        $MyID = $tmpID;
        $IDtype = $tmpIDType;
        if(empty($MyID) || empty($IDtype)) { return FALSE; };
        $MyPlayer = User::getById($MyID);
        $tmpFriendList = $MyPlayer->getFriendsList("", FALSE, 0, 0, 0);
        $ListCount = count($tmpFriendList);
        if(empty($ListCount)) { return NULL; };
        $FriendList = array();
        $i = 0;
        foreach($tmpFriendList as $tmpkey) {
            $FriendList[$i] = array(
                "NickName"  => PlayerHelper::showName((object)$tmpkey),
                "IDnum"     => $tmpkey["ID_PLAYER"],
                "Name"      => $tmpkey["FirstName"] . " " . $tmpkey["LastName"],
                "Url"       => MainHelper::site_url('player/' . $tmpkey["URL"]),
                "Picture"   => MainHelper::showImage($tmpkey, THUMB_LIST_60x60, FALSE, array('both', 'no_img' => 'noimage/no_player_60x60.png')),
            );
            ++$i;
        };
        return $FriendList;
    }

    public function fetchGroupsList($tmpID = 0, $tmpIDType = 0) {
        $MyID = $tmpID;
        $IDtype = $tmpIDType;
        if(empty($MyID) || empty($IDtype)) { return FALSE; };
        $tmpGroup = new Groups();
        $MyPlayer = User::getById($MyID);
        $PlayerGroups = $tmpGroup->getPlayerGroups($MyPlayer, 50);
        $GroupCount = count($PlayerGroups);
        $GroupList = array();
        for($i = 0; $i < $GroupCount; ++$i) {
            $CurGroup = $PlayerGroups[$i];
            $MemberAmount = $CurGroup->MemberCount;
            $GroupList[$i] = array(
                "Name"          => $CurGroup->GroupName,
                "IDnum"         => $CurGroup->ID_GROUP,
                "Description"   => $CurGroup->GroupDesc,
                "GameName"      => $CurGroup->GameName,
                "GameID"        => $CurGroup->ID_GAME,
                "Server"        => $CurGroup->Server,
                "Faction"       => $CurGroup->Faction,
                "OwnerName"     => PlayerHelper::showName($CurGroup->getLeader()),
                "OwnerID"       => $CurGroup->ID_CREATOR,
                "Picture"       => MainHelper::showImage($CurGroup, THUMB_LIST_60x60, FALSE, array('both', 'no_img' => 'noimage/no_group_60x60.png')),
                "MemberCount"   => $MemberAmount,
            );
            $tmpMemberList = $CurGroup->getMembers();
            for($c = 0; $c < $MemberAmount; ++$c) {
                $CurMember = $tmpMemberList[$c];
                $GroupList[$i]["Members"][$c] = array(
                    "NickName"  => PlayerHelper::showName($CurMember),
                    "IDnum"     => $CurMember->ID_PLAYER,
                    "Name"      => $CurMember->FirstName . " " . $CurMember->LastName,
                    "Url"       => MainHelper::site_url('player/' . $CurMember->URL),
                    "Picture"   => MainHelper::showImage($CurMember, THUMB_LIST_60x60, FALSE, array('both', 'no_img' => 'noimage/no_player_60x60.png')),
                );
            };
        };
        return $GroupList;
    }

    public function fetchMemberlist($tmpID = 0, $tmpIDType = 0) {
        $MyID = $tmpID;
        $IDtype = $tmpIDType;
        if(empty($MyID) || empty($IDtype)) { return FALSE; };
        $MyGroup = Groups::getGroupByID($MyID);
        $tmpMemberList = $MyGroup->getMembers();
        $ListCount = count($tmpMemberList);
        if(empty($ListCount)) { return NULL; };
        $MemberList = array();
        for($i = 0; $i < $ListCount; ++$i) {
            $CurMember = $tmpMemberList[$i];
            $MemberList[$i] = array(
                "NickName"  => PlayerHelper::showName($CurMember),
                "IDnum"     => $CurMember->ID_PLAYER,
                "Name"      => $CurMember->FirstName . " " . $CurMember->LastName,
                "Url"       => MainHelper::site_url('player/' . $CurMember->URL),
                "Picture"   => MainHelper::showImage($CurMember, THUMB_LIST_60x60, FALSE, array('both', 'no_img' => 'noimage/no_player_60x60.png')),
            );
        };
        return $MemberList;
    }

    public function fetchRaidList($tmpID = 0, $tmpIDType = 0) {
        $MyID = $tmpID;
        $IDtype = $tmpIDType;
        if(empty($MyID) || empty($IDtype)) { return FALSE; };
        switch($IDtype) {
            case 1: // player
                break;
            case 2: // specific group
                break;
            case 3: // all
                break;
            default:
        };

        $Query = Doo::db()->query("SELECT rs_raids.ID_RAID,rs_raids.OwnerType,rs_raids.FK_OWNER,rs_raids.StartTime,rs_raids.EndTime,rs_raids.Recurring,rs_raids.FK_GAME,rs_raids.FK_SERVER,rs_raids.Location,rs_raids.Size,rs_raids.RaidDesc,rs_raids.InviteType,rs_raids.Finalized,rs_raids.RemindInterval,sn_games.GameName,rs_servers.ServerName,rs_invitedplayer_rel.FK_PLAYER,rs_invitedplayer_rel.InviteStatus,rs_raidrole_rel.FK_ROLE,rs_raidrole_rel.RoleCount,rs_raidrole_rel.Remaining,rs_raidplayerrole_rel.RolePlayerRel,rs_raidplayerrole_rel.PlayerRoleRel,rs_raidplayerrole_rel.CharName
                                   FROM rs_raids
                                   LEFT JOIN sn_games
                                   ON sn_games.ID_GAME = rs_raids.FK_GAME
                                   LEFT JOIN rs_servers
                                   ON rs_servers.ID_SERVER = rs_raids.FK_SERVER
                                   LEFT JOIN
                                   (SELECT rs_raidrole_rel.FK_RAID,GROUP_CONCAT(rs_raidrole_rel.FK_ROLE) AS FK_ROLE,GROUP_CONCAT(rs_raidrole_rel.RoleCount) AS RoleCount,GROUP_CONCAT(rs_raidrole_rel.Remaining) AS Remaining FROM rs_raidrole_rel GROUP BY rs_raidrole_rel.FK_RAID)
                                   AS rs_raidrole_rel
                                   ON rs_raidrole_rel.FK_RAID = rs_raids.ID_RAID
                                   LEFT JOIN
                                   (SELECT rs_invitedplayer_rel.FK_RAID,GROUP_CONCAT(rs_invitedplayer_rel.InviteStatus) AS InviteStatus,GROUP_CONCAT(rs_invitedplayer_rel.FK_PLAYER) AS FK_PLAYER FROM rs_invitedplayer_rel GROUP BY rs_invitedplayer_rel.FK_RAID)
                                   AS rs_invitedplayer_rel
                                   ON rs_raids.ID_RAID = rs_invitedplayer_rel.FK_RAID
                                   LEFT JOIN
                                   (SELECT rs_raidplayerrole_rel.FK_RAID,GROUP_CONCAT(rs_raidplayerrole_rel.FK_PLAYER) AS PlayerRoleRel,GROUP_CONCAT(rs_raidplayerrole_rel.FK_ROLE) AS RolePlayerRel,GROUP_CONCAT(rs_raidplayerrole_rel.CharName) AS CharName FROM rs_raidplayerrole_rel GROUP BY rs_raidplayerrole_rel.FK_RAID)
                                   AS rs_raidplayerrole_rel
                                   ON rs_raids.ID_RAID = rs_raidplayerrole_rel.FK_RAID
                                   WHERE rs_raids.InviteType = 1
                                   OR rs_raids.FK_OWNER = {$MyID}
                                   OR rs_invitedplayer_rel.FK_PLAYER = {$MyID}
                                   GROUP BY rs_raids.ID_RAID
                                   ORDER BY rs_raids.StartTime ASC");
        if(empty($Query)) { return NULL; };
        $iEnd = $Query->rowCount();
        $Result = $Query->fetchAll();
        $RaidList = array();
        $i = 0;
        for(; $i < $iEnd; ++$i) {
            $CurNumber = $Result[$i];
            $Start = getdate(MainHelper::calculateTime($CurNumber["StartTime"], "U"));
            $StartHour = sprintf("%02d", $Start["hours"]) . ":" . sprintf("%02d", $Start["minutes"]);
            $EndHour = MainHelper::calculateTime($CurNumber["EndTime"], "H:i");
            $RaidID = "RaidID" . $CurNumber["ID_RAID"];
            $Game = $CurNumber["GameName"];
            $OwnerType = $CurNumber["OwnerType"];
            $OwnerID = $CurNumber["FK_OWNER"];
            $HtmlWeekCal = '<div class="RSweekEvent" id="' . $RaidID . '" data-listnum=' . $i . '><h6>' . $StartHour . ' - ' . $EndHour . '</h6><p>' . $Game . '</p></div>';
            if($OwnerType === "player") {
                if($MyID === $OwnerID) { $HtmlWeekCal = '<div class="RSweekEvent" id="' . $RaidID . '" data-listnum=' . $i . '><span class="RSweekEventConfig"></span><h6>' . $StartHour . ' - ' . $EndHour . '</h6><p>' . $Game . '</p></div>'; }
                $Creator = User::getById($OwnerID);
                $Owner = PlayerHelper::showName($Creator);
                $OwnerUrl = MainHelper::site_url('player/' . $Creator->URL);
            } else if($OwnerType === "group") {
                $Creator = Groups::getGroupByID($OwnerID);
                $Owner = $Creator->GroupName;
                $OwnerUrl = $Creator->GROUP_URL;
                if($Creator->isAdmin() || $Creator->isCreator() || $Creator->isOfficer()) { $HtmlWeekCal = '<div class="RSweekEvent" id="' . $RaidID . '" data-listnum=' . $i . '><span class="RSweekEventConfig"></span><h6>' . $StartHour . ' - ' . $EndHour . '</h6><p>' . $Game . '</p></div>'; }
            };
            $Roles = array();
            if(isset($CurNumber["FK_ROLE"])) {
                $FK_ROLE = explode(",", $CurNumber["FK_ROLE"]);
                $RoleCount = explode(",", $CurNumber["RoleCount"]);
                $Remaining = explode(",", $CurNumber["Remaining"]);
                $cEnd = count($FK_ROLE);
                for($c = 0; $c < $cEnd; ++$c) {
                    $Roles[$c] = array(
                        "FK_ROLE"   => $FK_ROLE[$c],
                        "RoleCount" => $RoleCount[$c],
                        "Remaining" => $Remaining[$c],
                    );
                };
            };

            $Invited = array();
            if(isset($CurNumber["FK_PLAYER"])) {
                $tmpInvites = explode(",", $CurNumber["FK_PLAYER"]);
                $tmpStatus = explode(",", $CurNumber["InviteStatus"]);
                $tmpCharName = explode(",", $CurNumber["CharName"]);
                $tmpRole = explode(",", $CurNumber["RolePlayerRel"]);
                $xEnd = count($tmpInvites);
                for($x = 0; $x < $xEnd; ++$x) {
                    $CurNum = $tmpInvites[$x];
                    $CurInv = User::getById($CurNum);
                    $Invited[$x] = array(
                        "IDnum"     => $CurInv->ID_PLAYER,
                        "Name"      => $CurInv->FirstName . " " . $CurInv->LastName,
                        "NickName"  => PlayerHelper::showName($CurInv),
                        "Status"    => $tmpStatus[$x],
                        "Url"       => MainHelper::site_url('player/' . $CurInv->URL),
                        "Picture"   => MainHelper::showImage($CurInv, THUMB_LIST_60x60, FALSE, array('both', 'no_img' => 'noimage/no_player_60x60.png')),
                        "CharName"  => (isset($tmpCharName[$x])) ? $tmpCharName[$x] : "",
                        "Role"      => (isset($tmpRole[$x])) ? $tmpRole[$x] : "",
                    );
                };
            };

            $RaidList[$i] = array(
                "Owner"             => $Owner,
                "OwnerID"           => $OwnerID,
                "OwnerUrl"          => $OwnerUrl,
                "RaidID"            => $RaidID,
                "HtmlMonID"         => $Start["year"] . "-" . sprintf("%02d", $Start["mon"]) . "-" . sprintf("%02d", $Start["mday"]),
                "HtmlMonCal"        => '<div class="RSmonEvent" id="' . $RaidID . '" data-listnum=' . $i . '>' . $StartHour . "</div>",
                "HtmlWeek"          => date("W"),
                "HtmlWeekID"        => $Start["wday"] . "-" . date("W", $Start[0]),
                "HtmlWeekCal"       => $HtmlWeekCal,
                "GameName"          => $Game,
                "Size"              => $CurNumber["Size"],
                "Location"          => $CurNumber["Location"],
                "Server"            => $CurNumber["ServerName"],
                "StartDate"         => $Start["month"] . " " . $Start["mday"] . ", " . $Start["year"],
                "StartTime"         => $StartHour,
                "EndTime"           => $EndHour,
                "Description"       => $CurNumber["RaidDesc"],
                "Roles"             => $Roles,
                "InviteType"        => $CurNumber["InviteType"],
                "Invited"           => $Invited,
            );
        };
        $RaidList["TotalCount"] = $i;
        return $RaidList;
    }

    public function fetchSignUpData($tmpRaid) {
        $Raid = $tmpRaid;
        $Game = Games::getGameByID($Raid->FK_GAME);
        $Dato = getdate(MainHelper::calculateTime($Raid->StartTime, "U"));
        $OwnerType = $Raid->OwnerType;
        $OwnerID = $Raid->FK_OWNER;
        if($OwnerType === "player") {
            $Creator = User::getById($OwnerID);
            $Owner = PlayerHelper::showName($Creator);
            $OwnerUrl = MainHelper::site_url('player/' . $Creator->URL);
        } else if($OwnerType === "group") {
            $Creator = Groups::getGroupByID($OwnerID);
            $Owner = $Creator->GroupName;
            $OwnerUrl = $Creator->GROUP_URL;
        };
        $RaidID = $Raid->ID_RAID;
        $tmpRoles = $this->getRaidRoleByID($RaidID);
        $Roles = "";
        foreach($tmpRoles as $tmpKey) {
            $Roles .= '<option value="' . $tmpKey["FK_ROLE"] . '">' . $tmpKey["RoleName"] . '       (' . $tmpKey["Remaining"] . ')' . '</option>';
        };
        $Values = array(
            "GameName"  => $Game->GameName,
            "Location"  => $Raid->Location,
            "Size"      => $Raid->Size,
            "GameImg"   => MainHelper::showImage($Game, THUMB_LIST_110x110, FALSE, ['both', 'no_img' => 'noimage/no_game_100x100.png']),
            "Date"      => $Dato["month"] . " " . $Dato["mday"] . ", " . $Dato["year"],
            "StartTime" => sprintf("%02d", $Dato["hours"]) . ":" . sprintf("%02d", $Dato["minutes"]),
            "EndTime"   => MainHelper::calculateTime($Raid->EndTime, "H:i"),
            "Owner"     => '<a href="' . $OwnerUrl . '">' . $Owner . '</a>',
            "Desc"      => $Raid->RaidDesc,
            "Roles"     => $Roles,
            "Status"    => $this->getInviteStatus($RaidID),
        );
        return $Values;
    }

    public function CreateNewRaid($RaidData, $RoleData, $InviteList) {
        $RaidInst = new RsRaids();
        $TmpRaidData = $RaidData;
        $TmpRoleData = $RoleData;
        $TmpInviteList = $InviteList;
        $RaidID = $RaidInst->insertAttributes($TmpRaidData);
        if(empty($RaidID)) { return FALSE; };
        $iEnd = count($TmpRoleData);
        for($i = 0; $i < $iEnd; ++$i) {
            $CurRol = $TmpRoleData[$i];
            $RoleModel = new RsRaidRoleRel();
//            $Attrs = [
//                "FK_RAID"   => $RaidID,
//                "FK_ROLE"   => $CurRol["RoleID"],
//                "Remaining" => $CurRol["Amount"],
//                "RoleCount" => $CurRol["Amount"],
//            ];
//            if(!$RoleModel->insertAttributes($Attrs)) { return FALSE; };
            $RoleModel->FK_RAID = $RaidID;
            $RoleModel->FK_ROLE = $CurRol["RoleID"];
            $RoleModel->Remaining = $CurRol["Amount"];
            $RoleModel->RoleCount = $CurRol["Amount"];
            $RoleModel->insert();
        };

        $cEnd = count($TmpInviteList);
        for($c = 0; $c < $cEnd; ++$c) {
            $CurInv = $TmpInviteList[$c];
//            if($TmpRaidData["FK_OWNER"] !== $CurInv) {
                $Invitemodel = new RsInvitedPlayerRel();
                $Invitemodel->FK_PLAYER = $CurInv;
                $Invitemodel->FK_RAID = $RaidID;
                $Invitemodel->InviteStatus = "waiting";
                $Invitemodel->insert();
//                $Attrs = [
//                    "FK_RAID"       => $RaidID,
//                    "FK_PLAYER"     => $CurInv,
//                    "InviteStatus"  => "waiting",
//                ];
//                if(!$Invitemodel->insertAttributes($Attrs)) { return FALSE; };
//            };
        }; // use explode and INSERT INTO .... VALUES, for better performance

        return TRUE;
    }

    public function CreateNewComment($CommentData, $RaidID) {
        $tmpComment = $CommentData;
        $tmpRaidID = $RaidID;
        $CommentInst = new RsComments();
        $CommentID = $CommentInst->insertAttributes($tmpComment);
        if(empty($CommentID)) { return FALSE; };
        $CommentRelModel = new RsRaidCommentRel();
        $Attrs = array(
            "FK_COMMENT"    => $CommentID,
            "FK_RAID"       => $tmpRaidID,
        );
        if($CommentRelModel->insertAttributes($Attrs)) { return TRUE; };
//        $CommentRelModel->FK_COMMENT = $CommentID;
//        $CommentRelModel->FK_RAID = $tmpRaidID;
//        if($CommentRelModel->insert()) { return TRUE; };
        return FALSE;
    }

    public function DeleteRaid($RaidID) {
        $tmpRaidID = $RaidID;
        $RaidInst = new RsRaids();
        $Opts = array(
            "limit" => 1,
            "param" => array($tmpRaidID),
            "where" => "{$RaidInst->_table}.ID_RAID = ?",
        );
        $RaidInst->delete($Opts);
        return TRUE;
    }

    public function SetDeclineRaid($RaidID) {
        $tmpRaidID = $RaidID;
        $Player = User::getUser();
        $PlayerID = $Player->ID_PLAYER;
        $Invitemodel = new RsInvitedPlayerRel();
        $table = $Invitemodel->_table;
        $Opts = array(
            "limit" => 1,
            "param" => array($tmpRaidID, $PlayerID),
            "where" => "{$table}.FK_RAID = ? AND {$table}.FK_PLAYER = ?",
        );
        if($Invitemodel->updateAttributes(array("InviteStatus" => "rejected"), $Opts)) { return TRUE; };
        return FALSE;
    }

    public function setSignUpRaid($tmpData) {
        $SignUpData = $tmpData;
        $Player = User::getUser();
        $PlayerID = $Player->ID_PLAYER;
        $RaidID = $SignUpData["RaidID"];
        $Invitemodel = new RsInvitedPlayerRel();
        $InvTable = $Invitemodel->_table;
        switch($SignUpData["Status"]) {
            case 1:
                $Status = "accepted";
                break;
            case 2:
                $Status = "waiting";
                break;
            default:
                return FALSE;
        };
        $Status = $SignUpData["Status"];
        $InvOpts = array(
            "limit" => 1,
            "param" => array($RaidID, $PlayerID),
            "where" => "{$InvTable}.FK_RAID = ? AND {$InvTable}.FK_PLAYER = ?",
        );
        $Invitemodel->updateAttributes(array("InviteStatus" => $Status), $InvOpts);

        $PlayerRoleModel = new RsRaidPlayerRoleRel();
        $RolAttrs = array(
            "FK_RAID"   => $RaidID,
            "FK_PLAYER" => $PlayerID,
            "FK_ROLE"   => $SignUpData["Role"],
            "CharName"  => $SignUpData["Character"],
        );
        if(!$PlayerRoleModel->insertAttributes($RolAttrs)) { return FALSE; };

        $CommentData = array(
            "FK_OWNER"  => $PlayerID,
            "OwnerType" => "player",
            "Comment"   => $SignUpData["Comment"],
            "TimeStamp" => 0,
        );
        if(!$this->CreateNewComment($CommentData, $RaidID)) { return FALSE; };
        return TRUE;
    }

    public static function getRaidByID($RaidID) {
        $tmpRaidID = $RaidID;
        $RaidInst = new RsRaids();
        $Opts = array(
            "limit" => 1,
            "param" => array($tmpRaidID),
            "where" => "{$RaidInst->_table}.ID_RAID = ?",
        );
        $Result = $RaidInst->find($Opts);
        if(!empty($Result)) { return $Result; };
        return FALSE;
    }

    public static function getInviteStatus($RaidID) {
        $tmpRaidID = $RaidID;
        $Player = User::getUser();
        $RaidInst = new RsInvitedPlayerRel();
        $table = $RaidInst->_table;
        $Opts = array(
            "limit" => 1,
            "param" => array($tmpRaidID, $Player->ID_PLAYER),
            "where" => "{$table}.FK_RAID = ? AND {$table}.FK_PLAYER = ?",
        );
        $Result = $RaidInst->find($Opts);
        if(!empty($Result)) { return $Result->InviteStatus; };
        return FALSE;
    }

    public static function getRaidRoleByID($RaidID) {
        $tmpRaidID = $RaidID;
        $query = "SELECT FK_RAID,FK_ROLE,RoleCount,Remaining,rs_roles.RoleName
                  FROM rs_raidrole_rel
                  LEFT JOIN rs_roles
                  ON rs_roles.ID_ROLE = rs_raidrole_rel.FK_ROLE
                  WHERE rs_raidrole_rel.FK_RAID = {$tmpRaidID}
                  LIMIT 50";
        $tmpResult = Doo::db()->query($query);
        if(empty($tmpResult)) { return NULL; };
        $Result = $tmpResult->fetchAll();
        if(empty($Result)) { return FALSE; };
        return $Result;
    }

    public static function getInviteType($RaidID) {
        $tmpRaidID = $RaidID;
        $RaidInst = new RsRaids();
        $Opts = array(
            "limit" => 1,
            "param" => array($tmpRaidID),
            "where" => "{$RaidInst->_table}.ID_RAID = ?",
        );
        $Result = $RaidInst->find($Opts);
        if(!empty($Result)) { return $Result->InviteType; };
        return FALSE;
    }

    public function isOwner($RaidID) {
        $tmpRaidID = $RaidID;
        $Player = User::getUser();
        $RaidInst = new RsRaids();
        $table = $RaidInst->_table;
        $Opts = array(
            "limit" => 1,
            "param" => array($tmpRaidID, $Player->ID_PLAYER),
            "where" => "{$table}.ID_RAID = ? AND {$table}.FK_OWNER = ?",
        );
        $Result = $RaidInst->find($Opts);
        if(!empty($Result)) { return TRUE; };
        return FALSE;
    }

    public function isInvited($RaidID) {
        $tmpRaidID = $RaidID;
        if($this->getInviteType($tmpRaidID) === "open") { return TRUE; };
        $Player = User::getUser();
        $InviteInst = new RsInvitedPlayerRel();
        $table = $InviteInst->_table;
        $Opts = array(
            "limit" => 1,
            "param" => array($tmpRaidID, $Player->ID_PLAYER),
            "where" => "{$table}.FK_RAID = ? AND {$table}.FK_PLAYER = ?",
        );
        $Result = $InviteInst->find($Opts);
        if(!empty($Result)) { return TRUE; };
        return FALSE;
    }
};
?>