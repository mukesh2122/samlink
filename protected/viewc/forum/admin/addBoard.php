<div class="message_container">
    <!-- header -->
    <div class="clearfix">
        <span class="fs22 fft fclg2 fl mr10"><?php echo $this->__('Add Board'); ?></span>
    </div>
    <!-- end header -->
    <form action="#" method="post" id="add_forum_board_form">
        <input type="hidden" name="type" value="<?php echo $type; ?>" />
        <input type="hidden" name="id" value="<?php echo $id; ?>" />
        <input type="hidden" name="cat_id" value="<?php echo $cat_id; ?>" />

		<div class="mt5">
			<label for="boardName" class="cp"><?php echo $this->__('Board name');?></label>
			<div class="border mt2">
				<input name="board_name" class="w576 news_border board_name" id="boardName" />
			</div>
		</div>
		
		<a href="javascript:void(0)" class="roundedButton grey fr add_forum_board mt10">
			<span class="lrc"></span>
			<span class="mrc"><?php echo $this->__('Create'); ?></span>
			<span class="rrc"></span>
		</a>
	</form>
</div>