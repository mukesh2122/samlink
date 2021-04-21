<?php include ('common/typeTop.php'); ?>

<?php
$messArr = (object) unserialize($item->Message);
$content = (object) unserialize($messArr->content);
$description = ContentHelper::handleContentOutput($messArr->description);
?>

<!-- Wall video item start -->
<div class="wall_item clearfix itemPost post_wall_<?php echo $item->ID_WALLITEM; ?>">
	<a class="wall_item_img" title="<?php echo $nick; ?>" href="<?php echo $url; ?>"><?php echo $img; ?></a>
	<div class="wall_item_meta">
		<div class="wall_item_text">
			<a href="<?php echo $url; ?>"><?php echo $nick; ?></a>
			<?php if (strlen($description) > 0): ?>
				<?php echo $description; ?>
			<?php endif; ?>
		</div>

		<div class="wall_item_video_container clearfix F_showVideo_<?php echo $content->id; ?>">

			<div class="wall_item_video_thumb">
				<a class="video_thumb showEmbededVideo" rel="<?php echo $content->id; ?>" href="javascript:void(0)" title="<?php echo htmlspecialchars($content->title); ?>">
					<img src="http://img.youtube.com/vi/<?php echo $content->id; ?>/0.jpg" onload="imageLoad(event);" />
					<span class="video_button"></span>
				</a>
			</div>

			<div class="wall_item_video_meta">
				<span class="wall_item_video_title"><a class="showEmbededVideo" rel="<?php echo $content->id; ?>" href="javascript:void(0)" title="<?php echo htmlspecialchars($content->title); ?>"><?php echo $content->title; ?></a></span>

				<span class="wall_item_video_link"><a href="http://youtube.com">www.youtube.com</a></span>

				<div class="wall_item_video_description">
					<?php echo $content->content; ?>
				</div>
			</div>
		</div>

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
<!-- Wall video item end -->






<?php /*
<?php include ('common/typeTop.php'); ?>

<?php
$messArr = (object) unserialize($item->Message);
$content = (object) unserialize($messArr->content);
$description = ContentHelper::handleContentOutput($messArr->description);
?>

<div class = "clearfix mt10 pt10 dot_top itemPost pr post_wall_<?php echo $item->ID_WALLITEM; ?>">
	<div class = "grid_1 alpha"><a class = "img" title = "<?php echo $nick; ?>" href = "<?php echo $url; ?>"><?php echo $img
?></a></div>
	<div class="w530 fl">
		<span class="mt0"><a href="<?php echo $url; ?>"><?php echo $nick; ?></a></span>

		<?php if (strlen($description) > 0): ?>
			<?php echo $description; ?>
		<?php endif; ?>
		<div class="mt3 clearfix">
			<div class="F_showVideo_<?php echo $content->id; ?>">
				<div class="fl w120 mr4">
					<a class="db videoThumb pr showEmbededVideo" rel="<?php echo $content->id; ?>" href="javascript:void(0)" title="<?php echo htmlspecialchars($content->title); ?>">
						<img src="http://img.youtube.com/vi/<?php echo $content->id; ?>/0.jpg" onload="imageLoad(event);" />
						<span class="videoButton pa b0 l0 zi2 mb5 ml5"></span>
					</a>
				</div>
				<div class="fl w400">
					<span class="db fclg2">
						<strong>
							<a class="thickbox fclg2 showEmbededVideo" rel="<?php echo $content->id; ?>" href="javascript:void(0)" title="<?php echo htmlspecialchars($content->title); ?>">
								<?php echo $content->title; ?>
							</a>
						</strong>
					</span>
					<span class="db"><a href="http://youtube.com">www.youtube.com</a></span>
					<span class="fclg"><?php echo $content->content; ?></span>

				</div>
			</div>
		</div>

	</div>
	<div>
		<?php include('common/comment_block.php'); ?>
	</div>
	<?php if ($item->isOwner()): ?>
		<a href="javascript:void(0)" class="itemMoreActions iconr_moreActions t0 r0 zi2 pa mt5 dn" rel="<?php //echo $board->ID_OWNER;    ?>"></a>
		<div class="itemMoreActionsBlock pa dn">
			<a class="db delete_post" rel="<?php echo $item->ID_WALLITEM; ?>" href="javascript:void(0)"><?php echo $this->__('Delete');?></a>
		</div>
	<?php endif; ?>
</div>
*/ ?>