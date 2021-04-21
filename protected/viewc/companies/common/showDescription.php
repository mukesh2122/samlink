<h1 class="db mt15 fs17 fcblue"><?php echo $company->CompanyName; ?></h1>
<div class="clearfix mt10 show_block">
	<div class="clearfix pb10 description dn">
		<?php echo ContentHelper::handleContentOutput($company->CompanyDesc); ?>
	</div>
	<div class="show_more_desc">
		<a class="fft fs11 show_desc" href="javascript:void(0)"><span>&nbsp;</span><?php echo $this->__('Show Description'); ?></a>
		<a class="fft fs11 hide_desc dn" href="javascript:void(0)"><span>&nbsp;</span><?php echo $this->__('Hide Description'); ?></a>
	</div>
</div>