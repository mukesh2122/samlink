<?php
	$messArr = (object) unserialize($m->Body);
	$content = ContentHelper::handleContentOutput($messArr->content);
	$description = ContentHelper::handleContentOutput($messArr->description);
	if($m->isRead == 0) {
		$m->markAsRead();
	}
	$nick = PlayerHelper::showName($m);
	$img = MainHelper::showImage($m, THUMB_LIST_60x60, false, array('no_img' => 'noimage/no_player_60x60.png'));
?> 
<div class="clearfix pt10 pb10 bb-s-g">
	<div class="clearfix">
		<div class="grid_1 alpha"><a class="img" title="<?php echo $nick;?>" href="<?php echo MainHelper::site_url('player/'.$m->URL);?>"><?php echo $img?></a></div>
		<div class="grid_5 alpha omega">
			<span class="mt0"><a href="<?php echo MainHelper::site_url('player/'.$m->URL);?>"><?php echo $nick;?></a></span>
			<?php echo $content;?>
		</div>
	</div>
	
	<?php
	$shareInfo = MainHelper::shareInfo($messArr->otype, $messArr->oid, $messArr->olang);

	if(!empty($shareInfo)):
	?>

		<div class="mt3 clearfix">
			<div class="fl w100px mr4">
				<a class="" href="<?php echo $shareInfo->url; ?>">
					<?php echo $shareInfo->img; ?>
				</a>
			</div>
			<div class="fl w400">
				<span class="db fclg2">
					<strong>
						<a class="thickbox fclg2" href="<?php echo $shareInfo->url; ?>">
							<?php echo $shareInfo->title; ?>
						</a>
					</strong>
				</span>
				<span class="db"><a href="<?php echo $shareInfo->url; ?>"><?php echo $shareInfo->url; ?></a></span>
			</div>
		</div>
	<?php endif; ?>
</div>
