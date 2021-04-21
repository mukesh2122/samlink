<?php
?>

<div class="esports_right_column">
	<!-- Header start -->
	<div id="news_header">
		<img src="<?php echo MainHelper::site_url('global/img/icon.png');?>" alt=""/>
		<span>Tournaments</span>

            <!-- Game search start -->
            <div id="tournamentSearch" class="esport_search">
            <form action="<?php echo MainHelper::site_url('esport/tournaments'); ?>" id="tournament_search inside_search" method="post">
                                            <input id="searchstring" name="searchstring" class="esport_search_input inside_search" type="text" title="<?php echo $this->__('Search tournaments'); ?>" value="<?php echo $this->__('Search tournaments'); ?>" />
                                            <input type="submit" value="<?php echo $this->__('Search'); ?>" class="esport_search_button light_blue" />
                                    </form>
            </div>	
        </div>
	<!-- Header end -->
	<!-- Playnation tournaments start -->
        <?php $tournamentsFree = $profile['tournamentsFree']; ?>
        <?php echo $this->renderBlock('esport/tournaments/tournamentList', array('title'=>$this->__('Current Playnation tournaments Free2Play'),'tournamentsList' => $tournamentsFree)); ?>

        <?php $tournamentsCredits = $profile['tournamentsCredits']; ?>
        <?php echo $this->renderBlock('esport/tournaments/tournamentList', array('title'=>$this->__('Current Playnation tournaments Credits'),'tournamentsList' => $tournamentsCredits)); ?>

        <?php $tournamentsCoins = $profile['tournamentsCoins']; ?>
        <?php echo $this->renderBlock('esport/tournaments/tournamentList', array('title'=>$this->__('Current Playnation tournaments Coins'),'tournamentsList' => $tournamentsCoins)); ?>
	<!-- Playnation tournaments end -->

	<?php if(1==2):?>
	<!-- Professional tournaments start -->
	<div id="pro_tournaments_list">
		<span class="tournament_top">Current professional tournaments</span>
		<ul class="tournament_list">
			<li class="game_lol">
				<img src="http://localhost/beta/global/img/esport/test/tournaments/game_lol.png"/>
				<h1>Tournament Name</h1>
				<h2>Hosted by: Host</h2>
				<h3>1/1/2014
				<br/>Start-time: 20:00 CET</h3>
				<div class="tournament_sponsors">
					<a href="#"><img src="http://localhost/beta/global/img/esport/test/tournaments/sponsor_razer.png"/></a>
					<a href="#"><img src="http://localhost/beta/global/img/esport/test/tournaments/sponsor_intel.png"/></a>
				</div>
				<div class="tournament_buttons pro_tournament_buttons">
					<a href="#">Watch now</a><br/><!-- Watch now takes you to coverage-site -->
					<a href="#">Bet live</a><!-- Bet live takes you to betting-site -->
				</div>
			</li>
			<li class="game_starcraft">
				<img src="http://localhost/beta/global/img/esport/test/tournaments/game_starcraft.png"/>
				<h1>Tournament Name</h1>
				<h2>Hosted by: Host</h2>
				<h3>1/1/2014
				<br/>Start-time: 20:00 CET</h3>
				<div class="tournament_buttons pro_tournament_buttons">
					<a href="#">Watch now</a><br/>
					<a href="#">Bet live</a>
				</div>
			</li>
			<li class="game_cod">
				<img src="http://localhost/beta/global/img/esport/test/tournaments/game_cod.png"/>
				<h1>Tournament Name</h1>
				<h2>Hosted by: Host</h2>
				<h3>1/1/2014
				<br/>Start-time: 20:00 CET</h3>
				<div class="tournament_buttons pro_tournament_buttons">
					<a href="#">Watch now</a><br/>
					<a href="#">Bet live</a>
				</div>
			</li>
		</ul>
	</div>
	<!-- Professional tournaments end -->
	<!-- Playnation tournaments start -->
	<div id="pn_tournaments_list">
		<span class="tournament_top">Current Playnation tournaments</span>
		<ul class="tournament_list">
			<li class="game_lol">
				<img src="http://localhost/beta/global/img/esport/test/tournaments/game_lol.png"/>
				<h1>Tournament Name</h1>
				<h2>Hosted by: Host</h2>
				<h3>1/1/2014
				<br/>Start-time: 20:00 CET</h3>
				<div class="tournament_buttons">
					<span>Join this tournament:</span>
					<a href="esports_tournament_example.htm">Information</a>
				</div>
			</li>
			<li class="game_starcraft">
				<img src="http://localhost/beta/global/img/esport/test/tournaments/game_starcraft.png"/>
				<h1>Tournament Name</h1>
				<h2>Hosted by: Host</h2>
				<h3>1/1/2014
				<br/>Start-time: 20:00 CET</h3>
				<div class="tournament_buttons">
					<span>Join this tournament:</span>
					<a href="#">Information</a>
				</div>
			</li>
			<li class="game_cod">
				<img src="http://localhost/beta/global/img/esport/test/tournaments/game_cod.png"/>
				<h1>Tournament Name</h1>
				<h2>Hosted by: Host</h2>
				<h3>1/1/2014
				<br/>Start-time: 20:00 CET</h3>
				<div class="tournament_buttons">
					<span>Join this tournament:</span>
					<a href="#">Information</a>
				</div>
			</li>
		</ul>
	</div>
	<!-- Playnation tournaments end -->
	<?php endif; ?>
</div>
