<?php
	$url = MainHelper::site_url('player/'.$user->URL);
	$nick = PlayerHelper::showName($user);
	$img = MainHelper::showImage($user, THUMB_LIST_60x60, false, array('no_img' => 'noimage/no_player_60x60.png'));
?>
<div class="w580">
	<div class="clearfix">
        <span class="fs22 fft fclg2 fl mr10"><?php echo $this->__('Share news on group wall');?></span>
    </div>
	<div class="mt5 mb5 clearfix">
		<label for="tags" class="cp"><?php echo $this->__('Search groups');?></label>
		<div class="border mt2 rounded5 h16 pt5 pb5 w570 pl4 pr4" id="group_tags">
			<input name="group_affiliate" class="news_border dn F_gid" id="tags" value="" />
		</div>
	</div>
	<div class="mb10">
		<textarea id="sharePost" rows="1" class="ta pl4 pr4 pt5 pb3 rounded5 w570" cols="1" title="<?php echo $this->__('Post text'); ?>"><?php echo $this->__('Post text'); ?></textarea>
	</div>

	<?php echo $post; ?>

	<div class="mt10 clerfix">
		<div class="add_button clearfix fl">
			<a href="javascript:void(0)" class="button button_medium mint F_closeFancybox"><?php echo $this->__('Cancel'); ?></a>
		</div>
		<div class="add_button clearfix fr">
			<a href="javascript:void(0)" class="button button_large mint F_shareOnGroupWall" data-opt='{"otype": "<?php echo $otype; ?>", "oid" : "<?php echo $oid; ?>", "olang" : "<?php echo $olang; ?>", "id": "<?php echo $user->URL; ?>", "type": "<?php echo WALL_OWNER_GROUP; ?>"}' ><?php echo $this->__('Post on group wall'); ?></a>
		</div>
	</div>
</div>