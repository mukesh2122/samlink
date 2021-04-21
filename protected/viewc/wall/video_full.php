<?php
    $nick = PlayerHelper::showName($poster);
    $img = MainHelper::showImage($poster, THUMB_LIST_60x60, false, array('no_img' => 'noimage/no_player_60x60.png'));
?> 
<div class="clearfix">
    <div class="grid_1 alpha"><a class="img" title="<?php echo $nick;?>" href="<?php echo MainHelper::site_url('player/'.$poster->URL);?>"><?php echo $img?></a></div>
	 <div class="w530 fl">
        <span class="mt0"><a href="<?php echo MainHelper::site_url('player/'.$poster->URL);?>"><?php echo $nick;?></a></span>
		<?php 
            $messArr = (object)unserialize($item->Message);
            $content = (object)unserialize($messArr->content);
            $description = ContentHelper::handleContentOutput($messArr->description);
			//$video = fopen('http://www.youtube.com/oembed?url=http%3A//youtube.com/watch%3Fv%3D'.$content->id.'&format=json', 'r');
			$videoInfo = file_get_contents('http://gdata.youtube.com/feeds/api/videos/'.$content->id.'?v=2&alt=json');
			$videoInfo = json_decode($videoInfo);
			//$videoInfo = fread($video, 9000);
			
        ?>
		<?php if(strlen($description) > 0):?>
            <?php echo $description;?>
        <?php endif; ?>
		<div>
			<iframe width="520" height="294" src="http://www.youtube.com/embed/<?php echo $content->id ?>" frameborder="0" allowfullscreen></iframe>
		</div>
		
    </div>
	<div class="iframe-vid">
		<?php include('common/comment_block.php');?>
	</div>
</div>

