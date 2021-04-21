<?php include('common/top.php');?>

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
    <?php if(MainHelper::IsModuleEnabledByTag('raidscheduler') == 1): ?>
        <li class="<?php echo $page == 'raidscheduler' ? 'active':''; ?>">
			<a class="icon_link" href="<?php echo MainHelper::site_url('events/raidscheduler'); ?>"><i class="event_tab_icon"></i><?php echo $this->__('RaidScheduler'); ?></a>
		</li>
    <?php endif; ?>
	</ul>

<!-- Event list start -->
<div class="list_container <?php echo (!isset($searchText)) ? 'filter_options' : ''; ?>">
	<?php 
		echo $this->renderBlock('events/common/search', array(
			'url' => $searchUrl, 
			'searchText' => isset($searchText) ? $searchText : '',
			'searchTotal' => isset($searchTotal) ? $searchTotal : '',
			'label' => $label = $this->__('Search for events...'),
			'type' => $type = $this->__('events')
		));
	?>

	
	<?php if(!isset($searchText)):?>
		<div class="list_header">
			<h1><?php echo $title;?></h1>
		</div>
	<?php endif; ?>
	
	<?php
	if (!isset($searchText)) {
	 	echo $this->renderBlock('events/common/filter_bar', array(
			'type' => $page,
			'tab' => $tab,
			'order' => $order,
		));
	 } ?>

	<?php if(isset($events) and !empty($events)): ?>
		
		<div class="item_list">
		<?php
		foreach($events as $e) {
			echo $this->renderBlock('common/event', array('event' => $e, 'owner' => false));
		}
		?>
		</div>

		<?php if(isset($pager)): ?>
			<?php echo $this->renderBlock('common/pagination', array('pager'=>$pager)) ?>
		<?php endif; ?>

	<?php else: ?>

		<p class="noItemsText"><?php echo $this->__('There are no events at this moment'); ?></p>

	<?php endif; ?>
</div>
<!-- Event list end -->