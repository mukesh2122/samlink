<div class="esports_right_column">
	<!-- Esports profile start -->
	<?php echo $this->renderBlock('esport/profile/gamescollectionalert', array('profile'=>$profile)); ?>
	<?php echo $this->renderBlock('esport/profile/esports_profile_wrapper', array('profile'=>$profile)); ?>
	<?php echo $this->renderBlock('esport/profile/match_history', array('profile'=>$profile)); ?>
	<?php echo $this->renderBlock('esport/profile/esports_profile_tournaments', array('profile'=>$profile)); ?>
	<!-- Esports profile end -->
</div>