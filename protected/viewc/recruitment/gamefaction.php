<?php

include("conn.php");

if (isset($_GET['action'])) { 
switch($_GET['action'])
  {
		case 'create':
			if (isset($_GET['game']) && isset($_GET['faction'])) 
			{
				$gameRel = $_GET['game'];
				$factionRel = $_GET['faction'];
				mysql_query("INSERT INTO sn_gamefaction_rel(FK_GAME, FK_FACTION) VALUES('$gameRel', '$factionRel') ") 
					or die(mysql_error());  
			}
		break;
		
		case 'remove':
			if (isset($_GET['game']) && isset($_GET['faction'])) 
			{
				$gameRel = $_GET['game'];
				$factionRel = $_GET['faction'];
				mysql_query("DELETE FROM sn_gamefaction_rel WHERE FK_GAME = $gameRel AND FK_FACTION = $factionRel") or die(mysql_error());  
			}
		break;
		
		case 'list':
			$arr = array();
			$rs = mysql_query("SELECT sn_gamefaction_rel . * , 
			sn_factions.name as FactionName,
			sn_games.GameName
			FROM sn_gamefaction_rel, sn_games, sn_factions
			WHERE sn_factions.ID_FACTION = sn_gamefaction_rel.FK_FACTION
			AND sn_games.ID_GAME = sn_gamefaction_rel.FK_GAME
			");
			while($obj = mysql_fetch_object($rs)) {
				$arr[] = $obj;
			}
			$response = '{"rels":'.json_encode($arr).'}';
			echo $response;
		break;
	}
}

	

?>