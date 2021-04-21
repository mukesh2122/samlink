<h3>Right column (Widgets)</h3>
<?php if(isset($widgets) and !empty($widgets)): ?>
	<table cellspacing="0" cellpadding="0" class="table table_bordered table_striped gradient_thead mt10">
		<thead>
			<tr>
				<th class="size_10 centered"><?php echo 'ID'; ?></th>
				<th class="size_30 centered"><?php echo $this->__('Name'); ?></th>
				<th class="size_20 centered"><?php echo $this->__('Module'); ?></th>
				<th class="size_20 centered"><?php echo $this->__('Is default?'); ?></th>
				<th class="size_20 centered"><?php echo $this->__('Is hidden?'); ?></th>
				<th class="size_10 centered"><?php echo $this->__('Action');?></th>
			</tr>
		</thead>
		<tbody>
			<?php foreach($widgets as $widget): ?>
				<tr>
					<td class="centered"><?php echo $widget['ID_WIDGET']; ?></td>
					<td><?php echo $widget['Name']; ?></td>
					<td><?php echo $widget['Module']; ?></td>
					<td><?php echo $widget['isDefault']; ?></td>
					<td><?php echo $widget['isHidden']; ?></td>
					<td class="centered">
						<a href="<?php echo MainHelper::site_url('admin/setup/layout/right-column/edit-widget/'.$widget['ID_WIDGET']);?>"><?php echo $this->__('Edit');?></a>
					</td>
				</tr>
			<?php endforeach; ?>
		</tbody>
	</table>
	<?php
endif;
?>
<div class="mt10">
	<a href="<?php echo MainHelper::site_url('admin/setup/layout/right-column/new-widget'); ?>" class="button button_auto light_blue pull_right"><?php echo $this->__('New widget'); ?></a>
</div>