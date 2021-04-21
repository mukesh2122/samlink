<?php
$user = User::getUser();
$isLayoutEnabled = MainHelper::isModuleEnabledByTag('layout');
if($isLayoutEnabled && $user->canAccess('Setup')): ?>
<h3><?php echo $this->__('General'); ?></h3>
<ul class="vertical_tabs">
	<li>
		<a href="<?php echo MainHelper::site_url('admin/setup');?>"><?php echo $this->__('Modules');?></a>
	</li>
	<li>
		<a href="<?php echo MainHelper::site_url('admin/setup/siteinfo');?>"><?php echo $this->__('Site info');?></a>
	</li>
</ul>
<?php
endif;
if($isLayoutEnabled && $user->canAccess('Edit layout')):
?>
<h3><?php echo $this->__('Layout'); ?></h3>
<ul class="vertical_tabs">
	<li>
		<a href="<?php echo MainHelper::site_url('admin/setup/layout/general');?>"><?php echo $this->__('General settings');?></a>
	</li>
	<li>
		<a href="<?php echo MainHelper::site_url('admin/setup/layout/header');?>"><?php echo $this->__('Header');?></a>
	</li>
	<li>
		<a href="<?php echo MainHelper::site_url('admin/setup/layout/topmenu');?>"><?php echo $this->__('Topmenu');?></a>
	</li>
	<li>
		<a href="<?php echo MainHelper::site_url('admin/setup/layout/right-column');?>"><?php echo $this->__('Right column (Widgets)');?></a>
	</li>
	<li>
		<a href="<?php echo MainHelper::site_url('admin/setup/layout/footer');?>"><?php echo $this->__('Footer');?></a>
	</li>
	<li>
		<a href="<?php echo MainHelper::site_url('admin/setup/layout/css');?>"><?php echo $this->__('Stylesheet');?></a>
	</li>
</ul>
<?php endif; ?>
