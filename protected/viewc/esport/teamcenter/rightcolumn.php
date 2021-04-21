<?php
    $top10won = $profile['topwon'];
    $top10views = $profile['topviews'];
?>
<div class="esports_right_column team_center">
    <!-- START TOP 10 -->
    <!-- **************READ ME******************* Use class "active" to have grey background gradient aswell as inbox shadow. AJ -->
	<div class="list_top10_ranking">
        <div class="top10_ranking">
            <div class="red_gradient_bg top10_header">
                <h2><?php echo strtoupper('Top 10').' : '.strtoupper('Teams with most games won'); ?></h2>
            </div>
            <?php $count = 1; ?>
            <?php if (!empty($top10won)): ?>
            <?php foreach ($top10won as $team): ?>
            <?php
                $t = new EsTeams();
                $t->Avatar = $team['Avatar'];
            ?>
                <a href="<?php echo MainHelper::site_url('esport/myteam/'.$team['ID_TEAM']); ?>">
                    <div class="top10_content grey_gradient_hover">
                        <ul class="ladder_info">
                            <li class="ladder_progress"></li>
                            <li class="ladder_icon"><?php echo MainHelper::showImage($t, THUMB_LIST_18x18, false, array('width', 'no_img' => 'noimage/no_player_18x18.png')); ?></li>
                            <li class="ladder_name"><?php echo $team['DisplayName']; ?></li>
                        </ul>
                    </div>
                </a>
            <?php $count++; ?>
            <?php endforeach; ?>
            <?php endif; ?>
            <?php for($i = $count; $i <= 10; $i++): ?>
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
                <h2><?php echo strtoupper($this->__('Top 10').' : '.$this->__('Most viewed teams')); ?></h2>
            </div>
            <?php $count = 1; ?>
            <?php if (!empty($top10views)): ?>
            <?php foreach ($top10views as $team): ?>
                <a href="<?php echo MainHelper::site_url('esport/myteam/'.$team->ID_TEAM); ?>">
                    <div class="top10_content grey_gradient_hover">
                        <ul class="ladder_info">
                            <li class="ladder_progress"></li>
                            <li class="ladder_icon"><?php echo MainHelper::showImage($team, THUMB_LIST_18x18, false, array('width', 'no_img' => 'noimage/no_player_18x18.png')); ?></li>
                            <li class="ladder_name"><?php echo $team->DisplayName; ?></li>
                        </ul>
                    </div>
                </a>
            <?php $count++; ?>
            <?php endforeach; ?>
            <?php endif; ?>
            <?php for($i = $count; $i <= 10; $i++): ?>
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
        <h2><?php echo strtoupper($this->__('My teams')); ?><span class="header_small_font"><?php echo $this->__('Create new team'); ?></span></h2>
    </div>
    <div class="grey_bg_margin">
        <?php foreach($profile['teams'] as $team): ?>
        <?php $team->getLeagueData(); ?>
        <div class="profile_picture_and_info">
            <div class="single_team">
                <div class="team_picture">
                    <a href="<?php echo MainHelper::site_url('esport/myteam/'.$team->ID_TEAM); ?>"><?php echo MainHelper::showImage($team, THUMB_LIST_150x200, false, array('width', 'no_img' => 'noimage/no_player_150x200.png'));?></a>
                </div>
                <p class="team_name"><a href="<?php echo MainHelper::site_url('esport/myteam/'.$team->ID_TEAM); ?>"><?php echo $team->DisplayName; ?></a></p>
                <p class="division"><?php echo $this->__('Division'); ?><img src="<?php echo MainHelper::site_url('global/pub_img/esport/ranks/small_'.$team->Division['img']);?>"/><br/><?php echo $this->__('Tier').': '; ?><span><?php echo $team->Tier; ?></span></p>
                <p class="ranking_position"><?php echo $this->__('Ranking Position').': '; ?><span><?php echo $team->Rank; ?></span></p>
                <p class="fans"><?php echo $this->__('Fans').': '; ?><span><?php echo $team->Fans; ?></span></p>
            </div>
        </div>
        <?php endforeach; ?>
        <div class="profile_picture_and_info"> 
            <div class="single_team">
                <div class="team_picture">
                    <a href="<?php echo MainHelper::site_url('esport/createteam'); ?>"><img src="<?php echo MainHelper::site_url('global/img/esport_create_new_team.png'); ?>"></a>
                </div>
            </div>
        </div>
    </div>
<!-- THE EEEEND -->
</div>