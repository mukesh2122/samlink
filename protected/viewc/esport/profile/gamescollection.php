<div id="game_col_slider">
	<p><?php //echo $this->__('Game Collection').':'; ?></p>
	<div id="gcs_games"style="overflow:auto;">
		<?php
		$myEgames = $profile['games'];
		foreach ($myEgames as $game)
		{
			$Gamename = $game['GameName'];
			$ImageURL = $game['ImageURL'];

			$game = Games::getGameByID($game['ID_GAME']);
			echo '<a target="_blank" title="'.$Gamename.'" href="'.$game->URL.'">'.
				MainHelper::showImage($game, THUMB_LIST_95x95, false, array('no_img' => 'noimage/no_game_95x95.png')).
				'</a>';
		}
		?>
	</div>
</div>