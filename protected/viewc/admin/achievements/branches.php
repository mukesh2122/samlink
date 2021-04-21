<table cellspacing="0" cellpadding="0" class="table table_bordered table_striped gradient_thead mt10">
	<thead>
		<tr>
			<th class="size_10 centered"><?php echo $this->__('ID');?></th>
			<th class="size_20 centered"><?php echo $this->__('Name');?></th>
                        <th class="size_50 centered"><?php echo $this->__('Description');?></th>
			<th class="size_10 centered"><?php echo $this->__('Action');?></th>
		</tr>
	</thead>
	<tbody>
	<?php
	$player = User::getUser();
	if(isset($branches) and !empty($branches)) {
		foreach($branches as $branch):?>
			<?php if($player->canAccess('Edit achievement information') === TRUE): ?>
				<tr>
					<td class="centered"><?php echo $branch->ID_BRANCH;?></td>
					<td class="centered"><?php echo $branch->BranchName;?></td>
                                        <td class="centered"><?php echo $branch->BranchDesc;?></td>
					<td class="centered">
						<a href="<?php echo MainHelper::site_url('admin/achievements/editbranch/'.$branch->ID_BRANCH);?>"><?php echo $this->__('Edit');?></a>
					</td>
				</tr>
			<?php endif; ?>
		<?php endforeach;
	}
	?>
		<?php if($player->canAccess('*') === TRUE): ?>
		<tr>
			<td colspan="4">
				<a href="<?php echo MainHelper::site_url('admin/achievements/newbranch');?>" class="button button_auto light_blue pull_right"><?php echo $this->__('Add branch');?></a>
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