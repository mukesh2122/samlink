<!-- header -->
<div class="clearfix">
	<span class="fs22 fft fclg2 fl mr10"><?php echo 'Edit Product Type Info'; ?></span>
</div>
<!-- end header -->
<form method="post" id="edit_type_form" action="<?php echo MainHelper::site_url('admin/shop/types/'.$type->ID_PRODUCTTYPE); ?>">
	<input type="hidden" name="type_id" value="<?php echo $type->ID_PRODUCTTYPE; ?>" />

	<label for="ProductTypeName"><?php echo 'Product Type Name'; ?></label>
	<div class="border mt2">
		<input tabindex="1" id="ProductTypeName" name="ProductTypeName" type="text" value="<?php echo $type->ProductTypeName; ?>" class="text_input" />
	</div>

	<div class="clear mt10">&nbsp;</div>
	<div class="standard_form_footer clearfix">
		<input class="button button_auto light_blue pull_right" type="submit" value="<?php echo 'Save Settings'; ?>" />
	</div>
</form>
<script type="text/javascript">loadDropdowns(); loadCheckboxes();</script>
