<?php if(!empty($medias)):?>
    <?php 
        $inc = 1; $offset = 0; 
		$groupUrl = $group->GROUP_URL;
    
        if($offset > 0) {
            $inc += $offset % 2;
        }
    ?>
    <?php foreach ($medias as $item):?>
        <?php 
            $content = (object)unserialize($item->MediaDesc);
        ?>
        <div class="<?php echo $inc < 3 ? 'mr3' : '';?> media_post video_img pr">
            <?php if($isAdmin == TRUE):?>
				<a href="javascript:void(0)" rel="<?php echo $item->ID_MEDIA;?>" class="pa cal icon_close_group_media mr5 mt20">&nbsp;</a>
            <?php endif;?>
            
            <?php if($content->type == VIDEO_YOUTUBE):?>
                <span class="video_title oh"><a rel="iframe" title="" href="<?php echo $groupUrl.'/media/'.MEDIA_VIDEO_URL.'/'.$item->ID_MEDIA;?>"><?php echo DooTextHelper::limitChar(htmlspecialchars($content->title), 75);?></a></span>
        	    <a class="thickbox" rel="iframe" href="<?php echo $groupUrl.'/media/'.MEDIA_SCREENSHOT.'/'.$item->ID_MEDIA;?>" title="<?php echo htmlspecialchars($content->title);?>">
        	       <img src="http://img.youtube.com/vi/<?php echo $content->id;?>/0.jpg" onload="imageLoad(event);">
        	    </a>
            <?php endif;?>
        </div>
        <?php if($inc == 3):?>
            <div class="clear mb8">&nbsp;</div>
        <?php $inc = 0; endif; ?>
        <?php $inc++;?>
    <?php endforeach;?>
<?php endif; ?>