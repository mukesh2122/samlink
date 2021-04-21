<?php include(realpath(dirname(__FILE__) . '/../common/top.php'));?>

<!-- My blocks -->
<div class="list_container">
	<?php

	echo $this->renderBlock('players/common/title_bar', array(
		'title' => $this->__('My blocked users'),
		'nextTo' => ''
	));

	
	if (isset($blockedUsers) and !empty($blockedUsers)) {
		$viewer = User::getUser();
		echo '<div class="item_list">';
			foreach ($blockedUsers as $item) {
				$item = (object) $item;
				echo $this->renderBlock('common/player', array(
					'player' => $item,
					'viewer' => $viewer,
					'adminActions' => array()
				));
			}
		echo '</div>';

	} else { ?>
		<p class="noItemsText"><?php echo $this->__('You have no blocked users at this moment'); ?></p>
	<?php } ?>
</div>
<!-- My blocks end-->