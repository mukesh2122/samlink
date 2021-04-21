<h3><?php echo $this->__('My support tickets'); ?></h3>
<ul class="vertical_tabs">
	<li>
		<a href="<?php echo MainHelper::site_url('players/feedback/new');?>" <?php if ((isset($typeFilter) && $typeFilter == "new")) { echo 'class="selected"'; } ?>><?php echo $this->__('Create new ticket');?></a>
	</li>
	<li>
		<a href="<?php echo MainHelper::site_url('players/feedback/All');?>" <?php if ((isset($typeFilter) && $typeFilter == "All")) { echo 'class="selected"'; } ?>><?php echo $this->__('View existing tickets'); ?></a>
	</li>
</ul>