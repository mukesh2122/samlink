<?php
    $challenger = $matchinfo['challenger'];
    $opponent = $matchinfo['opponent'];
    $game = $matchinfo['game'];
    $match = $matchinfo['match'];
?>
<form method="post" action="<?php echo MainHelper::site_url('esport/challenge/submitscores/submit'); ?>"> 
<input type="hidden" name="matchinfo" value="<?php echo $match->ID_MATCH; ?>" />
<div class="esports_right_column challenge">
	<div class="grey_bg_margin">
    	<div class="team own_team">
                <?php echo MainHelper::showImage($challenger, THUMB_LIST_188x188, false, array('both', 'no_img' => 'noimage/no_player_188x188.png'));?>
                <h2><?php echo $challenger->DisplayName; ?></h2>
        </div>
        <div class="vs">
        	<h1>Vs</h1>
        </div>
        <div class="team opponent">
                <?php echo MainHelper::showImage($opponent, THUMB_LIST_188x188, false, array('both', 'no_img' => 'noimage/no_player_188x188.png'));?>
                <h2><?php echo $opponent->DisplayName; ?></h2>
        </div>
    </div>
    <div class="submit_scores darkgrey_bg_margin clearboth">
    	<div class="clearboth mb20 section">
            <div class="news esport_profile_boxheaders live_streams mt0">
                <p><?php echo strtoupper($this->__('Game')).' '; ?><span><?php echo strtoupper($this->__('Details')); ?></span></p>
            </div>
            <div class="game_details">
            	<?php echo MainHelper::showImage($game, THUMB_LIST_70x70, false, array('both', 'no_img' => 'noimage/no_game_70x70.png'));?>
                <p><?php echo strtoupper($this->__('Game').': '); ?><span><?php echo $game->GameName; ?></span>
                <br/><?php echo strtoupper($this->__('Rank').': '); ?><span><?php echo ucfirst($match->RankedStatus); ?></span>
                <br/><?php echo strtoupper($this->__('Type').': '); ?><span><?php echo strtoupper(Esport::getPlayMode($match->PlayMode)); ?></span></p>
            </div>
        </div>
        <div class="clearboth mb20 section">
            <div class="news esport_profile_boxheaders live_streams mt0">
                <p><?php echo strtoupper($this->__('Match')).' '; ?><span><?php echo strtoupper($this->__('Score')); ?></span></p>
            </div>
            <input type="text" id="infobox" name="matchscore" value="" class="text_input w290" />
        </div>
        <div class="clearboth mb20 section">
            <div class="news esport_profile_boxheaders live_streams mt0">
                <p><?php echo strtoupper($this->__('Upload')).' '; ?><span><?php echo strtoupper($this->__('Screenshot')); ?></span></p>
            </div>
            <div class="profile_foto_edit mt5 dib pull_left">
                <input type="hidden" id="imageName" name="challenge_img_upload" value="" />
                <div class="standard_form_photo mt2">
                        <div class="standard_form_photo_wrapper mr50">
                                <?php echo MainHelper::showImage($match, THUMB_LIST_100x100, false, array('width', 'no_img' => 'noimage/no_game_100x100.png'));?>
                        </div>
                        <div class="standard_form_photo_action ml0">
                                <a id="challenge_img_upload" class="button button_medium btn_red_gradient_bg" href="javascript:void(0);"><?php echo $this->__('Upload Photo'); ?></a>
                                <p><?php echo $this->__('Use PNG, GIF or JPG.'); ?>
                        </div>
                </div>
            </div>
        </div>
    </div>
    <div class="grey_bg_margin plaingrey_bg save_info centered">
    	<input type="submit" class="button button_small grey pull_left btn_red_gradient_bg save_button" value="<?php echo $this->__('Submit scores'); ?>" />
        <input type="button" class="button button_small grey pull_left btn_grey_gradient_bg discard_button" value="<?php echo $this->__('Go back'); ?>" />
    </div>
</div>
</form>