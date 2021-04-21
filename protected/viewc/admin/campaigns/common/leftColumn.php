<h3><?php echo $this->__('Campaigns'); ?></h3>
<ul class="vertical_tabs">
	<li>
		<a href="<?php echo MainHelper::site_url('admin/campaigns');?>"><?php echo $this->__('All Campaigns');?></a>
	</li>
	<li>
		<a href="<?php echo MainHelper::site_url('admin/campaigns/newcampaign');?>"><?php echo $this->__('New Campaign');?></a>
	</li>
	<li>
		<a href="<?php echo MainHelper::site_url('admin/campaigns/banners');?>"><?php echo $this->__('All Banners');?></a>
	</li>
</ul>