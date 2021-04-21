<h3><?php echo $this->__('Achievements'); ?></h3>
<ul class="vertical_tabs">
	<li>
		<a href="<?php echo MainHelper::site_url('admin/achievements');?>"><?php echo $this->__('Achievements');?></a>
        </li>
        <li>
                <a href="<?php echo MainHelper::site_url('admin/achievements/levels');?>"><?php echo $this->__('Levels');?></a>
	</li>
        <li>
                <a href="<?php echo MainHelper::site_url('admin/achievements/playerachievements');?>"><?php echo $this->__('Player Achievements');?></a>
        </li>
        <li>
                <a href="<?php echo MainHelper::site_url('admin/achievements/branches');?>"><?php echo $this->__('Branches');?></a>
	</li>
        <li>
                <a href="<?php echo MainHelper::site_url('admin/achievements/rankings');?>"><?php echo $this->__('Rankings');?></a>
	</li>
</ul>