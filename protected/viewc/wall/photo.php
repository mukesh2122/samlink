<?php if ($item->ID_ALBUM == 0) : ?>
	<?php include ('common/typeTop.php'); ?>
	
	<!-- Wall photo item start -->
	<div class="wall_item clearfix itemPost post_wall_<?php echo $item->ID_WALLITEM; ?>">
		<a class="wall_item_img" title="<?php echo $nick; ?>" href="<?php echo $url; ?>"><?php echo $img; ?></a>
		<div class="wall_item_meta">
			<div class="wall_item_text">
				<a href="<?php echo $url; ?>"><?php echo $nick; ?></a><br />
				<?php
					$message = unserialize($item->Message);
					$content = unserialize($message['content']);
					if (isset($message['description'])){
						echo $message['description'];
						if (isset($content['message'])){
							echo ' - '.$content['message'];
						}
					}
					else {
						if (isset($content['message'])){
							echo $content['message'];
						}
					}
				?>
			</div>
			<?php /*
			<a class="thumbnail" rel="fancy_img" title="" href="<?php echo MainHelper::showImage($item, IMG_800x600, true, array('both')); ?>"><?php echo MainHelper::showImage($item, THUMB_LIST_198x148, false, array('both')); ?></a>
			*/ ?>
			<a rel="photo_tag" class="thumbnail" href="<?php echo MainHelper::site_url('players/iframeshowphotopopup/'.$item->ID_WALLITEM.'/'.WALL_PHOTO);?>"><?php echo MainHelper::showImage($item, THUMB_LIST_198x148, false, array('both'));?></a>

			<?php include('common/comment_block.php'); ?>
	
			<?php if($item->isOwner() or $item->isWallOwner()): ?>
				<div class="wall_item_dropdown item_dropdown">
					<a href="javascript:void(0)" class="wall_item_dropdown_trigger item_dropdown_trigger"><?php echo $this->__('Options');?></a>
					<ul class="wall_item_dropdown_options item_dropdown_options">
						<li>
							<a class="delete_post" rel="<?php echo $item->ID_WALLITEM; ?>" href="javascript:void(0)"><?php echo $this->__('Delete');?></a>
						</li>
					</ul>
				</div>
			<?php endif;?>
		</div>
	</div>
	<!-- Wall photo item end -->
<?php endif; ?>