<?php 
$player = $profile['player'];
    ?>
<!-- Main container start -->
<div id="container" class="clearfix">
	<!-- Main content start -->
	<div id="esports_wrapper">
		<!-- E-Sports menu start -->
		<?php echo $this->renderBlock('esport/common/topbar', array()); ?>
		<!-- E-Sports menu end -->

		<!-- E-Sports content start -->
		<div class="esports_content">
			<?php echo $this->renderBlock('esport/common/leftcolumn', array('profile' => $profile, 'choosegameEnabled'=>false,'bettingladderEnabled'=>false)); ?>	
                    <!-- E-Sports right column start -->
                    <div class="esports_right_column">
                        <div class="error_message m20">
                            <h1><?php echo $this->__('You are not currently a registred eSport player'); ?></h1>
                            <h2><a href="<?php echo MainHelper::site_url('esport/registerplayer'); ?>"><?php echo $this->__('I want to become a part of eSportNation'); ?></a></h2>
                        </div>
                    </div>
                    <!-- E-Sports right column end -->
		</div>
		<!-- E-Sports content end -->
	</div>
	<!-- Main content end -->
</div>
<!-- Main container end -->
