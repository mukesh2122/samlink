<?php
	$rating = $player->SocialRating;
	$rating_round = round($rating);
	$enabled = 'enabled';
?>
<div class="profile_rating subtle_grey clearfix <?php echo $enabled ? 'enabled' : 'disabled'; ?>">
	<div class="stars_rating">
        <span class="profile_rating_head"><?php echo $this->__('Rating'); ?>:</span>
		<ul>
			<?php for($i = 1; $i <= $rating_round; $i++): ?>
			<li class="clearfix icon_star_filled ratingStar star<?php echo $i; ?> <?php echo $i == $rating_round ? 'starCurrentSelected' : '' ?>"><input type="hidden" id="stars" value="<?php echo $i; ?>" />&nbsp;</li>
			<?php endfor; ?>

			<?php for($i = 1; $i <= 5 - $rating_round; $i++): ?>
			<li class="clearfix icon_star_empty ratingStar star<?php echo $rating_round + $i; ?>"><input type="hidden" id="stars" value="<?php echo $rating_round + $i; ?>" />&nbsp;</li>
			<?php endfor; ?>
		</ul>
	</div>
</div>