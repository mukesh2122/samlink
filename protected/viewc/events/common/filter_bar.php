<?php $url = 'events/'.  $type.'/tab';?>


<div class="filter_bar clearfix">
	<div class="filter_bar_label">
		<?php echo $this->__('Order events:'); ?>
	</div>
	<div class="filter_bar_options">
		<?php if($tab == 1):?>
			<?php if($order == 'desc' or $order=''):?>
				<a href="<?php echo MainHelper::site_url($url.'/date/asc');?>" class="filter_bar_option_selected filter_asc"><span><?php echo $this->__('Start date');?></span></a>
			<?php else:?>
				<a href="<?php echo MainHelper::site_url($url.'/date/desc');?>" class="filter_bar_option_selected filter_dsc"><span><?php echo $this->__('Start date');?></span></a>
			<?php endif;?>
		<?php else:?>
				<a href="<?php echo MainHelper::site_url($url.'/date/desc');?>"><span><?php echo $this->__('Start date');?></span></a>
		<?php endif;?>
				
		<?php if($tab == 2):?>
			<?php if($order == 'desc' or $order=''):?>
				<a href="<?php echo MainHelper::site_url($url.'/participants/asc');?>" class="filter_bar_option_selected filter_dsc"><span><?php echo $this->__('Participants');?></span></a>
			<?php else:?>
				<a href="<?php echo MainHelper::site_url($url.'/participants/desc');?>" class="filter_bar_option_selected filter_asc"><span><?php echo $this->__('Participants');?></span></a>
			<?php endif;?>
		<?php else:?>
				<a href="<?php echo MainHelper::site_url($url.'/participants/desc');?>"><span><?php echo $this->__('Participants');?></span></a>
		<?php endif;?>
	</div>
</div>
