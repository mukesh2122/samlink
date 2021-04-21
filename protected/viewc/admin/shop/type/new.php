
<form class="standard_form" method="post" action="<?php echo MainHelper::site_url('admin/shop/types/new'); ?>">

	<div class="standard_form_header clearfix">
		<h1 class="pull_left"><?php echo 'Create new product type'; ?></h1>
	</div>
		<div class="clearfix">
			<label for="ProductTypeName"><?php echo 'Product Type Name'; ?></label>
			<span>
				<input tabindex="1" id="ProductTypeName" name="ProductTypeName" type="text" value="" class="text_input" />
			</span>
		</div>

	<div class="standard_form_footer clearfix">
		<input class="button button_auto light_blue pull_right" type="submit" value="<?php echo 'Save Settings'; ?>" />
	</div>
	</div>
</form>
<script type="text/javascript">loadCheckboxes();</script>
