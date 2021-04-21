<?php if(!empty($medias)):
    $inc = 1; $offset = 0;
    $gameUrl = $game->GAME_URL;
    $p = User::getUser();
    foreach($medias as $item): ?>
        <div class="<?php echo $inc < 3 ? 'mr3' : ''; ?> media_post photo_img pr clearfix">
            <?php if($p and $p->canAccess('Edit game information')): ?>
                <a href="<?php echo $gameUrl.'/admin/editmedia/'.$item->ID_MEDIA; ?>" rel="iframe" class="pa cal icon_edit_group_media mr30 mt5">&nbsp;</a>
                <a href="javascript:void(0);" rel="<?php echo $item->ID_MEDIA; ?>" class="pa cal icon_close_game_media mr5 mt5">&nbsp;</a>
            <?php endif; ?>
            <a class="thickbox" rel="iframe" href="<?php echo $gameUrl.'/media/'.$item->MediaType.'/'.$item->ID_MEDIA; ?>"><?php echo MainHelper::showImage($item, THUMB_LIST_198x148, false, array('both')); ?></a>
            <span class="db img_info clearfix">
                <?php echo DooTextHelper::limitChar(htmlspecialchars($this->__($item->MediaName)), 75); ?>
            </span>
        </div>
        <?php if($inc == 3): ?>
            <div class="clear mb10">&nbsp;</div>
            <?php $inc = 0;
        endif;
        ++$inc;
    endforeach;
endif; ?>