<?php echo $this->renderBlock('shop/common/search', array(
	'url' => MainHelper::site_url('admin/shop/search'),
	'searchText' => isset($searchText) ? $searchText : '',
	'searchTotal' => isset($searchTotal) ? $searchTotal : 0,
	'label' => $label = 'Search for products...',
	'type' => $type = 'shop'
));?>
<?php if(isset($products) and !empty($products)):?>
	<table cellspacing="0" cellpadding="0" class="table table_bordered table_striped gradient_thead mt10">
		<thead>
			<tr>
				<th class="size_10 centered"><?php echo 'ID';?></th>
				<th class="size_100 centered"><?php echo 'Name';?></th>
				<th class="size_10 centered"><?php echo 'DL';?></th>
				<th class="size_10 centered"><?php echo 'Feature';?></th>
				<th class="size_10 centered"><?php echo 'SO';?></th>
				<th class="size_20 centered"><?php echo $this->__('Action');?></th>
			</tr>
		</thead>

		<tbody>
			<?php foreach($products as $product):?>
				<tr>
					<td class="centered"><?php echo $product->ID_PRODUCT;?></td>
					<td class="centered"><?php echo $product->ProductName;?></td>
					<td class="centered"><?php echo $product->isDownloadable;?></td>
					<td class="centered"><?php echo $product->isFeatured;?></td>
					<td class="centered"><?php echo $product->isSpecialOffer;?></td>
					<td class="centered">
						<a href="<?php echo MainHelper::site_url('admin/shop/product/'.$product->ID_PRODUCT);?>"><?php echo 'Edit';?></a>
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