<form class="standard_form" method="post" action="<?php echo MainHelper::site_url('admin/translate/new'); ?>">

	<div class="standard_form_header clearfix">
		<h1 class="pull_left"><?php echo 'Add new language'; ?></h1>
	</div>
	
	<div class="standard_form_elements clearfix">

		<div class="clearfix">
			<label for="A2"><?php echo 'Country code'; ?></label>
			<span>
				<input tabindex="2" id="A2" name="A2" type="text" value="" class="text_input" />
			</span>
		</div>
		<div class="clearfix">
			<label for="NativeName"><?php echo 'Local language name'; ?></label>
			<span>
				<input tabindex="2" id="NativeName" name="NativeName" type="text" value="" class="text_input" />
			</span>
		</div>
		<div class="clearfix">
			<label for="EnglishName"><?php echo 'English language name'; ?></label>
			<span>
				<input tabindex="2" id="EnglishName" name="EnglishName" type="text" value="" class="text_input" />
			</span>
		</div>

	</div>

	<div class="standard_form_footer clearfix">
		<input class="button button_auto light_blue pull_right" type="submit" value="<?php echo 'Save Settings'; ?>" />
	</div>
		
</form>
<script type="text/javascript">loadCheckboxes();</script>
