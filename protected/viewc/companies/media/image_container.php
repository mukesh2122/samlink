<?php
if(!empty($medias)):
    $inc = 1; $offset = 0;
    $isAdmin = User::canAccess("Edit company");
    if($offset > 0) { $inc += $offset % 3; };
    foreach($medias as $item): ?>
        <div class="<?php echo $inc < 3 ? 'mr9' : ''; ?> media_post media_img pr">
            <?php if($isAdmin === TRUE): ?>
                <a href="<?php echo $company->COMPANY_URL.'/admin/editmedia/'.$item->ID_MEDIA; ?>" rel="iframe" class="pa cal icon_edit_company_media mr30 mt5">&nbsp;</a>
                <a href="javascript:void(0);" rel="<?php echo $item->ID_MEDIA; ?>" class="pa cal icon_close_company_media mr5 mt5">&nbsp;</a>
            <?php endif; ?>
            <a class="thickbox" rel="iframe" href="<?php echo $company->COMPANY_URL.'/media/'.$item->MediaType.'/'.$item->ID_MEDIA; ?>"><?php echo MainHelper::showImage($item, THUMB_LIST_198x148); ?></a>
            <span class="db img_info clearfix">
                <?php echo DooTextHelper::limitChar(htmlspecialchars($this->__($item->MediaName)), 75); ?>
            </span>
        </div>
        <?php if($inc == 3): ?>
            <div class="clear mb10">&nbsp;</div>
            <?php
                $inc = 0;
        endif;
        ++$inc;
    endforeach;
else: ?>
    <div class="noItemsText"><?php echo $this->__('There are no media here. Yet!'); ?></div>
<?php endif; ?>