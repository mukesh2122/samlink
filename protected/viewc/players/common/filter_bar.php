<?php
	$catPath = ($selectedCategory!=0) ? "category/".$selectedCategory."/" : "";
 ?>
<div class="filter_bar clearfix">
	<div class="filter_bar_label">
		<?php echo $this->__('Player suggestions are based on') ?>:
	</div>
	<div class="filter_bar_options">
		<?php if($tab == 1):?>
			<?php if($order == 'desc' or $order=''):?>
				<a href="<?php echo MainHelper::site_url('players/'.$catPath.'tab/my-friends/asc');?>" class="filter_bar_option_selected filter_dsc"><span><?php echo $this->__('My Friends');?></span></a>
			<?php else:?>
				<a href="<?php echo MainHelper::site_url('players/'.$catPath.'tab/my-friends/desc');?>" class="filter_bar_option_selected filter_asc"><span><?php echo $this->__('My Friends');?></span></a>
			<?php endif;?>
		<?php else:?>
				<a href="<?php echo MainHelper::site_url('players/'.$catPath.'tab/my-friends/desc');?>"><span><?php echo $this->__('My Friends');?></span></a>
		<?php endif;?>
				
		<?php if (MainHelper::IsModuleEnabledByTag('contentchild') == 1 && MainHelper::IsModuleNotAvailableByTag('contentchild')==0): ?>
		<?php if($tab == 2):?>
			<?php if($order == 'desc' or $order=''):?>
				<a href="<?php echo MainHelper::site_url('players/'.$catPath.'tab/my-games/asc');?>" class="filter_bar_option_selected filter_dsc"><span><?php echo $this->__('My Games');?></span></a>
			<?php else:?>
				<a href="<?php echo MainHelper::site_url('players/'.$catPath.'tab/my-games/desc');?>" class="filter_bar_option_selected filter_asc"><span><?php echo $this->__('My Games');?></span></a>
			<?php endif;?>
		<?php else:?>
				<a href="<?php echo MainHelper::site_url('players/'.$catPath.'tab/my-games/desc');?>"><span><?php echo $this->__('My Games');?></span></a>
		<?php endif;?>
		<?php endif;?>

		<?php if (MainHelper::IsModuleEnabledByTag('groups') == 1 && MainHelper::IsModuleNotAvailableByTag('groups')==0): ?>
		<?php if($tab == 3):?>
			<?php if($order == 'desc' or $order=''):?>
				<a href="<?php echo MainHelper::site_url('players/'.$catPath.'tab/my-groups/asc');?>" class="filter_bar_option_selected filter_dsc"><span><?php echo $this->__('My Groups');?></span></a>
			<?php else:?>
				<a href="<?php echo MainHelper::site_url('players/'.$catPath.'tab/my-groups/desc');?>" class="filter_bar_option_selected filter_asc"><span><?php echo $this->__('My Groups');?></span></a>
			<?php endif;?>
		<?php else:?>
				<a href="<?php echo MainHelper::site_url('players/'.$catPath.'tab/my-groups/desc');?>"><span><?php echo $this->__('My Groups');?></span></a>
		<?php endif;?>
		<?php endif;?>
				
		<?php if($tab == 4):?>
			<?php if($order == 'desc' or $order=''):?>
				<a href="<?php echo MainHelper::site_url('players/'.$catPath.'tab/my-location/asc');?>" class="filter_bar_option_selected filter_dsc"><span><?php echo $this->__('My Location');?></span></a>
			<?php else:?>
				<a href="<?php echo MainHelper::site_url('players/'.$catPath.'tab/my-location/desc');?>" class="filter_bar_option_selected filter_asc"><span><?php echo $this->__('My Location');?></span></a>
			<?php endif;?>
		<?php else:?>
				<a href="<?php echo MainHelper::site_url('players/'.$catPath.'tab/my-location/desc');?>"><span><?php echo $this->__('My Location');?></span></a>
		<?php endif;?>
	</div>
</div>