<?php
$isEnabledNews = MainHelper::IsModuleEnabledByTag('news');
$isEnabledForum = MainHelper::IsModuleEnabledByTag('forum');
$isEnabledEvents = MainHelper::IsModuleEnabledByTag('events');
if (MainHelper::IsModuleNotAvailableByTag('news')==1) $isEnabledNews = 0;
if (MainHelper::IsModuleNotAvailableByTag('forum')==1) $isEnabledForum = 0;
if (MainHelper::IsModuleNotAvailableByTag('events')==1) $isEnabledEvents = 0;
$groupFunctions = MainHelper::GetModuleFunctionsByTag('groups'); 
$anyMedia = $groupFunctions['groupMediaVideos'] + $groupFunctions['groupMediaScreenshots']
    + $groupFunctions['groupMediaConceptArt']+ $groupFunctions['groupMediaWallpapers'];
?>

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

<!-- JOIN -->
<ul id="subLikeUl">
<?php if(Auth::isUserLogged() and $isApproved==1 && !$noProfileFunctionality): ?>
	<?php if(!$isMember and !$hasApplied):?>	
        <a data-opt='{"id":"<?php echo $group->ID_GROUP;?>", "type":"<?php echo SUBSCRIPTION_GROUP;?>"}'
           class="subLikeLink subscribe subscribe_<?php echo $group->ID_GROUP;?>" 
           href="javascript:void(0)"><li class="subLikeList"><?php echo $this->__('Join Group');?> <div 
                    id="iconSubscribe">&nbsp;</div></li></a>
        <a data-opt='{"id":"<?php echo $group->ID_GROUP;?>", "type":"<?php echo SUBSCRIPTION_GROUP;?>"}'
           class="subLikeLink dn unsubscribe unsubscribe_<?php echo $group->ID_GROUP;?>" 
           href="javascript:void(0)"><li class="subLikeList"><?php echo $this->__('Leave Group');?> <div 
                    id="iconSubscribe">&nbsp;</div></li></a>
    <?php
    endif;
    if($isMember): ?>
        <a data-opt='{"id":"<?php echo $group->ID_GROUP;?>", "type":"<?php echo SUBSCRIPTION_GROUP;?>"}'
           class="subLikeLink unsubscribe unsubscribe_<?php echo $group->ID_GROUP;?>" 
           href="javascript:void(0)"><li class="subLikeList"><?php echo $this->__('Leave Group');?> <div 
                    id="iconSubscribe">&nbsp;</div></li></a>
        <a data-opt='{"id":"<?php echo $group->ID_GROUP;?>", "type":"<?php echo SUBSCRIPTION_GROUP;?>"}'
           class="subLikeLink dn subscribe subscribe_<?php echo $group->ID_GROUP;?>" 
           href="javascript:void(0)"><li class="subLikeList"><?php echo $this->__('Join Group');?> <div 
                    id="iconSubscribe">&nbsp;</div></li></a>
    <?php endif; ?>
<?php endif; ?>
</ul>
<!-- JOIN END -->

<ul id="leftMenuUl">
    <?php $groupUrl = $group->GROUP_URL;?>
    <a href="<?php echo $groupUrl;?>" class="leftMenuLink"><li class="leftMenuList"><?php echo ucfirst($this->__('Info'));?></li></a>
    <?php if ($isEnabledNews == 1): ?>
    <a href="<?php echo $groupUrl.'/news';?>" class="leftMenuLink"> <li class="leftMenuList"><?php echo ucfirst($this->__('News'));?></li></a>
    <?php endif; ?>
    <?php if ($isEnabledForum == 1): ?>
        <?php if(Auth::isUserLogged() and ($group->isMember() or User::getUser()->canAccess('Super Admin Interface') === TRUE)): ?>
    <a href="<?php echo $group->FORUM_URL;?>" class="leftMenuLink"><li class="leftMenuList"><?php echo ucfirst($this->__('Forum'));?></li></a>
        <?php endif; ?>
    <?php endif; ?>
    <a href="<?php echo $groupUrl.'/members';?>" class="leftMenuLink"> <li class="leftMenuList"><?php echo ucfirst($this->__('Members'));?></li></a>
    <?php if ($isEnabledEvents == 1): ?>
    <a href="<?php echo $group->EVENTS_URL;?>" class="leftMenuLink"> <li class="leftMenuList"><?php echo ucfirst($this->__('Events'));?></li></a>
    <?php endif; ?>
</ul>
