<?php $isEnabledShop = MainHelper::IsModuleEnabledByTag('shop'); ?>
<?php $isEnabledMemberships = MainHelper::IsModuleEnabledByTag('memberships'); ?>
<?php if (MainHelper::IsModuleNotAvailableByTag('shop')==1) $isEnabledShop = 0; ?>

<?php
$suspendLevel = $player->getSuspendLevel();
$noProfileFunctionality = MainHelper::GetNoProfileFunctionality($suspendLevel);
$noSiteFunctionality = MainHelper::GetNoSiteFunctionality($suspendLevel);


$newMessages = '';
$newNotifications = '';
$newNotifications = '';

if($player->NewMessageCount > 0) {
	$newMessages = $player->NewMessageCount;
}
if($player->NewNotificationCount > 0) {
	$newNotifications = $player->NewNotificationCount;
}
?>

<!-- Profile widget start -->
<div id="profile_widget" class="clearfix">
	<a class="profile_widget_avatar" href="<?php echo MainHelper::site_url('players/wall');?>">
		<?php echo MainHelper::showImage($player, THUMB_LIST_60x60, false, array('no_img' => 'noimage/no_player_60x60.png'));?>
	</a>

	<div class="profile_widget_navigation w120">
		<span class="profile_widget_username"><?php echo DooTextHelper::limitChar(PlayerHelper::showName($player), 20); ?></span>
		<span class="profile_widget_wall_link"><a href="<?php echo MainHelper::site_url('esport/spotlight');?>"><?php echo $this->__('Go to my spotlight') ?></a></span>
		<span class="profile_widget_signout_link"><a class="" href="<?php echo MainHelper::site_url('login/logout'); ?>"><?php echo $this->__('Sign out');?></a></span>
	</div>
</div>
<!-- Profile widget end -->
