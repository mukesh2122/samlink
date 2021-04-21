<div class="message_container">
    <!-- header -->
    <div class="clearfix">
        <span class="fs22 fft fclg2 fl mr10"><?php echo $this->__('Edit Board'); ?></span>
    </div>
    <!-- end header -->
    <form action="#" method="post" id="ChangeBoardOrder"> 
    	<input type="hidden" name="type" value="<?php echo $type; ?>" />
        <input type="hidden" name="id" value="<?php echo $id; ?>" />
        <input type="hidden" name="cat_id" value="<?php echo $cat_id; ?>" />
        <input type="hidden" name="board_id" value="<?php echo $board_id ?>" />

		<div class="mt5">
			<label for="boardName" class="cp"><?php echo $this->__('Board Order');?></label>
			<div class="border mt2">
				<input name="board_order" class="w576 news_border board_name" id="BoardOrderNr" value="<?php echo $board->BoardOrder; ?>" />
			</div>
		</div>
		
		<a href="javascript:void(0)" class="UpdateBoardOrder roundedButton grey fr  mt10"> 
			<span class="lrc"></span>
			<span class="mrc">  <?php echo $this->__('Update'); ?> </span>
			<span class="rrc"></span>
		</a>  

	</form>
</div>




