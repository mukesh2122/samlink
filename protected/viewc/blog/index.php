    <?php echo $this->renderBlock('blog/blogItemFeatured', array('item' => $featuredBlog[0], 'headerName' => $this->__('Featured Blog')));?>

    <div id="news_border"> </div>
    <?php echo $this->renderBlock('blog/indexLeftSide', array('mostReadList' => $mostReadList)); ?>
    <div id="news_center_column" class="column">
        <div class="list_container">
            <?php include('common/top.php'); ?>
            <?php echo $this->renderBlock('blog/blogList', array('blogList' => $recentBlog, 'pager' => $pager, 'pagerObj' => $pagerObj, 'headerName' => $this->__('Latest blogs'), 'featuredBlog' => $featuredBlog[0]));?>
        </div>
    </div>
