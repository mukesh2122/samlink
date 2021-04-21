<div class="message_container">
    <!-- header -->
    <div class="clearfix">
        <span class="fs22 fft fclg2 fl mr10"><?php echo $this->__('Delete poll'); ?></span>
    </div>
    <!-- end header -->
    <form action="#" method="post" id="DeletePoll"> 
    	<input type="hidden" name="type" value="<?php echo $type; ?>" />
        <input type="hidden" name="id" value="<?php echo $id; ?>" />
       
        <input type="hidden" name="board_id" id="board_id" value="<?php echo $board_id ?>" />
        <input type="hidden" name="topic_id" id="topic_id" value="<?php echo $topic_id; ?>" />
        <input type="hidden" name="poll_id" id="poll_id" value="<?php echo $poll_id; ?>" />
        <input type="hidden" name="msg_id" id="msg_id" value="<?php echo $firstMsgID; ?>" />
			<?php
			//var_dump($_POST);
			?>
		<div class="mt5">
			<div class="border mt2">
				<?php
				 echo $this->__('Are you sure, you want to delete this poll?') ;
				?>
			</div>
		</div>
		
		<a href="javascript:void(0)" class="deletePoll_yes roundedButton grey fr  mr20 mt10"> 
			<span class="lrc"></span>
			<span class="mrc">  <?php echo $this->__('YES'); ?> </span>
			<span class="rrc"></span> 
		</a> 
		<a href="javascript:void(0)" class="deletePoll_no roundedButton grey fr mr10  mt10"> 
			<span class="lrc"></span>
			<span class="mrc">  <?php echo $this->__('NO'); ?> </span>
			<span class="rrc"></span> 
		</a> 
		
	</form>
</div>