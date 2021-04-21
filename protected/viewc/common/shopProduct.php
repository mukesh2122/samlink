<?php
$description = $product->ProductDesc;
$descLimit = 50;

$userPlayer = User::getUser();
$suspendLevel = $userPlayer->getSuspendLevel();
$noProfileFunctionality = MainHelper::GetNoProfileFunctionality($suspendLevel);
$noSiteFunctionality = MainHelper::GetNoSiteFunctionality($suspendLevel);
?>

<?php
if($product->isSpecialPremOffer) {
	$color = 'grey';
	$price = $product->SpecialPremPrice;
} elseif ($product->isSpecialOffer) {
	$color = 'green';
	$price = $product->SpecialPrice;
} elseif ($product->isFeatured) {
	$color = 'orange';
	$price = $product->Price;
} else {
	$color = '';
	$price = $product->Price;
};
?>

<!-- Shop product start -->
<div class="shop_product clearfix">
	<a href="<?php echo MainHelper::site_url('shop/product/'.$product->ID_PRODUCT); ?>" class="shop_product_img F_product_<?php echo $product->ID_PRODUCT;?>">
		<?php echo MainHelper::showImage($product, THUMB_LIST_188x188, false, array('no_img' => 'noimage/no_shop_188x188.png')); ?>
	</a>

	<div class="shop_product_smeta">
		<a href="<?php echo MainHelper::site_url('shop/product/'.$product->ID_PRODUCT); ?>" class="shop_product_name"><?php echo $product->ProductName; ?></a>

		<p class="shop_product_desc"><?php echo $description ? strip_tags(DooTextHelper::limitChar($description, $descLimit)) : $this->__('There is no description for this product at the moment.'); ?></p>

		<div class="shop_product_price">
			<?php echo MainHelper::creditsOutput($price);?>
		</div>

		<?php if (!$noProfileFunctionality): ?>
			<div class="shop_product_add_brief">
				<a href="javascript:void(0)" class="shop_product_add_brief_btn <?php echo $color ? $color : ''; ?> F_addToCart" data-opt='{"ID":"<?php echo $product->ID_PRODUCT;?>", "qty":"1"}'><i class="basket_icon"></i></a>
			</div>
		<?php endif; ?>
	</div>
</div>
<!-- Shop product end -->







<?php /*
<div class="list_item big list_shop_item clearfix">
	<span class="list_item_img F_product_<?php echo $product->ID_PRODUCT;?>"><?php echo MainHelper::showImage($product, THUMB_LIST_100x100, false, array('no_img' => 'noimage/no_shop_100x100.png')); ?></span>

	<div class="list_item_meta clearfix">
<!--		<h2><?php echo $product->ProductName; ?></h2> -->
		<h2><a class="list_item_header" href="<?php echo MainHelper::site_url('shop/product/'.$product->ID_PRODUCT); ?>"><?php echo $product->ProductName; ?></a></h2>

		<p class="list_item_description short_desc_<?php echo $product->ID_PRODUCT; ?>">
			<?php
			if($description) {
				echo strip_tags(DooTextHelper::limitChar($description, $descLimit));
				if (strlen($description) > $descLimit) {
					echo '<a class="icon_link revealmore" data-open="' . $this->__('Read more') . '" data-close="' . $this->__('Hide description') . '" data-id="' . $product->ID_PRODUCT . '" href="#"> ' . $this->__('Read more') . '</a>';
				}
			} else {
				echo $this->__('There is no description for this product at the moment.');
			}
			?>
		</p>

		<p class="list_item_description long_form dn long_desc_<?php echo $product->ID_PRODUCT; ?>">
			<?php echo ContentHelper::handleContentOutput($description); ?>
		</p>

		<div class="list_shop_item_actions">
			<a data-opt='{"ID":"<?php echo $product->ID_PRODUCT;?>", "qty":"1"}' class="button button_large green F_addToCart" href="javascript:void(0)"><span><?php echo MainHelper::creditsOutput($product->Price);?></span> | <?php echo $this->__('Add to Cart'); ?></a>
			<?php if($product->isFeatured):?>
				<span class="free_for_members"><?php echo $this->__('Available for members for free');?> <a href="javascript:void(0)" class="F_helpBubble" rel="<?php echo $this->__('This product is available to Silver, Gold and Platinum Members for free. Upgrade now and get 1, 2 or 3 games for free every month.');?>">(?)</a></span>
			<?php endif;?>
		</div>
	</div>
</div>
*/ ?>