<input type="text" name="addskill" /><input type="submit" name="nyskill" value="tilføj skill"/>
<?php

if (isset($super)){
 if (isset($newid)){ 
$sql1 = "SELECT * FROM ad_employees order by ID_EMPLOYEE DESC limit 1";	

$result1 = mysql_query ($sql1) or die (mysql_error());    
	
	while ($row1 = mysql_fetch_assoc ($result1))// følgende skal ske 1 gang per celle du har i din database
	{
		
?>
        <form action="index.php?admin=yes_my_master&&edit=<?php echo $row1["ID_EMPLOYEE"] ; ?>&&tilfoj=<?php echo $_POST["select_skill"];?>" method="post"><select name="select_skill"><?php
	}
	  $sql7 = "SELECT * FROM ad_skills "; // henter alle billeder fra databasen 

} else { ?>
        <form action="index.php?admin=yes_my_master&&edit=<?php echo $edit ; ?>&&tilfoj=<?php echo $_POST["select_skill"];?>" method="post"><select name="select_skill"><?php

	  $sql7 = "SELECT * FROM ad_skills WHERE ad_skills.ID_SKILL NOT IN (SELECT ad_employeeskill_rel.ID_SKILL FROM ad_employeeskill_rel WHERE ID_EMPLOYEE = $edit)"; // henter alle billeder fra databasen 
	}
		$result7 = mysql_query ($sql7) or die (mysql_error());    
	while ($row = mysql_fetch_assoc ($result7))// følgende skal ske 1 gang per celle du har i din database
	{
		echo "<option value='" . $row["ID_SKILL"] . "'>".$row["SkillName"] . "</option>";
	}

?></select>
<select name="SKILL_LEVEL">
<option value="Beginner">Beginner</option>
<option value="Intermediate">Intermediate</option>
<option value="Advanced">Advanced</option>
<option value="Expert">Expert</option>
<option value="Ace">Ace</option>
</select>
<input type="text" name="AddDescription" id="AddDescription" value="AddDescription"/>
<input name="tilfoj" value="tilføj" type="submit" />
</form>
<?php } ?>