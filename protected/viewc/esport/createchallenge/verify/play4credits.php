<?php
    $challenger = $gamedata['challenger'];
    $opponent = $gamedata['opponent'];
    $game = $gamedata['game'];
    $info = $gamedata['info'];
    $timezone = $gamedata['timezone'];
    $_SESSION['createchallenge']['rankedstatus'] = $info['rankedstatus'];
?>
<form class="create_challenge_form" name="create_challenge_form" onsubmit="alert('dddd');" method="post" action="<?php echo MainHelper::site_url('esport/createchallenge/create'); ?>">
<input type="hidden" value="<?php echo $_SESSION['createchallenge']['betsize'] = $info['betsize']; ?>" name="betsize"/>
<input type="hidden" value="<?php echo $_SESSION['createchallenge']['gameinfo'] = $info['gameinfo']; ?>" name="gameinfo" value="gameinfo"/>
<input type="hidden" value="<?php echo $_SESSION['createchallenge']['date'] = $info['date']; ?>" name="date"/>
<input type="hidden" value="<?php echo $_SESSION['createchallenge']['time'] = $info['time']; ?>" name="time"/>
<input type="hidden" value="<?php echo $_SESSION['createchallenge']['timezone'] = $info['timezone']; ?>" name="timezone"/>
<input type="hidden" value="<?php echo Esport::getPlayModeByName('Play4Credits'); ?>" name="playmode"/>
<input type="hidden" value="<?php echo $_SESSION['createchallenge']['challengerinfo'] = $info['challengerinfo']; ?>" name="challengerinfo"/>
<input type="hidden" value="<?php echo $_SESSION['createchallenge']['opponentinfo'] = $info['opponentinfo']; ?>" name="opponentinfo"/>
<input type="hidden" value="<?php echo $_SESSION['createchallenge']['serverdetails'] = $info['serverdetails']; ?>" name="serverdetails"/>
<div class="esports_right_column challenge">
	<div class="grey_bg_margin">
    	<div class="team own_team">
            <a href="<?php echo MainHelper::site_url('esport/spotlight/'.$challenger->ID_TEAM); ?>">
                <?php echo MainHelper::showImage($challenger, THUMB_LIST_188x188, false, array('width', 'no_img' => 'noimage/no_player_188x188.png'));?>
                <h2><?php echo $challenger->DisplayName; ?></h2>
            </a>
        </div>
        <div class="vs">
        	<h1>Vs</h1>
        </div>
        <?php if(!empty($opponent)): ?>
            <div class="team opponent">
                <a href="<?php echo MainHelper::site_url('esport/spotlight/'.$opponent->ID_TEAM); ?>">
                    <?php echo MainHelper::showImage($opponent, THUMB_LIST_188x188, false, array('width', 'no_img' => 'noimage/no_player_188x188.png'));?>
                    <h2><?php echo $opponent->DisplayName; ?></h2>
                </a>
            </div>
        <?php else: ?>
            <div class="team opponent">
                <img src="<?php echo MainHelper::site_url('global/img/random_188x188.png'); ?>" />
                <h2><?php echo $this->__('Random Team'); ?></h2>
            </div>
        <?php endif; ?>
    </div>
    <div class="darkgrey_bg_margin">
    	<div class="game_info">
        	<div class="esport_profile_boxheaders mt0 mb1"><p><?php echo $this->__('Game'); ?> & <span><?php echo $this->__('Rank'); ?></span></p></div>
            <p><?php echo $game->GameName.' ('.ucfirst($info['rankedstatus']).')'; ?></p>
            <div class="esport_profile_boxheaders mt0 mb1"><p><?php echo $this->__('Server').' '; ?><span><?php echo $this->__('Details'); ?></span></p></div>
            <p><?php echo $info['serverdetails']; ?></p>
            <div class="esport_profile_boxheaders mt0 mb1"><p><?php echo $this->__('Date').' & '; ?><span><?php echo $this->__('Time'); ?></span></p></div>
            <p><?php echo $this->__('Date').': '.$info['date']; ?><br />
                <?php echo $this->__('Time').': '.$info['time']; ?><br />
                <?php echo $this->__('Timezone').': '.$timezone->TimeZoneText.' - '.$timezone->HelpText; ?>
            </p>
            <div class="esport_profile_boxheaders mt0 mb1"><p><?php echo $this->__('Credit').' & '; ?><span><?php echo $this->__('Amount'); ?></span></p></div>
            <p><?php echo $info['betsize'].' Credits'; ?><br />
                <?php echo $this->__('Entry Fee').': '.$info['betsize'].' credits '; ?>
            <div class="pr di p4c_infobox">
                <span class="pr">(<?php echo $this->__('What is this?'); ?>)</span>
                <div style="display:none; background-color:white; bottom:20px;" class="infobox pa">Her skal vi så bare lige finde ud af hvad der skal stå</div>
            </div>
            </p>
        </div>
        <div class="game_image">
                <?php echo MainHelper::showImage($game, THUMB_LIST_220x220, false, array('width', 'no_img' => 'noimage/no_game_220x220.png'));?>
                <h2><?php echo $game->GameName; ?></h2>
        </div>
    </div>
    <div class="grey_bg_margin save_info centered">
    	<input type="submit" value="<?php echo $this->__('Confirm'); ?>" class="button button_small grey pull_left btn_red_gradient_bg save_button" />
        <input type="button" value="<?php echo $this->__('Go back'); ?>" class="button button_small grey pull_left btn_grey_gradient_bg discard_button" onclick="window.location = site_url+'esport/createchallenge/play4credits'" />
    </div>
</div>
</form>