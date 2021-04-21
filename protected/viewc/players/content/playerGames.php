<?php include(realpath(dirname(__FILE__) . '/../tabs_wall.php')); ?>

<!-- Player games start -->
<div class="list_container">
	<?php
	echo $this->renderBlock('players/common/search', array(
		'url' => MainHelper::site_url('player/'.$friendUrl.'/games/search'),
		'searchText' => isset($searchText) ? $searchText : '',
		'searchTotal' => isset($searchTotal) ? $searchTotal : 0,
		'default' => $this->__('Search for games')
	));

	echo $this->renderBlock('players/common/title_bar', array(
		'title' => $this->__('Games'),
		'total' => $pagerObj->totalItem
	));

	if (!empty($games)) {
		echo '<div class="item_list">';
		foreach ($games as $item) {
			echo $this->renderBlock('common/game', array('item' => $item, 'owner' => false));
		}
		echo '</div>';

		if (isset($pager) and $pager != '') {
			echo $this->renderBlock('common/pagination', array('pager' => $pager));
		}
	}
	else{ ?>
		<p class="noItemsText"><?php echo $this->__('[_1] has no games at this moment', array(PlayerHelper::showName($player))); ?></p>
	<?php } ?>
</div>
<!-- Player games end -->