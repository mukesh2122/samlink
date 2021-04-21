<?php 
$user = new User();
    $visitor = User::getUser(); 
    $highestGameLeague = $profile['highestGameLeague'];
    $team = $profile['fanclub'];
    $player = Esport::getUserByEsportTeam($team->ID_TEAM);
    $pf_rel = $profile['playerfanclub'];
    $top_menu = $profile['top_menu'];
    $bottom_menu = $profile['bottom_menu'];
    $lastmatch = $profile['lastgame'];
    $isLiked = !empty($pf_rel) ? $pf_rel->isLiked() : false;
    $isSubscribed = !empty($pf_rel) ? $pf_rel->isSubscribed() : false;
    
    $_SESSION['createchallenge']['challengerinfo'] = $visitor->ID_TEAM;
    $_SESSION['createchallenge']['opponentinfo'] = $team->ID_TEAM;
?>
<div class="esports_right_column spotlight">
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
        <div class="player_name content_margin"><h1><span><?php echo strtoupper($this->__('Player').': '); ?></span><?php echo $team->DisplayName ?></h1></div>
        <?php if(!empty($lastmatch)): ?>
            <div class="recently_played content_margin"><?php echo $this->__('Recently Played').': '; ?><a target="_blank" href="<?php echo $lastmatch->URL; ?>"><?php echo MainHelper::showImage($lastmatch, THUMB_LIST_18x18, false, array('width', 'no_img' => 'noimage/no_game_18x18.png'));?><?php echo ' '.$lastmatch->GameName; ?></a></div>
        <?php else: ?>
            <div class="recently_played content_margin"><?php echo $this->__('Recently Played').': -'; ?></div>
        <?php endif; ?>
        <hr />
        <div class="country_age_gender content_margin">
        	<div class="country"><img src="<?php echo MainHelper::site_url('global/img/flags/'.strtolower($player->Country).'.gif');?>"/>  <?php echo PlayerHelper::getCountry($player->Country); ?></div>
            <div class="age"><?php echo $this->__('Age').': '?><?php echo PlayerHelper::calculateAge($player->DateOfBirth); ?></div>
            <div class="gender"><?php echo $this->__($player->Gender); ?></div>
        </div>
        <hr />
        <div class="profile_description content_margin">
        	<?php echo $team->IntroMessage; ?>
        </div>
        <hr />
        <div class="fans_subscribe_challenge_like content_margin">
                <div class="fans"><p><?php echo $this->__('Fans').': ' ?><span><?php echo $profile['likes']; ?></span></p></div>
            <?php if($visitor->ID_TEAM != $team->ID_TEAM): ?>
                <div class="subscribe subscribe_feed"><a class="button button_small grey pull_right btn_red_gradient_bg <?php echo $isSubscribed ? 'dn' : ''; ?>" href="javascript:void(0);"><?php echo $this->__('Subscribe'); ?><img src="<?php echo MainHelper::site_url('global/img/esport_subscribe_feed_icon.png'); ?>" /></a></div>
                <div class="subscribe subscribe_feed"><a class="button button_small grey pull_right btn_red_gradient_bg <?php echo $isSubscribed ? '' : 'dn'; ?> active" href="javascript:void(0);"><?php echo $this->__('Unsubscribe'); ?><img src="<?php echo MainHelper::site_url('global/img/esport_subscribe_feed_icon.png'); ?>" /></a></div>
                <div class="subscribe like_me"><a class="button button_small grey pull_right btn_red_gradient_bg like like_<?php echo $team->ID_TEAM; ?> spotlight_like <?php echo $isLiked ? 'dn' : ''; ?>" rel="<?php echo $team->ID_TEAM; ?>" href="javascript:void(0);"><?php echo $this->__('Like Me'); ?></a></div>
                <div class="subscribe like_me"><a class="button button_small grey pull_right btn_red_gradient_bg unlike unlike_<?php echo $team->ID_TEAM; ?> spotlight_unlike <?php echo $isLiked ? '' : 'dn'; ?> active" rel="<?php echo $team->ID_TEAM; ?>" href="javascript:void(0);"><?php echo $this->__('Unlike Me'); ?></a></div>
                <div style="z-index:100; position:relative;" class="subscribe challenge_me"><a style="position:relative; z-index:1" class="button button_small grey pull_right btn_red_gradient_bg challenge" href="<?php echo MainHelper::site_url('esport/createchallenge/play4free'); ?>"><?php echo $this->__('Challenge Me'); ?></a></div>
            <?php else: ?>
                <a class="button button_small grey pull_left btn_red_gradient_bg" href="<?php echo MainHelper::site_url('esport/spotlight/edit'); ?>"><?php echo $this->__('Edit'); ?></a>
                <a class="button button_small grey pull_left btn_red_gradient_bg ml5" href="<?php echo MainHelper::site_url('esport/myteam/challenges'); ?>"><?php echo $this->__('Challenges'); ?></a>
            <?php endif; ?>
        </div>
    </div>
    </div>
    <!-- Profile_info END -->
    <div class="social_media">
    	<div class="red_gradient_bg small_red_border">
        </div>
        <p>Check out my other social media profiles, where you can always catch me.<br/>If you want to see more of me!<br/>Make sure to subscribe and follow me for more action.</p>
        <div class="social_icons">
        	<ul>
                <?php foreach($profile['social'] as $socials): ?>
            	<li>
                	<a href="<?php echo $socials->SocialURL; ?>" target='_blank'><img src="<?php echo MainHelper::site_url('global/img/social_icon_'.$socials->SocialName.'.png'); ?>" /></a>
                </li>
                <?php endforeach; ?>
            </ul>
        </div>
        <div class="red_gradient_bg small_red_border">
        </div>
    </div>
    <!-- Social_media END -->
    <div class="rank_and_gaming_rig_bg">
        <div class="rank_and_gaming_rig">
            <div class="rank">
                <p><?php echo strtoupper($this->__('Rank')); ?></p>
                <img src="<?php echo MainHelper::site_url('global/img/esport/test/medals/'.$highestGameLeague['ladderLeague']['img']);?>"/>
                <p><span><?php echo $highestGameLeague['ladderLeague']['LadderName']; ?></span></p>
            </div>
            <div class="gaming_rig">
                <p><?php echo strtoupper($this->__('Gaming rig')); ?></p>
                <ul>
                    <?php foreach($profile['gamingRig'] as $spec): ?>
                    <li>
                        <p class="item"><span><?php echo $spec->SpecName; ?></span><?php echo $spec->SpecDesc; ?></p>
                    </li>
                    <?php endforeach; ?>
                </ul>
            </div>
        </div>
    </div>
        <!-- Rank_and_gaming_rig END -->
    <div id="esports_menu" class="progressbar">
	<ul class="esports_ul margintop_10 progressbar_text spotlight_menu bottom_menu">
    <!-- Brug class "active" på anchor på det aktive menupunkt -->
            <li>
                <a href="javascript:void(0)" id="wallfeed" class="wallfeed <?php echo $bottom_menu == 'wallfeed' ? 'active' : ''; ?>"><?php echo strtoupper($this->__('Wall feed')); ?></a>
            </li>
            <li>
                <a href="javascript:void(0)" id="gamecollection" class="gamecollection <?php echo $bottom_menu == 'gamecollection' ? 'active' : ''; ?>"><?php echo strtoupper($this->__('Game collection')); ?></a>
            </li>
            <li>
                <a href="javascript:void(0)" id="fanlist" class="fanlist <?php echo $bottom_menu == 'fanlist' ? 'active' : ''; ?>"><?php echo strtoupper($this->__('Fan list')); ?></a>
            </li>
        </ul>
    </div>
    <!-- esports_menu END -->
    <!-- content for bottom pages -->
        <div class="wallfeed wallfeed_content bot_content" <?php echo $bottom_menu == 'wallfeed' ? '' : 'style=display:none'; ?>>
            <?php echo $this->renderBlock('esport/common/wallfeed', array('wallitems'=>$profile['wallitems'])); ?>
        </div>
        <div class="gamecollection_content bot_content" <?php echo $bottom_menu == 'gamecollection' ? '' : 'style=display:none'; ?>>
            <?php echo $this->renderBlock('esport/common/gamecollection', array('games'=>$profile['games'])); ?>
        </div>
        <div class="fanlist_content bot_content" <?php echo $bottom_menu == 'fanlist' ? '' : 'style=display:none'; ?>>
            <?php echo $this->renderBlock('esport/common/fanlist', array('fans'=>$profile['fans'])); ?>
        </div>
    <!-- content bottom page END -->
</div>