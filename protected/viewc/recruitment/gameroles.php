<?php

include("conn.php");

if (isset($_GET['action'])) { 
switch($_GET['action'])
  {
		case 'create':
			if (isset($_GET['game']) && isset($_GET['role'])) 
			{
				$gameRel = $_GET['game'];
				$roleRel = $_GET['role'];
				mysql_query("INSERT INTO sn_gamerole_rel(FK_GAME, FK_ROLE) VALUES('$gameRel', '$roleRel') ") 
					or die(mysql_error());  
			}
		break;
		
		case 'remove':
			if (isset($_GET['game']) && isset($_GET['role'])) 
			{
				$gameRel = $_GET['game'];
				$roleRel = $_GET['role'];
				mysql_query("DELETE FROM sn_gamerole_rel WHERE FK_GAME = $gameRel AND FK_ROLE = $roleRel") or die(mysql_error());  
			}
		break;
		
		case 'list':
			$arr = array();
			$rs = mysql_query("SELECT sn_gamerole_rel . * , 
			sn_roles.name as RoleName,
			sn_games.GameName
			FROM sn_gamerole_rel, sn_games, sn_roles
			WHERE sn_roles.ID_ROLE = sn_gamerole_rel.FK_ROLE
			AND sn_games.ID_GAME = sn_gamerole_rel.FK_GAME
			");
			while($obj = mysql_fetch_object($rs)) {
				$arr[] = $obj;
			}
			$response = '{"gamerolerels":'.json_encode($arr).'}';
			echo $response;
		break;
	}
}

	

?>