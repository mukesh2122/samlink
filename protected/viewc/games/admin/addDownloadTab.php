<div class="message_container">
    <!-- header -->
    <div class="clearfix">
        <span class="fs22 fft fclg2 fl mr10"><?php echo $this->__('Add New Tab'); ?></span>
    </div>
    <!-- end header -->
    <form action="#" method="post" id="addtab_game_form">
        <input type="hidden" name="game_id" value="<?php echo $game->ID_GAME; ?>">

		<div class="mt5">
			<label for="tabName" class="cp"><?php echo $this->__('Name'); ?></label>
			<div class="border mt2">
				<input name="tab_name" class="w576 news_border tab_name" id="tabName">
			</div>
		</div>

        <div class="clear mt10">&nbsp;</div>
        <a href="javascript:void(0);" class="link_green fr addtab_game"><span><span><?php echo $this->__('Add'); ?></span></span></a>
    </form>
</div>