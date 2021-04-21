<?php /*
<div class="gradient_header gradient_header_border clearfix">
	<div class="fl db fs12 mt2"><a class="header_back ml5 fcblue" href="javascript:void(0)" onclick="history.back(); return false;"><?php echo $this->__('Back to News');?></a></div>
	<span class="header_current"><?php echo MainHelper::calculateTime($item->PostingTime);?></span>
</div>
*/

$author = User::getById($item->ID_AUTHOR);
if(isset($item->NwItemLocale)){
	$locale = current($item->NwItemLocale);
	if($locale) {
		$item->Image = $locale->Image;
		$item->Headline = $locale->Headline;
		$item->IntroText = $locale->IntroText;
		$item->NewsText = $locale->NewsText;
		$item->Replies = $locale->Replies;
	}
}
?>

<article class="news_article">
	<h1 class="news_article_headline"><?php echo $item->Headline; ?> - <?php echo $this->__('by'); ?> <a href="<?php echo MainHelper::site_url('player/'.$author->URL); ?>"><?php echo PlayerHelper::showName($author); ?></a></h1>

	<div class="news_article_meta clearfix">
		<?php if(isset($item->Path) and !empty($item->Path)):?>
			<div class="news_article_path">
				<i class="tags_icon"></i>
				<a href="<?php echo MainHelper::site_url('player/'.$author->URL); ?>"><?php echo $this->__('by'); ?> <?php echo PlayerHelper::showName($author); ?></a>
			</div>
		<?php endif; ?>

		<time class="news_article_date" pubdate="pubdate"><i class="clock_icon"></i><?php echo MainHelper::calculateTime($item->PostingTime); ?></time>

		<span class="news_article_comments"><i class="speech_bubble_icon"></i><?php echo ($item->Replies != 1) ? $item->Replies . ' ' . $this->__('comments') : $item->Replies . ' ' . $this->__('comment'); ?><span>
	</div>

	<p class="news_article_teaser"><?php echo strip_tags($item->IntroText); ?></p>

	<div class="news_article_img"><?php echo MainHelper::showImage($item, THUMB_LIST_138x107, false, array('no_img' => 'noimage/no_news_138x107.png')); ?></div>

	<?php echo $item->NewsText; ?>
</article>