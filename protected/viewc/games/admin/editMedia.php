<div class="message_container">
    <!-- header -->
    <div class="clearfix">
        <span class="fs22 fft fclg2 fl mr10"><?php echo $this->__('Edit Media'); ?></span>
    </div>
    <!-- end header -->
    <form action="#" method="post" id="addmedia_game_form">
        <input type="hidden" name="game_id" value="<?php echo $game->ID_GAME; ?>">
        <input type="hidden" name="media_id" value="<?php echo $media->ID_MEDIA; ?>">

        <div class="mt5 pr zi100">
			<label for="game_media_tab" class="cp"><?php echo $this->__('Select Tab'); ?></label>
			<div class="jqtransform pr border clearfix mt2">
				<select name="tab" id="game_media_tab" class="w570 jqselect media_tab_type">
					<?php foreach ($tabs as $url => $tab): ?>
						<option value="<?php echo $url; ?>"><?php echo $this->__($tab); ?></option>
					<?php endforeach; ?>
				</select>
			</div>
		</div>

		<div class="mt5">
			<label for="mediaName" class="cp"><?php echo $this->__('Name');?></label>
			<div class="border mt2">
				<input name="media_name" class="w576 news_border media_name" id="mediaName" value="<?php echo $this->__($media->MediaName);?>">
			</div>
		</div>

        <div class="clear mt10">&nbsp;</div>
        <a href="javascript:void(0);" class="link_green fr editmedia_game"><span><span><?php echo $this->__('Save'); ?></span></span></a>
    </form>
</div>
<script type="text/javascript">loadDropdowns();</script>