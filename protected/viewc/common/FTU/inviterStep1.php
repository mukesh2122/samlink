<form action="" method="POST" name="openinviter" class="F_openInviterForm">
	<?php if(isset($errors) and isset($errors['login'])): ?>
	<div class="ftu_form_error">
		<?php echo $errors['login']; ?>
	</div>
	<?php endif; ?>
	<div class="clearfix">
		<label for="email_box"><?php echo $this->__('E-mail'); ?></label>
		<input class='text_input thTextbox' type="text" name="email_box" value="<?php echo isset($values) ? $values['email_box'] : ''; ?>" />
	</div>
	<?php if(isset($errors) and isset($errors['email'])): ?>
	<div class="ftu_form_error">
		<?php echo $errors['email']; ?>
	</div>
	<?php endif; ?>
	
	<div class="clearfix">
		<label for='password_box'><?php echo $this->__('Password'); ?></label>
		<input class='text_input thTextbox' type='password' name='password_box' value='' />
	</div>
	<?php if(isset($errors) and isset($errors['password'])): ?>
	<div class="ftu_form_error">
		<?php echo $errors['password']; ?>
	</div>
	<?php endif; ?>
	
	<label for='provider_box'><?php echo $this->__('E-mail provider'); ?></label>
	<select class="dropkick_lightWide" name='provider_box' tabindex="1">
		<option value=''><?php echo $this->__('Select an e-mail provider'); ?></option>
		<?php foreach ($services as $type=>$providers) : ?>
			<?php if($type == 'email'): ?>
				<optgroup label='<?php echo $pluginTypes[$type]; ?>'>
				<?php foreach ($providers as $provider=>$details) : ?>
					<option value='<?php echo $provider; ?>' <?php echo (isset($values) and $values['provider_box'] == $provider) ? 'selected' : ''; ?>><?php echo $details['name']; ?></option>
				<?php endforeach; ?>
				</optgroup>
			<?php endif; ?>
		<?php endforeach; ?>
	</select>

	<div class="clear"></div>

	<?php if(isset($errors) and isset($errors['provider'])): ?>
	<div class="ftu_form_error">
		<?php echo $errors['provider']; ?>
	</div>
	<?php endif; ?>
	
	<input type='hidden' name='step' value='get_contacts'>
	<div class="add_button clearfix">
		<a href="javascript:void(0)" class="button button_medium mint F_loginOpenInviter"><?php echo $this->__('Get friends'); ?></a>
	</div>
	<div class="mt10">
		<a href="javascript:void(0)" class="F_showInviteByEmail"><?php echo $this->__('Invite friends by typing their e-mail addresses'); ?></a>
	</div>
</form>