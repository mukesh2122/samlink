<?php
//include("conn.php");
/*$link = mysql_pconnect("localhost", "root", "") or die("Could not connect");
mysql_select_db("playnation") or die("Could not select database");*/

if (isset($_GET['action'])) {
	
	$action = ucfirst($_GET['action']);
switch($action)
	{
	
	case 'ShowNoticeById': 
		$nid = $_GET['nid'];
		$ownertype= $_GET['ownertype'];
		if ($ownertype == 'player') {
			$ownertype_name = "NickName";
			$ownertype_table= "sn_players";	
			$ownertype_ID= "ID_PLAYER";			
			}
		else {
			$ownertype_name = "GroupName";
			$ownertype_table= "sn_groups";
			$ownertype_ID= "ID_GROUP";	
		}
		
		$arr = array();
			$rs = mysql_query("
				SELECT rc_notices . * , 
				subtabel1.GroupTypeName AS GameplayLVLName, 
				subtabel2.GroupTypeName AS GameplayModeName,
				sn_roles.name as RoleName, 
				$ownertype_table.$ownertype_name as OwnerName,
				es_regions.RegionName as RegionName, 
				ge_languages.EnglishName as LanguageName,
				sn_games.Gamename as GameName,
				sn_servers.name as ServerName,
				sn_factions.name as FactionName			
				FROM rc_notices, sn_grouptypes AS subtabel1, sn_grouptypes AS subtabel2,
				sn_roles, $ownertype_table, es_regions, ge_languages, sn_games, sn_servers, sn_factions
				WHERE rc_notices.OwnerType = '$ownertype'
				AND subtabel1.ID_GROUPTYPE = rc_notices.FK_GAMEPLAYMODE
				AND subtabel2.ID_GROUPTYPE = rc_notices.FK_GAMEPLAYLVL	
				AND	sn_roles.ID_ROLE = rc_notices.FK_ROLE
				AND	es_regions.ID_REGION = rc_notices.FK_REGION
				AND	ge_languages.ID_LANGUAGE = rc_notices.FK_LANGUAGE
				AND	sn_games.ID_GAME = rc_notices.FK_GAME
				AND	sn_servers.ID_SERVER = rc_notices.FK_SERVER
				AND	sn_factions.ID_FACTION = rc_notices.FK_FACTION
				AND $ownertype_table.$ownertype_ID = rc_notices.FK_OWNER
				AND rc_notices.ID_NOTICE = $nid
			");			
			while($obj = mysql_fetch_object($rs)) {
				$arr[] = $obj;
			}
			$response = '{"notices":'.json_encode($arr).'}';
			echo $response;
	break;
	
	case 'ShowNoticesByOwner': 
		$ownerid = $_GET['ownerid'];
		$ownertype= $_GET['ownertype'];
		if ($ownertype == 'player') {
			$ownertype_name = "NickName";
			$ownertype_table= "sn_players";	
			$ownertype_ID= "ID_PLAYER";			
			}
		else {
			$ownertype_name = "GroupName";
			$ownertype_table= "sn_groups";
			$ownertype_ID= "ID_GROUP";	
		}
		
		$arr = array();
			$rs = mysql_query("
				SELECT rc_notices . * , 
				subtabel1.GroupTypeName AS GameplayLVLName, 
				subtabel2.GroupTypeName AS GameplayModeName,
				sn_roles.name as RoleName, 
				$ownertype_table.$ownertype_name as OwnerName,
				es_regions.RegionName as RegionName, 
				ge_languages.EnglishName as LanguageName,
				sn_games.Gamename as GameName,
				sn_servers.name as ServerName,
				sn_factions.name as FactionName			
				FROM rc_notices, sn_grouptypes AS subtabel1, sn_grouptypes AS subtabel2,
				sn_roles, $ownertype_table, es_regions, ge_languages, sn_games, sn_servers, sn_factions
				WHERE rc_notices.OwnerType = '$ownertype'
				AND subtabel1.ID_GROUPTYPE = rc_notices.FK_GAMEPLAYMODE
				AND subtabel2.ID_GROUPTYPE = rc_notices.FK_GAMEPLAYLVL	
				AND	sn_roles.ID_ROLE = rc_notices.FK_ROLE
				AND	es_regions.ID_REGION = rc_notices.FK_REGION
				AND	ge_languages.ID_LANGUAGE = rc_notices.FK_LANGUAGE
				AND	sn_games.ID_GAME = rc_notices.FK_GAME
				AND	sn_servers.ID_SERVER = rc_notices.FK_SERVER
				AND	sn_factions.ID_FACTION = rc_notices.FK_FACTION
				AND $ownertype_table.$ownertype_ID = rc_notices.FK_OWNER
				AND rc_notices.FK_OWNER = $ownerid
			");			
			while($obj = mysql_fetch_object($rs)) {
				$arr[] = $obj;
			}
			$response = '{"notices":'.json_encode($arr).'}';
			echo $response;
	break;
	
		
	case 'ListNotices':
	//combine with listgroupnotices
	//btw: filterparams virker ikke fordi de ikke bliver sendt med til notices af ajax men bliver på siden
	//load parametrene ind når der bliver søgt med jq fra html vals
	$ownertype = $_GET['ownertype'];	

			$filterparams = "";
		if (isset($_GET['game'])) { $filterparams.= 	" AND rc_notices.FK_GAME = ". $_GET['game'];  }
		if (isset($_GET['faction'])) { $filterparams.= " AND rc_notices.FK_FACTION = ". $_GET['faction'];  }
		if (isset($_GET['role'])) { $filterparams.= 	" AND rc_notices.FK_ROLE = ". $_GET['role'];  }
		if (isset($_GET['server'])) { $filterparams.= 	" AND rc_notices.FK_SERVER = ". $_GET['server'];  }
		if (isset($_GET['region'])) { $filterparams.= 	" AND rc_notices.FK_REGION = ". $_GET['region'];  }
		if (isset($_GET['lang'])) { $filterparams.= 	" AND rc_notices.FK_LANGUAGE = ". $_GET['lang'];  }
		if (isset($_GET['gpm'])) { $filterparams.= 	" AND rc_notices.FK_GAMEPLAYMODE = ". $_GET['gpm'];  }		
		if (isset($_GET['gpl'])) { $filterparams.= 	" AND rc_notices.FK_GAMEPLAYLVL = ". $_GET['gpl'];  }

	if ($ownertype == 'player') {
			$ownertype_name = "NickName";
			$ownertype_table= "sn_players";	
			$ownertype_ID= "ID_PLAYER";			
			}
		else {
			$ownertype_name = "GroupName";
			$ownertype_table= "sn_groups";
			$ownertype_ID= "ID_GROUP";	
		}
	
			$arr = array();
			$rs = mysql_query("
				SELECT rc_notices . * , 
				subtabel1.GroupTypeName AS GameplayLVLName, 
				subtabel2.GroupTypeName AS GameplayModeName,
				sn_roles.name as RoleName, 
				$ownertype_table.$ownertype_name as OwnerName,
				es_regions.RegionName as RegionName, 
				ge_languages.EnglishName as LanguageName,
				sn_games.Gamename as GameName,
				sn_servers.name as ServerName,
				sn_factions.name as FactionName			
				FROM rc_notices, sn_grouptypes AS subtabel1, sn_grouptypes AS subtabel2,
				sn_roles, $ownertype_table, es_regions, ge_languages, sn_games, sn_servers, sn_factions
				WHERE rc_notices.OwnerType = '$ownertype'
				AND subtabel1.ID_GROUPTYPE = rc_notices.FK_GAMEPLAYMODE
				AND subtabel2.ID_GROUPTYPE = rc_notices.FK_GAMEPLAYLVL	
				AND	sn_roles.ID_ROLE = rc_notices.FK_ROLE
				AND	es_regions.ID_REGION = rc_notices.FK_REGION
				AND	ge_languages.ID_LANGUAGE = rc_notices.FK_LANGUAGE
				AND	sn_games.ID_GAME = rc_notices.FK_GAME
				AND	sn_servers.ID_SERVER = rc_notices.FK_SERVER
				AND	sn_factions.ID_FACTION = rc_notices.FK_FACTION
				AND $ownertype_table.$ownertype_ID = rc_notices.FK_OWNER
				AND rc_notices.IsActive = '1'
				$filterparams
			");			
			while($obj = mysql_fetch_object($rs)) {
			$arr[] = $obj;
			}
			$response = '{"notices":'.json_encode($arr).'}';
			echo $response;
	break;	
	
	case 'GetOwnerInfo':
		
	if (isset($_GET['pid'])) {
		$pid = $_GET['pid'];
		$ownertype = $_GET['ownertype'];
		$arr = array();
		
		if ($ownertype == 'player'){
			$rs = mysql_query("
				SELECT sn_players.NickName AS uniname 
				FROM sn_players
				WHERE sn_players.ID_PLAYER = $pid
			");		
		}
		if ($ownertype == 'group'){
			$rs = mysql_query("
				SELECT sn_groups.Groupname AS uniname
				FROM sn_groups
				WHERE sn_groups.ID_GROUP = $pid
			");		
		}
		
			while($obj = mysql_fetch_object($rs)) {
				$arr[] = $obj;
			}
			$response = '{"ownername":'.json_encode($arr).'}';
			echo $response;			 
		};
	
	break;
	
	case 'GetGeneralOptions':
			$data = array();
			
			$optgame = array();
			$rs = mysql_query("
				SELECT sn_games.ID_GAME, sn_games.GameName
				FROM sn_games
			");			
			while($obj = mysql_fetch_object($rs)) {
				$optgame[] = $obj;
			}
			$data['game'] = $optgame;
			
			$optregion = array();
			$rs = mysql_query("
			SELECT es_regions.RegionName, es_regions.ID_REGION
			FROM es_regions
			");			
			while($obj = mysql_fetch_object($rs)) {
				$optregion[] = $obj;
			}
			$data['region'] = $optregion;
			
			$optlang = array();
			$rs = mysql_query("
			SELECT ge_languages.EnglishName, ge_languages.ID_LANGUAGE
			FROM ge_languages
			");			
			while($obj = mysql_fetch_object($rs)) {
				$optlang[] = $obj;
			}
			$data['language'] = $optlang;
		
			$response = json_encode($data);
			echo $response;
	break;	
		
	
	case 'GetOptionsByGame':			//get options for notice creation per game id
		if (isset($_GET['game'])) {
			$gameid = $_GET['game'];
			$data = array();
			
			$optgplvl = array();
			$rs = mysql_query("
				SELECT sn_grouptypes.ID_GROUPTYPE,
				sn_grouptypes.GroupTypeName
				FROM sn_grouptypes, sn_gamelevel_rel
				WHERE sn_gamelevel_rel.FK_GAME = '$gameid'
				AND sn_grouptypes.ID_GROUPTYPE = sn_gamelevel_rel.FK_GROUPTYPE
			");			
			while($obj = mysql_fetch_object($rs)) {
				$optgplvl[] = $obj;
			}
			$data['gplvl'] = $optgplvl;
			
			$optgpmode = array();
			$rs = mysql_query("
				SELECT sn_grouptypes.ID_GROUPTYPE,
				sn_grouptypes.GroupTypeName
				FROM sn_grouptypes, sn_gamemode_rel
				WHERE sn_gamemode_rel.FK_GAME = '$gameid'
				AND sn_grouptypes.ID_GROUPTYPE = sn_gamemode_rel.FK_GROUPTYPE
			");			
			while($obj = mysql_fetch_object($rs)) {
			$optgpmode[] = $obj;
			}
			$data['gpmode'] = $optgpmode;
			
			$optfaction = array();
			$rs = mysql_query("
			SELECT sn_factions.ID_FACTION,
			sn_factions.name
			FROM sn_factions, sn_gamefaction_rel
			WHERE sn_gamefaction_rel.FK_GAME = '$gameid'
			AND sn_factions.ID_FACTION = sn_gamefaction_rel.FK_FACTION
			");			
			while($obj = mysql_fetch_object($rs)) {
				$optfaction[] = $obj;
			}
			$data['faction'] = $optfaction;		
			
			$optserver = array();
			$rs = mysql_query("
			SELECT sn_servers.name, sn_servers.ID_SERVER
			FROM sn_gameservers_rel, sn_servers
			WHERE sn_servers.ID_SERVER = sn_gameservers_rel.FK_SERVER
			AND sn_gameservers_rel.FK_GAME = '$gameid'
			");			
			while($obj = mysql_fetch_object($rs)) {
				$optserver[] = $obj;
			}
			$data['server'] = $optserver;

			$optrole = array();
			$rs = mysql_query("
			SELECT sn_roles.name, sn_roles.ID_ROLE
			FROM sn_gamerole_rel, sn_roles
			WHERE sn_roles.ID_ROLE = sn_gamerole_rel.FK_ROLE
			AND sn_gamerole_rel.FK_GAME = '$gameid'
			");			
			while($obj = mysql_fetch_object($rs)) {
				$optrole[] = $obj;
			}
			$data['role'] = $optrole;
			
			$response = json_encode($data);
			echo $response;
			}
	break;	
	
/*	case 'Getoptionsgrouptypes':
	if (isset($_GET['grouptype'])) {
			$grouptype = $_GET['grouptype'];
			$arr = array();
			$rs = mysql_query("
				SELECT sn_grouptypes.ID_GROUPTYPE, sn_grouptypes.GroupTypeName
				FROM sn_grouptypes 
				WHERE sn_grouptypes.Subtype = '$grouptype'
			");			
			while($obj = mysql_fetch_object($rs)) {
				$arr[] = $obj;
			}
			$response = '{"notices":'.json_encode($arr).'}';
			echo $response;
			
		};	
	break;*/
	
	case 'Disable':
		if (isset($_GET['nid'])) {
			$nid = $_GET['nid'];
			mysql_query("UPDATE rc_notices SET IsActive = 0 WHERE ID_NOTICE = $nid") or die(mysql_error());  
		};
	break;

	case 'Enable':
		if (isset($_GET['nid'])) {
			$nid = $_GET['nid'];
			mysql_query("UPDATE rc_notices SET IsActive = 1 WHERE ID_NOTICE = $nid") or die(mysql_error());
			}
	break;		
	
	case 'Updatedetails':
		if (isset($_GET['nid']) && isset($_GET['details']) ) {
			$nid = $_GET['nid'];
			$details = $_GET['details'];			
			mysql_query("UPDATE rc_notices SET Details = '$details' WHERE ID_NOTICE = $nid") or die(mysql_error());
			}
	break;	

	case 'Remove':
		if (isset($_GET['nid'])) {
			$nid = $_GET['nid'];
			mysql_query("DELETE FROM rc_notices WHERE ID_NOTICE = $nid") or die(mysql_error());  
			//todo: slet responses til deleted notice.      
			//consideration: deletion permanent, cannot remake. employ fake delete via isactive attribute?
			//flipside: playnation site aims for large scale, freeing up space may be best.
		}
	break;
	
	default:
	if (isset($_GET['action']) && isset($_GET['owner']) && isset($_GET['owntype']) ) 
	{ 
	
		$owntype = $_GET['owntype'];
		$isactive = '1';
		$owner = $_GET['owner'];
		
		$region = $_GET['region'];
		$language = $_GET['language'];
		$game = $_GET['game'];
		$server = $_GET['server'];
		$faction = $_GET['faction'];
		$gplvl = $_GET['gplvl'];
		$gpmode = $_GET['gpmode'];
		$role = $_GET['role'];
		$details = $_GET['details'];
		$ingamename = $_GET['ingamename'];	
		
		
		switch($action)
		{
		case 'Create':	
		$response = "success";		
			mysql_query("INSERT INTO rc_notices(OwnerType, IsActive, FK_OWNER, FK_REGION, FK_LANGUAGE, FK_GAME, FK_SERVER, FK_FACTION, FK_GAMEPLAYLVL, FK_GAMEPLAYMODE, FK_ROLE, Details, InGameHandle) 
			VALUES('$owntype','$isactive','$owner','$region','$language','$game','$server','$faction','$gplvl','$gpmode','$role','$details','$ingamename')" ) or die(mysql_error());  
		break;
		
		case 'Update':	
				$response. "update";
			mysql_query("UPDATE rc_notices SET OwnerType = $owntype, IsActive = $isactive, FK_OWNER = $owner, FK_REGION = $region, FK_LANGUAGE = $language, 
			FK_GAME = $game, FK_SERVER = $server, FK_FACTION = $faction, FK_GAMEPLAYLVL = $gplvl, FK_GAMEPLAYMODE = $gpmode, FK_ROLE = $role, Details = $details, 
			InGameHandle = $ingamename WHERE ID_NOTICE = $nid") or die(mysql_error());
		break;
	
		}
		echo $response;
	}	
}
}	


	

?>