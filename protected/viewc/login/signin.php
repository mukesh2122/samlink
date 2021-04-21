<?php if(!empty($asBlock)): ?>
<div class="the_one_columns_child mb120">
<?php endif; ?>
	<div class="errorContainer dn"></div>
	<form class="standard_form mt30" method="get" id="login_form_page">
		<h1 class="standard_form_header"><?php echo $this->__('Sign in to PlayNation'); ?></h1>
		<div class="standard_form_elements clearfix">
			<div class="login_error dn"></div>
			<div class="clearfix">
				<label class="dropdown_form_label" for="login-email-page"><?php echo $this->__('E-mail'); ?></label>
				<span>
					<input tabindex="1" class="text_input" id="login-email-page" name="email" type="text">
				</span>
			</div>
			<div class="clearfix">
				<label class="dropdown_form_label" for="login-pass-page"><?php echo $this->__('Password'); ?></label>
				<span>
					<input tabindex="2" class="text_input" id="login-pass-page" name="pass" type="password">
				</span>
			</div>
		</div>
		<div class="standard_form_footer clearfix">
			<div class="stand_form_footer_link pull_left">
				<a id="link_forgot_page" href="javascript:void(0);"><?php echo $this->__('Forgot your password?'); ?></a>
			</div>
			<a class="button button_auto light_blue pull_right" id="action_login_page" href="javascript:void(0);"><?php echo $this->__('Sign In'); ?></a>
		</div>
		<div class="dn"><input type="submit" value=""></div>
	</form>
	<div class="register_reminder">
		<?php echo $this->__("Don't have an account yet? You can register [_1]right here[_2]", array('<a href="'.MainHelper::site_url('registration').'">', '</a>')); ?>
	</div>
<?php if(!empty($asBlock)): ?>
</div>
<?php endif; ?>