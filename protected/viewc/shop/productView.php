<?php
	$userPlayer = User::getUser();
	$suspendLevel = ($userPlayer) ? $userPlayer->getSuspendLevel() : 0;
	$noProfileFunctionality = MainHelper::GetNoProfileFunctionality($suspendLevel);
	$noSiteFunctionality = MainHelper::GetNoSiteFunctionality($suspendLevel);
?>
<div class="productv_back_actions clearfix">
	<div class="breadcrumb">
		<a href="<?php echo MainHelper::site_url('shop');?>"><?php echo $this->__('Shop');?></a> >
		<a href="<?php echo MainHelper::site_url('shop/'.$productType->ProductTypeName);?>"><?php echo $productType->NameTranslated;?></a> >
		<?php echo $product->ProductName;?>
	</div>

	<div class="back_to">
		<a href="<?php echo MainHelper::site_url('shop/'.$productType->ProductTypeName);?>"><?php echo $this->__('Back to'); ?> <?php echo strtolower($productType->NameTranslated);?></a>
	</div>
</div>

<div class="productv_wrapper clearfix">
	<div class="productv_left">
		<div class="productv_main_img">
			<a href="<?php echo MainHelper::site_url('shop/product/'.$product->ID_PRODUCT.'/image/0');?>" rel="fancy_img" class="F_product_<?php echo $product->ID_PRODUCT;?>">
				<span class="F_product_<?php echo $product->ID_PRODUCT;?>">
				<?php echo MainHelper::showImage($mainImage, THUMB_LIST_330x260, false, array('no_img' => 'noimage/no_shop_330x260.png')); ?>
				</span>
			</a>
		</div>
		<div class="productv_add_img">
			<?php foreach ($imagetabs as $imagetab):?>
				<a href="<?php echo MainHelper::site_url('shop/product/'.$product->ID_PRODUCT.'/image/'.$imagetab->ID_PRODUCTINFO);?>" rel="fancy_img">
					<?php echo MainHelper::showImage($imagetab, THUMB_LIST_100x100, false, array('no_img' => 'noimage/no_shop_100x100.png')); ?>
				</a>
			<?php endforeach;?>
		</div>
	</div>

	<div class="productv_right">
		<h1 class="productv_name"><?php echo $product->ProductName;?></h1>

		<span class="productv_price"><?php echo '<b>'.$this->__('Normal price').':</b> '.MainHelper::creditsOutput($product->Price);?></span>
		<?php if ($product->isSpecialOffer == 1): ?>
			<span class="productv_price"><?php echo $this->__('Special price').': '.MainHelper::creditsOutput($product->SpecialPrice);?></span>
		<?php endif; ?>
		<?php if ($product->isSpecialPremOffer == 1): ?>
			<span class="productv_price"><?php echo $this->__('Premium price').': '.MainHelper::creditsOutput($product->SpecialPremPrice);?></span>
		<?php endif; ?>
		<?php if ($product->isSpecialOffer == 1 || ($product->isSpecialPremOffer == 1 && $currentMembership !== FALSE)): ?>
			<span class="productv_price"><?php echo $this->__('Your price').': '.MainHelper::creditsOutput(($product->isSpecialPremOffer == 1 && $currentMembership !== FALSE) ? $product->SpecialPremPrice : $product->SpecialPrice).' - '.$this->__('you save').' '.MainHelper::creditsOutput($product->Price - (($product->isSpecialPremOffer == 1 && $currentMembership !== FALSE) ? $product->SpecialPremPrice : $product->SpecialPrice));?></span>
		<?php endif; ?>

		<?php $desc = ContentHelper::handleContentOutput($product->ProductDesc); ?>
		<?php if($desc != ''): ?>
			<p class="productv_desc"><?php echo $desc;?></p>
		<?php else: ?>
			<p class="productv_desc"><?php echo $this->__('There is no description at the moment.'); ?></p>
		<?php endif; ?>

		<?php if (!$noProfileFunctionality):?>
			<div class="productv_to_basket clearfix">
				<a data-opt='{"ID":"<?php echo $product->ID_PRODUCT;?>", "qty":"1"}' class="button button_large green F_addToCart" href="javascript:void(0)"><?php echo $this->__('Add to Cart'); ?></a>

				<?php if($product->isFeatured):?>
					<span class="free_for_members"><?php echo $this->__('Available for premium members for free');?> <a href="javascript:void(0)" class="F_helpBubble" rel="<?php echo $this->__('This product is available to Silver, Gold and Platinum Members for free. Upgrade now and get 1, 2 or 3 games for free every month.');?>">(?)</a></span>
				<?php endif; ?>
			</div>
		<?php endif; ?>

		<?php $isAdmin = $product->isAdmin(); ?>
		<?php if(!empty($infotabs) or $isAdmin === TRUE): ?>
	    	<ul class="horizontal_tabs small clearfix">
	    	<?php foreach ($infotabs as $infotab):?>
				<li style="position: relative;" <?php echo ($infotab->ID_PRODUCTINFO == $activeTabInfo) ? 'class="active"' : '';?>>
	            	<a <?php echo ($isAdmin === TRUE) ? 'class="pr30"' : ''; ?> href="<?php echo MainHelper::site_url('shop/product/'.$product->ID_PRODUCT.'/info/'.$infotab->ID_PRODUCTINFO);?>"><?php echo $infotab->Headline;?></a>
		            <?php if($isAdmin === TRUE):?>
	    	            <a href="javascript:void(0)" rel="<?php echo $infotab->ID_PRODUCTINFO;?>" class="cal pa icon_close_game_tab" style="margin-right: -9px; margin-top: 3px;"></a>
	        	    <?php endif;?>
		        </li>
				<?php if($activeTabInfo == $infotab->ID_PRODUCTINFO) $infodesc = $infotab->InfoDesc; ?>
	    	<?php endforeach; ?>
		    <?php if($isAdmin === TRUE):?>
	    	    <li>
	        	    <a class="add" rel="iframe" href="<?php echo MainHelper::site_url('shop/product/'.$product->ID_PRODUCT.'/admin/addinfotab');?>"><?php echo $this->__('Add tab +'); ?></a>
		        </li>

		        <?php if(!empty($infotabs)):?>
	    	        <li>
	        	        <a class="edit" rel="iframe" href="<?php echo MainHelper::site_url('shop/product/'.$product->ID_PRODUCT.'/admin/editinfotab');?>"><?php echo $this->__('Edit tab +'); ?></a>
	            	</li>
		        <?php endif;?>
	    	<?php endif;?>
			</ul>
		<?php endif;?>

		<?php if(isset($infodesc)): ?>
			<div class="productv_info_text">
				<?php echo $infodesc; ?>
			</div>
		<?php endif; ?>
	</div>
</div>