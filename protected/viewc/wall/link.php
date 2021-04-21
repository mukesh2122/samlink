<?php include ('common/typeTop.php'); ?>

<!-- Wall link item start -->
<div class="wall_item clearfix itemPost post_wall_<?php echo $item->ID_WALLITEM; ?>">
	<a class="wall_item_img" title="<?php echo $nick; ?>" href="<?php echo $url; ?>"><?php echo $img; ?></a>
	<div class="wall_item_meta">
		<div class="wall_item_text">
			<a href="<?php echo $url;?>"><?php echo $nick; ?></a>
			<?php
			$messArr = @(object)unserialize($item->Message);
			$content = @(object)unserialize($messArr->content);
			$description = ContentHelper::handleContentOutput($messArr->description);
			$url = parse_url($content->url);
			$domain = $url['scheme'].'://'.$url['host'];
			?>
			<?php if(strlen($description) > 0):?>
				<?php echo $description; ?>
			<?php endif; ?>
		</div>

		<?php if(strlen($content->title) > 0): ?>
			<a class="wall_item_link_title" href="<?php echo $content->url;?>" title="<?php echo htmlspecialchars($content->title);?>">
				<?php echo DooTextHelper::limitChar($content->title, 80);?>
			</a>
		<?php endif; ?>

		<div class="wall_item_link_meta">
			<div class="wall_item_link_description">
			<?php if(strlen($content->content) > 0): ?>
				<?php echo DooTextHelper::limitChar($content->content, 300);?>
			<?php endif; ?>
			</div>

			<a class="wall_item_link_domain" href="<?php echo $content->url;?>" target="_blank"><?php echo DooTextHelper::limitChar($domain, 45);?></a>
		</div>

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
<!-- Wall link item end -->






<?php /*
<?php include ('common/typeTop.php');?>

<div class="clearfix mt10 pt10 dot_top itemPost pr post_wall_<?php echo $item->ID_WALLITEM; ?>">
    <div class="grid_1 alpha"><a class="img" title="<?php echo $nick;?>" href="<?php echo $url;?>"><?php echo $img?></a></div>
	 <div class="w530 fl">
        <span class="mt0"><a href="<?php echo $url;?>"><?php echo $nick;?></a></span>
		<?php
            $messArr = @(object)unserialize($item->Message);
            $content = @(object)unserialize($messArr->content);
            $description = ContentHelper::handleContentOutput($messArr->description);
            $url = parse_url($content->url);
            $domain = $url['scheme'].'://'.$url['host'];
        ?>
		<?php if(strlen($description) > 0):?>
            <?php echo $description;?>
        <?php endif; ?>
		<div class="clearfix mt10">
			<div>
				<?php if(strlen($content->title) > 0): ?>
				<span class="db fclg2 mb5">
					<strong>
						<a class="fclg2" href="<?php echo $content->url;?>" title="<?php echo htmlspecialchars($content->title);?>">
							<?php echo DooTextHelper::limitChar($content->title, 80);?>
						</a>
					</strong>
				</span>
				<?php endif; ?>
				<?php if(strlen($content->content) > 0): ?>
				<span class="db fclg mb5"><?php echo DooTextHelper::limitChar($content->content, 300);?></span>
				<?php endif; ?>
				<span class="db"><a class="fs11" href="<?php echo $content->url;?>" target="_blank"><?php echo DooTextHelper::limitChar($domain, 45);?></a></span>
			</div>
		</div>

    </div>
	<div>
		<?php include('common/comment_block.php');?>
	</div>
	<?php if($item->isOwner()): ?>
		<a href="javascript:void(0)" class="itemMoreActions iconr_moreActions t0 r0 zi2 pa mt5 dn"></a>
		<div class="itemMoreActionsBlock pa dn">
			<a class="db delete_post" rel="<?php echo $item->ID_WALLITEM; ?>" href="javascript:void(0)"><?php echo $this->__('Delete');?></a>
		</div>
	<?php endif;?>
</div>
*/ ?>