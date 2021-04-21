<?php include(realpath(dirname(__FILE__) . '/../tabs_wall.php')); ?>

<!-- Player groups start -->
<div class="list_container">
	<?php
	echo $this->renderBlock('players/common/search', array(
		'url' => MainHelper::site_url('player/'.$friendUrl.'/groups/search'),
		'searchText' => isset($searchText) ? $searchText : '',
		'searchTotal' => isset($searchTotal) ? $searchTotal : 0,
		'default' => $this->__('Search for groups')
	));
	
	echo $this->renderBlock('players/common/title_bar', array(
		'title' => $this->__('Groups'),
		'total' => $pagerObj->totalItem
	));

	if (!empty($groups)) {
		echo '<div class="item_list">';
		foreach ($groups as $item) {
			echo $this->renderBlock('common/group', array('item' => $item));
		}
		echo '</div>';

		if (isset($pager) and $pager != '') {
			echo $this->renderBlock('common/pagination', array('pager' => $pager));
		}
	}
	else{ ?>
		<p class="noItemsText"><?php echo $this->__('[_1] has no groups at this moment', array(PlayerHelper::showName($player))); ?></p>
	<?php } ?>
</div>
<!-- Player groups end -->