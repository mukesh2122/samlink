<?php include('common/top.php'); 

$link = '';
$code = '';

if(isset($referrer) and !isset($error)){
	$formUrl = MainHelper::site_url('referral/edit-subreferral/'.$referrer->VoucherCode);
	
	$link = MainHelper::site_url('referral/c/'.$referrer->VoucherCode);
	$code = $referrer->VoucherCode;
} else {
	$formUrl = MainHelper::site_url('referral/create-subreferral-code');
}
?>

<form class="standard_form" action="<?php echo $formUrl;?>" method="POST">

	<div class="standard_form_header">
		<h1><?php echo (isset($referrer) and !isset($error)) ? $this->__('Edit Subreferral') : $this->__('Create New Subreferral') ?></h1>
	</div>
	
	<div class="standard_form_elements clearfix">
		<?php if(isset($error)):?>
			<div class="errorContainer mb20"><?php echo $error;?></div>
		<?php endif;?>
		
		<?php if(isset($referrer) and !isset($error)): ?>
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
		<?php endif; ?>

		<div class="clearfix">
			<label for="user"><?php echo $this->__('User e-mail');?></label>
			<span>
				<input tabindex="1" class="text_input" id="user" type="text" name="user" value="<?php echo isset($referrer) ? htmlspecialchars($referrer->EMail) : '';?>" />
			</span>
		</div>
		
		<div class="clearfix">
			<label for="displayLabel"><?php echo $this->__('Label');?></label>
			<span>
				<input tabindex="2" class="text_input" id="displayLabel" type="text" name="displayLabel" value="<?php echo isset($referrer) ? htmlspecialchars($referrer->DisplayName) : '';?>" />
			</span>
		</div>

		<div class="clearfix">
			<label for="commision"><?php echo $this->__('Commission');?></label>
			<span>
				<select tabindex="3" class="dropkick_lightWide" id="commision" name="commision">
					<option><?php echo $this->__('Select your commission');?></option>
					<?php for($i = 1; $i <= $manager->Commision; $i++):?>
					<option value="<?php echo $i;?>" <?php echo (isset($referrer) and $referrer->Commision == $i) ? 'selected="selected"' : '';?>><?php echo $i;?>%</option>
					<?php endfor;?>
				</select>
			</span>
		</div>

	</div>

	<div class="standard_form_footer clearfix">
		<input class="button button_auto light_blue pull_right ml15" type="submit" value="<?php echo $this->__('Save Changes');?>" />
		<a class="button button_medium light_grey pull_right" href="<?php echo MainHelper::site_url('referral');?>"><?php echo $this->__('Cancel');?></a>
	</div>
</form>
