<?php echo $this->renderBlock('shop/common/search', array(
	'url' => MainHelper::site_url('admin/shop/search'),
	'searchText' => isset($searchText) ? $searchText : '',
	'searchTotal' => isset($searchTotal) ? $searchTotal : 0,
	'label' => $label = 'Search for products...',
	'type' => $type = 'shop'
));?>
<?php if(isset($types) and !empty($types)):?>
	<table cellspacing="0" cellpadding="0" class="table table_bordered table_striped gradient_thead mt10">
		<thead>
			<tr>
				<th class="size_10 centered"><?php echo 'ID';?></th>
				<th class="size_100 centered"><?php echo 'ProductTypeName';?></th>
				<th class="size_100 centered"><?php echo 'Action';?></th>
			</tr>
		</thead>

		<tbody>
			<?php foreach($types as $types):?>
				<tr>
					<td class="centered"><?php echo $types->ID_PRODUCTTYPE;?></td>
					<td class="centered"><?php echo $types->ProductTypeName;?></td>

					<td class="centered">
						<a href="<?php echo MainHelper::site_url('admin/shop/types/'.$types->ID_PRODUCTTYPE);?>"><?php echo 'Edit';?></a>
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
