<?php include('common/top.php'); ?>

<?php 
$link = '';
$code = '';

if(isset($referrer)){
	$formUrl = MainHelper::site_url('referral/edit/'.$referrer->VoucherCode);
	
	$link = MainHelper::site_url('referral/c/'.$referrer->VoucherCode);
	$code = $referrer->VoucherCode;
} else {
	$formUrl = MainHelper::site_url('referral/create-referral-code');
}
?>

<form class="standard_form" action="<?php echo $formUrl;?>" method="POST">

	<div class="standard_form_header">
		<h1><?php echo isset($referrer) ? $this->__('Edit Referral') : $this->__('Create New Referral') ?></h1>
	</div>

	<div class="standard_form_elements clearfix">

		<?php if(isset($referrer)): ?>
		<div class="clearfix">
			<span class="act_as_label_double"><?php echo $this->__('Referral link'); ?></span>
			<div class="act_as_input_double">
				<?php echo $link;?>
			</div>
		</div>

		<div class="clearfix">
			<span class="act_as_label_double"><?php echo $this->__('Voucher code'); ?></span>
			<div class="act_as_input_double">
				<?php echo $code;?>
			</div>
		</div>
		
		<div class="clearfix">
			<span class="act_as_label_double"><?php echo $this->__('Commission'); ?></span>
			<div class="act_as_input_double">
				<?php echo $referrer->Commision;?>%
			</div>
		</div>
		<?php endif; ?>

		<div class="clearfix">
			<label for="displayLabel"><?php echo $this->__('Label');?></label>
			<span>
				<input class="text_input" id="displayLabel" type="text" name="displayLabel" value="<?php echo isset($referrer) ? htmlspecialchars($referrer->DisplayName) : '';?>" />
			</span>
		</div>

	</div>

	<div class="standard_form_footer clearfix">
		<input class="button button_auto light_blue pull_right ml15" type="submit" value="<?php echo $this->__('Save Changes');?>" />
		<a class="button button_medium light_grey pull_right" href="<?php echo MainHelper::site_url('referral');?>"><?php echo $this->__('Cancel');?></a>
	</div>
</form>