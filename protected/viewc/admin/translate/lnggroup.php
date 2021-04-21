<?php
	$missing = $translate->GetGroupMissingTrans($grouptype);
	$sum = 0;
	$missingList = "";
	foreach ($missing as $r)
	{
		$missing = $r['missing'];
		$sum += $missing;
		if ($missing==1)
		{
			$missingList .= "{$r['groupName']}<br/>";
		}
	}
	if ($sum>0)
	{
		?>
		<form name="missingform" method="post" action="
<?php echo MainHelper::site_url('admin/translate/lnggroup/'.$grouptype.'/lang'.(isset($translate->A2) ? ('/'.$translate->A2) : '') );
; ?>">
		<input type="hidden" name="missingaction" id="missingaction" value="importmissing"/>
	<table cellspacing="0" cellpadding="0" class="table table_bordered table_striped gradient_thead mt10">
		<thead>
			<tr>
				<th>
					<p>Missing translated entries in <?php echo "{$translate->A2}: $sum"; ?></p>
				</th>
			</tr>
		</thead>
		<tbody>
			<tr>
				<td>
					<p><?php echo "{$missingList}"; ?></p>
				</td>
			</tr>
			<tr>
				<td>
					<input type="submit" class="button button_auto light_blue pull_right" value="<?php echo $this->__('Import'); ?>" />
				</td>
			</tr>
		</tbody>
	</table>
		</form>
	<?php } ?>
				


<form class="c_column_search clearfix" name="searchform" method="post" action=
"<?php echo MainHelper::site_url('admin/translate/lnggroup/'.$grouptype.'/lang'.(isset($translate->A2) ? ('/'.$translate->A2) : '') );
; ?>">
<input type="text" class="c_column_search_input withLabel"  name="search" id="search" value="<?php if (isset($translate->search)) echo $translate->search; ?>" />
<input type="submit" class="c_column_search_button green" value="Search" />
</form>

<form name="lnggroupform" method="post" action=
"<?php echo MainHelper::site_url('admin/translate/lnggroup/'.$grouptype.'/lang'.(isset($translate->A2) ? ('/'.$translate->A2) : '') );
; ?>">

<input type="hidden" id="ID_LANGUAGE" name="ID_LANGUAGE" value="<?php echo $translate->GetLangID($translate->A2); ?>" />

<table cellspacing="0" cellpadding="0" class="table table_bordered table_striped gradient_thead mt10">
	<thead>
		<tr>
			<th class="size_25 centered">EN</th>
			<th class="size_25 centered"><?php echo $translate->A2;?></th>
		</tr>
	</thead>

	<tbody>
	<?php
		$groupTexts = $translate->GetGroupTexts($grouptype,$translate->search);
		$i = 0;
		foreach($groupTexts as $gt)
		{
			$name = "textarea{$gt['ID_group']}";
			$t = $gt['groupName'];$r = floor(strlen($t) / 36) + count(explode('\n',$t));
			?>
			<tr>
				<td class="centered" style="width:45%;"><?php echo $gt['groupNameEN']; ?></td>
				<td class="centered" style="width:45%;">
				<textarea rows="<?php echo $r; ?>" cols="36" tabindex="1" 
					name="<?php echo $name; ?>" id="<?php echo $name; ?>"
					onkeyup="t=this.value;this.rows = Math.floor(t.length / this.cols) + t.split('\n').length;"
				><?php echo $gt['groupName']; ?></textarea>
				</td>
			</tr>
			<?php
			$i++;
		}

	?>
		<tr>
			<td colspan="3">
				<input type="submit" class="button button_auto light_blue pull_right" value="Save" />
			</td>
		</tr>
	<tbody>
</table>
</form>
