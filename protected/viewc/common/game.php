<?php
$isEnabledNews = MainHelper::IsModuleEnabledByTag('news');
if(MainHelper::IsModuleNotAvailableByTag('news') == 1) { $isEnabledNews = 0; };
$contentchildFunctions = MainHelper::GetModuleFunctionsByTag('contentchild');
$gameUrl = $item->GAME_URL;
$description = (isset($owner) and strlen($item->Comments) > 0) ? $this->__($item->Comments) : $this->__($item->GameDesc);
$descLimit = 170;
$isPlaying = $item->isPlaying();

$showAdminFunc = FALSE;
$funcList = array();
if(Auth::isUserLogged() === TRUE) {
	$userPlayer = User::getUser();
	$suspendLevel = $userPlayer->getSuspendLevel();
	$noProfileFunctionality = MainHelper::GetNoProfileFunctionality($suspendLevel);
	$noSiteFunctionality = MainHelper::GetNoSiteFunctionality($suspendLevel);

	if(!$noProfileFunctionality) {
		if($isPlaying === TRUE) {
            $showAdminFunc = TRUE;
			$funcList[] = '<a href="javascript:void(0);" class="action_stop_playing" rel="'.$item->ID_GAME.'">'.$this->__('Stop playing').'</a>';
			$funcList[] = '<a href="javascript:void(0);" class="action_is_playing dn" rel="'.$item->ID_GAME.'">'.$this->__('Add to my games').'</a>';
		} else {
			$showAdminFunc = TRUE;
			$funcList[] = '<a href="javascript:void(0);" class="action_is_playing" rel="'.$item->ID_GAME.'">'.$this->__('Add to my games').'</a>';
			$funcList[] = '<a href="javascript:void(0);" class="action_stop_playing dn" rel="'.$item->ID_GAME.'">'.$this->__('Stop playing').'</a>';
		};
        if(isset($affiliates) && isset($isAdmin) && $isAdmin === TRUE) {
			$funcList[] = '<a rel="iframe" href="'.$gameUrl.'/admin/editalliance/'.$item->ID_GAME.'">'.$this->__('Edit').'</a>';
			$funcList[] = '<a class="remove_affiliate" rel="'.$item->ID_GAME.'" href="javascript:void(0);">'.$this->__('Remove').'</a>';
		};
	};
} else {
	$noSiteFunctionality = true;
};
?>

<!-- Game item start -->
<div class="list_item clearfix itemPost">
	<a class="list_item_img" href="<?php echo $gameUrl; ?>"><?php echo MainHelper::showImage($item, THUMB_LIST_80x80, false, array('no_img' => 'noimage/no_game_80x80.png')); ?></a>
	<div class="list_item_meta">
		<h2><a class="list_item_header" href="<?php echo $gameUrl; ?>"><?php echo $item->GameName; ?></a></h2>

		<p class="list_item_description short_desc_<?php echo $item->ID_GAME; ?>">
			<?php
			if($description) {
				echo strip_tags(DooTextHelper::limitChar($description, $descLimit));
			} else {
				echo $this->__('There is no description for this game at the moment.');
			}
			?>
		</p>
		<p class="list_item_description long_form dn long_desc_<?php echo $item->ID_GAME; ?>">
			<?php echo ContentHelper::handleContentOutput(strip_tags($description)); ?>
		</p>
		<ul class="list_item_footer">
			<?php if(strlen($description) > $descLimit): ?>
                <li><a class="icon_link revealmore" data-open="<?php echo $this->__('Read more'); ?>" data-close="<?php echo $this->__('Hide description'); ?>" data-id="<?php echo $item->ID_GAME; ?>" href="javascript:void(0);"><i class="readmore_icon"></i><?php echo $this->__('Read more'); ?></a></li>
			<?php endif;
			if(isset($owner) and $owner === true): ?>
                <li><a class="icon_link" href="<?php echo MainHelper::site_url('players/my-game-description/' . $item->ID_GAME);?>" rel="iframe" class="edit_icon"><i class="pen_icon"></i><?php echo strlen($item->Comments) > 0 ? $this->__('Edit Description') : $this->__('Write Description'); ?></a></li>
			<?php endif;
			if($isEnabledNews == 1): ?>
                <li><a class="icon_link" href="<?php echo $gameUrl, '/news'; ?>"><i class="news_icon"></i><?php echo $item->NewsCount; ?> <?php echo $this->__('News'); ?></a></li>
			<?php endif; ?>
			<li><a class="icon_link" href="<?php echo $gameUrl, '/media'; ?>"><i class="media_icon"></i><?php echo $item->DownloadableItems; ?> <?php echo ($item->DownloadableItems != 1) ? $this->__('Media Items') : $this->__('Media item'); ?></a></li>
			<?php if($item->isFreePlay && $contentchildFunctions['contentchildFreeToPlay'] == 1 && !$noSiteFunctionality): ?>
                <li><a href="<?php echo $gameUrl; ?>/play" class="icon_link"><i class="games_icon"></i><?php echo $this->__('Play now'); ?></a></li>
			<?php endif;
			if($item->isBuyable && $contentchildFunctions['contentchildBuyable'] == 1 && !$noSiteFunctionality): ?>
                <li><a href="<?php echo MainHelper::site_url('shop/product/' . $item->ID_PRODUCT); ?>" class="icon_link"><i class="games_icon"></i><?php echo $this->__('Show in Shop'); ?></a></li>
			<?php endif; ?>
		</ul>
		<?php if($showAdminFunc === true): ?>
			<div class="list_item_dropdown item_dropdown">
				<a href="javascript:void(0);" class="list_item_dropdown_trigger item_dropdown_trigger"><?php echo $this->__('Options'); ?></a>
				<ul class="list_item_dropdown_options item_dropdown_options">
					<li><?php echo implode("</li><li>", $funcList); ?></li>
				</ul>
			</div>
		<?php endif; ?>
	</div>
</div>
<!-- Game item end -->