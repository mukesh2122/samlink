<?php if(!empty($medias)):?>
    <?php 
        $inc = 1; $offset = 0;
		$groupUrl = $group->GROUP_URL;
    ?>
    <?php foreach ($medias as $item):?>
        <div class="<?php echo $inc < 3 ? 'mr3' : '';?> media_post photo_img pr clearfix">
            <?php if($isAdmin === TRUE):?>
                <a href="<?php echo $groupUrl.'/admin/editmedia/'.$item->ID_MEDIA;?>" rel="iframe" class="pa cal icon_edit_group_media mr30 mt5">&nbsp;</a>
                <a href="javascript:void(0)" rel="<?php echo $item->ID_MEDIA;?>" class="pa cal icon_close_group_media mr5 mt5">&nbsp;</a>
            <?php endif;?>
            
            <a class="thickbox" rel="iframe" href="<?php echo $groupUrl.'/media/'.$item->MediaType.'/'.$item->ID_MEDIA;?>"><?php echo MainHelper::showImage($item, THUMB_LIST_198x148, false, array('both'));?></a>
            <span class="db img_info clearfix">
                <?php echo DooTextHelper::limitChar(htmlspecialchars($item->MediaName), 75);?>
            </span>
        </div>
        
        <?php if($inc == 3):?>
            <div class="clear mb10">&nbsp;</div>
        <?php $inc = 0; endif; ?>
        <?php $inc++;?>
    <?php endforeach;?>
<?php endif; ?>