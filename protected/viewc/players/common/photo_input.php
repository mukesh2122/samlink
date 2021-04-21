<div class="<?php echo isset($infoBox) ? 'mt10' : ''; ?> clearfix">
	<div>
		<div class="videopostInputLeft fl"></div>
		<div class="videopostInputMid fl">
			<input type="text" id="<?php echo $wallType; ?>" 
				   title="<?php echo $this->__("Post images here..."); ?>" 
				   class="fl withLabel" 
				   value="<?php echo $this->__("Post images here..."); ?>" />
			
			<a id="wall_post_<?php echo $wallType; ?>" class="buttonRRound buttonVideoRound fr mt3" 
			   href="javascript:void(0)" rel="<?php echo $wallType; ?>">
				<span class="lrc"></span>
				<span class="mrc">
					<span class="iconr_photoshare fl mt1 mr2"></span>
					<span class="fl"><?php echo $this->__('Upload image'); ?></span>
				
				</span>
				<span class="rrc"></span>
			</a>
		</div>
		<div class="videopostInputRight fl"></div>
	</div>
</div>

<div id="photo_upload">
	
</div>