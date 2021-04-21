<?php
include(realpath(dirname(__FILE__) . '/../common/top.php'));
$viewer = User::getUser();
?>


<?php
echo $this->renderBlock('players/content/tabs_friendcat', array(
	'friends' => isset($friends) ? $friends : array(),
	'viewer' => $friend,
	'selectedfriendcatid' =>  (isset($selectedfriendcatid) && !empty($selectedfriendcatid)) ? $selectedfriendcatid : 0,
	'baseUrl' => 'player/'.$friendUrl.'/friends/',
	'editCat' => false));
?>


<!-- Player friends start -->
<div class="list_container <?php echo (!isset($searchText)) ? 'filter_options' : ''; ?>">
	<?php
	/* 
	<!--====================================================================================-->
		THE PLAYER SEARCH IS IN HERE
	<!--====================================================================================-->
	*/
	echo $this->renderBlock('players/common/search', array(
		'url' => MainHelper::site_url('player/'.$friendUrl.'/friends/search'),
		'searchText' => isset($searchText) ? $searchText : '',
		'searchTotal' => isset($searchTotal) ? $searchTotal : 0
	));

	if(!isset($searchText) or $searchText == "") {
		echo $this->renderBlock('players/common/title_bar', array(
			'title' => $this->__('Friends')
		));
	}

	/* 
	<!--====================================================================================-->
		THE FILTER BAR IS IN HERE
	<!--====================================================================================-->
	*/
	if(!isset($searchText)) {
		echo $this->renderBlock('players/common/filter_bar', array(
			'tab' => isset($tab) ? $tab : 1,
			'order' => isset($order) ? $order : ''
		));
	}

	/*
	<!--====================================================================================-->
		THE PLAYER LIST IS IN HERE
	<!--====================================================================================-->
	*/
	if (isset($playerList) and !empty($playerList)) {
		echo '<div class="item_list">';
			foreach ($playerList as $item) {
				echo $this->renderBlock('common/player', array('player' => (object) $item, 'viewer' => $viewer));
			}
		echo '</div>';

		if (isset($pager) and $pager != '' and isset($pagerObj) and $pagerObj->totalPage > 1) {
			echo $this->renderBlock('common/pagination', array('pager' => $pager));
		}
	}
	?>
</div>
<!-- Player friends end -->