<?php
        $highestGameLeague = $profile['highestGameLeague'];
?>
<div id="esports_profile_wrapper" class="esport_widget">
<div class="esport_profile_boxheaders mt0"><p><?php echo $this->__('Profile'); ?></p></div>

	<div id="pw_top">
        <div class="profile_highest_league">
                <p><?php echo $this->__('Highest league achieved'); ?></p>
                <img src="<?php echo MainHelper::site_url('global/img/esport/test/medals/'.$highestGameLeague['ladderLeague']['img']);?>"/>
                <span><?php echo $highestGameLeague['game']['GameName']; ?></span>
        </div>
        <?php echo $this->renderBlock('esport/profile/gamescollection', array('profile'=>$profile)); ?>
	</div>
	<?php echo $this->renderBlock('esport/profile/profile_information', array('profile'=>$profile)); ?>

	<?php echo $this->renderBlock('esport/profile/profile_latest_achievements', array('profile'=>$profile)); ?>
</div>