<?php include('common/event_tabs.php'); ?>

<!-- Invited start -->
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
			'title'		=> $this->__('Invited'),
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

		<?php if(isset($pager) and $pager != '' and isset($pagerObj) and $pagerObj->totalPage > 1): ?>
			<?php echo $this->renderBlock('common/pagination', array('pager'=>$pager)) ?>
		<?php endif; ?>

	<?php else: ?>

		<p class="noItemsText"><?php echo $this->__('There are no invitees here. Yet!'); ?></p>

	<?php endif; ?>
</div>
<!-- Invited end -->