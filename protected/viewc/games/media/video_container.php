<?php if(!empty($medias)):
    $inc = 1; $offset = 0;
    $gameUrl = $game->GAME_URL;
    $player = User::getUser();
    if($offset > 0) { $inc += $offset % 2; };
    foreach($medias as $item):
        $content = (object)unserialize($item->MediaDesc); ?>
        <div class="<?php echo $inc < 3 ? 'mr3' : ''; ?> media_post video_img pr">
            <?php if($player and $player->canAccess('Edit game information')): ?>
				<a href="javascript:void(0);" rel="<?php echo $item->ID_MEDIA; ?>" class="pa cal icon_close_game_media mr5 mt20">&nbsp;</a>
            <?php endif;
            if($content->type == VIDEO_YOUTUBE): ?>
                <span class="video_title oh"><a rel="iframe" title="" href="<?php echo $gameUrl.'/media/'.MEDIA_VIDEO_URL.'/'.$item->ID_MEDIA; ?>"><?php echo DooTextHelper::limitChar(htmlspecialchars($this->__($content->title)), 75); ?></a></span>
        	    <a class="thickbox" rel="iframe" href="<?php echo $gameUrl.'/media/'.MEDIA_SCREENSHOT.'/'.$item->ID_MEDIA; ?>" title="<?php echo htmlspecialchars($this->__($content->title)); ?>">
        	       <img src="http://img.youtube.com/vi/<?php echo $content->id; ?>/0.jpg" onload="imageLoad(event);">
        	    </a>
            <?php endif; ?>
        </div>
        <?php if($inc == 3): ?>
            <div class="clear mb8">&nbsp;</div>
        <?php $inc = 0;
        endif;
        ++$inc;
    endforeach;
endif; ?>