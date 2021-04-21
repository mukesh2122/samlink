<div class="download_cont itemPost pr">
	<div class="download_item clearfix mt10 pb5 pr">
		<div class="fs18"><a class="fcb lhn dot_bot pl5 pb5 pt3 db count_download" 
                             rel="<?php echo $download->ID_DOWNLOAD; ?>" target="_blank" 
                             href="<?php echo $download->URL; ?>"><?php echo $download->DownloadName; ?></a></div>
		<div class="clear mt5"></div>
		<div class="w144 fl">
			<div class="pl5"><?php echo MainHelper::showImage($download, THUMB_LIST_138x107); ?></div>
		</div>
		<div class="clearfix w450 fl">
			<div class="fs12 lhn fft w300 fl">
				<div class="download_desc pl10 pr10"><?php 
                echo ContentHelper::downloadShortDescription($this->__($download->DownloadDesc)); ?></div>
			</div>
			<div class="clearfix w150 fr">
				<div class="pl10 pr10">
					<div class="fcblue fft fwb"><?php echo $this->__('Download Info'); ?></div>
					<span class="db fclg fft mt2 fs12"><?php echo $this->__('Size'); ?>: 
                        <span class="fclg1"><?php echo $download->FileSize != '' ? $download->FileSize : '-'; ?> 
                            MB</span></span>
					<span class="db fclg fft fs12"><?php echo $this->__('Date'); ?>: 
                        <span class="fclg1"><?php echo Date("d/m-Y", $download->CreationTime); ?></span></span>
					<span class="db fclg fft fs12"><?php echo $this->__('Downloads'); ?>: 
                        <span class="fclg1"><?php 
                        echo $download->DownloadCount != '' ? $download->DownloadCount : '0'; ?></span></span>

					<div class="mt5 pl">
						<a target="_blank" href="<?php echo $download->URL; ?>" 
                           class="link_download tac db count_download" 
                           rel="<?php echo $download->ID_DOWNLOAD; ?>"><span><?php 
                           echo $this->__('Download file'); ?></span></a>
					</div>
				</div>
			</div>
		</div>
	</div>

	<?php if(Auth::isUserLogged() and isset($isAdmin) and $isAdmin): ?>
		<a href="javascript:void(0);" class="itemMoreActions iconr_moreActions t0 r0 zi2 pa mt5 mr5 dn" 
           rel="<?php echo $download->ID_DOWNLOAD; ?>"></a>
		<div class="itemMoreActionsBlock pa dn">
			<a href="javascript:void(0);" class="delete_group_download db" rel="<?php echo $download->ID_DOWNLOAD; ?>">
				<?php echo $this->__('Delete download');?>
			</a>
		</div>
	<?php endif;?>
</div>