<?php $isEnabledNews = MainHelper::IsModuleEnabledByTag('news'); ?>
<?php $isEnabledEvents = MainHelper::IsModuleEnabledByTag('events'); ?>
<?php $isEnabledGames = MainHelper::IsModuleEnabledByTag('Games'); ?>
<?php $isEnabledRegUser = MainHelper::IsModuleEnabledByTag('reguser'); ?>
<?php $reguserFunctions = MainHelper::GetModuleFunctionsByTag('reguser'); ?>
<?php $isEnabledContentparent = MainHelper::IsModuleEnabledByTag('contentparent'); ?>
<?php $contentchildFields = MainHelper::GetModuleFieldsByTag('contentchild'); ?> 
<?php $contentchildFunctions = MainHelper::GetModuleFunctionsByTag('contentchild'); ?>
<?php if (MainHelper::IsModuleNotAvailableByTag('news')==1) $isEnabledNews = 0; ?>
<?php if (MainHelper::IsModuleNotAvailableByTag('events')==1) $isEnabledEvents = 0; ?>
<?php if (MainHelper::IsModuleNotAvailableByTag('Games')==1) $isEnabledEvents = 0; ?>
<?php if (MainHelper::IsModuleNotAvailableByTag('reguser')==1) $isEnabledRegUser = 0; ?>
<?php if (MainHelper::IsModuleNotAvailableByTag('contentchild')==1) $isEnabledContentchild = 0; ?>
<?php if (MainHelper::IsModuleNotAvailableByTag('contentparent')==1) $isEnabledContentparent = 0; ?>

<?php
	$userPlayer = User::getUser();
	$isApproved = ($userPlayer) ? MainHelper::IsPlayerApproved($userPlayer->ID_PLAYER) : 1;

	$suspendLevel = ($userPlayer) ? $userPlayer->getSuspendLevel() : 0;
	$noProfileFunctionality = MainHelper::GetNoProfileFunctionality($suspendLevel);
	$noSiteFunctionality = MainHelper::GetNoSiteFunctionality($suspendLevel);
?>


<?php include('common/top.php'); ?>
<?php $p = User::getUser(); 
$suspendLevel = ($p) ? $p->getSuspendLevel() : 0;
$noProfileFunctionality = MainHelper::GetNoProfileFunctionality($suspendLevel);
$noSiteFunctionality = MainHelper::GetNoSiteFunctionality($suspendLevel);
$games = new Games();
$reviewCount = $game->getRatingsCount(); 
$playersCount = $games->getTotalPlayers($game);
?>


<div class="global_info_page clearfix">

<div id="headerCoverInfo">
    <div id="coverImg">&nbsp;</div>
    <div id="headerInfo"><h1>Information</h1></div>
</div>
    
<div id="global_info_page_background">

	<div class="global_info_block">
		<h1><?php echo $game->GameName; ?></h1>

		<?php $desc = ContentHelper::handleContentOutput($game->GameDesc); ?>
		<?php if ($desc != ''): ?>
                    <div class="pr20"><?php echo $desc; ?></div>
		<?php else: ?>
			<div class="noItemsText"><?php echo $this->__('There is no description at the moment.'); ?></div>
		<?php endif; ?>

		<?php if ($p and $p->canAccess('Edit game information')): ?>
        <div class="mt10">
            <?php if(Auth::isUserLogged()):
                if($p->isDeveloper() || $p->isSuperUser || $p->isTranslator()) : ?>
                    <a href="javascript:void(0);" class="fs11 action_translate di mr25" data-selec="game" rel="<?php echo $game->ID_GAME; ?>"><?php echo $this->__('Translate'); ?></a>
                <?php endif;
                if($p->canAccess('Edit game information')): ?>
                        <a class="fs11 sprite game_edit" href="<?php echo $game->GAME_URL . '/admin/editgameinfo'; ?>"><?php echo $this->__('Edit game info'); ?></a>
                <?php endif;
            endif; ?>
        </div>
		<?php endif; ?>
	</div>

	<div class="infoBox">        
	      	<div class="table_information">
        
                        <div class="title"><h2><?php echo $this->__('Information'); ?></h2></div>
                        <div class="hr">&nbsp;</div>
                        
                            <?php if ($isEnabledNews == 1): ?>
                        <div class="informationSubject">
                        <div class="leftIcon"><i class="stat_news_icon"><img src="../global/img/iconNews.png"/></i></div>
                        <div class="centerName"><p><?php echo ucfirst($this->__('News'));?></p></div>
                        <div class="rightValue"><p><?php echo $game->NewsCount; ?></p></div>
                        <div class="hr"></div>  
                        </div>
                            <?php endif;?>
				
                			<?php if ($isEnabledRegUser == 1 && $playersCount>0): ?>
                        <div class="informationSubject">
                        <div class="leftIcon"><i class="stat_group_icon"><img src="../global/img/iconGamePlayers.png"/></i></div>
                                        <div class="centerName"><p><?php echo ucfirst($this->__('Players'));?></p></div>
                                        <div class="rightValue"><p><?php echo $playersCount; ?></p></div>
                        <div class="hr"></div>
                        </div>
                            <?php endif;?>
				
                            <?php if ($isEnabledEvents == 1): ?>
                        <div class="informationSubject">
                                <div class="leftIcon"><i class="stat_event_icon"><img src="../global/img/iconEvents.png"/></i></div>
                                <div class="centerName"><p><?php echo ucfirst($this->__('Events'));?></p></div>
                                <div class="rightValue"><p><?php echo $game->EventCount; ?></p></div>
						<div class="hr"></div>
                        </div>
                            <?php endif;?>
        <br/>
        
         <!-- GAME info start -->    
        <div class="table_gameInfo">
        
                <span class="companyInfo">
                    <div class="title"><h3><?php echo $this->__('Game Info');?>:</h3></div>
                </span>
                    <div class="hr"></div>
                    
                <?php if ($contentchildFields['Type']['isEnabled']==1 && !empty($game->GameType)): ?>
                <div class="user_informations">
                    <span class="user_name"><?php echo $this->__('Type');?>:</span>
                    <span class="user_value"><?php echo $game->GameType;?></span>
                </div>
                    <div class="hr"></div>
				<?php endif; ?>
            
                <?php if ($contentchildFields['CreationDate']['isEnabled']==1 && !empty($game->CreationDate)): ?>
                <?php $creationDate = $game->CreationDate;
                    if ($creationDate != '0000-00-00'):?>
                    <div class="user_informations">
                        <span class="user_name"><?php echo $this->__('Released');?>:</span>
                        <span class="user_value"><?php echo date(DATE_SHORT, strtotime($creationDate));?></span>
                    </div>
                    <div class="hr"></div>
                <?php endif; ?>
                <?php endif; ?>
            
                <?php if ($contentchildFields['Platform']['isEnabled']==1 && !empty($platformNames)): ?>
                    <div class="user_informations">
                        <span class="user_name"><?php echo $this->__('Platforms');?>:</span>
                        <span class="user_value"><?php echo !empty($platformNames) ? implode(", ", $platformNames) : '-';?></span>
                    </div>
                    <div class="hr">&nbsp;</div>
                <?php endif; ?>
               
               <?php if (!empty($game->PlayersCount) && $isEnabledRegUser==1): ?>
            <div class="user_informations">
                <span class="user_name"><?php echo $this->__('Players');?>:</span>
                <span class="user_value"><?php echo $game->PlayersCount != '' ? $game->PlayersCount : '-';?></span>
            </div>
            <div class="hr">&nbsp;</div>
            <?php endif; ?>
        
            <?php if ($contentchildFields['ESRBrating']['isEnabled']==1 && !empty($game->ESRB )): ?>
            <div class="user_informations">
                <span class="user_name"><?php echo $this->__('ESRB Rating');?>:</span>
                <span class="user_value"><?php echo $game->ESRB != '' ? $game->ESRB : '-';?></span>
            </div>
            <div class="hr">&nbsp;</div>
            <?php endif; ?>
        
            <?php if ($isEnabledContentparent == 1): ?>
                <?php if (!empty($developers)): ?>
                <div class="user_informations">
                    <span class="user_name"><?php echo $this->__('Developers');?>:</span>
                    <span class="user_value"><?php echo $developers;?></span>
                </div>
                <div class="hr">&nbsp;</div>
                <?php endif; ?>
        
                <?php if (!empty($distributors)): ?>
                <div class="user_informations">
                    <span class="user_name"><?php echo $this->__('Distributors');?>:</span>
                    <span class="user_value"><?php echo $distributors;?></span>
                </div>
                <div class="hr">&nbsp;</div>
                <?php endif; ?>
            <?php endif; ?>
            
                <?php if (!empty($game->CreatedTime)): ?>
            <div class="user_informations">
                <span class="user_name"><?php echo $this->__('Joined');?>:</span>
                <span class="user_value"><?php echo date(DATE_SHORT, $game->CreatedTime);?></span>
            </div>
            <div class="hr">&nbsp;</div>
            <?php endif; ?>
        
            <?php if ($contentchildFields['URL']['isEnabled']==1 && !empty($game->URL)): ?>
            <div class="user_informations">
                <span class="user_name"><?php echo $this->__('Website');?>:</span>
                <span class="user_value">
                    <a target="_blank" href="<?php echo $game->URL;?>"><?php echo $game->URL;?></a>
                </span>
            </div>
            <?php endif; ?>
        
        </div>                
</div>

<br/>
		<?php if ($game->isFreePlay == 1 && $contentchildFunctions['contentchildFreeToPlay']==1 && !$noSiteFunctionality): ?>
			<div class="play_ftp_now">
				<?php echo $this->__('You can play this game [_1]for free[_2] right here on PlayNation.', array('<strong>', '</strong>')); ?>
				<a href="<?php echo $gameUrl; ?>/play" class="button button_fluid light_blue"><?php echo $this->__('Play now'); ?></a>
			</div>
		<?php endif; ?>
	</div>
 </div>   
    
</div>
    
    <?php /* DELETE ASAP
      if ($isEnabledEvents == 1): ?>
        <?php
        echo $this->renderBlock('events/event_list', array('search' => $search, 'type' => GAME, 'total' => $total, 'url' => $url, 'events' => $events, 'pager' => $pager, 'pagerObj' => $pagerObj, 'hideTop' => true));
        ?>
    <?php endif; */ ?>
    

