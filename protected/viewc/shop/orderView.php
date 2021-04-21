<?php include('common/top.php'); ?>



<!-- Order view start -->
<?php if($order):?>
<table class="shop_items">
	<tr class="subtle_grey">
		<th><?php echo $this->__('Order Nr. ').MainHelper::orderNumber($order->ID_ORDER); ?></th>
		<th><?php echo $this->__('Quantity'); ?></th>
		<th><?php echo $this->__('Price'); ?></th>
	</tr>
	<?php if(isset($order->FiPurchases)):
	foreach($order->FiPurchases as $key=>$orderItem):
	$class= $key % 2 == 0 ? '' : 'even_rows_bg';
	?>
	<tr class="shop_item">
		<td class="clearfix <?php echo $class; ?>">
			<?php echo $orderItem->ProductName;?>
			<?php if($orderItem->ProductType == DOWNLOADABLE and (Doo::conf()->downloadLimit - $orderItem->DownloadAttempts) > 0):?>
				<div><a href="<?php echo MainHelper::site_url('shop/download/'.$orderItem->ID_ORDER.'/'.$orderItem->DownloadURL);?>"><?php echo $this->__('Downloads left [_1] of [_2]', array(Doo::conf()->downloadLimit - $orderItem->DownloadAttempts, Doo::conf()->downloadLimit));?></a></div>
			<?php endif;?>
		</td>
		<td class="shop_item_meta <?php echo $class; ?>">
			<?php echo $orderItem->Quantity;?>
		</td>
		<td class="shop_item_meta <?php echo $class; ?>">
			<?php echo MainHelper::creditsOutput($orderItem->TotalPrice);?>
		</td>
	</tr>
	<?php endforeach;?>
	<?php endif;?>
	<tr class="shop_total">
		<td colspan="2">
			<?php echo $this->__('Total'); ?>:
		</td>
		<td class="F_totalPrice">
			<?php echo MainHelper::creditsOutput($order->TotalPrice);?>
		</td>
	</tr>
</table>
<?php endif;?>
<!-- Order view end -->

<!-- Order details start -->
<div class="order_view_info grey_box rounded_5">
	<div class="box_header">
		<h3><?php echo $this->__('Order Details') ?></h3>
	</div>

	<table>
		<tr>
			<td class="clearfix">
				<?php echo $this->__('Date of Order');?>
			</td>
			<td class="shop_item_meta_special">
				<?php echo date(DATE_SHORT, $order->CreatedTime);?>
			</td>
		</tr>
		<?php if($order->ClosedTime > 0):?>
		<tr>
			<td class="clearfix">
				<?php echo $this->__('Date of Order Complete');?>
			</td>
			<td class="shop_item_meta_special">
				<?php echo date(DATE_SHORT, $order->ClosedTime);?>
			</td>
		</tr>
		<?php endif;?>
		<?php if($order->ShippingTime > 0):?>
		<tr>
			<td class="clearfix">
				<?php echo $this->__('Date of Shipment');?>
			</td>
			<td class="shop_item_meta_special">
				<?php echo date(DATE_SHORT, $order->ShippingTime);?>
			</td>
		</tr>
		<?php endif;?>
		<?php if($order->ProcessingTime > 0):?>
		<tr>
			<td class="clearfix">
				<?php echo $this->__('Date of Payment');?>
			</td>
			<td class="shop_item_meta_special">
				<?php echo date(DATE_SHORT, $order->ProcessingTime);?>
			</td>
		</tr>
		<?php endif;?>
		<tr>
			<td class="clearfix vat">
				<?php echo $this->__('Billing Details');?>
			</td>
			<td class="shop_item_meta_special">
				<span>
					<?php echo $order->BillingFirstName.' '.$order->BillingLastName;?>
				</span>
				<span>
					<?php echo $order->BillingAddress;?>
				</span>
				<span>
					<?php echo $order->BillingZip;?>
				</span>
				<span>
					<?php echo $order->BillingCity;?>
				</span>
				<span>
					<?php echo PlayerHelper::getCountry($order->BillingCountry);?>
				</span>
			</td>
		</tr>
	</table>
</div>
<!-- Order details end -->