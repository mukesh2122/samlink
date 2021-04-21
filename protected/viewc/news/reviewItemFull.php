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
$ratings = new Ratings();
$reviewRating = $ratings->getUsersRating($item->OwnerType,$item->ID_OWNER,$item->ID_AUTHOR);
?>

<div class="reviewArticleBig">
    <div class="reviewFoundUseful">142 out of 201 found this review useful</div>
    
    <div class="reviewContent">
        <div class="reviewUserImg">
            <?php echo MainHelper::showImage($item, THUMB_LIST_100x100, false, array('no_img' => 'noimage/no_news_100x100.png')); ?>
            <p><a href="<?php echo MainHelper::site_url('player/'.$author->URL); ?>"><?php echo PlayerHelper::showName($author); ?></a></p>
        </div>
        
        <div class="reviewTop">
            <div class="reviewTitle"><?php echo $item->Headline; ?></div>
            <div class="reviewUserRating">Pinguin Master's <?php echo !empty($reviewRating) ? 'rating '.round($reviewRating->Rating).'/10' : 'rating 0/10'; ?></div>
            
            <div class="reviewIntroText"><?php echo strip_tags($item->IntroText); ?></div>
            <div class="reviewText1"><?php echo $item->NewsText; ?></div>
        </div>
            
        <div class="reviewCenterBig">
            <div class="reviewText2">Sed ut perspiciatis unde omnis iste natus error 
                sit voluptatem accusantium doloremque laudantium, 
                totam rem aperiam, eaque ipsa quae ab illo inventore veritatis et quasi 
                architecto beatae vitae dicta sunt explicabo. 
                Nemo enim ipsam voluptatem quia voluptas sit aspernatur aut odit aut fugit, 
                sed quia consequuntur magni dolores eos 
                qui ratione voluptatem sequi nesciunt</div>
            
            <div class="reviewText3">Sed ut perspiciatis unde omnis iste natus error 
                sit voluptatem accusantium doloremque laudantium, 
                totam rem aperiam, eaque ipsa quae ab illo inventore veritatis et quasi 
                architecto beatae vitae dicta sunt explicabo. 
                Nemo enim ipsam voluptatem quia voluptas sit aspernatur aut odit aut fugit, 
                sed quia consequuntur magni dolores eos 
                qui ratione voluptatem sequi nesciunt.
                Sed ut perspiciatis unde omnis iste natus error 
                sit voluptatem accusantium doloremque laudantium, 
                totam rem aperiam, eaque ipsa quae ab illo inventore veritatis et quasi 
                architecto beatae vitae dicta sunt explicabo.
                <br/>
                Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. 
                Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.<br/>
                <a href="?read=all">Read less</a>
            </div>
            
            <div class="reviewComments">0 comments</div>
            <div class="reviewFindUsefull">How do you find this review?
                <a href="?find=useful&id=1"><span class="reviewUseful">Useful</span></a>
                <a href="?find=notuseful&id=1"><span class="reviewNotUseful">Not useful</span></a>
            </div>
        </div>
        
        <div class="reviewBottomBig">&nbsp;</div>
    </div>
</div>

<?php /*
<article class="news_article">
	<h1 class="news_article_headline"><?php echo $item->Headline; ?> - <?php echo $this->__('by'); ?> 
            <a href="<?php echo MainHelper::site_url('player/'.$author->URL); ?>"><?php echo PlayerHelper::showName($author); ?></a></h1>

	<div class="news_article_meta clearfix">
		<?php if(isset($item->Path) and !empty($item->Path)):?>
			<div class="news_article_path">
				<i class="tags_icon"></i>
				<a href="<?php echo MainHelper::site_url('player/'.$author->URL); ?>"><?php echo $this->__('by'); ?> <?php echo PlayerHelper::showName($author); ?></a>
			</div>
		<?php endif; ?>

		<time class="news_article_date" pubdate="pubdate"><i class="clock_icon"></i><?php echo MainHelper::calculateTime($item->PostingTime); ?></time>

		<span class="news_article_rating"><i class="like_icon"></i><?php echo !empty($reviewRating) ? 'rating '.round($reviewRating->Rating).'/10' : 'rating 0/10'; ?><span>
		<span class="news_article_comments"><i class="speech_bubble_icon"></i><?php echo ($item->Replies != 1) ? $item->Replies . ' ' . $this->__('comments') : $item->Replies . ' ' . $this->__('comment'); ?><span>
	</div>

	<p class="news_article_teaser"><?php echo strip_tags($item->IntroText); ?></p>

	<div class="news_article_img"><?php echo MainHelper::showImage($item, THUMB_LIST_138x107, false, array('no_img' => 'noimage/no_news_138x107.png')); ?></div>

	<?php echo $item->NewsText; ?>
</article>
 * 
 */?>