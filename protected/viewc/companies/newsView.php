<?php 
$companyUrl = $company->COMPANY_URL;
$player = User::getUser();
include('common/top.php');

//echo $this->renderBlock('companies/common/search', array(
//	'url' => $companyUrl.'/news/search', 
//	'searchText' => isset($searchText) ? $searchText : '',
//	'searchTotal' => isset($searchTotal) ? $searchTotal : '',
//	'label' => $label = $this->__('Search for news...'),
//	'type' => $type = $this->__('news')
//));
?>

<?php if(!isset($searchText)): $player = User::getUser();?>
<div class="newsSearch_listHeader">
	<div id="headerCoverInfo">
            <div id="coverImg">&nbsp;</div>
            <div id="headerInfo"><h1><?php echo $this->__('Recent News');?></h1></div>
        </div>
        
	<?php if($isAdmin === TRUE or ($player and $player->canAccess('Create news') === TRUE)): ?>
		<a class="list_header_button" href="<?php echo $companyUrl; ?>/admin/add-news"><?php echo $this->__('Add News +') ?></a>
	<?php endif; ?>
</div>
<?php endif; 

 	if(isset($newsList) and !empty($newsList)):?>
	<?php echo $this->renderBlock('common/pagination', array('pager' => $pager)) ?>
<?php endif;

echo $this->renderBlock('companies/common/search', array(
	'url' => $companyUrl.'/news/search', 
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
			<?php echo $this->renderBlock('companies/newsItemLine', array('item' => $item, 'isAdmin' => $isAdmin, 'objUrl' => $companyUrl.'/news/')); ?>
		<?php endforeach; ?>
	</div>
	<?php echo $this->renderBlock('common/pagination', array('pager' => $pager));
else: ?>
	<p class="noItemsText"><?php echo $this->__('There are no news here. Yet!'); ?></p>
<?php endif; ?>