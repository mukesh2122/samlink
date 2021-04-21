<?php echo $this->renderBlock('shop/common/search', array(
	'url' => MainHelper::site_url('admin/shop/search'),
	'searchText' => isset($searchText) ? $searchText : '',
	'searchTotal' => isset($searchTotal) ? $searchTotal : 0,
	'label' => $label = 'Search for features...',
	'type' => $type = 'shop'
));?>
<?php if(isset($features) and !empty($features)):?>
	<table cellspacing="0" cellpadding="0" class="table table_bordered table_striped gradient_thead mt10">
		<thead>
			<tr>
				<th class="size_10 centered"><?php echo 'ID';?></th>
				<th class="size_100 centered"><?php echo 'Name';?></th>
				<th class="size_10 centered"><?php echo 'Position';?></th>
				<th class="size_20 centered"><?php echo $this->__('Action');?></th>
			</tr>
		</thead>

		<tbody>
			<?php foreach($features as $feature):?>
				<tr>
					<td class="centered"><?php echo $feature->ID_FEATURE;?></td>
					<td class="centered"><?php echo $feature->FeatureName;?></td>
					<td class="centered"><?php echo $feature->Position;?></td>
					<td class="centered">
						<a href="<?php echo MainHelper::site_url('admin/shop/features/'.$feature->ID_FEATURE);?>"><?php echo 'Edit';?></a>
					</td>
				</tr>
			<?php endforeach;?>
		</tbody>

	</table>
	<?php
	if(isset($pager)){
		echo $this->renderBlock('common/pagination', array('pager'=>$pager));
	}
endif;
?>
