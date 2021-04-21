<?php $groupUrl = $group->GROUP_URL; ?>
<?php include('common/top.php'); ?>

<?php /*
<!-- Group news search start -->
<form method="GET" action="<?php echo $group->GROUP_URL.'/news/search';?>" id="inside_search" class="c_column_search clearfix">
	<input type="hidden" id="form_url" value="<?php echo $group->GROUP_URL.'/news/search';?>" />
	<input type="text" id="inside_search_txt" class="c_column_search_input withLabel"
			title="<?php echo $this->__('Search for news...'); ?>"
			value="<?php echo (isset($searchText) and $searchText != '') ? htmlspecialchars($searchText) : $this->__('Search for news...'); ?>" />
	<input type="submit" value="<?php echo $this->__('Search'); ?>" class="c_column_search_button purple" />
</form>

<?php if(isset($searchText) and $searchText != ''):?>
	<div class="list_header">
		<h1><?php echo $this->__('Your search matched').' '.$searchTotal.' '.$this->__('news'); ?></h1>
		<div class="list_header_meta"><?php echo $this->__('You searched for:'); ?> <span><?php echo htmlspecialchars($searchText); ?></span></div>
	</div>
<?php endif;?>
<!-- Group news search end -->
*/ ?>

<?php if(!isset($searchText)): $player = User::getUser();?>
<div class="newsSearch_listHeader">
	<div id="headerCoverInfo">
            <div id="coverImg">&nbsp;</div>
            <div id="headerInfo"><h1><?php echo $this->__('Recent News');?></h1></div>
        </div>
        
	<?php if($isAdmin === TRUE): ?>
		<a class="list_header_button" href="<?php echo $groupUrl; ?>/admin/add-news"><?php echo $this->__('Add News +') ?></a>
	<?php endif; ?>
</div>
<?php endif; ?>

<?php
	echo $this->renderBlock('groups/common/search', array(
		'url' => $groupUrl.'/news/search',
		'searchText' => isset($searchText) ? $searchText : '',
		'searchTotal' => isset($searchTotal) ? $searchTotal : '',
		'label' => $label = $this->__('Search for news...'),
		'type' => $type = $this->__('news')
	));
?>

<?php if (isset($newsList) and !empty($newsList)): ?>
	<div class="item_list">
		<?php $num = 1; ?>
		<?php foreach ($newsList as $key => $item): ?>
			<?php echo $this->renderBlock('companies/newsItemLine', array('item' => $item, 'isAdmin' => $isAdmin, 'objUrl' => $groupUrl.'/news/')); ?>
		<?php endforeach; ?>
		<?php echo $this->renderBlock('common/pagination', array('pager' => $pager)) ?>
	</div>
<?php else: ?>
	<p class="noItemsText"><?php echo $this->__('There are no news here. Yet!'); ?></p>
<?php endif; ?>