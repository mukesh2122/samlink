<!-- header -->
<div class="clearfix">
	<span class="fs22 fft fclg2 fl mr10"><?php echo 'Edit Package Info'; ?></span>
</div>
<!-- end header -->
<form method="post" id="edit_package_form" action="<?php echo MainHelper::site_url('admin/shop/memberships/'.$package->ID_PACKAGE); ?>">
	<input type="hidden" name="package_id" value="<?php echo $package->ID_PACKAGE; ?>" />

	<div class="mt5">
		<label for="package_name"><?php echo 'Name'; ?></label>
		<div class="border mt2">
			<input tabindex="1" id="package_name" name="package_name" type="text" value="<?php echo $package->PackageName; ?>" class="text_input" />
		</div>
	</div>

	<div class="mt5">
		<label for="PackageType"><?php echo 'Package Type (Valid values: "Silver", "Gold", "Platinum" or no value)'; ?></label>
		<div class="border mt2">
			<input tabindex="2" id="PackageType" name="PackageType" type="text" value="<?php echo $package->PackageType; ?>" class="text_input" />
		</div>
	</div>

	<div class="clearfix no-margin mt5">
		<input tabindex="3" class="fl" <?php echo (isset($package) and $package->isMonthly == 1) ? 'checked="checked"' : '';?> type="checkbox" id="isMonthly" name="isMonthly" value="1" />
		<label class="fl cp" for="isMonthly"><?php echo 'isMonthly';?></label>
	</div>

	<div class="clearfix no-margin mt5">
		<input tabindex="4" class="fl" <?php echo (isset($package) and $package->isMembership == 1) ? 'checked="checked"' : '';?> type="checkbox" id="isMembership" name="isMembership" value="1" />
		<label class="fl cp" for="isMembership"><?php echo 'isMembership';?></label>
	</div>

	<div class="mt5">
		<label for="Duration"><?php echo 'Duration (In months)'; ?></label>
		<div class="border mt2">
			<input tabindex="5" id="Duration" name="Duration" type="text" value="<?php echo $package->Duration; ?>" class="text_input" />
		</div>
	</div>

	<div class="mt5">
		<label for="Price"><?php echo 'Price'; ?></label>
		<div class="border mt2">
			<input tabindex="6" id="Price" name="Price" type="text" value="<?php echo $package->Price; ?>" class="text_input" />
		</div>
	</div>

	<div class="mt5">
		<label for="FeatureCount"><?php echo 'FeatureCount'; ?></label>
		<div class="border mt2">
			<input tabindex="7" id="FeatureCount" name="FeatureCount" type="text" value="<?php echo $package->FeatureCount; ?>" class="text_input" />
		</div>
	</div>

	<div class="mt5">
		<label for="Position"><?php echo 'Position'; ?></label>
		<div class="border mt2">
			<input tabindex="8" id="Position" name="Position" type="text" value="<?php echo $package->Position; ?>" class="text_input" />
		</div>
	</div>

	<div class="mt5">
		<label for="PackageDesc" class="cp"><?php echo 'Package Description'; ?></label>
		<div class="border mt2">
			<?php MainHelper::loadCKE("PackageDesc", $package->PackageDesc); ?>
		</div>
	</div>

	<div class="clear mt10">&nbsp;</div>
	<div class="standard_form_footer clearfix">
		<input class="button button_auto light_blue pull_right" type="submit" value="<?php echo 'Save Settings'; ?>" />
	</div>
</form>
<script type="text/javascript">loadDropdowns(); loadCheckboxes();</script>
