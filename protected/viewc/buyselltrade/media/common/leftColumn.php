<?php
	$userPlayer = User::getUser();
	$isApproved = ($userPlayer) ? MainHelper::IsPlayerApproved($userPlayer->ID_PLAYER) : 1;

	$suspendLevel = ($userPlayer) ? $userPlayer->getSuspendLevel() : 0;
	$noProfileFunctionality = MainHelper::GetNoProfileFunctionality($suspendLevel);
	$noSiteFunctionality = MainHelper::GetNoSiteFunctionality($suspendLevel);
?>

<?php
	$isAdmin = $group->isAdmin();
	$leader = $group->getLeader();
	$isMember = $group->isMember();
	$hasApplied = $group->hasApplied();
	if($leader)
		$leaderNick = PlayerHelper::showName($leader);
?>

<!-- Group photo start -->
<div class="profile_foto">
	<a href="<?php echo $group->GROUP_URL;?>" class="personal_profile_link">
		<?php echo MainHelper::showImage($group, THUMB_LIST_200x300, false, array('width', 'no_img' => 'noimage/no_group_200x300.png'));?>
	</a>
</div>
<!-- Group photo end -->

<!-- Admin change picture start -->
<?php if(Auth::isUserLogged() and $isAdmin):?>
	<div class="actions rounded_5_btm clearfix">
		<?php if($group->ImageURL != ''):?>
			<a rel="<?php echo $group->ID_GROUP;?>" id="change_group_picture" href="javascript:void(0)"><?php echo $this->__('change picture');?></a>
		<?php else: ?>
			<a rel="<?php echo $group->ID_GROUP;?>" id="add_group_picture" href="javascript:void(0)"><?php echo $this->__('upload picture');?></a>
		<?php endif; ?>
	</div>
<?php endif; ?>
<!-- Admin change picture end -->

<!-- Group name start -->
<div class="profile_nickname">
	<span><?php echo $group->GroupName;?></span>
</div>
<!-- Group name end -->

<!-- Group info start -->
<div class="social_profile rounded_5_btm">
	<span class="user_info_header"><?php echo $this->__('Group Info');?>:</span>

	<?php if (!empty($leader->URL)): ?>
	<div class="user_info_item_long clearfix">
		<span class="user_info_vr_long"><?php echo $this->__('Leader');?>:</span>
		<span class="user_info_vl_long"><?php echo $leader ? '<a href="'.MainHelper::site_url('player/'.$leader->URL).'">'.$leaderNick.'</a>' : '-';?></span>
	</div>
	<?php endif; ?>

	<?php if (!empty($group->GameName)): ?>
	<div class="user_info_item_long clearfix">
		<span class="user_info_vr_long"><?php echo $this->__('Game');?>:</span>
		<span class="user_info_vl_long"><?php echo $group->GameName ? $group->GameName : '-';?></span>
	</div>
	<?php endif; ?>

	<?php if (!empty($group->GroupType1)): ?>
	<div class="user_info_item_long clearfix">
		<span class="user_info_vr_long"><?php echo $this->__('Type 1');?>:</span>
		<span class="user_info_vl_long"><?php echo $group->GroupType1;?></span>
	</div>
	<?php endif; ?>

	<?php if (!empty($group->GroupType2)): ?>
	<div class="user_info_item_long clearfix">
		<span class="user_info_vr_long"><?php echo $this->__('Type 2');?>:</span>
		<span class="user_info_vl_long"><?php echo $group->GroupType2;?></span>
	</div>
	<?php endif; ?>

	<?php if (!empty($group->MemberCount)): ?>
	<div class="user_info_item_long clearfix">
		<span class="user_info_vr_long"><?php echo $this->__('Members');?>:</span>
		<span class="user_info_vl_long"><?php echo $group->MemberCount;?></span>
	</div>
	<?php endif; ?>

	<?php if (!empty($group->CreatedTime)): ?>
	<div class="user_info_item_long clearfix">
		<span class="user_info_vr_long"><?php echo $this->__('Created');?>:</span>
		<span class="user_info_vl_long"><?php echo date(DATE_SHORT, $group->CreatedTime);?></span>
	</div>
	<?php endif; ?>

	<div class="profile_buttons">
		<?php if(Auth::isUserLogged() and $isApproved==1 && !$noProfileFunctionality):?>

			<?php if($group->isSubscribed()):?>

				<a data-opt='{"id":"<?php echo $group->ID_GROUP;?>", "type":"<?php echo SUBSCRIPTION_GROUP;?>"}' class="button button_178 button_icon button_no_shadow baby_blue clearfix dn subscribe subscribe_<?php echo $group->ID_GROUP;?>" href="javascript:void(0)">
					<span class="text mt3"><?php echo $this->__('Subscribe'); ?></span>
					<span class="icon iconr_subscribe">&nbsp;</span>
				</a>

				<a data-opt='{"id":"<?php echo $group->ID_GROUP;?>", "type":"<?php echo SUBSCRIPTION_GROUP;?>"}' class="button button_178 button_icon button_no_shadow baby_blue clearfix unsubscribe unsubscribe_<?php echo $group->ID_GROUP;?>" href="javascript:void(0)">
					<span class="text mt3"><?php echo $this->__('Unsubscribe'); ?></span>
					<span class="icon iconr_subscribe">&nbsp;</span>
				</a>

			<?php else: ?>

				<a data-opt='{"id":"<?php echo $group->ID_GROUP;?>", "type":"<?php echo SUBSCRIPTION_GROUP;?>"}' class="button button_178 button_icon button_no_shadow baby_blue clearfix subscribe subscribe_<?php echo $group->ID_GROUP;?>" href="javascript:void(0)">
					<span class="text mt3"><?php echo $this->__('Subscribe'); ?></span>
					<span class="icon iconr_subscribe">&nbsp;</span>
				</a>

				<a data-opt='{"id":"<?php echo $group->ID_GROUP;?>", "type":"<?php echo SUBSCRIPTION_GROUP;?>"}' class="button button_178 button_icon button_no_shadow baby_blue clearfix dn unsubscribe unsubscribe_<?php echo $group->ID_GROUP;?>" href="javascript:void(0)">
					<span class="text mt3"><?php echo $this->__('Unsubscribe'); ?></span>
					<span class="icon iconr_subscribe">&nbsp;</span>
				</a>

			<?php endif; ?>
			
			<?php if(!$isMember and !$hasApplied):?>

				<a class="button button_178 button_icon button_no_shadow light_green clearfix group_apply ga_<?php echo $group->ID_GROUP;?>" href="<?php echo $group->GROUP_URL.'/request-to-join';?>" rel="iframe">
					<span class="text mt3"><?php echo $this->__('Request To Join Group'); ?></span>
					<span class="icon iconr_request_join_group">&nbsp;</span>
				</a>

			<?php endif;?>
			
			<?php if(!$group->isLiked()):?>

				<a class="button button_178 button_icon button_no_shadow light_grey clearfix group_like like like_<?php echo $group->ID_GROUP;?>" href="javascript:void(0)" rel="<?php echo $group->ID_GROUP;?>">
					<span class="text mt2"><?php echo $this->__('Like'); ?></span>
					<span class="icon iconr_like mt2 mb2">&nbsp;</span>
				</a>

				<a class="button button_178 button_icon button_no_shadow light_grey clearfix dn group_unlike unlike_<?php echo $group->ID_GROUP;?>" href="javascript:void(0)" rel="<?php echo $group->ID_GROUP;?>">
					<span class="text mt2"><?php echo $this->__('Unlike'); ?></span>
					<span class="icon iconr_like mt2 mb2">&nbsp;</span>
				</a>

			<?php else:?>

				<a class="button button_178 button_icon button_no_shadow light_grey clearfix dn group_like like like_<?php echo $group->ID_GROUP;?>" href="javascript:void(0)" rel="<?php echo $group->ID_GROUP;?>">
					<span class="text mt2"><?php echo $this->__('Like'); ?></span>
					<span class="icon iconr_like mt2 mb2">&nbsp;</span>
				</a>

				<a class="button button_178 button_icon button_no_shadow light_grey clearfix group_unlike unlike_<?php echo $group->ID_GROUP;?>" href="javascript:void(0)" rel="<?php echo $group->ID_GROUP;?>">
					<span class="text mt2"><?php echo $this->__('Unlike'); ?></span>
					<span class="icon iconr_like mt2 mb2">&nbsp;</span>
				</a>

			<?php endif;?>
		
		<?php endif; ?>
	</div>
</div>
<!-- Group info end -->