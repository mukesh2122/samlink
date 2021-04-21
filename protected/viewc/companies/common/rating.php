<?php
$rating = $company->SocialRating;
$rating_round = round($rating);
$ratings = new Ratings();
$ratingCount = $ratings->getTotalRatings($company->ID_COMPANY, 'company'); 
$userRating;
if(Auth::isUserLogged()){
	$player = User::getUser();
	$userRating = $ratings->getUsersRating('company',$company->ID_COMPANY);
}
?>

<!--<div class="profile_rating subtle_grey clearfix enabled">
	<div class="stars_rating">
		<span class="profile_rating_head"><?php echo $this->__('Rating'); ?></span>
		<ul>
			<?php for($i = 1; $i <= $rating_round; $i++): ?>
                <li class="clearfix icon_star_filled ratingStar star<?php echo $i; ?> <?php echo $i == $rating_round ? 'starCurrentSelected' : ''; ?> pr2 pl2">&nbsp;</li>
			<?php endfor; ?>

			<?php for($i = 1; $i <= 5 - $rating_round; $i++): ?>
                <li class="clearfix icon_star_empty ratingStar star<?php echo $rating_round + $i; ?> pr2 pl2">&nbsp;</li>
			<?php endfor; ?>
		</ul>
	</div>
	<span class="actualRating"><?php // echo number_format(round($rating, 1), 1, '.', ' '); ?></span>
</div>-->

<!--<div class="profile_rating subtle_grey clearfix enabled">-->
<div class="yourrating">
    <span class="ratingKey"><?php echo $this->__('Your rating'); ?></span>
	<span class="ratingValue">		
            <span id="ratingSelect">
                <select id="ratingDropdown" style="width: 170px" <!-- class="ratingDropdown w60" name="language" -->>
                        <option value="0">Rate</option>
                        <?php for ($i = 1; $i <= 10; $i++): ?>
                        <option <?php echo !empty($userRating) && $userRating->Rating == $i ? 'selected = "selected"' : ''; ?> value="<?php echo $i;?>"><?php echo $i;?></option>
                        <?php endfor; ?>
                </select>
            </span>
        </span>
</div>

<!--<div class="profile_rating subtle_grey clearfix enabled">-->
<div class="overall">
    <div>
        <span class="ratingKey"><?php echo $this->__('Overall'); ?></span>
	<span class="ratingValue"><?php echo number_format(round($rating, 1), 1, '.', ' ').'/10 from '.$ratingCount; ?></span>
    </div>
</div>