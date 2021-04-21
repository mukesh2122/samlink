<?php include('common/top.php'); ?>

<?php if(!empty($listOrders)):?>
	<!-- Shop history start -->
	<table class="shop_items">
		<tr class="subtle_grey">
			<th>
				<span class="flag shop_flag"><?php echo $this->__('Order History'); ?></span>
			</th>
			<th>
				<?php echo $this->__('Total Price'); ?>
			</th>
			<th>
				<?php echo $this->__('Status'); ?>
			</th>
		</tr>
		<?php foreach($listOrders as $key=>$order):?>
			<?php $class = $key % 2 == 0 ? '' : 'even_rows_bg';?>
			<tr class="shop_item">
				<td class="clearfix <?php echo $class ?>">
					<a class="shop_item_name" href="<?php echo MainHelper::site_url('shop/history/'.$order->ID_ORDER);?>"><?php echo $this->__('Order Nr.').' '.MainHelper::orderNumber($order->ID_ORDER);?></a>
				</td>
				<td class="shop_item_meta <?php echo $class ?>">
					<?php echo MainHelper::creditsOutput($order->TotalPrice);?>
				</td>
				<td class="shop_item_meta tar <?php echo $class ?>">
					<?php
						if($order->ClosedTime > 0) {
							echo '<div>'.$this->__('Completed').':&nbsp;'. date(DATE_SHORT, $order->ClosedTime).'</div>';
						}
						if($order->ShippingTime > 0) {
							echo '<div>'.$this->__('Shipped').':&nbsp;'. date(DATE_SHORT, $order->ShippingTime).'</div>';
						}
						if($order->ProcessingTime > 0) {
							echo '<div>'.$this->__('Payed').':&nbsp;'. date(DATE_SHORT, $order->ProcessingTime).'</div>';
						}
						if($order->PendingTime > 0) {
							echo '<div>'.$this->__('Ordered').':&nbsp;'. date(DATE_SHORT, $order->PendingTime).'</div>';
						}
					?>
				</td>
			</tr>
		<?php endforeach;?>
	</table>
	<!-- Shop history end -->
	<?php if(isset($pager)):?>
		<?php echo $this->renderBlock('common/pagination', array('pager'=>$pager)) ?>
	<?php endif; ?>
<?php else: ?>
	<div class="noItemsText"><?php echo $this->__('You have not made any transactions.'); ?></div>
<?php endif; ?>
<!-- Cash out start -->
<div class="cash_out grey_box rounded_5">
	<div class="box_header">
		<h3><?php echo $this->__('Cash Out') ?></h3>
	</div>

	<form method="post">
		<label for="iban"><?php echo $this->__('IBAN');?></label>
		<input type="text" id="iban" class="text_input" name="iban" value="" />
		
		<label for="swift"><?php echo $this->__('SWIFT');?></label>
		<input type="text" id="swift" class="text_input" name="swift" value="" />
				
		<label for="amount"><?php echo $this->__('Amount');?></label>
		<input type="text" id="amount" class="text_input" name="amount" value="" />
	</form>
</div>
<!-- Cash out end -->

<!-- Cash out pay start -->
<div class="shop_footer clearfix">
	<a class="button button_large light_green"><?php echo $this->__('Cash Out Now'); ?></a>
	<p class="shop_info">
		<?php echo $this->__('This will complete your Cash Out and the amount will be transferred to your bank account.'); ?>
	</p>
</div>
<div class="shop_ext_inf">
	<?php echo $this->__('Notice! It is only possible to cash out Credits. The minimum Cash Out Amount is [_1] Credits. The Cash Out Fee is [_2] Credits and will be deducted from your Account. Read our [_3] to learn more about PlayNations Cash Out Policy.', array(100, 20, '<a href="#">'.$this->__('Terms of Service').'</a>')); ?>
</div>
<!-- Cash out pay end -->