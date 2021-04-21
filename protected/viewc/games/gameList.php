<!-- Game list start -->
<div class="list_container <?php echo (!isset($searchText)) ? 'filter_options' : ''; ?>">
	<?php if(isset($url)) {
		echo $this->renderBlock('games/common/search', array(
			'url' => $url,
			'searchText' => $searchText,
			'searchTotal' => $searchTotal,
			'label' => $label = $this->__('Search for games...'),
			'type' => $type = $this->__('games')
		));
    };
	if(!isset($searchText)): ?>
		<div class="list_header">
			<h1><?php echo $this->__($headerName); ?></h1>
		</div>
	<?php endif;
	if(!isset($searchText)) {
	 	echo $this->renderBlock('games/common/filter_bar', array(
			'tab' => $tab,
			'order' => $order,
			'genre' => $genre
		));
	 };
	if(isset($gameList) and !empty($gameList)): ?>
		<div class="item_list">
            <?php foreach ($gameList as $key=>$item) { echo $this->renderBlock('common/game', array('item' => $item, 'odd' => (($key-1) % 2 == 0))); }; ?>
		</div>
        <?php if(isset($pager)) { echo $this->renderBlock('common/pagination', array('pager'=>$pager)); };
	else: ?>
		<p class="noItemsText"><?php echo $this->__('There are no games here. Yet!'); ?></p>
	<?php endif; ?>
</div>
<!-- Game list end -->