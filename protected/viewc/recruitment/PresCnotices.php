<?php $isEnabledTranslate = MainHelper::IsModuleEnabledByTag('translations'); ?>
<?php

//include("previewstart.html");
//http://localhost/beta/recruitment2

echo '
<ul class="horizontal_tabs clearfix">
	<li >
		<a href="'. MainHelper::site_url(RECRUITMENT_NOTICES).'" class="icon_link">
		<i class="games_tab_icon"></i>Notices</a>
	</li>
	<li >
		<a href="'. MainHelper::site_url('recruitment2/'.RECRUITMENT_MY_NOTICES).'" class="icon_link">
		<i class="games_tab_icon"></i>My Notices</a>
	</li>
	<li class="active" >
		<a href="'. MainHelper::site_url('recruitment2/'.RECRUITMENT_CREATE_NOTICES).'" class="icon_link">
		<i class="games_tab_icon"></i>Create Notice</a>
	</li>
</ul>

<!-- header -->
<!-- Company list start -->
<div class="list_container filter_options">
	<!-- Company search start 
	<form method="GET" id="inside_search" class="c_column_search clearfix">
	<input type="hidden" id="form_url" value="http://playnation.eu/companies/search">
		<input type="text" id="inside_search_txt" class="c_column_search_input withLabel" title="Search for companies..." value="Search for companies...">
		<input type="submit" value="Search" class="c_column_search_button green">
	</form>

	 Company search end -->
		<div class="list_header">
			<h1>Recruitment - Create Notice</h1>
		</div>

<div class="rc_create_notice">

';
?>
<script type="text/javascript">
	function verify(object) {
		show_alert = '';
		if (document.getElementById('owner').value=='') {
			show_alert = 'You have to be Login to create a notice ';
		}
		if (document.getElementById('game').value=='') {
			if (show_alert!='') {
				show_alert+= ' and ou must choose a Game!';
			} else {
				show_alert = 'You must choose a Game!';
			}
		} else {
			if (show_alert!='') {
				show_alert += '!';
			}
		}
		var link_redirect = document.getElementById('link_create').value;
		if (show_alert!='') {
			alert(show_alert);
			
		} else {
			document.getElementById("rcForm").submit(); 
		}
	}
	
</script>
<div id="params" ></div>
<div id="demoWrapper">
			<h5 id="status"></h5>
			<form id="rcForm" action="<?php echo MainHelper::site_url(RECRUITMENT_NOTICES.'/'.RECRUITMENT_CREATE_NOTICES.'/notices/create'); ?>" method="post" class="bbq">
				<div id="fieldWrapper">
					<span class="step" id="first">
						<span class="profile_widget_upgrade">First step - Identity</span>
						<li class="global_nav_actions_li_c"  align="right">
						<a class="global_nav_action global_nav_action_trigger" href="#">
						<?php  echo $ownertype != '' ? $ownertype : 'Owner Type';?><i class="down_arrow_light_icon"></i></a>
						<div class="global_nav_action_dropdown">
								<ul class="dropdown_lang_select">
									<li <?php echo $ownertype == 'player' ? 'class="active"' : ''; ?>><a href=<?php echo MainHelper::site_url(RECRUITMENT_NOTICES.'/'.RECRUITMENT_CREATE_NOTICES.'/ownertype/player'); ?>>
									<?php echo 'Player'; ?>
									</a></li>
									<li  <?php echo $ownertype == 'group' ? 'class="active"' : ''; ?>><a href=<?php echo MainHelper::site_url(RECRUITMENT_NOTICES.'/'.RECRUITMENT_CREATE_NOTICES.'/ownertype/group'); ?>>
									<?php echo 'Group'; ?>
									</a></li>
								</ul>
							</div>
							
						</li>
						
						<label for="owntype">&nbsp;</label>
						<input name="owntype" value="<?php echo $ownertype; ?>" id="owntype" type="hidden" name="owner">
						<p><b>Owner Type</b></p>
						
						<label for="owner">&nbsp;</label>
						<input name="owner" class="step" value="<?php echo $ownerid; ?>" id="owner" type="text" name="owner" readonly>
						<p><b>Owner ID</b></p>
								
					</span>
					<br />
					
					<span id="general" class="step">
						<span class="profile_widget_upgrade">Step 2 - General Information</span>
						<br /><br />
						<?php $gamesID = Games::getGameByID($game_id); ?>
						
						
						<li class="global_nav_actions_li_c">
						<a class="global_nav_action global_nav_action_trigger" href="#">
						<?php  echo $game_id != '' ? $gamesID->GameName : 'Games';?><i class="down_arrow_light_icon"></i></a>
							<div class="global_nav_action_dropdown">
								<div class="dropdown_games_select">
								<ul class="dropdown_lang_select">
									<?php if(isset($gameList) and !empty($gameList)) {
										foreach ($gameList as $item) { ?>
											<li <?php echo  $game_id != '' ? ($item->ID_GAME == $game_id ? 'class="active"' : ''):''; ?>><a href=<?php echo MainHelper::site_url(RECRUITMENT_NOTICES.'/'.RECRUITMENT_CREATE_NOTICES.'/game/'.$item->ID_GAME); ?>>
											<?php echo $item->GameName; ?>
											</a></li>
										<?php } ?>
									<?php } ?>	
								</ul>
								</div>
							</div>
						</li>
						
						<input name="game" value="<?php echo $game_id; ?>" id="game" type="hidden">
						<p>Choose the game you wish to create a notice for </p>
						<br /><br />
						
						<?php $regionID = Recruitment::getRegionByID($region); ?>
						<li class="global_nav_actions_li_c">
						<a class="global_nav_action global_nav_action_trigger" href="#">
						<?php  echo $region != '' ? $regionID->RegionName : 'Regions';?><i class="down_arrow_light_icon"></i></a>
						<div class="global_nav_action_dropdown">
								<ul class="dropdown_lang_select">
									<?php if(isset($regionList) and !empty($regionList)) {
										foreach ($regionList as $item) { ?>
											<li <?php echo $region != '' ? ($item->ID_REGION == $regionID->ID_REGION ? 'class="active"' : '') : '';?>><a href=<?php echo MainHelper::site_url(RECRUITMENT_NOTICES.'/'.RECRUITMENT_CREATE_NOTICES.'/region/'.$item->ID_REGION); ?>>
											<?php echo $item->RegionName; ?>
											</a></li>
										<?php } ?>
									<?php } ?>	
								</ul>
							</div>
						</li>
					    <input name="region" value="<?php echo $region != '' ? $regionID->ID_REGION : ''; ?>" id="region" type="hidden" name="owner">
						
						<p>Choose the Region</p>
						<br /><br />
						
						
						<?php $langs = Lang::getLanguages(); $currentLang = Lang::getCurrentLangID(); $selectedLang = Lang::getLangById($currentLang);?>
						<?php if($isEnabledTranslate == 1): ?>
						<li class="global_nav_actions_li_c">
							<a class="global_nav_action global_nav_action_trigger" href="#"><?php  echo $selectedLang->NativeName;?><i class="down_arrow_light_icon"></i></a>
							<div class="global_nav_action_dropdown">
								<ul class="dropdown_lang_select">
									<?php foreach($langs as $lang):?>
									<li <?php echo $lang->ID_LANGUAGE == $currentLang ? 'class="active"' : '';?>>
										<a href="<?php echo MainHelper::site_url(RECRUITMENT_NOTICES.'/'.RECRUITMENT_CREATE_NOTICES.'/lang/'.$lang->ID_LANGUAGE);?>"><?php echo $lang->NativeName;?></a>
									</li>
									<?php endforeach;?>
								</ul>
							</div>
						</li>
						<?php endif; ?>
						<input name="language" value="<?php echo $currentLang; ?>" id="language" type="hidden" name="owner">
						<p>Choose the language</p>
					</span>
					<br />
					<span id="locale" class="step">	
						<span class="profile_widget_upgrade">Step 3 - Game Info</span>
						<br /><br />
						
						<?php $serverID = Recruitment::getServerByID($server); ?>
						<li class="global_nav_actions_li_c">
						<a class="global_nav_action global_nav_action_trigger" href="#">
						<?php  echo $server != '' ? $serverID->ServerName : 'Servers';?><i class="down_arrow_light_icon"></i></a>
						<div class="global_nav_action_dropdown">
								<ul class="dropdown_lang_select">
									<?php if(isset($serverList) and !empty($serverList)) {
										foreach ($serverList as $item) { ?>
											<li <?php echo $item->ID_SERVER == $serverID->ID_SERVER ? 'class="active"' : '';?>><a href=<?php echo MainHelper::site_url(RECRUITMENT_NOTICES.'/'.RECRUITMENT_CREATE_NOTICES.'/server/'.$item->ID_SERVER); ?>>
											<?php echo $item->ServerName; ?>
											</a></li>
										<?php } ?>
									<?php } ?>	
								</ul>
							</div>
						</li>
						<input name="server" value="<?php echo $serverID->ID_SERVER; ?>" id="server" type="hidden" name="owner">
						<p>Choose the server they play on</p>
						<br /><br />
						
						<?php $factionID = Recruitment::getFactionByID($faction); ?>
						<li class="global_nav_actions_li_c">
						<a class="global_nav_action global_nav_action_trigger" href="#">
						<?php  echo $faction != '' ? $factionID->FactionName : 'Factions';?><i class="down_arrow_light_icon"></i></a>
						<div class="global_nav_action_dropdown">
								<ul class="dropdown_lang_select">
									<?php if(isset($factionList) and !empty($factionList)) {
										foreach ($factionList as $item) { ?>
											<li <?php echo $item->ID_FACTION == $factionID->ID_FACTION ? 'class="active"' : '';?>><a href=<?php echo MainHelper::site_url(RECRUITMENT_NOTICES.'/'.RECRUITMENT_CREATE_NOTICES.'/faction/'.$item->ID_FACTION); ?>>
											<?php echo $item->FactionName; ?>
											</a></li>
										<?php } ?>
									<?php } ?>	
								</ul>
							</div>
						</li>
						<input name="faction" value="<?php echo $factionID->ID_FACTION; ?>" id="faction" type="hidden" name="owner">
						<p>Choose the faction</p>
						<br /><br />
						
						<?php $roleID = Recruitment::getRoleByID($role); ?>
						<li class="global_nav_actions_li_c">
						<a class="global_nav_action global_nav_action_trigger" href="#">
						<?php  echo $role != '' ? $roleID->RoleName : 'Roles';?><i class="down_arrow_light_icon"></i></a>
						<div class="global_nav_action_dropdown">
								<ul class="dropdown_lang_select">
									<?php if(isset($roleList) and !empty($roleList)) {
										foreach ($roleList as $item) { ?>
											<li <?php echo $item->ID_ROLE == $roleID->ID_ROLE ? 'class="active"' : '';?>><a href=<?php echo MainHelper::site_url(RECRUITMENT_NOTICES.'/'.RECRUITMENT_CREATE_NOTICES.'/role/'.$item->ID_ROLE); ?>>
											<?php echo $item->RoleName; ?>
											</a></li>
										<?php } ?>
									<?php } ?>	
								</ul>
							</div>
						</li>
						<input name="role" value="<?php echo $roleID->ID_ROLE; ?>" id="role" type="hidden" name="owner">
						<p>Choose the ingame role</p>
					</span>
					<br />
					<span id="character" class="step">
						<span class="profile_widget_upgrade">Step 4 - Gameplay Info</span>
						<br /><br />
						<?php $levelID = Recruitment::getLevelByID($level); ?>
						<li class="global_nav_actions_li_c">
						<a class="global_nav_action global_nav_action_trigger" href="#">
						<?php  echo $level != '' ? $levelID->GroupTypeName : 'Levels';?><i class="down_arrow_light_icon"></i></a>
						<div class="global_nav_action_dropdown">
								<ul class="dropdown_lang_select">
									<?php if(isset($levelList) and !empty($levelList)) {
										foreach ($levelList as $item) { ?>
											<li <?php echo $level != '' ? ($item->ID_GROUPTYPE == $levelID->ID_GROUPTYPE ? 'class="active"' : '') : '';?>><a href=<?php echo MainHelper::site_url(RECRUITMENT_NOTICES.'/'.RECRUITMENT_CREATE_NOTICES.'/level/'.$item->ID_GROUPTYPE); ?>>
											<?php echo $item->GroupTypeName; ?>
											</a></li>
										<?php } ?>
									<?php } ?>	
								</ul>
							</div>
						</li>
						<input name="gplvl" value="<?php echo $level != '' ? $levelID->ID_GROUPTYPE : ''; ?>" id="gplvl" type="hidden" name="owner">
						
						<p>Choose the level of play</p>
						<br /><br />
						
						<?php $modeID = Recruitment::getModeByID($mode); ?>
						<li class="global_nav_actions_li_c">
						<a class="global_nav_action global_nav_action_trigger" href="#">
						<?php  echo $mode != '' ? $modeID->GroupTypeName : 'Modes';?><i class="down_arrow_light_icon"></i></a>
						<div class="global_nav_action_dropdown">
								<ul class="dropdown_lang_select">
									<?php if(isset($modeList) and !empty($modeList)) {
										foreach ($modeList as $item) { ?>
											<li <?php echo $mode != '' ? ($item->ID_GROUPTYPE == $modeID->ID_GROUPTYPE ? 'class="active"' : '') : '';?>><a href=<?php echo MainHelper::site_url(RECRUITMENT_NOTICES.'/'.RECRUITMENT_CREATE_NOTICES.'/mode/'.$item->ID_GROUPTYPE); ?>>
											<?php echo $item->GroupTypeName; ?>
											</a></li>
										<?php } ?>
									<?php } ?>	
								</ul>
							</div>
						</li><br />
						<input name="gpmode" value="<?php echo $mode != '' ? $modeID->ID_GROUPTYPE : ''; ?>" id="gpmode" type="hidden" name="owner">
						
						<p>Choose the mode of play</p>
					</span>
					<span id="extra" class="step">	
						<span class="profile_widget_upgrade">Step 5 - Extra Info</span>
						<br /><br />
						<label for="ingamename">Ingame name</label>
						<input name="ingamename" id="ingamename" type="text">							
						<br /><br /><br /><br />
						<label for="details">Extra details</label>
						<textarea name="details" id="details" rows="4" cols="40"></textarea>
					</span>
					
				</div>
				<div id="demoNavigation">
				<br /><br /><br />
				<input id="link_create" name="link_create" type="hidden" value="<?php echo MainHelper::site_url(RECRUITMENT_NOTICES.'/'.RECRUITMENT_CREATE_NOTICES.'/notices/').'create'; ?>">
					<?php //<input class="rounded_5 navigation_button green" id="back" value="Back" type="reset" />  onClick="verify(this);" ?>
					<input class="rounded_5 navigation_button green" id="next" value="Confirm Notice" type="button" onClick="verify(this);" />
					</div>
			</form>
			
		</div>
		</div>
		</div>
