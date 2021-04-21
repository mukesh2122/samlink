<?php
    $nick = PlayerHelper::showName($poster);
    $img = MainHelper::showImage($poster, THUMB_LIST_40x40, false, array('no_img' => 'noimage/no_player_40x40.png'));
?>

<div class="mt10 mr5 ml5 clearfix dot_bot pb5 reply_<?php echo $item->ID_NEWS.'_'.$item->ReplyNumber; ?>">
	<div class="w50 fl db"><a title="<?php echo $nick;?>" href="<?php echo MainHelper::site_url('player/'.$poster->URL);?>"><?php echo $img;?></a></div>
	<div class="grid_6 alpha omega">
		<a href="<?php echo MainHelper::site_url('player/'.$poster->URL); ?>"><?php echo $nick; ?></a>
		<?php echo nl2br(htmlspecialchars($this->__($item->Message))); ?>
		<div class="clear mt5">&nbsp;</div>
		<?php if(Auth::isUserLogged()):?>
			<?php if($item->isLiked()): //ADDED 2013-12-19?>
                <a data-opt='{"id":"<?php echo $item->ID_NEWS;?>", "reply": "<?php echo $item->ReplyNumber;?>", "type":"newsreply", "like":"1"}' class="icon_link action_unlike unlike_<?php echo $item->ID_NEWS.'_'.$item->ReplyNumber;?>" href="javascript:void(0)"><i class="like_icon"></i><?php echo $this->__('Unlike');?> (<span class="like_comment_num"><?php echo $item->LikeCount;?></span>)</a>
                <a data-opt='{"id":"<?php echo $item->ID_NEWS;?>", "reply": "<?php echo $item->ReplyNumber;?>", "type":"newsreply", "like":"1"}' class="icon_link action_like dn like_<?php echo $item->ID_NEWS.'_'.$item->ReplyNumber;?>" href="javascript:void(0)"><i class="like_icon"></i><?php echo $this->__('Like');?> (<span class="like_comment_num"><?php echo $item->LikeCount;?></span>)</a>
            <?php else:?>
                <a data-opt='{"id":"<?php echo $item->ID_NEWS;?>", "reply": "<?php echo $item->ReplyNumber;?>", "type":"newsreply", "like":"1"}' class="icon_link action_like like_<?php echo $item->ID_NEWS.'_'.$item->ReplyNumber;?>" href="javascript:void(0)"><i class="like_icon"></i><?php echo $this->__('Like');?> (<span class="like_comment_num"><?php echo $item->LikeCount;?></span>)</a>
                <a data-opt='{"id":"<?php echo $item->ID_NEWS;?>", "reply": "<?php echo $item->ReplyNumber;?>", "type":"newsreply", "like":"1"}' class="icon_link action_unlike dn unlike_<?php echo $item->ID_NEWS.'_'.$item->ReplyNumber;?>" href="javascript:void(0)"><i class="like_icon"></i><?php echo $this->__('Unlike');?> (<span class="like_comment_num"><?php echo $item->LikeCount;?></span>)</a>
            <?php endif; ?>
    
            <?php if($item->isDisliked()): //ADDED 2013-12-19?>
                <a data-opt='{"id":"<?php echo $item->ID_NEWS;?>", "reply": "<?php echo $item->ReplyNumber;?>", "type":"newsreply", "like":"0"}' class="icon_link action_undislike undislike_<?php echo $item->ID_NEWS.'_'.$item->ReplyNumber;?>" href="javascript:void(0)"><i class="dislike_icon"></i><?php echo $this->__('Undislike');?> (<span class="dislike_comment_num"><?php echo $item->DislikeCount;?></span>)</a>
                <a data-opt='{"id":"<?php echo $item->ID_NEWS;?>", "reply": "<?php echo $item->ReplyNumber;?>", "type":"newsreply", "like":"0"}' class="icon_link action_dislike dn dislike_<?php echo $item->ID_NEWS.'_'.$item->ReplyNumber;?>" href="javascript:void(0)"><i class="dislike_icon"></i><?php echo $this->__('Dislike');?> (<span class="dislike_comment_num"><?php echo $item->DislikeCount;?></span>)</a>
                <?php else:?>
                <a data-opt='{"id":"<?php echo $item->ID_NEWS;?>", "reply": "<?php echo $item->ReplyNumber;?>", "type":"newsreply", "like":"0"}' class="icon_link action_dislike dislike_<?php echo $item->ID_NEWS.'_'.$item->ReplyNumber;?>" href="javascript:void(0)"><i class="dislike_icon"></i><?php echo $this->__('Dislike');?> (<span class="dislike_comment_num"><?php echo $item->DislikeCount;?></span>)</a>
                <a data-opt='{"id":"<?php echo $item->ID_NEWS;?>", "reply": "<?php echo $item->ReplyNumber;?>", "type":"newsreply", "like":"0"}' class="icon_link action_undislike dn undislike_<?php echo $item->ID_NEWS.'_'.$item->ReplyNumber;?>" href="javascript:void(0)"><i class="dislike_icon"></i><?php echo $this->__('Undislike');?> (<span class="dislike_comment_num"><?php echo $item->DislikeCount;?></span>)</a>
            <?php endif; ?>
		<?php endif;?>
		<span class="fs10 fft mt15 fclg tac"><?php echo MainHelper::calculateTime($item->LastActivityTime);?></span>
		<?php /* if($item->isOwner() === TRUE):?>
			<a href="javascript:void(0)" rel="<?php echo $item->ID_NEWS.'_'.$item->ReplyNumber;?>" class="pa cal icon_close_newsreply">&nbsp;</a>
		<?php endif; */?>
	</div>
</div>