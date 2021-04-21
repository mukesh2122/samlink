<?php $isEnabledTranslate = MainHelper::IsModuleEnabledByTag('translations'); ?>
<?php

echo '
<ul class="horizontal_tabs clearfix">
	<li class="active" >
		<a href="'. MainHelper::site_url(RECRUITMENT_NOTICES).'" class="icon_link">
		<i class="games_tab_icon"></i>Notices</a>
	</li>
	<li >
		<a href="'. MainHelper::site_url(RECRUITMENT_NOTICES.'/'.RECRUITMENT_MY_NOTICES).'" class="icon_link">
		<i class="games_tab_icon"></i>My Notices</a>
	</li>
	<li >
		<a href="'. MainHelper::site_url(RECRUITMENT_NOTICES.'/'.RECRUITMENT_CREATE_NOTICES).'" class="icon_link">
		<i class="games_tab_icon"></i>Create Notice</a>
	</li>
</ul>

<!-- header -->
<!-- Company list start -->
<h3>Filters</b></h3>	


';

?>
<div class="list_container filter_options" style="border-bottom:solid #666666 thin;">
<li class="global_nav_actions_li">
<a class="global_nav_action global_nav_action_trigger" href="#">
<?php  echo $ownertype != '' ? $ownertype : 'Owner Type';?><i class="down_arrow_light_icon"></i></a>
<div class="global_nav_action_dropdown">
		<ul class="dropdown_lang_select">
			<li><a href=<?php echo MainHelper::site_url(RECRUITMENT_NOTICES.'/ownertype/player'); ?>>
			<?php echo 'Player'; ?>
			</a></li>
			<li><a href=<?php echo MainHelper::site_url(RECRUITMENT_NOTICES.'/ownertype/group'); ?>>
			<?php echo 'Group'; ?>
			</a></li>
		</ul>
	</div>
</li>

 
<?php $game_id != '' ? $games = Games::getGameByID($game_id) : ''; ?>
<li class="global_nav_actions_li">
<a class="global_nav_action global_nav_action_trigger" href="#">
<?php  echo $game_id != '' ? $games->GameName : 'Games';?><i class="down_arrow_light_icon"></i></a>
<div class="global_nav_action_dropdown">
		<div class="dropdown_games_select">
		<ul class="dropdown_lang_select">
			<?php if(isset($gameList) and !empty($gameList)) {
				foreach ($gameList as $item) { ?>
					<li <?php echo $item->ID_GAME == $game_id ? 'class="active"' : ''; ?>><a href=<?php echo MainHelper::site_url(RECRUITMENT_NOTICES.'/game/'.$item->ID_GAME); ?>>
					<?php echo $item->GameName; ?>
					</a></li>
				<?php } ?>
			<?php } ?>	
		</ul>
		</div>
	</div>
</li>



<?php $langs = Lang::getLanguages(); $currentLang = Lang::getCurrentLangID(); $selectedLang = Lang::getLangById($currentLang); ?>
<?php $lang != '' ? ($lang!=$currentLang ? $selectedLang = Lang::getLangById($lang) : '') : '' ?>
<?php if($isEnabledTranslate == 1): ?>
<li class="global_nav_actions_li">
	<a class="global_nav_action global_nav_action_trigger" href="#"><?php  echo $selectedLang->NativeName;?><i class="down_arrow_light_icon"></i></a>
	<div class="global_nav_action_dropdown">
		<ul class="dropdown_lang_select">
			<?php foreach($langs as $language):?>
			<li <?php echo $language->ID_LANGUAGE == $currentLang ? 'class="active"' : '';?>>
				<a href="<?php echo MainHelper::site_url(RECRUITMENT_NOTICES.'/lang/'.$language->ID_LANGUAGE);?>"><?php echo $language->NativeName;?></a>
			</li>
			<?php endforeach;?>
		</ul>
	</div>
</li>
<?php endif; ?>

<?php $regionID = Recruitment::getRegionByID($region); ?>
<li class="global_nav_actions_li">
<a class="global_nav_action global_nav_action_trigger" href="#">
<?php  echo $region != '' ? $regionID->RegionName : 'Regions';?><i class="down_arrow_light_icon"></i></a>

<div class="global_nav_action_dropdown">
		<ul class="dropdown_lang_select">
			<?php if(isset($regionList) and !empty($regionList)) {
				foreach ($regionList as $item) { ?>
					<li <?php echo $region != '' ? ($item->ID_REGION == $regionID->ID_REGION ? 'class="active"' : '') : '';?>><a href=<?php echo MainHelper::site_url(RECRUITMENT_NOTICES.'/region/'.$item->ID_REGION); ?>>
					<?php echo $item->RegionName; ?>
					</a></li>
				<?php } ?>
			<?php } ?>	
			
		</ul>
	</div>
</li>

<?php $factionID = Recruitment::getFactionByID($faction); ?>
<li class="global_nav_actions_li">
<a class="global_nav_action global_nav_action_trigger" href="#">
<?php  echo $faction != '' ? $factionID->FactionName : 'Factions';?><i class="down_arrow_light_icon"></i></a>
<div class="global_nav_action_dropdown">
		<ul class="dropdown_lang_select">
			<?php if(isset($factionList) and !empty($factionList)) {
				foreach ($factionList as $item) { ?>
					<li <?php echo $item->ID_FACTION == $factionID->ID_FACTION ? 'class="active"' : '';?>><a href=<?php echo MainHelper::site_url(RECRUITMENT_NOTICES.'/faction/'.$item->ID_FACTION); ?>>
					<?php echo $item->FactionName; ?>
					</a></li>
				<?php } ?>
			<?php } ?>	
		</ul>
	</div>
</li>

<?php $roleID = Recruitment::getRoleByID($role); ?>
<li class="global_nav_actions_li">
<a class="global_nav_action global_nav_action_trigger" href="#">
<?php  echo $role != '' ? $roleID->RoleName : 'Roles';?><i class="down_arrow_light_icon"></i></a>
<div class="global_nav_action_dropdown">
		<ul class="dropdown_lang_select">
			<?php if(isset($roleList) and !empty($roleList)) {
				foreach ($roleList as $item) { ?>
					<li <?php echo $item->ID_ROLE == $roleID->ID_ROLE ? 'class="active"' : '';?>><a href=<?php echo MainHelper::site_url(RECRUITMENT_NOTICES.'/role/'.$item->ID_ROLE); ?>>
					<?php echo $item->RoleName; ?>
					</a></li>
				<?php } ?>
			<?php } ?>	
		</ul>
	</div>
</li>

<?php $levelID = Recruitment::getLevelByID($level); ?>
<li class="global_nav_actions_li">
<a class="global_nav_action global_nav_action_trigger" href="#">
<?php  echo $level != '' ? $levelID->GroupTypeName : 'Levels';?><i class="down_arrow_light_icon"></i></a>
<div class="global_nav_action_dropdown">
		<ul class="dropdown_lang_select">
			<?php if(isset($levelList) and !empty($levelList)) {
				foreach ($levelList as $item) { ?>
					<li <?php echo $level != '' ? ($item->ID_GROUPTYPE == $levelID->ID_GROUPTYPE ? 'class="active"' : '') : '';?>><a href=<?php echo MainHelper::site_url(RECRUITMENT_NOTICES.'/level/'.$item->ID_GROUPTYPE); ?>>
					<?php echo $item->GroupTypeName; ?>
					</a></li>
				<?php } ?>
			<?php } ?>	
		</ul>
	</div>
</li>

<?php $modeID = Recruitment::getModeByID($mode); ?>
<li class="global_nav_actions_li">
<a class="global_nav_action global_nav_action_trigger" href="#">
<?php  echo $mode != '' ? $modeID->GroupTypeName : 'Modes';?><i class="down_arrow_light_icon"></i></a>
<div class="global_nav_action_dropdown">
		<ul class="dropdown_lang_select">
			<?php if(isset($modeList) and !empty($modeList)) {
				foreach ($modeList as $item) { ?>
					<li <?php echo $mode != '' ? ($item->ID_GROUPTYPE == $modeID->ID_GROUPTYPE ? 'class="active"' : '') : '';?>><a href=<?php echo MainHelper::site_url(RECRUITMENT_NOTICES.'/mode/'.$item->ID_GROUPTYPE); ?>>
					<?php echo $item->GroupTypeName; ?>
					</a></li>
				<?php } ?>
			<?php } ?>	
		</ul>
	</div>
</li>

<?php $serverID = Recruitment::getServerByID($server); ?>
<li class="global_nav_actions_li">
<a class="global_nav_action global_nav_action_trigger" href="#">
<?php  echo $server != '' ? $serverID->ServerName : 'Servers';?><i class="down_arrow_light_icon"></i></a>
<div class="global_nav_action_dropdown">
		<ul class="dropdown_lang_select">
			<?php if(isset($serverList) and !empty($serverList)) {
				foreach ($serverList as $item) { ?>
					<li <?php echo $server != '' ? ($item->ID_SERVER == $serverID->ID_SERVER ? 'class="active"' : '') : '';?>><a href=<?php echo MainHelper::site_url(RECRUITMENT_NOTICES.'/server/'.$item->ID_SERVER); ?>>
					<?php echo $item->ServerName; ?>
					</a></li>
				<?php } ?>
			<?php } ?>	
		</ul>
	</div>
</li>
<br /> <br /> <br /> <br /> <br />
</div>
<!-- Notices list start -->

	<?php if(!isset($searchText)):?>
		<div class="list_header">
			<h1><?php echo $headerName;?></h1>
		</div>
	<?php endif; ?>

	<?php if(isset($noticesList) and !empty($noticesList)):?>
		
		<?php foreach ($noticesList as $key=>$item):?>
	<div class="rc_notices_item"
				<div class="rc_notices_rightBox">
					<div class="rc_notices_rightBox_col1">
					<ul>
						<li class="subtle_grey" title="Game"><?php echo $item->GameName; ?></li> 
						<li class="subtle_grey" title="Server"><?php echo $item->ServerName; ?></li> 
						<li class="subtle_grey" title="Ingame Name"><?php echo $item->InGameHandle; ?></li>
					</ul> 
					</div> 
					<div class="rc_notices_rightBox_col3">
					<ul>
						<li class="subtle_grey" title="Role"><?php echo $item->RoleName; ?></li> 
						<li class="subtle_grey" title="Gameplay"><?php echo $item->GameplayModeName; ?></li> 
						<li class="subtle_grey" title="Gameplay"><?php echo $item->GameplayLVLName; ?></li>+ 
					</ul> 
					</div> 
					<div class="rc_notices_rightBox_col2">
					<ul>
						<li class="subtle_grey" title="Faction"><?php echo $item->FactionName; ?></li>
						<li class="subtle_grey" title="Language"><?php echo $item->LanguageName; ?></li>
						<li class="subtle_grey" title="Region"><?php echo $item->RegionName; ?></li> 
					</ul> 
					</div> 
					<div class="rc_notices_rightBox_details">
						<span title="Details" ><?php echo $item->Details; ?></span>
					</div>
				</div>
				<div class="rc_notices_leftBox">
					<div class="rc_notices_leftBox_name">
						<p title="Name"><?php echo $item->OwnerName; ?></p> 
					</div>			
					<div class="rc_notices_leftBox_avatarP" style="background: no-repeat url('../global/css/img/AvatarP.png');">
					</div>
					<div class="rc_notices_leftBox_response rounded_5_btm">
						<span><a href="<?php echo MainHelper::site_url(RECRUITMENT_NOTICES.'/'.RECRUITMENT_RESPOND_NOTICES.'/'.$item->ID_NOTICE.'/'.$item->OwnerType); ?>" class="icon_link">Respond</a></span>
					</div>
				</div> 
			
	
					<br /><br />
			</div>
			
		<?php endforeach; ?>
		
		<?php if(isset($pager)):?>
			<?php echo $this->renderBlock('common/pagination', array('pager'=>$pager)) ?>
		<?php endif; ?>

	<?php else: ?>
		<p class="noItemsText"><?php echo $this->__('There are no notices here. Yet!'); ?></p>
		</div>
	<?php endif; ?>

<!-- Game list end -->