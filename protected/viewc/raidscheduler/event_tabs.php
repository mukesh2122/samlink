<ul class="horizontal_tabs clearfix">
    <li class="<?php echo $page == 'upcoming' ? 'active':''; ?>">
        <a class="icon_link" href="<?php echo MainHelper::site_url('events/upcoming'); ?>"><i class="event_tab_icon"></i><?php echo $this->__('Upcoming events'); ?></a>
    </li>
    <li class="<?php echo $page == 'current' ? 'active':''; ?>">
        <a class="icon_link" href="<?php echo MainHelper::site_url('events/current'); ?>"><i class="event_tab_icon"></i><?php echo $this->__('Current events'); ?></a>
    </li>
    <li class="<?php echo $page == 'all' ? 'active':''; ?>">
        <a class="icon_link" href="<?php echo MainHelper::site_url('events/all'); ?>"><i class="event_tab_icon"></i><?php echo $this->__('All events'); ?></a>
    </li>
    <li class="<?php echo $page == 'raidscheduler' ? 'active':''; ?>">
        <a class="icon_link" href="<?php echo MainHelper::site_url('events/raidscheduler'); ?>"><i class="event_tab_icon"></i><?php echo $this->__('RaidScheduler'); ?></a>
    </li>
</ul>