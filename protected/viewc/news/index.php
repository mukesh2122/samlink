<div id="news_center_column" class="column content_middle">
    <?php include('common/top.php');
    include('common/search.php');
    include('common/filter_bar.php');

    if(isset($topNews)) {
        $headline = $this->__('Top News');
        echo $this->renderBlock('news/topNewsList', array('topNews' => $topNews, 'blockType' => NEWS_TOP, 'head' => $headline, 'hideText' => $headline));
    };
    if(isset($recentNews)) {
        echo $this->renderBlock('news/newsList', array(
            'newsList' => $recentNews,
            'pager' => $pager,
            'pagerObj' => $pagerObj,
            'tab' => isset($tab) ? $tab : 3,
            'order' => isset($order) ? $order : 'desc',
            'headerName' => $this->__('Recent News')));
    }; ?>
</div>
