<?php
	$player = $profile['player'];
	$FK_TEAM = $player->ID_TEAM;
	$games = $profile['games'];
?>

<!-- Game chooser begins -->
<!--<div id="game_chooser">
	<h2><?php //echo $this->__('Choose game'); ?></h2>

	<div id="game_chooser_selector">
		 To see the rankings of different games 

				<select onchange="playquickmatch.href='<?php //echo MainHelper::site_url('esport/playquickmatch/'); ?>'+this.value;" id="gamechooser" class="" name="gamechooser" style="width:160px;">
				<?php
					/*foreach ($games as $game)
					{
						echo '<option value="'.$game['ID_GAME'].'">'.$game['GameName'].'</option>';
					}*/
				?>
				</select>
		<?php
			//$ID_GAME_0 = (count($games)>0) ? $games[0]['ID_GAME'] : 0;
		?>

	</div>
	
	<a id="playquickmatch" rel="iframe" class="" href="<?php //echo MainHelper::site_url('esport/playquickmatch/'.$ID_GAME_0); ?>"><?php //echo $this->__('Play Quick Match'); ?></a>
</div>-->
<!-- Game chooser ends -->


				



<div id="game_chooser">
	<h2><?php echo $this->__('Active Matches'); ?></h2>
		<?php

/*			foreach ($games as $game)
			{
				echo "<b>{$game['GameName']}</b><br/>";
				
				$FK_GAME = $game['FK_GAME'];

				$gameRatings = $game['GameRatings'];
				echo " - matchedplayedF2p: {$gameRatings['matchesplayedF2p']}<br/>";
				echo " - matchedplayedCredits: {$gameRatings['matchesplayedCredits']}<br/>";
				echo " - matchedplayedCoins: {$gameRatings['matchesplayedCoins']}<br/>";
				echo " - ratingF2p: {$gameRatings['ratingF2p']}<br/>";
				echo " - ratingCredits: {$gameRatings['ratingCredits']}<br/>";
				echo " - ratingCoins: {$gameRatings['ratingCoins']}<br/>";
				echo " - totalMatchesPlayed: {$gameRatings['totalMatchesPlayed']}<br/>";
				echo " - gameRating: {$gameRatings['gameRating']}<br/>";

			}
*/

		//Test show active matches
		$esport = new Esport();
		$active = $esport->GetMatchState('Active');
		$open = $esport->GetMatchState('Open');

		$query = "SELECT * FROM es_matches 
			LEFT JOIN es_leagues ON es_leagues.ID_LEAGUE = es_matches.FK_LEAGUE 
			LEFT JOIN es_teams ON es_teams.ID_TEAM = es_matches.ChallengerID 
			LEFT JOIN sn_games ON sn_games.ID_GAME = es_leagues.FK_GAME 
			WHERE es_matches.OpponentID=$FK_TEAM AND es_matches.State & $active";
		$challengedMatches = Doo::db()->query($query)->fetchall();
		//echo "<p>";
		//echo "<b>Active matches as Opponent:</b><br/>";
		foreach ($challengedMatches as $cm)
		{
			echo '<div class="esports_match">';
				echo '<div class="user_info_item clearfix">';
					echo '<span class="user_info_vr">Game:</span>';
					echo '<span class="user_info_vl">'.$cm['GameName'].'</span>';
				echo '</div>';
				echo '<div class="user_info_item clearfix">';
					echo '<span class="user_info_vr">Opponent:</span>';
					echo '<span class="user_info_vl">'.$cm['DisplayName'].'</span>';
				echo '</div>';
                echo '<div class="user_info_item clearfix">';
                    echo '<span class="user_info_vr">Type:</span>';
                    echo '<span class="user_info_vl">'.$cm['LeagueName'].'</span>';
                echo '</div>';
                echo '<div class="user_info_item clearfix">';
					echo '<a id="playquickmatch" rel="iframe" class="" href="'.MainHelper::site_url('esport/reportmatchresult/'.$cm['ID_MATCH'].'/'.$FK_TEAM).'">Report result</a>';
                echo '</div>';
            echo '</div>';
/*			echo "Game: {$cm['GameName']}<br/>, League: {$cm['LeagueName']}<br/>, challenged by: {$cm['DisplayName']} ({$cm['ChallengerID']})";
			echo "<br/>";
			echo "My rating: {$cm['OpponentRatingBefore']}  Other rating: {$cm['ChallengerRatingBefore']}";
			echo "<br/>";
			echo '<a id="playquickmatch" rel="iframe" class="" href="'.MainHelper::site_url('esport/reportmatchresult/'.$cm['ID_MATCH'].'/'.$FK_TEAM).'">Report result</a>';
			echo "</div>";*/
		}
		//echo "</p>";

		$query = "SELECT * FROM es_matches 
			LEFT JOIN es_leagues ON es_leagues.ID_LEAGUE = es_matches.FK_LEAGUE 
			LEFT JOIN es_teams ON es_teams.ID_TEAM = es_matches.OpponentID 
			LEFT JOIN sn_games ON sn_games.ID_GAME = es_leagues.FK_GAME 
			WHERE es_matches.ChallengerID=$FK_TEAM AND es_matches.State & $active";
		$challengedMatches = Doo::db()->query($query)->fetchall();
		//echo "<br/><p>";
		//echo "<b>Active matches as Challenger:</b><br/>";
		foreach ($challengedMatches as $cm)
		{
			echo '<div class="esports_match">';
				echo '<div class="user_info_item clearfix">';
					echo '<span class="user_info_vr">Game:</span>';
					echo '<span class="user_info_vl">'.$cm['GameName'].'</span>';
				echo '</div>';
				echo '<div class="user_info_item clearfix">';
					echo '<span class="user_info_vr">Opponent:</span>';
					echo '<span class="user_info_vl">'.$cm['DisplayName'].'</span>';
				echo '</div>';
                echo '<div class="user_info_item clearfix">';
                    echo '<span class="user_info_vr">Type:</span>';
                    echo '<span class="user_info_vl">'.$cm['LeagueName'].'</span>';
                echo '</div>';
                echo '<div class="user_info_item clearfix">';
					echo '<a id="playquickmatch" rel="iframe" class="" href="'.MainHelper::site_url('esport/reportmatchresult/'.$cm['ID_MATCH'].'/'.$FK_TEAM).'">Report result</a>';
                echo '</div>';
            echo '</div>';
/*			echo '<div class="esports_match">';
			echo "<b>Game:</b> {$cm['GameName']}<br/>, <b>League:</b> {$cm['LeagueName']}<br/>, <b>challenged by:</b> {$cm['DisplayName']} ({$cm['ChallengerID']})";
			echo "<br/>";
			echo "My rating: {$cm['ChallengerRatingBefore']}  Other rating: {$cm['OpponentRatingBefore']}";
			echo "<br/>";
			echo '<a id="playquickmatch" rel="iframe" class="" href="'.MainHelper::site_url('esport/reportmatchresult/'.$cm['ID_MATCH'].'/'.$FK_TEAM).'">Report result</a>';
			echo "</div>";*/
		}
		//echo "</p>";
		
		
		
		$query = "SELECT * FROM es_matches 
			LEFT JOIN es_leagues ON es_leagues.ID_LEAGUE = es_matches.FK_LEAGUE 
			LEFT JOIN sn_games ON sn_games.ID_GAME = es_leagues.FK_GAME 
			WHERE es_matches.ChallengerID=$FK_TEAM AND es_matches.State & $open";
		$opponentMatches = Doo::db()->query($query)->fetchall();
		//echo "<br/><p>";
		//echo "<b>My open matches as Challenger(no opponents yet):</b><br/>";
		foreach ($opponentMatches as $cm)
		{
			echo '<div class="esports_match">';
				echo '<div class="user_info_item clearfix">';
					echo '<span class="user_info_vr">Game:</span>';
					echo '<span class="user_info_vl">'.$cm['GameName'].'</span>';
				echo '</div>';
				echo '<div class="user_info_item clearfix">';
					echo '<span class="user_info_vr">Opponent:</span>';
					echo '<span class="user_info_vl">'.$this->__('No opponent yet').'</span>';
				echo '</div>';
                echo '<div class="user_info_item clearfix">';
                    echo '<span class="user_info_vr">Type:</span>';
                    echo '<span class="user_info_vl">'.$cm['LeagueName'].'</span>';
                echo '</div>';
            echo '</div>';

/*			echo '<div class="esports_match">';
			echo "<b>Game:</b> {$cm['GameName']},<br/><b>League:</b> {$cm['LeagueName']},";
			echo "</div>";*/
		}
		//echo "</p>";

		?>
</div>
