<div class="message_container">
    <!-- header -->
    <div class="clearfix">
        <span class="fs22 fft fclg2 fl mr10"><?php echo $this->__('Add Media'); ?></span>
    </div>
    <!-- end header -->
    <form action="#" method="post" id="addmedia_game_form">
        <input type="hidden" name="game_id" value="<?php echo $game->ID_GAME; ?>">

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
			<label for="game_media_video" class="cp"><?php echo $this->__('Youtube link/upload files'); ?></label>
			<div class="border mt2">
				<div class="game_tab_video">
					<textarea id="game_media_video" name="media_videos" rows="5" class="news_border w576"></textarea>
				</div>
				<div class="game_tab_images dn">
					<div id="custom-queue"></div>
					<input id="game_media_images" name="Filedata" type="file">
				</div>
			</div>
		</div>

        <div class="clear mt10">&nbsp;</div>
        <a href="javascript:void(0);" class="link_green fr addmedia_game"><span><span><?php echo $this->__('Add'); ?></span></span></a>
    </form>
</div>
<script type="text/javascript">loadDropdowns(); createMultiUploader('game_media_images', '<?php echo MainHelper::site_url('game/ajaxuploadmultiphoto/'.$game->ID_GAME); ?>');</script>