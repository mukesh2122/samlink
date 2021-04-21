<div class="message_container">
    <!-- header -->
    <div class="clearfix">
        <span class="fs22 fft fclg2 fl mr10"><?php echo $this->__('Ban User'); ?></span>
    </div>
    <!-- end header -->
    <form action="#" method="post" id="ban_from_forum"  > 
		<input type="hidden" id="type" name="type" value ="<?php echo $type; ?>" >
		<input type="hidden" id="id" name="id" value ="<?php echo $id; ?>" >
		<input type="hidden" id="id_player" name="id_player" value="<?php echo $id_player; ?>">
		<input type="hidden" id="playersIP" name="playersIP" value="<?php echo $playersIP; ?>">
		

		<div class="mt5">
			<div><?php echo $this->__('How long shall the user, '.$playername.', be banned for ?' );?></div>
			<div class="border mt2">
					
				<div>
					<input type="radio" name="ban_time" value="3"><?php echo $this->__(' 3 days'); ?><br>
					<input type="radio" name="ban_time" value="7"><?php echo $this->__(' 1 week'); ?> <br>
					<input type="radio" name="ban_time" value="14"><?php echo $this->__(' 2 week'); ?> <br>
					<input type="radio" name="ban_time" value="21"><?php echo $this->__(' 3 week'); ?> <br>
					<input type="radio" name="ban_time" value="28"><?php echo $this->__(' 4 week'); ?> <br>
					<input type="radio" name="ban_time" value="-1"><?php echo $this->__(' for ever'); ?> <br>
				</div>
				<div class="mt10">
					<?php echo $this->__('What shall the user, '.$playername.', be banned from ?' )?><br>
					<input type="radio" name="ban_from" value="0"><?php echo $this->__(' The entire forum'); ?> <br>
					<input type="radio" name="ban_from" value="<?php echo $board_id; ?>"> <?php echo $this->__(' This board only'); ?> <br>
				</div>
			</div>
		</div>
		
		<a href="javascript:void(0)" class="roundedButton grey fr add_ban_user mt10">
			<span class="lrc"></span>
			<span class="mrc"><?php echo $this->__('Ban this user'); ?></span>
			<span class="rrc"></span>
		</a>
	</form>
</div>
