<?php

include('common/top.php');

//include('PresLnotices.php');
echo $this->renderBlock('recruitment2/PresLnotices', array(
	'groupList' => $groupList,
	'url' => MainHelper::site_url('groups/search/' . GROUP_ALL),
	'searchText' => isset($searchText) ? $searchText : null,
	'searchTotal' => isset($searchTotal) ? $searchTotal : 0,
	'pager' => $pager, 
	'pagerObj' => $pagerObj,
	'headerName' => $this->__('All Groups'))
);



?>