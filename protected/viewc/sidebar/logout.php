<?php
$isEnabledShop = MainHelper::IsModuleEnabledByTag('shop');
$isEnabledMemberships = MainHelper::IsModuleEnabledByTag('memberships');
if (MainHelper::IsModuleNotAvailableByTag('shop') == 1) { $isEnabledShop = 0; };
$suspendLevel = $player->getSuspendLevel();
$noProfileFunctionality = MainHelper::GetNoProfileFunctionality($suspendLevel);
$noSiteFunctionality = MainHelper::GetNoSiteFunctionality($suspendLevel);
$newNotifications = ($player->NewNotificationCount > 0) ? $player->NewNotificationCount : '';
$newMessages = ($player->NewMessageCount > 0) ? $player->NewMessageCount : '';
?>

<!-- Profile widget start -->
<div id="profile_widget" class="clearfix">
	<a class="profile_widget_avatar" href="<?php echo MainHelper::site_url('players/wall'); ?>">
		<?php echo MainHelper::showImage($player, THUMB_LIST_40x40, FALSE, array('no_img' => 'noimage/no_player_40x40.png')); ?>
	</a>
	<div class="profile_widget_navigation">
		<span class="profile_widget_username">
            <?php echo DooTextHelper::limitChar(PlayerHelper::showName($player), 20); ?>
        </span>
		<span class="profile_widget_wall_link">
            <a href="<?php echo MainHelper::site_url('players/wall'); ?>"><?php echo $this->__('Go to my profile page'); ?></a>
        </span>
		<span class="profile_widget_signout_link">
            <a class="" href="<?php echo MainHelper::site_url('login/logout'); ?>"><?php echo $this->__('Sign out'); ?></a>
        </span>
	</div>
	<div class="clear"></div>
	<?php if($isEnabledMemberships == 1 && !$noProfileFunctionality): ?>
		<a class="profile_widget_upgrade" href="<?php echo MainHelper::site_url('shop/membership'); ?>">
            <?php echo $this->__('Upgrade account'); ?>
        </a>
		<a class="profile_widget_upgrade" href="<?php echo MainHelper::site_url('shop/buy-credits'); ?>">
            <?php echo $this->__('Buy credits'); ?>
        </a>
	<?php endif; ?>
	<ul class="profile_widget_notifications">
		<?php if($player->NewNotificationCount > 0): ?>
            <li>
                <a href="<?php echo MainHelper::site_url('players/notifications'); ?>">
                    <span class="notification notification_red"><?php echo $player->NewNotificationCount; ?></span>
                    <?php echo ($player->NewNotificationCount != 1) ? $this->__('new notifications') : $this->__('new notification'); ?>
                </a>
            </li>
		<?php endif;
		if($player->NewMessageCount > 0): ?>
            <li>
                <a href="<?php echo MainHelper::site_url('players/conversations'); ?>">
                    <span class="notification notification_red"><?php echo $player->NewMessageCount; ?></span>
                    <?php echo ($player->NewMessageCount != 1) ? $this->__('new messages') : $this->__('new message'); ?>
                </a>
            </li>
		<?php endif;
		if($player->FreeGameLimit > 0): ?>
            <li>
                <a href="<?php echo MainHelper::site_url('shop/Games'); ?>">
                    <span class="notification notification_red"><?php echo $player->FreeGameLimit; ?></span>
                    <?php echo ($player->FreeGameLimit != 1) ? $this->__('free games') : $this->__('free game'); ?>
                </a>
            </li>
		<?php endif;
        if($player->NewAchievementCount > 0): ?>
            <li>
                <a href="<?php echo MainHelper::site_url('players/my-achievements'); ?>">
                    <span class="notification notification_red"><?php echo $player->NewAchievementCount; ?></span>
                    <?php echo ($player->NewAchievementCount != 1) ? $this->__('new achievements') : $this->__('new achievement'); ?>
                </a>
            </li>
		<?php endif; ?>
	</ul>
</div>
<!-- Profile widget end -->
<div class="profile_widget_seperator"></div>