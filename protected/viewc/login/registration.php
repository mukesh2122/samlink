<?php
	$tabindex = 0;
	$dob = date('Y-m-d');
?>
<div class="the_one_columns_child">
	<div class="errorContainer dn"></div>
	<form class="standard_form mt30 mb120" method="get" id="register_form_page">
		<h1 class="standard_form_header"><?php echo $this->__('Register on PlayNation'); ?></h1>
		<div class="standard_form_elements clearfix">
			<div class="clearfix">
				<label for="register-email-page"><?php echo $this->__('E-mail'); ?></label>
				<span>
					<input tabindex="<?php echo ++$tabindex; ?>" id="register-email-page" name="email" type="text" value="<?php echo isset($email) ? $email : ''; ?>" class="text_input">
				</span>
			</div>
			<?php if (!empty($age_limit)) {
				echo '<div class="standard_form_dob clearfix">';
				echo '<label for="dob">', $this->__('Brithday'), '</label>';
				echo '<select id="dobYear" class="dropkick_lightNarrow" name="year" tabindex="', ++$tabindex, '">';
				$years = MainHelper::getYears();
				foreach ($years as $k => $v) {
					echo '<option value="', $k, '" ', (MainHelper::isYearSelected($dob, $v) ? 'selected="selected"' : ''), '>', $v, '</option>';
				}
				echo '</select>';
				echo '<select id="dobMonth" class="dropkick_lightNarrow" name="month" tabindex="', ++$tabindex, '">';
				$months = MainHelper::getMonthList();
				foreach ($months as $k => $v) {
					echo '<option value="', $k, '" ', (MainHelper::isMonthSelected($dob, $k) ? 'selected="selected"' : ''), '>', $v, '</option>';
				}
				echo '</select>';
				echo '<select id="dobDay" class="dropkick_lightNarrow" name="day" tabindex="', ++$tabindex, '">';
				$days = MainHelper::getDays();
				foreach ($days as $k => $v) {
					echo '<option value="', $k, '" ', (MainHelper::isDaySelected($dob, $v) ? 'selected="selected"' : ''), '>', $v, '</option>';
				}
				echo '</select>';
				if (isset($Element['error'])) {
					echo '<div id="dob-error" class="error">';
					echo '<label for="dop" class="error" generated="true"></label>';
					echo '</div>';
				}
				echo '</div>';
			} ?>
			<div class="clearfix">
				<label for="register-user-page"><?php echo $this->__('Nickname'); ?></label>
				<span>
					<input tabindex="<?php echo ++$tabindex; ?>" id="register-user-page" name="nick" type="text" value="<?php echo isset($twitter) ? $twitter->screen_name : ''; ?>" class="text_input">
				</span>
			</div>
			<div class="clearfix">
				<label for="register-pass-page"><?php echo $this->__('Password'); ?></label>
				<span>
					<input tabindex="<?php echo ++$tabindex; ?>" id="register-pass-page" name="pass" type="password" value="" class="text_input">
				</span>
			</div>
			<div class="clearfix">
				<label for="register-confirm-pass-page"><?php echo $this->__('Confirm password'); ?></label>
				<span>
					<input tabindex="<?php echo ++$tabindex; ?>" id="register-confirm-pass-page" name="confirm_pass" type="password" value="" class="text_input">
				</span>
			</div>
			<?php if(!isset($code)): ?>
                <div class="clearfix mb10">
                    <input type="checkbox" class="F_showRefCodeField" id="refCode">
                    <label for="refCode" class="p0 m0"><?php echo $this->__('Yes, I have a code I would like to use'); ?></label>
                </div>
                <div class="clearfix dn refferalCode">
                    <label for="referral-code-page"><?php echo $this->__('Referral Code [_1](optional)[_2]', array('<em>', '</em>')); ?></label>
                    <span>
                        <input tabindex="<?php echo ++$tabindex; ?>" class="text_input" id="referral-code-page" name="referral_code" type="text" value="<?php echo isset($code) ? $code : ''; ?>" title="<?php echo $this->__('Referral Code'); ?>">
                    </span>
                </div>
			<?php endif; ?>	
			<div class="standard_form_tos clearfix">
                <div class="stand_form_tos_wrapper no-margin clearfix">
                    <input tabindex="<?php echo ++$tabindex; ?>" id="accept-terms-page" name="terms" type="checkbox" value="1" title="<?php echo $this->__('I accept the Terms of Service'); ?>" class="fl">
                    <a target="_blank" href="<?php echo MainHelper::site_url('info/terms'); ?>"><?php echo $this->__('I accept the Terms of Service'); ?></a>
                </div>
			</div>
		</div>
		<div class="standard_form_footer clearfix">
			<div class="stand_form_footer_link pull_left">
				<?php echo $this->__('Already have an account? Sign in [_1]right here[_2]', array('<a href="'.MainHelper::site_url('signin').'">', '</a>')); ?>
			</div>
			<input id="action_register_page" class="button button_auto light_blue pull_right" value="<?php echo $this->__('Register'); ?>">
		</div>
	</form>
</div>
<script type="text/javascript">loadCheckboxes();</script>