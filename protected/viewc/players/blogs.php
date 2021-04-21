<?php
	include('tabs_wall.php');
        $user = User::getUser();
        $item = $blogs[0];
        $descLimit = 14000;
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
    }
?>
        <?php if($user->ID_PLAYER==$poster->ID_PLAYER): ?>
        <div class="clearfix mt10 fr">
            <a class="roundedButton grey mr5" href="<?php echo MainHelper::site_url('blog/addblog'); ?>">
                <span class="lrc"></span>
                <span class="mrc pr10 pl10"><?php echo $this->__('Add Blog Post');?></span>
                <span class="rrc"></span>
            </a>
        </div>
        <?php endif; ?>
        
<?php if(!empty($item)) { ?>
<article class="news_article">
        <h1><a class="link_black" href="<?php echo $item->URL; ?>"><?php echo $item->Headline;?></a></h1>
        <div class="news_article_meta clearfix">
            <?php if(isset($item->Path) and !empty($item->Path)):?>
                <div class="news_article_path">
                    <i class="tags_icon"></i>
                    <?php
                    $num = 0;
                    $totalNum = count($item->Path);
                    ?>
                    <?php foreach ($item->Path as $path):?>
                        <a href="<?php echo MainHelper::site_url('player/'.$author->URL);?>"><?php echo $path->Title;?></a>
                        <?php echo ($num < $totalNum - 1) ? '<span>></span>' : ''; ;?>
                    <?php $num++; endforeach;?>
                </div>
            <?php endif; ?>

            <time class="news_article_date" pubdate="pubdate"><i class="clock_icon"></i><?php echo MainHelper::calculateTime($item->PostingTime); ?></time>

            <span class="news_article_comments"><i class="speech_bubble_icon"></i><?php echo ($item->Replies != 1) ? $item->Replies . ' ' . $this->__('comments') : $item->Replies . ' ' . $this->__('comment'); ?><span>
        </div>

        <p class="news_article_teaser mb10"><?php echo strip_tags($item->IntroText); ?></p>
        <div class="news_article_img"><?php echo MainHelper::showImage($item, THUMB_LIST_600x200, false, array('no_img' => 'noimage/no_news_600x200.png')); ?></div>
        <?php echo DooTextHelper::limitChar($item->NewsText, $descLimit, '')?>
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
        <?php if(!empty($blogs)): ?>
        <div class="item_list">
            <div id="news_center_column" class="column blogs_list">
                <?php foreach ($blogs as $key=>$item):?>
                    <?php if($key>0) echo $this->renderBlock('blog/blogItemLine', array('item' => $item));?>
                <?php endforeach; ?>
            </div>
        </div>
        <?php endif; ?>