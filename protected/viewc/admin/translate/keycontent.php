<?php
$KeyWord = "";
$ChangeWord = "";
if (isset($_POST['KeyWord']))
	$KeyWord = $_POST['KeyWord'];
if (isset($_POST['ChangeWord']))
	$ChangeWord = $_POST['ChangeWord'];
?>

<form class="standard_form" method="post" action="<?php echo MainHelper::site_url('admin/translate/keycontent/lang/'.$translate->A2); ?>" name="keycontentform" id="keycontentform">
	<input type="hidden" id="submitmode" name="submitmode" value="preview" />

	<div class="standard_form_header clearfix">
		<h1 class="pull_left"><?php echo 'Change key content'; ?></h1>
	</div>

	<div class="standard_form_elements clearfix">
		<div class="clearfix">
			<label for="TransKey">
				<?php echo "Key word to change"; ?>
			</label>
			<div class="standard_form_checks_wrapper no-margin clearfix">
				<span>
					<input tabindex="1" id="KeyWord" name="KeyWord" type="text" value="<?php echo $KeyWord; ?>" class="text_input" />
				</span>
			</div>
		</div>
		<br/>
		<div class="clearfix">
			<label for="TransKey">
				<?php echo "Changed to"; ?>
			</label>
			<div class="standard_form_checks_wrapper no-margin clearfix">
				<span>
					<input tabindex="2" id="ChangeWord" name="ChangeWord" type="text" value="<?php echo $ChangeWord; ?>" class="text_input" />
				</span>
			</div>
		</div>


	</div>
	<div class="standard_form_footer clearfix">
		<input tabindex="3" class="button button_auto light_blue pull_right" type="submit" value="<?php echo 'Preview'; ?>" onclick="document.keycontentform.submitmode.value = 'preview';" />
	</div>

	<?php
		if ($KeyWord!="")
		{
			//Show groups results
			$groupTypes = $translate->GetGroupTypes();
			$any = 0;
			$html = "";
			foreach ($groupTypes as $groupType)
			{
				$groupTexts = $translate->GetGroupTexts($groupType);
				$htmlInGroup = '<tr><td colspan="3" class="centered">Group: <b>'.$groupType.'</b></td></tr>';
				$anyInGroup = 0;
				foreach ($groupTexts as $gt)
				{
					$ID_TEXT = $gt['ID_TEXT'];
					$TransText = $gt['groupName'];
					if (strpos($TransText, $KeyWord)!== false)
					{
						$anyInGroup++;
						$TransTextInfo = str_replace($KeyWord,"<b>".$KeyWord."</b>",$TransText);
						$TransTextChanged = str_replace($KeyWord,"<b>".$ChangeWord."</b>",$TransText);
						
						$cb = '<input name="'.$groupType.'TXT'.$ID_TEXT.'" type="checkbox" checked="true" />';
						$htmlInGroup .= "<tr><td>{$cb}</td><td>{$TransTextInfo}</td><td>{$TransTextChanged}</td></tr>";
					}
				}
				if ($anyInGroup)
				{
					$html .= $htmlInGroup;
					$any += $anyInGroup;
				}
			}


			$query = "SELECT * FROM ge_screentexts WHERE TransText".$translate->A2." LIKE BINARY '%$KeyWord%'";
			$rs = Doo::db()->query($query)->fetchall();
			if (count($rs) > 0 || $any > 0)
			{
			?>
			<table cellspacing="0" cellpadding="0" class="table table_bordered table_striped gradient_thead mt10">
			<thead>
				<tr>
					<th>
						<input name="allnone" type="checkbox" checked="true" onclick="
						for (i=0;i<document.forms.keycontentform.elements.length;i++)
						{
							e = document.forms.keycontentform.elements[i];
							if (e.type=='checkbox')
								e.checked = this.checked;
						}"/>
					</th>
					<th>Old text</th><th>New text</th>
				</tr>
			</thead>
			<tbody>
			<?php
			$query = "SELECT * FROM ge_screentexts WHERE TransText".$translate->A2." LIKE BINARY '%$KeyWord%'";
			$rs = Doo::db()->query($query)->fetchall();
			echo '<tr><td colspan="3" class="centered">Texts</td></tr>';
			for($i=0;$i<count($rs);$i++)
			{
				echo "<tr>";
				$row = $rs[$i];
				$ID_TEXT = $row['ID_TEXT'];
				$TransKey = $row['TransKey'];
				$TransText = $row['TransText'.$translate->A2];

				$TransTextInfo = str_replace($KeyWord,"<b>".$KeyWord."</b>",$TransText);
				$TransTextChanged = str_replace($KeyWord,"<b>".$ChangeWord."</b>",$TransText);

				$cb = '<input name="TEXT'.$ID_TEXT.'" type="checkbox" checked="true" />';
				echo "<td>{$cb}</td><td>{$TransTextInfo}</td><td>{$TransTextChanged}</td>";

				echo "<tr/>";
			}

			//if ($any>0)
			{
				echo $html;
			}

			echo "</tbody>";






			?>





			</table>
			<div class="standard_form_footer clearfix">
				<input tabindex="4" class="button button_auto light_blue pull_right" type="submit" value="<?php echo 'Submit'; ?>" onclick="var c = confirm('Are you sure you want to submit?');if (c){document.keycontentform.submitmode.value = 'submit';}return c;" />
			</div>
			<?php
			}
		}
	?>

</form>




<script type="text/javascript">//loadCheckboxes();</script>
