<?php

include('common/top.php');

echo $this->renderBlock('groups/groupList', array(
	'groupList' => $groupList,
	'url' => MainHelper::site_url('groups/search/' . GROUP_ALL),
	'searchText' => isset($searchText) ? $searchText : null,
	'searchTotal' => isset($searchTotal) ? $searchTotal : 0,
	'pager' => $pager, 
	'pagerObj' => $pagerObj,
	'headerName' => $this->__('All Groups'))
);
?>