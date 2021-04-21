<?php

include("conn.php");

if (isset($_GET['action'])) { 
switch($_GET['action'])
  {
		case 'create':
			if (isset($_GET['game']) && isset($_GET['mode'])) 
			{
				$gameRel = $_GET['game'];
				$modeRel = $_GET['mode'];
				mysql_query("INSERT INTO sn_gamemode_rel(FK_GAME, FK_GROUPTYPE) VALUES('$gameRel', '$modeRel') ") 
					or die(mysql_error());  
			}
		break;
		
		case 'remove':
			if (isset($_GET['game']) && isset($_GET['mode'])) 
			{
				$gameRel = $_GET['game'];
				$modeRel = $_GET['mode'];
				mysql_query("DELETE FROM sn_gamemode_rel WHERE FK_GAME = $gameRel AND FK_GROUPTYPE = $modeRel") or die(mysql_error());  
			}
		break;
		
		case 'list':
			$arr = array();
			$rs = mysql_query("SELECT sn_gamemode_rel . * , 
			sn_grouptypes.GroupTypeName,
			sn_games.GameName
			FROM sn_gamemode_rel, sn_games, sn_grouptypes
			WHERE sn_grouptypes.ID_GROUPTYPE = sn_gamemode_rel.FK_GROUPTYPE
			AND sn_games.ID_GAME = sn_gamemode_rel.FK_GAME
			");
			while($obj = mysql_fetch_object($rs)) {
				$arr[] = $obj;
			}
			$response = '{"gamemodeRels":'.json_encode($arr).'}';
			echo $response;
		break;
	}
}

	

?>