<!-- Wall item actions start -->
<?php
$viewer = User::getUser();
$suspendLevel = ($viewer) ? $viewer->getSuspendLevel() : 0;
$nocommenting = ($suspendLevel==1 || $suspendLevel==2) && $viewer->ID_PLAYER==$item->ID_OWNER;
$noSiteFunctionality = ($suspendLevel==2 || $suspendLevel==4);
if($item->WallOwnerType==WALL_OWNER_EVENT && $item->ID_EVENT>0) {
    $admin = $list['isAdmin'];
    $participating = $list['isParticipating'];
    $subscribed = $list['isSubscribed'];
    $eventCommentAccess = $admin || $participating || $subscribed ? true : false;
}
?>
<ul class="wall_item_footer">
	<li>
		<a class="icon_link action_viewcomments vc_<?php echo $item->ID_WALLITEM;?> <?php echo isset($all_comments) ? 'dn' : '';?>" 
		rel="<?php echo $item->ID_WALLITEM;?>" href="javascript:void(0)"><i class="comment_icon"></i><?php echo $this->__('Show comments');?> (<span class="comments_num_<?php echo $item->ID_WALLITEM;?>"><?php echo $item->Replies;?></span>)</a>

		<a class="icon_link action_hidecomments hc_<?php echo $item->ID_WALLITEM;?> <?php echo isset($all_comments) ? '' : 'dn';?>" 
		rel="<?php echo $item->ID_WALLITEM;?>" href="javascript:void(0)"><i class="comment_icon"></i><?php echo $this->__('Hide comments');?> (<span class="comments_num_<?php echo $item->ID_WALLITEM;?>"><?php echo $item->Replies;?></span>)</a>
	</li>
	<li>
		<?php if(Auth::isUserLogged() && !$nocommenting && !$noSiteFunctionality):?>
			<?php if($item->isLiked()):?>
				<a data-opt='{"id":"<?php echo $item->ID_WALLITEM;?>", "reply": "0", "type":"<?php echo $item->ItemType;?>", "like":"1"}' class="icon_link action_unlike unlike_<?php echo $item->ID_WALLITEM;?>_0" href="javascript:void(0)"><i class="like_icon"></i><?php echo $this->__('Unlike');?> (<span class="like_comment_num"><?php echo $item->LikeCount;?></span>)</a>
				<a data-opt='{"id":"<?php echo $item->ID_WALLITEM;?>", "reply": "0", "type":"<?php echo $item->ItemType;?>", "like":"1"}' class="icon_link action_like dn like_<?php echo $item->ID_WALLITEM;?>_0" href="javascript:void(0)"><i class="like_icon"></i><?php echo $this->__('Like');?> (<span class="like_comment_num"><?php echo $item->LikeCount;?></span>)</a>
			<?php else:?>
				<a data-opt='{"id":"<?php echo $item->ID_WALLITEM;?>", "reply": "0", "type":"<?php echo $item->ItemType;?>", "like":"1"}' class="icon_link action_like like_<?php echo $item->ID_WALLITEM;?>_0" href="javascript:void(0)"><i class="like_icon"></i><?php echo $this->__('Like');?> (<span class="like_comment_num"><?php echo $item->LikeCount;?></span>)</a>
				<a data-opt='{"id":"<?php echo $item->ID_WALLITEM;?>", "reply": "0", "type":"<?php echo $item->ItemType;?>", "like":"1"}' class="icon_link action_unlike dn unlike_<?php echo $item->ID_WALLITEM;?>_0" href="javascript:void(0)"><i class="like_icon"></i><?php echo $this->__('Unlike');?> (<span class="like_comment_num"><?php echo $item->LikeCount;?></span>)</a>
			<?php endif; ?>
            
            <?php if($item->isDisliked()): //Added?>
				<a data-opt='{"id":"<?php echo $item->ID_WALLITEM;?>", "reply": "0", "type":"<?php echo $item->ItemType;?>", "like":"0"}' class="icon_link action_undislike undislike_<?php echo $item->ID_WALLITEM;?>_0" href="javascript:void(0)"><i class="dislike_icon"></i><?php echo $this->__('Undislike');?> (<span class="dislike_comment_num"><?php echo $item->DislikeCount;?></span>)</a>
				<a data-opt='{"id":"<?php echo $item->ID_WALLITEM;?>", "reply": "0", "type":"<?php echo $item->ItemType;?>", "like":"0"}' class="icon_link action_dislike dn dislike_<?php echo $item->ID_WALLITEM;?>_0" href="javascript:void(0)"><i class="dislike_icon"></i><?php echo $this->__('Dislike');?> (<span class="dislike_comment_num"><?php echo $item->DislikeCount;?></span>)</a>
                <?php else:?>
				<a data-opt='{"id":"<?php echo $item->ID_WALLITEM;?>", "reply": "0", "type":"<?php echo $item->ItemType;?>", "like":"0"}' class="icon_link action_dislike dislike_<?php echo $item->ID_WALLITEM;?>_0" href="javascript:void(0)"><i class="dislike_icon"></i><?php echo $this->__('Dislike');?> (<span class="dislike_comment_num"><?php echo $item->DislikeCount;?></span>)</a>
				<a data-opt='{"id":"<?php echo $item->ID_WALLITEM;?>", "reply": "0", "type":"<?php echo $item->ItemType;?>", "like":"0"}' class="icon_link action_undislike dn undislike_<?php echo $item->ID_WALLITEM;?>_0" href="javascript:void(0)"><i class="dislike_icon"></i><?php echo $this->__('Undislike');?> (<span class="dislike_comment_num"><?php echo $item->DislikeCount;?></span>)</a>
            <?php endif; ?>
	<?php endif; ?>
	</li>
	<li class="wall_item_date">
		<span><?php echo MainHelper::calculateTime($item->PostingTime) ?></span>
	</li>
</ul>
<!-- Wall item actions end -->

<!-- Wall item comments start -->
<div class="wall_item_comment_container">
	<div class="wall_item_comments <?php echo isset($all_comments) or (isset($comments) and !empty($comments)) ? '' : 'dn ';?>">
		<div class="comments_block_<?php echo $item->ID_WALLITEM;?>">
			<?php echo isset($all_comments) ? $all_comments : ' '; ?>
			<?php if(isset($comments)): ?>
				<?php echo $comments; ?>
			<?php endif; ?>
		</div>
	</div>

	<div class="wall_item_comment_input">
		<?php if(Auth::isUserLogged() && !$nocommenting && !$noSiteFunctionality):?>
                    <?php if($item->WallOwnerType==WALL_OWNER_EVENT && $item->ID_EVENT>0 && isset($eventCommentAccess) && $eventCommentAccess): // if type is event you need to either participate or be subscribed to comment?>
			<textarea rows='1' id="comment_<?php echo $item->ID_WALLITEM;?>" class="autoSize titleAttr comment_block" title="<?php echo $this->__('Comment...');?>"><?php echo $this->__('Comment...');?></textarea>
			<a class="wall_item_comment_input_button comment_post" rel="comment_<?php echo $item->ID_WALLITEM;?>" href="javascript:void(0)"><?php echo $this->__('Comment');?></a>
                    <?php else: ?>
                        <textarea rows='1' id="comment_<?php echo $item->ID_WALLITEM;?>" class="autoSize titleAttr comment_block" title="<?php echo $this->__('Comment...');?>"><?php echo $this->__('Comment...');?></textarea>
			<a class="wall_item_comment_input_button comment_post" rel="comment_<?php echo $item->ID_WALLITEM;?>" href="javascript:void(0)"><?php echo $this->__('Comment');?></a>
                    <?php endif;?>
		<?php endif; ?>
	</div>

</div>
<!-- Wall item comments end -->





<?php /*
<div class="mt10 post_body clearfix w530 fr">
	
    <a class="link_icon icon_viewnewscomments action_viewcomments vc_<?php echo $item->ID_WALLITEM;?> <?php echo isset($all_comments) ? 'dn' : '';?>" 
	   rel="<?php echo $item->ID_WALLITEM;?>" href="javascript:void(0)"><?php echo $this->__('Show comments');?> (<span class="comments_num_<?php echo $item->ID_WALLITEM;?>"><?php echo $item->Replies;?></span>)</a>
	   
    <a class="link_icon icon_viewnewscomments action_hidecomments hc_<?php echo $item->ID_WALLITEM;?> <?php echo isset($all_comments) ? '' : 'dn';?>" 
	   rel="<?php echo $item->ID_WALLITEM;?>" href="javascript:void(0)"><?php echo $this->__('Hide comments');?> (<span class="comments_num_<?php echo $item->ID_WALLITEM;?>"><?php echo $item->Replies;?></span>)</a>
	   
	<?php if(Auth::isUserLogged()):?>
		<?php if($item->isLiked()):?>
			<a data-opt='{"id":"<?php echo $item->ID_WALLITEM;?>", "reply": "0", "type":"<?php echo $item->ItemType;?>"}' class="link_icon icon_like action_unlike unlike_<?php echo $item->ID_WALLITEM;?>_0" href="javascript:void(0)"><?php echo $this->__('Unlike');?> (<span class="like_comment_num"><?php echo $item->LikeCount;?></span>)</a>
			<a data-opt='{"id":"<?php echo $item->ID_WALLITEM;?>", "reply": "0", "type":"<?php echo $item->ItemType;?>"}' class="link_icon icon_like action_like dn like_<?php echo $item->ID_WALLITEM;?>_0" href="javascript:void(0)"><?php echo $this->__('Like');?> (<span class="like_comment_num"><?php echo $item->LikeCount;?></span>)</a>
		<?php else:?>
			<a data-opt='{"id":"<?php echo $item->ID_WALLITEM;?>", "reply": "0", "type":"<?php echo $item->ItemType;?>"}' class="link_icon icon_like action_like like_<?php echo $item->ID_WALLITEM;?>_0" href="javascript:void(0)"><?php echo $this->__('Like');?> (<span class="like_comment_num"><?php echo $item->LikeCount;?></span>)</a>
			<a data-opt='{"id":"<?php echo $item->ID_WALLITEM;?>", "reply": "0", "type":"<?php echo $item->ItemType;?>"}' class="link_icon icon_like action_unlike dn unlike_<?php echo $item->ID_WALLITEM;?>_0" href="javascript:void(0)"><?php echo $this->__('Unlike');?> (<span class="like_comment_num"><?php echo $item->LikeCount;?></span>)</a>
		<?php endif; ?>
	<?php endif; ?>
	<?php /* if(Auth::isUserLogged()):?>
		<a class="link_icon icon_share action_share" rel="<?php echo $item->ItemType.'_'.$item->ID_WALLITEM;?>_0" href="javascript:void(0)">
			<?php echo $this->__('Share');?> (<span class="like_comment_num"><?php echo $item->LikeCount;?></span>)
		</a>
	<?php endif; ?>
	   
    <?php /* if($item->isOwner() === FALSE):?>
        <a class="link_icon icon_share" href="#">Share</a>
    <?php endif; ?>
    <?php if(false and $item->isOwner() === TRUE):?>
        <?php if($item->Public == 1):?>
            <a class="link_icon icon_makeprivate action_makeprivate" rel="<?php echo $item->ID_WALLITEM;?>" href="javascript:void(0)">Make Private</a>
            <a class="link_icon icon_makepublic dn action_makepublic" rel="<?php echo $item->ID_WALLITEM;?>" href="javascript:void(0)">Make Public</a>
        <?php else: ?>
            <a class="link_icon icon_makeprivate dn action_makeprivate" rel="<?php echo $item->ID_WALLITEM;?>" href="javascript:void(0)">Make Private</a>
            <a class="link_icon icon_makepublic action_makepublic" rel="<?php echo $item->ID_WALLITEM;?>" href="javascript:void(0)">Make Public</a>
        <?php endif; ?>
        
    <?php endif; ?>
			
			<span class="fclg"><?php echo MainHelper::calculateTime($item->LastActivityTime); ?></span>
</div>

<!-- comments -->
<div class="clearfix">
	<div class="w530 fr clearfix pt10">
		<div class="comments_block <?php echo isset($all_comments) or (isset($comments) and !empty($comments)) ? '' : 'dn ';?> clearfix">
			<div class="comments_block_<?php echo $item->ID_WALLITEM;?>">
			<?php echo isset($all_comments) ? $all_comments : ' ';?>
				<?php if(isset($comments)){
					echo $comments;
				} ?>
			</div>
		</div>
		<?php if(Auth::isUserLogged()):?>
			<div class="comments-cont">
				<div class="comments-top">
					  <div class="comments-bot pr">
						<textarea id="comment_<?php echo $item->ID_WALLITEM;?>" rows="1" class="ta comment_block" cols="1" title="<?php echo $this->__('Comment...');?>"><?php echo $this->__('Comment...');?></textarea>
						<a class="pa comment_post commentInside fft link_comment" rel="comment_<?php echo $item->ID_WALLITEM;?>" href="javascript:void(0)"><?php echo $this->__('Comment');?></a>
					  </div>
				</div>
			</div>
		<?php endif; ?>
	</div>
</div>
<!-- end comments -->
*/ ?>
