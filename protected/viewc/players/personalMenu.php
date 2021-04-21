<?php
$reguserFunctions = MainHelper::GetModuleFunctionsByTag('reguser');
$isEnabledContentchild = MainHelper::IsModuleEnabledByTag('contentchild');
if(MainHelper::IsModuleNotAvailableByTag('contentchild')==1) $isEnabledContentchild = 0;
$userPlayer = User::getUser();
$isApproved = ($userPlayer) ? MainHelper::IsPlayerApproved($userPlayer->ID_PLAYER) : 1;
$pvAllowWall = 1;
$pvAllowGroups = 1;
$pvAllowGames = 1;
$pvAllowFriends = 1;
$pvAllowEvents = 1;
$pvAllowAchievements = 1;
if(isset($friend) && ($userPlayer)) {
	if($userPlayer->ID_PLAYER != $friend->ID_PLAYER) {
		$SnPrivacy = new SnPrivacy;
		$pvTypes = $SnPrivacy->GetPrivacyTypesForPlayer($userPlayer,$friend);
		$pvAllowWall = $pvTypes['mywall']['allow'];
		$pvAllowGroups = $pvTypes['mygames']['allow'];
		$pvAllowGames = $pvTypes['mygroups']['allow'];
		$pvAllowFriends = $pvTypes['myfriends']['allow'];
		$pvAllowEvents = $pvTypes['myevents']['allow'];
		$pvAllowAchievements = $pvTypes['myachievements']['allow'];
	}
}
if(Auth::isUserLogged()):
	$newMessages = '';
	$newEvents = '';
	$newNotifications = '';
	$newFriends = '';
    $newAchievements = '';
	if(!isset($friend)) {
		if($player->NewMessageCount > 0) {
			$newMessages = '<span class="new_items">+'.$player->NewMessageCount.'</span>';
		}
		if($player->NewEventCount > 0) {
			$newEvents = '<span class="new_items">+'.$player->NewEventCount.'</span>';
		}
		if($player->NewNotificationCount > 0 && $reguserFunctions['reguserNotifications']==1 && $isApproved==1) {
			$newNotifications = '<span class="new_items">+'.$player->NewNotificationCount.'</span>';
		}
		if($player->FriendRequestsReceived > 0) {
			$newFriends = '<span class="new_items">+'.$player->FriendRequestsReceived.'</span>';
		}
        if($player->NewAchievementCount > 0) {
			$newAchievements = '<span class="new_items">+'.$player->NewAchievementCount.'</span>';
		}
	}

    $blocksURL = isset($friend) ? "" : MainHelper::site_url('players/my-blocks');
    $friendsURL = isset($friend) ? MainHelper::site_url('player/'.$friend->URL.'/friends') : MainHelper::site_url('players/my-friends');
    $gamesURL = isset($friend) ? MainHelper::site_url('player/'.$friend->URL.'/games') : MainHelper::site_url('players/my-games');
    $groupsURL = isset($friend) ? MainHelper::site_url('player/'.$friend->URL.'/groups') : MainHelper::site_url('players/my-groups');
    $eventsURL = isset($friend) ? MainHelper::site_url('player/'.$friend->URL.'/events') : MainHelper::site_url('players/my-events');
    $achievementsURL = isset($friend) ? MainHelper::site_url('player/'.$friend->URL.'/achievements') : MainHelper::site_url('players/my-achievements');

    $raidsURL = isset($friend) ? "" : MainHelper::site_url('players/raidscheduler');
    $wallURL = isset($friend) ? MainHelper::site_url('player/'.$friend->URL) : MainHelper::site_url('players/wall');
    $prefix = isset($friend) ? '' : $this->__('My').' ';
    $subscribtionsURL = MainHelper::site_url('players/my-subscriptions');
?>

<div class="left_nav">
    <ul>
		<?php if(MainHelper::IsModuleEnabledByTag('walls') == 1 && $pvAllowWall==1): ?>
			<li <?php echo $selected == 'wall' ? 'class="active"' : ''; ?>>
                <a class="nav_wall" href="<?php echo $wallURL; ?>">
                    <?php echo $this->__('Wall'); ?>
                </a>
            </li>
        <?php endif;
        if(!isset($friend)): ?>
			<?php if($reguserFunctions['reguserMessages']==1 && $isApproved==1): ?>
                <li <?php echo $selected == 'messages' ? 'class="active"' : ''; ?>>
                    <a class="nav_messages" href="<?php echo MainHelper::site_url('players/conversations')/*MainHelper::site_url('players/messages')*/; ?>">
                        <?php echo $this->__('Messages'), ' ', $newMessages; ?>
                    </a>
                </li>
			<?php endif;
			if($reguserFunctions['reguserNotifications']==1 && $isApproved==1) : ?>
                <li <?php echo $selected == 'notifications' ? 'class="active"' : ''; ?>>
                    <a class="nav_notifications" href="<?php echo MainHelper::site_url('players/notifications'); ?>">
                        <?php echo $this->__('Notifications'), ' ', $newNotifications; ?>
                    </a>
                </li>
			<?php endif;
        endif;
		if(MainHelper::IsModuleEnabledByTag('groups') == 1 && MainHelper::IsModuleNotAvailableByTag('groups')==0 && $pvAllowGroups==1): ?>
            <li <?php echo $selected == 'groups' ? 'class="active"' : ''; ?>>
                <a class="nav_groups" href="<?php echo $groupsURL; ?>">
                    <?php echo $prefix, $this->__('Groups'); ?>
                </a>
            </li>
        <?php endif;
		if($isEnabledContentchild == 1 && $pvAllowGames==1): ?>
            <li <?php echo $selected == 'games' ? 'class="active"' : ''; ?>>
                <a class="nav_games" href="<?php echo $gamesURL; ?>">
                    <?php echo $prefix, $this->__('Games'); ?>
                </a>
            </li>
        <?php endif;
        if(!isset($friend)):
			if($reguserFunctions['reguserSubscriptions']==1 && $isApproved==1) : ?>
                <li <?php echo $selected == 'subscription' ? 'class="active"' : ''; ?>>
                    <a class="nav_subscribtions" href="<?php echo $subscribtionsURL; ?>">
                        <?php echo $prefix, $this->__('Subscriptions'); ?>
                    </a>
                </li>
			<?php endif;
        endif;
		if($pvAllowFriends==1): ?>
            <li class="<?php echo $selected == 'friends' ? ' active' : '';?>">
                <a class="nav_friends" href="<?php echo $friendsURL; ?>">
                    <?php echo $prefix, $this->__('Friends'); ?>
                </a>
            </li>
        <?php endif;
        if($pvAllowAchievements == 1): ?>
            <li class="<?php echo $selected == 'achievements' ? ' active' : ''; ?>">
                <a class="nav_achievements" href="<?php echo $achievementsURL; ?>">
                    <?php echo $prefix, $this->__('Achievements'), $newAchievements; ?>
                </a>
            </li>
        <?php endif;
		if($blocksURL!=""): ?>
            <li class="<?php echo $selected == 'blocks' ? ' active' : ''; ?>">
                <a class="nav_friends" href="<?php echo $blocksURL; ?>">
                    <?php echo $prefix, $this->__('Blocks'); ?>
                </a>
            </li>
        <?php endif;
		if(($raidsURL !== "") && (MainHelper::IsModuleEnabledByTag('raidscheduler') == 1)): ?>
            <li class="<?php echo $selected == 'raids' ? ' active' : ''; ?>">
                <a class="nav_events" href="<?php echo $raidsURL; ?>">
                    <?php echo $prefix, $this->__('Raids'); ?>
                </a>
            </li>
        <?php endif;
		if(!isset($friend) and $player->isReferrer == 1):
			if (MainHelper::IsModuleEnabledByTag('events') == 1 && MainHelper::IsModuleNotAvailableByTag('events')==0 && $pvAllowEvents==1): ?>
				<li class="<?php echo $selected == 'events' ? ' active' : ''; ?>">
					<a class="nav_events" href="<?php echo $eventsURL; ?>">
                        <?php echo $prefix, $this->__('Events'), $newEvents; ?>
                    </a>
				</li>
			<?php endif;
			if($reguserFunctions['reguserRefferalprogram']==1 && $isApproved==1): ?>
				<li class="last<?php echo $selected == 'affiliate' ? ' active' : ''; ?>">
					<a class="nav_events" href="<?php echo MainHelper::site_url('referral'); ?>">
                        <?php echo $this->__('Referral Program'); ?>
                    </a>
				</li>	
			<?php endif;
		else:
			if(MainHelper::IsModuleEnabledByTag('events') == 1 && MainHelper::IsModuleNotAvailableByTag('events')==0 && $pvAllowEvents==1): ?>
				<li class="last<?php echo $selected == 'events' ? ' active' : ''; ?>">
					<a class="nav_events" href="<?php echo $eventsURL; ?>">
                        <?php echo $prefix, $this->__('Events'), $newEvents; ?>
                    </a>
				</li>
			<?php endif;
		endif;?>
    </ul>
</div>
<?php endif; ?>