<?php
if (isset($_POST['ID_PLAYER_DELETE']))
{
	//Delete admin relation

	if (isset($_POST['ID_LANGUAGE']) && $_POST['ID_PLAYER_DELETE']!="")
	{
		$ID_PLAYER = $_POST['ID_PLAYER_DELETE'];
		$ID_LANGUAGE = $_POST['ID_LANGUAGE'];
		$query = "DELETE FROM sy_translators WHERE ID_PLAYER=$ID_PLAYER AND ID_LANGUAGE=$ID_LANGUAGE";
		$rs = Doo::db()->query($query);
		DooUriRouter::redirect(MainHelper::site_url('admin/translate/editlanguage/id/'.$ID_LANGUAGE));
	}
}

?>

<?php
$complain = "";
if (isset($_POST['addlanguageadmin']))
{
	//Find possible player with this email and add him as translator for this language
	$email = $_POST['addlanguageadmin'];
	$queryPlayer = "SELECT * FROM sn_players WHERE EMail='$email'";
	$rsPlayer = Doo::db()->query($queryPlayer)->fetchall();
	if (isset($rsPlayer[0]))
	{
		$player = $rsPlayer[0];
		$ID_PLAYER = $player['ID_PLAYER'];
		$ID_LANGUAGE = $selected_language['ID_LANGUAGE'];

		//Avoid double translator entry
		$totalNum = (object) Doo::db()->fetchRow("SELECT COUNT(*) as cnt FROM sy_translators WHERE ID_PLAYER=$ID_PLAYER AND ID_LANGUAGE=$ID_LANGUAGE");
		if ($totalNum->cnt==0)
		{
			//Add translator to database
			$query = "INSERT INTO sy_translators (ID_PLAYER,ID_LANGUAGE,isEditor,Commission) VALUES ($ID_PLAYER,$ID_LANGUAGE,0,0)";
			$rs = Doo::db()->query($query);
			//Set usergroup for this player
			$query = "UPDATE sn_players SET ID_USERGROUP=17 WHERE ID_PLAYER=$ID_PLAYER";
			$rs = Doo::db()->query($query);
			DooUriRouter::redirect(MainHelper::site_url('admin/translate/editlanguage/id/'.$selected_language['ID_LANGUAGE']));
		}
		else
		{
			$complain = "<br/><br/><p>Translator already exists for this language</p>";
		}

	}
	
}
?>



<div class="standard_form" >
<form name="langform" method="post" action="<?php echo MainHelper::site_url('admin/translate/languages'); ?>">
	<input type="hidden" name="ID_LANGUAGE" id="ID_LANGUAGE" value="<?php echo $selected_language['ID_LANGUAGE']; ?>" />

	<div class="standard_form_header clearfix">
		<h1 class="pull_left"><?php echo 'Edit language'; ?></h1>
	</div>

	<div class="standard_form_elements clearfix">
		<div class="clearfix">
			<label for="A2"><?php echo 'Country code'; ?></label>
			<span>
				<input tabindex="1" id="A2" name="A2" type="text" value="<?php echo $selected_language['A2']; ?>" class="text_input" />
			</span>
		</div>

		<div class="clearfix">
			<label for="NativeName"><?php echo 'Native name'; ?></label>
			<span>
				<input tabindex="2" id="NativeName" name="NativeName" type="text" value="<?php echo $selected_language['NativeName']; ?>" class="text_input" />
			</span>
		</div>

		<div class="clearfix">
			<label for="EnglishName"><?php echo 'English name'; ?></label>
			<span>
				<input tabindex="3" id="EnglishName" name="EnglishName" type="text" value="<?php echo $selected_language['EnglishName']; ?>" class="text_input" />
			</span>
		</div>

		<div class="standard_form_checks clearfix">
			<label for="isEnabled"><?php echo 'Is enabled'; ?></label>
			<span>
				<div class="standard_form_checks_wrapper no-margin clearfix">
					<input class="dst" tabindex="5" id="isEnabled" name="isEnabled" type="checkbox" <?php if ($selected_language['isEnabled']=="1") echo "checked";?> class="text_input" />
				</div>
			</span>
		</div>

		
	</div>

</form>



<form name="langadminform"  method="post" action="<?php echo MainHelper::site_url('admin/translate/editlanguage/id/'.$selected_language['ID_LANGUAGE']); ?>">

	<input type="hidden" name="ID_LANGUAGE" id="ID_LANGUAGE" value="<?php echo $selected_language['ID_LANGUAGE']; ?>" />
	<input type="hidden" name="ID_PLAYER_DELETE" id="ID_PLAYER_DELETE" value="" />

	<div class="standard_form_header clearfix">
	</div>

	<div class="standard_form_elements clearfix">
		<label for="isEnabled"><?php echo 'Language admins'; ?></label>
		<span>
			<div class="standard_form_checks_wrapper no-margin clearfix">
				<table cellspacing="0" cellpadding="0" class="table table_bordered table_striped gradient_thead mt10">
					<thead>
						<tr>
							<th class="size_15 centered"><?php echo $this->__('Name');?></th>
							<th class="size_15 centered"><?php echo $this->__('Email');?></th>
							<th class="size_15 centered"><?php echo $this->__('Action');?></th>
						</tr>
					</thead>
					<tbody>
				<?php
					//List lang-admins for this language
					$query = "SELECT * FROM sy_translators WHERE ID_LANGUAGE={$selected_language['ID_LANGUAGE']}";
					$rstran = Doo::db()->query($query)->fetchall();
					foreach ($rstran as $tran)
					{
						$ID_PLAYER = $tran['ID_PLAYER'];
						$queryPlayer = "SELECT * FROM sn_players WHERE ID_PLAYER=$ID_PLAYER";
						$rsPlayer = Doo::db()->query($queryPlayer)->fetchall();
						if(isset($rsPlayer[0]))
						{
							$onclick = "ID_PLAYER_DELETE.value = '".$ID_PLAYER."';document.langadminform.submit();";
							$delete = '<a onclick="'.$onclick.'" href="#">Delete</a>';
							$player = $rsPlayer[0];
							echo "<tr><td>{$player['FirstName']} {$player['LastName']}</td><td>{$player['EMail']}</td><td>{$delete}</td></tr>";
						}
					}
			?>
					</tbody>
				</table>
			<?php echo $complain; ?>
			</div>
		</span>
	</div>

	<div class="standard_form_elements clearfix">
		<label for="addlanguageadmin"><?php echo 'Add by email'; ?></label>
		<span>
			<input tabindex="5" id="addlanguageadmin" name="addlanguageadmin" type="text" value="" class="text_input" />
		</span>
	</div>
	
	<div class="standard_form_elements clearfix">
		<input class="button button_auto light_blue pull_right" type="submit" value="<?php echo 'Add admin'; ?>" />
	</div>

		
</form>














	<div class="standard_form_footer clearfix">
		<input class="button button_auto light_blue pull_right" type="submit" value="<?php echo 'Save Settings'; ?>" 
		onclick="document.langform.submit()"/>
	</div>
</div>
<script type="text/javascript">loadCheckboxes();</script> 