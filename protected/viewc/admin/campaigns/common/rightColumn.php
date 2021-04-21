<h3><?php echo $this->__('Campaign'); ?></h3>
<ul class="vertical_tabs">
        <li>
		<a href="<?php echo MainHelper::site_url('admin/campaigns/editcampaign/'.$campaign->ID_CAMPAIGN);?>"><?php echo $campaign->AdvertiserName?></a>
	</li>
<h3><?php echo $this->__('Banners'); ?></h3>
<ul class="vertical_tabs">
        <li>
		<a href="<?php echo MainHelper::site_url('admin/campaigns/banners/'.$campaign->ID_CAMPAIGN);?>"><?php echo $this->__('Campaign Banners');?></a>
	</li>
        <li>
		<a href="<?php echo MainHelper::site_url('admin/campaigns/adbanner/'.$campaign->ID_CAMPAIGN);?>"><?php echo $this->__('Upload Banner');?></a>
	</li>
</ul>