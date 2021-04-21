
<!-- header -->
<div class="clearfix">
	<span class="fs22 fft fclg2 fl mr10"><?php echo 'Edit Credit Info'; ?></span>
</div>
<!-- end header -->
<form method="post" id="edit_credit_form" action="<?php echo MainHelper::site_url('admin/shop/rates/'.$credit->ID_EXCHANGE); ?>">
	<input type="hidden" name="credit_id" value="<?php echo $credit->ID_EXCHANGE; ?>" />

	<label for="Credits"><?php echo 'Credits'; ?></label>
	<div class="border mt2">
		<input tabindex="1" id="Credits" name="Credits" type="text" value="<?php echo $credit->Credits; ?>" class="text_input" />
	</div>

	<label for="Money"><?php echo 'Real money'; ?></label>
	<div class="border mt2">
		<input tabindex="2" id="Money" name="Money" type="text" value="<?php echo $credit->Money; ?>" class="text_input" />
	</div>

	<label for="currency"><?php echo 'Currency'; ?></label>
	<div class="border mt2">
		<input tabindex="3" id="currency" name="currency" type="text" disabled="disabled" value="<?php echo $credit->Currency; ?>" class="text_input" />
		<input type="hidden" name="currency" value="<?php echo $credit->Currency; ?>" />
	</div>

	<div class="clear mt10">&nbsp;</div>
	<div class="standard_form_footer clearfix">
		<input class="button button_auto light_blue pull_right" type="submit" value="<?php echo 'Save Settings'; ?>" />
	</div>
</form>
<script type="text/javascript">loadDropdowns(); loadCheckboxes();</script>
