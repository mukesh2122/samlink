<?php 
$isEnabledNews = MainHelper::IsModuleEnabledByTag('news');
$isEnabledEvents = MainHelper::IsModuleEnabledByTag('events');
$groupFunctions = MainHelper::GetModuleFunctionsByTag('groups');
if(MainHelper::IsModuleNotAvailableByTag('news') == 1) $isEnabledNews = 0;
if(MainHelper::IsModuleNotAvailableByTag('events') == 1) $isEnabledEvents = 0;
$userPlayer = User::getUser();
$isApproved = ($userPlayer) ? MainHelper::IsPlayerApproved($userPlayer->ID_PLAYER) : 1;
$suspendLevel = ($userPlayer) ? $userPlayer->getSuspendLevel() : 0;
$noProfileFunctionality = MainHelper::GetNoProfileFunctionality($suspendLevel);
$noSiteFunctionality = MainHelper::GetNoSiteFunctionality($suspendLevel);
include('common/top.php');
$isAdmin = $group->isAdmin();
$isMember = $group->isMember();
$desc = ContentHelper::handleContentOutput($this->__($group->GroupDesc));
$leader = $group->getLeader();
if($leader) {
    $leaderNick = PlayerHelper::showName($leader);
}
?>

<div class="global_info_page clearfix">

<div id="headerCoverInfo">
    <div id="coverImg">&nbsp;</div>
    <div id="headerInfo"><h1>Information</h1></div>
</div>

<div class="global_info_page_background">
	<div class="global_info_block">
		<h1><?php echo $group->GroupName; ?></h1>
		<?php if($desc != ''): ?>
			<div class="pr20"><?php echo $desc; ?></div>
		<?php else: ?>
			<div class="noItemsText"><?php echo $this->__('There is no description at the moment.'); ?></div>
		<?php endif; ?>
        <div class="mt10">
            <?php if(Auth::isUserLogged()):
                if($userPlayer->isDeveloper() || $userPlayer->isSuperUser || $userPlayer->isTranslator()) : ?>
                    <a href="javascript:void(0);" class="fs11 action_translate di mr25" data-selec="group" rel="<?php echo $group->ID_GROUP; ?>"><?php echo $this->__('Translate'); ?></a>
                <?php endif;
            endif;
            if($isAdmin): // apparently rel="iframe"  makes it an ajax call?>
                <a class="fs11 sprite company_edit" href="<?php echo $group->GROUP_URL.'/admin/editgroupinfo'; ?>"><?php echo $this->__('Edit group info'); ?></a>
            <?php endif; ?>
        </div>
	</div>

    <div class="infoBox">        
        <div class="table_information">

            <div class="title"><h2><?php echo $this->__('Information'); ?></h2></div>
            <div class="hr">&nbsp;</div>

                <?php if ($isEnabledNews == 1): ?>
            <div class="informationSubject">
                <div class="leftIcon"><i class="stat_news_icon"><img src="../global/img/iconNews.png"/></i></div>
                <div class="centerName"><p><?php echo ucfirst($this->__('News'));?></p></div>
                <div class="rightValue"><p><?php echo $group->NewsCount; ?></p></div>
                <div class="hr"></div>  
            </div>
                <?php endif;?>

            <div class="informationSubject">
                <div class="leftIcon"><i class="stat_group_icon"><img src="../global/img/iconGamePlayers.png"/></i></div>
                <div class="centerName"><p><?php echo ucfirst($this->__('Members'));?></p></div>
                <div class="rightValue"><p><?php echo $group->MemberCount; ?></p></div>
                <div class="hr"></div>
            </div>

                <?php if ($isEnabledEvents == 1): ?>
            <div class="informationSubject">
                <div class="leftIcon"><i class="stat_event_icon"><img src="../global/img/iconEvents.png"/></i></div>
                <div class="centerName"><p><?php echo ucfirst($this->__('Events'));?></p></div>
                <div class="rightValue"><p><?php echo $group->EventCount; ?></p></div>
                <div class="hr"></div>
            </div>
                <?php endif;?>
            <br/>

            <!-- GROUP info start -->    
            <div class="table_gameInfo">

                <span class="companyInfo">
                    <div class="title"><h3><?php echo $this->__('Group Info');?>:</h3></div>
                </span>
                <div class="hr"></div>

                <?php if (!empty($leader->URL)): ?>
                <div class="user_informations">
                    <span class="user_name"><?php echo $this->__('Leader');?>:</span>
                    <span class="user_value"><?php echo '<a href="'.MainHelper::site_url('player/'.$leader->URL).'">'.$leaderNick.'</a>'; ?></span>
                </div>
                <div class="hr"></div>
                <?php endif; ?>

                <?php if (!empty($group->GameName)): ?>
                    <?php
                    $game = new Games;
                    $game = $game->getGameByID($group->ID_GAME);
                    $gameUrl = $game->GAME_URL;
                    ?>
                <div class="user_informations">
                    <span class="user_name"><?php echo $this->__('Game');?>:</span>
                    <span class="user_value"><a href="<?php echo $gameUrl?>"><?php echo $group->GameName?></a></span>
                </div>
                <div class="hr"></div>
                <?php endif; ?>

                <?php if (!empty($group->GroupType1)): ?>
                <div class="user_informations">
                    <span class="user_name"><?php echo $this->__('Type 1');?>:</span>
                    <span class="user_value"><?php echo $group->GroupType1;?></span>
                </div>
                <div class="hr"></div>
                <?php endif; ?>

                <?php if (!empty($group->GroupType2)): ?>
                <div class="user_informations">
                    <span class="user_name"><?php echo $this->__('Type 2');?>:</span>
                    <span class="user_value"><?php echo $group->GroupType2;?></span>
                </div>
                <div class="hr"></div>
                <?php endif; ?>

                <?php if (!empty($group->CreatedTime)): ?>
                <div class="user_informations">
                    <span class="user_name"><?php echo $this->__('Created');?>:</span>
                    <span class="user_value"><?php echo date(DATE_SHORT, $group->CreatedTime)?></span>
                </div>
                <?php endif; ?>

             </div> <!-- table_gameInfo -->
        </div> <!-- table_information -->
    </div> <!-- infoBox -->
</div> <!-- global_info_page_background -->

<div class="mt40">
	<div class="clearfix">
		<?php if(!empty($alliances)): ?>
			<div class="fs15 fft mt10 mb5 fl"><?php echo $this->__('Affiliated groups'); ?></div>
		<?php endif;
		if($isAdmin === TRUE): ?>
			<a class="add_download fft fs12 db fr mt10 sprite" rel="iframe" href="<?php echo $group->GROUP_URL.'/admin/addalliance';?>"><?php echo $this->__('Add Affiliate');?></a>
		<?php endif; ?>
	</div>
	<?php if(!empty($alliances)): ?>
	    <div class="clear">&nbsp;</div>
		<?php foreach($alliances as $key=>$item) { echo $this->renderBlock('common/group', array('item' => $item, 'parent' => $group, 'owner' => false, 'affiliates' => true, 'isAdmin' => $isAdmin)); };
	endif; ?>
</div>
</div> <!-- global_info_page clearfix -->