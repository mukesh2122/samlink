<div class="message_container">
    <!-- header -->
    <div class="clearfix">
        <span class="fs22 fft fclg2 fl mr10"><?php echo strlen($gameRel->Comments) > 0 ? $this->__('Edit Description') : $this->__('Write Description'); ?></span>
    </div>
    <!-- end header -->
    <form action="#" method="post" id="write_game_desc_form">
        <input type="hidden" name="game_id" value="<?php echo $gameRel->ID_GAME; ?>" />
        <div class="comments-cont mt10">
            <div class="comments-top">
                <div class="comments-bot pr">
                    <textarea name="game_description" rows="1" class="ta message_block comment_block" cols="1" title="<?php echo $this->__('Game Description >'); ?>"><?php echo strlen($gameRel->Comments) > 0 ? $gameRel->Comments : $this->__('Game Description >'); ?></textarea>
                </div>
            </div>
        </div>  

        <div class="clear mt10">&nbsp;</div>
        <a href="javascript:void(0)" class="link_green fr write_game_desc"><span><span><?php echo $this->__('Save'); ?></span></span></a>
    </form>
</div>