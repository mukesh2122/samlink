<?php /*
<div class="gradient_header gradient_header_border clearfix">
	<div class="fl db fs12 mt2"><a class="header_back ml5 fcblue" href="javascript:void(0)" onclick="history.back(); return false;"><?php echo $this->__('Back to News');?></a></div>
	<span class="header_current"><?php echo MainHelper::calculateTime($item->PostingTime);?></span>
</div>
*/ 
$user = User::getUser();
$author = ($item->ID_AUTHOR) ? User::getById($item->ID_AUTHOR) : 0;
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
        <?php if(Auth::isUserLogged() && $user->ID_PLAYER==$author->ID_PLAYER): ?>
        <div class="clearfix mt10">
            <a class="roundedButton grey fl mr5" href="<?php echo MainHelper::site_url('blog/editblog/'.$item->ID_NEWS); ?>">
                <span class="lrc"></span>
                <span class="mrc pr10 pl10"><?php echo $this->__('Edit Blog-post');?></span>
                <span class="rrc"></span>
            </a>
        </div>
        <?php endif; ?>
	<h1 class="news_article_headline"><?php echo $item->Headline; ?></h1>

	<div class="news_article_meta clearfix">
		<?php if(isset($item->Path) and !empty($item->Path)):?>
			<div class="news_article_path">
				<i class="tags_icon"></i>
				<?php
				$num = 0;
				$totalNum = count($item->Path);
				?>
				<?php foreach ($item->Path as $path):?>
					<a href="<?php echo MainHelper::site_url('player/'.$author->URL.'/wall/blog');?>"><?php echo $author->NickName;?></a>
					<?php echo ($num < $totalNum - 1) ? '<span>></span>' : ''; ;?>
				<?php $num++; endforeach;?>
			</div>
		<?php endif; ?>

		<time class="news_article_date" pubdate="pubdate"><i class="clock_icon"></i><?php echo MainHelper::calculateTime($item->PostingTime); ?></time>

		<span class="news_article_comments"><i class="speech_bubble_icon"></i><span class="comments_num_<?php echo $item->ID_NEWS;?>"><?php echo ($item->Replies != 1) ? $item->Replies . '</span> ' . $this->__('comments') : $item->Replies . ' ' . $this->__('comment'); ?></span>
	</div>

	<p class="news_article_teaser"><?php echo strip_tags($item->IntroText); ?></p>

	<div class="news_article_img"><?php echo MainHelper::showImage($item, THUMB_LIST_600x200, false, array('no_img' => 'noimage/no_news_600x200.png')); ?></div>

	<?php echo $item->NewsText; ?>
	<?php if ($author): ?>
        <p>
		<a href="<?php echo MainHelper::site_url('player/'.$author->URL); ?>"> <?php echo $this->__('by'); ?> <?php echo PlayerHelper::showName($author); ?></a>
        </p>
                    <?php endif; ?>
</article>