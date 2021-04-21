<div class="message_container">
    <!-- header -->
    <div class="clearfix">
        <span class="fs22 fft fclg2 fl mr10"><?php echo $this->__('Add Media'); ?></span>
    </div>
    <!-- end header -->
    <form action="#" method="post" id="addmedia_company_form">
        <input type="hidden" name="company_id" value="<?php echo $company->ID_COMPANY; ?>">

		<div class="mt5 pr zi100">
			<label for="company_media_tab" class="cp"><?php echo $this->__('Select Tab'); ?></label>
			<div class="jqtransform pr border clearfix mt2">
				<select name="tab" id="company_media_tab" class="w570 jqselect media_tab_type">
					<?php foreach ($tabs as $url => $tab): ?>
						<option value="<?php echo $url; ?>"><?php echo $this->__($tab); ?></option>
					<?php endforeach; ?>
				</select>
			</div>
		</div>

		<div class="mt5">
			<label for="downloadDescription" class="cp"><?php echo $this->__('Youtube link/upload files'); ?></label>
			<div class="border mt2">
				<div class="company_tab_video">
					<textarea name="media_videos" rows="5" class="news_border w576"></textarea>
				</div>
				<div class="company_tab_images dn">
					<div id="custom-queue"></div>
					<input id="company_media_images" name="Filedata" type="file">
				</div>
			</div>
		</div>

        <div class="clear mt10">&nbsp;</div>
        <a href="javascript:void(0);" class="link_green fr addmedia_company"><span><span><?php echo $this->__('Add'); ?></span></span></a>
    </form>
</div>
<script type="text/javascript">loadDropdowns(); createMultiUploader('company_media_images', '<?php echo MainHelper::site_url('company/ajaxuploadmultiphoto/'.$company->ID_COMPANY); ?>');</script>