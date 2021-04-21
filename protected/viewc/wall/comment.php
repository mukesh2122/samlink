<?php $nick = PlayerHelper::showName($poster); ?>
<?php $img = MainHelper::showImage($poster, THUMB_LIST_40x40, false, array('no_img' => 'noimage/no_player_40x40.png')); ?>
<?php
	$viewer = User::getUser();
	$suspendLevel = ($viewer) ? $viewer->getSuspendLevel() : 0;
	$nocommenting = ($suspendLevel==1 || $suspendLevel==2) && $viewer->ID_PLAYER==$item->ID_OWNER;
	$noSiteFunctionality = ($suspendLevel==2 || $suspendLevel==4);
 ?>
<!-- Wall comment item start -->
<div class="wall_item_comment clearfix itemPost reply_<?php echo $item->ID_WALLITEM.'_'.$item->ReplyNumber;?>">
	<a class="wall_item_comment_img" title="<?php echo $nick;?>" href="<?php echo MainHelper::site_url('player/'.$poster->URL);?>"><?php echo $img;?></a>

	<div class="wall_item_comment_meta">
		<div class="wall_item_comment_text">
			<a href="<?php echo MainHelper::site_url('player/'.$poster->URL);?>"><?php echo $nick;?></a>
			<?php echo nl2br(htmlspecialchars($item->Message));?>
		</div>

		<ul class="wall_item_comment_footer">
			<li>
				<?php if(Auth::isUserLogged() && !$nocommenting && !$noSiteFunctionality):?>
					<?php if($item->isLiked()):?>
						<a data-opt='{"id":"<?php echo $item->ID_WALLITEM;?>", "reply": "<?php echo $item->ReplyNumber;?>", "type":"reply", "like":"1"}' class="icon_link action_unlike unlike_<?php echo $item->ID_WALLITEM.'_'.$item->ReplyNumber;?>" href="javascript:void(0)"><i class="like_icon"></i><?php echo $this->__('Unlike');?> (<span class="like_comment_num"><?php echo $item->LikeCount;?></span>)</a>
						<a data-opt='{"id":"<?php echo $item->ID_WALLITEM;?>", "reply": "<?php echo $item->ReplyNumber;?>", "type":"reply", "like":"1"}' class="icon_link action_like dn like_<?php echo $item->ID_WALLITEM.'_'.$item->ReplyNumber;?>" href="javascript:void(0)"><i class="like_icon"></i><?php echo $this->__('Like');?> (<span class="like_comment_num"><?php echo $item->LikeCount;?></span>)</a>
					<?php else:?>
						<a data-opt='{"id":"<?php echo $item->ID_WALLITEM;?>", "reply": "<?php echo $item->ReplyNumber;?>", "type":"reply", "like":"1"}' class="icon_link action_like like_<?php echo $item->ID_WALLITEM.'_'.$item->ReplyNumber;?>" href="javascript:void(0)"><i class="like_icon"></i><?php echo $this->__('Like');?> (<span class="like_comment_num"><?php echo $item->LikeCount;?></span>)</a>
						<a data-opt='{"id":"<?php echo $item->ID_WALLITEM;?>", "reply": "<?php echo $item->ReplyNumber;?>", "type":"reply", "like":"1"}' class="icon_link action_unlike dn unlike_<?php echo $item->ID_WALLITEM.'_'.$item->ReplyNumber;?>" href="javascript:void(0)"><i class="like_icon"></i><?php echo $this->__('Unlike');?> (<span class="like_comment_num"><?php echo $item->LikeCount;?></span>)</a>
					<?php endif; ?>
            
					<?php if($item->isDisliked()):?>
                        <a data-opt='{"id":"<?php echo $item->ID_WALLITEM;?>", "reply": "<?php echo $item->ReplyNumber;?>", "type":"reply", "like":"0"}' class="icon_link action_undislike undislike_<?php echo $item->ID_WALLITEM.'_'.$item->ReplyNumber;?>" href="javascript:void(0)"><i class="dislike_icon"></i><?php echo $this->__('Undislike');?> (<span class="dislike_comment_num"><?php echo $item->DislikeCount;?></span>)</a>
                        <a data-opt='{"id":"<?php echo $item->ID_WALLITEM;?>", "reply": "<?php echo $item->ReplyNumber;?>", "type":"reply", "like":"0"}' class="icon_link action_dislike dn dislike_<?php echo $item->ID_WALLITEM.'_'.$item->ReplyNumber;?>" href="javascript:void(0)"><i class="dislike_icon"></i><?php echo $this->__('Dislike');?> (<span class="dislike_comment_num"><?php echo $item->DislikeCount;?></span>)</a>
                        <?php else:?>
                        <a data-opt='{"id":"<?php echo $item->ID_WALLITEM;?>", "reply": "<?php echo $item->ReplyNumber;?>", "type":"reply", "like":"0"}' class="icon_link action_dislike dislike_<?php echo $item->ID_WALLITEM.'_'.$item->ReplyNumber;?>" href="javascript:void(0)"><i class="dislike_icon"></i><?php echo $this->__('Dislike');?> (<span class="dislike_comment_num"><?php echo $item->DislikeCount;?></span>)</a>
                        <a data-opt='{"id":"<?php echo $item->ID_WALLITEM;?>", "reply": "<?php echo $item->ReplyNumber;?>", "type":"reply", "like":"0"}' class="icon_link action_undislike dn undislike_<?php echo $item->ID_WALLITEM.'_'.$item->ReplyNumber;?>" href="javascript:void(0)"><i class="dislike_icon"></i><?php echo $this->__('Undislike');?> (<span class="dislike_comment_num"><?php echo $item->DislikeCount;?></span>)</a>
                    <?php endif; ?>
				<?php endif; ?>
			</li>
			<li>
				<span class="wall_item_date"><?php echo MainHelper::calculateTime($item->LastActivityTime);?></span>
			</li>
		</ul>

		<?php if(($item->isOwner() or $item->isWallOwner()) && !$nocommenting): ?>
			<div class="comment_item_delete">
				<a class="comment_item_delete_trigger delete_reply" data-opt='{}' rel="<?php echo $item->ID_WALLITEM.'_'.$item->ReplyNumber;?>" href="javascript:void(0)">&times;</a>
			</div>
		<?php endif;?>
	</div>
</div>
<!-- Wall comment item end -->





<?php /*
<?php
    $nick = PlayerHelper::showName($poster);
    $img = MainHelper::showImage($poster, THUMB_LIST_40x40, false, array('no_img' => 'noimage/no_player_40x40.png'));
?>

<div class="mt10 mr5 ml5 clearfix dot_bot pb5 reply_<?php echo $item->ID_WALLITEM.'_'.$item->ReplyNumber;?> itemPost pr">
	<div class="w50 fl db"><a title="<?php echo $nick;?>" href="<?php echo MainHelper::site_url('player/'.$poster->URL);?>"><?php echo $img;?></a></div>
	<div class="grid_6 alpha omega">
		<a href="<?php echo MainHelper::site_url('player/'.$poster->URL);?>"><?php echo $nick;?></a>
		<?php echo nl2br(htmlspecialchars($item->Message));?>
		<div class="clear mt5">&nbsp;</div>

		<?php if(Auth::isUserLogged()):?>
			<?php if($item->isLiked()):?>
				<a data-opt='{"id":"<?php echo $item->ID_WALLITEM;?>", "reply": "<?php echo $item->ReplyNumber;?>", "type":"reply"}' class="link_icon icon_like action_unlike unlike_<?php echo $item->ID_WALLITEM.'_'.$item->ReplyNumber;?>" href="javascript:void(0)"><?php echo $this->__('Unlike');?> (<span class="like_comment_num"><?php echo $item->LikeCount;?></span>)</a>
				<a data-opt='{"id":"<?php echo $item->ID_WALLITEM;?>", "reply": "<?php echo $item->ReplyNumber;?>", "type":"reply"}' class="link_icon icon_like action_like dn like_<?php echo $item->ID_WALLITEM.'_'.$item->ReplyNumber;?>" href="javascript:void(0)"><?php echo $this->__('Like');?> (<span class="like_comment_num"><?php echo $item->LikeCount;?></span>)</a>
			<?php else:?>
				<a data-opt='{"id":"<?php echo $item->ID_WALLITEM;?>", "reply": "<?php echo $item->ReplyNumber;?>", "type":"reply"}' class="link_icon icon_like action_like like_<?php echo $item->ID_WALLITEM.'_'.$item->ReplyNumber;?>" href="javascript:void(0)"><?php echo $this->__('Like');?> (<span class="like_comment_num"><?php echo $item->LikeCount;?></span>)</a>
				<a data-opt='{"id":"<?php echo $item->ID_WALLITEM;?>", "reply": "<?php echo $item->ReplyNumber;?>", "type":"reply"}' class="link_icon icon_like action_unlike dn unlike_<?php echo $item->ID_WALLITEM.'_'.$item->ReplyNumber;?>" href="javascript:void(0)"><?php echo $this->__('Unlike');?> (<span class="like_comment_num"><?php echo $item->LikeCount;?></span>)</a>
			<?php endif; ?>
		<?php endif; ?>

		<span class="fs10 fft mt15 fclg tac"><?php echo MainHelper::calculateTime($item->LastActivityTime);?></span>
		<?php /* if($item->isOwner() === TRUE):?>
			<a href="javascript:void(0)" rel="<?php echo $item->ID_NEWS.'_'.$item->ReplyNumber;?>" class="pa cal icon_close_newsreply">&nbsp;</a>
		<?php endif; ?> *
	</div>

	<?php if($item->isOwner()): ?>
		<a href="javascript:void(0)" class="itemMoreActions iconr_moreActions t0 r0 zi2 pa mt5 dn" rel="<?php echo $item->ID_WALLITEM.'_'.$item->ReplyNumber;?>"></a>
		<div class="itemMoreActionsBlock pa dn">
			<a class="db delete_reply" data-opt='{}' rel="<?php echo $item->ID_WALLITEM.'_'.$item->ReplyNumber;?>" href="javascript:void(0)"><?php echo $this->__('Delete');?></a>
		</div>
	<?php endif;?>
</div>
*/ ?>
