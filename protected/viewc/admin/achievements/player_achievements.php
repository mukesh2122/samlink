<?php
	echo $this->renderBlock('players/common/search', array(
		'url' => MainHelper::site_url('admin/users/search'),
		'searchText' => isset($searchText) ? $searchText : '',
		'searchTotal' => isset($searchTotal) ? $searchTotal : 0
	));
?>
<table cellspacing="0" cellpadding="0" class="table table_bordered table_striped gradient_thead mt10">
	<thead>
		<tr>
			<th class="size_20 centered"><?php echo $this->__('Player');?></th>
			<th class="size_40 centered"><?php echo $this->__('Achievement');?></th>
			<th class="size_20 centered"><?php echo $this->__('Date Achieved');?></th>
		</tr>
	</thead>
	<tbody>
	<?php
	$player = User::getUser();
	if(isset($achievements) and !empty($achievements)) {
		foreach($achievements as $achievement):?>
			<?php if($player->canAccess('Edit achievement information') === TRUE): ?>
				<tr>
					<td class="centered"><?php echo $achievement->DisplayName;?></td>
					<td class="centered"><?php echo $achievement->Achievement;?></td>
					<td class="centered"><?php echo date(DATE_FULL ,$achievement->AchievementTime);?></td>
				</tr>
			<?php endif; ?>
		<?php endforeach;
	}
	?>
	</tbody>
</table>
<?php
if(isset($pager)){
	echo $this->renderBlock('common/pagination', array('pager'=>$pager));
}
?>