<?php

include("conn.php");

if (isset($_GET['action'])) { 
switch($_GET['action'])
  {
		case 'create':
			if (isset($_GET['name'])) 
			{
				$name = $_GET['name'];
				mysql_query("INSERT INTO sn_factions(name) VALUES('$name') ") or die(mysql_error());  
			}
		break;
		
		case 'remove':
			if (isset($_GET['id'])) 
			{
				$id = $_GET['id'];
				mysql_query("DELETE FROM sn_factions WHERE ID_FACTION = $id") or die(mysql_error());  
			}
		break;
		
		case 'update':
			if (isset($_GET['name'])) 
			{
				$name = $_GET['name'];
				$id = $_GET['id'];
				mysql_query("UPDATE sn_factions SET name='$name' WHERE ID_FACTION=$id") or die(mysql_error());  
			}
			
		break;
		
		case 'list':
			$arr = array();
			$rs = mysql_query("SELECT * FROM sn_factions");
			while($obj = mysql_fetch_object($rs)) {
				$arr[] = $obj;
			}
			$response = '{"factions":'.json_encode($arr).'}';
			echo $response;
		break;
	}
}

	

?>