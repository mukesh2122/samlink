<form id="form_recovery" method="post">
	<h3><?php echo $this->__('Password Recovery');?></h3>

	<p><?php echo $this->__('Enter your e-mail address for<br/>password recovery');?></p>
	<div class="remind_error dn">&nbsp;</div>
	<input class="rounded_5" name="remail" id="login_email" type="text" value="" class="input_login required email" />

	<div class="right_column_form_footer">
		<a class="button green_flat button_small button_no_shadow" id="action_recover" href="javascript:void(0)"><?php echo $this->__('Recover');?></a>
	</div>
</form>