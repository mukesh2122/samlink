
<table cellspacing="0" cellpadding="0" class="table table_bordered table_striped gradient_thead mt10">
	<thead>
		<tr>
			<th class="size_20 centered"><?php echo $this->__('Name');?></th>
			<th class="size_30 centered"><?php echo $this->__('Description');?></th>
			<th class="size_10 centered"><?php echo $this->__('Points');?></th>
			<th class="size_10 centered"><?php echo $this->__('Multiplier');?></th>
                        <th class="size_20 centered"><?php echo $this->__('Image');?></th>
			<th class="size_10 centered"><?php echo $this->__('Action');?></th>
		</tr>
	</thead>
	<tbody>
	<?php
	$player = User::getUser();
	if(isset($levels) and !empty($levels)) {
		foreach($levels as $level):?>
			<?php if($player->canAccess('Edit achievement information') === TRUE): ?>
				<tr>
					<td class="centered"><?php echo $level->LevelName;?></td>
					<td class="centered"><?php echo $level->LevelDesc;?></td>
					<td class="centered"><?php echo $level->Points;?></td>
					<td class="centered"><?php echo $level->Multiplier;?></td>
					<td class="centered"><?php echo $level->ImageURL;?></td>
					<td class="centered">
						<a href="<?php echo MainHelper::site_url('admin/achievements/editlevel/').$level->ID_LEVEL;?>"><?php echo $this->__('Edit');?></a>
					</td>
				</tr>
			<?php endif; ?>
		<?php endforeach;
	}
	?>
		<?php if($player->canAccess('*') === TRUE): ?>
		<tr>
			<td colspan="6">
				<a href="<?php echo MainHelper::site_url('admin/achievements/newlevel');?>" class="button button_auto light_blue pull_right"><?php echo $this->__('Add level');?></a>
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