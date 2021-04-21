<!-- header -->
<div class="clearfix">
	<span class="fs22 fft fclg2 fl mr10"><?php echo 'Edit Product Info'; ?></span>
</div>
<!-- end header -->
<form method="post" id="edit_product_form" action="<?php echo MainHelper::site_url('admin/shop/product/'.$product->ID_PRODUCT); ?>">
	<input type="hidden" name="product_id" value="<?php echo $product->ID_PRODUCT; ?>" />

	<div class="mt5">
		<label for="product_name"><?php echo 'Name'; ?></label>
		<div class="border mt2">
			<input tabindex="1" id="product_name" name="product_name" type="text" value="<?php echo $product->ProductName; ?>" class="text_input" />
		</div>
	</div>
	<div class="mt5 pr zi100">
		<label for="product_type" class="cp"><?php echo 'Product Type'; ?></label>
		<div class="jqtransform pr border clearfix mt2">
			<select tabindex="2" id="product_type" name="product_type" class="w350 product_type jqselect">
				<option value="0">
					<?php echo 'Select product type';?>
				</option>
				<?php foreach ($genreList as $genre): ?>
					<option value="<?php echo $genre->ID_PRODUCTTYPE; ?>" <?php echo $genre->ID_PRODUCTTYPE == $product->ID_PRODUCTTYPE ? 'selected="selected"' : ''; ?>>
						<?php echo $genre->ProductTypeName; ?>
					</option>
				<?php endforeach; ?>
			</select>
		</div>
	</div>
	<div class="mt5">
		<label for="price"><?php echo 'Price'; ?></label>
		<div class="border mt2">
			<input tabindex="3" id="price" name="price" type="text" value="<?php echo $product->Price; ?>" class="text_input" />
		</div>
	</div>
	<div class="clearfix no-margin mt5">
		<input tabindex="4" class="fl" <?php echo (isset($product) and $product->isDownloadable == 1) ? 'checked="checked"' : '';?> type="checkbox" id="is_downloadable" name="is_downloadable" value="1" />
		<label class="fl cp" for="is_downloadable"><?php echo 'Downloadable';?></label>
	</div>
	<div class="mt5">
		<label for="download_url"><?php echo 'Download URL'; ?></label>
		<div class="border mt2">
			<input tabindex="5" id="download_url" name="download_url" type="text" value="<?php echo $product->DownloadURL; ?>" class="text_input" />
		</div>
	</div>
	<div class="clearfix no-margin mt5">
		<input tabindex="6" class="fl" <?php echo (isset($product) and $product->isSpecialOffer == 1) ? 'checked="checked"' : '';?> type="checkbox" id="is_special_offer" name="is_special_offer" value="1" />
		<label class="fl cp" for="is_special_offer"><?php echo 'Special offer';?></label>
	</div>
	<div class="mt5">
		<label for="special_price"><?php echo 'Special price'; ?></label>
		<div class="border mt2">
			<input tabindex="7" id="special_price" name="special_price" type="text" value="<?php echo $product->SpecialPrice; ?>" class="text_input" />
		</div>
	</div>

	<div class="mt5">
		<label for="product_desc" class="cp"><?php echo 'Product Description'; ?></label>
		<div class="border mt2">
			<?php MainHelper::loadCKE("product_desc", $product->ProductDesc); ?>
		</div>
	</div>

	<div class="profile_foto_edit mt5">
		<label><?php echo 'Product photo'; ?></label>
		<div class="standard_form_photo mt2">
			<div class="standard_form_photo_wrapper">
				<?php echo MainHelper::showImage($product, THUMB_LIST_100x100, false, array('width', 'no_img' => 'noimage/no_shop_100x100.png'));?>
			</div>
			<input type="hidden" id="product_id" value="<?php echo $product->ID_PRODUCT;?>" />
			<div class="standard_form_photo_action">
				<a id="change_shop_picture" rel="<?php echo $product->ID_PRODUCT;?>" class="button button_medium light_grey" href="javascript:void(0)"><?php echo $this->__('Upload Photo'); ?></a>
				<p><?php echo $this->__('Use PNG, GIF or JPG.') ?>
			</div>
		</div>
	</div>

	<div class="clear mt10">&nbsp;</div>
	<div class="standard_form_footer clearfix">
		<input class="button button_auto light_blue pull_right" type="submit" value="<?php echo 'Save Settings'; ?>" />
	</div>
</form>
<script type="text/javascript">loadDropdowns(); loadCheckboxes();</script>