

<?php
if (isset($super)){
if (isset($_POST["don"])){

 
	


	$sql5 = "UPDATE ad_employees SET EmployeeName ='". $_POST["EmployeeName"] ."', Phone ='". $_POST["Phone"] ."', Email = '" . $_POST["Email"] . "', Skype = '" . $_POST["Skype"] . "' WHERE ID_EMPLOYEE ='". $edit ."'"; // opdatere
	mysql_query ($sql5) or die (mysql_error());
	$gotoindex = "index.php";
		
	}
	if (isset($newid)){
		echo "hey ";
	$sql1 = "SELECT * FROM ad_employees order by ID_EMPLOYEE DESC limit 1";	
	}else{

       	$sql1 = "SELECT * FROM ad_employees WHERE ID_EMPLOYEE = '". $edit ."'";
	}
        $result1 = mysql_query ($sql1) or die (mysql_error());    
	
	while ($row1 = mysql_fetch_assoc ($result1))// følgende skal ske 1 gang per celle du har i din database
	{
		
	 ?>
     <center><img src="https://api.skype.com/users/<?php echo $row1["Skype"]; ?>/profile/avatar" /></center><br/>
     <form action="index.php?admin=yes_my_master" method="post">
    <table class="edit" width="300" border="0">
  <tr>
    <td width="100">Name :</td>
    <td width="200"><input name="EmployeeName" type="text" value="<?php echo $row1["EmployeeName"]; if(isset($_SESSION["logetin"]))
		{?>"/>
			<form id="ed_buttens" action="" method="post">
            <input name="don" type="submit" value="don" />
            </form>
			<?php } ?></td>
  </tr>
  <tr>
    <td>Job Title:</td>
    <td><?php echo $row1["JobTitle"]; ?></td>
  </tr>
  <tr>
    <td>Phone:</td>
    <td><input name="Phone" type="text" value="<?php echo $row1["Phone"]; ?>"/></td>
  </tr>
  <tr>
    <td>E-mail:</td>
    <td><input name="Email" type="text" value="<?php echo $row1["Email"]; ?>"/></td>
  </tr>
  <tr>
    <td>Skype:</td>
    <td><input name="Skype" type="text" value="<?php echo $row1["Skype"]; ?>"/></td>
    </tr>
</table>
<table class="edit" width="500" border="1">
  <tr>
    <td width="140">Skills</td>
    <td width="100">Level</td>
     <td width="100">beskrivelse</td>
  </tr>
<?php 
	if (isset($newid)){
	}else{
  $sql3 = "SELECT * FROM ad_employeeskill_rel WHERE ID_EMPLOYEE = '".$row1["ID_EMPLOYEE"]."'"; // henter alle billeder fra databasen 
  
		$result3 = mysql_query ($sql3) or die (mysql_error());    
	
	while ($row3 = mysql_fetch_assoc ($result3))// følgende skal ske 1 gang per celle du har i din database
	{
        
  ?>
      <tr>
    <td>
	<?php   $sql2 = "SELECT * FROM ad_skills WHERE ID_Skill = '".$row3["ID_SKILL"]."'"; // henter alle billeder fra databasen 
		$result2 = mysql_query ($sql2) or die (mysql_error());    
	
	while ($row2 = mysql_fetch_assoc ($result2))// følgende skal ske 1 gang per celle du har i din database
	{
		echo $row2["SkillName"] ;
		
	}?></td>
    <td><?php echo $row3["SkillLevel"];
	if(isset($_SESSION["logetin"])) {
	?>
    <a href="index.php?index.php?admin=yes_my_master&&edit=<?php echo $edit ; ?>&&fjern=<?php echo $row3["ID_SKILL"];?>">delete</a>
 <?php 
	} ?></td> 
   <td width="100"><?php echo $row3["AddDescription"];?></td>
    <?php
	}
	}
	?>
  
</table>
<?php }
include("inc/til_skill.php");
?>
</form>
<?php } ?>