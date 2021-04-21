<div class="message_container">
    <!-- header -->
    <div class="clearfix">
        <span class="fs22 fft fclg2 fl mr10"><?php echo $this->__('Edit Download'); ?></span>
    </div>
    <!-- end header -->
    <form action="#" method="post" id="adddownload_company_form">
        <input type="hidden" name="company_id" value="<?php echo $company->ID_COMPANY; ?>">
        <input type="hidden" name="download_id" value="<?php echo $download->ID_DOWNLOAD; ?>">

        		<div class="mt5 pr zi100">
			<label for="tabID" class="cp"><?php echo $this->__('Select Tab'); ?></label>
			<div class="jqtransform pr border clearfix mt2">
				<select id="tabID" name="tab_id" class="w570 tab_id jqselect">
					 <?php foreach ($tabs as $tab): ?>
						<option <?php echo $download->ID_FILETYPE == $tab->ID_FILETYPE ? 'selected="selected"' : ''; ?> value ="<?php echo $tab->ID_FILETYPE; ?>"><?php echo $this->__($tab->FiletypeName); ?></option>
					<?php endforeach; ?>
				</select>
			</div>
		</div>

		<div class="mt5">
			<label for="downloadFilename" class="cp"><?php echo $this->__('File Name'); ?></label>
			<div class="border mt2">
				<input name="download_filename" class="w576 news_border download_filename" id="downloadFilename" value="<?php echo $download->DownloadName; ?>">
			</div>
		</div>

		<div class="mt5">
			<label for="downloadFilesize" class="cp"><?php echo $this->__('File Size'); ?></label>
			<div class="border mt2">
				<input name="download_filesize" class="w576 news_border download_filesize" id="downloadFilesize" value="<?php echo $download->FileSize; ?>">
			</div>
		</div>

		<div class="mt5">
			<label for="downloadFileurl" class="cp"><?php echo $this->__('File URL'); ?></label>
			<div class="border mt2">
				<input name="download_fileurl" class="w576 news_border download_fileurl" id="downloadFileurl" value="<?php echo $download->URL;?>">
			</div>
		</div>

		<div class="mt5">
			<label for="downloadDescription" class="cp"><?php echo $this->__('Download Description'); ?></label>
			<div class="border mt2">
				<textarea name="download_description" rows="5"  class="news_border w576" id="downloadDescription"><?php echo $this->__($download->DownloadDesc); ?></textarea>
			</div>
		</div>

        <div class="clear mt10">&nbsp;</div>
        <a href="javascript:void(0);" class="link_green fr adddownload_company"><span><span><?php echo $this->__('Save'); ?></span></span></a>
    </form>
</div>
<script type="text/javascript">loadDropdowns();</script>