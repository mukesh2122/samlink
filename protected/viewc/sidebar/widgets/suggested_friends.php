<?php
	$listOfFields = array('MutualCount', 'sameCity', 'sameCountry', 
		'CommonGamesPlayedCount', 'CommonGamesSubscribedCount', 'CommonGroupsCount');

	$random = array_rand($listOfFields);
	$selectedField = $listOfFields[$random];

	$listOfSuggestedFriends = MainHelper::getSuggestedFriends($player->ID_PLAYER, $selectedField);
?>
<div class="widget suggested-friends" data-state="<?php echo ($isOpen == 1) ? 'open' : 'closed'; ?>" data-id="<?php echo $widgetId; ?>">
	<div class="top">
		<h3><?php echo $widgetName; ?></h3>
		<span class="slide-icon" title="<?php echo ($isOpen == 1) ? 'Collapse' : 'Expand'; ?> this widget.">&#9660;</span>
		<span class="close-icon" title="Hide this widget.">X</span>
	</div>
	<ul class="widget-body list-of-items">
		<?php
			if (empty($listOfSuggestedFriends)) { ?>
				<li>
					<p>No suggested friends.</p>
				</li>
			<?php 
			} else {
				foreach ($listOfSuggestedFriends as $friend) {
					$userInfo = User::getById($friend['ID_LEVEL2FRIEND']);
					if ($userInfo) {
						$userCountry = PlayerHelper::getCountry($userInfo->Country);

						$friendsQuantity = ($friend['MutualCount'] > 1) ? 'friends' : 'friend';
						$reasonsList = array(
							'MutualCount' => $friend['MutualCount'] . ' ' . $friendsQuantity . ' in common.',
							'sameCity' => 'You live in the same city.',
							'sameCountry' => 'You are from the same country.',
							'CommonGamesPlayedCount' => 'You have played ' . $friend['CommonGamesPlayedCount'] . ' common games.',
							'CommonGamesSubscribedCount' => 'You are subscribed to ' . $friend['CommonGamesSubscribedCount'] . ' common games.',
							'CommonGroupsCount' => 'You have ' . $friend['CommonGroupsCount'] . ' groups in common.'
						);
						?>
						<li>
							<div class="player-image">
								<a href="<?php echo MainHelper::site_url('player/' . $userInfo->URL); ?>">
									<?php echo MainHelper::showImage($userInfo, THUMB_LIST_40x40, false, array('no_img' => 'noimage/no_player_40x40.png')); ?>
								</a>
							</div>
							<h4><a href="<?php echo MainHelper::site_url('player/' . $userInfo->URL); ?>" title="<?php echo $this->__($userInfo->NickName); ?>"><?php echo $this->__($userInfo->NickName); ?></a></h4>
							<p><span>Country</span>: <?php echo $this->__($userCountry); ?></p>
							<p class="reason">(<?php echo $this->__($reasonsList[$selectedField]); ?>)</p>
							<div class="add-btn">
								<a href="#" class="add_member_profile" rel="<?php echo $this->__($userInfo->ID_PLAYER); ?>">Add</a>
							</div>
						</li>
						<?php
					}
				}
			}
		?>
	</ul>
</div>