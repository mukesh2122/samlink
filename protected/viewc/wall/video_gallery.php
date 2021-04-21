<?php if(!empty($items)):?>
	<?php 
		$inc = $offset > 0 ? $offset +1  : 1;
	?>
	<?php foreach ($items as $item):?>
		<?php 
			$messArr = (object)unserialize($item->Message);
			$content = (object)unserialize($messArr->content);
		?>
		<div class="pr mt10 <?php echo ($inc % 3 != 0) ? 'mr3' : '';?> video_img">
			<?php if($content->type == VIDEO_YOUTUBE):?>
				<span class="video_title oh pa t0 l0 zi2"><a rel="iframe" title="" href="<?php echo MainHelper::site_url('players/iframeshowphoto/'.$item->ID_WALLITEM.'/'.WALL_VIDEO);?>"><?php echo DooTextHelper::limitChar(htmlspecialchars($content->title), 75);?></a></span>
				<a class="thickbox db" rel="iframe" href="<?php echo MainHelper::site_url('players/iframeshowphoto/'.$item->ID_WALLITEM.'/'.WALL_VIDEO);?>" title="<?php echo htmlspecialchars($content->title);?>">
				   <img src="http://img.youtube.com/vi/<?php echo $content->id;?>/0.jpg" onload="imageLoad(event);">
				</a>
			<?php endif;?>
			<span class="db video_info clearfix pa b0 l0">
				<span class="video_comments video_comments_<?php echo $item->ID_WALLITEM;?>"><?php echo $item->Replies;?></span>
				<span class="video_likes video_likes_<?php echo $item->ID_WALLITEM;?>"><?php echo $item->LikeCount;?></span>
				<a href="javascript:void(0)" class="fr icon_delete_gallery mr4 delete_post refresh" rel="<?php echo $item->ID_WALLITEM;?>"></a>
			</span>
		</div>
		<?php if($inc % 3 == 0):?>
			<div class="clear">&nbsp;</div>
		<?php endif; $inc++;?>
	<?php endforeach;?>
<?php endif; ?>