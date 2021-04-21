<input type="hidden" id="event_id" value="<?php echo $event->ID_EVENT; ?>" />
<div class="profile_foto_edit pr ">
	<?php echo MainHelper::showImage($event, THUMB_LIST_200x300, false, array('width', 'no_img' => 'noimage/no_events_200x300.png'));?>
</div>
<div class="mt5 clearfix">
	<a id="uploadEventPhoto" class="buttonRRound uploadImage" href="javascript:void(0)">
		<span class="lrc"></span>
		<span class="mrc tac"><span class="iconr_photoshare fl mt1 mr2"></span><?php echo $this->__('Upload Image'); ?></span>
		<span class="rrc"></span>
	</a>
</div>
<div class="mt10">
	<?php echo $this->__('Use PNG, GIF or JPG format'); ?><br />
	<?php echo $this->__('Max. window size: 200x300px'); ?>
</div>
