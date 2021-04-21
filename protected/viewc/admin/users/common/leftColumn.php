<h3><?php echo $this->__('Players'); ?></h3>
<ul class="vertical_tabs">
	<li>
		<a href="<?php echo MainHelper::site_url('admin/users');?>"><?php echo $this->__('All Players');?></a>
	</li>
	<li>
		<a href="<?php echo MainHelper::site_url('admin/users/notapproved');?>"><?php echo $this->__('To be approved');?></a>
	</li>
	<li>
		<a href="<?php echo MainHelper::site_url('admin/users/selfdeactivated');?>"><?php echo $this->__('Self deactivated users');?></a>
	</li>
	<li>
		<a href="<?php echo MainHelper::site_url('admin/users/banned');?>"><?php echo $this->__('Banned users');?></a>
	</li>
	<li>
		<a href="<?php echo MainHelper::site_url('admin/users/friendcat');?>"><?php echo $this->__('Friend categories');?></a>
	</li>
	<li>
		<a href="<?php echo MainHelper::site_url('admin/users/specialtools');?>"><?php echo $this->__('Special tools');?></a>
	</li>
</ul>