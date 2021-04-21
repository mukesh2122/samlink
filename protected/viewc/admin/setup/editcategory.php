<form class="standard_form" name="categoryform" method="post" action="#">
	<input type="hidden" name="ID_MODULE" id="ID_MODULE" value="<?php echo $selected_module['ID_MODULE']; ?>" />
	<input type="hidden" name="ID_CATEGORY" id="ID_CATEGORY" value="<?php echo $selected_category['ID_CATEGORY']; ?>" />

	<div class="standard_form_header clearfix">
		<h1 class="pull_left"><?php echo 'Edit category' ?></h1>
	</div>

	<div class="standard_form_elements clearfix">
		<div class="clearfix">
			<label for="A2"><?php echo 'Category name'; ?></label>
			<span>
				<input tabindex="1" id="CategoryName" name="CategoryName" type="text" value="<?php echo $selected_category['CategoryName']; ?>" class="text_input" />
			</span>
		</div>

		<div class="standard_form_checks clearfix">
			<label for="A2"><?php echo 'Must Be Approved'; ?></label>
			<div class="standard_form_checks_wrapper no-margin clearfix" >
				<input class="dst" id="MBA_enabled" name="MBA_enabled" type="checkbox" <?php echo ($selected_category['MBA_enabled']==1) ? " checked " : "";?> />
			</div>
		</div>


	</div>
	
	<div class="standard_form_footer clearfix">
		<input class="button button_auto light_blue pull_right" type="submit" value="<?php echo 'Save Settings'; ?>" />
	</div>
</form>


<script type="text/javascript">loadCheckboxes();</script> 