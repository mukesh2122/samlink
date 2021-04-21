<?php
    $selectedTier = $ladder['selectedTier'];
    $selectedLeague = $ladder['selectedLeague'];
    $tierMin = $ladder['tierMin'];
    $tierMax = $ladder['tierMax'];
    $leagues = $ladder['leagues'];
    $myLeagueinfo = $leagues[$selectedLeague-1];
    $allRatings = $ladder['allRatings'];
    $teamRatings = $ladder['teamRatings'];
    $gameinfo = $ladder['gameinfo'];
?>
<div class="esports_right_column">
	<!-- START TOP 10 -->
    <!-- **************READ ME******************* Use class "active" to have grey background gradient aswell as inbox shadow. AJ -->
	<div class="list_top10_ranking">
        <div class="top10_ranking">
            <div class="red_gradient_bg top10_header">
                <h2>TOP 10 : <?php echo strtoupper($this->__('Elite ranks')); ?></h2>
            </div>
            <?php $count = 0; ?>
            <?php foreach($allRatings as $rating): ?>
            <?php if($count < 10): ?>
            <?php 
                $player = new Players();
                $player->Avatar = $rating['Avatar'];
            ?>
            <a href="#">
                <div class="top10_content grey_gradient_hover">
                    <ul class="ladder_info">
                            <li class="ladder_progress"></li>
                            <li class="ladder_icon"><?php echo MainHelper::showImage($player, THUMB_LIST_18x18, false, array('no_img' => 'noimage/no_player_18x18.png')); ?></li>
                            <li class="ladder_name"><?php echo ($count+1).'. '.$rating['DisplayName']; ?></li>
                    </ul>
                </div>
            </a>
            <?php $count++; ?>
            <?php else: break; ?>
            <?php endif; ?>
            <?php endforeach; ?>
            <?php for ($i = $count; $i < 10; $i++): ?>
            <a href="#">
                <div class="top10_content grey_gradient_hover">
                    <ul class="ladder_info">
                        <li class="ladder_progress"></li>
                        <li class="ladder_icon"></li>
                    <li class="ladder_name"></li>
            	</ul>
                </div>
            </a>
            <?php endfor; ?>
        </div>
        <div class="top10_ranking">
            <div class="red_gradient_bg top10_header">
                <h2>TOP 10 :  <?php echo strtoupper($this->__('Your league')); ?></h2>
            </div>
            <?php $count = 0; ?>
            <?php foreach ($allRatings as $rating): ?>
            <?php if ($myLeagueinfo['min'] <= $rating['TotalRating'] && $myLeagueinfo['max'] >= $rating['TotalRating'] && $count < 10): ?>
            <?php 
                $player = new Players();
                $player->Avatar = $rating['Avatar'];
            ?>
            <a href="#">
                <div class="top10_content grey_gradient_hover">
                    <ul class="ladder_info">
                        <!--<li class="ladder_progress"><img src="../global/css/img/up_arrow.png" /></li>-->
                        <li class="ladder_icon"><?php echo MainHelper::showImage($player, THUMB_LIST_18x18, false, array('no_img' => 'noimage/no_player_18x18.png')); ?></li>
                    <li class="ladder_name"><?php echo ($count+1).'. '.$rating['DisplayName']; ?></li>
            	</ul>
                </div>
            </a>
            <?php $count++; ?>
            <?php endif; ?>
            <?php endforeach; ?>
            <?php for ($i = $count; $i < 10; $i++): ?>
            <a href="#">
                <div class="top10_content grey_gradient_hover">
                    <ul class="ladder_info">
                        <li class="ladder_progress"></li>
                        <li class="ladder_icon"></li>
                    <li class="ladder_name"></li>
            	</ul>
                </div>
            </a>
            <?php endfor; ?>
        </div>
        <div class="top10_ranking">
            <div class="red_gradient_bg top10_header">
                <h2>TOP 10 : YOUR TEAMS LEAGUE</h2>
            </div>
            <?php $count = 0; ?>
            <?php $team = new EsTeams(); ?>
            <?php foreach ($teamRatings as $trating): ?>
            <?php $team->Avatar = $trating['Avatar']; ?>
            <?php //if ($myLeagueinfo['min'] <= $trating['TotalRating'] && $myLeagueinfo['max'] >= $trating['TotalRating'] && $count < 10): ?>
            <a href="#">
                <div class="top10_content grey_gradient_hover">
                    <ul class="ladder_info">
                        <!--<li class="ladder_progress"><img src="../global/css/img/up_arrow.png" /></li>-->
                        <li class="ladder_icon"><?php echo MainHelper::showImage($team, THUMB_LIST_18x18, false, array('no_img' => 'noimage/no_player_18x18.png')); ?></li>
                    <li class="ladder_name"><?php echo ($count+1).'. '.$trating['DisplayName']; ?></li>
            	</ul>
                </div>
            </a>
            <?php $count++; ?>
            <?php //endif; ?>
            <?php endforeach; ?>
            <?php for ($i = $count; $i < 10; $i++): ?>
            <a href="#">
                <div class="top10_content grey_gradient_hover">
                    <ul class="ladder_info">
                        <li class="ladder_progress"></li>
                        <li class="ladder_icon"></li>
                    <li class="ladder_name"></li>
            	</ul>
                </div>
            </a>
            <?php endfor; ?>
        </div>
    </div>
    <!-- END TOP 10 -->
    <div class="overview red_gradient_bg">
        <h2><?php echo strtoupper($this->__('Overview')); ?></h2>
    </div>
    <div class="overview_games">
    	<div class="red_gradient_bg overview_header">
        	<h4><?php echo $this->__('Games'); ?></h4>
        </div>
        <div id="ladder_gamelist_bigimage" style="position:relative" class="cp">
        	<?php $img = $ID_GAME != 'all' ? 'noimage/no_game_121x150.png' : 'noimage/pickyourgame_121x150.jpg'; ?>
        	<?php echo MainHelper::showImage($gameinfo, THUMB_LIST_121x150, false, array('no_img' => $img )); ?>
                <div id="ladder_gamelist" style="display:none; color:white; padding:20px; position:absolute; top:0px; left:100%; width:150px; background:url('img/esport_profile_personal_bg.png') repeat-x scroll 0% 0% rgb(46, 45, 45);">
                    <?php foreach($games as $game): ?>
                    <?php $ogame = new SnGames(); ?>
                    <?php $ogame->ImageURL = $game['ImageURL']; ?>
                    <a href="<?php echo MainHelper::site_url("esport/ladder/{$game['ID_GAME']}"); ?>">
                        <div class="">
                            <ul class="ladder_info">
                                <li class="ladder_icon"><?php echo MainHelper::showImage($ogame, THUMB_LIST_18x18, false, array('no_img' => 'noimage/no_game_18x18.png')); ?></li>
                                <li class="ladder_name"><?php echo $game['GameName']; ?></li>
                            </ul>
                        </div>
                    <a/>
                    <?php endforeach; ?>
                </div>
        </div>
    </div>
    <div class="overview_ranks ranks">
    	<div class="red_gradient_bg overview_header">
        	<h4><?php echo $this->__('Ranks'); ?></h4>
        </div>
        <div class="ranks">
               	<a href="<?php echo MainHelper::site_url("esport/ladder/{$ID_GAME}/league/1/{$selectedTier}"); ?>">
                	<div class="rank grey_gradient_hover <?php echo $selectedLeague == 1 ? 'active' : ''; ?>">
               			<img src="<?php echo MainHelper::site_url('global/pub_img/esport/ranks/bronze.png'); ?>"/>
                    	<p><?php echo $this->__('Bronze'); ?></p>
                	</div>
                </a>
                <a href="<?php echo MainHelper::site_url("esport/ladder/{$ID_GAME}/league/2/{$selectedTier}"); ?>">
                	<div class="rank grey_gradient_hover <?php echo $selectedLeague == 2 ? 'active' : ''; ?>">
               			<img src="<?php echo MainHelper::site_url('global/pub_img/esport/ranks/silver.png'); ?>"/>
                    	<p><?php echo $this->__('Silver'); ?></p>
                	</div>
                </a>
                <a href="<?php echo MainHelper::site_url("esport/ladder/{$ID_GAME}/league/3/{$selectedTier}"); ?>">
                	<div class="rank grey_gradient_hover <?php echo $selectedLeague == 3 ? 'active' : ''; ?>">
               			<img src="<?php echo MainHelper::site_url('global/pub_img/esport/ranks/gold.png'); ?>"/>
                    	<p><?php echo $this->__('Gold'); ?></p>
                	</div>
                </a>
                <a href="<?php echo MainHelper::site_url("esport/ladder/{$ID_GAME}/league/4/{$selectedTier}"); ?>">
                	<div class="rank grey_gradient_hover <?php echo $selectedLeague == 4 ? 'active' : ''; ?>">
               			<img src="<?php echo MainHelper::site_url('global/pub_img/esport/ranks/elite.png'); ?>"/>
                    	<p><?php echo $this->__('Elite'); ?></p>
                	</div>
                </a>
        </div>
    </div>
    <div class="overview_tiers tiers">
    	<div class="red_gradient_bg overview_header">
        	<h4><?php echo $this->__('Tiers'); ?></h4>
        </div>
        <div class="tiers">
               	<a href="<?php echo MainHelper::site_url("esport/ladder/{$ID_GAME}/league/{$selectedLeague}/1"); ?>">
                	<div class="tier grey_gradient_hover <?php echo $selectedTier == 1 ? 'active' : ''; ?>">
                    	<p><?php echo $this->__('Tier').' I'; ?></p>
                	</div>
                </a>
                <a href="<?php echo MainHelper::site_url("esport/ladder/{$ID_GAME}/league/{$selectedLeague}/2"); ?>">
                	<div class="tier grey_gradient_hover <?php echo $selectedTier == 2 ? 'active' : ''; ?>">
                    	<p><?php echo $this->__('Tier').' II'; ?></p>
                	</div>
                </a>
                <a href="<?php echo MainHelper::site_url("esport/ladder/{$ID_GAME}/league/{$selectedLeague}/3"); ?>">
                	<div class="tier grey_gradient_hover <?php echo $selectedTier == 3 ? 'active' : ''; ?>">
                    	<p><?php echo $this->__('Tier').' III'; ?></p>
                	</div>
                </a>
                <a href="<?php echo MainHelper::site_url("esport/ladder/{$ID_GAME}/league/{$selectedLeague}/4"); ?>">
                	<div class="tier grey_gradient_hover <?php echo $selectedTier == 4 ? 'active' : ''; ?>">
                    	<p><?php echo $this->__('Tier').' IV'; ?></p>
                	</div>
                </a>
                <a href="<?php echo MainHelper::site_url("esport/ladder/{$ID_GAME}/league/{$selectedLeague}/5"); ?>">
                	<div class="tier grey_gradient_hover <?php echo $selectedTier == 5 ? 'active' : ''; ?>">
                    	<p><?php echo $this->__('Tier').' V'; ?></p>
                	</div>
                </a>
        </div>
    </div>
    <div class="overview_positions positions">
    	<div class="red_gradient_bg overview_header">
        </div>
        <div class="position">
        	<a class="btn_team_position" href="#"><?php echo $this->__('Team Position'); ?></a>
            <br/>
            <br/>
            <br/>
            <a class="btn_my_position" href="<?php echo MainHelper::site_url("esport/ladder/"); ?>"><?php echo $this->__('My Position'); ?></a>
        </div>
    </div>
    <div class="ladder_ranks overview red_gradient_bg">
    	<h2><?php echo strtoupper($this->__('Ladder Ranks')); ?></h2>
    </div>
    <div class="red_gradient_bg overview_header player">
        <h4><?php echo $this->__('Player'); ?></h4>
    </div>
    <div class="red_gradient_bg overview_header team">
        <h4><?php echo $this->__('Team'); ?></h4>
    </div>
    <div class="red_gradient_bg overview_header wins">
        <h4><?php echo $this->__('Wins'); ?></h4>
    </div>
    <div class="red_gradient_bg overview_header points">
        <h4><?php echo $this->__('Points'); ?></h4>
    </div>
    <?php if(empty($allRatings)): ?>
        <div class="error_message">
            <h1><?php echo $this->__('Sorry, no ranking was found'); ?></h1>
            <h3><?php echo $this->__('Choose your game above'); ?></h3>
        </div>
    <?php endif; ?>
    <?php 
        $count = 1;
        $player = new Players();
        $team = new EsTeams();
    ?>
    <?php foreach ($allRatings as $rating): ?>
    <?php if ($tierMin <= $rating['TotalRating'] && $tierMax >= $rating['TotalRating']): ?>
    <?php $player->Avatar = $rating['Avatar']; ?>
    <?php $team->Avatar = $rating['TeamAvatar']; ?>
    <a href="#">
        <div class="ladder_content player grey_gradient_hover">
            <ul class="ladder_info">
                <li class="ladder_icon"><?php echo MainHelper::showImage($player, THUMB_LIST_18x18, false, array('no_img' => 'noimage/no_player_18x18.png')); ?></li>
        	    <li class="ladder_rank_name"><?php echo $count++.'. '.$rating['DisplayName']; ?></li>
    	  	</ul>
	    </div>
    </a>
    <a href="#">
        <div class="ladder_content team grey_gradient_hover">
            <?php if($rating['MultiplayerID'] != 0): ?>
            <ul class="ladder_info">
                <li class="ladder_icon"><?php echo MainHelper::showImage($team, THUMB_LIST_18x18, false, array('no_img' => 'noimage/no_player_18x18.png')); ?></li>
                <li class="ladder_rank_team"><?php echo $rating['MultiplayerName']; ?></li>
            </ul>
            <?php endif; ?>
        </div>
    </a>
    <div class="ladder_content wins">
    	<p class="ladder_numbers"><?php echo $rating['TotalWins']; ?></p>
    </div>
    <div class="ladder_content points">
    	<p class="ladder_numbers"><?php echo $rating['TotalRating']; ?></p>
    </div>
    <?php endif; ?>
    <?php endforeach; ?>
    
    <!-- Hele vejen op til top 40 -->
</div>