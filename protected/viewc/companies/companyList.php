<!-- Company list start -->
<div class="list_container <?php echo (!isset($searchText)) ? 'filter_options' : ''; ?>">
	<?php echo $this->renderBlock('companies/common/search', array(
			'url' => MainHelper::site_url('companies/search'),
			'searchText' => isset($searchText) ? $searchText : '',
			'searchTotal' => isset($searchTotal) ? $searchTotal : '',
			'label' => $label = $this->__('Search for companies...'),
			'type' => $type = $this->__('companies')
		));

	if(!isset($searchText)): ?>
		<div class="list_header">
			<h1><?php echo $headerName; ?></h1>
		</div>
	<?php endif;

	if (!isset($searchText)) {
	 	echo $this->renderBlock('companies/common/filter_bar', array(
			'tab' => $tab,
			'order' => $order
		));
	};

	if(isset($companyList) and !empty($companyList)): ?>
		<div class="item_list">
            <?php foreach($companyList as $key=>$item) { echo $this->renderBlock('companies/companyItem', array('item' => $item, 'odd' => (($key-1) % 2 == 0))); }; ?>
		</div>
        <?php if(isset($pager)) { echo $this->renderBlock('common/pagination', array('pager'=>$pager)); };
	else: ?>
		<p class="noItemsText"><?php echo $this->__('There are no companies here. Yet!'); ?></p>
	<?php endif; ?>
</div>
<!-- Company list end -->