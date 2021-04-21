<div class="<?php echo isset($infoBox) ? 'mt10' : ''; ?> clearfix">
	<div>
		<div class="videopostInputLeft fl"></div>
		<div class="videopostInputMid fl">
			<input type="text" id="<?php echo $wallType; ?>" 
				   title="<?php echo $this->__('Paste your link here...'); ?>" 
				   class="fl withLabel" 
				   value="<?php echo $this->__('Paste your link here...'); ?>" />
			
			<a id="wall_post_<?php echo $wallType; ?>" class="buttonRRound buttonVideoRound fr mt3" 
			   href="javascript:void(0)" rel="<?php echo $wallType; ?>">
				<span class="lrc"></span>
				<span class="mrc">
					<span class="iconr_linkshare fl mt1 mr2"></span>
					<span class="fl"><?php echo $this->__('Share link'); ?></span>
				
				</span>
				<span class="rrc"></span>
			</a>
		</div>
		<div class="videopostInputRight fl"></div>
	</div>
</div>

<?php if(isset($pager)): ?>
	<div>

	</div>
<?php endif; ?>