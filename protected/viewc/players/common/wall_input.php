<div class="<?php echo isset($infoBox) ? 'mt10' : ''; ?>">
	<div class="wallpostBoxTop"></div>
	<div class="wallpostBoxMid">
		<div class="wallpostInputTop"></div>
		<div class="wallpostInputMid">
			<textarea id="wall" rows="1" class="ta pl5 pr5 pt2 wallInput" cols="1" title="<?php echo isset($friend_profile) ? $post_text : $this->__('Share your thoughts >');?>"><?php echo isset($friend_profile) ? $post_text : $this->__('Share your thoughts >');?></textarea>
		</div>
		<div class="wallpostInputBottom"></div>
		
		<div class=" mt5 clearfix">
			<div class="fl mt3">
				<span class="iconr_photol fl mr5"></span> 
				<a href="javascript:void(0)" id="photoUplMain" class="fl fcbl3 fs12 mr10"><?php echo $this->__('Upload image'); ?></a> 
				<span class="iconr_videol fl mr5"></span>
				<a href="javascript:void(0)" class="fl fcbl3 fs12 postVideoSwitch"><?php echo $this->__('Post video'); ?></a>
			</div>
			
			<div class="fr">
				<a id="wall_post_<?php echo $wallType; ?>" class="roundedButton blue" href="javascript:void(0)" rel="<?php echo $wallType; ?>">
					<span class="lrc"></span>
					<span class="mrc w60 tac"><?php echo $this->__('Post'); ?></span>
					<span class="rrc"></span>
				</a>
			</div>
		</div>
	</div>
	<div class="clearfix wallpostBoxBottom"></div>
</div>