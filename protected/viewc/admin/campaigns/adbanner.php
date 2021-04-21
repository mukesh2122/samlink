<?php ?>
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
<?php ?>