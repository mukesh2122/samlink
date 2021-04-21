<?php
	$super = true;
	include("inc/connect.php");

	if (isset($_SESSION["logetin"]))
	{
		if (isset($fjern))
		{
			$sql = "DELETE FROM ad_employeeskill_rel WHERE ID_EMPLOYEE = '$edit' AND ID_SKILL = '$fjern' "; // sletter

			mysql_query ($sql) or die (mysql_error()); 
			header ("location:index.php?admin=yea_my_master&&edit=". $edit ."");
		}

		if (isset($_POST["logout"])) // spørger om der er trykket på logout knappen
		{
			session_destroy(); // destruerer alle sessions hvilket vil sige at den session vi sætter når vi er logget ind ikke længere eksisterer
			header("location:" . $_SERVER['HTTP_REFERER']);
		}

		if (isset($tilfoj))
		{
			$sql = "INSERT INTO ad_employeeskill_rel (ID_EMPLOYEE,ID_SKILL,SkillLevel,AddDescription) VALUES ('$edit','".$_POST["select_skill"]."', '".$_POST["SKILL_LEVEL"]."','".$_POST["AddDescription"]."')"; // opretter
			mysql_query ($sql) or die (mysql_error()); 
			header('location:index.php?admin=yes_my_master&&edit='. $edit. '');
		}

		if (isset($_POST["no"]))
		{
			header("location:index.php?admin=yes_my_master");
		}

		if (isset($_POST["nexst_step"]) && !empty($_POST["JobTitle"]) && !empty($_POST["Phone"]) && !empty($_POST["Email"]) && !empty($_POST["Skype"]))
		{
			$sql3 = "SELECT * FROM ad_employees  order by ID_EMPLOYEE desc limit 1"; // henter alle billeder fra databasen 
			$result3 = mysql_query ($sql3) or die (mysql_error());	

			while ($row3 = mysql_fetch_assoc ($result3))// følgende skal ske 1 gang per celle du har i din database
			{ 
				$newid = $row3["ID_EMPLOYEE"] + 1;
			}

			echo $sql5 = "INSERT INTO ad_employees (EmployeeName,Phone,Email,Skype,JobTitle,active) VALUES ('". $_POST["EmployeeName"] ."','". $_POST["Phone"] ."','" . $_POST["Email"] . "','" . $_POST["Skype"] . "','" . $_POST["JobTitle"] . "', '1')"; // insert
			mysql_query ($sql5) or die (mysql_error());
			$nexst_step = "nexst_step";
			header ("location:index.php?admin=yea_my_master&&newid=". $newid ."");
		}
		else
		{
			if (isset($_POST["nexst_step"]) && empty($_POST["JobTitle"]) && empty($_POST["Phone"]) && empty($_POST["Email"]) && empty($_POST["Skype"]))
			{
				header ("location:index.php?admin=yea_my_master&&yell=you_miss_the_point_you_need_to_fill_it_out");
			}
		}

		if(isset($_POST["yes"]))
		{
			$sql1 = "UPDATE ad_employees SET active ='2' WHERE ID_EMPLOYEE = $delete";
			mysql_query ($sql1) or die (mysql_error());+
			$sql2 = "UPDATE ad_employeeskill_rel SET active ='2' WHERE ID_EMPLOYEE = $delete";
			mysql_query ($sql2) or die (mysql_error());
			header ("location:index.php?admin=yea_my_master");
		}

		if(isset($_POST["nyskill"]) && !empty($_POST["addskill"]))
		{
			$sql = "INSERT INTO ad_skills (SkillName) VALUES ('".$_POST["addskill"]."')";
			mysql_query ($sql) or die (mysql_error());
			header("location:index.php?admin=yes_my_master&&edit=". $edit. "");
		}
	}
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	<title>Playnation Employee</title>
	<link href="style.css" rel="stylesheet" type="text/css" />
	<link rel="shortcut icon" href="http://localhost:8888/beta/favicon.ico" type="image/ico" />
</head>

<body>
<?php 
	if(isset($_SESSION["logetin"]))
	{
		if (isset($_GET["yell"]))
		{
			echo "<h1>you_miss_the_point_you_need_to_fill_it_out</h1>";
		}
		if (isset($edit) or isset($newid))
		{
?>
	<div id="bick_and_black"><a class="colse" href="index.php?admin=yes_my_master"> X</a>
		<div id="warpper_edit">
<?php include("inc/edit.php"); ?>
		</div>
	</div>
<?php
		}
		if (isset($delete))
		{
?>
	<div id="bick_and_black">
		<div id="are_you_sure">
<?php include("inc/delete.php"); ?>
		</div>
	</div>
<?php
		}
		if (isset($_POST["Add_Employee"]))
		{
?>
	<div id="bick_and_black">
		<div id="warpper_edit">
<?php include("inc/add_employee.php"); ?>
		</div>
	</div>
<?php
		}
	}
?>
	<div id="banner">
		<a href="index.php?admin=yes_my_master">
			<div id="banner_img">
			</div>
		</a>
	</div>
	<div id="warpper">
		<form action="" method="post">
			<table width="1024" border="0">
				<tr>
					<td width="49">&nbsp;</td>
					<td width="938">
						<input name="sogefelt" id="sogefelt" type="text" />
						<input name="sog" id="sog" type="submit" value="søg" />
					</td>
				</tr>
				<tr>
					<td></td>
					<td>
						<select name="skill" id="skill">
							<option value="0">no skill selectet</option>
<?php 
	$sql = "SELECT * FROM ad_skills"; // henter alle billeder fra databasen
	$result = mysql_query ($sql);	

	while ($row = mysql_fetch_assoc ($result))// følgende skal ske 1 gang per celle du har i din database
	{
?>
							<option value=" <?php echo $row["ID_SKILL"] ?>"> <?php echo $row["SkillName"] ; ?> </option>
<?php
	}
?>
						</select>
<?php
	if (isset($admin) == "yes_my_master")
	{
		include("inc/login.php");
		if (isset($_SESSION["logetin"]))
		{
?>
<?php
		}
	}
?>
					</td>
				</tr>
			</table>
		</form>
<?php
	$skill = (isset($_POST) && array_key_exists('skill', $_POST)) ? $_POST["skill"] : "0";
	if(!empty($_POST["sogefelt"]))
	{
		$string = $_POST["sogefelt"]; 
?>
		results for <?php echo $string; ?>...<br/><hr/>
<?php
	}
?>
		<div id="relsult">
<?php
	$sog = (isset($_POST) && array_key_exists('sog', $_POST)) ? true : false;
	if($sog != true and $skill == 0)
	{
		$sql1 = "SELECT * FROM ad_employees WHERE active = 1";
	}
	else
	{
 		$sql1 = "SELECT ad_employees.* FROM ad_employees INNER JOIN ad_employeeskill_rel ON ad_employees.ID_EMPLOYEE = ad_employeeskill_rel.ID_EMPLOYEE WHERE ad_employeeskill_rel.ID_SKILL = $skill and ad_employees.active = 1"; // skal kunne søge på 2 navne så den skal hente både henrik og mig hvis man søger på henrik mikkel
	}

	if(!empty($string) and isset($_post["skill"]) == 0)
	{
		$string_parts = explode(" ", $string);
		$sql1 = "SELECT * FROM ad_employees Where ";
		foreach($string_parts as $key=>$part)
		{
			if ($key > 0)
				$sql1 .= " or ";
			$sql1 .= "EmployeeName like '%".$part."%' or JobTitle like '%".$part."%' or Skype like '%".$part."%' or Email like '%".$part."%' "; // skal kunne søge på 2 navne så den skal hente både henrik og mig hvis man søger på henrik mikkel
		}
	}
	$result1 = mysql_query ($sql1);	

	while ($row1 = mysql_fetch_assoc ($result1))// følgende skal ske 1 gang per celle du har i din database
	{
		if ($row1["active"] == 1)
		{
?>
		<table width="895" border="0">
			<tr>
				<td width="64">Name :</td>
				<td width="620">
<?php
			echo $row1["EmployeeName"];
			if(isset($_SESSION["logetin"]))
			{
?>
					<form id="ed_buttens" action="" method="post">
						<a href="index.php?admin=yes_my_master&&edit=<?php echo $row1["ID_EMPLOYEE"] ; ?>">
							<input name="edit" type="button" value="Edit" />
						</a>
						<a href="index.php?admin=yes_my_master&&delete=<?php echo $row1["ID_EMPLOYEE"] ; ?>">
							<input name="delete" type="button" value="Delete" />
						</a>
					</form>
<?php
			}
?>
				</td>
				<td width="" rowspan="3">
					<img src="https://api.skype.com/users/<?php echo $row1["Skype"]; ?>/profile/avatar" />
				</td>
			</tr>
			<tr>
				<td>Job Title:</td>
				<td><?php echo $row1["JobTitle"]; ?></td>
			</tr>
			<tr>
				<td>Phone:</td>
				<td><?php echo $row1["Phone"]; ?></td>
			</tr>
			<tr>
				<td>E-mail:</td>
				<td><?php echo $row1["Email"]; ?></td>
			</tr>
			<tr>
				<td>Skype:</td>
				<td><?php echo $row1["Skype"]; ?></td>
			</tr>
		</table>
		<table width="600" border="1">
			<tr>
				<td width="150">Skills</td>
				<td width="150">Level</td>
				<td width="150">beskrivelse</td>
			</tr>
<?php 
			$sql3 = "SELECT * FROM ad_employeeskill_rel WHERE ID_EMPLOYEE = '".$row1["ID_EMPLOYEE"]."'"; // henter alle billeder fra databasen 
			$result3 = mysql_query ($sql3);	

			while ($row3 = mysql_fetch_assoc ($result3))// følgende skal ske 1 gang per celle du har i din database
			{
?>
			<tr>
				<td>
<?php
				$sql2 = "SELECT * FROM ad_skills WHERE ID_Skill = '".$row3["ID_SKILL"]."'"; // henter alle billeder fra databasen 
				$result2 = mysql_query ($sql2);	
	
				while ($row2 = mysql_fetch_assoc ($result2))// følgende skal ske 1 gang per celle du har i din database
				{
					echo $row2["SkillName"];
				}
?>
				</td>
				<td><?php echo $row3["SkillLevel"]; ?></td>
				<td width="300px"><?php echo $row3["AddDescription"]; ?></td>
			</tr>
<?php
			}
?>
		</table>
		<hr/>
<?php
		}
	}
?>
   
		</div>
	</div>

</body>
</html>