<?php
	$tournaments = $profile['tournaments'];
        $class = $profile['attendedTournaments'] > 9 ? 'tournaments_wscroller' : '';
?>
<div id="esports_profile_tournaments" class="esport_widget">
	<div class="esport_profile_boxheaders"><p><?php echo $this->__('Tournaments attended'); ?></p></div>
        <div id="esports_tournaments_boxcontainer" class="<?php echo $class; ?>">
	<?php 
                echo isset($tournaments) && !empty($tournaments) ? '' : '<div class="ml15 mt10">'.$this->__('No tournaments attended yet').'</div>';
		foreach ($tournaments as $tournament)
		{
			$game = Games::getGameByID($tournament['ID_GAME']);
			?>
			<div class="attended_tournament">
				<p class="mb5"><?php echo date('d-m-Y H:i',$tournament['StartTime']); ?></p>
				<a href="<?php echo MainHelper::site_url('esport/tournamentinfo/'.$tournament['ID_LEAGUE']); ?>">
				<?php echo MainHelper::showImage($game, THUMB_LIST_60x60, false, array('no_img' => 'noimage/no_game_60x60.png')); ?>
				<p><?php echo $tournament['LeagueName']; ?></p>
				</a>
			</div>
			<?php
		}
	?>
        </div>
</div>