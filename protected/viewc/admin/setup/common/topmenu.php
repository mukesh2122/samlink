<h3><?php echo $this->__('Topmenu'); ?></h3>
<ul class="vertical_tabs">
	<li>
		<a href="<?php echo MainHelper::site_url('admin/setup/layout/currentlayout');?>"><?php echo $this->__('Generel');?></a>
	</li>
        <li>
		<a href="<?php echo MainHelper::site_url('admin/setup/layout/defaultlayout');?>"><?php echo $this->__('Mouse over');?></a>
	</li>
	<li>
		<a href="<?php echo MainHelper::site_url('admin/setup/layout/header');?>"><?php echo $this->__('Hover');?></a>
	</li>
</ul>