<?php if($item->RatingTop > 0 or $item->RatingPop > 0):?>
	<div class="list_item_rating">
		<?php if($item->RatingPop > 0):?>
			<span class="list_item_rating_pop"><?php echo $item->RatingPop;?></span>
		<?php endif; ?>

		<?php if($item->RatingTop > 0):?>
			<span class="list_item_rating_top"><?php echo $item->RatingTop;?></span>
		<?php endif; ?>
	</div>
<?php endif; ?>