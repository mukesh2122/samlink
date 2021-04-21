<?php $url = 'games/'.  urlencode($genre).'/tab'; ?>

<div class="filter_bar clearfix">
	<div class="filter_bar_label">
		<?php echo $this->__('Order games:'); ?>
	</div>
	<div class="filter_bar_options">
		<?php if($tab == 1):
			if($order == 'desc' or $order=''): ?>
				<a href="<?php echo MainHelper::site_url($url.'/alphabetically/asc'); ?>" class="filter_bar_option_selected filter_asc"><span><?php echo $this->__('Alphabetically'); ?></span></a>
			<?php else: ?>
				<a href="<?php echo MainHelper::site_url($url.'/alphabetically/desc'); ?>" class="filter_bar_option_selected filter_dsc"><span><?php echo $this->__('Alphabetically'); ?></span></a>
			<?php endif;
		else: ?>
				<a href="<?php echo MainHelper::site_url($url.'/alphabetically/asc'); ?>"><span><?php echo $this->__('Alphabetically'); ?></span></a>
		<?php endif;
		if($tab == 2):
			if($order == 'desc' or $order=''): ?>
				<a href="<?php echo MainHelper::site_url($url.'/by-popularity/asc'); ?>" class="filter_bar_option_selected filter_dsc"><span><?php echo $this->__('By Popularity'); ?></span></a>
			<?php else: ?>
				<a href="<?php echo MainHelper::site_url($url.'/by-popularity/desc'); ?>" class="filter_bar_option_selected filter_asc"><span><?php echo $this->__('By Popularity'); ?></span></a>
			<?php endif;
		else: ?>
				<a href="<?php echo MainHelper::site_url($url.'/by-popularity/desc'); ?>"><span><?php echo $this->__('By Popularity'); ?></span></a>
		<?php endif;
		if($tab == 3):
			if($order == 'desc' or $order=''):?>
				<a href="<?php echo MainHelper::site_url($url.'/by-rating/asc'); ?>" class="filter_bar_option_selected filter_dsc"><span><?php echo $this->__('By Rating'); ?></span></a>
			<?php else: ?>
				<a href="<?php echo MainHelper::site_url($url.'/by-rating/desc'); ?>" class="filter_bar_option_selected filter_asc"><span><?php echo $this->__('By Rating'); ?></span></a>
			<?php endif;
		else: ?>
				<a href="<?php echo MainHelper::site_url($url.'/by-rating/desc');?>"><span><?php echo $this->__('By Rating'); ?></span></a>
		<?php endif;
		if($tab == 4):
			if($order == 'desc' or $order=''): ?>
				<a href="<?php echo MainHelper::site_url($url.'/by-release-date/asc'); ?>" class="filter_bar_option_selected filter_dsc"><span><?php echo $this->__('By Release Date'); ?></span></a>
			<?php else: ?>
				<a href="<?php echo MainHelper::site_url($url.'/by-release-date/desc'); ?>" class="filter_bar_option_selected filter_asc"><span><?php echo $this->__('By Release Date'); ?></span></a>
			<?php endif;
		else:?>
				<a href="<?php echo MainHelper::site_url($url.'/by-release-date/desc'); ?>"><span><?php echo $this->__('By Release Date'); ?></span></a>
		<?php endif;?>
	</div>
</div>