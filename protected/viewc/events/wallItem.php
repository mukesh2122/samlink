<div class="post_wall post_wall_<?php echo $item->ID_NEWS;?> mt10 mb15 clearfix">
    <?
        $posterName = $event->EventHeadline;
        $img = MainHelper::showImage($event);
        //$isAdmin = $company->isAdmin();
    ?> 
    
    <div class="post_head clearfix">
        <div class="grid_1 alpha"><a class="img" title="<?php echo $posterName;?>" href="<?php //echo $event->COMPANY_URL;?>"><?php echo $img?></a></div>
        <div class="grid_5 alpha omega">
            <span class="fs10 mt13 fclg db"><?php echo $this->__('Post by');?>:</span>
            <span class="db mt0"><a href="<?php //echo $company->COMPANY_URL;?>"><?php echo $posterName;?></a></span>
        </div>
        <div class="grid_2 alpha omega fr pr">
            <a href="javasctipt:void(0)" rel="<?php echo $item->ID_NEWS;?>_0" class="pa cal action_newslike icon_like">&nbsp;</a>
            <span class="like_comment_num pa"><?php echo $item->LikeCount;?></span>
            <a href="javasctipt:void(0)" rel="<?php echo $item->ID_NEWS;?>_0" class="pa cal action_newsdislike icon_dislike">&nbsp;</a>
            <span class="dislike_comment_num pa"><?php echo $item->DislikeCount;?></span>
            <div class="calendar db pa cal_body">
                <span class="db fs10 fft mt15 fclg tac"><?php echo date("h:i A", $item->PostingTime);?></span>
                <span class="db fwb tac fs19 lhn com_post_day"><?php echo date("d", $item->PostingTime);?></span>
                <span class="db fs10 fft fclg tac cal_time"><?php echo date("M Y", $item->PostingTime);?></span>
            </div>
            <?php if($isAdmin === TRUE):?>
                <a href="javascript:void(0)" rel="<?php echo $item->ID_NEWS;?>" class="pa cal icon_close_compnay_news_post">&nbsp;</a>
            <?php endif; ?>
        </div>
    </div>
    
    <div class="mt0 fcb post_body clearfix">
        <?php 
            echo ContentHelper::handleContentOutput($item->NewsText);
        ?>
    </div>
    
    <div class="mt20 post_body clearfix">
        <a class="link_icon icon_viewnewscomments action_viewnewscomments vc_<?php echo $item->ID_NEWS;?>" rel="<?php echo $item->ID_NEWS;?>" href="javascript:void(0)">
            <?php echo $item->Replies > 0 ? $this->__('View All Comments') : $this->__('No Comments');?> (<span class="comments_num_<?php echo $item->ID_NEWS;?>"><?php echo $item->Replies;?></span>)
        </a>
        
        <a class="link_icon icon_viewnewscomments action_hidenewscomments hc_<?php echo $item->ID_NEWS;?> dn" rel="<?php echo $item->ID_NEWS;?>" href="javascript:void(0)"><?php echo $this->__('Hide comments');?> (<span class="comments_num_<?php echo $item->ID_NEWS;?>"><?php echo $item->Replies;?></span>)</a>
    </div>
    
    <?php if(Auth::isUserLogged()):?>
        <div class="comments-cont mt10">
            <div class="comments-top">
                  <div class="comments-bot pr">
                    <textarea id="comment_<?php echo $item->ID_NEWS;?>" rows="1" class="ta comment_block" cols="1" title="<?php echo $this->__('Comment >');?>"><?php echo $this->__('Comment >');?></textarea>
                    <a class="pa comment_newspost fft link_green" rel="comment_<?php echo $item->ID_NEWS;?>" href="javascript:void(0)"><span><span><?php echo $this->__('Comment');?></span></span></a>
                  </div>
            </div>
        </div>
    <?php endif; ?>
    <!-- comments -->
    <div class="comments_block <?php echo strlen($replies) > 1 ? '' : 'dn';?> clearfix">
        <div class="comments_block_<?php echo $item->ID_NEWS;?>">
        <?php echo $replies;?>
        </div>
    </div>
    <!-- end comments -->

</div>