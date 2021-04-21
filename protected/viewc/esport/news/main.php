<!-- Main container start -->
<div id="container" class="clearfix">
	<!-- Main content start -->
	<div id="esports_wrapper">
		<!-- E-Sports menu start -->
		<?php echo $this->renderBlock('esport/common/topbar', array()); ?>
		<!-- E-Sports menu end -->
		<!-- E-Sports News Slider start -->
		<div class="mt30" style="background:black;">
        	<?php echo $news_slider; ?>
        </div>
		<div class="esports_content news_page">
                            	<div class="news_categories">
            	<div class="news esport_profile_boxheaders live_streams mt0 big_header"><p><span><?php echo $this->__('News').' '; ?></span><?php echo $this->__('Categories'); ?></p></div>
                <div class="dark_red_container">
                    <?php foreach($NewsCategories as $category): ?>
                    <a href="#choose_this_game">
                        <div class="game_category">
                            <?php echo MainHelper::showImage($category, THUMB_LIST_18x18, false, array('no_img' => 'noimage/no_news_18x18.png')); ?>
                            <p><?php echo $category->GameName; ?></p>
                        </div>
                    </a>
                    <?php endforeach; ?>
                </div>
            </div>
			<div id="esports_news_left_column" class="new_headlines">
            	<div class="news esport_profile_boxheaders live_streams mt0 big_header"><p><span><?php echo $this->__('New'); ?></span><?php echo ' '.$this->__('Headlines'); ?></p></div>
                <ul>
                    <li>
                        <a href="<?php echo $recentNews[0]->PLAIN_URL;?>">
                            <div class="image_holder"><?php echo MainHelper::showImage($recentNews[0], THUMB_LIST_330x200, false, array('no_img' => 'noimage/no_news_330x200.png')); ?></div>
                            <p class="headline"><?php echo $recentNews[0]->Headline;?></p>
                            <p class="content"><?php echo strip_tags($recentNews[0]->IntroText) ;?></p>
                        </a>
                    </li>
                </ul>
			</div>
            <div class="news_splitter_gradient">
            </div>
			<div id="esports_news_right_column" class="latest_news">
            	<div class="news esport_profile_boxheaders live_streams mt0 big_header"><p><span><?php echo $this->__('Latest'); ?></span><?php echo ' '.$this->__('News'); ?></p></div>
                <ul>
                    <?php foreach ($recentNews as $news): ?>
                    <li>
                        <a href="<?php echo $news->PLAIN_URL;?>">
                            <div class="image_holder"><?php echo MainHelper::showImage($news, THUMB_LIST_135x90, false, array('no_img' => 'noimage/no_news_135x90.png')); ?></div>
                            <p class="headline"><?php echo $news->Headline;?></p>
                            <p class="content"><?php echo strip_tags($news->IntroText);?></p>
                        </a>
                    </li>
                    <?php endforeach; ?>
                </ul>
            </div>
            <div id="esports_news_center_column" class="horizontal_splitter">
            	<img src="<?php echo MainHelper::site_url('global/css/img/esport_news_splitter_horizontal.png'); ?>" />
            </div>
            <div id="esports_news_center_column" class="featured_videos">
                <div class="news esport_profile_boxheaders live_streams mt0 featured_header"><p><span><?php echo $this->__('Featured'); ?></span><?php echo ' '.$this->__('Videos'); ?></p></div>
                <ul>
                    <?php foreach($featureVideos as $videos): ?>
                    <li>
                        <a href="<?php echo $videos->PLAIN_URL;?>">
                            <div class="image_holder"><?php echo MainHelper::showImage($videos, THUMB_LIST_246x167, false, array('no_img' => 'noimage/no_news_246x167.png')); ?></div>
                            <p class="headline red_gradient_bg"><?php echo $videos->Headline;?></p>
                            <p class="content"><?php echo strip_tags($videos->IntroText);?></p>
                        </a>
                    </li>
                    <?php endforeach; ?>
                </ul>
            </div>
            <div id="esports_news_center_column" class="news_splitter_vertical_center horizontal_splitter">
                <div class="news esport_profile_boxheaders live_streams mt0 big_header"><p><?php echo $this->__('News'); ?></p></div>
                <ul class="main_news">
                    <?php foreach($otherNews as $news): ?>
                    <li>
                        <a href="<?php echo $news->PLAIN_URL ;?>">
                            <div class="image_holder"><?php echo MainHelper::showImage($news, THUMB_LIST_165x100, false, array('no_img' => 'noimage/no_news_165x100.png')); ?></div>
                            <p class="headline"><?php echo $news->Headline;?></p>
                            <p class="content"><?php echo strip_tags($news->IntroText) ;?></p>
                            <a class="button button_small grey pull_right btn_red_gradient_bg news_button" href="<?php echo $news->PLAIN_URL ;?>"><?php echo $this->__('Read more'); ?></a>
                        </a>
                    </li>
                    <?php endforeach; ?>
                </ul>
            </div>
            <div id="esports_news_center_column">
            	<a class="button button_small grey pull_right btn_red_gradient_bg all_news_button" href="#">View all news</a>
            </div>
		</div>
		<!-- E-Sports content end -->

	</div>
	<!-- Main content end -->
</div>
<!-- Main container end -->
		