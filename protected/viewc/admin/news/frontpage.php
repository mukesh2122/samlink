<?php if(isset($modules) and !empty($modules)):?>
	<form method="post" action="<?php echo MainHelper::site_url('admin/news/frontpage'); ?>">
		<table cellspacing="0" cellpadding="0" class="table table_bordered table_striped gradient_thead mt10">
			<thead>
				<tr>
					<th class="size_30 centered"><?php echo $this->__('Name');?></th>
					<th class="size_10 centered"><?php echo $this->__('Frontpage');?></th>
					<th class="size_10 centered"><?php echo $this->__('News');?></th>
					<th class="size_10 centered"><?php echo $this->__('FTU');?></th>
					<th class="size_10 centered"><?php echo $this->__('Action');?></th>
				</tr>
			</thead>
			<tbody>
				<?php foreach ($modules as $module):?>
				<tr>
					<td>
						<?php echo $module->Name; ?>
					</td>
					<td class="centered">
						<input type="checkbox" name="<?php echo $module->ID_FRONTPAGE.'_Frontpage'; ?>" <?php echo ($module->Frontpage) ? 'checked' : ''; ?> />
					</td>
					<td class="centered">
						<input type="checkbox" name="<?php echo $module->ID_FRONTPAGE.'_News'; ?>" <?php echo ($module->News) ? 'checked' : ''; ?> />
					</td>
					<td class="centered">
						<input type="checkbox" name="<?php echo $module->ID_FRONTPAGE.'_FTU'; ?>" <?php echo ($module->FTU) ? 'checked' : ''; ?> />
					</td>
					<td class="centered">
						<?php if ($module->Setup) : ?>
						<a href="<?php echo MainHelper::site_url('admin/news/frontpage/'.urlencode(strtolower($module->Name))); ?>">Edit</a>
						<?php endif; ?>
					</td>
				</tr>
				<?php endforeach;?>
				<tr>
					<td colspan="5">
						<input type="submit" class="button button_auto light_blue pull_right" value="<?php echo $this->__('Save'); ?>" />
					</td>
				</tr>
			</tbody>
		</table>
	</form>
<?php endif; ?>
