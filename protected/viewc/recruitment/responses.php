<?php

$link = mysql_pconnect("localhost", "root", "") or die("Could not connect");
mysql_select_db("playnation") or die("Could not select database");

if (isset($_GET['action'])) {
	switch($_GET['action'])
	{
	case 'create':	
		if (isset($_GET['noteid']) && isset($_GET['owner']) && isset($_GET['ownertype'])  
		&& isset($_GET['resdetails'])) 	
		{ 
		$noteid = $_GET['noteid'];
		$owner = $_GET['owner'];
		$ownertype = $_GET['ownertype'];
		$resdetails = $_GET['resdetails'];
		$resstat = 'waiting';
		$committer = $_GET['committer'];
		$commitdate = gmdate('j M Y H:i:s');
		$resdetails = "<br>". $commitdate. " ". $committer. " : ". $_GET['resdetails'];
						
		mysql_query("INSERT INTO rc_responses(FK_NOTICE, ID_OWNER, OwnerType, ResponseDetailsLog, ResponseStatus) VALUES('$noteid','$owner','$ownertype','$resdetails','$resstat')" ) or die(mysql_error());  
		}
		echo "create";
	break;

	case 'showrepliesplayer': //all replies related to player notice id  
		if (isset($_GET['noteid'])) {
			$noteid = $_GET['noteid'];
			
			$arr = array();
			$rs = mysql_query("
			
			SELECT ID_RESPONSE, FK_NOTICE, ID_OWNER, OwnerType, ResponseDetailsLog, ResponseStatus, sn_players.NickName 
			FROM rc_responses, sn_players 
			WHERE ID_OWNER = $noteid AND sn_players.ID_PLAYER = ID_OWNER			
			
			");						
			
			while($obj = mysql_fetch_object($rs)) {
				$arr[] = $obj;
			}
			$response = '{"replies":'.json_encode($arr).'}';
			echo $response;
			}
	break;	
	
	case 'showreplyplayer': //one per id, owned by a player
			$resid = $_GET['resid'];
			
			$arr = array();
			$rs = mysql_query("
			
			SELECT ID_RESPONSE, FK_NOTICE, ID_OWNER, OwnerType, ResponseDetailsLog, ResponseStatus, sn_players.NickName 
			FROM rc_responses, sn_players 
			WHERE ID_RESPONSE = $resid AND sn_players.ID_PLAYER = ID_OWNER			
			
			");						
			
			while($obj = mysql_fetch_object($rs)) {
				$arr[] = $obj;
			}
			$response = '{"replies":'.json_encode($arr).'}';
			echo $response;
	
	break;	
	
	
	//your head asplode
	case 'showreplysuni': 
		$noticeids = $_GET['noticeids'];
		
		$noticearray = explode(",", $noticeids);
		
		$firstnotice = array_shift($noticearray);
				
		$noticeORS = " WHERE (FK_NOTICE = $firstnotice ";
		
		foreach ($noticearray as $value) {
			$noticeORS.= " OR FK_NOTICE = $value ";
		}	
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
			SELECT ID_RESPONSE, FK_NOTICE, ID_OWNER, OwnerType, ResponseDetailsLog, ResponseStatus, 
			$ownertype_table.$ownertype_name AS OwnerName
			FROM rc_responses, $ownertype_table 
			$noticeORS ) AND $ownertype_table.$ownertype_ID = ID_OWNER
			AND rc_responses.OwnerType = '$ownertype'
			");		
			$response = $rs;
			
			while($obj = mysql_fetch_object($rs)) {
			$arr[] = $obj;
			}
			$response = '{"replies":'.json_encode($arr).'}';
			echo $response;
	break;
	
	case 'showreplyuni': //show one reply by any type of owner
		$responseid = $_GET['rid'];
		$ownertype= $_GET['ownertype'];
		
			$arr = array();
			$rs = mysql_query("
			
			SELECT ID_RESPONSE, ID_OWNER, OwnerType, ResponseDetailsLog, ResponseStatus, 
			$ownertype_table.$ownertype_name AS OwnerName
			FROM rc_responses, $ownertype_table 
			WHERE ID_RESPONSE = $responseid 
			AND $ownertype_table.$ownertype_ID = ID_OWNER			
			
			");		
			$response = $rs;
			
			while($obj = mysql_fetch_object($rs)) {
				$arr[] = $obj;
			}
			$response = '{"replies":'.json_encode($arr).'}';
			echo $response;
	break;
	
	
	case 'changestatus':  //owner/recipient can set
		if (isset($_GET['resstat'])) {
			$resid = $_GET['resid'];
			$resstat = $_GET['resstat'];
			
			//could add detail log of status changes
			
			mysql_query("UPDATE rc_responses SET ResponseStatus = '$resstat' WHERE ID_RESPONSE = $resid") or die(mysql_error());  
		}
	break;	

	case 'updatedetails':  //owner/recipient can set
		if (isset($_GET['resdetails']) && isset($_GET['committer'])) {
			$resid = $_GET['resid'];
			$committer = $_GET['committer'];
			$commitdate = gmdate('j M Y H:i:s');
			$resdetails = "<br />". $commitdate. "<br />". $committer. " <br /> said:". $_GET['resdetails'];
			mysql_query("UPDATE rc_responses SET ResponseDetailsLog = CONCAT(ResponseDetailsLog, '$resdetails') WHERE ID_RESPONSE = $resid") or die(mysql_error());  
		}
	break;
	
	}
}
?>