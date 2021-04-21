<div class="grid_2 alpha omega fr pr news_calendar">
    <a href="javasctipt:void(0)" rel="<?php echo $item->ID_NEWS;?>_0" class="pa cal action_newslike icon_like">&nbsp;</a>
    <span class="like_comment_num pa"><?php echo $item->LikeCount;?></span>
    <a href="javasctipt:void(0)" rel="<?php echo $item->ID_NEWS;?>_0" class="pa cal action_newsdislike icon_dislike">&nbsp;</a>
    <span class="dislike_comment_num pa"><?php echo $item->DislikeCount;?></span>
    <div class="calendar db pa cal_body">
        <span class="db fs10 fft mt15 fclg tac"><?php echo date("h:i A", $item->PostingTime);?></span>
        <span class="db fwb tac fs19 lhn news_post_day"><?php echo date("d", $item->PostingTime);?></span>
        <span class="db fs10 fft fclg tac cal_time"><?php echo date("M Y", $item->PostingTime);?></span>
    </div>
</div>