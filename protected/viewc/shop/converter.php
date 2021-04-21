<?php $user = User::getUser(); ?>
<div class="payment_options grey_box rounded_5">
	<div class="box_header">
		<h3><?php echo $this->__('Converter'); ?></h3>
	</div>

	<p><?php echo $this->__('This is where you exchange Credits to Coins. You can use Coins in E-Sport and you can buy certain site features and special offers. The exchange rate is 1 Credit ~ 10 Coins. Notice that you cannot exchange Coins to Credits. And you cannot cash out Coins'); ?></p>
	<form id="F_creditConverterForm">
		<label for="amountPD" class="db"><?php echo $this->__('Amount of Credits to convert'); ?></label>
		<input id="amountPD" name="amountPD" type="text" value="0" rel="<?php echo $user->Credits; ?>" class="text_input mt3" />
		<span id="convertedPC" class="fcgr">0</span>
</div>
<div class="credits_buy shop_footer clearfix">
	<a href="javascript:void(0)" class="button button_large light_green F_convertPD"><?php echo $this->__('Convert'); ?></a>
</div>
	</form>