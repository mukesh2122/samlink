<?php

class Recruitment {

    /**
     * Returns all group list
     *
     * @return SnGroups list
     */
	 
	 
 
	 public function getGames() {
		$list = Doo::db()->find('SnGames', array(
		    'select' => 'ID_GAME, GameName',
		    'asc' => 'GameName'
		));
        
        return $list;
    }
    public static function setGame($game) {
		setcookie('game', $game, (time() + (3600 * 24 * 365)), "/");
		
		setcookie('mode', '', (time() + (3600 * 24 * 365)), "/");
		setcookie('level', '', (time() + (3600 * 24 * 365)), "/");
		setcookie('role', '', (time() + (3600 * 24 * 365)), "/");
		setcookie('faction', '', (time() + (3600 * 24 * 365)), "/");
		setcookie('server', '', (time() + (3600 * 24 * 365)), "/");
		setcookie('lang', '', (time() + (3600 * 24 * 365)), "/");
		
	}
	 public function getSetGames() {
		if (isset($_COOKIE['game']) and !empty($_COOKIE['game'])) {
			return $_COOKIE['game'];
		} else {
			return '';
		}
    }
	
	public static function setType($type) {
		setcookie('type', $type, (time() + (3600 * 24 * 365)), "/");
		
		setcookie('game', '', (time() + (3600 * 24 * 365)), "/");
		setcookie('mode', '', (time() + (3600 * 24 * 365)), "/");
		setcookie('level', '', (time() + (3600 * 24 * 365)), "/");
		setcookie('role', '', (time() + (3600 * 24 * 365)), "/");
		setcookie('faction', '', (time() + (3600 * 24 * 365)), "/");
		setcookie('server', '', (time() + (3600 * 24 * 365)), "/");
		setcookie('lang', '', (time() + (3600 * 24 * 365)), "/");
		
	}
	 public function getSetType() {
		if (isset($_COOKIE['type']) and !empty($_COOKIE['type'])) {
			return $_COOKIE['type'];
		} else {
			return '';
		}
    }
	
	 public function getRegions() {
		$list = Doo::db()->find('EsRegions', array(
		    'select' => 'ID_REGION, RegionName',
		    'desc' => 'ID_REGION'
		));
        
        return $list;
    }
	public static function setRegion($region) {
		setcookie('region', $region, (time() + (3600 * 24 * 365)), "/");
	}
	 public function getSetRegion() {
		if (isset($_COOKIE['region']) and !empty($_COOKIE['region'])) {
			return $_COOKIE['region'];
		} else {
			return '';
		}
    }
	public static function getRegionByID($id) {
        $item = Doo::db()->getOne('EsRegions', array(
            'limit' => 1,
            'where' => 'ID_REGION = ?',
            'param' => array($id)
                ));
        return $item;
    }
	public static function setOwnerType($ownertype) {
		setcookie('ownertype', $ownertype, (time() + (3600 * 24 * 365)), "/");
	}
	 public function getOwnerType() {
		if (isset($_COOKIE['ownertype']) and !empty($_COOKIE['ownertype'])) {
			return $_COOKIE['ownertype'];
		} else {
			return '';
		}
    }	
	public function getServer($game_id = '') {
		$gameserver = new RsGameServerRel;
		$server = new RsServers;
		$list = '';
		if ($game_id != '') {
 			$list = Doo::db()->find('RsServers', array(
		    	'select' => 'ID_SERVER, ServerName',
				'where' => " EXISTS (SELECT {$gameserver->_table}.FK_SERVER FROM {$gameserver->_table} WHERE {$server->_table}.ID_SERVER = {$gameserver->_table}.FK_SERVER AND {$gameserver->_table}.FK_GAME = ?)",
				'param' => array($game_id),
		    	'asc' => 'ServerName'
			));
		} else {
			$list = Doo::db()->find('RsServers', array(
				'select' => 'ID_SERVER, ServerName',
				'asc' => 'ServerName'
			));
		}        
        return $list;
    }	
	public static function setServer($server) {
		setcookie('server', $server, (time() + (3600 * 24 * 365)), "/");
	}
	 public function getSetServer() {
		if (isset($_COOKIE['server']) and !empty($_COOKIE['server'])) {
			return $_COOKIE['server'];
		} else {
			return '';
		}
    }
	public static function setLang($lang) {
		setcookie('lang', $lang, (time() + (3600 * 24 * 365)), "/");
	}
	 public function getSetLang() {
		if (isset($_COOKIE['lang']) and !empty($_COOKIE['lang'])) {
			return $_COOKIE['lang'];
		} else {
			return '';
		}
    }
	public static function getServerByID($id) {
        $item = Doo::db()->getOne('RsServers', array(
            'limit' => 1,
            'where' => 'ID_SERVER = ?',
            'param' => array($id)
                ));
        return $item;
    }
			
	public function getFaction($game_id = '') {
		$faction = new RsFactions;
		$gamefaction = new RsGameFactionRel;
		$list = '';
		if ($game_id != '') {
 			$list = Doo::db()->find('RsFactions', array(
		    	'select' => 'ID_FACTION, FactionName',
				'where' => " EXISTS (SELECT {$gamefaction->_table}.FK_FACTION FROM {$gamefaction->_table} WHERE {$faction->_table}.ID_FACTION = {$gamefaction->_table}.FK_FACTION AND {$gamefaction->_table}.FK_GAME = ?)",
				'param' => array($game_id),
		    	'asc' => 'FactionName'
			));
		} else {
			$list = Doo::db()->find('RsFactions', array(
		    	'select' => 'ID_FACTION, FactionName',
		    	'asc' => 'FactionName'
			));
		}
		
        return $list;
    }
	 public static function setFaction($faction) {
		setcookie('faction', $faction, (time() + (3600 * 24 * 365)), "/");
	}
	public function getSetFaction() {
		if (isset($_COOKIE['faction']) and !empty($_COOKIE['faction'])) {
			return $_COOKIE['faction'];
		} else {
			return '';
		}
    }
	public static function getFactionByID($id) {
        $item = Doo::db()->getOne('RsFactions', array(
            'limit' => 1,
            'where' => 'ID_FACTION = ?',
            'param' => array($id)
                ));
        return $item;
    }
	
	public function getRoles($game_id = '') {
		$rolerel = new RsGameRoleRel;
		$roles = new RsRoles;
		$list = '';
		if ($game_id != '') {
			$list = Doo::db()->find('RsRoles', array(
		    	'select' => 'ID_ROLE, RoleName',
				'where' => " EXISTS (SELECT {$rolerel->_table}.FK_ROLE FROM {$rolerel->_table} WHERE {$roles->_table}.ID_ROLE = {$rolerel->_table}.FK_ROLE AND {$rolerel->_table}.FK_GAME = ?)",
				'param' => array($game_id),
		    	'asc' => 'RoleName'
			));
			
		} else {
			$list = Doo::db()->find('RsRoles', array(
		    	'select' => 'ID_ROLE, RoleName',
		    	'asc' => 'RoleName'
			));
        }
		
        return $list;
    }		
	 public static function setRole($role) {
		setcookie('role', $role, (time() + (3600 * 24 * 365)), "/");
	}
	public function getSetRole() {
		if (isset($_COOKIE['role']) and !empty($_COOKIE['role'])) {
			return $_COOKIE['role'];
		} else {
			return '';
		}
    }
	public static function getRoleByID($id) {
        $item = Doo::db()->getOne('RsRoles', array(
            'limit' => 1,
            'where' => 'ID_ROLE = ?',
            'param' => array($id)
                ));
        return $item;
    }
	
			
	public function getLevel($game_id = '') {
		$gamelevel = new RsGameLevelRel;
		$levelgroup = new SnGroupTypes;
		$list = '';
		if ($game_id != '') {
			$list = Doo::db()->find('SnGroupTypes', array(
		    	'select' => 'ID_GROUPTYPE, GroupTypeName',
				'where' => " EXISTS (SELECT {$gamelevel->_table}.FK_GROUPTYPE FROM {$gamelevel->_table} WHERE {$levelgroup->_table}.ID_GROUPTYPE = {$gamelevel->_table}.FK_GROUPTYPE AND {$gamelevel->_table}.FK_GAME = ?)",
				'param' => array($game_id),
		    	'asc' => 'GroupTypeName'
			));
			
		} else {
			$list = Doo::db()->find('SnGroupTypes', array(
				'select' => 'ID_GROUPTYPE, GroupTypeName',
				'asc' => 'GroupTypeName'
			));
        }
        return $list;
    }
	public static function setLevel($level) {
		setcookie('level', $level, (time() + (3600 * 24 * 365)), "/");
	}
	public function getSetLevel() {
		if (isset($_COOKIE['level']) and !empty($_COOKIE['level'])) {
			return $_COOKIE['level'];
		} else {
			return '';
		}
    }
	public static function getLevelByID($id) {
        $item = Doo::db()->getOne('SnGroupTypes', array(
            'limit' => 1,
            'where' => 'ID_GROUPTYPE = ?',
            'param' => array($id)
                ));
        return $item;
    }
	
	
	public function getMode($game_id = '') {
		$gamemode = new RsGameModeRel;
		$modegroup = new SnGroupTypes;
		$list = '';
		if ($game_id != '') {
			$list = Doo::db()->find('SnGroupTypes', array(
		    	'select' => 'ID_GROUPTYPE, GroupTypeName',
				'where' => " EXISTS (SELECT {$gamemode->_table}.FK_GROUPTYPE FROM {$gamemode->_table} WHERE {$modegroup->_table}.ID_GROUPTYPE = {$gamemode->_table}.FK_GROUPTYPE AND {$gamemode->_table}.FK_GAME = ?)",
				'param' => array($game_id),
		    	'asc' => 'GroupTypeName'
			));
			
		} else {
			$list = Doo::db()->find('SnGroupTypes', array(
				'select' => 'ID_GROUPTYPE, GroupTypeName',
				'asc' => 'GroupTypeName'
			));
		}	        
        return $list;
    }	
	public static function setMode($mode) {
		setcookie('mode', $mode, (time() + (3600 * 24 * 365)), "/");
	}
	public function getSetMode() {
		if (isset($_COOKIE['mode']) and !empty($_COOKIE['mode'])) {
			return $_COOKIE['mode'];
		} else {
			return '';
		}
    }
	public static function getModeByID($id) {
        $item = Doo::db()->getOne('SnGroupTypes', array(
            'limit' => 1,
            'where' => 'ID_GROUPTYPE = ?',
            'param' => array($id)
                ));
        return $item;
    }
	
	public function getNotices($ownertype='',$game_id='',$level='',$mode='',$role='',$faction='',$region='',$server='',$lang='',$limit='',$typeGame='',$type='',$order='1',$typeKeywords='') {
		
		if (($ownertype=='') or ($ownertype=='player')) {
			$ownertype_name = 'NickName';
			$ownertype_table= "sn_players";	
			$ownertype_ID= "ID_PLAYER";	
		} else {
			$ownertype_name = "GroupName";
			$ownertype_table= "sn_groups";
			$ownertype_ID= "ID_GROUP";	
		}
		
		if (($type=='') or ($type=='player')) {
			$ownertype_name = 'NickName';
			$ownertype_table= "sn_players";	
			$ownertype_ID= "ID_PLAYER";	
		} else {
			$ownertype = $type;
			$ownertype_name = "GroupName";
			$ownertype_table= "sn_groups";
			$ownertype_ID= "ID_GROUP";	
		}
		
		$filter = '';
		if ($game_id!='') {
			$filter =  ' AND rc_notices.FK_GAME = '.$game_id;
		}
		if ($level!='') {
			$filter .= ' AND rc_notices.FK_GAMEPLAYLVL = '.$level;
		}
		if ($mode!='') {
			$filter .= ' AND rc_notices.FK_GAMEPLAYMODE = '.$mode;
		}
		if ($role!='') {
			$filter .= ' AND rc_notices.FK_ROLE = '.$role;
		}
		if ($faction!='') {
			$filter .= ' AND rc_notices.FK_FACTION = '.$faction;
		}
		if ($region!='') {
			$filter .= ' AND rc_notices.FK_REGION = '.$region;
		}
		if ($server!='') {
			$filter .= ' AND rc_notices.FK_SERVER = '.$server;
		}
		if ($lang!='') {
			$filter .= ' AND rc_notices.FK_LANGUAGE = '.$lang;
		}
		if ($typeGame!='') {
			$filter .= " AND sn_games.Gamename LIKE '%".$typeGame."%' ";
		}
		if ($typeKeywords!='') {
			$filter .= " AND ((rc_notices.Details LIKE '%".$typeKeywords."%') ";
			$filter .= " OR (subtabel1.GroupTypeName LIKE '%".$typeKeywords."%') ";
			$filter .= " OR (subtabel2.GroupTypeName LIKE '%".$typeKeywords."%') ";
			$filter .= " OR (es_regions.RegionName LIKE '%".$typeKeywords."%') ";
			$filter .= " OR (ge_languages.EnglishName LIKE '%".$typeKeywords."%') ";
			$filter .= " OR (rs_servers.ServerName LIKE '%".$typeKeywords."%') ";
			$filter .= " OR (rs_factions.FactionName LIKE '%".$typeKeywords."%')) ";
		}
		if ($order=='1') {
			$orderby = ' ORDER BY rc_notices.ViewCount DESC ';
		} else {
			$orderby = ' ORDER BY rc_notices.ID_NOTICE DESC ';
		}
		$sqllimit = '';
		if ($limit!='') {
			$sqllimit = ' LIMIT '.$limit;
		}
		$query ="SELECT rc_notices. * , 
				subtabel1.GroupTypeName AS GameplayLVLName, 
				subtabel2.GroupTypeName AS GameplayModeName,
				rs_roles.RoleName as RoleName, 
				".$ownertype_table.".".$ownertype_name." as OwnerName,
				es_regions.RegionName as RegionName, 
				ge_languages.EnglishName as LanguageName,
				sn_games.Gamename as GameName,
				sn_games.GameType as GameType,
				rs_servers.ServerName as ServerName,
				rs_factions.FactionName as FactionName			
				FROM rc_notices INNER JOIN sn_games ON sn_games.ID_GAME = rc_notices.FK_GAME 
								LEFT JOIN sn_grouptypes AS subtabel1 ON subtabel1.ID_GROUPTYPE = rc_notices.FK_GAMEPLAYMODE 
								LEFT JOIN sn_grouptypes AS subtabel2 ON subtabel2.ID_GROUPTYPE = rc_notices.FK_GAMEPLAYLVL
								LEFT JOIN rs_roles ON rs_roles.ID_ROLE = rc_notices.FK_ROLE
								LEFT JOIN ".$ownertype_table." ON ".$ownertype_table.".".$ownertype_ID." = rc_notices.FK_OWNER
								LEFT JOIN es_regions ON es_regions.ID_REGION = rc_notices.FK_REGION 
								LEFT JOIN ge_languages ON ge_languages.ID_LANGUAGE = rc_notices.FK_LANGUAGE 
								LEFT JOIN rs_servers ON rs_servers.ID_SERVER = rc_notices.FK_SERVER
								LEFT JOIN rs_factions ON rs_factions.ID_FACTION = rc_notices.FK_FACTION
				WHERE rc_notices.OwnerType = '".$ownertype."'".$filter.$orderby.$sqllimit."";
		//die($query);
		$rs = Doo::db()->query($query);
		$item = $rs->fetchAll(PDO::FETCH_CLASS);
		
        return $item;
	}
	
	public function getNoticeById($nid, $ownertype='') {
		
		if (($ownertype=='player')) {
			$ownertype_name = 'NickName';
			$ownertype_table= "sn_players";	
			$ownertype_ID= "ID_PLAYER";	
		} else {
			$ownertype_name = "GroupName";
			$ownertype_table= "sn_groups";
			$ownertype_ID= "ID_GROUP";	
		}
		
		$query ="SELECT rc_notices . * , 
				subtabel1.GroupTypeName AS GameplayLVLName, 
				subtabel2.GroupTypeName AS GameplayModeName,
				rs_roles.RoleName as RoleName, 
				".$ownertype_table.".".$ownertype_name." as OwnerName,
				es_regions.RegionName as RegionName, 
				ge_languages.EnglishName as LanguageName,
				sn_games.Gamename as GameName,
				rs_servers.ServerName as ServerName,
				rs_factions.FactionName as FactionName			
				FROM rc_notices INNER JOIN sn_games ON sn_games.ID_GAME = rc_notices.FK_GAME 
								LEFT JOIN sn_grouptypes AS subtabel1 ON subtabel1.ID_GROUPTYPE = rc_notices.FK_GAMEPLAYMODE 
								LEFT JOIN sn_grouptypes AS subtabel2 ON subtabel2.ID_GROUPTYPE = rc_notices.FK_GAMEPLAYLVL
								LEFT JOIN rs_roles ON rs_roles.ID_ROLE = rc_notices.FK_ROLE
								LEFT JOIN ".$ownertype_table." ON ".$ownertype_table.".".$ownertype_ID." = rc_notices.FK_OWNER
								LEFT JOIN es_regions ON es_regions.ID_REGION = rc_notices.FK_REGION 
								LEFT JOIN ge_languages ON ge_languages.ID_LANGUAGE = rc_notices.FK_LANGUAGE 
								LEFT JOIN rs_servers ON rs_servers.ID_SERVER = rc_notices.FK_SERVER
								LEFT JOIN rs_factions ON rs_factions.ID_FACTION = rc_notices.FK_FACTION
				WHERE rc_notices.OwnerType = '".$ownertype."'
				AND   rc_notices.ID_NOTICE = '".$nid."'";
				
		$rs = Doo::db()->query($query);
		$item = $rs->fetchAll(PDO::FETCH_CLASS);
		
        return $item;
	}
	public function gamedescription($post) {
		$info = '';
		if (!empty($post)) {
			
			//$notices = new RcNotices;
				
			$info = ContentHelper::handleContentInput($post['gamedescription']);
			//die($info);
		}
		 return $info;
	}
	public function gamename($post) {
		$info = '';
		if (!empty($post)) {
			
			//$notices = new RcNotices;
				
			$info = ContentHelper::handleContentInput($post['game']);
			//die($info);
		}
		 return $info;
	}
	public function saveNotice($post) {
		$noticesID = '';
		if (!empty($post)) {
			
			
			$notices = new RcNotices;
				
			$notices->OwnerType = ContentHelper::handleContentInput($post['ownertype']);
			$notices->isActive = '1';
			$notices->FK_OWNER = ContentHelper::handleContentInput($post['owner']);
			
			$notices->FK_REGION = ContentHelper::handleContentInput($post['region']);
			$notices->FK_LANGUAGE = ContentHelper::handleContentInput($post['language']);
			$notices->FK_GAME = ContentHelper::handleContentInput($post['game']);
			$notices->FK_SERVER = ContentHelper::handleContentInput($post['server']);
			$notices->FK_FACTION = ContentHelper::handleContentInput($post['faction']);
			$notices->FK_GAMEPLAYLVL = ContentHelper::handleContentInput($post['gplvl']);
			$notices->FK_GAMEPLAYMODE = ContentHelper::handleContentInput($post['gpmode']);
			$notices->FK_ROLE = ContentHelper::handleContentInput($post['role']);
			$notices->Details = ContentHelper::handleContentInput($post['details']);
			$notices->InGameHandle = '';	//ContentHelper::handleContentInput($post['ingamename'])
			
			//$notices->CreatedTime = $today_date;
			
			$noticesID = $notices->insert();		

		}
        return $noticesID;	
			
	}
	public function getownerinfo($oid='',$ownertype='') {
		$item = '';
		if (($ownertype == 'player') && ($oid!='')){
			$item = Doo::db()->getOne('Players', array(
            'limit' => 1,
            'where' => 'ID_PLAYER = ?',
            'param' => array($oid)
                ));
        		
		}
			
       return $item;
	}
	
	
	public function saveResponse($post) {
		$responseID = '';
		if (!empty($post)) {
		
			$responses = new RsResponses;
				
			$responses->OwnerType = ContentHelper::handleContentInput($post['ownertype']);
			$responses->isActive = '1';
			$responses->FK_OWNER = ContentHelper::handleContentInput($post['ownerid']);
			
			$responses->FK_NOTICE = ContentHelper::handleContentInput($post['nid']);
			$responses->ResponseDetailsLog = ContentHelper::handleContentInput($post['ResponseDetailsLog']);
			$responses->ResponseStatus = 'waiting';
			
			$responsesID = $responses->insert();		
		
		}
        return $responsesID;	
			
	}
	
	
	public function updateResponse($responseid,$statusid,$owner,$notice) {
		$ID = '';
		if (($responseid!='') && ($statusid!='')) {
		
			
			$responses = new RsResponses;
			$responses->ResponseStatus = $statusid;
			$responses->ID_RESPONSE = $responseid;
			$responses->FK_OWNER = $owner;
			$responses->FK_NOTICE = $notice;
			$responses->update(array(
							'field' => 'ResponseStatus',
							'where' => 'ID_RESPONSE = ? AND FK_NOTICE = ? AND FK_OWNER = ?',
							'param' => array($responseid,$notice,$owner)
			));	
//			
		}
        return true;	
			
	}
	
	public function NoticeCountViews($notice) {
        $rc = new RcNotices();
		$totalNum = (object) Doo::db()->fetchRow('SELECT ViewCount as cnt FROM `' . $rc->_table . '` WHERE ID_NOTICE = '.$notice.' LIMIT 1');
        return $totalNum->cnt;
    }
	public function updateNoticeViews($notice,$countplus) {
		$ID = '';
		if (($notice!='')) {
		
			$countplus = (1 * $countplus) +1;
			$notices = new RcNotices;
				
			$notices->ID_NOTICE = $notice;
			$notices->ViewCount = $countplus;
			$notices->update(array(
							'field' => 'ViewCount',
							'where' => 'ID_NOTICE = ?',
							'param' => array($notice)
			));	
//			
		}
        return true;	
			
	}
	
	public function getMyNotices($ownertype='', $ownerid='', $type = '',$limit='') {
		$item = '';
		setcookie('game', '', (time() + (3600 * 24 * 365)), "/");
		setcookie('mode', '', (time() + (3600 * 24 * 365)), "/");
		setcookie('level', '', (time() + (3600 * 24 * 365)), "/");
		setcookie('role', '', (time() + (3600 * 24 * 365)), "/");
		setcookie('faction', '', (time() + (3600 * 24 * 365)), "/");
		setcookie('server', '', (time() + (3600 * 24 * 365)), "/");
		setcookie('lang', '', (time() + (3600 * 24 * 365)), "/");
		
		if ($ownerid!='') {
			if (($ownertype=='') or ($ownertype=='player')) {
				$ownertype_name = 'NickName';
				$ownertype_table= "sn_players";	
				$ownertype_ID= "ID_PLAYER";	
			} else {
				$ownertype_name = "GroupName";
				$ownertype_table= "sn_groups";
				$ownertype_ID= "ID_GROUP";	
			}
			
			if (($type!='') && ($type=='responses')) {
				$responses = " AND EXISTS (SELECT ID_RESPONSE FROM rs_responses WHERE rs_responses.FK_NOTICE = rc_notices.ID_NOTICE 
				                           AND rs_responses.FK_OWNER = ".$ownerid.") "; 
			} else {
				$responses = " AND rc_notices.FK_OWNER = ".$ownerid;
			}
			$sqllimit = '';
			if ($limit!='') {
				$sqllimit = ' LIMIT '.$limit;
			}
			//$query =
			$query ="SELECT rc_notices . * , 
				subtabel1.GroupTypeName AS GameplayLVLName, 
				subtabel2.GroupTypeName AS GameplayModeName,
				rs_roles.RoleName as RoleName, 
				".$ownertype_table.".".$ownertype_name." as OwnerName,
				es_regions.RegionName as RegionName, 
				ge_languages.EnglishName as LanguageName,
				sn_games.Gamename as GameName,
				rs_servers.ServerName as ServerName,
				rs_factions.FactionName as FactionName			
				FROM rc_notices INNER JOIN sn_games ON sn_games.ID_GAME = rc_notices.FK_GAME 
								LEFT JOIN sn_grouptypes AS subtabel1 ON subtabel1.ID_GROUPTYPE = rc_notices.FK_GAMEPLAYMODE 
								LEFT JOIN sn_grouptypes AS subtabel2 ON subtabel2.ID_GROUPTYPE = rc_notices.FK_GAMEPLAYLVL
								LEFT JOIN rs_roles ON rs_roles.ID_ROLE = rc_notices.FK_ROLE
								LEFT JOIN ".$ownertype_table." ON ".$ownertype_table.".".$ownertype_ID." = rc_notices.FK_OWNER
								LEFT JOIN es_regions ON es_regions.ID_REGION = rc_notices.FK_REGION 
								LEFT JOIN ge_languages ON ge_languages.ID_LANGUAGE = rc_notices.FK_LANGUAGE 
								LEFT JOIN rs_servers ON rs_servers.ID_SERVER = rc_notices.FK_SERVER
								LEFT JOIN rs_factions ON rs_factions.ID_FACTION = rc_notices.FK_FACTION
				WHERE rc_notices.OwnerType = '".$ownertype."'".$responses.$sqllimit."";
			
			$rs = Doo::db()->query($query);
			$item = $rs->fetchAll(PDO::FETCH_CLASS);
		}
        return $item;
	}
	public static function getResponsesByNotices($noticesid,$ownertype='') {
        $item = '';
		if ($noticesid!='') {
			//if (($ownertype=='') or ($ownertype=='player')) {
				$ownertype_name = 'NickName';
				$ownertype_table= "sn_players";	
				$ownertype_ID= "ID_PLAYER";	
			//} else {
//				$ownertype_name = "GroupName";
//				$ownertype_table= "sn_groups";
//				$ownertype_ID= "ID_GROUP";	
//			}
//			
			$query ="SELECT ID_RESPONSE, FK_NOTICE, FK_OWNER, OwnerType, ResponseDetailsLog, ResponseStatus, 
			".$ownertype_table.".".$ownertype_name." as OwnerName
			FROM rs_responses, ".$ownertype_table."
			WHERE (FK_NOTICE = '".$noticesid."') 
			AND ".$ownertype_table.".".$ownertype_ID." = FK_OWNER";

			$rs = Doo::db()->query($query);
			$item = $rs->fetchAll(PDO::FETCH_CLASS);
		}
        return $item;
    }
	
	 public function getNoticesTotal() {
        $rc = new RcNotices();
		$totalNum = (object) Doo::db()->fetchRow('SELECT COUNT(1) as cnt FROM `' . $rc->_table . '` LIMIT 1');
        return $totalNum->cnt;
    }
	 public function getMyNoticesTotal($ownertype='',$player='') {
        $rc = new RcNotices();
		$totalNum = (object) Doo::db()->fetchRow("SELECT COUNT(1) as cnt FROM ".$rc->_table."
		WHERE FK_OWNER = '".$player."'
		AND   OwnerType = '".$ownertype."'
		 LIMIT 1");
        return $totalNum->cnt;
    }
	 public function getResponsesTotal($nid='') {
        $rs = new RsResponses();
		$totalNum = (object) Doo::db()->fetchRow("SELECT COUNT(1) as cnt FROM ".$rs->_table."
		WHERE FK_NOTICE = '".$nid."'
		 LIMIT 1");
        return $totalNum->cnt;
    }
	public static function getSearchGames($phrase) {
		$list = '';
		if (strlen($phrase) > 2) {
			$list = Doo::db()->find('SnGames', array(
				'limit' => 10,
				'asc' => 'GameName',
				'where' => 'GameName LIKE ?',
				'param' => array('%'. $phrase . '%')
			));
		}

		return $list;
	}
	
	public function getTop5Notices($ownertype='') {
		
		if (($ownertype=='') or ($ownertype=='player')) {
			$ownertype_name = 'NickName';
			$ownertype_table= "sn_players";	
			$ownertype_ID= "ID_PLAYER";	
		} else {
			$ownertype_name = "GroupName";
			$ownertype_table= "sn_groups";
			$ownertype_ID= "ID_GROUP";	
		}
		$filter = '';
		
		$sqllimit = '';
		//if ($limit!='') {
			$sqllimit = ' ORDER BY rc_notices.ViewCount DESC LIMIT 5 ';
		//}
		$query ="SELECT rc_notices. * , 
				subtabel1.GroupTypeName AS GameplayLVLName, 
				subtabel2.GroupTypeName AS GameplayModeName,
				rs_roles.RoleName as RoleName, 
				".$ownertype_table.".".$ownertype_name." as OwnerName,
				es_regions.RegionName as RegionName, 
				ge_languages.EnglishName as LanguageName,
				sn_games.Gamename as GameName,
				sn_games.GameType as GameType,
				rs_servers.ServerName as ServerName,
				rs_factions.FactionName as FactionName			
				FROM rc_notices INNER JOIN sn_games ON sn_games.ID_GAME = rc_notices.FK_GAME 
								LEFT JOIN sn_grouptypes AS subtabel1 ON subtabel1.ID_GROUPTYPE = rc_notices.FK_GAMEPLAYMODE 
								LEFT JOIN sn_grouptypes AS subtabel2 ON subtabel2.ID_GROUPTYPE = rc_notices.FK_GAMEPLAYLVL
								LEFT JOIN rs_roles ON rs_roles.ID_ROLE = rc_notices.FK_ROLE
								LEFT JOIN ".$ownertype_table." ON ".$ownertype_table.".".$ownertype_ID." = rc_notices.FK_OWNER
								LEFT JOIN es_regions ON es_regions.ID_REGION = rc_notices.FK_REGION 
								LEFT JOIN ge_languages ON ge_languages.ID_LANGUAGE = rc_notices.FK_LANGUAGE 
								LEFT JOIN rs_servers ON rs_servers.ID_SERVER = rc_notices.FK_SERVER
								LEFT JOIN rs_factions ON rs_factions.ID_FACTION = rc_notices.FK_FACTION
				WHERE rc_notices.OwnerType = '".$ownertype."'".$filter.$sqllimit."";

		$rs = Doo::db()->query($query);
		$item = $rs->fetchAll(PDO::FETCH_CLASS);
		
        return $item;
	}
	//%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%
	public static function ListGroupsByPlayer($playerid) {
		$item = '';
		
		$sqllimit = '';
		$sqllimit = ' ORDER BY sn_groups.ID_GROUP ';
		$query ="SELECT sn_playergroup_rel. * , 
				sn_groups.* 
				FROM sn_playergroup_rel INNER JOIN sn_groups ON sn_playergroup_rel.ID_GROUP = sn_groups.ID_GROUP 
				WHERE sn_playergroup_rel.ID_PLAYER = '".$playerid."'".$sqllimit."";

		$rs = Doo::db()->query($query);
		$item = $rs->fetchAll(PDO::FETCH_CLASS);
		
		
		//if (($playerid != '')){
//			$item = Doo::db()->find('SnPlayerGroupRel', array(
//            'where' => 'ID_PLAYER = ?',
//            'param' => array($playerid)
//                ));
//        		
//		}
			
       return $item;
	}
	
}