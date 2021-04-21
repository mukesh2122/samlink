<?php
include('common/top.php');

echo $this->renderBlock('companies/companyList', array(
	'companyList' => $companyList,
	'searchType' => COMPANY_INDEX,
	'searchText' => isset($searchText) ? $searchText : NULL,
	'searchTotal' => isset($searchTotal) ? $searchTotal : 0,
	'tab' => isset($tab) ? $tab : 1,
	'order' => isset($order) ? $order : 'desc',
	'pager' => $pager,
	'pagerObj' => $pagerObj,
	'headerName' => $this->__('Companies'))
);
?>