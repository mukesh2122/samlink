<?php 
include('common/top.php'); 

if(isset($recentBlog)){
    echo $this->renderBlock('blog/blogList', array('blogList' => $recentBlog, 'pager' => $pager, 'pagerObj' => $pagerObj, 'headerName' => $this->__('Recent Posts')));
}
