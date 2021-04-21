<?php
	$url = MainHelper::site_url('player/'.$user->URL);
	$nick = PlayerHelper::showName($user);
	$img = MainHelper::showImage($user, THUMB_LIST_60x60, false, array('no_img' => 'noimage/no_player_60x60.png'));
?>
<div class="clearfix">
    <div class="grid_1 alpha"><a class="img" title="<?php echo $nick;?>" href="<?php echo $url;?>"><?php echo $img; ?></a></div>
	<?php echo $this->renderBlock('wall/share_texts/news', array('otype' => $otype, 'oid' => $oid, 'olang' => $olang)); ?>
</div>