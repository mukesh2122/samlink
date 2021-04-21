<div class="message_container">
    <!-- header -->
    <div class="clearfix">
        <span class="fs22 fft fclg2 fl mr10"><?php echo $this->__('Delete reply'); ?></span>
    </div>
    <!-- end header -->
    <form  method="post" id="DeleteReply"> 
    	<input type="hidden" id="type" name="type" value="<?php echo $type; ?>" />
        <input type="hidden" id="id" name="id" value="<?php echo $id; ?>" />
        <input type="hidden" id="board_id" name="board_id" value="<?php echo $board_id; ?>" />
        <input type="hidden" id="topic_id" name="topic_id" value="<?php echo $topic_id; ?>" />
        <input type="hidden" id="msg_id" name="msg_id" value="<?php echo $msg_id; ?>" />

		<div class="mt5">
			<div class="border mt2">
				<?php echo $this->__('Here you sure you want to delete this reply?'); ?>
				
			</div>
		</div>
				 
		<a href="javascript:void(0)" class="deleteMessage_yes roundedButton grey fr  mr20 mt10"> 
			<span class="lrc"></span>
			<span class="mrc">  <?php echo $this->__('YES'); ?> </span>
			<span class="rrc"></span> 
		</a> 
		<a href="javascript:void(0)" class="deleteMessage_no roundedButton grey fr mr10  mt10"> 
			<span class="lrc"></span>
			<span class="mrc">  <?php echo $this->__('NO'); ?> </span>
			<span class="rrc"></span> 
		</a> 
		
	</form>
</div>
