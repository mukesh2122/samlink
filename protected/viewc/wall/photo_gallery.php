<?php if(!empty($items)):?>
	<?php 
		$inc = $offset > 0 ? $offset +1  : 1;
	?>
	<?php foreach ($items as $item):?>
		<div class="mt10 <?php echo ($inc % 3 != 0) ? 'mr3' : '';?> media_post photo_img pr">
			<a rel="photo_tag" class="showImage" href="<?php echo MainHelper::site_url('players/iframeshowphotopopup/'.$item->ID_WALLITEM.'/'.WALL_PHOTO);?>"><?php echo MainHelper::showImage($item, THUMB_LIST_198x148, false, array('both'));?></a>
			<span class="db img_info clearfix pa b0 l0">
				<span class="img_comments img_comments_<?php echo $item->ID_WALLITEM;?>"><?php echo $item->Replies;?></span>
				<span class="img_likes img_likes_<?php echo $item->ID_WALLITEM;?>"><?php echo $item->LikeCount;?></span>
				<?php if (!isset($friendUrl) || empty($friendUrl)) : ?>
					<a href="javascript:void(0)" class="fr icon_delete_gallery mr4 delete_post refresh" rel="<?php echo $item->ID_WALLITEM;?>"></a>
					<a href="<?php echo MainHelper::site_url('players/edit_post/'.WALL_PHOTO.'/'.$item->ID_WALLITEM);?>" class="fr iconr_editPen mr4" rel="<?php echo $item->ID_WALLITEM;?>"></a>
				<?php endif; ?>
			</span>
		</div>
		<?php if($inc % 3 == 0):?>
			<div class="clear">&nbsp;</div>
		<?php endif; $inc++;?>
	<?php endforeach;?>
<?php endif; ?>