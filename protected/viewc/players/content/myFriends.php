<?php include(realpath(dirname(__FILE__) . '/../common/top.php'));?>

<!-- My friends start -->

<?php
$viewer = User::getUser();
echo $this->renderBlock('players/content/tabs_friendcat', array(
	'friends' => isset($friends) ? $friends : array(),
	'viewer' => $viewer,
	'selectedfriendcatid' =>  (isset($selectedfriendcatid) && !empty($selectedfriendcatid)) ? $selectedfriendcatid : 0,
	'baseUrl' => 'players/my-friends/',
	'editCat' => true));
?>



<div class="list_container">
	<?php
	echo $this->renderBlock('players/common/search', array(
		'url' => MainHelper::site_url('players/my-friends/search'),
		'searchText' => isset($searchText) ? $searchText : '',
		'searchTotal' => isset($searchTotal) ? $searchTotal : 0,
		'type' => $this->__('friends')
	));

	if($searchText == '') {
		echo $this->renderBlock('players/common/title_bar', array(
			'title' => $this->__('My friends'),
			'nextTo' => '<div class="add_button fr mt-6"><a href="'.MainHelper::site_url('players/invite-friends').'" class="button button_medium mint">'.$this->__("Invite friends").'</a></div>'
		));
	}



	
	
	if (isset($friends) and !empty($friends)) {
		$viewer = User::getUser();
		echo '<div class="item_list">';
			foreach ($friends as $item) {
				$item = (object) $item;
				echo $this->renderBlock('common/player', array(
					'player' => $item,
					'viewer' => $viewer,
					'adminActions' => array('deleteFriend' => true, 'categorizeFriend' => true)
				));
			}
		echo '</div>';

		if (isset($pager) and $pager != '') {
			echo $this->renderBlock('common/pagination', array('pager' => $pager));
		}
	} else { ?>
		<p class="noItemsText"><?php echo $this->__('You have no friends at this moment'); ?></p>
	<?php } ?>
	
</div>
<!-- My friends end -->
