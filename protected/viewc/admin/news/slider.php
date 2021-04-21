<table cellspacing="0" cellpadding="0" class="table table_bordered table_striped gradient_thead mt10">
	<?php if(isset($slides) and !empty($slides)):?>
		<thead>
			<tr>
				<th class="size_10 centered"><?php echo $this->__('Image');?></th>
				<th class="size_20 centered"><?php echo $this->__('Headline');?></th>
				<th class="size_20 centered"><?php echo $this->__('URL');?></th>
				<th class="size_10 centered"><?php echo $this->__('Priority');?></th>
				<th class="size_10 centered"><?php echo $this->__('Active');?></th>
				<th class="size_10 centered"><?php echo $this->__('Action');?></th>
			</tr>
		</thead>
		<tbody>
			<?php foreach ($slides as $slide):?>
				<tr>
					<td><?php echo $slide->Image; ?></td>
					<td><?php echo $slide->Headline; ?></td>
					<td>
						<textarea disabled readonly style="background-color:transparent;border:0;resize:none" cols="25" rows="<?php echo ceil(strlen($slide->URL)/25); ?>"><?php echo $slide->URL; ?></textarea>
					</td>
					<td class="centered"><?php echo $slide->Priority; ?></td>
					<td class="centered"><?php echo ($slide->isActive) ? $this->__('Yes') : $this->__('No'); ?></td>
					<td class="centered">
						<a href="<?php echo MainHelper::site_url('admin/news/frontpage/slider/edit/'.$slide->ID_SLIDE);?>">
							<?php echo $this->__('Edit');?>
						</a>
						<br />
						<a href="<?php echo MainHelper::site_url('admin/news/frontpage/slider/delete/'.$slide->ID_SLIDE);?>" onClick="return confirm('<?php echo $this->__('Are you sure you wish to delete the slide?'); ?>');">
							<?php echo $this->__('Delete');?>
						</a>
					</td>
				</tr>
			<?php endforeach;?>
		<?php endif; ?>
		<tr>
			<td colspan="7">
				<form action="<?php echo MainHelper::site_url('admin/news/frontpage/slider/edit/0'); ?>">
					<input type="submit" class="button button_auto light_blue pull_right" value="<?php echo $this->__('Add slide'); ?>" />
				</form>
			</td>
		</tr>
	</tbody>
</table>
