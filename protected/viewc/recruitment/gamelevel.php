<?php

include("conn.php");

if (isset($_GET['action'])) { 
switch($_GET['action'])
  {
		case 'create':
			if (isset($_GET['game']) && isset($_GET['level'])) 
			{
				$gameRel = $_GET['game'];
				$levelRel = $_GET['level'];
				mysql_query("INSERT INTO sn_gamelevel_rel(FK_GAME, FK_GROUPTYPE) VALUES('$gameRel', '$levelRel') ") 
					or die(mysql_error());  
			}
		break;
		
		case 'remove':
			if (isset($_GET['game']) && isset($_GET['level'])) 
			{
				$gameRel = $_GET['game'];
				$levelRel = $_GET['level'];
				mysql_query("DELETE FROM sn_gamelevel_rel WHERE FK_GAME = $gameRel AND FK_GROUPTYPE = $levelRel") or die(mysql_error());  
			}
		break;
		
		case 'list':
			$arr = array();
			$rs = mysql_query("SELECT sn_gamelevel_rel . * , 
			sn_grouptypes.GroupTypeName,
			sn_games.GameName
			FROM sn_gamelevel_rel, sn_games, sn_grouptypes
			WHERE sn_grouptypes.ID_GROUPTYPE = sn_gamelevel_rel.FK_GROUPTYPE
			AND sn_games.ID_GAME = sn_gamelevel_rel.FK_GAME
			");
			while($obj = mysql_fetch_object($rs)) {
				$arr[] = $obj;
			}
			$response = '{"gamelevelRels":'.json_encode($arr).'}';
			echo $response;
		break;
	}
}

	

?>