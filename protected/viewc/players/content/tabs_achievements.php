<ul class="horizontal_tabs clearfix">
		<li class="<?php echo $activeTab == ACHIEVEMENT_TROPHYROOM ? 'active' : ''; ?>">
			<a class="icon_link" href="<?php echo MainHelper::site_url($baseUrl);?>"><?php echo $this->__('Trophy Room'); ?></a>
		</li>
                <li class="<?php echo $activeTab == ACHIEVEMENT_RANKINGS ? "active" : ""; ?>">
			<a class="icon_link" href="<?php echo MainHelper::site_url($baseUrl.'rankings');?>"><?php echo $this->__('Rankings'); ?></a>
		</li>
                <li class="<?php echo $activeTab == ACHIEVEMENT_FRIENDSRANKING ? "active" : ""; ?>">
			<a class="icon_link" href="<?php echo MainHelper::site_url($baseUrl.'friends-ranking');?>"><?php echo $this->__('Friends Rankings'); ?></a>
                </li>

</ul>
