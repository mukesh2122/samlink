<?php $isEnabledMemberships = MainHelper::IsModuleEnabledByTag('memberships'); ?>

<?php include('common/top.php'); ?>

<?php
echo $this->renderBlock('shop/common/search', array(
	'url' => MainHelper::site_url('shop/search'),
	'searchText' => isset($searchText) ? $searchText : null,
	'searchTotal' => isset($searchTotal) ? $searchTotal : 0,
));
?>

<?php if(!isset($searchText)): ?>
	<?php $header = (isset($selectedGenreTranslated) and $selectedGenreTranslated != "") ? $selectedGenreTranslated : $this->__('All Products'); ?>
	<div class="list_header">
		<h1> <?php echo $header; ?></h1>
		<div class="shop_filter_container">
			<a href="#" class="shop_filter_trigger"><?php echo $this->__('Sort by:'); ?> <span><?php echo isset($selectedSort) ? $selectedSortTranslated : $this->__('Popularity'); ?></span><i class="down_arrow_light_icon"></i></a>
			<ul class="shop_filter_dropdown">
				<li>
					<a href="<?php echo MainHelper::site_url('shop/'.(($selectedGenreID != 0) ? urlencode($selectedGenre).'/' : '').'sort/Popularity');?>"<?php echo (!isset($selectedSort) || $selectedSort == 'Popularity') ? ' class="selected"' : '';?>><?php echo $this->__('Popularity'); ?></a>
				</li>
				<li>
					<a href="<?php echo MainHelper::site_url('shop/'.(($selectedGenreID != 0) ? urlencode($selectedGenre).'/' : '').'sort/Date added');?>"<?php echo (isset($selectedSort) && $selectedSort == 'Date added') ? ' class="selected"' : '';?>><?php echo $this->__('Date added') ?></a>
				</li>
				<li>
					<a href="<?php echo MainHelper::site_url('shop/'.(($selectedGenreID != 0) ? urlencode($selectedGenre).'/' : '').'sort/Alphabetically');?>"<?php echo (isset($selectedSort) && $selectedSort == 'Alphabetically') ? ' class="selected"' : '';?>><?php echo $this->__('Alphabetically'); ?></a>
				</li>
				<li>
					<a href="<?php echo MainHelper::site_url('shop/'.(($selectedGenreID != 0) ? urlencode($selectedGenre).'/' : '').'sort/Price low to high');?>"<?php echo (isset($selectedSort) && $selectedSort == 'Price low to high') ? ' class="selected"' : '';?>><?php echo $this->__('Price low to high') ?></a>
				</li>
				<li>
					<a href="<?php echo MainHelper::site_url('shop/'.(($selectedGenreID != 0) ? urlencode($selectedGenre).'/' : '').'sort/Price high to low');?>"<?php echo (isset($selectedSort) && $selectedSort == 'Price high to low') ? ' class="selected"' : '';?>><?php echo $this->__('Price high to low') ?></a>
				</li>
			</ul>
		</div>
	</div>
<?php endif; ?>

<!-- Color descriptions start -->
<table class="color_desc_table table table_bordered">
	<tr>
		<td class="centered">
			<span class="color_desc desc_blue"></span>
			<a href="<?php echo MainHelper::site_url('shop/'.urlencode('Regular'));?>"><?php echo $this->__('Regular'); ?></a>
		</td>
		<td class="centered">
			<span class="color_desc desc_green"></span>
			<a href="<?php echo MainHelper::site_url('shop/'.urlencode('Special offers'));?>"><?php echo $this->__('Special offers');?></a>
		</td>
		<?php if($isEnabledMemberships == 1):?>
			<td class="centered">
				<span class="color_desc desc_grey"></span>
				<a href="<?php echo MainHelper::site_url('shop/'.urlencode('Special premium offers'));?>"><?php echo $this->__('Premium offers');?></a>
			</td>
			<td class="centered">
				<span class="color_desc desc_orange"></span>
				<a href="<?php echo MainHelper::site_url('shop/'.urlencode('Free for premium members'));?>"><?php echo $this->__('Free for premium members');?></a>
			</td>
		<?php endif;?>
	</tr>
</table>
<!-- Color descriptions end -->

<?php
if(!empty($listProducts)){
	echo '<div class="shop_product_list">';
	echo '<div class="shop_product_row clearfix">';
	$i = 1;
	foreach($listProducts as $item){
		echo $this->renderBlock('common/shopProduct', array('product' => $item));

		echo ($i % 3 == 0) ? '</div><div class="shop_product_row clearfix">' : '';
		$i++;
	}
	echo '</div>';
	echo '</div>';

	if(isset($pager)){
		echo $this->renderBlock('common/pagination', array('pager'=>$pager));
	}
} else {
	echo '<div class="noItemsText">'.$this->__('There are no products at this moment').'</div>';
}
?>