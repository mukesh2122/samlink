<?php
	$listOfComingGames = MainHelper::getComingGames();
?>
<div class="widget coming-games" data-state="<?php echo ($isOpen == 1) ? 'open' : 'closed'; ?>" data-id="<?php echo $widgetId; ?>">
	<div class="top">
		<h3><?php echo $widgetName; ?></h3>
		<span class="slide-icon" title="<?php echo ($isOpen == 1) ? 'Collapse' : 'Expand'; ?> this widget.">&#9660;</span>
		<span class="close-icon" title="Hide this widget.">X</span>
	</div>
	<ul class="widget-body list-of-items">
		<?php
			if (empty($listOfComingGames)) { ?>
				<li>
					<p>No coming games.</p>
				</li>
			<?php 
			} else {
				foreach ($listOfComingGames as $game) { ?>
					<li>
						<div class="game-image">
							<a href="<?php echo $game->GAME_URL; ?>">
								<?php echo MainHelper::showImage($game, THUMB_LIST_40x40, false, array('no_img' => 'noimage/no_game_40x40.png')); ?>
							</a>
						</div>
						<h4><a href="<?php echo $game->GAME_URL; ?>" title="<?php echo $this->__($game->GameName); ?>"><?php echo $this->__($game->GameName); ?></a></h4>
						<p><span><?php echo $this->__('Game type'); ?></span>: <?php echo ($game->GameType == '') ? 'Unknown' : $game->GameType; ?></p>
						<p><span><?php echo $this->__('Release date'); ?></span>: <?php echo $game->CreationDate; ?></p>
						<div class="clearfix"></div>
					</li>
					<?php
				}
			}
		?>
	</ul>
</div>