
<form class="standard_form" method="post" action="<?php echo MainHelper::site_url('admin/shop/rates/new'); ?>">

	<div class="standard_form_header clearfix">
		<h1 class="pull_left"><?php echo 'New Credits'; ?></h1>
	</div>

	<div class="standard_form_elements clearfix">

		<div class="clearfix">
			<label for="Credits"><?php echo 'Credits'; ?></label>
			<span>
				<input tabindex="1" id="Credits" name="Credits" type="text" value="0" class="text_input" />
			</span>
		</div>

		<div class="clearfix">
			<label for="Money"><?php echo 'Real money'; ?></label>
			<span>
				<input tabindex="2" id="Money" name="Money" type="text" value="0" class="text_input" />
			</span>
		</div>

		<div class="clearfix">
			<label for="currency_disp"><?php echo 'Currency'; ?></label>
			<span>
				<input tabindex="3" id="currency_disp" name="currency_disp" type="text" disabled="disabled" value="EUR" class="text_input" />
				<input type="hidden" name="currency" value="EUR" />
			</span>
		</div>

	</div>

	<div class="standard_form_footer clearfix">
		<input class="button button_auto light_blue pull_right" type="submit" value="<?php echo 'Save Settings'; ?>" />
	</div>

</form>
<script type="text/javascript">loadCheckboxes();</script>
