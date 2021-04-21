<?php
    $amounts = array(10,15,20,25,50,75,100,200);
    $team = $profile['team'];
    $opponent = isset($_SESSION['createchallenge']['opponentinfo']) ? Esport::getTeamByID($_SESSION['createchallenge']['opponentinfo']) : $profile['opponent'];
    $betsize = isset($_SESSION['createchallenge']['betsize']) ? $_SESSION['createchallenge']['betsize'] : 10;
    $date = isset($_SESSION['createchallenge']['date']) ? $_SESSION['createchallenge']['date'] : '';
    $time = isset($_SESSION['createchallenge']['time']) ? $_SESSION['createchallenge']['time'] : date('H:i');
    $timezoneid = isset($_SESSION['createchallenge']['timezone']) ? $_SESSION['createchallenge']['timezone'] : 0;
    $gameinfo = isset($_SESSION['createchallenge']['gameinfo']) ? $_SESSION['createchallenge']['gameinfo'] : '';
    $challengerinfo = isset($_SESSION['createchallenge']['challengerinfo']) ? $_SESSION['createchallenge']['challengerinfo'] : $profile['id'];
    $opponentinfo = isset($_SESSION['createchallenge']['opponentinfo']) ? $_SESSION['createchallenge']['opponentinfo'] : 0;
    $serverdetails = isset($_SESSION['createchallenge']['serverdetails']) ? $_SESSION['createchallenge']['serverdetails'] : '' ;
    $rankedstatus = isset($_SESSION['createchallenge']['rankedstatus']) ? $_SESSION['createchallenge']['rankedstatus'] : 'unranked' ;
?>
<form class="create_p4c_form" method="post" action="<?php echo MainHelper::site_url('esport/createchallenge/play4credits/verify'); ?>">
<input type="hidden" value ="<?php echo $betsize; ?>" class="betsize" name="betsize" />
<input type="hidden" value="<?php echo $gameinfo; ?>" class="gameinfo" name="gameinfo"/>
<input type="hidden" value="<?php echo Esport::getPlayModeByName('Play4Credits'); ?>" name="playmode"/>
<input type="hidden" class="challengerinfo" value="<?php echo $challengerinfo; ?>" name="challengerinfo"/>
<input type="hidden" class="opponentinfo" value="<?php echo !empty($opponent) ? $opponent->ID_TEAM : $opponentinfo; ?>" name="opponentinfo"/>
<div class="esports_right_column">
	<div class="overview red_gradient_bg">
            <h2><?php echo strtoupper($this->__('Create challenge')); ?></h2>
    </div>
     <div class="darkgrey_bg_margin">
    	<p><?php echo $this->__('You are about to create a PLAY4CREDITS Challenge. This will cost your team credits and depending on your choices below, your team will compete in a ranked or unranked challenge against another team.'); ?></p>
    </div>
    <div class="darkgrey_bg_margin">
        <div class="esport_profile_boxheaders mt0 mb1">
            <p>
            <?php echo $this->__('Credit').' ' ?><span><?php echo $this->__('amount'); ?></span>
            <span class="available_credits">(
                <span id="available_amount"><?php echo $team->Credits ?> </span>
                <?php echo ' credits '.$this->__('available').' '; ?>
                <a target="_blank" href="<?php echo MainHelper::site_url('shop/buy-credits'); ?>">
                    <?php echo $this->__('Add').' '; ?></a><?php echo $this->__('more'); ?>)
            </span>
            </p>
        </div>
        <p class="color_white"><?php echo $this->__('Fixed credit amount'); ?></p>
        <div class="fixed_credit_amount cp">
        <?php foreach($amounts as $amount): ?>
            <div class="amount <?php echo $amount == $betsize ? 'selected' : ''; ?>">
            	<h1><?php echo $amount; ?></h1>
                <p><?php echo $this->__('Credits'); ?></p>
            </div>
        <?php endforeach; ?>
        </div>
        <p class="color_white"><?php echo $this->__('Custom credit amount'); ?></p>
        <div class="w200 h15 pull_left" id="slider"></div>
        <div class="fixed_credit_amount custom_credit_amount">
            <div class="amount">
            	<h1 id="amount"></h1>
                <p>Credits</p>
            </div>
        </div>
    </div>
    <div class="darkgrey_bg_margin">
    	<div class="esport_profile_boxheaders mt0 mb1"><p><?php echo $this->__('Choose').' '; ?><span><?php echo $this->__('Game'); ?></span></p></div>
        	<div class="visual_list games cp">
                <?php if(!empty($profile['gamelist'])): ?>    
                <?php foreach($profile['gamelist'] as $game): ?>
                    <div class="visual_item game <?php echo $gameinfo == $game->ID_GAME ? "selected" : ''; ?>" rel="<?php echo $game->ID_GAME; ?>">
                        <?php echo MainHelper::showImage($game, THUMB_LIST_95x95, false, array('width', 'no_img' => 'noimage/no_game_95x95.png'));?>
                        <p><?php echo $game->GameName; ?></p>
                    </div>
                <?php endforeach; ?>
                <?php else: ?>
                    <div class="error_message">
                        <h1 class="m20"><?php echo $this->__('No games in common'); ?></h1>
                    </div>
                <?php endif; ?>
            </div>
        </div>
        <div class="darkgrey_bg_margin">
            <div class="esport_profile_boxheaders mt0 mb1"><p><?php echo $this->__('Ranked').' or '; ?><span><?php echo $this->__('Unranked'); ?></span></p></div>
            <select id="rolebox" value="" name="rankedstatus" class="text_input w290 pull_left create_challenge_input">
                <option <?php echo $rankedstatus == 'unranked' ? "selected='selected'" : ''; ?> value="unranked"><?php echo $this->__('Unranked'); ?></option>
                <option <?php echo $rankedstatus == 'ranked' ? "selected='selected'" : ''; ?> value="ranked"><?php echo $this->__('Ranked'); ?></option>
            </select>
        </div> 
        <div class="darkgrey_bg_margin">
            <div class="esport_profile_boxheaders mt0 mb1"><p><?php echo $this->__('Choose').' '; ?><span><?php echo $this->__('Team'); ?></span></p></div>
            <?php if(!empty($opponent)): ?>
                <div class="visual_list cp" id="player_list">
                    <div class="visual_item player selected" rel="<?php echo $opponent->ID_TEAM; ?>"> 
                        <?php echo MainHelper::showImage($opponent, THUMB_LIST_95x95, false, array('width', 'no_img' => 'noimage/no_game_95x95.png'));?>
                        <p><?php echo $opponent->DisplayName; ?></p>
                    </div>
                </div>
            <?php else: ?>
                <div class="teamsearch_container pr dib">
                    <img class="" style="display:none; position: absolute; right: 100px; height: 20px; top: 20px;" src="<?php echo MainHelper::site_url('global/img/ajax-loader-small.gif');?>" />
                    <input type="text" id="commentbox role_box" value="Search team..." class="text_input w290 pull_left boxsweep create_challenge_input">
                    <a class="button button_small grey pull_left mt2 btn_red_gradient_bg create_challenge_input search_button" id="role_box"><?php echo $this->__('Search'); ?></a>
                </div>
                <div class="visual_list cp" id="player_list">
                    <div class="visual_item player selected" rel="0"> 
                        <img src="<?php echo MainHelper::site_url('global/img/random_100x100.png'); ?>" />
                        <p><?php echo $this->__('Random Team'); ?></p>
                    </div>
                </div>
            <?php endif; ?>
        </div>
        <div class="darkgrey_bg_margin server_details">
            <div class="esport_profile_boxheaders mt0 mb1"><p><?php echo strtoupper($this->__('Server')).' '; ?><span><?php echo strtoupper($this->__('Details')); ?></span></p></div>
        	<textarea type="text" id="infobox" name="serverdetails" class="text_input w290 pull_left"><?php echo $serverdetails; ?></textarea>
            <p><?php echo $this->__('INFO:  It is your responsibility to let the other team know where you are playing. The info will ONLY be sent to the team you are playing against.'); ?></p>
        </div>
        <div class="darkgrey_bg_margin date_and_time esport">
            <div class="esport_profile_boxheaders mt0 mb1"><p><?php echo strtoupper($this->__('Date')).' '; ?><span>& <?php echo strtoupper($this->__('Time')); ?></span></p></div>
            <div class="team_info">
                <div class=" information_section">
                    <input type="text" value="<?php echo $date; ?>" id="datepicker" name="date" class="text_input pull_right infobox" /> 
                    <p><?php echo $this->__('Date'); ?></p>
                </div>
                <div class="information_section">
                    <input type="text" value="<?php echo $time; ?>" name="time" value="<?php echo date('H:i'); ?>" class="text_input pull_right infobox" /> 
                    <p><?php echo $this->__('Time'); ?></p>
                </div>
                <div class="information_section">
                    <select id="rolebox" name="timezone" value="Timezone" class="text_input w290 pull_right"> 
                      <?php foreach(MainHelper::getTimeZoneList() as $timezone): ?>
                          <option <?php echo $timezoneid == $timezone->ID_TIMEZONE ? "selected='selected'" : ''; ?> value="<?php echo $timezone->ID_TIMEZONE; ?>"><?php echo $timezone->TimeZoneText.' - '.$timezone->HelpText; ?></option>
                      <?php endforeach; ?>
                    </select> 
                    <p><?php echo $this->__('Timezone'); ?></p>
                </div>
            </div>
        </div>
        <div class="darkgrey_bg_margin save_info">
            <input type="submit" class="button button_small grey pull_left btn_red_gradient_bg save_button" value="<?php echo $this->__('Create challenge'); ?>" />
            <input type="button" class="button button_small grey pull_left btn_grey_gradient_bg discard_button" onclick="window.location = site_url+'esport/spotlight/challenges';" value="<?php echo $this->__('Cancel'); ?>"/>
        </div>
</div>
</form>