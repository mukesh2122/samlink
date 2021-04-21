<?php $isEnabledNews = MainHelper::IsModuleEnabledByTag('news'); ?>
<?php $isEnabledForum = MainHelper::IsModuleEnabledByTag('forum'); ?>
<?php $isEnabledEvents = MainHelper::IsModuleEnabledByTag('events'); ?>
<?php if (MainHelper::IsModuleNotAvailableByTag('news')==1) $isEnabledNews = 0; ?>
<?php if (MainHelper::IsModuleNotAvailableByTag('forum')==1) $isEnabledForum = 0; ?>
<?php if (MainHelper::IsModuleNotAvailableByTag('events')==1) $isEnabledEvents = 0; ?>
<?php $isEnabledRaids = 0;
      if(Auth::isUserLogged()): ?>
        <?php if(isset($group)): ?>
            <?php if(($group->isMember()) || User::getUser()->canAccess('Super Admin Interface')): ?>
                <?php $isEnabledRaids = 1; ?>
            <?php endif; ?>
        <?php endif; ?>
<?php endif; ?>

<?php $groupFunctions = MainHelper::GetModuleFunctionsByTag('groups'); 
		$anyMedia = $groupFunctions['groupMediaVideos'] + $groupFunctions['groupMediaScreenshots']
		+ $groupFunctions['groupMediaConceptArt']+ $groupFunctions['groupMediaWallpapers'];
?>

<?php if(isset($group)):?>
    <input id="group_id" value="<?php echo $group->ID_GROUP;?>" type="hidden" />
<?php endif; ?>  

<?php echo !isset($hideAdd) ? $this->renderBlock('common/header_ads', array()) : '';?>

<?php if(isset($infoBox)):?>
    <?php echo $infoBox;?>
<?php endif; ?>

<!-- header -->
<?php /*
<div class="mt10 header groups_header clearfix mb15">
    <a href="<?php echo MainHelper::site_url('group');?>"><?php echo $this->__('Groups');?></a>
	<?php if(isset($addHeader)):?>
		<?php echo $addHeader;?>
	<?php endif;?>
</div>
*/ ?>
<!-- end header -->

<?php if(isset($CategoryType)):?>
	<ul class="horizontal_tabs clearfix">
		<?php if(!isset($group)):?>
			<li class="<?php echo $CategoryType == GROUP_ALL ? 'active':'';?>">
				<a class="icon_link" href="<?php echo MainHelper::site_url('groups');?>"><i class="groups_tab_icon"></i><?php echo $this->__('All Groups');?></a>
			</li>
			<li class="<?php echo $CategoryType == GROUP_RECENT ? 'active':'';?>">
				<a class="icon_link" href="<?php echo MainHelper::site_url('groups/recent');?>"><i class="recent_tab_icon"></i><?php echo $this->__('Recently Added');?></a>
			</li>
		<?php else:?>
			<li class="<?php echo $CategoryType == GROUP_INFO ? 'active':'';?>">
				<a class="icon_link" href="<?php echo $group->GROUP_URL;?>"><i class="info_tab_icon"></i><?php echo $this->__('Info');?></a>
			</li>
			<?php if ($isEnabledNews == 1): ?>
				<li class="<?php echo $CategoryType == GROUP_NEWS ? 'active':'';?>">
					<a class="icon_link" href="<?php echo $group->GROUP_URL.'/news';?>"><i class="news_tab_icon"></i><?php echo $this->__('News');?></a>
				</li>
			<?php endif; ?>
			<li class="<?php echo $CategoryType == GROUP_MEMBER ? 'active':'';?>">
				<a class="icon_link" href="<?php echo $group->GROUP_URL.'/members';?>"><i class="groups_tab_icon"></i><?php echo $this->__('Members');?></a>
			</li>
			<?php if ($isEnabledForum == 1): ?>
				<?php if(Auth::isUserLogged() and ($group->isMember() or User::getUser()->canAccess('Super Admin Interface') === TRUE)): ?>
					<li class="<?php echo $CategoryType == GROUP_FORUM ? 'active':'';?>">
						<a class="icon_link" href="<?php echo $group->FORUM_URL;?>"><i class="forum_tab_icon"></i><?php echo $this->__('Forum');?></a>
					</li>
				<?php endif; ?>
			<?php endif; ?>
			<?php if ($anyMedia != 0): ?>
			<li class="<?php echo $CategoryType == GROUP_MEDIA ? 'active':'';?>">
				<a class="icon_link" href="<?php echo $group->GROUP_URL.'/media';?>"><i class="media_tab_icon"></i><?php echo $this->__('Media');?></a>
			</li>
			<?php endif; ?>
			<?php if ($isEnabledEvents == 1): ?>
			<li class="<?php echo $CategoryType == GROUP_EVENTS ? 'active':'';?>">
				<a class="icon_link" href="<?php echo $group->EVENTS_URL;?>"><i class="event_tab_icon"></i><?php echo $this->__('Events');?></a>
			</li>
			<?php endif; ?>
            <?php if($isEnabledRaids == 1): ?>
			<li class="<?php echo $CategoryType == GROUP_RAIDS ? 'active':'';?>">
				<a class="icon_link" href="<?php echo $group->RAIDS_URL; ?>"><i class="event_tab_icon"></i><?php echo $this->__('Raids');?></a>
			</li>
			<?php endif; ?>
		<?php endif;?>
	</ul>
<?php endif;?>

<?php /*

<?php if(isset($group)):?>
    <input id="group_id" value="<?php echo $group->ID_GROUP;?>" type="hidden" />
<?php endif; ?>  

<div class="header_ad">
	<?php echo !isset($hideAdd) ? $this->renderBlock('common/header_ads', array()) : '';?>
</div>

<?php if(isset($infoBox)):?>
    <?php echo $infoBox;?>
<?php endif; ?>

<div class="clearfix header groups_header clearfix">
    <a href="<?php echo MainHelper::site_url('groups');?>" class="fl"><?php echo $this->__('Groups');?></a>
	<?php if(!isset($group)):?>
		<a rel="iframe" href="<?php echo MainHelper::site_url('groups/creategroup');?>" class="fr fs12 group_header_button"><?php echo $this->__('Create New Group +');?></a>
	<?php endif; ?>
	<?php if(isset($addHeader)):?>
		<?php echo $addHeader;?>
	<?php endif;?>
</div>
<?php if(isset($CategoryType)):?>
	<ul id="news_tab" class="tab_navigation_big clearfix">
		<?php if(!isset($group)):?>
			<li><a class="<?php echo $CategoryType == GROUP_ALL ? 'active':'';?>" href="<?php echo MainHelper::site_url('groups');?>"><span><span><span class="icon_tabs icon_all_groups">&nbsp;</span><?php echo $this->__('All Groups');?></span></span></a></li>
			<li><a class="<?php echo $CategoryType == GROUP_RECENT ? 'active':'';?>" href="<?php echo MainHelper::site_url('groups/recent');?>"><span><span><span class="icon_tabs icon_recent">&nbsp;</span><?php echo $this->__('Recent');?></span></span></a></li>
		<?php else:?>
			<li><a class="<?php echo $CategoryType == GROUP_INFO ? 'active':'';?>" href="<?php echo $group->GROUP_URL;?>"><span><span><span class="icon_tabs icon_info">&nbsp;</span><?php echo $this->__('Info');?></span></span></a></li>
			<li><a class="<?php echo $CategoryType == GROUP_NEWS ? 'active':'';?>" href="<?php echo $group->GROUP_URL.'/news';?>"><span><span><span class="icon_tabs icon_tab_news">&nbsp;</span><?php echo $this->__('News');?></span></span></a></li>
			<li><a class="<?php echo $CategoryType == GROUP_MEMBER ? 'active':'';?>" href="<?php echo $group->GROUP_URL.'/members';?>"><span><span><span class="icon_tabs icon_tab_members">&nbsp;</span><?php echo $this->__('Members');?></span></span></a></li>
			<li><a class="<?php echo $CategoryType == GROUP_FORUM ? 'active':'';?>" href="<?php echo $group->FORUM_URL;?>"><span><span><span class="icon_tabs icon_forums">&nbsp;</span><?php echo $this->__('Forum');?></span></span></a></li>
			<li><a class="<?php echo $CategoryType == GROUP_MEDIA ? 'active':'';?>" href="<?php echo $group->GROUP_URL.'/media';?>"><span><span><span class="icon_tabs icon_games">&nbsp;</span><?php echo $this->__('Media');?></span></span></a></li>
			<li><a class="<?php echo $CategoryType == GROUP_EVENTS ? 'active':'';?>" href="<?php echo $group->EVENTS_URL;?>"><span><span><span class="icon_tabs icon_events">&nbsp;</span><?php echo $this->__('Events');?></span></span></a></li>
		<?php endif;?>
	</ul>
<?php endif;?>

*/ ?>