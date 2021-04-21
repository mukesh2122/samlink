<?php
	function displayValue($name, $params) {
		$result = '';
		switch ($params['type']) {
			case 'ValueInt':
				$result = '<input class="size_80 centered" name="'.$name.'" type="text" value="'.$params['value'].'" />';
			break;
			case 'ValueBool':
				$result = '<select class="size_80 centered" name="'.$name.'">'
				.	'<option class="centered" value=""  '.($params['value']=='' ?'selected':'').'></option>'
				.	'<option class="centered" value="1" '.($params['value']=='1'?'selected':'').'>'.SnController::__('Yes').'</option>'
				.	'<option class="centered" value="0" '.($params['value']=='0'?'selected':'').'>'.SnController::__('No').'</option>'
				.	'</select>';
			break;
		}
		return $result;
	}
	
?>

<form method="post" action="<?php echo MainHelper::site_url('admin/news/crawlerglobals'); ?>">
	<table cellspacing="0" cellpadding="0" class="table table_bordered table_striped gradient_thead mt10">
		<thead>
			<tr>
				<th class="size_60 centered"><?php echo $this->__('Key');?></th>
				<th class="size_40 centered"><?php echo $this->__('Value');?></th>
			</tr>
		</thead>
		<tbody>
			<?php if (isset($crawlerParams) && !empty($crawlerParams)) : ?>
				<?php foreach($crawlerParams as $name => $params) : ?>
				<tr>
					<td><?php echo $this->__($name); ?></td>
					<td class="centered">
						<?php echo displayValue($name, $params); ?>
					</td>
				</tr>
				<?php endforeach; ?>
			<?php endif; ?>
			<tr>
				<td colspan="2">
					<input type="submit" class="button button_auto light_blue pull_right" value="<?php echo $this->__('Save'); ?>" />
				</td>
			</tr>
		</tbody>
	</table>
</form>
