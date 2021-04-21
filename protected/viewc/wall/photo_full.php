<?php
$nick = PlayerHelper::showName($poster);
$img = MainHelper::showImage($poster, THUMB_LIST_60x60, false, array('no_img' => 'noimage/no_player_60x60.png'));
?> 
<div class="clearfix">
    <div class="fl w70"><a class="img" title="<?php echo $nick; ?>" href="<?php echo MainHelper::site_url('player/' . $poster->URL); ?>"><?php echo $img ?></a></div>
	<div class="fl">
        <span class="mt0"><a href="<?php echo MainHelper::site_url('player/' . $poster->URL); ?>"><?php echo $nick; ?></a></span>
		<?php
		$messArr = (object) unserialize($item->Message);
		$content = (object) unserialize($messArr->content);
		?>
		<div>
			<?php echo MainHelper::showImage($item, IMG_800x600, false, array('both')); ?>
		</div>
    </div>
	<div>
		<?php include('common/comment_block.php'); ?>
	</div>
</div>

