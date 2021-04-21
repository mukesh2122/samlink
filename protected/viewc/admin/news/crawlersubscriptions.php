<form action="<?php echo MainHelper::site_url('admin/news/crawlersubscriptions'); ?>" method="post">
	<table cellspacing="0" cellpadding="0" class="table table_bordered table_striped gradient_thead mt10">
		<thead>
			<tr>
				<th class="size_50 centered"><?php echo $this->__('Name'); ?></th>
				<th class="size_20 centered"><?php echo $this->__('Last updated'); ?></th>
				<th class="size_10 centered"><?php echo $this->__('Active'); ?></th>
			</tr>
		</thead>
		<tbody>
			<?php if(isset($sites) and !empty($sites)):?>
				<?php foreach ($sites as $site):?>
					<tr>
						<td>
							<?php echo $site->Name; ?>
						</td>
						<td class="centered">
							<?php echo date('Y-m-d H:i', $site->LastUpdateTime); ?>
						</td>
						<td class="centered">
							<input type="checkbox" name="<?php echo $site->ID_SITE; ?>" <?php if ($site->isActive) echo 'checked="checked"'; ?> />
						</td>
					</tr>
				<?php endforeach;?>
			<?php else: ?>
				<tr>
					<td colspan="3" class="centered">
						<?php echo $this->__('There are currently no available subscriptions'); ?>
					</td>
				</tr>
			<?php endif; ?>
			<tr>
				<td colspan="4">
					<button class="button button_auto light_blue pull_left" type="reset" value="Reset" style="padding:10px;">
						<?php echo $this->__('Cancel'); ?>
					</button>
					<button class="button button_auto light_blue pull_right" type="submit" value="Submit" style="padding:10px;">
						<?php echo $this->__('Save'); ?>
					</button>
				</td>
			</tr>
		</tbody>
	</table>
</form>

