<?php $reguserFunctions = MainHelper::GetModuleFunctionsByTag('reguser'); ?>
<?php
	$userPlayer = User::getUser();
	$isApproved = ($userPlayer) ? MainHelper::IsPlayerApproved($userPlayer->ID_PLAYER) : 1;

	$suspendLevel = ($userPlayer) ? $userPlayer->getSuspendLevel() : 0;
	$noProfileFunctionality = MainHelper::GetNoProfileFunctionality($suspendLevel);
	$noSiteFunctionality = MainHelper::GetNoSiteFunctionality($suspendLevel);
?>

<?php
    $isAdmin = $event->isAdmin();
?>
<input type="hidden" id="event_id" value="<?php echo $event->ID_EVENT; ?>" />

<!-- Event photo start -->
<div class="profile_foto">
    <a href="<?php echo $event->EVENT_URL;?>" class="personal_profile_link">
		<?php echo MainHelper::showImage($event, THUMB_LIST_200x300, false, array('width', 'no_img' => 'noimage/no_events_200x300.png'));?>
    </a>
    <ul id="img_load" class="dn"></ul>
</div>
<!-- Event photo end -->

<!-- Event name start -->
<div class="profile_nickname">
	<span><?php echo $event->EventHeadline;?></span>
</div>
<!-- Event name end -->

<!-- Event info start -->
<div class="social_profile rounded_5_btm">
	<span class="user_info_header"><?php echo $this->__('Event Info');?>:</span>
	<?php if($isAdmin): ?>
		<a href="<?php echo MainHelper::site_url('event/'.$event->ID_EVENT.'/edit'); ?>" class="user_info_edit icon_profile_edit">Edit</a>
	<?php endif; ?>

	<div class="user_info_item_long clearfix">
		<span class="user_info_vr_long"><?php echo $this->__('Type');?>:</span>
		<span class="user_info_vl_long"><?php echo $this->__(ucfirst($event->EventType));?></span>
	</div>

	<div class="user_info_item_long clearfix">
		<span class="user_info_vr_long"><?php echo $this->__('Start date');?>:</span>
		<span class="user_info_vl_long"><?php echo $event->getLocalTime(); ?></span>
	</div>

	<div class="user_info_item_long clearfix">
		<span class="user_info_vr_long"><?php echo $this->__('End date');?>:</span>
		<span class="user_info_vl_long"><?php echo $event->getLocalEndTime(); ?></span>
	</div>

	<div class="user_info_item_long clearfix">
		<span class="user_info_vr_long"><?php echo $this->__('Location');?>:</span>
		<span class="user_info_vl_long"><?php echo $event->EventLocation;?></span>
	</div>

	<div class="user_info_item_long clearfix">
		<span class="user_info_vr_long"><?php echo $this->__('Participants');?>:</span>
		<span class="user_info_vl_long"><?php echo $event->ActiveCount; ?></span>
	</div>

	<div class="user_info_item_long clearfix">
		<span class="user_info_vr_long"><?php echo $this->__('Privacy');?>:</span>
		<span class="user_info_vl_long"><?php echo $event->isPublic == 1 ? $this->__('Public') : $this->__('Private'); ?></span>
	</div>

	<div class="user_info_item_long clearfix">
		<span class="user_info_vr_long"><?php echo $this->__('Invitations');?>:</span>
		<span class="user_info_vl_long"><?php echo $this->__(ucfirst($event->InviteLevel)); ?></span>
	</div>

	<div class="profile_buttons">
		<?php if(Auth::isUserLogged() && $isApproved==1 && !$noProfileFunctionality):?>

			<?php if($reguserFunctions['reguserSubscriptions']==1 && $isApproved==1):?>
				<?php if($event->isSubscribed()):?>

					<a data-opt='{"id":"<?php echo $event->ID_EVENT;?>", "type":"<?php echo SUBSCRIPTION_EVENT;?>"}' class="button button_178 button_icon button_no_shadow baby_blue clearfix dn subscribe subscribe_<?php echo $event->ID_EVENT;?>" href="javascript:void(0)">
						<span class="text mt3"><?php echo $this->__('Subscribe'); ?></span>
						<span class="icon iconr_subscribe">&nbsp;</span>
					</a>

					<a data-opt='{"id":"<?php echo $event->ID_EVENT;?>", "type":"<?php echo SUBSCRIPTION_EVENT;?>"}' class="button button_178 button_icon button_no_shadow baby_blue clearfix unsubscribe unsubscribe_<?php echo $event->ID_EVENT;?>" href="javascript:void(0)">
						<span class="text mt3"><?php echo $this->__('Unsubscribe'); ?></span>
						<span class="icon iconr_subscribe">&nbsp;</span>
					</a>

				<?php else: ?>

					<a data-opt='{"id":"<?php echo $event->ID_EVENT;?>", "type":"<?php echo SUBSCRIPTION_EVENT;?>"}' class="button button_178 button_icon button_no_shadow baby_blue clearfix subscribe subscribe_<?php echo $event->ID_EVENT;?>" href="javascript:void(0)">
						<span class="text mt3"><?php echo $this->__('Subscribe'); ?></span>
						<span class="icon iconr_subscribe">&nbsp;</span>
					</a>

					<a data-opt='{"id":"<?php echo $event->ID_EVENT;?>", "type":"<?php echo SUBSCRIPTION_EVENT;?>"}' class="button button_178 button_icon button_no_shadow baby_blue clearfix dn unsubscribe unsubscribe_<?php echo $event->ID_EVENT;?>" href="javascript:void(0)">
						<span class="text mt3"><?php echo $this->__('Unsubscribe'); ?></span>
						<span class="icon iconr_subscribe">&nbsp;</span>
					</a>

				<?php endif; ?>
			<?php endif; ?>

			<?php if($event->InviteLevel == 'open' or ($event->InviteLevel == 'user' and $event->isParticipating()) or $event->isAdmin()): ?>

				<a class="button button_178 button_icon button_no_shadow light_orange clearfix invite_event_friends" href="javascript:void(0)">
					<span class="text mt3"><?php echo $this->__('Invite People'); ?></span>
					<span class="icon iconr_send_message mt2 mb3">&nbsp;</span>
				</a>

			<?php endif; ?>

			<?php if(($event->InviteLevel == 'open' or $event->isInvited()) and !$event->isParticipating()): ?>

				<a class="button button_178 button_icon button_no_shadow light_orange clearfix F_joinEvent" href="javascript:void(0)" rel="<?php echo $event->ID_EVENT; ?>">
					<span class="text mt3"><?php echo $this->__('Participate'); ?></span>
					<span class="icon iconr_send_message mt2 mb3">&nbsp;</span>
				</a>

			<?php endif; ?>

			<?php if($event->isParticipating()): ?>
				<a class="button button_178 button_icon button_no_shadow light_orange clearfix F_unparticipate" href="javascript:void(0)" rel="<?php echo $event->ID_EVENT; ?>">
					<span class="text mt3"><?php echo $this->__('Unparticipate'); ?></span>
					<span class="icon iconr_send_message mt2 mb3">&nbsp;</span>
				</a>
			<?php endif; ?>

	<?php endif; ?>
	</div>
</div>
<!-- Event info end -->