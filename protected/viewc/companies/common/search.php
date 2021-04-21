<!-- Company search start -->
<?php if(isset($url)): ?>
<div id="searchField">
	<form method="GET" id="inside_searchForm" class="searchForm">
		<input type="hidden" id="form_url" value="<?php echo $url; ?>">
		<input id="search_inputField" type="text" class="search_inputField" placeholder="<?php echo (isset($searchText) && ($searchText !== '')) ? htmlspecialchars($searchText) : $label; ?>">
        <div id="search_button"><input id="search_button_REAL" type="button" class="search_buttonIcon"></div>
	</form>

	<?php if(isset($searchText) && ($searchText !== '')): ?>
		<div class="list_header">
			<h1><?php echo $this->__('Your search matched [_1]', array($searchTotal)), ' ', $type; ?></h1>
			<div class="list_header_meta"><?php echo $this->__('You searched for:'); ?> <span><?php echo htmlspecialchars($searchText); ?></span></div>
		</div>
	<?php endif;?>
</div>
<?php endif;  ?>
<!-- Company search end -->