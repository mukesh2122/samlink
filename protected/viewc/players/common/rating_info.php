<?php
$ratingInf = "";
$ratingInfClass = round($user->SocialRating) <= 2 ? 'fcr' : 'fcgr';
if(!$vote){
	switch(round($user->SocialRating)){
		case 1:
			$ratingInf = "Bad";
			break;

		case 2:
			$ratingInf = "Medium";
			break;

		case 3:
			$ratingInf = "Average";
			break;

		case 4:
			$ratingInf = "Good";
			break;

		case 5:
			$ratingInf = "Super!";
			break;

		default:
			$ratingInf = "None";
			break;
	}
}
else{
	switch($vote){
		case 1:
			$ratingInf = "Bad";
			break;

		case 2:
			$ratingInf = "Medium";
			break;

		case 3:
			$ratingInf = "Average";
			break;

		case 4:
			$ratingInf = "Good";
			break;

		case 5:
			$ratingInf = "Super!";
			break;

		default:
			$ratingInf = "None";
			break;
	}	
}
?>
<div class="w115 ratingInfo bb-s-g h25 pb5">
	<div class="fl mt4">
		<span class="fl fs14 mr2"><?php echo !$vote ? round($user->SocialRating, 1) : $vote;?></span>
		<span class="<?php echo !$vote ? 'icon_star_filled' : 'icon_star_filled_vote' ?> fl"></span>
	</div>
	<div class="fr">
		<span class="fs10 fl <?php echo $ratingInfClass; ?> mt10 mr2"><?php echo $this->__($ratingInf); ?></span>
		<?php if(round($user->SocialRating) > 0):?>
			<span class="fl iconr_rating_meter star<?php echo !$vote ? round($user->SocialRating) : $vote; ?>"></span>
		<?php endif; ?>
	</div>
</div>
<div class="pt5 tal">
	<div class="fclg fs10"><?php echo $isSelf ? $this->__('Your rating') : $this->__('Rating'); ?>:	<?php echo $this->__($ratingInf); ?></div>
	<div class="fclg fs10"><?php echo $this->__('Raters'); ?>:	<?php echo $user->getRatingsCount();?></div>
</div>
