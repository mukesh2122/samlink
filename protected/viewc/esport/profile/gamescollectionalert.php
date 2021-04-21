<div class="esport_infobox esport_widget p10 m15 esport_link_red">
<?php
	$player = $profile['player'];
	$ID_TEAM = $player->ID_TEAM;
	if ($ID_TEAM==0)
	{
		?>
                        <div>
			<span class="fcw mr5">
				<?php echo $this->__('You have no eSport profile or game collection'); ?>.<br/>
				<a href="<?php echo MainHelper::site_url('esport/addgamescollection'); ?>">
					<?php echo $this->__('Add your game collection here and become eSport player'); ?>
				</a>
			</span>
                        </div>
		<?php
	}
	else
	{
		$myEgames = $profile['games'];
		$games = new Games();
                $esport = new Esport();
		$mygames = $games->getPlayerGames($player,100000);
		foreach ($mygames as $game)
		{
			$isESportGame = $game->isESportGame;
			//echo $game->ID_GAME . " " . $game->GameName;
			if ($isESportGame)
			{
				$found = false;
				foreach ($myEgames as $myg)
				{
					if ($myg['FK_GAME']==$game->ID_GAME)
						$found = true;
				}
				//echo (($game->isESportGame) ? '(Is Esport!)' : "");
				if (!$found)
				{
                                        echo "<div>";
					echo "<span class='mr5 fcw'><strong>".$game->GameName . "</strong> " . $this->__('is not on your eSports game list') . ".</span>";
					echo '<a href="'.MainHelper::site_url('esport/addgametocollection/'.$game->ID_GAME).'">'.$this->__('Add game to list').'</a><br/>';
                                        echo "</div>";
				}
			}
		}
                
                $pendingTeams = $esport->getTeamRelations($ID_TEAM,$isPending = true);
                
                foreach ($pendingTeams as $team){
                    echo "<div>";
                    echo "<span class='mr5 fcw'>".$this->__('You have a pending team request from')." <strong>".$team->DisplayName."</strong></span>";
                    echo '<a class="mr5" href="'.MainHelper::site_url('esport/teamrequestrespond/accept/'.$team->ID_TEAM).'">'.$this->__('Accept').'</a>';
                    echo '<a href="'.MainHelper::site_url('esport/teamrequestrespond/reject/'.$team->ID_TEAM).'">'.$this->__('Reject').'</a><br/>';
                    echo "</div>";
                }

	}
?>
</div>
