<?php 
    include('common/top.php'); 
?>

<?php echo $this->renderBlock('blog/bloggersList', array('bloggersList' => $players, 'pager' => $pager, 'pagerObj' => $pagerObj, 'back' => $this->__('Back to All Games'), 'back_link' => MainHelper::site_url('blog/bloggers'), 'headerName' => $this->__('Bloggers')));?>
