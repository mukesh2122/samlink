<?php include('common/event_tabs.php'); ?>

<!-- Participants start -->
<div class="list_container">
	<?php 
		echo $this->renderBlock('events/common/search', array(
			'search'	=> isset($search) ? $search : '',
			'searchId'	=> 'search'. ucfirst($type).'EventForm',
			'total'		=> $total,
			'rel'		=> $event->ID_EVENT
		));
	?>

	<?php 
		echo $this->renderBlock('events/common/title_bar', array(
			'title'		=> $this->__('Participants'),
			'total'		=> $total
		));
	?>

	<?php $viewer = User::getUser(); ?>
	<?php if(isset($players) and !empty($players)): ?>

		<div class="item_list">
		<?php
		foreach ($players as $item) {
			$item = (object)$item;
			echo $this->renderBlock('common/player', array('player' => $item, 'viewer' => $viewer));
		}
		?>
		</div>

		<?php
		if(isset($pager) and $pager != '' and isset($pagerObj) and $pagerObj->totalPage > 1):
			echo $this->renderBlock('common/pagination', array('pager'=>$pager));
		endif;
		?>

	<?php else: ?>

		<p class="noItemsText"><?php echo $this->__('There are no participants here. Yet!'); ?></p>

	<?php endif; ?>
</div>
<!-- Participants end -->