<?php 
	$functions = MainHelper::GetModuleFunctionsByTag('news');
	$userPlayer = User::getUser();
	$isApproved = ($userPlayer) ? MainHelper::IsPlayerApproved($userPlayer->ID_PLAYER) : 1;
        $descLimit = 1400;
?>

<?php
if(isset($item->NwItemLocale)){
        $author = ($item->ID_AUTHOR) ? User::getById($item->ID_AUTHOR) : 0;
	$locale = current($item->NwItemLocale);
	if($locale) {
		$item->Image = $locale->Image;
		$item->Headline = $locale->Headline;
		$item->IntroText = $locale->IntroText;
		$item->NewsText = $locale->NewsText;
		$item->Replies = $locale->Replies;
	}
        $newsText = preg_replace("/<img[^>]+\>/i", "", $item->NewsText); 
}
?>
<?php if(!empty($item)) { ?>
<article class="featured_blog">
    <h1 class="news_article_headline mb20"><?php echo $headerName; ?></h1>
    <?php if(!empty($headerName)): ?>
    <div id="featured_blog" class="clearfix">
        <div id="fb_left">
            <div class="profile_foto">
                <a href="<?php echo $item->URL; ?>" class="personal_profile_link">
                    <?php echo MainHelper::showImage($author, THUMB_LIST_200x300, false, array('width', 'no_img' => 'noimage/no_player_200x300.png'));?>
                </a>
            </div>
            <div class="profile_nickname">
                <span><?php echo $author->NickName;?></span>
            </div>
        </div>
    <?php endif ?>
        <div id="fb_right">
            <h1><a class="link_black" href="<?php echo $item->URL; ?>"><?php echo $item->Headline;?></a></h1>
            <div class="news_article_meta clearfix">
                <?php if(isset($item->Path) and !empty($item->Path)):?>
                    <div class="news_article_path">
                        <i class="tags_icon"></i>
                        <?php foreach ($item->Path as $path):?>
                            <a href="<?php echo MainHelper::site_url('player/'.$author->URL.'/wall/blog');?>"><?php echo $author->NickName;?></a>
                        <?php endforeach;?>
                    </div>
                <?php endif; ?>

                <time class="news_article_date" pubdate="pubdate"><i class="clock_icon"></i><?php echo MainHelper::calculateTime($item->PostingTime); ?></time>

                <span class="news_article_comments"><i class="speech_bubble_icon"></i><?php echo ($item->Replies != 1) ? $item->Replies . ' ' . $this->__('comments') : $item->Replies . ' ' . $this->__('comment'); ?><span>
            </div>

            <p class="news_article_teaser mb10"><?php echo strip_tags($item->IntroText); ?></p>
            <div class="news_article_img"><?php echo MainHelper::showImage($item, THUMB_LIST_138x107, false, array('no_img' => 'noimage/no_news_138x107.png')); ?></div>

            <p><?php echo DooTextHelper::limitChar($newsText, $descLimit, '')?>
                <span class="ml5">
                     <a class="link_black" href="<?php echo $item->URL; ?>"><?php echo $this->__('Read more...'); ?></a>
                </span></p>
            
<!--            <a href="<?php echo MainHelper::site_url('player/'.$author->URL); ?>"><?php echo $this->__('by'); ?> <?php echo PlayerHelper::showName($author); ?></a>-->
        </div>
    </div>
</article>
<?php } 
else {
?>
    <article class="news_article">
        <span><?php echo "There are no blogs written yet."?></span>
    </article>
<?php
}
?>