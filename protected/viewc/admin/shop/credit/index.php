<?php echo $this->renderBlock('shop/common/search', array(
	'url' => MainHelper::site_url('admin/shop/search'),
	'searchText' => isset($searchText) ? $searchText : '',
	'searchTotal' => isset($searchTotal) ? $searchTotal : 0,
	'label' => $label = 'Search for products...',
	'type' => $type = 'shop'
));?>
<?php if(isset($credits) and !empty($credits)):?>
	<table cellspacing="0" cellpadding="0" class="table table_bordered table_striped gradient_thead mt10">
		<thead>
			<tr>
				<th class="size_10 centered"><?php echo 'ID';?></th>
				<th class="size_100 centered"><?php echo 'Credits';?></th>
				<th class="size_10 centered"><?php echo 'Money';?></th>
				<th class="size_10 centered"><?php echo 'Currency';?></th>
				<th class="size_20 centered"><?php echo $this->__('Action');?></th>
			</tr>
		</thead>

		<tbody>
			<?php foreach($credits as $credit):?>
				<tr>
					<td class="centered"><?php echo $credit->ID_EXCHANGE;?></td>
					<td class="centered"><?php echo $credit->Credits;?></td>
					<td class="centered"><?php echo $credit->Money;?></td>
					<td class="centered"><?php echo $credit->Currency;?></td>
					<td class="centered">
						<a href="<?php echo MainHelper::site_url('admin/shop/rates/'.$credit->ID_EXCHANGE);?>"><?php echo 'Edit';?></a>
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
