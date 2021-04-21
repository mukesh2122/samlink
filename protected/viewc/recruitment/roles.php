<?php

include("conn.php");

if (isset($_GET['action'])) { 
switch($_GET['action'])
  {
		case 'create':
			if (isset($_GET['name'])) 
			{
				$name = $_GET['name'];
				mysql_query("INSERT INTO sn_roles(name) VALUES('$name') ") or die(mysql_error());  
			}
		break;
		
		case 'remove':
			if (isset($_GET['id'])) 
			{
				$id = $_GET['id'];
				mysql_query("DELETE FROM sn_roles WHERE ID_ROLE = $id") or die(mysql_error());  
			}
		break;
		
		case 'update':
			if (isset($_GET['name'])) 
			{
				$name = $_GET['name'];
				$id = $_GET['id'];
				mysql_query("UPDATE sn_roles SET name='$name' WHERE ID_ROLE=$id") or die(mysql_error());  
			}
			
		break;
		
		case 'list':
			$arr = array();
			$rs = mysql_query("SELECT * FROM sn_roles");
			while($obj = mysql_fetch_object($rs)) {
				$arr[] = $obj;
			}
			$response = '{"roles":'.json_encode($arr).'}';
			echo $response;
		break;
	}
}

	

?>