<?php 
include('common/top.php'); 

if(isset($recentNews)) {
    echo $this->renderBlock('news/newsList', array(
        'newsList' => $recentNews, 
        'pager' => $pager, 
        'pagerObj' => $pagerObj, 
        'headerName' => $this->__('Recent News')));
}; ?>