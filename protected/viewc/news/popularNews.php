<?php 
include('common/top.php'); 

if(isset($topNews)) {
    echo $this->renderBlock('news/topNewsList', array('topNews' => $topNews, 'blockType'=> NEWS_POPULAR, 'head' => $this->__('Popular Top 5'), 'hideText' => $this->__('Popular News')));
}

if(isset($popularNews)){
    echo $this->renderBlock('news/newsList', array('newsList' => $popularNews, 'pager' => $pager, 'pagerObj' => $pagerObj, 'headerName' => $this->__('Popular News')));
}