<?php include('common/top.php'); ?>
<?php
$suspendLevel = $player->getSuspendLevel();
$noProfileFunctionality = MainHelper::GetNoProfileFunctionality($suspendLevel);
$noSiteFunctionality = MainHelper::GetNoSiteFunctionality($suspendLevel);
?>

<div class="shop_cart">
	<?php if($cart && !$noProfileFunctionality):?>
		<div class="shop_error errorContainer dn">&nbsp;</div>
		
		<?php echo $this->renderBlock('shop/cartTable', array('cart' => $cart));?>

		<!-- Billing info start -->
		<div class="shop_bill_info grey_box rounded_5">
			<div class="box_header">
				<h3><?php echo $this->__('Billing Details') ?></h3>
			</div>
			<form method="post" class="clearfix F_cartForm">
				
				<label for="fname"><?php echo $this->__('First Name');?></label>
				<input type="text" id="fname" class="text_input" name="billing_first_name" value="<?php echo $player->FirstName;?>" />

				<label for="lname"><?php echo $this->__('Last Name');?></label>
				<input type="text" id="lname" class="text_input" name="billing_last_name" value="<?php echo $player->LastName;?>" />
				
				<label for="addr"><?php echo $this->__('Street Address');?></label>
				<input type="text" id="addr" class="text_input" name="billing_address" value="<?php echo $player->Address;?>" />
				
				<label for="pcode"><?php echo $this->__('Postal Code');?></label>
				<input type="text" id="pcode" class="text_input" name="billing_post_code" value="<?php echo $player->Zip;?>" />
				
				<label for="city"><?php echo $this->__('City/Town');?></label>
				<input type="text" id="city" class="text_input" name="billing_city" value="<?php echo $player->City;?>" />
				
				<label for="country"><?php echo $this->__('Country'); ?></label>
				<select id="country" class="dropkick_lightWide" name="billing_country" tabindex="1">
					<?php $countries = MainHelper::getCountryList(); ?>
					<?php foreach($countries as $country): ?>
						<option value="<?php echo $country->A2; ?>" <?php echo $player->Country == $country->A2 ? 'selected="selected"' : '';?>>
							<?php echo $this->__($country->Country); ?>
						</option>
					<?php endforeach; ?>
				</select>

			</form>
		</div>
		<!-- Billing info end -->

		<!-- Not styled yet because of apparency – discuss with Richard -->
		<div class="errorContainer"></div>

		<!-- Shop pay start -->
		<div class="shop_footer clearfix">
			<?php if($player->Credits >= $cart->TotalPrice):?>
				<a class="button button_large light_green F_confirmCart"><?php echo $this->__('Complete Order Now'); ?></a>
				<p class="shop_info">
					<?php echo $this->__('This will complete your order and your payments will be deducted from your account.'); ?>
				</p>
			<?php else:?>
				<p class="shop_info_imp">
					<?php echo $this->__('You do not have enough credits.'); ?>
				</p>
			<?php endif;?>
		</div>
		<!-- Shop pay end -->

	<?php else:?>
		<div class="shop_info_imp mt20">
			<?php echo $this->__('Shopping cart is empty');?>
		</div>
	<?php endif;?>
</div>