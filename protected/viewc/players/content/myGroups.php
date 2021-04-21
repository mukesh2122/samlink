<?php include(realpath(dirname(__FILE__) . '/../common/top.php'));?>

<!-- My groups start -->
<div class="list_container">
	<?php
	echo $this->renderBlock('players/common/search', array(
		'url' => MainHelper::site_url('players/my-groups/search'),
		'searchText' => isset($searchText) ? $searchText : '',
		'searchTotal' => isset($searchTotal) ? $searchTotal : 0,
		'default' => $this->__('Search for groups...'),
		'type' => $this->__('groups')
	));

	if($searchText == '') {
		echo $this->renderBlock('players/common/title_bar', array(
			'title' => $this->__('My groups'),
			'total' => $pagerObj->totalItem
		));
	}

	if (!empty($groups)){
		echo '<div class="item_list">';
			foreach ($groups as $item) {
				echo $this->renderBlock('common/group', array('item' => $item, 'owner' => true));
			}
		echo '</div>';

		if (isset($pager) and $pager != '') {
			echo $this->renderBlock('common/pagination', array('pager' => $pager));
		}
	}
	else{ ?>
		<p class="noItemsText"><?php echo $this->__('You have no groups at this moment'); ?></p>
	<?php } ?>
	</div>
<!-- My groups end -->