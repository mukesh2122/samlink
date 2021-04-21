<?php
	$teamID = $player->ID_TEAM;
	$listOfScheduledGames = '';

	if ($teamID > 0) {
		$listOfScheduledGames = MainHelper::getListOfMatches($teamID);
	}
?>
<div class="widget scheduled-games" data-state="<?php echo ($isOpen == 1) ? 'open' : 'closed'; ?>" data-id="<?php echo $widgetId; ?>">
	<div class="top">
		<h3><?php echo $widgetName; ?></h3>
		<span class="slide-icon" title="<?php echo ($isOpen == 1) ? 'Collapse' : 'Expand'; ?> this widget.">&#9660;</span>
		<span class="close-icon" title="Hide this widget.">X</span>
	</div>
	<ul class="widget-body list-of-items">
		<?php if ($teamID == 0) { ?>
			<li>
				<p>You have to be a member of <a href="<?php echo MainHelper::site_url('esport'); ?>">eSport</a> in order to see your scheduled games.</p>
			</li>
		<?php } else {
				if (empty($listOfScheduledGames)) { ?>
					<li>
						<p>No scheduled games.</p>
					</li>
				<?php 
				} else {
					foreach ($listOfScheduledGames as $game) { 
						$gameInfo = MainHelper::getGameInfo($game['FK_GAME']);
						$challengerTeam = MainHelper::getTeamInfo($game['ChallengerID']);
						$opponentTeam = MainHelper::getTeamInfo($game['OpponentID']);
						?>
						<li>
							<h4><a href="<?php echo MainHelper::site_url('game-overview'); ?>"><?php echo ($challengerTeam === false) ? 'Unknown' : $challengerTeam->DisplayName; echo $this->__(' vs. '); echo ($opponentTeam === false) ? 'Unknown' : $opponentTeam->DisplayName; ?></a></h4>
							<p><span><?php echo $this->__('Starts'); ?></span>: <?php echo date('h:m d-m-Y', $game['StartTime']); ?></p>
							<div class="game-image">
								<a href="<?php echo $gameInfo->GAME_URL; ?>">
									<?php echo MainHelper::showImage($gameInfo, THUMB_LIST_40x40, false, array('no_img' => 'noimage/no_game_40x40.png')); ?>
								</a>
							</div>
							<p><span><?php echo $this->__('Game'); ?></span>: <?php echo $this->__($gameInfo->GameName); ?></p>
							<p><span><?php echo $this->__('League'); ?></span>: <?php echo $game['LeagueName']; ?></p>
							<div class="clearfix"></div>
						</li>
						<?php
					}
				}
			}
		?>
	</ul>
</div>