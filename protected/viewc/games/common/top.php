<?php $isEnabledNews = MainHelper::IsModuleEnabledByTag('news'); ?>
<?php $isEnabledForum = MainHelper::IsModuleEnabledByTag('forum'); ?>
<?php $isRegUsers = MainHelper::IsModuleEnabledByTag('reguser'); ?>
<?php if (MainHelper::IsModuleNotAvailableByTag('news')==1) $isEnabledNews = 0; ?>
<?php if (MainHelper::IsModuleNotAvailableByTag('forum')==1) $isEnabledForum = 0; ?>
<?php if (MainHelper::IsModuleNotAvailableByTag('reguser')==1) $isRegUsers = 0; ?>

<?php $contentchildFunctions = MainHelper::GetModuleFunctionsByTag('contentchild'); 
		$anyMedia = $contentchildFunctions['contentchildMediaVideos'] + $contentchildFunctions['contentchildMediaScreenshots']
		+ $contentchildFunctions['contentchildMediaConceptArt']+ $contentchildFunctions['contentchildMediaWallpapers']
		+ $contentchildFunctions['contentchildMediaDownloads'];?>

<?php if(isset($game)):?>
    <input id="game_id" value="<?php echo $game->ID_GAME;?>" type="hidden" />
<?php endif; ?>

<?php echo !isset($hideAdd) ? $this->renderBlock('common/header_ads', array()) : '';?>

<?php if(isset($infoBox)):?>
    <?php echo $infoBox;?>
<?php endif; ?>

<?php 
	if (isset($game))
		if ($game->PlayersCount==0)
			$isRegUsers = 0;

	$any = $isEnabledNews + $contentchildFunctions['contentchildWall'] + $contentchildFunctions['contentchildUgf'] + 
	$isRegUsers + $isEnabledForum + $anyMedia; ?>

<?php /* if(isset($CategoryType) and isset($game) and $any>0):?>

	<?php 
    $countMedia = MainHelper::countMedias($game);
    if($countMedia == 0) { $anyMedia = 0; };
    ?>
	<ul class="horizontal_tabs clearfix">
		<?php $gameUrl = $game->GAME_URL; ?>
		<li class="<?php echo $CategoryType == GAME_INFO ? 'active':''; ?>">
			<a class="icon_link" href="<?php echo $gameUrl; ?>"><i class="info_tab_icon"></i><?php echo $this->__('Info'); ?></a>
		</li>
		<?php if ($isEnabledNews == 1): ?>
            <li class="<?php echo $CategoryType == GAME_NEWS ? 'active':''; ?>">
                <a class="icon_link" href="<?php echo $gameUrl.'/news'; ?>"><i class="news_tab_icon"></i><?php echo $this->__('News'); ?></a>
            </li>
		<?php endif;
		if($contentchildFunctions['contentchildWall'] == 1): ?>
            <li class="<?php echo $CategoryType == GAME_WALL ? 'active':''; ?>">
                <a class="icon_link" href="<?php echo $gameUrl.'/wall'; ?>"><i class="wall_tab_icon"></i><?php echo $this->__('Wall'); ?></a>
            </li>
		<?php endif;
		if($contentchildFunctions['contentchildUgf'] == 1): ?>
            <li class="<?php echo $CategoryType == GAME_REVIEWS ? 'active':''; ?>">
                <a class="icon_link" href="<?php echo $gameUrl.'/reviews'; ?>"><i class="news_tab_icon"></i><?php echo $this->__('Reviews'); ?></a>
            </li>
		<?php endif;
		if($isRegUsers == 1): ?>
            <li class="<?php echo $CategoryType == GAME_PLAYERS || $CategoryType == GAME_MEMBERS ? 'active':''; ?>">
                <a class="icon_link" href="<?php echo $gameUrl.'/players'; ?>"><i class="players_tab_icon"></i><?php echo $this->__('Members'); ?></a>
            </li>
		<?php endif;
		if($isEnabledForum == 1): ?>
            <li class="<?php echo $CategoryType == GAME_FORUM ? 'active':''; ?>">
                <a class="icon_link" href="<?php echo $game->FORUM_URL; ?>"><i class="forum_tab_icon"></i><?php echo $this->__('Forum'); ?></a>
            </li>
		<?php endif;
		if($anyMedia != 0): ?>
            <li class="<?php echo $CategoryType == GAME_MEDIA ? 'active':''; ?>">
                <a class="icon_link" href="<?php echo $gameUrl.'/media'; ?>"><i class="media_tab_icon"></i><?php echo $this->__('Media'); ?></a>
            </li>
		<?php endif; ?>
		<?php /* <li class="<?php echo $CategoryType == GAME_DOWNLOADS ? 'active':'';?>">
			<a class="icon_link" href="<?php echo $gameUrl.'/downloads';?>"><i class="downloads_tab_icon"></i><?php echo $this->__('Downloads');?></a>
		</li>
		<?php /*
		<li class="<?php echo $CategoryType == GAME_EVENTS ? 'active':'';?>">
			<a class="icon_link" href="<?php echo $game->EVENTS_URL;?>"><i class="event_tab_icon"></i><?php echo $this->__('Events');?></a>
		</li>  ?>
	</ul>
<?php endif;  */?>

<?php if($contentchildFunctions['contentchildFreeToPlay']==1 and isset($CategoryType) and $CategoryType !== null and ($CategoryType == GAME_INDEX or $CategoryType == GAME_FREE_TO_PLAY or $CategoryType == GAME_BUYABLE)):?>
	<ul class="horizontal_tabs clearfix">
		<li class="<?php echo $CategoryType == GAME_INDEX ? 'active' : ''; ?>">
			<a href="<?php echo MainHelper::site_url('games'); ?>" class="icon_link"><i class="games_tab_icon"></i><?php echo $this->__('Game Index'); ?></a>
		</li>
		<li class="<?php echo $CategoryType == GAME_FREE_TO_PLAY ? 'active' : ''; ?>">
			<a href="<?php echo MainHelper::site_url('games/'.GAME_FREE_TO_PLAY); ?>" class="icon_link"><i class="games_tab_icon"></i><?php echo $this->__('Free-to-play Games'); ?></a>
		</li>
		<li class="<?php echo $CategoryType == GAME_BUYABLE ? 'active' : ''; ?>">
			<a href="<?php echo MainHelper::site_url('games/'.GAME_BUYABLE); ?>" class="icon_link"><i class="games_tab_icon"></i><?php echo $this->__('Buyable Games'); ?></a>
		</li>
	</ul>
<?php endif;
/*
if(isset($CategoryType)): ?>
	<ul class="horizontal_tabs clearfix">
		<?php if(!isset($game)):?>
			<li class="<?php echo $CategoryType == GAME_INDEX ? 'active':'';?>">
				<a href="<?php echo MainHelper::site_url('games');?>"><?php echo $this->__('All Games');?></a>
			</li>
			<li class="<?php echo $CategoryType == GAME_POPULAR ? 'active':'';?>">
				<a href="<?php echo MainHelper::site_url('games/popular');?>"><?php echo $this->__('Popular');?></a>
			</li>
			<li class="<?php echo $CategoryType == GAME_RECENT ? 'active':'';?>">
				<a href="<?php echo MainHelper::site_url('games/recent');?>"><?php echo $this->__('Recently Added');?></a>
			</li>
		<?php else:?>
			<?php $gameUrl = $game->GAME_URL;?>
			<li class="<?php echo $CategoryType == GAME_INFO ? 'active':'';?>">
				<a class="icon_link" href="<?php echo $gameUrl;?>"><i class="info_tab_icon"></i><?php echo $this->__('Info');?></a>
			</li>
			<li class="<?php echo $CategoryType == GAME_NEWS ? 'active':'';?>">
				<a class="icon_link" href="<?php echo $gameUrl.'/news';?>"><i class="news_tab_icon"></i><?php echo $this->__('News');?></a>
			</li>
			<li class="<?php echo $CategoryType == GAME_PLAYERS ? 'active':'';?>">
				<a class="icon_link" href="<?php echo $gameUrl.'/players';?>"><i class="players_tab_icon"></i><?php echo $this->__('Players');?></a>
			</li>
			<li class="<?php echo $CategoryType == GAME_FORUM ? 'active':'';?>">
				<a class="icon_link" href="<?php echo $game->FORUM_URL;?>"><i class="forum_tab_icon"></i><?php echo $this->__('Forum');?></a>
			</li>
			<li class="<?php echo $CategoryType == GAME_MEDIA ? 'active':'';?>">
				<a class="icon_link" href="<?php echo $gameUrl.'/media';?>"><i class="media_tab_icon"></i><?php echo $this->__('Media');?></a>
			</li>
			<li class="<?php echo $CategoryType == GAME_DOWNLOADS ? 'active':'';?>">
				<a class="icon_link" href="<?php echo $gameUrl.'/downloads';?>"><i class="downloads_tab_icon"></i><?php echo $this->__('Downloads');?></a>
			</li>
			<li class="<?php echo $CategoryType == GAME_EVENTS ? 'active':'';?>">
				<a class="icon_link" href="<?php echo $game->EVENTS_URL;?>"><i class="event_tab_icon"></i><?php echo $this->__('Events');?></a>
			</li>
		<?php endif; ?>
	</ul>
<?php endif; ?>
*/ ?>