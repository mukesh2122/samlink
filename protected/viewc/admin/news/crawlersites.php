<?php if(isset($sites) and !empty($sites)):?>
	<table cellspacing="0" cellpadding="0" class="table table_bordered table_striped gradient_thead mt10">
		<thead>
			<tr>
				<th class="size_40 centered"><?php echo $this->__('Site name'); ?></th>
				<th class="size_10 centered"><?php echo $this->__('Language'); ?></th>
				<th class="size_20 centered"><?php echo $this->__('Last updated'); ?></th>
				<th class="size_10 centered"><?php echo $this->__('Internal'); ?></th>
				<th class="size_10 centered"><?php echo $this->__('Active'); ?></th>
				<th class="size_10 centered"><?php echo $this->__('Action'); ?></th>
			</tr>
		</thead>
		<tbody>
			<?php foreach ($sites as $site):?>
			<tr>
				<td>
					<?php echo $site->Name; ?>
				</td>
				<td class="centered">
					<?php echo $this->__(Doo::conf()->langName[$site->ID_LANGUAGE]); ?>
				</td>
				<td class="centered">
					<?php echo date('Y-m-d H:i', $site->LastUpdateTime); ?>
				</td>
				<td class="centered">
					<?php echo ($site->isInternal) ? $this->__('Yes') : $this->__('No'); ?>
				</td>
				<td class="centered">
					<?php echo ($site->isActive) ? $this->__('Yes') : $this->__('No'); ?>
				</td>
				<td class="centered">
					<a href="<?php echo MainHelper::site_url('admin/news/crawlersites/edit/'.$site->ID_SITE); ?>">
						<?php echo $this->__('Edit');?>
					</a>
					<br />
					<a href="<?php echo MainHelper::site_url('admin/news/crawlersites/delete/'.$site->ID_SITE); ?>">
						<?php echo $this->__('Delete');?>
					</a>
				</td>
			</tr>
			<?php endforeach;?>
			<tr>
				<td colspan="6">
					<form action="<?php echo MainHelper::site_url('admin/news/crawlersites/edit/0'); ?>">
						<input type="submit" class="button button_auto light_blue pull_right" value="<?php echo $this->__('Add site'); ?>" />
					</form>
				</td>
			</tr>
		</tbody>
	</table>
<?php endif; ?>
