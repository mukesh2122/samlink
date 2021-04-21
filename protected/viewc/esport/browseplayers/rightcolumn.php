<?php
    $byAlphabet = $profile['byAlphabet'];
    $byTeam = '';
    $byGame = $profile['byGame'];
    $alphabet = array('0-9','a','b','c','d','e','f','g','h','i','j','k','l','m','n','o','p','q','r','s','t','u','v','w','x','y','z');
?>
<div class="esports_right_column team_center">
	<!-- START BROWSE PLAYERS -->
	<div class="overview red_gradient_bg">
            <h2><?php echo strtoupper('Browse players'); ?><span class="header_small_font"><?php echo $this->__('By alphabet').' '; ?>(
                    <?php foreach($alphabet as $letter): ?>
                        <a href="<?php echo MainHelper::site_url('esport/browseplayers/'.$letter); ?>"><?php echo strtoupper($letter); ?></a>
                    <?php endforeach; ?>
            )</span></h2>
    </div>
    <div class="grey_bg_margin">
    	<div class="search_for_player">
            <div class="news esport_profile_boxheaders live_streams mt0">
                <p><?php echo strtoupper($this->__('Search')).' '; ?><span><?php echo strtoupper($this->__('Player')); ?></span></p>
            </div>
            <input type="text" id="commentbox" value="" class="text_input w290 pull_left" />
            <input type="button" class="button button_small grey pull_right mt2 btn_red_gradient_bg" id="sendChatButton" value="Search" />
    	</div>
        <div class="game_filter">
            <div class="news esport_profile_boxheaders live_streams mt0">
                <p><?php echo strtoupper($this->__('Game')).' '; ?><span><?php echo strtoupper($this->__('Filter')); ?></span></p>
            </div>
            <select id="" class="w290 pull_left" name="gamelist">
                <option value="all"><?php echo $this->__('Choose a game'); ?></option>
                <?php foreach ($profile['games'] as $game): ?>
                        <option <?php echo $byGame == $game->ID_GAME ? "selected='selected'" : ""; ?> value="<?php echo $game->ID_GAME; ?>">
                                <?php echo $game->GameName; ?>
                        </option>
                <?php endforeach; ?>
            </select>
    	</div>
    </div>
  	<!-- LIST WITH SEARCHED PLAYERS -->
	<div class="browsed_teams_list">
		<div class="headers">
            <div class="red_gradient_bg overview_header teams">
                <h4><?php echo ucfirst($this->__('Player')); ?></h4>
            </div>
            <div class="red_gradient_bg overview_header games">
                <h4><?php echo ucfirst($this->__('Games')); ?></h4>
            </div>
            <div class="red_gradient_bg overview_header wins">
                <h4><?php echo ucfirst($this->__('Wins')); ?></h4>
            </div>
            <div class="red_gradient_bg overview_header rank">
                <h4><?php echo ucfirst($this->__('Rank')); ?></h4>
            </div>
        </div>
        <div class="browsed_list">
            <?php if(!empty($profile['teams'])): ?>
            <?php foreach($profile['teams'] as $team): ?>
            <?php $esport = new Esport(); ?>
            <?php $team->getLeagueData(); ?>
            <?php $games = $esport->getGamesByTeam($team->ID_TEAM); ?>
            <div class="result_single_team">
                <div class="browse_content teams">
                    <a href="<?php echo MainHelper::site_url('esport/spotlight/'.$team->ID_TEAM); ?>"><?php echo MainHelper::showImage($team, THUMB_LIST_60x60, false, array('width', 'no_img' => 'noimage/no_player_60x60.png'));?></a>
                    <h2><a href="<?php echo MainHelper::site_url('esport/spotlight/'.$team->ID_TEAM); ?>"><?php echo $team->DisplayName ?></a></h2>
                </div>
                <div class="browse_content games">
                    <div class="images_holder">
                        <?php foreach($games as $game): ?>
                        <?php echo MainHelper::showImage($game, THUMB_LIST_18x18, false, array('width', 'no_img' => 'noimage/no_game_18x18.png', 'title' => $game->GameName));?>
                        <?php endforeach; ?>
                    </div>
                </div>
                <div class="browse_content wins">
                    <h2><?php echo $team->TotalWins; ?></h2>
                </div>
                <div class="browse_content rank">
                    <img src="<?php echo MainHelper::site_url('global/pub_img/esport/ranks/small_'.$team->Division['img']);?>" />
                    <h4><?php echo $team->Division['LadderName'].' / Tier '; ?><span><?php echo $team->Tier; ?></span></h4>
                </div>
            </div>
            <?php endforeach; ?>
            <?php else: ?>
                <div class="error_message">
                    <h1><?php echo $this->__('No players were found'); ?></h1>
                </div>
            <?php endif; ?>
        </div>
    </div>
<!-- THE EEEEND -->
</div>