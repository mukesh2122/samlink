<!-- Search start -->
<?php if(isset($url)):?>
	<form class="c_column_search clearfix" id="inside_search" method="GET" action="<?php echo Mainhelper::site_url('shop/search') ?>">
		<input type="hidden" id="form_url" value="<?php echo $url;?>" />
		<input type="text" id="inside_search_txt" class="c_column_search_input withLabel"
				title="<?php echo $this->__('Search for products...'); ?>" 
				value="<?php echo (isset($searchText) and $searchText != '') ? htmlspecialchars($searchText) : $this->__('Search for products...'); ?>" />
		<input type="submit" value="<?php echo $this->__('Search'); ?>" class="c_column_search_button light_blue" />
	</form>

	<?php if(isset($searchText) and $searchText != ''):?>
		<div class="list_header">
			<h1><?php echo $this->__('Your search matched').' '.$searchTotal.' '.$this->__('products'); ?></h1>
			<div class="list_header_meta"><?php echo $this->__('You searched for:'); ?> <span><?php echo htmlspecialchars($searchText); ?></span></div>
		</div>
	<?php endif;?>
<?php endif;?>
<!-- Search end -->