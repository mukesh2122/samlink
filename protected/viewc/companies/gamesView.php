<?php 
/*
$isAdmin = FALSE;
if($company->isAdmin()){
    $isAdmin = true;
    $additional_header = '<a class="add_download fft fs12 db fr mt5 sprite" rel="iframe" href="'.$company->COMPANY_URL.'/admin/addgame">'.$this->__('Add Game').'</a>';
}
 */
$companyUrl = $company->COMPANY_URL;
$url = $companyUrl.'/news/search';
// include('common/top.php');

?>

<?php include('common/top.php'); ?>

<div id="headerCoverInfo">
    <div id="coverImg">&nbsp;</div>
    <div id="headerInfo"><h1><?php echo ucfirst($this->__('Games')); ?></h1></div>
</div>

<?php // echo $this->renderBlock('common/pagination', array('pager' => $pager)); ?>

<!-- Company games search start -->
<?php 
echo $this->renderBlock('companies/common/search', array(
	'url' => $companyUrl.'/games/search', 
	'searchText' => isset($searchText) ? $searchText : '',
	'searchTotal' => isset($searchTotal) ? $searchTotal : '',
	'label' => $label = $this->__('Search for games...'),
	'type' => $type = $this->__('Games')
));

/* if (isset($url)):?>
<div id="searchField">
	<form method="GET" id="inside_searchForm" class="searchForm">
		<input type="hidden" id="form_url" value="<?php echo $url;?>" />
		<input type="text" class="search_inputField"
				title="<?php echo $label; ?>" 
				placeholder="<?php echo (isset($searchText) and $searchText != '') ? htmlspecialchars($searchText) : $label; ?>" />
                <div id="search_button"><input type="submit" value="" class="search_buttonIcon" /></div>
	</form>

	<?php if(isset($searchText) and $searchText != ''):?>
<div class="list_header">
			<h1><?php echo $this->__('Your search matched [_1]', array($searchTotal)).' '.$type; ?></h1>
			<div class="list_header_meta"><?php echo $this->__('You searched for:'); ?> <span><?php echo htmlspecialchars($searchText); ?></span></div>
</div>
	<?php endif;?>
</div>
<?php endif; */ ?>

<!-- Company games search end -->

<?php if(isset($gameList) and !empty($gameList)):?>
    <div class="item_list">
	    <?php foreach ($gameList as $item):?>
			<?php echo $this->renderBlock('common/gameMedium', array('item' => $item));?>
	    <?php endforeach; ?>
	    <?php //echo $this->renderBlock('common/pagination', array('pager'=>$pager)) ?>
    </div>
<?php else: ?>
	<p class="noItemsText"><?php echo $this->__('There are no games here. Yet!'); ?></p>
<?php endif; ?>