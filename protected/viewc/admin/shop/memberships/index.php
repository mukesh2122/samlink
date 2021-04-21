<?php echo $this->renderBlock('shop/common/search', array(
	'url' => MainHelper::site_url('admin/shop/search'),
	'searchText' => isset($searchText) ? $searchText : '',
	'searchTotal' => isset($searchTotal) ? $searchTotal : 0,
	'label' => $label = 'Search for products...',
	'type' => $type = 'shop'
));?>
<?php if(isset($packages) and !empty($packages)):?>
	<table cellspacing="0" cellpadding="0" class="table table_bordered table_striped gradient_thead mt10">
		<thead>
			<tr>
				<th class="size_10 centered"><?php echo 'ID';?></th>
				<th class="size_100 centered"><?php echo 'Name';?></th>
				<th class="size_10 centered"><?php echo 'Type';?></th>
				<th class="size_10 centered"><?php echo 'Duration';?></th>
				<th class="size_10 centered"><?php echo 'Price';?></th>
				<th class="size_20 centered"><?php echo $this->__('Action');?></th>
			</tr>
		</thead>

		<tbody>
			<?php foreach($packages as $package):?>
				<tr>
					<td class="centered"><?php echo $package->ID_PACKAGE;?></td>
					<td class="centered"><?php echo $package->PackageName;?></td>
					<td class="centered"><?php echo $package->PackageType;?></td>
					<td class="centered"><?php echo $package->Duration;?></td>
					<td class="centered"><?php echo $package->Price;?></td>
					<td class="centered">
						<a href="<?php echo MainHelper::site_url('admin/shop/memberships/'.$package->ID_PACKAGE);?>"><?php echo 'Edit';?></a>
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
