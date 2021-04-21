<?php include(realpath(dirname(__FILE__) . '/../common/top.php'));?>

<!-- My events start -->
<div class="list_container">
	<?php
	echo $this->renderBlock('players/common/search', array(
		'url' => MainHelper::site_url('players/my-events/search'),
		'searchText' => isset($searchText) ? $searchText : '',
		'searchTotal' => isset($searchTotal) ? $searchTotal : 0,
		'default' => $this->__('Search for events'),
		'type' => $this->__('events')
	));

	if($searchText == '') {
		echo $this->renderBlock('players/common/title_bar', array(
			'title' => $this->__('My events'),
			'total' => $pagerObj->totalItem
		));
	}

	if(isset($events) and !empty($events)){

		echo '<div class="item_list">';
		foreach($events as $e){
			echo $this->renderBlock('common/event', array('event' => $e, 'owner' => true));
		}
		echo '</div>';

		if (isset($pager) and $pager != '') {
			echo $this->renderBlock('common/pagination', array('pager'=>$pager));
		}
	}
	else{ ?>
		<p class="noItemsText"><?php echo $this->__('You have no events at this moment'); ?></p>
	<?php } ?>
	</div>
<!-- My events end -->