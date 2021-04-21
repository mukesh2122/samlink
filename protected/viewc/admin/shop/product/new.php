
<form class="standard_form" method="post" action="<?php echo MainHelper::site_url('admin/shop/product/new'); ?>">

	<div class="standard_form_header clearfix">
		<h1 class="pull_left"><?php echo 'Create new product'; ?></h1>
	</div>

	<div class="standard_form_elements clearfix">
		<div class="clearfix">
			<label for="product_name"><?php echo 'Name'; ?></label>
			<span>
				<input tabindex="1" id="product_name" name="product_name" type="text" value="" class="text_input" />
			</span>
		</div>

		<div class="clearfix">
			<label for="product_type"><?php echo 'Product Type'; ?></label>
			<span>
				<select id="product_type" class="dropkick_lightWide" name="product_type" tabindex="2">
					<option value="0">
						<?php echo 'Select product type';?>
					</option>
					<?php foreach ($genreList as $genre): ?>
						<option value="<?php echo $genre->ID_PRODUCTTYPE; ?>">
							<?php echo $genre->ProductTypeName; ?>
						</option>
					<?php endforeach; ?>
				</select>
			</span>
		</div>

		<div class="clearfix">
			<label for="price"><?php echo 'Price'; ?></label>
			<span>
				<input tabindex="3" id="price" name="price" type="text" value="0" class="text_input" />
			</span>
		</div>

		<div class="standard_form_checks clearfix">
			<label for="is_downloadable"><?php echo 'Downloadable'; ?></label>
			<span>
				<div class="standard_form_checks_wrapper no-margin clearfix">
					<input class="dst" tabindex="4" id="is_downloadable" name="is_downloadable" type="checkbox" class="text_input" />
				</div>
			</span>
		</div>
		<div class="clearfix">
			<label for="download_url"><?php echo 'Download URL'; ?></label>
			<span>
				<input tabindex="5" id="download_url" name="download_url" type="text" value="" class="text_input" />
			</span>
		</div>

		<div class="standard_form_checks clearfix">
			<label for="is_special_offer"><?php echo 'Special offer'; ?></label>
			<span>
				<div class="standard_form_checks_wrapper no-margin clearfix">
					<input class="dst" tabindex="6" id="is_special_offer" name="is_special_offer" type="checkbox" class="text_input" />
				</div>
			</span>
		</div>
		<div class="clearfix">
			<label for="special_price"><?php echo 'Special price'; ?></label>
			<span>
				<input tabindex="7" id="special_price" name="special_price" type="text" value="0" class="text_input" />
			</span>
		</div>

		<div class="clearfix">
			<label for="product_desc"><?php echo 'Description'; ?></label>
			<span>
				<div class="standard_form_checks_wrapper no-margin clearfix">
					<textarea rows="7" cols="61" tabindex="8" id="product_desc" name="product_desc"></textarea>
				</div>
			</span>
		</div>
	</div>

	<div class="standard_form_footer clearfix">
		<input class="button button_auto light_blue pull_right" type="submit" value="<?php echo 'Save Settings'; ?>" />
	</div>

</form>
<script type="text/javascript">loadCheckboxes();</script>