<?php
$rating = $game->SocialRating;
$rating_round = round($rating);
$ratings = new Ratings();
$ratingsCount = $ratings->getTotalRatings($game->ID_GAME, 'game'); 
$userRating;
if(Auth::isUserLogged()) {
    $player = User::getUser();
    $userRating = $ratings->getUsersRating('game',$game->ID_GAME);
};
?>



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
	<span class="ratingValue"><?php echo number_format(round($rating, 1), 1, '.', ' ').'/10 from '.$ratingsCount; ?></span>
    </div>
</div>