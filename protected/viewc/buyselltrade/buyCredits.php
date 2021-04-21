<?php $isEnabledTranslate = MainHelper::IsModuleEnabledByTag('translations');

$headerName=''; ?>
<?php // IAM AN AWFUL TEST, REMOVE ME!!!  ?>
<ul class="horizontal_tabs clearfix">
	<li class="active" >
		<a href="<?php echo MainHelper::site_url(BUYSELLTRADE_NOTICES);?>" class="icon_link">
		<i class="games_tab_icon"></i><?php echo $this->__('Notices'); ?></a>
	</li>
	<li>
		<a href="<?php echo  MainHelper::site_url(BUYSELLTRADE_NOTICES.'/'.BUYSELLTRADE_MY_NOTICES); ?>" class="icon_link">
		<i class="games_tab_icon"></i><?php echo $this->__('My Notices'); ?></a>
	</li>
	<li>
		<a href="<?php echo MainHelper::site_url(BUYSELLTRADE_NOTICES.'/'.BUYSELLTRADE_CREATE_NOTICES);?>" class="icon_link">
		<i class="games_tab_icon"></i><?php echo $this->__('Create Notice'); ?></a>
	</li>
    <li class="active">
		<a  href="<?php echo MainHelper::site_url(BUYSELLTRADE_NOTICES.'/'.BUYSELLTRADE_BUYCREDITS);?>" class="icon_link">
        <i class="games_tab_icon"></i><?php echo $this->__('Credits');?></a>
	</li>
	
	<li>
		<a  href="<?php echo MainHelper::site_url(BUYSELLTRADE_NOTICES.'/'.BUYSELLTRADE_TRANSACTIONS);?>" class="icon_link" >
        <i class="games_tab_icon"></i><?php echo $this->__('Transactions');?></a>
	</li>

</ul>

<form method="post" id="F_creditsForm">
<!-- Credit items start -->
<table class="credits_options shop_items">
	<tr class="subtle_grey">
		<th>
			<?php echo $this->__('Buy Credits'); ?>
		</th>
		<th>
			<?php echo $this->__('Price'); ?>
		</th>
	</tr>

	<?php if (!empty($rates)):?>
		<?php foreach ($rates as $key=>$rate): ?>
			<?php $class = $key % 2 == 0 ? '' : 'bglg';?>
			<tr class="shop_item">
				<td class="no-margin clearfix <?php echo $class ?>">
					<input type="radio" id="rate_<?php echo $key;?>" name="rate" <?php echo !$key ? 'checked="checked"' : '';?> value="<?php echo $rate->ID_EXCHANGE;?>"/>
					<label for="rate_<?php echo $key;?>" class="shop_item_name"><?php echo $rate->Credits; ?> <?php echo $this->__('Credits'); ?></label>
				</td>
				<td class="shop_item_meta <?php echo $class ?>">
					<?php echo $rate->Money; ?> <?php echo $rate->Currency; ?>
				</td>
			</tr>
		<?php endforeach; ?>
	<?php endif; ?>
</table>
<!-- Credit items end -->

<!-- Credit payment options start -->
<div class="payment_options grey_box rounded_5">
	<div class="box_header">
		<h3><?php echo $this->__('Payment Options'); ?></h3>
	</div>

	<div class="payment_option no-margin clearfix">
		<div class="select">
			<input type="radio" name="payment" value="<?php echo PAYMENT_PAYPAL;?>" id="paypal" checked="checked" />
			<label for="paypal"><?php echo $this->__('PayPal');?></label>
		</div>
		<div class="payment_description">
			<?php echo $this->__("Choose PayPal to use your PayPal account, Visa, Mastercard, Discover or American Express. Notice that a PayPal account is not required to pay with a credit card on PayPal's website. You can pay as a PayPal-guest."); ?>
		</div>
	</div>

	<div class="payment_option no-margin clearfix">
		<div class="select">
			<input type="radio" name="payment" value="<?php echo PAYMENT_XSOLLA;?>" id="xsolla" />
			<label for="xsolla"><?php echo $this->__('Xsolla');?></label>
		</div>
		<div class="payment_description">
			<?php echo $this->__('Xsolla offers more than 350+ payment solutions in 85+ countries. Choose Xsolla to find the best payment solution for you.'); ?>
		</div>
	</div>

	<?php /*
	<table>
		<tr>
			<td class="no-margin">
				<input type="radio" name="payment" value="<?php echo PAYMENT_PAYPAL;?>" id="paypal" checked="checked" />
				<label for="paypal"><?php echo $this->__('PayPal');?></label>
			</td>
			<td class="no-margin">
				<input type="radio" name="payment" value="<?php echo PAYMENT_XSOLLA;?>" id="xsolla" />
				<label for="xsolla"><?php echo $this->__('Xsolla');?></label>
			</td>
			<td class="no-margin">
			</td>
		</tr>
	</table>
	*/ ?>
</div>
<!-- Credit payment options end -->
</form>
<?php /*
<!-- Billing info start -->
<div class="shop_bill_info grey_box rounded_5">
	<div class="box_header">
		<h3><?php echo $this->__('Billing Details') ?></h3>
	</div>
	<form method="post" class="clearfix">
		
		<label for="fname"><?php echo $this->__('First Name');?></label>
		<input type="text" id="fname" class="text_input" name="billing_first_name" value="" />

		<label for="lname"><?php echo $this->__('Last Name');?></label>
		<input type="text" id="lname" class="text_input" name="billing_last_name" value="" />
		
		<label for="addr"><?php echo $this->__('Street Address');?></label>
		<input type="text" id="addr" class="text_input" name="billing_address" value="" />
		
		<label for="pcode"><?php echo $this->__('Postal Code');?></label>
		<input type="text" id="pcode" class="text_input" name="billing_post_code" value="" />
		
		<label for="city"><?php echo $this->__('City/Town');?></label>
		<input type="text" id="city" class="text_input" name="billing_city" value="" />
		
		<label for="country"><?php echo $this->__('Country'); ?></label>
		<select id="country" class="dropkick_lightWide" name="billing_country">
				<option value="">
					Option 1
				</option>
				<option value="">
					Option 2
				</option>
				<option value="">
					Option 3
				</option>
		</select>
	</form>
</div>
<!-- Billing info end -->
*/ ?>

<!-- Shop pay start -->
<div class="credits_buy shop_footer clearfix">
	<a class="button button_large light_green F_buyCredits"><?php echo $this->__('Buy Credits'); ?></a>
</div>

<?php echo $this->renderBlock('shop/converter', array()); ?>

<script type="text/javascript">loadCheckboxes();</script>
