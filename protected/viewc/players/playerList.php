<?php
include('common/top.php');
$player = $viewer = User::getUser();
$tab = isset($tab) ? $tab : 1;

$listTitle = $this->__('Players you might know');
if($tab == 2) {
	$listTitle = $this->__('Players who play the same games as you');
} else if($tab == 3) {
	$listTitle = $this->__('Players who are members of the same groups as you');
} else if($tab == 4) {
	$listTitle = $this->__('Players who live in your area');
}
?>

<?php if(Auth::isUserLogged()):?>
	<input type="hidden" id="selectedTab" value="<?php ?>" />
	<ul class="horizontal_tabs clearfix">
		<li class="active">
			<a class="icon_link" href="<?php ?>"><i class="players_tab_icon"></i><?php echo $this->__('Find Players');?></a>
		</li>
		
		<li class="<?php ?>">
                    <a class="icon_link" href="<?php echo MainHelper::site_url('players/top-list'); ?>"<i class="photo_tab_icon"></i><?php echo $this->__('Top Players');?></a>
		</li>
		<?php endif; ?>
               
	</ul>
	
<!-- Player suggestions start -->
<div class="list_container <?php echo (!isset($searchText)) ? 'filter_options' : ''; ?>">
	<?php
	/* 
	<!--====================================================================================-->
		THE PLAYER SEARCH IS IN HERE
	<!--====================================================================================-->
	*/
	echo $this->renderBlock('players/common/search', array(
		'url' => MainHelper::site_url('players/search'),
		'searchText' => isset($searchText) ? $searchText : '',
		'searchTotal' => isset($searchTotal) ? $searchTotal : 0
	));

	if(!isset($searchText)) {
		echo $this->renderBlock('players/common/title_bar', array(
			'title' => $listTitle,
			'selectedCategory' => $selectedCategory
		));
	}

	/* 
	<!--====================================================================================-->
		THE FILTER BAR IS IN HERE
	<!--====================================================================================-->
	*/
	if(!isset($searchText)) {
		echo $this->renderBlock('players/common/filter_bar', array(
			'tab' => $tab,
			'order' => isset($order) ? $order : '',
			'selectedCategory' => $selectedCategory
		));
	}

	/*
	<!--====================================================================================-->
		THE PLAYER LIST IS IN HERE
	<!--====================================================================================-->
	*/
	if (isset($playerList) and !empty($playerList)) {
		echo '<div id="wall_container" class="item_list">';
			foreach ($playerList as $item) {
				echo $this->renderBlock('common/player', array('player' => (object) $item, 'owner' => $player, 'viewer' => $viewer));
			}
		echo '</div>';

		/*
		<!--====================================================================================-->
			THE "SHOW MORE" BUTTON IS IN HERE
		<!--====================================================================================-->
		*/
		echo $this->renderBlock('players/common/show_more', array(
			'tab' => $tab,
			'order' => isset($order) ? $order : '',
			'total' => isset($total) ? $total : 0,
		));
		
		if (isset($pager) and $pager != '' and isset($pagerObj) and $pagerObj->totalPage > 1) {
			echo $this->renderBlock('common/pagination', array('pager' => $pager));
		}
	}
	?>
</div>
<!-- Player suggestions end -->