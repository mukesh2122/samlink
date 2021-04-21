<div class="w580 clearfix">
	<!-- header -->
	<div class="clearfix">
		<span class="fs22 fft fclg2 fl mr10"><?php echo $this->__('Share news by message');?></span>
	</div>
	<!-- end header -->

	<div class="comments-cont mt10 clearfix">
		<div class="comments-top">
			  <div class="comments-bot clearfix pr">
				<span class="fl db fclg fs12 pr5 pb5"><?php echo $this->__('To');?>:</span>
				<span class="fl db w400 oh"><input name="tags" class="dn" id="tags" value="<?php echo isset($friend) ? $friend->FirstName : '';?>  " /></span>
			  </div>
		</div>
	</div>

	<div class="mt10">
		<textarea id="sharePost" rows="1" class="ta pl4 pr4 pt5 pb3 rounded5 w570" cols="1" title="<?php echo $this->__('Post text'); ?>"><?php echo $this->__('Post text'); ?></textarea>
	</div>
	
	<div class="mt10 clerfix">
		<div class="add_button clearfix fl">
			<a href="javascript:void(0)" class="button button_medium mint F_closeFancybox"><?php echo $this->__('Cancel'); ?></a>
		</div>
		<div class="add_button clearfix fr">
			<a href="javascript:void(0)" class="button button_large mint F_shareMessage" data-opt='{"otype": "<?php echo $otype; ?>", "oid" : "<?php echo $oid; ?>", "olang" : "<?php echo $olang; ?>"}' ><?php echo $this->__('Send message'); ?></a>
		</div>
	</div>
</div>