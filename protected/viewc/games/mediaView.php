<?php $contentchildFunctions = MainHelper::GetModuleFunctionsByTag('contentchild'); ?>

<?php $gameUrl = $game->GAME_URL;
$p = User::getUser();
include('common/top.php');
?>

<div id="headerCoverInfo">
    <div id="coverImg">&nbsp;</div>
    <div id="headerInfo"><h1><?php echo $this->__('Media') ?></h1></div>
</div>

<div class="mediaList_header">
	<?php if($p and $p->canAccess('Edit game information')): ?>
		<a class="list_header_button" rel="iframe" href="<?php echo $gameUrl; ?>/admin/addmedia"><?php echo $this->__('Add Media +'); ?></a>
	<?php endif; ?>
</div>


<?php if(!empty($tabs) || !empty($downloads)): // horizontal_tabs small clearfix ?>
	<ul class="mediaTab">
		<?php foreach ($tabs as $url=>$tab):?>
			<li <?php echo ($url == $activeTab) ? 'class="active"' : '';?>>
				<a href="<?php echo $gameUrl.'/media/'.$url;?>"><?php echo $tab;?></a>
			</li>
		<?php endforeach;?>

		<?php if (!isset($games)) $games = new Games();
			$mediasDownload = isset($downloads) ? $downloads : array();//$games->getMedias($game->ID_GAME, GAME_DOWNLOADS);
			if ($contentchildFunctions['contentchildMediaDownloads']==1 && count($mediasDownload)>0): ?>
		<li <?php echo (isset($CategoryType) and $CategoryType == GAME_DOWNLOADS) ? 'class="active"' : ''; ?>>
			<a class="icon_link" href="<?php echo $gameUrl.'/downloads'; ?>"><?php echo $this->__('Downloads'); ?></a>
        </li>
		<?php endif; ?>
    </ul>
<?php endif; ?>

<div class="mediaBody">
    <div class="mediaContent"><?php echo isset($media) ? $media : '';?></div>
</div>

<?php if(!isset($media) or $media == ''):
	$noItemsText = '';
	if($activeTab == MEDIA_SCREENSHOT_URL)
		$noItemsText = $this->__('There are no screenshots at this moment');
	elseif($activeTab == MEDIA_VIDEO_URL)
		$noItemsText = $this->__('There are no videos at this moment');
	elseif($activeTab == MEDIA_CONCEPTART_URL)
		$noItemsText = $this->__('There are no concept art at this moment');
	elseif($activeTab == MEDIA_WALLPAPER_URL)
		$noItemsText = $this->__('There are no wallpapers at this moment');
	?>
	<p class="noItemsText"><?php echo $noItemsText; ?></p>
<?php endif; ?>