<?php 
    $achievement = new Achievement();
?>

<link rel="stylesheet" type="text/css" href="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8.16/themes/base/jquery-ui.css">

			<!-- Achievements area start -->
		<div id="achievements_site">
			<div class="latest_achievements">
				<h1><?php echo $this->__('Latest Achievements'); ?></h1>
                                <ul>
                                    <?php if (count($latestAchievements) > 0): 
                                             foreach($latestAchievements as $latest){
                                                echo $this->renderBlock('achievements/common/latest', array('latest' => $latest, 'player' => $player));
                                            }
                                         else:
                                             echo '<p>'.$this->__('There are currently no achievements unlocked').'</p>';
                                         endif;
                                    ?>        
                                </ul>
			</div>
			<div class="overview_achievements">
				<h1><?php echo $this->__('All Achievements'); ?></h1>
				<?php foreach($branches as $branch){
                                    echo $this->renderBlock('achievements/common/achievements_list',array('branch' => $branch, 'player' => $player));
                                }?>
			</div>
                   
<div id="dialog" title="Dialog Title"><?php echo $this->renderBlock('achievements/common/dialog'); ?></div>
		</div>
                <script type="text/javascript" src="<?php echo Doo::Conf()->APP_URL.'/global/js/jquery.achievement-accordion.js' ?>"></script>
                <script>
                    $( "#dialog" ).dialog({ autoOpen: false, 
                                            height: 500,
                                            width: 600,
                                            modal: true,
                                            resizable: false,
                                            title: "Achievement Progress"
                                        });
    $( "img" ).click(function() {
        var id = $(this).attr('id');
        $( "#dialog" ).dialog( "open" );
});
                </script>
		<!-- Achievements area end -->
