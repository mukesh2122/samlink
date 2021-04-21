<?php
if(!empty($medias)):
    $inc = 1; $offset = 0;
    $isAdmin = User::canAccess("Edit company");
    if($offset > 0) { $inc += $offset % 2; };
    foreach($medias as $item):
        $content = (object)unserialize($item->MediaDesc); ?>
        <div class="<?php echo $inc < 2 ? 'mr8' : ''; ?> media_post video_img pr">
            <?php if($isAdmin == TRUE):?>
                <a href="javascript:void(0);" rel="<?php echo $item->ID_MEDIA; ?>" class="pa cal icon_close_company_media mr5 mt20">&nbsp;</a>
            <?php endif;
            if($content->type == VIDEO_YOUTUBE): ?>
                <span class="video_title oh"><a rel="iframe" title="" href="<?php echo $company->COMPANY_URL.'/media/'.MEDIA_VIDEO_URL.'/'.$item->ID_MEDIA; ?>"><?php echo DooTextHelper::limitChar(htmlspecialchars($this->__($content->title)), 75); ?></a></span>
        	    <a class="thickbox" rel="iframe" href="<?php echo $company->COMPANY_URL.'/media/'.MEDIA_SCREENSHOT.'/'.$item->ID_MEDIA; ?>" title="<?php echo htmlspecialchars($this->__($content->title)); ?>">
        	       <img src="http://img.youtube.com/vi/<?php echo $content->id; ?>/0.jpg" onload="imageLoad(event);">
        	    </a>
            <?php endif; ?>
        </div>
        <?php if($inc == 2): ?>
            <div class="clear mb8">&nbsp;</div>
            <?php
            $inc = 0;
        endif;
        $inc++;
    endforeach;
else: ?>
    <div class="noItemsText"><?php echo $this->__('There are no media here. Yet!'); ?></div>
<?php endif; ?>