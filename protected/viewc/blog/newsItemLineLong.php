<div class="clearfix mt5">
	<div class="fl w190"><a href="<?php echo $item->URL; ?>"><?php echo MainHelper::showImage($item, THUMB_LIST_180x140, false, array('no_img' => 'noimage/no_news_180x140.png')); ?></a>&nbsp;</div>
	<div class="fl w630 clearfix dot_top">
		<div class="clearfix pt5">
			<?php echo $this->renderBlock('news/common/path', array('item' => $item)); ?>
		</div>

		<h2 class="article_list_header fft mt8 fs19">
			<a href="<?php echo $item->URL; ?>"><?php echo ContentHelper::articleFeaturedHeadline($item->Headline); ?></a>
		</h2>

		<div class="intro_text"><?php echo $item->IntroText; ?></div>
		<div class="mt8 clearfix">
			<a class="fl mr10" href="<?php echo $item->URL; ?>"><?php echo $this->__('Read more'); ?></a> 
			<a class="fl link_icon icon_viewnewscomments" href="<?php echo $item->URL; ?>">
				<?php echo $item->Replies > 0 ? $this->__('View Comments') : $this->__('No Comments'); ?> (<?php echo $item->Replies; ?>)
			</a>
			<div class="news_date fs11 fft fclg fr pt5"><?php echo MainHelper::calculateTime($item->PostingTime); ?></div>
		</div>
	</div>
</div>