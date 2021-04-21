<div class="errorContainer dn"></div>
<!-- Register form start -->
<form id="register_form" method="get" class="right_column_form">
	<div class="primary_login_content">
		<div class="login_error dn"></div>
		<div>
			<label class="first_child" for="register-email"><?php echo $this->__('E-mail'); ?></label>
			<span>
				<input id="register-email" name="email" type="text" value="" title="<?php echo $this->__('E-mail'); ?>" class="text_input_right rounded_5">
			</span>
		</div>
		<div>
			<label for="register-user"><?php echo $this->__('Nickname'); ?></label>
			<span>
				<input id="register-user" name="nick" type="text" value="" title="<?php echo $this->__('Nickname'); ?>" class="text_input_right rounded_5">
			</span>
		</div>
		<div>
			<label for="register-pass"><?php echo $this->__('Password'); ?></label>
			<span>
				<input id="register-pass" name="pass" type="password" value="" title="<?php echo $this->__('Password'); ?>" class="text_input_right rounded_5">
			</span>
		</div>
		<div>
			<label for="register-confirm-pass"><?php echo $this->__('Confirm Password'); ?></label>
			<span>
				<input id="register-confirm-pass" name="confirm_pass" type="password" value="" title="<?php echo $this->__('Confirm Password'); ?>" class="text_input_right rounded_5">
			</span>
		</div>
		<div>
			<label for="referral"><?php echo $this->__('Referral Code'); ?></label>
			<span>
				<input name="referral_code" type="text" value="" title="<?php echo $this->__('Referral Code'); ?>" class="text_input_right rounded_5">
			</span>
		</div>
		<div class="right_column_accept_terms no-margin clearfix">
			<input id="accept-terms" name="terms" type="checkbox" value="1" title="<?php echo $this->__('I accept the Terms of Service'); ?>">
			<a target="_blank" href="<?php echo MainHelper::site_url('info/terms'); ?>"><?php echo $this->__('I accept the Terms of Service'); ?></a>
		</div>
	</div>
	<div class="right_column_form_footer clearfix ">
		<a class="button green_flat button_fluid button_no_shadow" id="action_register" href="javascript:void(0);"><?php echo $this->__('Register'); ?></a>
	</div>
	<div class="dn"><input type="submit" value=""></div>
</form>
<!-- Register form end -->
<script type="text/javascript">loadCheckboxes();</script>