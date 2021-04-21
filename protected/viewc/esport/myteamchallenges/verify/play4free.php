<?php
    $challenger = $gamedata['challenger'];
    $opponent = $gamedata['opponent'];
    $game = $gamedata['game'];
    $info = $gamedata['info'];
    //$timezone = $gamedata['timezone'];
?>
<form class="create_challenge_form" method="post" action="<?php echo MainHelper::site_url('esport/createchallenge/create'); ?>">
<input type="hidden" value="<?php echo $info->ID_MATCH; ?>" name="gameinfo"/>

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
            <p><?php echo $game->GameName.' ('.ucfirst($info->RankedStatus).')'; ?></p>
            <div class="esport_profile_boxheaders mt0 mb1"><p><?php echo $this->__('Server').' '; ?><span><?php echo $this->__('Details'); ?></span></p></div>
            <p><?php echo $info->ServerDetails; ?></p>
            <div class="esport_profile_boxheaders mt0 mb1"><p><?php echo $this->__('Date').' & '; ?><span><?php echo $this->__('Time'); ?></span></p></div>
            <p><?php echo $this->__('Date').': '.Date('d-m-Y',$info->StartTime); ?><br />
                <?php echo $this->__('Time').': '.Date('H:i', $info->StartTime); ?><br />
            </p>
        </div>
        <div class="game_image">
            <a href="#go_to_team_page">
                <?php echo MainHelper::showImage($game, THUMB_LIST_220x220, false, array('both', 'no_img' => 'noimage/no_game_220x220.png'));?>
                <h2><?php echo $game->GameName; ?></h2>
            </a>
        </div>
    </div>
    <div class="grey_bg_margin save_info centered">
        <input type="button" value="<?php echo $this->__('Accept'); ?>" class="button button_small grey pull_left btn_red_gradient_bg save_button" onclick="window.location = site_url+'esport/ajaxacceptchallenge/<?php echo $info->ID_MATCH; ?>'" />
        <input type="button" value="<?php echo $this->__('Decline'); ?>" class="button button_small grey pull_left btn_grey_gradient_bg discard_button" onclick="window.location = site_url+'esport/ajaxcreatechallenge/<?php echo $info->ID_MATCH; ?>'" />
        <input type="button" value="<?php echo $this->__('Go back'); ?>" class="button button_small grey pull_left btn_grey_gradient_bg discard_button" onclick="window.location = site_url+'esport/myteam/challenges'" />
    </div>
</div>
</form>