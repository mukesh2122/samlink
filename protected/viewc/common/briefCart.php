<?php
if(Auth::isUserLogged()):
	if($cart = Cart::getBriefCart()): ?>
	<!-- Shopping cart start -->
        <a class="cart_link" href="<?php echo MainHelper::site_url('shop/cart');?>"><i class="basket_icon_dark"></i><?php echo $this->__('Cart'); ?>: <span><?php echo $cart->Quantity; ?></span></a>
	<!-- Shopping cart end -->
<?php endif;
endif;

/*
if(Auth::isUserLogged()):
	if($cart = Cart::getBriefCart()):?>
	<!-- Shopping cart start -->
	<div id="brief_cart_left">
		<div id="brief_cart_header" class="subtle_grey rounded_5_top"><?php echo $this->__('Shopping Cart');?></div>
		<?php if(isset($cart->FiCartProductRel) and !empty($cart->FiCartProductRel)):?>
			<div id="brief_cart_items" class="rounded_5_btm">
				<ul>
					<?php foreach($cart->FiCartProductRel as $cartItem):?>
						<li class="clearfix">
							<a data-opt='{"ID":"<?php echo $cartItem->ID_PRODUCT;?>"}' href="javascript:void(0)" class="delete_list_item F_removeFromCart">X</a>
							<span class="brief_cart_item"><?php echo $cartItem->ProductName;?></span><span class="brief_cart_item_pts"><?php echo $cartItem->Quantity .'x'. MainHelper::creditsOutput($cartItem->UnitPrice - $cartItem->Discount);?></span>
						</li>
					<?php endforeach;?>
				</ul>
				<div class="brief_cart_items_ttl">
				<?php echo $this->__('Total');?><div><?php echo MainHelper::creditsOutput($cart->TotalPrice);?></div>
				</div>
				<div class="clear"></div>
			</div>
		<?php endif;?>
	</div>
	<a class="button button_large orange" href="<?php echo MainHelper::site_url('shop/cart');?>"><?php echo $this->__('Continue Order');?></a>
	<!-- Shopping cart end -->
<?php endif;
endif;?>
*/ ?>