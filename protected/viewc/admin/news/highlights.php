<table cellspacing="0" cellpadding="0" class="table table_bordered table_striped gradient_thead mt10">
	<?php if(isset($highlights) and !empty($highlights)):?>
		<thead>
			<tr>
				<th class="size_10 centered"><?php echo $this->__('Image');?></th>
				<th class="size_20 centered"><?php echo $this->__('Headline');?></th>
				<th class="size_30 centered"><?php echo $this->__('IntroText');?></th>
				<th class="size_20 centered"><?php echo $this->__('URL');?></th>
				<th class="size_10 centered"><?php echo $this->__('Priority');?></th>
				<th class="size_10 centered"><?php echo $this->__('Active');?></th>
				<th class="size_10 centered"><?php echo $this->__('Action');?></th>
			</tr>
		</thead>
		<tbody>
			<?php foreach ($highlights as $highlight):?>
				<tr>
					<td><?php echo $highlight->Image; ?></td>
					<td><?php echo $highlight->Headline; ?></td>
					<td><?php echo $highlight->IntroText; ?></td>
					<td>
						<textarea disabled readonly style="background-color:transparent;border:0;resize:none" cols="25" rows="<?php echo ceil(strlen($highlight->URL)/25); ?>"><?php echo $highlight->URL; ?></textarea>
					</td>
					<td class="centered"><?php echo $highlight->Priority; ?></td>
					<td class="centered"><?php echo ($highlight->isActive) ? $this->__('Yes') : $this->__('No'); ?></td>
					<td class="centered">
						<a href="<?php echo MainHelper::site_url('admin/news/frontpage/highlights/edit/'.$highlight->ID_HIGHLIGHT);?>">
							<?php echo $this->__('Edit');?>
						</a>
						<a href="<?php echo MainHelper::site_url('admin/news/frontpage/highlights/delete/'.$highlight->ID_HIGHLIGHT);?>" onClick="return confirm('<?php echo $this->__('Are you sure you wish to delete the highlight?'); ?>');">
							<?php echo $this->__('Delete');?>
						</a>
					</td>
				</tr>
			<?php endforeach;?>
		<?php endif; ?>
		<tr>
			<td colspan="7">
				<form action="<?php echo MainHelper::site_url('admin/news/frontpage/highlights/edit/0'); ?>">
					<input type="submit" class="button button_auto light_blue pull_right" value="<?php echo $this->__('Add highlight'); ?>" />
				</form>
			</td>
		</tr>
	</tbody>
</table>
