<?php
	$friendNames = '';
	if (isset($friends))
	{
		foreach ($friends as $friend)
		{
			$friendNames .= (($friendNames == '') ? '' : ', ').$friend->DisplayName;
		}
	}
?>
<div class="message_container">
	<!-- header -->
	<div class="clearfix">
		<span class="fs22 fft fclg2 fl mr10"><?php echo $this->__('New Message');?></span>
	</div>
	<!-- end header -->
	
	 
	<div class="comments-cont mt10">
		<div class="comments-top">
			  <div class="comments-bot clearfix pr">
				<span class="fl db fclg fs12 pr5 pb5"><?php echo $this->__('To');?>:</span>
				<input type="hidden" id="conversation" value="<?php echo $conversation->ID_CONVERSATION;?>" />
				<span class="fl db"><?php echo $friendNames; ?></span>
			  </div>
		</div>
	</div>
	
	<div class="comments-cont mt10">
		<div class="comments-top">
			  <div class="comments-bot pr">
				<textarea id="message_text" rows="1" class="ta message_block comment_block" cols="1" title="<?php echo $this->__('Message >');?>"><?php echo isset($message) ? $message : $this->__('Message >');?></textarea>
				<a class="pa conv_message_post fft link_blue" href="javascript:void(0)"><span><span><?php echo $this->__('Send');?></span></span></a>
			  </div>
		</div>
	</div> 
	
</div>