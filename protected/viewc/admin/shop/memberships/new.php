
<form class="standard_form" method="post" action="<?php echo MainHelper::site_url('admin/shop/memberships/new'); ?>">

	<div class="standard_form_header clearfix">
		<h1 class="pull_left"><?php echo 'Create new package'; ?></h1>
	</div>

	<div class="standard_form_elements clearfix">
		<div class="clearfix">
			<label for="package_name"><?php echo 'Name'; ?></label>
			<span>
				<input tabindex="1" id="package_name" name="package_name" type="text" value="" class="text_input" />
			</span>
		</div>

		<div class="clearfix">
			<label for="PackageType"><?php echo 'Package Type'; ?></label>
			<span>
				<input tabindex="2" id="PackageType" name="PackageType" type="text" value="" class="text_input" />
			</span>
			<?php echo '("Silver", "Gold", "Platinum" or "")'; ?>
		</div>

		<div class="standard_form_checks clearfix">
			<label for="isMonthly"><?php echo 'isMonthly'; ?></label>
			<span>
				<div class="standard_form_checks_wrapper no-margin clearfix">
					<input class="dst" tabindex="3" id="isMonthly" name="isMonthly" type="checkbox" class="text_input" />
				</div>
			</span>
		</div>

		<div class="standard_form_checks clearfix">
			<label for="isMembership"><?php echo 'isMembership'; ?></label>
			<span>
				<div class="standard_form_checks_wrapper no-margin clearfix">
					<input class="dst" tabindex="4" id="isMembership" name="isMembership" type="checkbox" class="text_input" />
				</div>
			</span>
		</div>

		<div class="clearfix">
			<label for="Duration"><?php echo 'Duration (In months)'; ?></label>
			<span>
				<input tabindex="5" id="Duration" name="Duration" type="text" value="" class="text_input" />
			</span>
		</div>

		<div class="clearfix">
			<label for="Price"><?php echo 'Price'; ?></label>
			<span>
				<input tabindex="6" id="Price" name="Price" type="text" value="0" class="text_input" />
			</span>
		</div>

		<div class="clearfix">
			<label for="Position"><?php echo 'Position'; ?></label>
			<span>
				<input tabindex="6" id="Position" name="Position" type="text" value="0" class="text_input" />
			</span>
		</div>

		<div class="clearfix">
			<label for="PackageDesc"><?php echo 'Package Description'; ?></label>
			<span>
				<div class="standard_form_checks_wrapper no-margin clearfix">
					<textarea rows="7" cols="61" tabindex="8" id="PackageDesc" name="PackageDesc"></textarea>
				</div>
			</span>
		</div>
	</div>

	<div class="standard_form_footer clearfix">
		<input class="button button_auto light_blue pull_right" type="submit" value="<?php echo 'Save Settings'; ?>" />
	</div>

</form>
<script type="text/javascript">loadCheckboxes();</script>
