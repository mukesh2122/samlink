
<table cellspacing="0" cellpadding="0" class="table table_bordered table_striped gradient_thead mt10">
	<thead>
		<tr>
			<th class="size_20 centered"><?php echo $this->__('Name');?></th>
			<th class="size_30 centered"><?php echo $this->__('Description');?></th>
			<th class="size_10 centered"><?php echo $this->__('Active');?></th>
                        <th class="size_10 centered"><?php echo $this->__('Branch');?></th>
			<th class="size_10 centered"><?php echo $this->__('Action');?></th>
		</tr>
	</thead>
	<tbody>
	<?php
	$player = User::getUser();
	if(isset($achievements) and !empty($achievements)) {
		foreach($achievements as $achievement):?>
			<?php if($player->canAccess('Edit achievement information') === TRUE): ?>
				<tr>
					<td class="centered"><?php echo $achievement->AchievementName;?></td>
					<td class="centered"><?php echo $achievement->AchievementDesc;?></td>
					<td class="centered"><?php echo $achievement->isActive;?></td>
					<td class="centered"><?php echo $achievement->FK_BRANCH;?></td>
					<td class="centered">
						<a href="<?php echo MainHelper::site_url('admin/achievements/edit/').$achievement->ID_ACHIEVEMENT;?>"><?php echo $this->__('Edit');?></a>
					</td>
				</tr>
			<?php endif; ?>
		<?php endforeach;
	}
	?>
		<?php if($player->canAccess('*') === TRUE): ?>
		<tr>
			<td colspan="6">
				<a href="<?php echo MainHelper::site_url('admin/achievements/newachievement');?>" class="button button_auto light_blue pull_right"><?php echo $this->__('Add achievement');?></a>
			</td>
		</tr>
		<?php endif; ?>
	</tbody>
</table>
<?php
if(isset($pager)){
	echo $this->renderBlock('common/pagination', array('pager'=>$pager));
}
?>