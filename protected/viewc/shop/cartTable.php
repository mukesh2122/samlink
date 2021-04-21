<!-- Shop cart items start -->
<?php if(isset($cart->FiCartProductRel)):?>
<table class="shop_items">
	<tr class="subtle_grey">
		<th colspan="2">
			<?php echo $this->__('Shopping Cart'); ?>
		</th>
		<th>
			<?php echo $this->__('Quantity'); ?>
		</th>
		<th>
			<?php echo $this->__('Price'); ?>
		</th>
	</tr>
	<?php
	foreach($cart->FiCartProductRel as $key=>$cartItem):
		$class= $key % 2 == 0 ? '' : 'even_rows_bg';
	?>
	<tr class="shop_item F_cartTr_<?php echo $cartItem->ID_PRODUCT;?>">
		<td class="clearfix <?php echo $class; ?>" colspan="2">
			<a data-opt='{"ID":"<?php echo $cartItem->ID_PRODUCT;?>"}' href="javascript:void(0)" class="delete_list_item F_removeFromCart">X</a>
			<span class="shop_item_name"><?php echo $cartItem->ProductName;?></span>
		</td>
		<td class="shop_item_meta <?php echo $class; ?>">
			<?php echo $cartItem->Quantity;?>
		</td>
		<td class="shop_item_meta <?php echo $class; ?>">
			<?php echo MainHelper::creditsOutput($cartItem->TotalPrice);?>
		</td>
	</tr>
	<?php endforeach;?>
	
	<tr class="shop_total">
		<td colspan="3">
			<?php echo $this->__('Total'); ?>:
		</td>
		<td class="F_totalPrice">
			<?php echo MainHelper::creditsOutput($cart->TotalPrice);?>
		</td>
	</tr>
</table>
<!-- Shop cart items end -->
<?php endif;?>