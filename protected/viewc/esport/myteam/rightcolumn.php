<?php
    $teammates = $profile['teammates'];
    $team = $profile['team'];
    $pf_rel = $profile['playerfanclub'];
    
    $lastmatch = $profile['lastmatch'];
    $lastopponent = new Players();
    
    if(!empty($lastmatch) && $lastmatch->ChallengerID == $team->ID_TEAM)
        $lastopponent = Esport::GetTeamByID($lastmatch->OpponentID);
    else if(!empty($lastmatch) && $lastmatch->OpponentID == $team->ID_TEAM)
        $lastopponent = Esport::GetTeamByID($lastmatch->ChallengerID);
    else
        $lastopponent->DisplayName == '-';
    
    $top_menu = $profile['top_menu'];
    $bottom_menu = $profile['bottom_menu'];
    
    $isLiked = !empty($pf_rel) ? $pf_rel->isLiked() : false;
    $isSubscribed = !empty($pf_rel) ? $pf_rel->isSubscribed() : false;
?>
<div class="esports_right_column spotlight myteam">
	<div id="esports_menu" class="progressbar">
	<ul class="esports_ul margintop_10 progressbar_text spotlight_menu">
    <!-- Brug class "active" på anchor på det aktive menupunkt -->
        <li>
                <a href="javascript:void(0);" class="active"><?php echo strtoupper($this->__('Profile info')); ?></a>
        </li>
    </ul>
	</div>
    <!-- esports_menu END -->
    <div class="profile_picture_and_info">
    <div class="profile_picture">
    	<?php echo MainHelper::showImage($team, THUMB_LIST_150x200, false, array('width', 'no_img' => 'noimage/no_player_150x200.png'));?>
    </div>
    <div class="profile_info">
    	<div class="player_name content_margin"><h1><span><?php echo strtoupper($this->__('Team')).': '; ?></span><?php echo $team->DisplayName; ?></h1></div>
        <div class="recently_played content_margin"><?php echo $this->__('Recent Match').': '; ?><a href="<?php echo MainHelper::site_url('esport/team'+$team->ID_TEAM); ?>">vs. <?php echo $lastopponent->DisplayName; ?></a></div>
        <hr />
        <div class="country_age_gender content_margin">
            <div class="country"><img src="<?php echo MainHelper::site_url('global/img/flags/'.strtolower($team->Country).'.gif');?>"/><?php echo ' '.ucfirst(strtolower(Lang::getCountryByTag($team->Country))); ?></div>
            <div class="ranking_position"><?php echo $this->__('Ranking Position').': '; ?><span><?php echo $team->Rank; ?></span></div>
        </div>
        <hr />
        <div class="profile_description content_margin">
        	<p><?php echo $team->IntroMessage; ?></p>
        </div>
        <hr />
        <div class="fans_subscribe_challenge_like content_margin">
            <?php if($profile['player']->esportCheckStatus('isCaptain',$team->ID_TEAM) == 0): ?>
            <div class="fans"><p><?php echo $this->__('Fans').': '; ?><span><?php echo $team->Fans; ?></span></p></div>
           <div class="subscribe subscribe_feed"><a class="button button_small grey pull_right btn_red_gradient_bg <?php echo $isLiked ? 'dn' : ''; ?>" href="#"><?php echo $this->__('Subscribe'); ?><img src="<?php echo MainHelper::site_url('global/img/esport_subscribe_feed_icon.png'); ?>" /></a></div>
            <div class="subscribe subscribe_feed"><a class="button button_small grey pull_right btn_red_gradient_bg <?php echo $isLiked ? '' : 'dn'; ?> active" href="#"><?php echo $this->__('Unsubscribe'); ?><img src="<?php echo MainHelper::site_url('global/img/esport_subscribe_feed_icon.png'); ?>" /></a></div>
            <div class="subscribe like_me"><a class="button button_small grey pull_right btn_red_gradient_bg like like_<?php echo $team->ID_TEAM; ?> spotlight_like <?php echo $isLiked ? 'dn' : ''; ?>" rel="<?php echo $team->ID_TEAM; ?>" href="javascript:void(0)"><?php echo $this->__('Like Me'); ?></a></div>
            <div class="subscribe like_me"><a class="button button_small grey pull_right btn_red_gradient_bg unlike unlike_<?php echo $team->ID_TEAM; ?> spotlight_unlike <?php echo $isLiked ? '' : 'dn'; ?> active" rel="<?php echo $team->ID_TEAM; ?>" href="javascript:void(0)"><?php echo $this->__('Unlike Me'); ?></a></div>
            <div class="subscribe challenge_me"><a class="button button_small grey pull_right btn_red_gradient_bg challenge" href="<?php echo MainHelper::site_url('esport/challenge/'.$team->ID_TEAM); ?>"><?php echo $this->__('Challenge Me'); ?></a></div>
            <?php else: ?>
            <a class="button button_small grey pull_left btn_red_gradient_bg challenge" href="<?php echo MainHelper::site_url('esport/myteam/edit/'.$team->ID_TEAM); ?>"><?php echo $this->__('Edit'); ?></a>
            <?php endif; ?>
        </div>
    </div>
    </div>
    <!-- Profile_info END -->
    <div class="social_media">
    	<div class="red_gradient_bg small_red_border">
        </div>
        <p>Make sure to support our team, and join the discussions on all the other<br/>various social medias. We appriciate all you fans and your support ALOT.</p>
        <div class="social_icons">
        	<ul>
                <?php foreach($profile['social'] as $socials): ?>
            	<li>
                	<a href="<?php echo $socials->SocialURL; ?>" target='_blank'><img src="<?php echo MainHelper::site_url('global/img/social_icon_'.$socials->SocialName.'.png'); ?>" /></a>
                </li>
                <?php endforeach; ?>
            </ul>
        </div>
    </div>
    <!-- Social_media END -->
    <!-- TEAM ROSTER HER -->
    <div class="overview red_gradient_bg team_roster">
    	<h2><?php echo strtoupper($this->__('Team roster')); ?></h2><a href="#Ved_Ikke"><img src="<?php echo MainHelper::site_url('global/img/esport_people_icon.png'); ?>" /></a><a href="#Ved_Ikke"><img src="<?php echo MainHelper::site_url('global/css/img/esport_options_icon.png'); ?>" /></a>
    </div>
    <div class="roster">
    	<div class="arrow_left">
        	<a href="#backwards"><img src="<?php echo MainHelper::site_url('global/img/esport_lobby_arrow_back.png'); ?>" /></a>
        </div>
        <ul>
            <?php if(!empty($teammates)): ?>
            <?php foreach($teammates as $member): ?>
                <a href="<?php echo MainHelper::site_url('esport/spotlight/'.$member->ID_TEAM); ?>">
                    <li>
                        <?php echo MainHelper::showImage($member, THUMB_LIST_100x100, false, array('width', 'no_img' => 'noimage/no_player_100x100.png'));?>
                        <h2><?php echo $member->DisplayName; ?></h2>
                    </li>
                </a>
            <?php endforeach; ?>
            <?php endif; ?>
        </ul>
        <div class="arrow_right">
        	<a href="#forward"><img src="<?php echo MainHelper::site_url('global/img/esport_lobby_arrow_forward.png'); ?>" /></a>
        </div>
    </div>
    
   <!-- START: TOP 10 LISTER -->
    <div class="list_top10_ranking">
            <div class="top10_ranking">
            <div class="red_gradient_bg top10_header esport_list_first">
                <h2><?php echo strtoupper($this->__('Leaderboard')); ?></h2>
            </div>
            <?php $count = 0; ?>
            <?php if(!empty($profile['leagueranking'])): ?>
            <?php foreach ($profile['leagueranking'] as $ranking): ?>
            <?php
                if($count > 10)break;
                $teams = new EsTeams();
                $teams->Avatar = $ranking['Avatar'];
            ?>
            <a href="<?php echo MainHelper::site_url('esport/team'.$ranking['ID_TEAM']); ?>">
                <div class="top10_content grey_gradient_hover">
                <ul class="ladder_info">
                    <li class="ladder_icon"><?php echo MainHelper::showImage($teams, THUMB_LIST_18x18, false, array('width', 'no_img' => 'noimage/no_player_18x18.png'));?></li>
                    <li class="ladder_name"><?php echo ($count+1).'. '.$ranking['DisplayName']; ?></li>
            	</ul>
                </div>
            </a>
            <?php $count++; ?>
            <?php endforeach; ?>
            <?php endif; ?>
            <?php for($i = $count; $i < 10; $i++): ?>
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
        <div class="top10_ranking recent_matches">
            <div class="red_gradient_bg top10_header">
                <h2><?php echo strtoupper($this->__('Recent matches')); ?></h2>
            </div>
            <?php $count = 0; ?>
            <?php if (!empty($profile['lastmatches'][0])): ?>
            <?php foreach ($profile['lastmatches'] as $match): ?>
            <?php 
                if($match->ChallengerID == $team->ID_TEAM){
                    $lastopponent = Esport::GetTeamByID($lastmatch->OpponentID);
                }
                else if($match->OpponentID == $team->ID_TEAM){
                    $lastopponent = Esport::GetTeamByID($lastmatch->ChallengerID);
                }
                
                $result = $match->MatchWinnerID == $team->ID_TEAM ? 'won' : 'lost';
            ?>
                <div class="top10_content grey_gradient_hover">
                    <ul class="ladder_info">
                        <li class="ladder_progress"><span class="<?php echo $result; ?>"><?php echo ucfirst($result); ?></span></li>
                        <li class="ladder_icon">vs</li>
                    <li class="ladder_name"><?php echo $lastopponent->DisplayName; ?></li>
            	</ul>
                </div>
            <?php $count++; ?>
            <?php endforeach; ?>
            <?php endif; ?>
            <?php for($i = $count; $i < 10; $i++): ?>
                <div class="top10_content grey_gradient_hover">
                    <ul class="ladder_info">
                        <li class="ladder_progress"><span class="won"></span></li>
                        <li class="ladder_icon"></li>
                    <li class="ladder_name"></li>
            	</ul>
                </div>
            <?php endfor; ?>
        </div>
        <div class="top10_ranking">
            <div class="red_gradient_bg last top10_header">
                <h2><?php echo strtoupper($this->__('Games played')); ?></h2>
            </div>
            <?php $count = 0; ?>
            <?php foreach($profile['games'] as $game): ?>
            <a href="#">
                <div class="top10_content last grey_gradient_hover">
                    <ul class="ladder_info">
                        <li class="ladder_icon"><?php echo MainHelper::showImage($game, THUMB_LIST_18x18, false, array('width', 'no_img' => 'noimage/no_game_18x18.png'));?></li>
                        <li class="ladder_name"><?php echo $game->GameName; ?></li>
                    </ul>
                </div>
            </a>
            <?php $count++; ?>
            <?php endforeach; ?>
            <?php for($i = $count; $i < 10; $i++): ?>
                <div class="top10_content last grey_gradient_hover">
                    <ul class="ladder_info">
                        <li class="ladder_icon"></li>
                        <li class="ladder_name"></li>
                    </ul>
                </div>
            <?php endfor; ?>
        </div>
    </div>
    <!-- END: TOP 10 LISTER -->
    <div id="esports_menu" class="progressbar">
	<ul class="esports_ul margintop_10 progressbar_text spotlight_menu bottom_menu">
            <!-- Brug class "active" på anchor på det aktive menupunkt -->
            <li>
                    <a href="javascript:void(0)" id="wallfeed" class="wallfeed active"><?php echo strtoupper($this->__('Wall feed')); ?></a>
            </li>
            <li>
                    <a href="javascript:void(0)" id="fanlist" class="fanlist">FAN LIST</a>
            </li>
        </ul>
    </div>
    <!-- esports_menu END -->
    <!-- content for bottom pages -->
        <div class="wallfeed wallfeed_content bot_content" <?php echo $bottom_menu == 'wallfeed' ? '' : 'style=display:none'; ?>>
            <?php echo $this->renderBlock('esport/common/wallfeed', array('wallitems'=>$profile['wallitems'])); ?>
        </div>
        <div class="fanlist_content bot_content" <?php echo $bottom_menu == 'fanlist' ? '' : 'style=display:none'; ?>>
            <?php echo $this->renderBlock('esport/common/fanlist', array('fans'=>$profile['fans'])); ?>
        </div>
    <!-- content bottom page END -->
</div>