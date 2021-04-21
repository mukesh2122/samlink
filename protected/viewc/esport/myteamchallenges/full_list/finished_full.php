<div class="esports_right_column">
	<!-- START menu -->
	<div id="esports_menu" class="progressbar">
	<ul class="esports_ul margintop_10 progressbar_text spotlight_menu">
    <!-- Brug class "active" på anchor på det aktive menupunkt -->
		<li>
        	<a href="#">TEAM PROFILE</a>
        </li>
        <li>
        	<a href="#" class="active">CHALLENGES</a>
        </li>
        <li>
        	<a href="#">FORUM</a>
        </li>
    </ul>
	</div>
    <!-- ACTIVE CHALLENGES -->
    <div class="darkgrey_bg_margin">
    	<div class="esport_profile_boxheaders mt0 mb1"><p>FINISHED <span>CHALLENGES</span></p></div>
    </div>
    <div class="overview red_gradient_bg">
        <h2>FINISHED CHALLENGES</h2>
    </div>
    <div class="browsed_teams_list team_challenge finished">
	<?php echo $this->renderBlock('esport/common/gamelist_finished', array('challenges'=>$profile['challenges'], 'player' => $profile['player'])); ?>	
    </div>
</div>