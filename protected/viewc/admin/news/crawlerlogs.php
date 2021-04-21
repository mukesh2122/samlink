<table cellspacing="0" cellpadding="0" class="table table_bordered table_striped gradient_thead mt10">
	<thead>
		<tr>
			<th class="size_20 centered"><?php echo $this->__('Start Time');?></th>
			<th class="size_20 centered"><?php echo $this->__('Update Time');?></th>
			<th class="size_20 centered"><?php echo $this->__('End Time');?></th>
			<th class="size_20 centered"><?php echo $this->__('Status');?></th>
			<th class="size_20 centered"><?php echo $this->__('Action');?></th>
		</tr>
	</thead>
	<tbody>
		<?php if (empty($logs)): ?>
			<tr><td class="centered" colspan="5"><?php echo $this->__('No logs available'); ?></td></tr>
		<?php else: ?>
			<?php foreach($logs as $log): ?>
				<tr>
					<td class="centered"><?php echo $log->LogStartTime > 0  ? date('d/m/Y h:i:s', $log->LogStartTime) : '-'; ?></td>
					<td class="centered"><?php echo $log->LogUpdateTime > 0 ? date('d/m/Y h:i:s', $log->LogUpdateTime): '-'; ?></td>
					<td class="centered"><?php echo $log->LogEndTime > 0    ? date('d/m/Y h:i:s', $log->LogEndTime)   : '-'; ?></td>
					<td class="centered"><?php echo $log->LogStatus; ?></td>
					<td class="centered">
						<div class="pull_left" style="width:50%;">
							<a href="javascript:void(0);" title="<?php echo $log->LogReport; ?>"><?php echo $this->__('View'); ?></a>
						</div>
						<div class="pull_left" style="width:50%;">
							<a class="delete_log" rel="<?php echo $log->ID_LOG; ?>" href="javascript:void(0)"><?php echo $this->__('Delete'); ?></a>
						</div>
					</td>
				</tr>
			<?php endforeach; ?>
		<?php endif; ?>
	</tbody>
</table>
<script type="text/javascript">
	$(document).ready(function(){
		$('.delete_log').click(function(){
			if (confirm('<?php echo $this->__('Are you sure you want to delete this record?'); ?>')){
				var data = {};
				data.crawlerlog = {};
				data.crawlerlog.id = $(this).attr('rel');
				$.post(site_url+'admin/news/ajaxdeletecrawlerlog', data, function(result) {
					document.location.reload(true);
				});
			}
		});
	});
</script>