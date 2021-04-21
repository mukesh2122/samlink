<?php
	$messArr = ((isset($m->Body)) ? $messArr = (object) unserialize($m->Body) : $messArr = (object) unserialize($m->MessageText));
	$content = $messArr->content;
	$description = ContentHelper::handleContentOutput($messArr->description);
	if (isset($m->Body))
	{
		if($m->isRead == 0)
		{
			$m->markAsRead();
		}
		$nick = PlayerHelper::showName($m);
		$img = MainHelper::showImage($m, THUMB_LIST_60x60, false, array('no_img' => 'noimage/no_player_60x60.png'));
	}
	else
	{
		$nick = $m->DisplayName;
		$img = MainHelper::showImage($m, THUMB_LIST_60x60, false, array('no_img' => 'noimage/no_player_60x60.png'));
	}
?> 
<div class="clearfix pt10 pb10 bb-s-g">
	<div class="clearfix">
		<div class="grid_1 alpha"><a class="img" title="<?php echo $nick;?>" href="<?php echo MainHelper::site_url('player/'.$m->URL);?>"><?php echo $img?></a></div>
		<div class="grid_5 alpha omega">
			<span class="mt0"><a href="<?php echo MainHelper::site_url('player/'.$m->URL);?>"><?php echo $nick;?></a></span>
			<?php echo ($messArr->type != WALL_VIDEO) ? $content : $description;?>
		</div>
	</div>
	<?php echo $this->renderBlock('common/videoItem', array(
			'messArr' => $messArr,
			'item' => $m,
		));
	?>
	<div class="clearfix tar fclg"><?php echo MainHelper::calculateTime((isset($m->Body)) ? $m->MsgTime : $m->MessageTime, DATE_FULL); ?></div>
</div>
