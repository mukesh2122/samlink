<!--?php include('common/top.php'); ?-->
<div id="news_center_column" class="column content_middle esport_content">
<?php if(isset($topNews)):?>
	<?php echo $this->renderBlock('esport/news/topNewsList', array('topNews' => $topNews, 'blockType'=> NEWS_TOP,  'head' => $this->__('Top News'), 'hideText' => $this->__('Top News')));?>
<?php endif; ?>

<?php if(isset($recentNews)):?>
	<?php echo $this->renderBlock('esport/news/newsList', array('newsList' => $recentNews, 'pager' => $pager, 'pagerObj' => $pagerObj, 'headerName' => $this->__('Recent News')));?>
<?php endif; ?>
</div>
