<!-- Main container start -->
<div id="container" class="clearfix">
	<!-- Main content start -->
	<div id="esports_wrapper">
		<!-- E-Sports menu start -->
		<?php echo $this->renderBlock('esport/common/topbar', array()); ?>
		<!-- E-Sports menu end -->

		<!-- E-Sports content start -->
		<div class="esports_content">
			<?php echo $this->renderBlock('esport/common/leftcolumn', array('profile'=>$profile,'choosegameEnabled'=>false,'bettingladderEnabled'=>false)); ?>		
                        <?php
                        if($playmode == ESPORT_PLAYMODE_PLAY4CREDITS)
                            echo $this->renderBlock('esport/myteamchallenges/verify/play4credits', array('profile'=>$profile, 'gamedata'=>$gamedata)); 
                        else
                            echo $this->renderBlock('esport/myteamchallenges/verify/play4free', array('profile'=>$profile, 'gamedata'=>$gamedata)); 
                        ?>
		</div>
		<!-- E-Sports content end -->
	</div>
	<!-- Main content end -->
</div>
<!-- Main container end -->