
<form class="standard_form" method="post" action="<?php echo MainHelper::site_url('admin/shop/features/new'); ?>">

	<div class="standard_form_header clearfix">
		<h1 class="pull_left"><?php echo 'Create new feature'; ?></h1>
	</div>

	<div class="standard_form_elements clearfix">
		<div class="clearfix">
			<label for="FeatureName"><?php echo 'Name'; ?></label>
			<span>
				<input tabindex="1" id="FeatureName" name="FeatureName" type="text" value="" class="text_input" />
			</span>
		</div>

		<div class="clearfix">
			<label for="Position"><?php echo 'Position'; ?></label>
			<span>
				<input tabindex="2" id="Position" name="Position" type="text" value="0" class="text_input" />
			</span>
		</div>

		<div class="clearfix">
			<label for="FeatureDesc"><?php echo 'Description'; ?></label>
			<span>
				<div class="standard_form_checks_wrapper no-margin clearfix">
					<textarea rows="7" cols="61" tabindex="3" id="FeatureDesc" name="FeatureDesc"></textarea>
				</div>
			</span>
		</div>
	</div>

	<div class="standard_form_footer clearfix">
		<input class="button button_auto light_blue pull_right" type="submit" value="<?php echo 'Save Settings'; ?>" />
	</div>

</form>
<script type="text/javascript">loadCheckboxes();</script>
