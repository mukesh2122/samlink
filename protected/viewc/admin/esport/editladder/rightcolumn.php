<div class="esports_right_column">
	<!-- Header start -->
	<div id="news_header">
		<img src="<?php echo MainHelper::site_url('global/img/icon.png');?>" alt=""/>
		<span>E-Sport Admin - Edit ladder leagues</span>
	</div>
	<!-- Header end -->

	
<form name="ladderform"  method="post" action="<?php echo MainHelper::site_url('esport/admin/editladder'); ?>">
	<input type="hidden" name="action" value="submitall" />
	<table cellspacing="0" cellpadding="0" class="table table_bordered table_striped gradient_thead mt10">
		<thead>
			<tr>
				<th class="size_10 centered"><?php echo $this->__('Image');?></th>
				<th class="size_25 centered"><?php echo $this->__('Min rating');?></th>
				<th class="size_25 centered"><?php echo $this->__('Max rating');?></th>
			</tr>
		</thead>

		<tbody>

	<?php
		$p = User::getUser();
		$esport = new Esport();
		$playmodes = $esport->GetPlayModes();

		$ladderLeagues = $esport->GetLadderLeagues();
		$i = 0;
		foreach ($ladderLeagues as $ll):
			$min = $ll['min'];
			$max = $ll['max'];
			$img = $ll['img'];
		?>
			<tr>
				<td class="size_25 centered"><img height="64px" src="<?php echo MainHelper::site_url('global/img/esport/medals/'.$img); ?>" /></td>
				<td class="size_25 centered">
					<input name="min<?php echo $i; ?>" class="text_input w200" type="text" value="<?php echo $min; ?>" />
				</td>
				<td class="size_25 centered">
					<input name="max<?php echo $i; ?>" class=" text_input w200" type="text" value="<?php echo $max; ?>" />
				</td>
			</tr>
	<?php $i++; 
		endforeach; ?>
		</tbody>
	</table>
	
	<div class="clearfix mt10 mr10">
		<input class="button button_auto light_blue pull_right" type="submit" value="<?php echo $this->__('Save'); ?>" />
	</div>

		
</form>
	
	
	
</div>
