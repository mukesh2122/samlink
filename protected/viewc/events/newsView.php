<?php include('common/event_tabs.php'); ?>

<?php $player = User::getUser();?>
<div class="list_header">
	<h1><?php echo $this->__('Recent News');?></h1>
</div>

<?php if(isset($newsList) and !empty($newsList)):?>
	<div class="item_list">
		<?php foreach ($newsList as $key => $item): ?>
                        <?php $editUrl = 'event/' . $item->ID_EVENT . '/edit/' .$item->ID_NEWS; ?>
			<?php echo $this->renderBlock('news/newsItemLine', array('item' => $item, 'isAdmin' => $player ? $player->canAccess('Create news') : false, 'editURL' => MainHelper::site_url($editUrl))); ?>
		<?php endforeach; ?>
	</div>
	<?php echo $this->renderBlock('common/pagination', array('pager' => $pager)) ?>
<?php else: ?>
	<p class="noItemsText"><?php echo $this->__('There are no news at this moment'); ?></p>
<?php endif; ?>