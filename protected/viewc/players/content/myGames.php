<?php include(realpath(dirname(__FILE__) . '/../common/top.php'));?>

<!-- My games start -->
<div class="list_container">
	<?php
	echo $this->renderBlock('players/common/search', array(
		'url' => MainHelper::site_url('players/my-games/search'),
		'searchText' => isset($searchText) ? $searchText : '',
		'searchTotal' => isset($searchTotal) ? $searchTotal : 0,
		'default' => $this->__('Search for games'),
		'type' => $this->__('games')
	));

	if($searchText == '') {
		echo $this->renderBlock('players/common/title_bar', array(
			'title' => $this->__('My games'),
			'total' => $pagerObj->totalItem
		));
	}

	if (!empty($games)) {
		echo '<div class="item_list">';
		foreach ($games as $item) {
			echo $this->renderBlock('common/game', array('item' => $item, 'owner' => true));
		}
		echo '</div>';

		if (isset($pager) and $pager != '') {
			echo $this->renderBlock('common/pagination', array('pager' => $pager));
		}
	}
	else{ ?>
		<p class="noItemsText"><?php echo $this->__('You have no games at this moment'); ?></p>
	<?php } ?>
</div>
<!-- My games end -->