<?php
?>
<input type="hidden" id="ID_PLAYER" name="ID_PLAYER" value="<?php echo $player->ID_PLAYER; ?>" />
<div class="message_container">
	<!-- header -->
	<div class="comments-cont mt10">
        <div class="comments-top">
              <div class="comments-bot clearfix pr">
		<span class="fs22 fft fclg2 fl mr10"><?php echo $this->__('Change your email');?></span>
              </div>
        </div>
    </div>
	<!-- end header -->
	
    <div class="comments-cont mt10">
        <div class="comments-top">
              <div class="comments-bot pr">
                <textarea id="newemail" name="newemail" rows="1" class="ta message_block comment_block" cols="1" title="<?php echo $this->__('Email address >');?>"></textarea>
				<a class="pa changeemail_post fft link_blue" href="javascript:void(0)"><span><span><?php echo $this->__('Ok');?></span></span></a>
              </div>
        </div>
    </div> 
</div>