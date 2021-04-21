<?php 
    $matchHistory = $profile['matchHistory'];
    $class = $matchHistory['total'] > 6 ? 'wscroller' : ''; 

?>
<div id="esports_latest_games" class="<?php echo $class; ?> esport_widget">
    <div class="esport_profile_boxheaders"><p><?php echo $this->__('Match history'); ?></p></div>
        <div id="esports_latest_games_gamecontainer">
        <ul>
	<?php 	
		$p = $profile['player'];
                $items = 0;
		$teams = $profile['teams'];
                echo isset($matchHistory) && !empty($matchHistory) ? '' : '<div class="ml15 mt10">'.$this->__('No matches played yet').'</div>';
		foreach ($matchHistory as $match)
		{
                    if(isset($match['gamename'])){
                        $game = new SnGames();
                        $game->ImageURL = $match['img'];
			echo '<li class="latestGameBlock">';
			echo MainHelper::showImage($game, THUMB_LIST_40x40, false, array('no_img' => 'noimage/no_game_40x40.png'));
			echo '<p class="result">' . $match['result'] . '</p>';
			echo '<span><p class="gamename">' . $match['gamename'] . '</p><br/>';
			echo ''.$match['score'] . '<br/><br/>';
			echo date('d-m-Y',$match['time']);
                        echo '</span>
                    </li>';
                    }
		}
	?>
	</ul>
        </div>
</div>