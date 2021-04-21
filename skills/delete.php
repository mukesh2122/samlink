<?php
if (isset($super)){
$sql = "SELECT * FROM ad_employees WHERE ID_EMPLOYEE = '$delete'"; // henter alle billeder fra databasen 
		$result = mysql_query ($sql) or die (mysql_error());    
	
	while ($row = mysql_fetch_assoc ($result))// følgende skal ske 1 gang per celle du har i din database
	{
echo "are you sure you want to delete <br/>" . $row["EmployeeName"] ."" ;
	}
?>
<form action="" method="post">
<input class="butten" name="yes" type="submit" value="yes">
<input class="butten" name="no" type="submit" value="no">

</form><?php } ?>