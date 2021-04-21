<!-- Wall item actions start -->
<?php
$viewer = User::getUser();
$suspendLevel = ($viewer) ? $viewer->getSuspendLevel() : 0;
$nocommenting = ($suspendLevel==1 || $suspendLevel==2) && $viewer->ID_PLAYER==$item->ID_OWNER;
$noSiteFunctionality = ($suspendLevel==2 || $suspendLevel==4);
?>
<script type="text/javascript">
	$(document).ready(function(){
		$('a#show_comments').click();   // Show comments as default
	});
</script>
<ul class="wall_item_footer">
	<li>
		<a id="show_comments" class="icon_link action_viewcomments vc_<?php echo $item->ID_WALLITEM;?> <?php echo isset($all_comments) ? 'dn' : '';?>" 
		rel="<?php echo $item->ID_WALLITEM;?>" href="javascript:void(0)"><i class="comment_icon"></i><?php echo $this->__('Show comments');?> (<span class="comments_num_<?php echo $item->ID_WALLITEM;?>"><?php echo $item->Replies;?></span>)</a>

		<a class="icon_link action_hidecomments hc_<?php echo $item->ID_WALLITEM;?> <?php echo isset($all_comments) ? '' : 'dn';?>" 
		rel="<?php echo $item->ID_WALLITEM;?>" href="javascript:void(0)"><i class="comment_icon"></i><?php echo $this->__('Hide comments');?> (<span class="comments_num_<?php echo $item->ID_WALLITEM;?>"><?php echo $item->Replies;?></span>)</a>
	</li>
	<li>
		<?php if(Auth::isUserLogged() && !$nocommenting && !$noSiteFunctionality):?>
			<?php if($item->isLiked()):?>
				<a data-opt='{"id":"<?php echo $item->ID_WALLITEM;?>", "reply": "0", "type":"<?php echo $item->ItemType;?>"}' class="icon_link action_unlike unlike_<?php echo $item->ID_WALLITEM;?>_0" href="javascript:void(0)"><i class="like_icon"></i><?php echo $this->__('Unlike');?> (<span class="like_comment_num"><?php echo $item->LikeCount;?></span>)</a>
				<a data-opt='{"id":"<?php echo $item->ID_WALLITEM;?>", "reply": "0", "type":"<?php echo $item->ItemType;?>"}' class="icon_link action_like dn like_<?php echo $item->ID_WALLITEM;?>_0" href="javascript:void(0)"><i class="like_icon"></i><?php echo $this->__('Like');?> (<span class="like_comment_num"><?php echo $item->LikeCount;?></span>)</a>
			<?php else:?>
				<a data-opt='{"id":"<?php echo $item->ID_WALLITEM;?>", "reply": "0", "type":"<?php echo $item->ItemType;?>"}' class="icon_link action_like like_<?php echo $item->ID_WALLITEM;?>_0" href="javascript:void(0)"><i class="like_icon"></i><?php echo $this->__('Like');?> (<span class="like_comment_num"><?php echo $item->LikeCount;?></span>)</a>
				<a data-opt='{"id":"<?php echo $item->ID_WALLITEM;?>", "reply": "0", "type":"<?php echo $item->ItemType;?>"}' class="icon_link action_unlike dn unlike_<?php echo $item->ID_WALLITEM;?>_0" href="javascript:void(0)"><i class="like_icon"></i><?php echo $this->__('Unlike');?> (<span class="like_comment_num"><?php echo $item->LikeCount;?></span>)</a>
			<?php endif; ?>
	<?php endif; ?>
	</li>
	<li class="wall_item_date">
		<span><?php echo MainHelper::calculateTime($item->PostingTime) ?></span>
	</li>
</ul>
<!-- Wall item actions end -->

<!-- Wall item comments start -->
<div class="ug_wall_item_comment_container_narrow">

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
			<textarea rows='1' id="comment_<?php echo $item->ID_WALLITEM;?>" class="autoSize titleAttr comment_block" title="<?php echo $this->__('Comment...');?>"><?php echo $this->__('Comment...');?></textarea>
			<a class="wall_item_comment_input_button comment_post" rel="comment_<?php echo $item->ID_WALLITEM;?>" href="javascript:void(0)"><?php echo $this->__('Comment');?></a>
		<?php endif; ?>
	</div>

</div>
<!-- Wall item comments end -->
