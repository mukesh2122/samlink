<?php
    $news = $profile['article'];
    $author = $profile['author'];
    $game = $profile['game'];
    
    //Split article headline in two for red and white headline
    $split = str_word_count($news->Headline) / 2;
    $headline = explode(' ', $news->Headline, $split + 1);
    $redhead = implode(' ',array_slice($headline, 0, -1));
    $whitehead = end($headline);
?>
<!-- Main container start -->
<div id="container" class="clearfix">
	<!-- Main content start -->
	<div id="esports_wrapper">
		<!-- E-Sports menu start -->
		<?php echo $this->renderBlock('esport/common/topbar', array()); ?>
		<!-- E-Sports menu end -->

		<!-- E-Sports content start -->
		<div class="esports_content">
			<div class="news_article_single">
            	<div class="full_width_image">
                	<?php echo MainHelper::showImage($news, THUMB_LIST_1062x420, false, array('no_img' => 'noimage/no_esportnews_1062x420.jpg')); ?>
                </div>
                <div class="breadcrumbs_visual grey_bg_reverse">
                    <h2>
                        <img src="<?php echo MainHelper::site_url('global/img/breadcrumbs_red_house.png'); ?>" /> <a href="<?php echo MainHelper::site_url('esport/news'); ?>"><?php echo ucfirst($this->__('News')); ?></a> > 
                        <a href="#to_category_page">Category</a> >  
                        <img src="global/css/img/breadcrumbs_league-of-legends.png" /><?php echo $game->GameName; ?>
                    </h2>
                </div>
                <div class="smaller_red_border red_gradient_bg">
                </div>
                <div class="article_contents">
                	<h1 class="article_header"><?php echo $redhead; ?> <span><?php echo $whitehead; ?></span><span class="author"><?php echo $this->__('by').' ' ?><a href="#Octanen-twitter-account"><?php echo $author->DisplayName; ?></a></span></h1>
                    <div class="article_text">
                    	<p>
                            <?php echo $news->NewsText; ?>
                        </p>
                    </div>
                </div>
                <div class="smaller_red_border red_gradient_bg">
                </div>
                <div class="author_short_info">
                 	<div class="author_img_name">
                      	<?php echo MainHelper::showImage($author, THUMB_LIST_100x100, false, array('no_img' => 'noimage/no_player_100x100.png')); ?>
                        <a href="#go_to_arturs_profile"><?php echo $author->FirstName; ?><span> "<?php echo $author->DisplayName; ?>" </span><?php echo $author->LastName; ?></a>
                    </div>
                  	<div class="author_description">
                      	<p>When Octanen isnt sleeping on his keyboard, lurking forums and poking around for latest news then he relaxes with gaming.<br/><br/>Playing Right Now: Dota2, League of Legends and DayZ Standalone along with Arma 3.<br/>You can catch him on Twitter: @Octanen / @PLYNeSport</p>
                    </div>
                </div>
            </div>
		</div>
		<!-- E-Sports content end -->
	</div>
	<!-- Main content end -->
</div>
<!-- Main container end -->