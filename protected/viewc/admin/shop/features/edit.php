<!-- header -->
<div class="clearfix">
	<span class="fs22 fft fclg2 fl mr10"><?php echo 'Edit feature Info'; ?></span>
</div>
<!-- end header -->
<form method="post" id="edit_feature_form" action="<?php echo MainHelper::site_url('admin/shop/features/'.$feature->ID_FEATURE); ?>">
	<input type="hidden" name="feature_id" value="<?php echo $feature->ID_FEATURE; ?>" />

	<div class="mt5">
		<label for="FeatureName"><?php echo 'Name'; ?></label>
		<div class="border mt2">
			<input tabindex="1" id="FeatureName" name="FeatureName" type="text" value="<?php echo $feature->FeatureName; ?>" class="text_input" />
		</div>
	</div>

	<div class="mt5">
		<label for="Position"><?php echo 'Position'; ?></label>
		<div class="border mt2">
			<input tabindex="2" id="Position" name="Position" type="text" value="<?php echo $feature->Position; ?>" class="text_input" />
		</div>
	</div>

	<div class="mt5">
		<label for="FeatureDesc" class="cp"><?php echo 'Feature Description'; ?></label>
		<div class="border mt2">
			<?php MainHelper::loadCKE("FeatureDesc", $feature->FeatureDesc); ?>
		</div>
	</div>


	<div class="clear mt10">&nbsp;</div>
	<div class="standard_form_footer clearfix">
		<input class="button button_auto light_blue pull_right" type="submit" value="<?php echo 'Save Settings'; ?>" />
	</div>
</form>
<script type="text/javascript">loadDropdowns(); loadCheckboxes();</script>
