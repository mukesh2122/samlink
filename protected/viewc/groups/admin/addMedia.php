<div class="message_container">
    <!-- header -->
    <div class="clearfix">
        <span class="fs22 fft fclg2 fl mr10"><?php echo $this->__('Add Media'); ?></span>
    </div>
    <!-- end header -->
    <form action="#" method="post" id="addmedia_group_form">
        <input type="hidden" name="group_id" value="<?php echo $group->ID_GROUP; ?>" />

		<div class="mt5 pr zi100">
			<label for="group_media_tab" class="cp"><?php echo $this->__('Select Tab');?></label>
			<div class="jqtransform pr border clearfix mt2">
				<select name="tab" id="group_media_tab" class="w570 jqselect media_tab_type">
					<?php foreach ($tabs as $url => $tab): ?>
						<option value="<?php echo $url; ?>"><?php echo $tab; ?></option>
					<?php endforeach; ?>
				</select>
			</div>
		</div>
		
        <div class="mt5">
			<label for="downloadDescription" class="cp"><?php echo $this->__('Youtube link/upload files');?></label>
			<div class="border mt2">
				<div class="group_tab_video">
					<textarea name="media_videos" rows="5" class="news_border w576"></textarea>
				</div>
				<div class="group_tab_images dn">
					<div id="custom-queue"></div>
					<input id="group_media_images" name="Filedata" type="file" />
				</div>
			</div>
		</div>

        <div class="clear mt10">&nbsp;</div>
        <a href="javascript:void(0)" class="link_green fr addmedia_group mb20"><span><span><?php echo $this->__('Add'); ?></span></span></a>
    </form>
</div>
<script type="text/javascript">loadDropdowns(); createMultiUploader('group_media_images', '<?php echo MainHelper::site_url('group/ajaxuploadmultiphoto/'.$group->ID_GROUP); ?>');</script>