
<?php 
include('common/top.php');

if(isset($topBlog)) {

    echo $this->renderBlock('blog/topBlogList', array('topBlog' => $topBlog, 'blockType'=> NEWS_POPULAR, 'head' => $this->__('Popular Top 5'), 'hideText' => $this->__('Popular Posts')));
}

if(isset($popularBlog)){

    echo $this->renderBlock('blog/blogList', array('blogList' => $popularBlog, 'pager' => $pager, 'pagerObj' => $pagerObj, 'headerName' => $this->__('Popular Posts')));
}
