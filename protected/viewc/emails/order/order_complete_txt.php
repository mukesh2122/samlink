<?php echo $this->__('Receipt from PlayNation.eu'); ?>

<?php echo $this->__('Hello'); ?> <?php echo PlayerHelper::showName($player); ?>

<?php echo $this->__('Thank you for your order. This is your receipt.

Billing Details:'); ?>

<?php echo $this->__('Name').':'; ?> <?php echo $order->BillingFirstName.' '.$order->BillingLastName; ?>
<?php echo $this->__('Street Address').':'; ?> <?php echo $order->BillingAddress; ?>
<?php echo $this->__('Zip Code').':'; ?> <?php echo $order->BillingZip; ?>
<?php echo $this->__('City/Town').':'; ?> <?php echo $order->BillingCity; ?>
<?php echo $this->__('Country').':'; ?><?php echo PlayerHelper::getCountry($order->BillingCountry); ?>

<?php echo $this->__('Order Details').':'; ?>

<?php echo $this->__('Order Nr.'); ?> <?php echo MainHelper::orderNumber($order->ID_ORDER); ?>

<?php if(isset($order->FiPurchases)):
		foreach($order->FiPurchases as $key=>$orderItem):
	?>
<?php echo $this->__('Product Name').':'; ?> <?php echo $orderItem->ProductName; ?>
<?php echo $this->__('Product Quantity').':'; ?> <?php echo $orderItem->Quantity; ?>
<?php echo $this->__('Price').':'; ?> <?php echo MainHelper::creditsOutput($orderItem->TotalPrice); ?>
	<?php endforeach;?>
<?php endif;?>
															

<?php echo $this->__('Total').':'; ?> <?php echo MainHelper::creditsOutput($order->TotalPrice); ?>

<?php echo $this->__('Date of Order').':'; ?> <?php echo date(DATE_SHORT, $order->CreatedTime); ?>
<?php echo $this->__('Payment has been deducted from you PlayNation Account.'); ?>

<?php echo $this->__('If you have purchased any downloadable items, you can find your download link(s) in your order history.'); ?>

<?php echo $this->__('This e-mail was created automatically. Do not reply.'); ?>
<?php echo $this->__('If you require assistance, please contact our customer support at support@playnation.eu'); ?>
                                                           
--
<?php echo $this->__('PlayNation Team'); ?>
