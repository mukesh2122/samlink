<!-- Company search start -->
<?php if(isset($url)):?>
	<form method="GET" id="inside_search" class="c_column_search clearfix">
		<input type="hidden" id="form_url" value="<?php echo $url;?>" />
		<input type="text" id="inside_search_txt" class="c_column_search_input withLabel"
				title="<?php echo $label; ?>" 
				value="<?php echo (isset($searchText) and $searchText != '') ? htmlspecialchars($searchText) : $label; ?>" />
		<input type="submit" value="<?php echo $this->__('Search'); ?>" class="c_column_search_button green" />
	</form>

	<?php if(isset($searchText) and $searchText != ''):?>
		<div class="list_header">
			<h1><?php echo $this->__('Your search matched [_1]', array($searchTotal)).' '.$type; ?></h1>
			<div class="list_header_meta"><?php echo $this->__('You searched for:'); ?> <span><?php echo htmlspecialchars($searchText); ?></span></div>
		</div>
	<?php endif;?>
<?php endif;?>
<!-- Company search end -->