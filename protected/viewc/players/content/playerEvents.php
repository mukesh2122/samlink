<?php include(realpath(dirname(__FILE__) . '/../tabs_wall.php')); ?>

<!-- Player events start -->
<div class="list_container">
	<?php
	echo $this->renderBlock('players/common/search', array(
		'url' => MainHelper::site_url('player/'.$friendUrl.'/events/search'),
		'searchText' => isset($searchText) ? $searchText : '',
		'searchTotal' => isset($searchTotal) ? $searchTotal : 0,
		'default' => $this->__('Search for events')
	));

	echo $this->renderBlock('players/common/title_bar', array(
		'title' => $this->__('Events'),
		'total' => $pagerObj->totalItem
	));

	if(isset($events) and !empty($events)){
		echo '<div class="item_list">';
		foreach($events as $e){
			echo $this->renderBlock('common/event', array('event' => $e, 'owner' => false));
		}
		echo '</div>';

		if (isset($pager) and $pager != '') {
			echo $this->renderBlock('common/pagination', array('pager'=>$pager));
		}
	}
	else{ ?>
		<div class="noItemsText"><?php echo $this->__('[_1] has no events at this moment', array(PlayerHelper::showName($player))); ?></div>
	<?php } ?>
</div>
<!-- Player events end -->