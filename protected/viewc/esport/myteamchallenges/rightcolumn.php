<?php
    $player = $profile['player'];
?>
<div class="esports_right_column team_center">
	<!-- START menu -->
	<div id="esports_menu" class="progressbar">
            <ul class="esports_ul margintop_10 progressbar_text spotlight_menu">
                <li>
                            <a href="#"><?php echo strtoupper($this->__('Team profile')); ?></a>
                </li>
                <li>
                    <a href="#" class="active"><?php echo strtoupper($this->__('Challenges')); ?></a>
                </li>
                <li>
                    <a href="<?php echo MainHelper::site_url('esport/forum'); ?>"><?php echo strtoupper($this->__('Forum')); ?></a>
                </li>
            </ul>
	</div>
    <div class="play4 grey_bg_margin">
    	<a href="<?php echo MainHelper::site_url('esport/createchallenge/play4free'); ?>"><img src="<?php echo MainHelper::site_url('global/img/esport_create_play4free.png'); ?>" /></a>
        <a href="<?php echo MainHelper::site_url('esport/createchallenge/play4credits'); ?>"><img src="<?php echo MainHelper::site_url('global/img/esport_create_play4credits.png'); ?>" /></a>
    </div>
  	<!-- PENDING CHALLENGES -->
    <div class="overview red_gradient_bg">
        <h2 class="di"><?php echo strtoupper($this->__('Pending').' '.$this->__('Challenges')); ?></h2>
        <span><a class="fcw pull_right mr15" href="<?php echo MainHelper::site_url('esport/challenges/pending'); ?>"><?php echo $this->__('Show all'); ?></a></span>
    </div>
	<div class="browsed_teams_list team_challenge pending">
            <?php echo $this->renderBlock('esport/common/gamelist_pending', array('challenges'=>$challenges['pending'], 'player' => $player)); ?>
        </div>
    </div>
    <!-- ACTIVE CHALLENGES -->
    <div class="overview red_gradient_bg">
        <h2 class="di"><?php echo strtoupper($this->__('Active').' '.$this->__('Challenges')); ?></h2>
        <span><a class="fcw pull_right mr15" href="<?php echo MainHelper::site_url('esport/challenges/active'); ?>"><?php echo $this->__('Show all'); ?></a></span>
    </div>
	<div class="browsed_teams_list team_challenge active">
            <?php echo $this->renderBlock('esport/common/gamelist_active', array('challenges'=>$challenges['active'], 'player' => $player)); ?>
        </div>
    </div>
    <!-- CLOSED CHALLENGES -->
    <div class="overview red_gradient_bg">
        <h2 class="di"><?php echo strtoupper($this->__('Finished').' '.$this->__('Challenges')); ?></h2>
        <span><a class="fcw pull_right mr15" href="<?php echo MainHelper::site_url('esport/challenges/finished'); ?>"><?php echo $this->__('Show all'); ?></a></span>
    </div>
	<div class="browsed_teams_list team_challenge finished">
            <?php echo $this->renderBlock('esport/common/gamelist_finished', array('challenges'=>$challenges['finished'], 'player' => $player)); ?>
        </div>
    </div>
<!-- THE EEEEND -->
</div>
<script>
//    $('.status a.accept').click(function(){
//        $.post(site_url+"esport/ajaxacceptchallenge",{
//            match: $(this).attr('rel'),
//        }, function(data){
//        });
//    });
</script>