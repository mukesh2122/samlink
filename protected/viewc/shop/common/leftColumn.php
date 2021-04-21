<?php $isEnabledMemberships = MainHelper::IsModuleEnabledByTag('memberships'); ?>

<ul class="vertical_tabs shop_special_menu">
	<li>
		<a href="<?php echo MainHelper::site_url('shop/'.(($selectedGenreID > 0) ? urlencode($selectedGenre).'/' : '').'sort/'.urlencode('New products'));?>"><?php echo $this->__('New products');?></a>
	</li>
	<li>
		<a href="<?php echo MainHelper::site_url('shop/'.(($selectedGenreID > 0) ? urlencode($selectedGenre).'/' : '').'sort/Popularity');?>"><?php echo $this->__('Popular products');?></a>
	</li>
	<?php if($isEnabledMemberships == 1):?>
	<li>
		<a href="<?php echo MainHelper::site_url('shop/'.urlencode('Free for premium members'));?>"><?php echo $this->__('Free for premium members');?></a>
	</li>
	<?php endif;?>
	<?php if($shop->GetTotalProducts(-2) > 0):?>
		<li>
			<a href="<?php echo MainHelper::site_url('shop/'.urlencode('Special offers'));?>"><?php echo $this->__('Special offers');?></a>
		</li>
	<?php endif;?>
	<?php if($shop->GetTotalProducts(-3) > 0 && $isEnabledMemberships == 1):?>
		<li>
			<a href="<?php echo MainHelper::site_url('shop/'.urlencode('Special premium offers'));?>"><?php echo $this->__('Premium offers');?></a>
		</li>
	<?php endif;?>
</ul>

<ul class="shop_cats_menu">
	<li class="shop_cats_menu_header"><?php echo $this->__('Categories'); ?></li>
	<li class="seperator"></li>
	<li>
		<a href="<?php echo MainHelper::site_url('shop');?>" <?php echo $selectedGenreID == 0 ? 'class="selected"' : '';?>><?php echo $this->__('All products');?></a>
	</li>
	<?php if(isset($genreList) and !empty($genreList)):?>
		<?php foreach($genreList as $genre):?>
			<li>
				<a href="<?php echo MainHelper::site_url('shop/'.  urlencode($genre->ProductTypeName));?>" <?php echo $selectedGenreID == $genre->ID_PRODUCTTYPE ? 'class="selected"' : '';?>><?php echo $genre->NameTranslated;?></a>
			</li>
		<?php endforeach;?>
	<?php endif;?>
</ul>