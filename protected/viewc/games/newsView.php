<?php $gameUrl = $game->GAME_URL; ?>
<?php include('common/top.php'); ?>

<div id="headerCoverInfo">
    <div id="coverImg">&nbsp;</div>
    <div id="headerInfo"><h1><?php echo $this->__('Recent News');?></h1></div>
</div>

<?php if(!isset($searchText)): $player = User::getUser();?>

<?php if(isset($newsList) and !empty($newsList)):?>
	<?php echo $this->renderBlock('common/pagination', array('pager' => $pager)) ?>
<?php endif; 

echo $this->renderBlock('games/common/search', array(
    'url' => $gameUrl.'/news/search',
    'searchText' => isset($searchText) ? $searchText : '',
    'searchTotal' => isset($searchTotal) ? $searchTotal : '',
    'label' => $label = $this->__('Search for news...'),
    'type' => $type = $this->__('news')
));
?>


  
<?php endif; ?>

<?php if(isset($newsList) and !empty($newsList)):?>
	<div class="item_list">
		<?php foreach ($newsList as $key => $item): ?>
			<?php echo $this->renderBlock('games/newsItemLine', array('item' => $item, 'isAdmin' => $player ? $player->canAccess('Create news') : false, 'objUrl' => $gameUrl.'/news/')); ?>
		<?php endforeach; ?>
	</div>
	<?php echo $this->renderBlock('common/pagination', array('pager' => $pager)) ?>
<?php else: ?>
	<p class="noItemsText"><?php echo $this->__('There are no news at this moment'); ?></p>
<?php endif; ?>