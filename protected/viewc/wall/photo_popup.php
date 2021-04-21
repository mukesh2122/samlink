<?php
$nick = PlayerHelper::showName($poster);
$img  = MainHelper::showImage($poster, THUMB_LIST_60x60, FALSE, array('no_img' => 'noimage/no_player_60x60.png'));
$message = unserialize($item->Message);
$content = unserialize($message['content']);
$filename = $content['content'];
$wallTags = new Walltags();
$tagsList = $wallTags->getAllTags($item->ID_WALLITEM);
$photoPopup = TRUE;
?>

<div id="ug_fullimage_container" class="dnn">
    <img id="ug_fullsize_img" src="<?php echo Doo::conf()->APP_URL, 'global/pub_img/', FOLDER_WALL_PHOTOS, '/', $filename[0], '/', $filename[1], '/', $filename; ?>">
    <button class="ug_preview"></button>
</div>
<div id="popupcontainer" class="clearfix">
	<div class="pull_left mr10">
		<div id="ug_image_container">
			<?php echo MainHelper::showImage($item, THUMB_LIST_800x600, FALSE, array('both')); ?>
			<button class="ug_full"></button>
			<button class="ug_prev"></button>
			<button class="ug_next"></button>
		</div>
	</div>
	<div class="pull_right ug_wall_item_comment_container_narrow">
		<div class="pull_left mr10">
			<a class="img" title="<?php echo $nick; ?>" href="<?php echo MainHelper::site_url('player/' . $poster->URL); ?>">
                <?php echo $img; ?>
            </a>
		</div>
		<div class="pull_left">
			<span class="mt0"><a href="<?php echo MainHelper::site_url('player/' . $poster->URL); ?>"><?php echo $nick; ?></a></span>
			<p><?php echo isset($message['description']) ? $message['description'] : ''; ?></p>
		</div>
		<!-- Tagged individuals start -->
		<div id="tagList">
			<?php
            $totalCount = count($tagsList);
            if($totalCount > 0) { echo $this->__('Tagged'), ': '; };
			$count = 0;
			foreach($tagsList as $tag): ?>
				<a rel="<?php echo $tag->ID_TAGGED; ?>" href="javascript:void(0);" title="<?php echo $this->__('Tagged by'), ' ', User::getById($tag->ID_TAGGEDBY)->DisplayName; ?>">
					<?php echo $tag->DisplayName; ?>
                </a>
                <?php
                if($count < ($totalCount - 2)) { echo ', '; }
                elseif($count == ($totalCount - 2)) { echo ' ', $this->__('and'), ' '; };
                $count++;
			endforeach; ?>
		</div>
		<!-- Tagged individuals end -->
		<div style="clear:both;">
			<?php include('common/comment_block_narrow.php'); ?>
		</div>
	</div>
</div>
<?php include(Doo::conf()->SITE_PATH . 'global/js/imageTag.js.php'); ?>