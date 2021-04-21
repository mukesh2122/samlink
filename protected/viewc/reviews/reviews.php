<!--?php include('common/top.php'); ?-->
<div id="news_center_column" class="column content_middle">
<?php if(isset($topReviews)) {
	echo $this->renderBlock('reviews/topReviewsList', array('topReviews' => $topReviews, 'blockType'=> NEWS_TOP,  'head' => $this->__('Top News'), 'hideText' => $this->__('Top News')));
};
if(isset($recentReviews)) {
	echo $this->renderBlock('reviews/reviewsList', array('reviewsList' => $recentReviews, 'pager' => $pager, 'pagerObj' => $pagerObj, 'headerName' => $this->__('Recent Reviews')));
}; ?>
</div>
