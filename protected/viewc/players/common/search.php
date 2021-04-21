<!--====================================================================================-->
<?php if(isset($url)):
    if(!isset($default)){ $default = $this->__('Search for players...'); };
    if(!isset($type)){ $type = $this->__('players'); }; ?>

    <form method="GET" id="inside_search" class="c_column_search clearfix">
		<input type="hidden" id="form_url" value="<?php echo $url;?>">
		<input type="text" id="inside_search_txt" class="c_column_search_input withLabel"
				title="<?php echo $default; ?>" 
				value="<?php echo (isset($searchText) and $searchText != '') ? htmlspecialchars($searchText) : $default; ?>">
		<input type="submit" value="<?php echo $this->__('Search'); ?>" class="c_column_search_button red">
	</form>

	<?php if(isset($searchText) && $searchText != ''): ?>
		<div class="list_header">
			<h1><?php echo $this->__('Your search matched') . ' ' . $searchTotal . ' ' . $type; ?></h1>
			<div class="list_header_meta"><?php echo $this->__('You searched for:'); ?> <span><?php echo htmlspecialchars($searchText); ?></span></div>
		</div>
	<?php endif;
endif; ?>
<!--====================================================================================-->