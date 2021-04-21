<?php
class MainHelper {
	public static function getSuspendQuery($pid)
	{
		//part of WHERE in query to determine if a user is invisible
		return " AND
			(	SELECT COUNT(*) FROM sn_playersuspend
				WHERE sn_playersuspend.ID_PLAYER={$pid}
				AND	sn_playersuspend.isHistory=0
				AND ( CURDATE()<=sn_playersuspend.EndDate OR sn_playersuspend.Level IN(4,5))
			)=0";
	}

	public static function GetDurdays($StartDate)
	{
		$dateToday = date("Y-m-d");
		$dStart = new DateTime($StartDate);
		$dEnd  = new DateTime($dateToday);

		$dDiff = $dStart->diff($dEnd);
		$dDiff->format('%R'); // use for point out relation: smaller/greater
		return $dDiff->days;
	}
	public static function GetRemainTime($EndDate)
	{
		$dateToday = date("Y:m:d H:i:s");
		$dStart = new DateTime($dateToday);
		$dEnd  = new DateTime($EndDate);
		$dDiff = $dStart->diff($dEnd);
		return $dDiff;
	}

	public static function GetNoProfileFunctionality($suspendLevel)
	{
		return ($suspendLevel==1 || $suspendLevel==2 || $suspendLevel==4 || $suspendLevel==5);
	}
	public static function GetNoSiteFunctionality($suspendLevel)
	{
		return ($suspendLevel==2 || $suspendLevel==4 || $suspendLevel==5);
	}

	public static function GetSuspendLevelText($l)
	{
		$a = array
		(
			'Active user',
			'No Profile Functionality',
			'Limited Access',
			'No Access',
			'Profile Deactivated By User',
			'Banned'
		);
		return $a[$l];
	}

	public static function FriendInCategories($ID_PLAYER,$ID_FRIEND)
	{
		$query = "SELECT *
			FROM sn_playerfriendcat,sn_playerfriendcat_rel
			WHERE sn_playerfriendcat.ID_PLAYER={$ID_PLAYER}
			AND sn_playerfriendcat_rel.ID_FRIEND={$ID_FRIEND}
			AND sn_playerfriendcat.ID_CAT=sn_playerfriendcat_rel.ID_CAT
			AND sn_playerfriendcat.ID_PLAYER=sn_playerfriendcat_rel.ID_PLAYER
			AND sn_playerfriendcat.Native IN (0,1)";

		return Doo::db()->query($query)->fetchall();
	}

	public static function IsFriendBlocked($ID_PLAYER,$ID_FRIEND)
	{
		$query = "SELECT COUNT(*) AS cnt FROM sn_playerfriendcat_rel
			RIGHT JOIN sn_playerfriendcat ON sn_playerfriendcat_rel.ID_CAT=sn_playerfriendcat.ID_CAT
			WHERE sn_playerfriendcat.ID_PLAYER={$ID_PLAYER}
			AND sn_playerfriendcat_rel.ID_PLAYER={$ID_PLAYER}
			AND sn_playerfriendcat_rel.ID_FRIEND={$ID_FRIEND}
			AND sn_playerfriendcat.Native=2";
		$o = (object) Doo::db()->fetchRow($query);
		//0 if not blocked, 1 if blocked
		return $o->cnt;
	}

	public static function InitFriendCategoriesAllPlayers()
	{
		//Creates all friend categories for all users as default
		//NOT TESTED YET..!
		$query = "DELETE FROM sn_playerfriendcat WHERE ID_PLAYER=$ID_PLAYER;
			DELETE FROM sn_playerfriendcat_rel WHERE ID_PLAYER=$ID_PLAYER;
			INSERT INTO sn_playerfriendcat
			(CategoryName,ID_PLAYER,Native,ID_CAT)
			SELECT sn_playerfriendcat.CategoryName,sn_players.ID_PLAYER,sn_playerfriendcat.Native,sn_playerfriendcat.ID_CAT
			FROM sn_playerfriendcat,sn_players
			GROUP BY ID_CAT,sn_players;";

		$rs = Doo::db()->query($query);
	}

	public static function DeleteFriendCategoriesPlayer($ID_PLAYER) {
		$query = "DELETE IGNORE FROM sn_playerfriendcat WHERE ID_PLAYER=$ID_PLAYER;
			DELETE IGNORE FROM sn_playerfriendcat_rel WHERE ID_PLAYER=$ID_PLAYER;";
		$rs = Doo::db()->query($query);
        return $rs;
    }

    public static function CreateFriendCategoriesPlayer($ID_PLAYER)
	{
		//Creates all friend categories for user as default
		$query = "DELETE FROM sn_playerfriendcat WHERE ID_PLAYER=$ID_PLAYER;
			DELETE FROM sn_playerfriendcat_rel WHERE ID_PLAYER=$ID_PLAYER;
			INSERT INTO sn_playerfriendcat
			(CategoryName,ID_PLAYER,Native,ID_CAT)
			SELECT sn_playerfriendcat.CategoryName,{$ID_PLAYER},sn_playerfriendcat.Native,sn_playerfriendcat.ID_CAT
			FROM sn_playerfriendcat
			WHERE sn_playerfriendcat.Native=1
			GROUP BY ID_CAT;";
		$rs = Doo::db()->query($query);
        return $rs;
	}


	public static function InitPrivacySettingsAllPlayers()
	{
		//Creates all privacy settings for all users as default
		$query = "DELETE FROM sn_playerprivacy_rel;
			INSERT INTO sn_playerprivacy_rel
			(ID_PLAYER,ID_PRIVSET,ID_TARGET,TargetType)
			SELECT ID_PLAYER,ID_PRIVSET,0,'friends' FROM sn_privacy,sn_players
			UNION
			SELECT ID_PLAYER,ID_PRIVSET,0,'others' FROM sn_privacy,sn_players
			UNION
			SELECT ID_PLAYER,ID_PRIVSET,ID_CATEGORY,'category' FROM sn_privacy,sy_categories,sn_players";

		$rs = Doo::db()->query($query);
	}

	public static function InitPersonalInfoAllPlayers()
	{
		//Creates all personal info for all users as default
		$query = "DELETE FROM sn_playerpinfo_rel;
			INSERT INTO sn_playerpinfo_rel
			(ID_PLAYER,FieldName)
			SELECT ID_PLAYER,'vcb_firstName' FROM sn_players
			UNION
			SELECT ID_PLAYER,'vcb_lastName' FROM sn_players
			UNION
			SELECT ID_PLAYER,'vcb_city' FROM sn_players
			UNION
			SELECT ID_PLAYER,'vcb_country' FROM sn_players
			UNION
			SELECT ID_PLAYER,'vcb_dob' FROM sn_players
			UNION
			SELECT ID_PLAYER,'vcb_playercategory' FROM sn_players
			UNION
			SELECT ID_PLAYER,CONCAT('vcb_extrafield_',ID_FIELD) FROM sn_entityextras,sn_players WHERE OwnerType='player';";

		$rs = Doo::db()->query($query);
	}

	public static function DeletePersonalInformation($ID_PLAYER) {
		//Delete all pInfo for user.
		$query ="DELETE IGNORE FROM sn_playerpinfo_rel WHERE ID_PLAYER=$ID_PLAYER;";
		$rs = Doo::db()->query($query);
        return $rs;
    }

    public static function CreatePersonalInformation($ID_PLAYER)
	{
		//Delete all pInfo for user.
		//And creates pInfo for: nativefields, extrafields and category for user
		$query ="DELETE FROM sn_playerpinfo_rel WHERE ID_PLAYER=$ID_PLAYER;
			INSERT INTO sn_playerpinfo_rel
			(ID_PLAYER,FieldName)
			SELECT $ID_PLAYER,'vcb_firstName'
			UNION
			SELECT $ID_PLAYER,'vcb_lastName'
			UNION
			SELECT $ID_PLAYER,'vcb_city'
			UNION
			SELECT $ID_PLAYER,'vcb_country'
			UNION
			SELECT $ID_PLAYER,'vcb_dob'
			UNION
			SELECT $ID_PLAYER,'vcb_playercategory'
			UNION
			SELECT $ID_PLAYER,CONCAT('vcb_extrafield_',ID_FIELD) FROM sn_entityextras WHERE OwnerType='player'";
		$rs = Doo::db()->query($query);
        return $rs;
	}
	public static function UpdatePersonalInfo($ID_PLAYER)
	{
		//Update personal information
		$rs = Doo::db()->query("DELETE FROM sn_playerpinfo_rel WHERE ID_PLAYER={$ID_PLAYER}");
		foreach($_POST as $pkey=>$pval)
		{
			$s = strpos($pkey,'vcb_');
			if ($s===0)
			{
				//echo "$FieldKey  ($pkey)<br/>";
				$query = "
					INSERT INTO sn_playerpinfo_rel
					(ID_PLAYER,FieldName) VALUES
					({$ID_PLAYER},'$pkey')";
				$rs = Doo::db()->query($query);
			}
		}
	}
	public static function GetPersonalInformation($ID_PLAYER)
	{
		$rs = Doo::db()->query("SELECT * FROM sn_playerpinfo_rel WHERE ID_PLAYER={$ID_PLAYER}")->fetchall();
		$a = array();
		foreach ($rs as $r)
			$a[] = $r['FieldName'];
		return $a;
	}

	public static function countMedias($game)
	{
		$games = new Games();
		$mediasVideo = $games->getMedias($game->ID_GAME, MEDIA_VIDEO);
		$mediasScreenshot = $games->getMedias($game->ID_GAME, MEDIA_SCREENSHOT);
		$mediasConceptart = $games->getMedias($game->ID_GAME, MEDIA_CONCEPTART);
		$mediasWallpaper = $games->getMedias($game->ID_GAME, MEDIA_WALLPAPER);
		$mediasDownload = $games->getFiletypes($game->ID_GAME);

		$countMedia =
			(count($mediasVideo)>0) +
			(count($mediasScreenshot)>0) +
			(count($mediasConceptart)>0) +
			(count($mediasWallpaper)>0)+
			(count($mediasDownload)>0);
		return $countMedia;
	}

	public static function countCompanyMedias($company)
	{
		$companies = new Companies();
		$mediasVideo = $companies->getMedias($company->ID_COMPANY, MEDIA_VIDEO);
		$mediasScreenshot = $companies->getMedias($company->ID_COMPANY, MEDIA_SCREENSHOT);
		$mediasConceptart = $companies->getMedias($company->ID_COMPANY, MEDIA_CONCEPTART);
		$mediasWallpaper = $companies->getMedias($company->ID_COMPANY, MEDIA_WALLPAPER);
		$mediasChannel = $companies->getMedias($company->ID_COMPANY, MEDIA_CHANNEL);
		$mediasDownload = $companies->getFiletypes($company->ID_COMPANY);

		$countMedia =
			(count($mediasVideo)>0) +
			(count($mediasScreenshot)>0) +
			(count($mediasConceptart)>0) +
			(count($mediasWallpaper)>0) +
			(count($mediasDownload)>0) +
			(count($mediasChannel)>0);
		return $countMedia;
	}


	public static function GetFirstChoiceLanguage()
	{
		$query = "SELECT LOWER(A2) as A2 from sy_settings
			LEFT JOIN ge_languages ON ge_languages.ID_LANGUAGE=sy_settings.valueInt
			WHERE sy_settings.ID_SETTING='isFirstChoiceLang'";
		Doo::db()->query($query);
		$p = (object) Doo::db()->fetchRow($query);
		return $p->A2;
	}

	public static function GetSetting($ID_SETTING, $SettingType, $SettingDefault = 'none')
	{
		$query = "SELECT $SettingType FROM sy_settings WHERE ID_SETTING ='$ID_SETTING'";

		Doo::db()->query($query);
		$p = (object) Doo::db()->fetchRow($query);
		if (isset($p->$SettingType))
			return $p->$SettingType;
		if (isset($SettingDefault) && $SettingDefault != 'none')
			return $SettingDefault;
		return FALSE;
	}

	public static function ApproveOwner($ID_OWNER,$ID_APPROVER)
	{
		$player = User::getUser();
		$query = "UPDATE sn_playercategory_rel SET Approved=1,ID_APPROVER=$ID_APPROVER WHERE ID_OWNER=$ID_OWNER";
		Doo::db()->query($query);
	}

	public static function IsPlayerApproved($ID_OWNER)
	{
		//Returns "1" if owner is not approved when his category requires it
		$query = "
			SELECT (Approved = 1 OR Approved IS NULL OR MBA_enabled=0) as isApproved,
				sn_players.ID_PLAYER, sy_categories.*, sn_playercategory_rel.*, sn_players.FirstName, sn_players.LastName
			FROM sn_players
			LEFT JOIN sn_playercategory_rel
			ON sn_players.ID_PLAYER=sn_playercategory_rel.ID_OWNER
			LEFT JOIN sy_categories
			ON sy_categories.ID_CATEGORY=sn_playercategory_rel.ID_CATEGORY
			WHERE ID_PLAYER = $ID_OWNER";

		$p = (object) Doo::db()->fetchRow($query);
		return $p->isApproved;
	}


	public static function GetPlayerCategories($OwnerType)
	{
		$query = "SELECT *
			FROM sy_categories
			WHERE OwnerType='$OwnerType'";
		return Doo::db()->query($query)->fetchall();
	}

	public static function GetPlayersCategory($ID_PLAYER)
	{
		$query = "SELECT *
			FROM sn_playercategory_rel
			WHERE ID_OWNER=$ID_PLAYER";
		$rs = Doo::db()->query($query)->fetchall();
		if (isset($rs[0]))
			return $rs[0]['ID_CATEGORY'];

		return null;
	}

	public static function GetPlayersCategoryName($ID_PLAYER)
	{
		$query = "SELECT sy_categories.CategoryName
			FROM sy_categories,sn_playercategory_rel
			WHERE ID_OWNER=$ID_PLAYER
			AND sy_categories.ID_CATEGORY=sn_playercategory_rel.ID_CATEGORY";
		$rs = Doo::db()->query($query)->fetchall();
		if (isset($rs[0]))
			return $rs[0]['CategoryName'];

		return null;
	}

	public static function WhoApprovedMe($ID_PLAYER)
	{
		$query = "SELECT *
			FROM sn_playercategory_rel
			LEFT JOIN sn_players
			ON sn_playercategory_rel.ID_APPROVER=sn_players.ID_PLAYER
			WHERE ID_OWNER=$ID_PLAYER
			AND ID_PLAYER <> 0";
		$rs = Doo::db()->query($query)->fetchall();
		if (isset($rs[0]))
			return $rs[0];

		return null;
	}

	public static function RenderCategories($categories,$that,$style,$ID_PLAYER)
	{
		$selected_category = self::GetPlayersCategory($ID_PLAYER);
		?>
		<div class="clearfix">
			<label for="category"><?php echo $that->__('Category'); ?></label>
			<div class="clearfix di">
				<select id="playercategory" class="dropkick_lightWide" name="playercategory">
					<?php $categories = MainHelper::GetPlayerCategories('player'); ?>
					<?php foreach ($categories as $category): ?>
						<option value="<?php echo $category['ID_CATEGORY']; ?>" <?php echo ($selected_category==$category['ID_CATEGORY'])?'selected="selected"':""; ?> >
							<?php echo $category['CategoryName']; ?>
						</option>
					<?php endforeach; ?>
				</select>
			</div>
		</div>
		<?php
	}

	public static function RenderExtrafields($extrafields,$that,$style)
	{
		$outerClass = "clearfix";
		$textClass = "text_input";
		$boolClass = "standard_form_checks_wrapper";
		$inputStart = "<span>";
		$inputEnd = "</span>";
		$dataIStart = "";
		$dataIEnd = "";
		if ($style=="popupedit")
		{
			$outerClass = "mt5";
			$textClass = "w576 news_border company_url";
			$boolClass = "";
			$inputStart = '<div class="border mt2">';
			$inputEnd = "</div>";
			$dataIStart = '<div class="border mt2">';
			$dataIEnd = "</div>";
		}
/*
		<div class="mt5">
			<label for="companyUrl" class="cp"><?php echo $this->__('Company Url');?></label>
			<div class="border mt2">
				<input name="company_url" class="w576 news_border company_url" id="companyUrl" value="<?php echo $company->URL; ?>" />
			</div>
		</div>
*/

	//Show possible extrafields
		foreach ($extrafields as $extrafield)
		{
			?>
			<?php
			$name = "extrafield_".$extrafield['ID_FIELD'];
			switch ($extrafield['FieldType'])
			{
				case "text":
					?>
					<div class="<?php echo $outerClass; ?>">
						<label for="phone"><?php echo $extrafield['FieldName']; ?></label>
						<?php echo $inputStart; ?>
							<input id="<?php echo $name; ?>" name="<?php echo $name; ?>" type="text" value="<?php echo $extrafield['ValueText']; ?>" class="<?php echo $textClass; ?>">
						<?php echo $inputEnd; ?>
					</div><?php
					break;
				case "integer":
					?>
					<div class="<?php echo $outerClass; ?>">
						<label for="phone"><?php echo $extrafield['FieldName']; ?></label>
						<?php echo $inputStart; ?>
							<input id="<?php echo $name; ?>" name="<?php echo $name; ?>" type="text" value="<?php echo $extrafield['ValueInt']; ?>" class="<?php echo $textClass; ?>">
						<?php echo $inputEnd; ?>
					</div><?php
					break;
				case "boolean":
					?>
					<div class="standard_form_checks clearfix">
						<label><?php echo $extrafield['FieldName']; ?></label>
						<?php echo $dataIStart; ?>
						<div class="di">
							<div class="<?php echo $boolClass; ?> no-margin clearfix">
								<input class="dst" type="checkbox" id="<?php echo $name; ?>" name="<?php echo $name; ?>" value="1" <?php echo $extrafield['ValueBoolean'] == 1 ? 'checked="checked"' : ''; ?>>
								<label for="<?php echo $name; ?>"><?php echo $that->__('Yes'); ?></label>
							</div>
						</div>
						<?php echo $dataIEnd; ?>
					</div><?php
					break;
				case "date":
					?>
					<div class="standard_form_dob clearfix">
						<label for="dob"><?php echo $extrafield['FieldName']; ?></label>
						<?php echo $dataIStart; ?>
						<div class="di">
							<select id="<?php echo $name; ?>_Year" class="dropkick_lightNarrow" name="<?php echo $name; ?>_year" tabindex="6">
								<?php $years = MainHelper::getYears(); ?>
								<?php foreach ($years as $c => $v): ?>
									<option value="<?php echo $c; ?>" <?php echo (MainHelper::isYearSelected($extrafield['ValueDate'], $v)) ? 'selected="selected"' : ''; ?>>
										<?php echo $v; ?>
									</option>
								<?php endforeach; ?>
							</select>
						</div>

						<div class="di">
							<select id="<?php echo $name; ?>_Month" class="dropkick_lightNarrow" name="<?php echo $name; ?>_month" tabindex="7">
								<?php $months = MainHelper::getMonthList(); ?>
								<?php foreach ($months as $c => $v): ?>
									<option value="<?php echo $c; ?>" <?php echo (MainHelper::isMonthSelected($extrafield['ValueDate'], $c)) ? 'selected="selected"' : ''; ?>>
										<?php echo $v; ?>
									</option>
								<?php endforeach; ?>
							</select>
						</div>

						<div class="di">
							<select id="<?php echo $name; ?>_Day" class="dropkick_lightNarrow" name="<?php echo $name; ?>_day" tabindex="8">
								<?php $days = MainHelper::getDays(); ?>
								<?php foreach ($days as $c => $v): ?>
									<option value="<?php echo $c; ?>" <?php echo (MainHelper::isDaySelected($extrafield['ValueDate'], $v)) ? 'selected="selected"' : ''; ?>>
										<?php echo $v; ?>
									</option>
								<?php endforeach; ?>
							</select>
						</div>
						<?php echo $dataIEnd; ?>
					</div><?php
					break;
				case "timestamp":
					?>
					<div class="<?php echo $outerClass; ?>">
						<label for="phone"><?php echo $extrafield['FieldName']; ?></label>
						<?php echo $inputStart; ?>
							<input id="<?php echo $name; ?>" name="<?php echo $name; ?>" type="text" value="<?php echo $extrafield['ValueTimestamp']; ?>" class="<?php echo $textClass; ?>">
						<?php echo $inputEnd; ?>
					</div><?php
					break;
			}
		}
	}



	public static function GetFieldTablenameByOwner($OwnerType)
	{
		switch ($OwnerType)
		{
			case 'player':
				return "sn_playersextra_rel";
			case 'company':
				return "sn_companiesextra_rel";
			case 'game':
				return "sn_gamesextra_rel";
			case 'group':
				return "sn_groupsextra_rel";
			default:
				return "sn_playersextra_rel";
		}
		return "sn_playersextra_rel";
	}

	public static function GetExtraFieldsByOwnertype($OwnerType,$ID_OWNER=null)
	{
		if ($ID_OWNER!=null)
		{
			//Fieldnames and their data
			$tablename = self::GetFieldTablenameByOwner($OwnerType);
			$query = "SELECT sn_entityextras.* ,
				$tablename.ID_OWNER,
				$tablename.ValueText,
				$tablename.ValueInt,
				$tablename.ValueBoolean,
				$tablename.ValueDate,
				$tablename.ValueTimestamp
				FROM sn_entityextras
				LEFT JOIN $tablename
				ON sn_entityextras.ID_FIELD = $tablename.ID_FIELD
				AND $tablename.ID_OWNER=$ID_OWNER
				WHERE OwnerType='$OwnerType'
				ORDER BY sn_entityextras.Priority";
		}
		else
		{
			//Only field names
			$query = "SELECT sn_entityextras.*,
				'' as ValueText,
				0 as ValueInt,
				0 as ValueBoolean,
				'' as ValueDate,
				'' as ValueTimestamp
				FROM sn_entityextras
				WHERE OwnerType='$OwnerType'
				ORDER BY sn_entityextras.Priority";
		}

		return Doo::db()->query($query)->fetchall();
	}

	public static function UpdateExtrafieldsByPOST($OwnerType,$ID_OWNER)
	{
		//Update edited extrafields
		$extrafields = MainHelper::GetExtraFieldsByOwnertype($OwnerType,$ID_OWNER);
		foreach ($extrafields as $extrafield)
		{
			$name = "extrafield_{$extrafield['ID_FIELD']}";

			if (isset($_POST[$name."_year"]) and isset($_POST[$name."_month"]) and isset($_POST[$name."_day"]))
			{
				$year = $_POST[$name."_year"];
				$month = $_POST[$name."_month"];
				$day = $_POST[$name."_day"];
				$y = '0000';
				$m = '00';
				$d = '00';
				if ($year > 0)
					$y = intval($year);
				if ($month > 0)
					$m = intval($month);
				if ($day > 0)
					$d = intval($day);

				$date = $y . '-' . $m . '-' . $d;
				MainHelper::UpdateExtraField($extrafield['ID_FIELD'], $ID_OWNER, $date, $OwnerType);
			}
			else
			{
				if (isset($_POST[$name]))
				{
					MainHelper::UpdateExtraField($extrafield['ID_FIELD'], $ID_OWNER, $_POST[$name], $OwnerType);
				}
				else
				{
					MainHelper::UpdateExtraField($extrafield['ID_FIELD'], $ID_OWNER, "", $OwnerType);
				}
			}
		}
	}

	public static function GetExtraFieldByFieldName($OwnerType,$FieldName) {
		//Only field names
		$query = "SELECT sn_entityextras.*,
		'' as ValueText,
		0 as ValueInt,
		0 as ValueBoolean,
		'' as ValueDate,
		'' as ValueTimestamp
		FROM sn_entityextras
		WHERE OwnerType='$OwnerType' AND FieldName = '$FieldName'
		ORDER BY sn_entityextras.Priority";

		return Doo::db()->query($query)->fetchall();
	}

	public static function UpdateExtraField($ID_FIELD, $ID_OWNER, $value, $OwnerType) {
		$tmpValue = $value;
		$tablename = self::GetFieldTablenameByOwner($OwnerType);

		$query = "SELECT COUNT(*) as cnt FROM $tablename WHERE ID_FIELD={$ID_FIELD} AND ID_OWNER={$ID_OWNER}";
		$totalNum = (object) Doo::db()->fetchRow($query);

		if ($totalNum->cnt === 0)
		{
			//Insert as new entry
			$query = "INSERT INTO $tablename (ID_FIELD,ID_OWNER,
				ValueText,
				ValueInt,
				ValueBoolean,
				ValueDate,
				ValueTimestamp
				) VALUES
				({$ID_FIELD},{$ID_OWNER},'{$tmpValue}','{$tmpValue}','{$tmpValue}','{$tmpValue}','{$tmpValue}')";
			Doo::db()->query($query);
		}
		else
		{
			//Update entry
			$query = "UPDATE $tablename SET
				ValueText='{$value}',
				ValueInt='{$value}',
				ValueBoolean='{$value}',
				ValueDate='{$value}',
				ValueTimestamp='{$value}'
				WHERE ID_OWNER={$ID_OWNER} AND ID_FIELD={$ID_FIELD}";
			Doo::db()->query($query);
		}
	}

	public static function UpdateCategoryByPOST($OwnerType,$ID_OWNER)
	{
		//Update edited category
		if (isset($_POST['playercategory']))
		{
			$ID_CATEGORY = $_POST['playercategory'];
			if ($ID_CATEGORY!='0')
				MainHelper::UpdateCategory($ID_CATEGORY, $ID_OWNER, $OwnerType);

		}
	}

	public static function IsCategoryMBA($ID_CATEGORY)
	{
		$query = "SELECT MBA_enabled FROM sy_categories WHERE ID_CATEGORY=$ID_CATEGORY";
		$p = (object) Doo::db()->fetchRow($query);
		return $p->MBA_enabled;
	}

	public static function UpdateCategory($ID_CATEGORY, $ID_OWNER, $OwnerType)
	{

		$query = "SELECT COUNT(*) as cnt FROM sn_playercategory_rel WHERE ID_OWNER={$ID_OWNER}";
		$totalNum = (object) Doo::db()->fetchRow($query);

		//Is approved required in category?
		$isCatMBA = self::IsCategoryMBA($ID_CATEGORY);

		if ($totalNum->cnt==0)
		{
			//Insert as new entry
			$Approved = ($isCatMBA == 1) ? 0 : 1;

			$query = "INSERT INTO sn_playercategory_rel (ID_OWNER,ID_CATEGORY,Approved,ID_APPROVER)
				VALUES
				($ID_OWNER,$ID_CATEGORY,$Approved,0)";
			Doo::db()->query($query);
		}
		else
		{
			//Update entry

			//If new changed category is MBA, set approved to 0
			$oldCatID = self::GetPlayersCategory($ID_OWNER);
			$UpdateApproved = "";
			if ($oldCatID!=$ID_CATEGORY && $isCatMBA==1)
				$UpdateApproved = ",Approved=0,ID_APPROVER=0";

			$query = "UPDATE sn_playercategory_rel SET ID_CATEGORY=$ID_CATEGORY {$UpdateApproved} WHERE ID_OWNER={$ID_OWNER}";
			Doo::db()->query($query);
		}
	}


	public static function MakeValidation($fields, $form){
		?><script type="text/javascript">
			$(document).ready(function() {
				$('<?php echo $form; ?>').on('submit', function() {
					$('<?php echo $form; ?>').removeData('validator');
					<?php
						$rules = "";
						$messages = "";
						$c = "";
						foreach($fields as $field) {
							if(isset($field['rule'])) {
								$rules .= $c . $field['rule'];
								$messages .= $c . $field['message'];
								$c = ",";
							}
						}
					?>
					$('<?php echo $form; ?>').validate({
						rules : {<?php echo $rules; ?>},
						messages : {<?php echo $messages; ?>},
					});
					return $('<?php echo $form; ?>').valid();
				});
			});
		</script><?php
	}

	public static function GetModuleFields($query)
	{
		$rs = Doo::db()->query($query)->fetchall();
		$fields = array();
		foreach ($rs as $r)
		{
			$fields[$r['FieldName']] = array(
				'FieldName'=>$r['FieldName'],
				'isEnabled'=>$r['isEnabled'],
				'isRequired'=>$r['isRequired'],
				'rule'=>$r['rule'],
				'message'=>$r['message']);
		}

		return $fields;
	}
	public static function GetModuleFieldsByID($ID_MODULE)
	{
		$query = "SELECT * FROM sy_fields WHERE ID_MODULE=$ID_MODULE";
		return self::GetModuleFields($query);
	}
	public static function GetModuleFieldsByTag($ModuleTag)
	{
		$query = "SELECT sy_fields.* FROM sy_fields,sy_modules
			WHERE sy_modules.ModuleTag='$ModuleTag'	AND sy_fields.ID_MODULE=sy_modules.ID_MODULE";
		return self::GetModuleFields($query);
	}

	public static function GetModuleFunctions($query)
	{
		$rs = Doo::db()->query($query)->fetchall();
		$isEnabled = array();
		foreach ($rs as $r)
			$isEnabled[$r['FunctionTag']] = $r['isEnabled'];

		return $isEnabled;
	}
	public static function GetModuleFunctionsByID($ID_MODULE)
	{
		$query = "SELECT * FROM sy_modulefunctions WHERE ID_MODULE=$ID_MODULE";
		return self::GetModuleFunctions($query);
	}
	public static function GetModuleFunctionsByTag($ModuleTag)
	{
		$query = "SELECT sy_modulefunctions.* FROM sy_modulefunctions,sy_modules
			WHERE sy_modules.ModuleTag='$ModuleTag'	AND sy_modulefunctions.ID_MODULE=sy_modules.ID_MODULE";
		return self::GetModuleFunctions($query);
	}

	public static function IsModuleEnabled($query)
	{
		$rs = Doo::db()->query($query)->fetchall();
		if (isset($rs[0]))
			return $rs[0]['isEnabled'];

		return 0;
	}
	public static function IsModuleEnabledByID($ID_MODULE)
	{
		$query = "SELECT * FROM sy_modules WHERE ID_MODULE=$ID_MODULE";
		return self::IsModuleEnabled($query);
	}
	public static function IsModuleEnabledByTag($ModuleTag)
	{
		$query = "SELECT * FROM sy_modules WHERE ModuleTag='$ModuleTag'";
		return self::IsModuleEnabled($query);
	}

	public static function IsModuleNotAvailableByTag($ModuleTag)
	{
		$query = "SELECT sy_moduleoff.*
			FROM sy_moduleoff,sy_modules
			WHERE sy_moduleoff.ID_MODULE=sy_modules.ID_MODULE
			AND sy_modules.ModuleTag='$ModuleTag'";
		$rs = Doo::db()->query($query)->fetchall();
		if (isset($rs[0]))
			if ($rs[0]['NotAvailable']==1)
				return 1;

		return 0;
	}

	public static function TrySetModuleNotAvailableByTag($ModuleTag)
	{
		$query = "SELECT sy_moduleoff.*
			FROM sy_moduleoff,sy_modules
			WHERE sy_moduleoff.ID_MODULE=sy_modules.ID_MODULE
			AND sy_modules.ModuleTag='$ModuleTag'";
		$rs = Doo::db()->query($query)->fetchall();
		if (isset($rs[0]))
			if ($rs[0]['NotAvailable']==1)
				return $rs[0]['Message'];

		return null;
	}

	public static function site_url($url='') {
		return Doo::conf()->APP_URL . $url;
	}

		public static function getPageName(){
			return str_replace(Doo::conf()->SUBFOLDER,'',$_SERVER["REQUEST_URI"]);
		}

	public static function calculateTime($timestamp, $format = DATE_FULL){
		if (Auth::isUserLogged()) {
			$player = User::getUser();

			$timestamp += $player->TimeOffset + $player->DSTOffset;
		}

		return date($format, $timestamp);
	}

        public static function timeAgo($timestamp, $format = DATE_FULL) {
                                $etime = time() - $timestamp;

                        if ($etime < 1)
                        {
                            return '0 seconds';
                        }

                        $a = array( 12 * 30 * 24 * 60 * 60  =>  'year',
                                    30 * 24 * 60 * 60       =>  'month',
                                    24 * 60 * 60            =>  'day',
                                    60 * 60                 =>  'hour',
                                    60                      =>  'minute',
                                    1                       =>  'second'
                                    );

                        foreach ($a as $secs => $str)
                        {
                            $d = $etime / $secs;
                            if ($d >= 1)
                            {
                                $r = round($d);
                                return $r . ' ' . $str . ($r > 1 ? 's' : '') . ' ago';
                            }
                        }
        }

	public static function shareInfo($otype, $oid, $olang = false){
		$result = array('title' => '', 'url' => '', 'img' => '');

		switch ($otype) {
			case SHARE_NEWS:
				if($olang){
					$item = News::getArticleByID($oid, $olang);

					if($item) {
						$result['title'] = $item->Headline;
						$result['url'] = $item->URL;
						$result['description'] = $item->IntroText;
						$result['img'] = self::showImage($item, THUMB_LIST_100x100, false, array('no_img' => 'noimage/no_news_100x100.png'));
					} else {
						return null;
					}
				}
		}

		return (object) $result;
	}

	public static function activeMenu($url) {
		return (strlen($_SERVER['REQUEST_URI']) != strlen(str_replace(Doo::conf()->SUBFOLDER . $url, "", $_SERVER['REQUEST_URI'])));
	}

	public static function loadInfoBox($controller, $method, $return = false) {
		if (Auth::isUserLogged()) {
			$player = User::getUser();

			if ($player) {
				$snInfo = new SnInfo();
				$snPlayerInfoRel = new SnPlayerInfoRel();

				$query = "SELECT {$snInfo->_table}.*, {$snPlayerInfoRel->_table}.ID_PLAYER
							FROM {$snInfo->_table}
							LEFT JOIN {$snPlayerInfoRel->_table} ON {$snInfo->_table}.ID_INFO = {$snPlayerInfoRel->_table}.ID_INFO AND {$snPlayerInfoRel->_table}.ID_PLAYER = ?
							WHERE {$snInfo->_table}.Controller = ? AND {$snInfo->_table}.Method = ?
							LIMIT 1";
				$q = Doo::db()->query($query, array($player->ID_PLAYER, $controller, $method));
				$info = $q->fetchObject('SnInfo');

				if ($info and $info->ID_PLAYER == null) {
					Doo::loadController('SnController');
					$snController = new SnController();
					if ($return == true) {
						return $snController->renderBlock('common/infoBox', array('info' => $info));
					} else {
						echo $snController->renderBlock('common/infoBox', array('info' => $info));
					}
				}
			}
		}
	}

	public static function closeInfoBox($id) {
		$player = User::getUser();
		$snPlayerInfoRel = new SnPlayerInfoRel();
		$snPlayerInfoRel->ID_INFO = $id;
		$snPlayerInfoRel->ID_PLAYER = $player->ID_PLAYER;
		$snPlayerInfoRel->insert();
	}

	public static function topMenu() {
		$menu = new SyMenu;
		$data['topmenu'] = $menu->getMenu(TOP,Auth::isUserLogged()?1:0);
		return (object) $data;
	}

	public static function bottomMenu() {
		$menu = new SyMenu;
		$data['bottommenu'] = $menu->getMenu(BOTTOM,Auth::isUserLogged()?1:0);
		return (object) $data;
	}

	public static function esportMenu() {
		$menu = new SyMenu;
		$data['topmenu'] = $menu->getMenu(ESPORT,Auth::isUserLogged()?1:0);
		return (object) $data;
	}

	public static function loadSideWidgets($params = array(), $addParam1 = '', $addParam2 = '') {
		Doo::loadController('SnController');
		$snController = new SnController();
		$content = '';

		if (!empty($params) and is_array($params)) {
			foreach ($params as $param) {
				switch ($param) {
					case WIDGET_LOGIN:

						break;
					case WIDGET_CALENDAR:

						break;
					case WIDGET_PROMOTION:

						break;
				}
			}
		}

		return $content;
	}

	public static function companiesLeftSide($company, $active = '') {
		Doo::loadController('SnController');
		$snController = new SnController();

		$return = $snController->renderBlock('companies/common/leftColumn', array('company' => $company, 'selected' => $active));
		return $return;
	}

	public static function gamesLeftSide($game, $active = '') {
		Doo::loadController('SnController');
		$snController = new SnController();

		$return = $snController->renderBlock('games/common/leftColumn', array('game' => $game, 'selected' => $active));
		return $return;
	}

	public static function groupsLeftSide($group, $active = '') {
		Doo::loadController('SnController');
		$snController = new SnController();

		$return = $snController->renderBlock('groups/common/leftColumn', array('group' => $group, 'selected' => $active));
		return $return;
	}

	public static function FindImage($id,$thumb,$ownerType)
	{
		switch($thumb)
		{
			//portrait
			case THUMB_LIST_200x300:
			case THUMB_LIST_100x150:
				$Orientation = 'portrait';
			break;
			//landscape
			case IMG_800x600:
			case IMG_600x360:
			case THUMB_LIST_1440x810:
			case THUMB_LIST_1120x700:
			case THUMB_LIST_800x600:
			case THUMB_LIST_330x260:
			case THUMB_LIST_240x180:
			case THUMB_LIST_200x140:
			case THUMB_LIST_198x148:
			case THUMB_LIST_180x140:
			case THUMB_LIST_140x110:
			case THUMB_LIST_138x107:
			case THUMB_LIST_100x75:
			case THUMB_LIST_98x81:
				$Orientation = 'landscape';
			break;
			//square
			case THUMB_LIST_188x188:
			case THUMB_LIST_100x100:
			case THUMB_LIST_80x80:
			case THUMB_LIST_60x60:
			case THUMB_LIST_40x40:
				$Orientation = 'square';
			break;
			//banner
			case THUMB_LIST_600x200:
			case THUMB_LIST_100x33:
				$Orientation = 'banner';
			break;
			default:
				$Orientation = 'square';
			break;
		}

		$SnImages = Doo::db()->getOne('SnImages', array(
		'limit' => 1,
		'where' => 'ID_OWNER = ? AND OwnerType = ? AND Orientation = ? AND ImageUrl <> ""',
		'param' => array($id,$ownerType,$Orientation)
		));
		$result = '';
		if(is_object($SnImages))
		{
			$result = $SnImages->ImageUrl;
		}
		else
		{
			switch($Orientation)
			{
				case 'portrait':
				case 'landscape':
					$SnImages = Doo::db()->getOne('SnImages', array(
					'limit' => 1,
					'where' => 'ID_OWNER = ? AND OwnerType = ? AND Orientation = ? AND ImageUrl <> ""',
					'param' => array($id,$ownerType,'square')
					));

					if(is_object($SnImages))
					{
						$result = $SnImages->ImageUrl;
					}
				break;
				case'square':
					$SnImages = Doo::db()->getOne('SnImages', array(
					'limit' => 1,
					'where' => 'ID_OWNER = ? AND OwnerType = ? AND Orientation = ? AND ImageUrl <> ""',
					'param' => array($id,$ownerType,'landscape')
					));

					if(is_object($SnImages))
					{
						$result = $SnImages->ImageUrl;
					}
					else
					{
						$SnImages = Doo::db()->getOne('SnImages', array(
						'limit' => 1,
						'where' => 'ID_OWNER = ? AND OwnerType = ? AND Orientation = ? AND ImageUrl <> ""',
						'param' => array($id,$ownerType,'portrait')
						));

						if(is_object($SnImages))
						{
							$result = $SnImages->ImageUrl;
						}
					}
				break;
				case'banner':
					$SnImages = Doo::db()->getOne('SnImages', array(
					'limit' => 1,
					'where' => 'ID_OWNER = ? AND OwnerType = ? AND Orientation = ? AND ImageUrl <> ""',
					'param' => array($id,$ownerType,'landscape')
					));

					if(is_object($SnImages))
					{
						$result = $SnImages->ImageUrl;
					}
					else
					{
						$SnImages = Doo::db()->getOne('SnImages', array(
						'limit' => 1,
						'where' => 'ID_OWNER = ? AND OwnerType = ? AND Orientation = ? AND ImageUrl <> ""',
						'param' => array($id,$ownerType,'square')
						));

						if(is_object($SnImages))
						{
							$result = $SnImages->ImageUrl;
						}
					}
				break;
			}
		}
		return $result;
	}

	/**
	 * Shows image by type and size
	 *
	 * @return String
	 */
	public static function showImage($model, $thumb = THUMB_LIST_60x60, $srcOnly = false, $params = array()) {
                        $title = isset($params['title']) ? $params['title'] : '';

		if($model) {
			$folder = '';
			$img_name = '';

        // change this extremely inefficient if-else galore to  get_class($model)   and   switch   the resulting string.
			if($model instanceof SnImages) {
				switch($model->OwnerType) {
					case 'company':
						$folder = FOLDER_COMPANIES;
					break;
					case 'game':
						$folder = FOLDER_GAMES;
					break;
					case 'group':
						$folder = FOLDER_GROUPS;
					break;
					case 'event':
						$folder = FOLDER_EVENTS;
					break;
					case 'news':
						$folder = FOLDER_NEWSITEMS;
					break;
					case 'product':
						$folder = FOLDER_SHOP;
					break;
					case 'blog':
						$folder = FOLDER_BLOG;
					break;
					default:
						return false;
					break;
				}
				$img_name = $model->ImageUrl;
			}
			elseif ($model instanceof SnSearch)
			{
				switch ($model->FieldType)
				{
					case 'company':
						$folder = FOLDER_COMPANIES;
					break;
					case 'game':
						$folder = FOLDER_GAMES;
					break;
					case 'group':
						$folder = FOLDER_GROUPS;
					break;
					case 'event':
						$folder = FOLDER_EVENTS;
					break;
					case 'news':
					case 'review':
						$folder = FOLDER_NEWSITEMS;
					break;
					case 'product':
						$folder = FOLDER_SHOP;
					break;
					case 'blog':
						$folder = FOLDER_BLOG;
					break;
					default:
						return false;
					break;
				}
				$img_name = self::FindImage($model->ID_ITEM,$thumb,$model->FieldType == 'review' ? 'news' : $model->FieldType);
				if($img_name == '')
					$img_name = $model->ImageUrl;
			}
			elseif ($model instanceof NwItems || $model instanceof NwItemLocale)
			{
				if($model->isBlog==1)
				{
					$folder = FOLDER_BLOG;
					$img_name = self::FindImage($model->ID_NEWS,$thumb,'blog');
				}
				else
				{
					$folder = FOLDER_NEWSITEMS;
					$img_name = self::FindImage($model->ID_NEWS,$thumb,'news');
				}

				if($img_name == '')
				{
					$img_name = $model->Image;
				}

				if(empty($img_name)||$img_name == '')
				{

					switch($model->OwnerType)
					{
						case'company':
							$folder = FOLDER_COMPANIES;

							$SnCompanies = Doo::db()->getOne('SnCompanies', array(
							'limit' => 1,
							'where' => 'ID_COMPANY = ?',
							'param' => array($model->ID_OWNER)
							));

							$img_name = self::FindImage($SnCompanies->ID_COMPANY,$thumb,$model->OwnerType);
							if($img_name == '')
							{
								$img_name = $SnCompanies->ImageURL;
							}
						break;
						case'game':
							$folder = FOLDER_GAMES;

							$SnGames = Doo::db()->getOne('SnGames', array(
							'limit' => 1,
							'where' => 'ID_GAME = ?',
							'param' => array($model->ID_OWNER)
							));

							$img_name = self::FindImage($SnGames->ID_GAME,$thumb,$model->OwnerType);
							if($img_name == '')
							{
								$img_name = $SnGames->ImageURL;
							}
						break;
						case'group':
							$folder = FOLDER_GAMES;

							$SnGroups = Doo::db()->getOne('SnGroups', array(
							'limit' => 1,
							'where' => 'ID_GROUP = ?',
							'param' => array($model->ID_OWNER)
							));

							$img_name = self::FindImage($SnGroups->ID_GROUP,$thumb,$model->OwnerType);
							if($img_name == '')
							{
								$img_name = $SnGroups->ImageURL;
							}
						break;
					}
				}
			} elseif ($model instanceof SnWallitems) {
				$folder = FOLDER_WALL_PHOTOS;
				$messArr = (object) unserialize($model->Message);
				$content = (object) unserialize($messArr->content);

				$img_name = $content->content;
			} elseif ($model instanceof SnGames) {
				$folder = FOLDER_GAMES;

				$img_name = self::FindImage($model->ID_GAME,$thumb,'game');
				if($img_name == '')
				{
					$img_name = $model->ImageURL;
				}
			} elseif ($model instanceof SnGroups) {
				$folder = FOLDER_GROUPS;

				$img_name = self::FindImage($model->ID_GROUP,$thumb,'group');
				if($img_name == '')
				{
					$img_name = $model->ImageURL;
				}
			} elseif ($model instanceof SnCompanies) {
				$folder = FOLDER_COMPANIES;

				$img_name = self::FindImage($model->ID_COMPANY,$thumb,'company');
				if($img_name == '')
				{
					$img_name = $model->ImageURL;
				}
			} elseif ($model instanceof EvEvents) {
				$folder = FOLDER_EVENTS;
				$img_name = self::FindImage($model->ID_EVENT,$thumb,'event');
				if($img_name == '')
				{
					$img_name = $model->ImageURL;
				}
			} elseif ($model instanceof SnMedia) {
				switch ($model->OwnerType) {
					case WALL_GROUPS:
						$folder = FOLDER_GROUPS;
						break;
					case WALL_COMPANIES:
						$folder = FOLDER_COMPANIES;
						break;
					case WALL_GAMES:
						$folder = FOLDER_GAMES;
						break;
				}
				$img_name = $model->MediaDesc;
			} elseif ($model instanceof Players or (isset($model->ID_PLAYER) and isset($model->Avatar))) {
				$folder = FOLDER_PLAYERS;
				$img_name = $model->Avatar;
			} elseif ($model instanceof FiProducts || $model instanceof FiProductInfo) {
				$folder = FOLDER_SHOP;
				$img_name = $model->ImageURL;
			} elseif ($model instanceof SyBugReports) {
				$folder = FOLDER_BUGREPORTS;
				$img_name = $model->ImageURL;
			}
			elseif ($model instanceof AcLevels){
				$folder = FOLDER_ACHIEVEMENTS;
				$img_name = $model->ImageURL;
			}
			elseif ($model instanceof AcAchievements){
				$folder = FOLDER_ACHIEVEMENTS;
				$img_name = $model->ImageURL;
			}
			elseif ($model instanceof EsLeagues){
				$folder = FOLDER_ESPORT;
				$img_name = $model->Image;
			}
			elseif ($model instanceof EsMatches){
				$folder = FOLDER_ESPORT_SCREENSHOTS;

                                if($model->ImageType == 'opponent')
                                    $img_name = $model->OpponentScreenshot;
                                else
                                    $img_name = $model->ChallengerScreenshot;
			}
			elseif ($model instanceof EsFanclubs){
				$folder = FOLDER_ESPORT_FANCLUBS;
				$img_name = $model->ImageURL;
			}
			elseif ($model instanceof EsTeams){
				$folder = FOLDER_ESPORT_TEAMS;
				$img_name = $model->Avatar;
			}
			elseif ($model instanceof SyLayout){
				$folder = FOLDER_LAYOUT;
				$img_name = $model->Value;
			}
			elseif ($model instanceof EsLadderranges){
				$folder = FOLDER_ESPORT_LADDER;
				$img_name = $model->img;
			}

			$path = Doo::conf()->SITE_PATH . 'global/pub_img/' . $folder . '/';
			$pathPublic = Doo::conf()->APP_URL . 'global/pub_img/' . $folder . '/';
			$ext = strrchr($img_name,'.');

			$addPath = substr($img_name, 0, 1) . '/' . substr($img_name, 1, 1) . '/';
			$pathToStore = $path . $addPath;
			$pathToStorePublic = $pathPublic . $addPath;

			$thumbName = ($thumb != '') ? (substr($img_name, 0, strrpos($img_name, '.')) . $thumb . '.jpg') : $img_name;
			$file = $pathToStore . $thumbName;

			$thumbNameOrig = substr($img_name, 0, strrpos($img_name, '.')) . $ext;
			$fileOrig = $pathToStore . $thumbNameOrig;

			if (!file_exists($file) and file_exists($fileOrig) and $ext) {

				$gd = new SnGdImage($pathToStore, $pathToStore, true);
				$gd->generatedQuality = 85;
				$gd->thumbSuffix = $thumb;

				$resize = 0;
				if (!empty($params)) {
					if (in_array('width', $params)) {
						$resize = 1;
					}
					if (in_array('height', $params)) {
						$resize = 2;
					}
					if (in_array('both', $params)) {
						$resize = 3;
					}
				}

				$actualSize = explode("x", str_replace('_', '', $thumb));
				if ($resize == 0) {
					$gd->adaptiveResizeCropExcess($thumbNameOrig, $actualSize[0], $actualSize[1]);
				} else if ($resize == 1) {
					$gd->ratioResize($thumbNameOrig, $actualSize[0]);
				} else if ($resize == 2) {
					$gd->ratioResize($thumbNameOrig, null, $actualSize[1]);
				} else if ($resize == 3) {
					$gd->ratioResize($thumbNameOrig, $actualSize[0], $actualSize[1]);
				}
			}

			if (file_exists($file)) {
				$img = $pathToStorePublic . $thumbName;
				if ($srcOnly == true) {
					return $img;
				} else {
					list($imgWidth, $imgHeight) = getimagesize($file);
					return '<img src="' . $img . '" alt="" width="' . $imgWidth . '" height="' . $imgHeight . '" title="'. $title .'">';
				}
			}
		}

		if (isset($params['no_img'])) {
			if ($srcOnly == true) {
				return Doo::conf()->APP_URL . 'global/img/' . $params['no_img'];
			}
			return '<img src="' . Doo::conf()->APP_URL . 'global/img/' . $params['no_img'] . '" alt="" title="' . $title . '">';
		}
	}

	public static function getCountryList($instruc = 'Choose your country') {
		$list = new GeCountries();
		$list->ID_COUNTRY = 0;
		$list->Country = $instruc;
		$array = array($list);
		$list = new GeCountries();
		$list = array_merge($array, $list->find(array('asc' => 'Country')));
		return $list;
	}

	public static function getTimeZoneList($instruc = 'Choose your timezone') {
		$list = new GeTimezones();
		$list->ID_TIMEZONE = 0;
		$list->TimeZoneText = $instruc;
		$array = array($list);
		$list = new GeTimezones();
		$list = array_merge($array, $list->find(array('asc' => 'Offset')));
		return $list;
	}

	public static function getMonthList($instruc = 'Month') {
		return array(
			0 => $instruc,
			1 => 'Jan',
			2 => 'Feb',
			3 => 'Mar',
			4 => 'Apr',
			5 => 'May',
			6 => 'Jun',
			7 => 'Jul',
			8 => 'Aug',
			9 => 'Sep',
			10 => 'Oct',
			11 => 'Nov',
			12 => 'Dec'
		);
	}

	public static function getDays($instruc = 'Day') {
		$days[0] = $instruc;
		for ($i = 1; $i < 32; $i++) {
			$days[$i] = $i < 10 ? '0' . $i : $i;
		}

		return $days;
	}

	public static function getYears($instruc = 'Year', $future = 10) {
		$years[0] = $instruc;
				$date = date("Y") + $future;
		for ($i = $date; $i > $date - 80 - $future; $i--) {
			$years[$i] = $i;
		}

		return $years;
	}

	public static function isYearSelected($date, $val) {
		$year = substr($date, 0, 4);

		if ($year == $val)
			return true;

		return false;
	}

	public static function isMonthSelected($date, $val) {
		$month = substr($date, 5, 2);

		if (strlen($month) > 1 and substr($month, 0, 1) == 0) {
			$month = substr($month, 1, 1);
		}

		if ($month == $val)
			return true;

		return false;
	}

	public static function isDaySelected($date, $val) {
		$day = substr($date, -2, 2);

		if (strlen($day) > 1 and substr($day, 0, 1) == 0) {
			$day = substr($day, 1, 1);
		}

		if ($day == $val)
			return true;

		return false;
	}

	public static function isHourSelected($time, $val) {
		$hour = substr($time, 0, 2);

		if ($hour == $val)
			return true;

		return false;
	}
	public static function isMinuteSelected($time, $val) {
		$minute = substr($time, -2, 2);

		if ($minute == $val)
			return true;

		return false;
	}

	public static function getHours() {
		$hours[0] = 'Hour';
		for ($i = 1; $i <= 24; $i++) {
			$num = $i - 1;
			if ($num < 10) {
				$num = '0' . $num;
			}
			$hours[$i] = $num;
		}
		return $hours;
	}

	public static function getMinutes($intval = 15) {
		$minutes[0] = 'Min';
		for ($i = 1; $i <= 60; $i += $intval) {
			$num = $i - 1;
			if ($num < 10) {
				$num = '0' . $num;
			}
			$minutes[$i] = $num;
		}
		return $minutes;
	}

	public static function getTime() {
		$time = array();

		for ($i = 0; $i < (24 * 60); $i += 30) {
			$time[$i] = date('H:i', mktime(0, $i, 0, 0, 0, 0));
		}

		return $time;
	}

	public static function getEventTypes() {
		$types[EVENT_TYPE_LIVE] = $this->__(ucfirst(EVENT_TYPE_LIVE));
		$types[EVENT_TYPE_ESPORT] = $this->__(ucfirst(EVENT_TYPE_ESPORT));
	}

	public static function getFutureYears() {
		$years[0] = "Year";
		$date = date("Y");
		for ($i = $date; $i < $date + Doo::conf()->maxFutureYears; $i++) {
			$years[$i] = $i;
		}

		return $years;
	}

	/**
	 * Returns array of platform names
	 * @param SnGames $game
	 * @return array
	 */
	public static function getGamePlatforms(SnGames $game) {
		$platforms = $game->getPlatforms();
		$platformNames = array();
		if (!empty($platforms)) {
			foreach ($platforms as $pl) {
				$platformNames[] = $pl->PlatformName;
			}
		}

		return $platformNames;
	}

	public static function getGameRelease(SnGames $game) {
		$time = '';
		if ($game->CreationDate != '0000-00-00') {
			$time = date(DATE_SHORT, strtotime($game->CreationDate));
		}
		return $time;
	}

	public static function loadCKE($textareaID, $text = '', $params = array(), $attrs = array(), $events = array(), $toolbar = '') {
		Doo::loadClass('CKEditor/ckeditor');
        $url = MainHelper::site_url('global/js/ckeditor4.3.3/');
		$CKEditor = new CKEditor($url);

		$config = array();
		$_SESSION['fmFileRoot'] = Doo::conf()->SITE_PATH.'global/pub_img/'.FOLDER_CUSTOMVIEW.'/';
		$config['filebrowserBrowseUrl'] = $url . 'Filemanager/index.html';

        $config['tabIndex'] = 1;
		switch($toolbar) {
			case 'light':
				$config['toolbar'] = array(
                    array('Bold', 'Italic', 'Underline', 'Strike', 'JustifyLeft', 'JustifyCenter', 'JustifyRight', 'JustifyBlock', 'NumberedList', 'BulletedList', 'Outdent', 'Indent', 'Undo', 'Redo', 'PasteText')
				);
				break;
			default:
				$config['toolbar'] = array(
                    array('Styles', 'Bold', 'Italic', 'Underline', 'Strike', 'JustifyLeft', 'JustifyCenter', 'JustifyRight', 'JustifyBlock', 'NumberedList', 'BulletedList', 'Outdent', 'Indent', 'Undo', 'Redo', 'PasteText', 'Source'),
                    array('Link', 'Unlink', 'Image', 'Flash', 'Iframe', 'Table', 'Maximize', 'ShowBlocks')
				);
		};

		if(!empty($params)) { foreach($params as $key => $val) { $config["{$key}"] = "{$val}"; }; }
        else {
			$config['extraPlugins'] = 'autogrow,maxlength';
			$config['removePlugins'] = 'resize';
		};

        if(!empty($attrs)) { foreach($attrs as $key => $val) { $CKEditor->$key = $val; }; };

		$CKEditor->editor($textareaID, html_entity_decode($text), $config, $events);
	}

	public static function getWallPosts(&$list, $obj, $offset = 0, $type = WALL_HOME, $friendUrl = '', $album = 0) {
		$wall = new Wall();
		$render = new SnController();

		$type = str_replace(array(WALL_OWNER_PLAYER . '_'), '', $type);

		$plist = $wall->getPostList($obj, $type, $offset, $friendUrl, '', $album);
		$list['postTotal'] = $wall->getTotalPostsByType();
		$list['postCount'] = count($plist);
		$postList = '';

		if (!empty($plist)) {
			if ($type == WALL_PHOTO or $type == WALL_VIDEO) {
				$val = array('poster' => $obj, 'items' => $plist, 'offset' => $offset, 'friendUrl' => $friendUrl);
				$postList = $render->renderBlock('wall/' . $type . '_gallery', $val);
			} else {
				$num = 0;
				foreach ($plist as $item) {
					MainHelper::getWallPost($render, $wall, $item, $postList, $num, $list);
					$num++;
				}
			}
		}
		$list['posts'] = $postList;
	}

	public static function getWallPost(&$render, &$wall, &$item, &$postList, $num = 0, $list="") {
		if ($item->OwnerType == WALL_OWNER_PLAYER) {
			$poster = User::getById($item->ID_OWNER);
		} elseif ($item->OwnerType == WALL_OWNER_GROUP) {
			$poster = Groups::getGroupByID($item->ID_OWNER);
		} elseif ($item->OwnerType == WALL_OWNER_EVENT) {
			$poster = Event::getEvent($item->ID_OWNER);
		}

		$clist = $wall->getRepliesList($item->ID_WALLITEM, Doo::conf()->defaultShowRepliesLimit);
		$comments = '';
		if (!empty($clist)) {
			$clist = array_reverse($clist);
			$nm = 0;
			foreach ($clist as $com) {
				$vl = array('poster' => $com->Players, 'item' => $com, 'num' => $nm);
				$comments .= $render->renderBlock('wall/comment', $vl);
				$nm++;
			}
		}

		$val = array('poster' => $poster, 'item' => $item, 'num' => $num, 'comments' => $comments, 'list' => $list);

		if ($item->isShared == 1)
			$postList .= $render->renderBlock('wall/share_' . $item->ShareOwnerType, $val);
		else
			$postList .= $render->renderBlock('wall/' . $item->ItemType, $val);
	}

	public static function creditsOutput($credits) {
		return (int) $credits . '<span class="curr_span">Credits</span>';
	}

	public static function centsOutput($cents) {
		return (int) $cents . '<span class="curr_span">Coins</span>';
	}

	public static function orderNumber($number) {
		$cont = 10000000 + intval($number);
		return substr("$cont", 1, strlen($cont) - 1);
	}

	public static function showInviter($list = array(), $echo = true) {
		Doo::loadController('SnController');
		$snController = new SnController();
		include(Doo::conf()->SITE_PATH . 'OpenInviter/openinviter.php');

		$player = User::getUser();
		$inviter = new OpenInviter();
		$services = $inviter->getPlugins();
		$pluginTypes = $inviter->pluginTypes;

		if (!empty($list)) {
			$errors = array();
			if (isset($list['provider_box']) and empty($list['provider_box']))
				$errors['provider'] = $snController->__('Please choose provider');
			if (isset($list['email_box']) and empty($list['email_box']))
				$errors['email'] = $snController->__('Please enter email address');
			if (isset($list['password_box']) and empty($list['password_box']))
				$errors['password'] = $snController->__('Please enter your password');


			if (empty($errors)) {
				$inviter->startPlugin($list['provider_box']);
				$login = $inviter->login($list['email_box'], $list['password_box']);
				if ($login) {
					$contacts = $inviter->getMyContacts();
					if ($contacts == false)
						return;

					if ($inviter->showContacts()) {
						$existing = array();
						$invite = array();
						if (!empty($contacts)) {
							foreach ($contacts as $email => $name) {
								$user = User::getByEmail($email);
								if ($user) {
									if ($user->ID_PLAYER != $player->ID_PLAYER
											and !$player->isFriend($user->ID_PLAYER)
											and !$player->isPending($user->ID_PLAYER))
										$existing[] = $user;
								}
								elseif (!$player->hasInvited($email)) {
									$invite[$email] = $name;
								}
							}
						}

						$res = $snController->renderBlock('common/FTU/inviterStep2', array('invite' => $invite, 'existing' => $existing));

						if($echo)
							echo $res;
						else
							return $res;
					}
				} else {
					$errors['login'] = $snController->__('Email and password does not match');
				}
			}

			if (!empty($errors)) {
				$res = $snController->renderBlock('common/FTU/inviterStep1', array('services' => $services, 'pluginTypes' => $pluginTypes, 'errors' => $errors, 'values' => $list));
				if($echo)
					echo $res;
				else
					return $res;
			}
		}
		else{
			$res = $snController->renderBlock('common/FTU/inviterStep1', array('services' => $services, 'pluginTypes' => $pluginTypes));

			if($echo)
				echo $res;
			else
				return $res;
		}
	}

	public static function getPopularGames() {
		$g = new Games();
		$games = $g->getAllGames(Doo::conf()->FTUlistLimit, 2);

		return $games;
	}

	public static function getLargestGroups() {
		$g = new Groups();
		$groups = $g->getLargestGroups(Doo::conf()->FTUlistLimit);

		return $groups;
	}

	public static function validatePostFields($params) {
		$valid = TRUE;
		$input = filter_input_array(INPUT_POST);
		if(!empty($input)) {
			foreach($params as $param) {
				if(empty($input["{$param}"]) || trim($input["{$param}"]) == "") {
					$valid = FALSE;
					break;
				};
			};
		} else { $valid = FALSE; };
		return $valid;
	}

	public static function validateGetFields($params) {
		$valid = TRUE;
		$input = filter_input_array(INPUT_GET);
		if(!empty($input)) {
			foreach($params as $param) {
				if(empty($input["{$param}"]) || trim($input["{$param}"]) == "") {
					$valid = FALSE;
					break;
				};
			};
		} else { $valid = FALSE; };
		return $valid;
	}

	public static function infoBoxText($string, $player) {
		Doo::loadController('SnController');
		$snController = new SnController();

		$string = $snController->__($string);

		if (preg_match_all('/\[_[a-zA-Z]+\]/', $string, $matches)) {
			foreach ($matches[0] as $m) {
				switch ($m) {
					case '[_memberType]':
						$string = str_replace($m, 'Basic', $string); //TODO: get real membership type
						break;
					case '[_maxPhotos]':
						$string = str_replace($m, 50, $string); //TODO: get real max photos
						break;
					case '[_maxGroups]':
						$string = str_replace($m, 5, $string); //TODO: get real max groups
						break;
					case '[_helpPD]':
						$a = '<a href="javascript:void(0)" class="F_helpBubble" rel="' . $snController->__('Credits is one of PlayNations virtual currencies and can be used to play E-Sport and buy products, memberships and services on the site.') . '">?</a>';
						$string = str_replace($m, $a, $string);
						break;
					case '[_helpPC]':
						$a = '<a href="javascript:void(0)" class="F_helpBubble" rel="' . $snController->__('Coins is one of PlayNations virtual currencies and can be used to buy certain products and services on the site.') . '">?</a>';
						$string = str_replace($m, $a, $string);
						break;
					case '[_termsServices]':
						$a = '<a href="' . MainHelper::site_url('info/7') . '">' . $snController->__('Terms of Service') . '</a>';
						$string = str_replace($m, $a, $string);
						break;
				}
			}
		}

		return $string;
	}
	// randomly pick a active banner

	public static function pickBanner($place, $site = '')
	{
		$player = User::getUser();
		$lang = new Lang();
		$Country = $lang->getCountryIDByTag($player->Country);
		$Language = $player->ID_LANGUAGE;
		$nowdate = date("d.m.Y");
		$now = strtotime($nowdate);
		$query =
			"SELECT * FROM ad_campaigns
				INNER JOIN ad_banners
				ON ad_campaigns.ID_CAMPAIGN = ad_banners.FK_CAMPAIGN
				WHERE ad_banners.Placement = '$place'
				AND	NOT (ad_banners.DisplaySiteUrl <> '".addslashes($site)."' AND ad_banners.DisplaySiteUrl <> '')
				AND ad_campaigns.StartDate <= $now AND NOT (ad_campaigns.EndDate < $now AND ad_campaigns.EndDate > 0)
				AND ad_campaigns.Country IN ($Country,0) AND ad_campaigns.Language IN ($Language,0)
				AND NOT (ad_banners.MaxClicks <= ad_banners.CurrentClicks AND ad_banners.MaxClicks > 0)
				AND NOT (ad_banners.MaxDisplays <= ad_banners.CurrentDisplays AND ad_banners.MaxDisplays > 0)
				ORDER BY RAND()
				LIMIT 1";
		Doo::db()->query($query);
		$r = (object) Doo::db()->fetchRow($query);
		return $r;
	}

	public static function pickBannernotloggedin($place, $site = '')
	{
		$nowdate = date("d.m.Y");
		$now = strtotime($nowdate);
// Find language and country, then reactivate the following by replacing the other country lang line in the query below
//				AND ad_campaigns.Country IN ($Country,0) AND ad_campaigns.Language IN ($Language,0)

		$query =
			"SELECT * FROM ad_campaigns
				INNER JOIN ad_banners
				ON ad_campaigns.ID_CAMPAIGN = ad_banners.FK_CAMPAIGN
				WHERE ad_banners.Placement = '$place'
				AND	NOT (ad_banners.DisplaySiteUrl <> '".addslashes($site)."' AND ad_banners.DisplaySiteUrl <> '')
				AND ad_campaigns.StartDate <= $now AND NOT (ad_campaigns.EndDate < $now AND ad_campaigns.EndDate > 0)
				AND ad_campaigns.Country = 0 AND ad_campaigns.Language = 0
				AND NOT (ad_banners.MaxClicks <= ad_banners.CurrentClicks AND ad_banners.MaxClicks > 0)
				AND NOT (ad_banners.MaxDisplays <= ad_banners.CurrentDisplays AND ad_banners.MaxDisplays > 0)
				ORDER BY RAND()
				LIMIT 1";
		Doo::db()->query($query);
		$r = (object) Doo::db()->fetchRow($query);
		return $r;
	}
	public static function countUpClick($id)
	{
		$query =
			"SELECT CurrentClicks FROM ad_banners WHERE ID_BANNER = '$id'";
		Doo::db()->query($query);
		$r = (object)Doo::db()->fetchRow($query);
		$new = $r->CurrentClicks;
		$new=$new+1;
		$query = "UPDATE ad_banners SET CurrentClicks='$new' WHERE ID_BANNER = '$id'";
		Doo::db()->query($query);
	}

	public static function countUpDisplays($id, $newDisplay)
	{
		$query = "UPDATE ad_banners SET CurrentDisplays='$newDisplay' WHERE ID_BANNER = '$id'";
		Doo::db()->query($query);
	}

	public static function carma()
	{
		$player = User::getUser();
		$Country= $player->Country;
		$primLanguage= $player->ID_LANGUAGE;
		return $player;
	}

	public static function getWidgetsList($ID_PLAYER, $howToOrder = 'position') {
		switch ($howToOrder) {
			case 'visibility':
				$query = "SELECT * FROM sn_playerwidget_rel
					INNER JOIN sn_widgets ON sn_playerwidget_rel.ID_WIDGET = sn_widgets.ID_WIDGET 
					WHERE sn_playerwidget_rel.ID_PLAYER = $ID_PLAYER AND sn_widgets.isHidden = 0 
					ORDER BY sn_playerwidget_rel.isVisible DESC, sn_playerwidget_rel.WidgetOrder ASC";
				break;
			case 'position':
			default:
				$query = "SELECT * FROM sn_playerwidget_rel
					INNER JOIN sn_widgets ON sn_playerwidget_rel.ID_WIDGET = sn_widgets.ID_WIDGET 
					WHERE sn_playerwidget_rel.ID_PLAYER = $ID_PLAYER AND sn_widgets.isHidden = 0 
					ORDER BY sn_playerwidget_rel.WidgetOrder ASC";
				break;
		}

		Doo::db()->query($query);
		$p = (object) Doo::db()->fetchall($query);

		return $p;
	}

	public static function getWidgetListAdmin() {
		$query = "SELECT * FROM sn_widgets ORDER BY ID_WIDGET ASC";
		$p = Doo::db()->fetchall($query);

		return $p;
	}

	public static function getWidgetByID($id) {
		$widget = new SnWidgets();
		$widget->ID_WIDGET = $id;
		$widget = $widget->getOne();

		return $widget;
	}

	public static function getWidget($ID_PLAYER, $widgetName) {
		$query = "SELECT * FROM sn_playerwidget_rel
			INNER JOIN sn_widgets ON sn_playerwidget_rel.ID_WIDGET = sn_widgets.ID_WIDGET
			WHERE sn_playerwidget_rel.ID_PLAYER = $ID_PLAYER AND sn_widgets.Name = '{$widgetName}'";

		Doo::db()->query($query);
		$p = Doo::db()->fetchRow($query);

		return $p;
	}

	public static function getHighestMsgNumberForTopic($ID_PLAYER, $thread) {
		$query = "SELECT `ID_MSG` FROM fm_playertopic_rel
			WHERE ID_PLAYER = $ID_PLAYER AND ID_TOPIC = $thread->ID_TOPIC AND OwnerType = '{$thread->OwnerType}'";

		Doo::db()->query($query);
		$p = (object) Doo::db()->fetchRow($query);

		return $p;
	}

	public static function getFirstUnreadMsgNumberForTopic($playersHighestMsgNumberforTopic, $thread) {
		$query = "SELECT `ID_MSG` FROM fm_messages
			WHERE OwnerType = '{$thread->OwnerType}' AND ID_TOPIC = $thread->ID_TOPIC AND ID_BOARD = $thread->ID_BOARD";

		Doo::db()->query($query);
		$p = (object) Doo::db()->fetchall($query);

		foreach ($p as $value) {
			if ($playersHighestMsgNumberforTopic < $value['ID_MSG']) {
				return $value['ID_MSG'];
			}
		}

		return 0;
	}

	public static function getPageForFirstUnreadMsgForTopic($playersFirstUnreadMessage, $thread) {
		$query = "SELECT `ID_MSG` FROM fm_messages
			WHERE OwnerType = '{$thread->OwnerType}' AND ID_TOPIC = $thread->ID_TOPIC AND ID_BOARD = $thread->ID_BOARD";

		Doo::db()->query($query);
		$p = (object) Doo::db()->fetchall($query);

		$currentPage = 1;
		$numberOfMsgPerPage = Doo::conf()->forumMessagesLimit;
		$n = 1;

		foreach ($p as $value) {
			if ($n > ($numberOfMsgPerPage * $currentPage)) {
				$currentPage++;
			}

			if ($playersFirstUnreadMessage < $value['ID_MSG']) {
				return $currentPage;
			}

			$n++;
		}

		return 1;
	}

	public static function getListOfTopics($ownerId, $ownerType, $boardId) {
		$query = "SELECT `ID_TOPIC` FROM fm_topics
			WHERE ID_OWNER = $ownerId AND OwnerType = '{$ownerType}' AND ID_BOARD = $boardId";

		Doo::db()->query($query);
		$p = (object) Doo::db()->fetchall($query);

		return $p;
	}


	/****** CHECK BANS ON FORUM *******/
	static function ifBannedForum($type, $id, $id_p=""){
		$user = $id_p == "" ?  User::getUser() : User::getById($id_p);

		if($user){
			$data = Doo::db()->getOne('FmBannedPlayerBoardRel', array(
				'limit'  => 1 ,
				'desc' => 'StartDate',
				'where' => 'OwnerType = ? AND ID_OWNER = ? AND ID_PLAYER = ? AND ID_BOARD = 0 AND isHistory = 0',
				'param' => array($type,$id,$user->ID_PLAYER)
				)
			);

			if($data){
				if($data->Unlimited == 1){
					return TRUE;
				}else{
					$current_date = date('Y-m-d');

					if($data->EndDate >= $current_date){
						return TRUE;
					}else{
						return false;
					}
				}
			}else{
				return false;
			}
		}else{
			return false;
		}

	}

	static function ifBannedBoard($type, $id, $board, $id_p=""){
		$user = $id_p == "" ?  User::getUser() : User::getById($id_p);

		if($user){
			$data = Doo::db()->getOne('FmBannedPlayerBoardRel', array(
				'limit'  => 1 ,
				'desc' => 'StartDate',
				'where' => 'OwnerType = ? AND ID_OWNER = ? AND ID_PLAYER = ? AND ID_BOARD = ? AND isHistory = 0',
				'param' => array($type,$id,$user->ID_PLAYER,$board)
				)
			);

			if($data){
				if($data->Unlimited == 1){
					return TRUE;
				}else{
					$current_date = date('Y-m-d');

					if($data->EndDate >= $current_date){
						return TRUE;
					}else{
						return false;
					}
				}
			}else{
				return false;
			}
		}else{
			return false;
		}
	}

	public static function GetNumberOfFollowers($ownerId, $ownerType, $boardId, $topicId) {
		$query = "SELECT COUNT(*) as 'numOfFollowers' FROM fm_notify
			WHERE ID_OWNER = $ownerId AND OwnerType = '{$ownerType}' AND ID_BOARD = $boardId AND ID_TOPIC = $topicId";

		Doo::db()->query($query);
		$p = (object) Doo::db()->fetchRow($query);

		return $p->numOfFollowers;
	}

	public static function TopicPagination($boardOwner, $boardId, $topicId, $topicPaginationUrl) {
		Doo::loadController('SnController');
		$snController = new SnController();
		$forum = new Forum();

		$messagesCount = $forum->getTotalMessages($boardOwner, $boardId, $topicId);
		$pager = $snController->appendPagination($list, null, $messagesCount, $topicPaginationUrl, Doo::conf()->forumMessagesLimit);

		return $pager;
	}

	public static function getSuggestedFriends($playerId, $field) {
		$query = "SELECT * FROM sn_level2friends
			WHERE ID_PLAYER = $playerId AND isFriends = 0 AND isHidden = 0
			AND $field > 0
			ORDER BY RAND() LIMIT 4";

		$p = Doo::db()->fetchall($query);
		return $p;
	}

	public static function getForumSubscribtions($playerId) {
		$data = Doo::db()->find('SnPlayerSubscribtionRel', array(
			'where' => 'ID_PLAYER = ? AND ItemType = ? AND OwnerType <> ?',
			'param' => array($playerId, 'forum', '')
			)
		);

		return $data;
	}

	public static function getLatestForumThreads($subscribtions, $number) {
		if ($number == 0) {
			$options['where'] = "ID_OWNER = 1 AND OwnerType = 'company'";
			$options['desc'] = "ID_TOPIC";
			$options['limit'] = 5;

			$data = MainHelper::getCompanyInfo(1);
			$p[] = array(
				'name' => $data->CompanyName,
				'forumURL' => $data->FORUM_URL
			);
			$p[0]['threads'] = Doo::db()->find('FmTopics', $options);
		} else {
			foreach ($subscribtions as $key => $value) {
				if ($value->OwnerType == 'game') {
					$data = MainHelper::getGameInfo($value->ID_OWNER);
					$p[] = array(
						'name' => $data->GameName,
						'forumURL' => $data->FORUM_URL
					);
				} else if ($value->OwnerType == 'group') {
					$data = MainHelper::getGroupInfo($value->ID_OWNER);
					$p[] = array(
						'name' => $data->GroupName,
						'forumURL' => $data->FORUM_URL
					);
				} else {
					$data = MainHelper::getCompanyInfo($value->ID_OWNER);
					$p[] = array(
						'name' => $data->CompanyName,
						'forumURL' => $data->FORUM_URL
					);
				}

				$options['where'] = "ID_OWNER = $value->ID_OWNER AND OwnerType = '{$value->OwnerType}'";
				$options['desc'] = "ID_TOPIC";
				$options['limit'] = 5;
				$p[$key]['threads'] = Doo::db()->find('FmTopics', $options);
			}
		}

		return $p;
	}

	public static function getFirstTopicMessage($topic) {
		$data = Doo::db()->getOne('FmMessages', array(
			'where' => 'ID_OWNER = ? AND OwnerType = ? AND ID_MSG = ? AND ID_TOPIC = ?',
			'param' => array($topic->ID_OWNER, $topic->OwnerType, $topic->ID_FIRST_MSG, $topic->ID_TOPIC)
			)
		);

		return $data;
	}

	public static function getCompanyInfo($id) {
		$company = new SnCompanies();
		$company->ID_COMPANY = $id;
		$company = $company->getOne();

		return $company;
	}

	public static function getGameInfo($id) {
		$game = new SnGames();
		$game->ID_GAME = $id;
		$game = $game->getOne();

		return $game;
	}

	public static function getGroupInfo($id) {
		$group = new SnGroups();
		$group->ID_GROUP = $id;
		$group = $group->getOne();

		return $group;
	}

	public static function getComingGames() {
		$options['where'] = "CreationDate > '" . date('Y-m-d') . "'";
		$options['asc'] = "CreationDate";
		$options['limit'] = 5;
		$data = Doo::db()->find('SnGames', $options);

		return $data;
	}

	public static function getListOfMatches($teamID) {
		$query = "SELECT es_leagues.*, es_teams.*, es_matches.* 
			FROM es_leagues 
			INNER JOIN es_teams ON es_teams.ID_TEAM = $teamID 
			INNER JOIN es_matches ON es_leagues.ID_LEAGUE = es_matches.FK_LEAGUE 
			WHERE (es_matches.ChallengerID = $teamID OR es_matches.OpponentID = $teamID) AND es_matches.State = 4 
			LIMIT 5";

		$p = Doo::db()->fetchall($query);
		return $p;
	}

	public static function getTeamInfo($id) {
		$team = new EsTeams();
		$team->ID_TEAM = $id;
		$team = $team->getOne();

		return $team;
	}

}
?>
