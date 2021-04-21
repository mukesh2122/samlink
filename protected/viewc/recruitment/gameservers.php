<?php

include("conn.php");

if (isset($_GET['action'])) { 
switch($_GET['action'])
  {
		case 'create':
			if (isset($_GET['game']) && isset($_GET['server'])) 
			{
				$gameRel = $_GET['game'];
				$serverRel = $_GET['server'];
				mysql_query("INSERT INTO sn_gameservers_rel(FK_GAME, FK_SERVER) VALUES('$gameRel', '$serverRel') ") 
					or die(mysql_error());  
			}
		break;
		
		case 'remove':
			if (isset($_GET['game']) && isset($_GET['server'])) 
			{
				$gameRel = $_GET['game'];
				$serverRel = $_GET['server'];
				mysql_query("DELETE FROM sn_gameservers_rel WHERE FK_GAME = $gameRel AND FK_SERVER = $serverRel") or die(mysql_error());  
			}
		break;
		
		case 'list':
			$arr = array();
			$rs = mysql_query("SELECT sn_gameservers_rel . * , 
			sn_servers.name as ServerName,
			sn_games.GameName
			FROM sn_gameservers_rel, sn_games, sn_servers
			WHERE sn_servers.ID_SERVERS = sn_gameservers_rel.FK_SERVER
			AND sn_games.ID_GAME = sn_gameservers_rel.FK_GAME
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