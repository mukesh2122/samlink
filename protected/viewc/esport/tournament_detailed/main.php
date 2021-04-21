<!-- include CSS & JS files -->
<!-- CSS file -->
<link rel="stylesheet" type="text/css" href="jScrollbar.jquery.css" media="screen" />
<!-- jQuery files -->
<script type="text/javascript" src="../global/js/jscrollbar/jquery/jquery.js"></script>
<script type="text/javascript" src="../global/js/jscrollbar/jquery/jquery-ui.js"></script>
<script type="text/javascript" src="../global/js/jscrollbar/jquery/jquery-mousewheel.js"></script>
<script type="text/javascript" src="../global/js/jscrollbar/jquery/jScrollbar.jquery.js"></script>



<!-- Main container start -->
<div id="container" class="clearfix">
	<!-- Main content start -->
	<div id="esports_wrapper">
            
        <?php echo $this->renderBlock('esport/common/topbar', array()); ?>
            
		<!-- E-Sports content start -->
		<div class="esports_content tournament_detailed">
        	<div class="esport_profile_boxheaders top_header"><p>Game <span>Lobby</span></p></div>
            <div class="online_count"><img class="mr5" src="http://playnationesport.com/global/img/onlineindicator.png"><span>2 online</span></div>
            <div id="esports_menu" class="progressbar red_gradient_bg">
            	<div class="esports_menu_bottom"></div>
                <ul class="esports_ul full_width progressbar_text">
                <li><a class="quickmatch" href="#">QUICKMATCH</a></li><li><a class="tournaments active" href="#">TOURNAMENTS</a></li>	</ul>
            </div>
            <div class="tournament_image">
            	<img src="#giant_mofo_image" />
            </div>
            <div class="td_sponsors">
            	<span class="img_container"><img src="../global/css/img/header_logo_beta.png" /></span>
                <span class="img_container"><img src="../global/css/img/breadcrumbs_league-of-legends.png" /></span>
                <span class="img_container"><img src="../global/css/img/intro_text_title.png" /></span>
                <span class="img_container"><img src="../global/css/img/breadcrumbs_league-of-legends.png" /></span>
                <span class="img_container"><img src="../global/css/img/header_logo_beta.png" /></span>
                <span class="img_container"><img src="../global/css/img/breadcrumbs_league-of-legends.png" /></span>
            </div>
            <!-- TOURNAMENT INFO -->
            <div class="td_tournament_info">
            	<div class="td_heading">
                	<h1><?php echo $this->__('Tournament info') ?></h1>
                </div>
            	<div class="td_tournament_info_content">
                	<p>This tournament is all about CAKE CAKE CAKE Feel Free to bring your own cake if you dont like chocolate cake.
                    All you need is CAKE RIGHT!?! YES YOU CAN HAZ CAKEZ YOU CAN HAZ CAKEZ YOU CAN HAZ CAKEZ YOU CAN HAZ CAKEZ YOU CAN HAZ CAKEZ YOU CAN HAZ CAKEZ    YOU CAN HAZ CAKEZ YOU CAN HAZ CAKEZ    YOU CAN HAZ CAKEZ YOU CAN HAZ CAKEZ    YOU CAN HAZ CAKEZ YOU CAN HAZ CAKEZ    YOU CAN HAZ CAKEZ YOU CAN HAZ CAKEZ  YOU CAN HAZ CAKEZ YOU CAN HAZ CAKEZ    YOU CAN HAZ CAKEZ YOU CAN HAZ CAKEZ    YOU CAN HAZ CAKEZ YOU CAN HAZ CAKEZ    YOU CAN HAZ CAKEZ YOU CAN HAZ CAKEZ YOU CAN HAZ CAKEZ YOU CAN HAZ CAKEZ    YOU CAN HAZ CAKEZ YOU CAN HAZ CAKEZ    YOU CAN HAZ CAKEZ YOU CAN HAZ CAKEZ    YOU CAN HAZ CAKEZ YOU CAN HAZ CAKEZ    YOU CAN HAZ CAKEZ YOU CAN HAZ CAKEZ    YOU CAN HAZ CAKEZ YOU CAN HAZ CAKEZ    YOU CAN HAZ CAKEZ YOU CAN HAZ CAKEZ YOU CAN HAZ CAKEZ YOU CAN HAZ CAKEZ  YOU CAN HAZ CAKEZ YOU CAN HAZ CAKEZ YOU CAN HAZ CAKEZ YOU CAN HAZ CAKEZ    YOU CAN HAZ CAKEZ YOU CAN HAZ CAKEZ
                    
                    So sign up to the tournament and get cakez! They are sponsored by:  Cake & Cookie Devourers</p>
				</div>
            </div>
            <!-- RULES PRIZE TOURNMANET STATUS MENU -->
            <!-- RULES -->
            <div class="td_rules td_block">
            	<div class="td_heading">
                	<h1><?php echo $this->__('Rules') ?></h1>
                </div>
                <div class="td_content">
                	<p>The 1st place in each group picks their opponent from either 
                    the 3rd or 4th place finish in the opposite group.
                    
                    Upper Bracket
                    Upper Bracket A: Group A Seed 1 vs Group B Seed 3/4
                    Upper Bracket B: Group B Seed 2 vs Group A Seed 3/4 
                    (The team Group B Seed 1 didn't choose)
                    Upper Bracket C: Group B Seed 1 vs Group A Seed 3/4
                    Upper Bracket D: Group A Seed 2 vs Group B Seed 3/4 
                    (The team Group A Seed 1 didn't choose)
                    
                    First Round: The higher seed has Selection Priority for game 
                    one and then alternates for game two. If it goes to a third 
                    game, the higher seed has Selection Priority again.
                    
                    Other Rounds: Selection Priority is determined by total 
                    games W-L record of the Main Event. If it is tied, a coin toss 
                    determines it.
                    All Upper Bracket games are Best of Three. Grand Final is 
                    Best of Five, no game advantage.
                    First Round: The higher seed has Selection Priority for game 
                    one and then alternates for game two. If it goes to a third 
                    game, the higher seed has Selection Priority again.
                    
                    Other Rounds: Selection Priority is determined by total 
                    games W-L record of the Main Event. If it is tied, a coin toss 
                    determines it.
                    All Upper Bracket games are Best of Three. Grand Final is 
                    Best of Five, no game advantage.
                    First Round: The higher seed has Selection Priority for game 
                    one and then alternates for game two. If it goes to a third 
                    game, the higher seed has Selection Priority again.
                    
                    Other Rounds: Selection Priority is determined by total 
                    games W-L record of the Main Event. If it is tied, a coin toss 
                    determines it.
                    All Upper Bracket games are Best of Three. Grand Final is 
                    Best of Five, no game advantage.
                    First Round: The higher seed has Selection Priority for game 
                    one and then alternates for game two. If it goes to a third 
                    game, the higher seed has Selection Priority again.
                    
                    Other Rounds: Selection Priority is determined by total 
                    games W-L record of the Main Event. If it is tied, a coin toss 
                    determines it.
                    All Upper Bracket games are Best of Three. Grand Final is 
                    Best of Five, no game advantage.
                    First Round: The higher seed has Selection Priority for game 
                    one and then alternates for game two. If it goes to a third 
                    game, the higher seed has Selection Priority again.
                    
                    Other Rounds: Selection Priority is determined by total 
                    games W-L record of the Main Event. If it is tied, a coin toss 
                    determines it.
                    All Upper Bracket games are Best of Three. Grand Final is 
                    Best of Five, no game advantage.
                    </p>
                </div>
            </div>
            <!-- RULES -->
            <div class="td_prize td_block">
            	<div class="td_heading">
                	<h1><?php echo $this->__('Prize') ?></h1>
                </div>
                <div class="td_content">
                	<p>The 1st place in each group picks their opponent from either 
                    the 3rd or 4th place finish in the opposite group.
                    
                    Upper Bracket
                    Upper Bracket A: Group A Seed 1 vs Group B Seed 3/4
                    Upper Bracket B: Group B Seed 2 vs Group A Seed 3/4 
                    (The team Group B Seed 1 didn't choose)
                    Upper Bracket C: Group B Seed 1 vs Group A Seed 3/4
                    Upper Bracket D: Group A Seed 2 vs Group B Seed 3/4 
                    (The team Group A Seed 1 didn't choose)
                    
                    First Round: The higher seed has Selection Priority for game 
                    one and then alternates for game two. If it goes to a third 
                    game, the higher seed has Selection Priority again.
                    
                    Other Rounds: Selection Priority is determined by total 
                    games W-L record of the Main Event. If it is tied, a coin toss 
                    determines it.
                    All Upper Bracket games are Best of Three. Grand Final is 
                    Best of Five, no game advantage.
                    </p>
                </div>
            </div>
            <!-- TOURNAMENT STATUS -->
            <div class="td_tournament_status td_block">
            	<div class="td_heading">
                	<h1><?php echo $this->__('Tournament status') ?></h1>
                </div>
                <div class="td_content">
                	<h4 class="start_date">Tournament Start Date: 1. March 2014</h4>
                    <div class="tournament_status_button">Tournament is: <span class="open">OPEN</span> <!-- class "closed" if status is "CLOSED" --> </div>
                	<p>The 1st place in each group picks their opponent from either 
                    the 3rd or 4th place finish in the opposite group.
                    
                    Upper Bracket
                    Upper Bracket A: Group A Seed 1 vs Group B Seed 3/4
                    Upper Bracket B: Group B Seed 2 vs Group A Seed 3/4 
                    (The team Group B Seed 1 didn't choose)
                    Upper Bracket C: Group B Seed 1 vs Group A Seed 3/4
                    Upper Bracket D: Group A Seed 2 vs Group B Seed 3/4 
                    (The team Group A Seed 1 didn't choose)
                    
                    First Round: The higher seed has Selection Priority for game
                    </p>
                    <div class="join_tournament_button">
                    	<div class="join_tournament_button_container"><a href="#join_tournament" class="tournament_status_button">Join Tournament</a></div>
                       	<p>Only Team Leaders can sign the team up to the tournament.</p>
                    </div>
                </div>
            </div>
            <!-- TOURNAMENT BRACKETS -->
            <div class="td_tournament_brackets">
            	<div class="td_heading width33 pull_left">
                	<h1><?php echo $this->__('Tournament brackets') ?></h1>
                </div>
                <div class="td_heading width33 pull_left">
                </div>
                <div class="td_heading width33 pull_left">
                	<h1><?php echo $this->__('Match coverage') ?></h1>
                </div>
            	<div class="td_tournament_brackets_content">
                <!-- BRACKET TABLES STARTS HERE -->
                
<table border="1" bordercolor="black" cellpadding="" cellspacing="0" class="tournament_bracket_table">
	<tr>
		<td>
        	<div class="bracket_match left_side">
            	<div class="bracket_match_team1">
                <img src="#team1_logo" />
                <p>S A D B O Y S</p>
                </div>
                <div class="bracket_match_team2">
                <img src="#team2_logo" />
                <p>Mega langt klan navn som der ikke er plads til</p>
                </div>
        	</div>
        </td>
		<td rowspan="2"><img src="../global/css/img/collecting_top16_left.png" class="collecting_top16 collecting_left" /></td>
		<td rowspan="2">
        	<div class="bracket_match left_side">
            	<div class="bracket_match_team1">
                <img src="#team1_logo" />
                <p>S A D B O Y S</p>
                </div>
                <div class="bracket_match_team2">
                <img src="#team2_logo" />
                <p>Mega langt klan navn som der ikke er plads til</p>
                </div>
        	</div>
        </td>
		<td rowspan="4"><img src="../global/css/img/collecting_top8_left.png" class="collecting_top8 collecting_left" /></td>
		<td colspan="3">
        	<div class="bracket_match top4">
            	<div class="bracket_match_team1">
                <img src="#team1_logo" />
                <p>S A D B O Y S</p>
                </div>
                <div class="bracket_match_team2">
                <img src="#team2_logo" />
                <p>Mega langt klan navn som der ikke er plads til</p>
                </div>
        	</div>
        </td>
		<td rowspan="4"><img src="../global/css/img/collecting_top8_right.png" class="collecting_top8 collecting_right" /></td>
		<td rowspan="2">
        	<div class="bracket_match left_side">
            	<div class="bracket_match_team1">
                <img src="#team1_logo" />
                <p>S A D B O Y S</p>
                </div>
                <div class="bracket_match_team2">
                <img src="#team2_logo" />
                <p>Mega langt klan navn som der ikke er plads til</p>
                </div>
        	</div>
        </td>
        <td rowspan="2"><img src="../global/css/img/collecting_top16_right.png" class="collecting_top16 collecting_right" /></td>
        <td>
        	<div class="bracket_match left_side">
            	<div class="bracket_match_team1">
                <img src="#team1_logo" />
                <p>S A D B O Y S</p>
                </div>
                <div class="bracket_match_team2">
                <img src="#team2_logo" />
                <p>Mega langt klan navn som der ikke er plads til</p>
                </div>
        	</div>
        </td>
	</tr>
	<tr>
		<td>
        	<div class="bracket_match left_side">
            	<div class="bracket_match_team1">
                <img src="#team1_logo" />
                <p>S A D B O Y S</p>
                </div>
                <div class="bracket_match_team2">
                <img src="#team2_logo" />
                <p>Mega langt klan navn som der ikke er plads til</p>
                </div>
        	</div>
        </td>
		<td rowspan="2">
        	<div class="bracket_match left_side">
            	<div class="bracket_match_team1">
                <img src="#team1_logo" />
                <p>S A D B O Y S</p>
                </div>
                <div class="bracket_match_team2">
                <img src="#team2_logo" />
                <p>Mega langt klan navn som der ikke er plads til</p>
                </div>
        	</div>
        </td>
		<td rowspan="2"><img src="../global/css/img/collecting_top4.png" class="collecting_top4" /></td>
		<td rowspan="2">
        	<div class="bracket_match left_side">
            	<div class="bracket_match_team1">
                <img src="#team1_logo" />
                <p>S A D B O Y S</p>
                </div>
                <div class="bracket_match_team2">
                <img src="#team2_logo" />
                <p>Mega langt klan navn som der ikke er plads til</p>
                </div>
        	</div>
        </td>
		<td>
        	<div class="bracket_match left_side">
            	<div class="bracket_match_team1">
                <img src="#team1_logo" />
                <p>S A D B O Y S</p>
                </div>
                <div class="bracket_match_team2">
                <img src="#team2_logo" />
                <p>Mega langt klan navn som der ikke er plads til</p>
                </div>
        	</div>
        </td>
	</tr>
	<tr>
		<td>
        	<div class="bracket_match left_side">
            	<div class="bracket_match_team1">
                <img src="#team1_logo" />
                <p>S A D B O Y S</p>
                </div>
                <div class="bracket_match_team2">
                <img src="#team2_logo" />
                <p>Mega langt klan navn som der ikke er plads til</p>
                </div>
        	</div>
        </td>
		<td rowspan="2"><img src="../global/css/img/collecting_top16_left.png" class="collecting_top16 collecting_left" /></td>
		<td rowspan="2">
        	<div class="bracket_match left_side">
            	<div class="bracket_match_team1">
                <img src="#team1_logo" />
                <p>S A D B O Y S</p>
                </div>
                <div class="bracket_match_team2">
                <img src="#team2_logo" />
                <p>Mega langt klan navn som der ikke er plads til</p>
                </div>
        	</div>
        </td>
		<td rowspan="2">
        	<div class="bracket_match left_side">
            	<div class="bracket_match_team1">
                <img src="#team1_logo" />
                <p>S A D B O Y S</p>
                </div>
                <div class="bracket_match_team2">
                <img src="#team2_logo" />
                <p>Mega langt klan navn som der ikke er plads til</p>
                </div>
        	</div>
        </td>
        <td rowspan="2"><img src="../global/css/img/collecting_top16_right.png" class="collecting_top16 collecting_right" /></td>
        <td>
        	<div class="bracket_match left_side">
            	<div class="bracket_match_team1">
                <img src="#team1_logo" />
                <p>S A D B O Y S</p>
                </div>
                <div class="bracket_match_team2">
                <img src="#team2_logo" />
                <p>Mega langt klan navn som der ikke er plads til</p>
                </div>
        	</div>
        </td>
	</tr>
	<tr>
		<td>
        	<div class="bracket_match left_side">
            	<div class="bracket_match_team1">
                <img src="#team1_logo" />
                <p>S A D B O Y S</p>
                </div>
                <div class="bracket_match_team2">
                <img src="#team2_logo" />
                <p>Mega langt klan navn som der ikke er plads til</p>
                </div>
        	</div>
        </td>
		<td colspan="3"></td>
		<td>
        	<div class="bracket_match left_side">
            	<div class="bracket_match_team1">
                <img src="#team1_logo" />
                <p>S A D B O Y S</p>
                </div>
                <div class="bracket_match_team2">
                <img src="#team2_logo" />
                <p>Mega langt klan navn som der ikke er plads til</p>
                </div>
        	</div>
        </td>
	</tr>
</table>



                
                
                
                
                <!-- BRACKET TABLES END HERE -->
                </div>
            </div>
            <!-- Teams Upcoming matches Latest results -->
            <!-- Teams -->
            <div class="td_teams td_block">
            	<div class="td_heading">
                	<h1>Teams</h1>
                </div>
                <div class="td_team_content">
                	<div class="team">
                        <a class="nodec" href="#go_to_team_page">
                            <span class="img_container team_img"><img src="../global/css/img/temporary_team1.png" /></span>
                            <span class="img_container"><h3>Cloud 9 HyperX</h3></span>
                        </a>
                    </div>
                    <div class="team">
                        <a class="nodec" href="#go_to_team_page">
                            <span class="img_container team_img"><img src="../global/css/img/temporary_team2.png" /></span>
                            <span class="img_container"><h3>fnat1c</h3></span>
                        </a>
                    </div>
                    <div class="team">
                        <a class="nodec" href="#go_to_team_page">
                            <span class="img_container team_img"><img src="../global/css/img/temporary_team1.png" /></span>
                            <span class="img_container"><h3>Schroet Kommando</h3></span>
                        </a>
                    </div>
                    <div class="team">
                        <a class="nodec" href="#go_to_team_page">
                            <span class="img_container team_img"><img src="../global/css/img/temporary_team2.png" /></span>
                            <span class="img_container"><h3>Meet Your Makers</h3></span>
                        </a>
                    </div>
                    <div class="team">
                        <a class="nodec" href="#go_to_team_page">
                            <span class="img_container team_img"><img src="../global/css/img/temporary_team1.png" /></span>
                            <span class="img_container"><h3>4Kings</h3></span>
                        </a>
                    </div>
                    <div class="team">
                        <a class="nodec" href="#go_to_team_page">
                            <span class="img_container team_img"><img src="../global/css/img/temporary_team1.png" /></span>
                            <span class="img_container"><h3>4Kings</h3></span>
                        </a>
                    </div>
                </div>
            </div>
            <!-- Upcoming matches -->
            <div class="td_upcoming td_block">
            	<div class="td_heading">
                	<h1><?php echo $this->__('Upcoming matches') ?></h1>
                </div>
                <div class="td_team_content">
                	<div class="upcoming_match">
                    	<span class="img_container"><a href="#go_to_team_page"><img src="../global/css/img/temporary_team1.png" /></a></span>
                        <span class="img_container vs"><img src="../global/css/img/upcomingmatch_vs.png" /></span>
                        <span class="img_container"><a href="#go_to_team_page"><img src="../global/css/img/temporary_team2.png" /></a></span>
                    </div>
                    <div class="upcoming_match">
                    	<span class="img_container"><a href="#go_to_team_page"><img src="../global/css/img/temporary_team1.png" /></a></span>
                        <span class="img_container vs"><img src="../global/css/img/upcomingmatch_vs.png" /></span>
                        <span class="img_container"><a href="#go_to_team_page"><img src="../global/css/img/temporary_team2.png" /></a></span>
                    </div>
                    <div class="upcoming_match">
                    	<span class="img_container"><a href="#go_to_team_page"><img src="../global/css/img/temporary_team1.png" /></a></span>
                        <span class="img_container vs"><img src="../global/css/img/upcomingmatch_vs.png" /></span>
                        <span class="img_container"><a href="#go_to_team_page"><img src="../global/css/img/temporary_team2.png" /></a></span>
                    </div>
                    <div class="upcoming_match">
                    	<span class="img_container"><a href="#go_to_team_page"><img src="../global/css/img/temporary_team1.png" /></a></span>
                        <span class="img_container vs"><img src="../global/css/img/upcomingmatch_vs.png" /></span>
                        <span class="img_container"><a href="#go_to_team_page"><img src="../global/css/img/temporary_team2.png" /></a></span>
                    </div>
                    <div class="upcoming_match">
                    	<span class="img_container"><a href="#go_to_team_page"><img src="../global/css/img/temporary_team1.png" /></a></span>
                        <span class="img_container vs"><img src="../global/css/img/upcomingmatch_vs.png" /></span>
                        <span class="img_container"><a href="#go_to_team_page"><img src="../global/css/img/temporary_team2.png" /></a></span>
                    </div>
                    <div class="upcoming_match">
                    	<span class="img_container"><a href="#go_to_team_page"><img src="../global/css/img/temporary_team1.png" /></a></span>
                        <span class="img_container vs"><img src="../global/css/img/upcomingmatch_vs.png" /></span>
                        <span class="img_container"><a href="#go_to_team_page"><img src="../global/css/img/temporary_team2.png" /></a></span>
                    </div>
                </div>
            </div>
            <!-- Latest results -->
            <div class="td_latest td_block">
            	<div class="td_heading">
                	<h1><?php echo $this->__('Latest results') ?></h1>
                </div>
                <div class="td_team_content">
                	<div class="latest_result" style="background-image: url('../global/css/img/latestresults_winner_left.png');"> <!-- billedet "latestresults_winner_right.png", viser holdet til højre som vinder. Og self venstre hold som vinder med billede "_left.png" :DD -->
                    	<a href="#go_to_team_page"><span class="img_container left_team"><img src="../global/css/img/temporary_team2.png" /></span></a>
                        <a href="#go_to_team_page"><span class="img_container right_team"><img src="../global/css/img/temporary_team1.png" /></span></a>
                    </div>
                    <div class="latest_result" style="background-image: url('../global/css/img/latestresults_winner_right.png');"> <!-- billedet "latestresults_winner_right.png", viser holdet til højre som vinder. Og self venstre hold som vinder med billede "_left.png" :DD -->
                    	<a href="#go_to_team_page"><span class="img_container left_team"><img src="../global/css/img/temporary_team2.png" /></span></a>
                        <a href="#go_to_team_page"><span class="img_container right_team"><img src="../global/css/img/temporary_team1.png" /></span></a>
                    </div>
                    <div class="latest_result" style="background-image: url('../global/css/img/latestresults_winner_right.png');"> <!-- billedet "latestresults_winner_right.png", viser holdet til højre som vinder. Og self venstre hold som vinder med billede "_left.png" :DD -->
                    	<a href="#go_to_team_page"><span class="img_container left_team"><img src="../global/css/img/temporary_team2.png" /></span></a>
                        <a href="#go_to_team_page"><span class="img_container right_team"><img src="../global/css/img/temporary_team1.png" /></span></a>
                    </div>
                    <div class="latest_result" style="background-image: url('../global/css/img/latestresults_winner_left.png');"> <!-- billedet "latestresults_winner_right.png", viser holdet til højre som vinder. Og self venstre hold som vinder med billede "_left.png" :DD -->
                    	<a href="#go_to_team_page"><span class="img_container left_team"><img src="../global/css/img/temporary_team2.png" /></span></a>
                        <a href="#go_to_team_page"><span class="img_container right_team"><img src="../global/css/img/temporary_team1.png" /></span></a>
                    </div>
                    <div class="latest_result" style="background-image: url('../global/css/img/latestresults_winner_right.png');"> <!-- billedet "latestresults_winner_right.png", viser holdet til højre som vinder. Og self venstre hold som vinder med billede "_left.png" :DD -->
                    	<a href="#go_to_team_page"><span class="img_container left_team"><img src="../global/css/img/temporary_team2.png" /></span></a>
                        <a href="#go_to_team_page"><span class="img_container right_team"><img src="../global/css/img/temporary_team1.png" /></span></a>
                    </div>
                    <div class="latest_result" style="background-image: url('../global/css/img/latestresults_winner_right.png');"> <!-- billedet "latestresults_winner_right.png", viser holdet til højre som vinder. Og self venstre hold som vinder med billede "_left.png" :DD -->
                    	<a href="#go_to_team_page"><span class="img_container left_team"><img src="../global/css/img/temporary_team2.png" /></span></a>
                        <a href="#go_to_team_page"><span class="img_container right_team"><img src="../global/css/img/temporary_team1.png" /></span></a>
                    </div>
                </div>
            </div>
		</div>
		<!-- E-Sports content end -->
	</div>
	<!-- Main content end -->
</div>
<!-- Main container end -->