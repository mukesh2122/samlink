<?php
$reguserFunctions = MainHelper::GetModuleFunctionsByTag('reguser');
$reguserFields = MainHelper::GetModuleFieldsByTag('reguser');
$userPlayer = User::getUser();
$isApproved = ($userPlayer) ? MainHelper::IsPlayerApproved($userPlayer->ID_PLAYER) : 1;
$suspendLevel = ($userPlayer) ? $userPlayer->getSuspendLevel() : 0;
$noProfileFunctionality = MainHelper::GetNoProfileFunctionality($suspendLevel);
$noSiteFunctionality = MainHelper::GetNoSiteFunctionality($suspendLevel);
if(!isset($selected)) { $selected = 'wall'; };
$name = $friend->FirstName ? $friend->FirstName : '-';
$nickname = $friend->NickName ? $friend->NickName : '-';
$age = PlayerHelper::calculateAge($friend->DateOfBirth);
$country = PlayerHelper::getCountry($friend->Country);
$canRate = ($player && $friend->isFriend($player->ID_PLAYER)) ? TRUE : FALSE;
$visitorID = (Auth::isUserLogged()) ? User::getUser()->ID_PLAYER : NULL;
?>

<input type="hidden" value="<?php echo $friend->URL; ?>" name="friend_url" id="friend_url">

<!-- Profile photo start -->
<div class="profile_foto">
	<?php echo MainHelper::showImage($friend, THUMB_LIST_200x300, FALSE, array('width', 'no_img' => 'noimage/no_player_200x300.png')); ?>
</div>
<!-- Profile photo end -->

<!-- Profile nickname start -->
<div class="profile_nickname">
	<span><?php echo $nickname; ?></span>
</div>
<!-- Profile nickname end -->

<!-- Profile rating start -->
<?php echo PlayerHelper::showRating($friend, $canRate); ?>
<!-- Profile rating end -->

<!-- Profile info start -->
<div class="personal_profile rounded_5_btm">
    <?php if(isset($blogDesc)): ?>
        <span class="user_info_header"><?php echo $this->__('Blogger Info'); ?>:</span>
        <span><?php echo $blogDesc; ?></span>
    <?php else: ?>
        <span class="user_info_header"><?php echo $this->__('User Info'); ?>:</span>
        <?php if((!$noProfileFunctionality) && ($visitorID === $friend->ID_PLAYER)): ?>
            <a href="<?php echo MainHelper::site_url('players/edit'); ?>" class="user_info_edit icon_profile_edit">
                <?php echo $this->__('Edit'); ?>
            </a>
        <?php endif; ?>
        <div class="user_info_item clearfix">
            <span class="user_info_vr"><?php echo $this->__('Nick'); ?>:</span>
            <span class="user_info_vl"><?php echo $nickname; ?></span>
        </div>
        <?php if($reguserFields['DateOfBirth']['isEnabled'] == 1): ?>
            <div class="user_info_item clearfix">
                <span class="user_info_vr"><?php echo $this->__('Age'); ?>:</span>
                <span class="user_info_vl"><?php echo $age; ?></span>
            </div>
        <?php endif;
        if($reguserFields['Country']['isEnabled'] == 1): ?>
            <div class="user_info_item clearfix">
                <span class="user_info_vr"><?php echo $this->__('Country'); ?>:</span>
                <span class="user_info_vl"><?php echo $country; ?></span>
            </div>
        <?php endif;
    endif; ?>
	<div class="profile_buttons">
		<?php if(Auth::isUserLogged() && $player && $player->ID_PLAYER != $friend->ID_PLAYER && !$noProfileFunctionality):
			if($reguserFunctions['reguserSubscriptions']==1 && $isApproved==1):
				if($player->isSubscribed($friend->ID_PLAYER)): ?>
					<a data-opt='{"id":"<?php echo $friend->ID_PLAYER; ?>", "type":"<?php echo SUBSCRIPTION_PLAYER; ?>"}' class="button button_178 button_icon button_no_shadow baby_blue clearfix dn subscribe subscribe_<?php echo $friend->ID_PLAYER; ?>" href="javascript:void(0);">
						<span class="text mt3"><?php echo $this->__('Subscribe'); ?></span>
						<span class="icon iconr_subscribe">&nbsp;</span>
					</a>
					<a data-opt='{"id":"<?php echo $friend->ID_PLAYER; ?>", "type":"<?php echo SUBSCRIPTION_PLAYER; ?>"}' class="button button_178 button_icon button_no_shadow baby_blue clearfix unsubscribe unsubscribe_<?php echo $friend->ID_PLAYER; ?>" href="javascript:void(0);">
						<span class="text mt3"><?php echo $this->__('Unsubscribe'); ?></span>
						<span class="icon iconr_subscribe">&nbsp;</span>
					</a>
				<?php else: ?>
					<a data-opt='{"id":"<?php echo $friend->ID_PLAYER; ?>", "type":"<?php echo SUBSCRIPTION_PLAYER; ?>"}' class="button button_178 button_icon button_no_shadow baby_blue clearfix subscribe subscribe_<?php echo $friend->ID_PLAYER; ?>" href="javascript:void(0);">
						<span class="text mt3"><?php echo $this->__('Subscribe'); ?></span>
						<span class="icon iconr_subscribe">&nbsp;</span>
					</a>

					<a data-opt='{"id":"<?php echo $friend->ID_PLAYER; ?>", "type":"<?php echo SUBSCRIPTION_PLAYER; ?>"}' class="button button_178 button_icon button_no_shadow baby_blue clearfix dn unsubscribe unsubscribe_<?php echo $friend->ID_PLAYER; ?>" href="javascript:void(0);">
						<span class="text mt3"><?php echo $this->__('Unsubscribe'); ?></span>
						<span class="icon iconr_subscribe">&nbsp;</span>
					</a>
				<?php endif;
			endif; ?>
			<a rel="<?php echo $friend->ID_PLAYER; ?>" class="button button_178 button_icon button_no_shadow light_grey clearfix block_user" href="javascript:void(0);" title="<?php echo PlayerHelper::showName($friend); ?>">
				<span class="text mt3"><?php echo $this->__('Block user'); ?></span>
				<span class="icon  mt2 mb3">&nbsp;</span>
			</a>
			<a class="button button_178 button_icon button_no_shadow light_grey clearfix send_message" href="javascript:void(0);" title="<?php echo PlayerHelper::showName($friend); ?>">
				<span class="text mt3"><?php echo $this->__('Send message'); ?></span>
				<span class="icon iconr_send_message mt2 mb3">&nbsp;</span>
			</a>
			<?php if(!$player->isFriend($friend->ID_PLAYER) && !$noProfileFunctionality): ?>
				<a class="button button_178 button_icon button_no_shadow light_grey clearfix add_friend_profile" href="javascript:void(0);" rel="<?php echo $friend->ID_PLAYER; ?>">
					<span class="text mt3"><?php echo $this->__('Add friend'); ?></span>
					<span class="icon iconr_add_friend mt1 mb1">&nbsp;</span>
				</a>
			<?php endif;
		endif; ?>
	</div>
</div>
<!-- Profile info end -->
<?php include('personalMenu.php'); ?>