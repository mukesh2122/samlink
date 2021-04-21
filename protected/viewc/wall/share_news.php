<?php include ('common/typeTop.php');?>

<!-- Wall article item start -->
<div class="wall_item clearfix itemPost post_wall_<?php echo $item->ID_WALLITEM; ?>">
	<a class="wall_item_img" title="<?php echo $nick; ?>" href="<?php echo $url; ?>"><?php echo $img; ?></a>
	<div class="wall_item_meta">
		<div class="wall_item_text">
			<?php
			$messArr = (object)unserialize($item->Message);
			$content = $messArr->content;
			?>
			<a href="<?php echo $url;?>"><?php echo $nick;?></a>
			<?php  echo ContentHelper::handleContentOutput($content); ?>
		</div>

		<?php echo $this->renderBlock('wall/share_texts/news', array('otype' => $messArr->otype, 'oid' => $messArr->oid, 'olang' => $messArr->olang)); ?>

		<?php include('common/comment_block.php');?>

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
<!-- Wall article item end -->