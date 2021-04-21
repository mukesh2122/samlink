<?php $newsFunctions = MainHelper::GetModuleFunctionsByTag('news'); 
	$userPlayer = User::getUser();
	$isApproved = ($userPlayer) ? MainHelper::IsPlayerApproved($userPlayer->ID_PLAYER) : 1;
?>

<?php if (isset($topNews) and !empty($topNews)): ?>
	<!-- Top news start -->
	<div class="right_column_item top_news_right">
		<h3 class="right_column_header clearfix">
			<?php echo $this->__('Top News');?>
			<span id="news_pager" class="cycle-pager"></span>
		</h3>

		<div id="top_news_cont">
			<ul id="top_news_carousel" class="cycle-slideshow" data-cycle-fx="scrollHorz" data-cycle-timeout="4000" data-cycle-pause-on-hover="true">
				<?php foreach ($topNews as $news): ?>
					<li>
						<h2><a href="<?php echo $news->URL; ?>"><?php echo $news->Headline; ?></a></h2>

						<span class="right_column_date"><?php echo date(DATE_FULL, $news->PostingTime); ?></span>
						
						<a href="<?php echo $news->URL; ?>">
							<?php echo MainHelper::showImage($news, THUMB_LIST_200x140, false, array('no_img' => 'noimage/no_news_200x140.png')); ?>
						</a>

						<p><?php echo DooTextHelper::limitChar($news->IntroText, 120); ?></p>

						<div class="right_column_meta">
							<a class="right_column_read_more" href="<?php echo $news->URL; ?>"><?php echo $this->__('Read more Â»'); ?></a> 
							<?php if ($newsFunctions['comments']==1 && $isApproved==1): ?>
							<a class="right_column_comments link_icon icon_viewnewscomments" href="<?php echo $news->URL; ?>">
								<?php echo $news->Replies > 0 ? $this->__('Comments') : $this->__('No Comments'); ?> (<?php echo $news->Replies; ?>)
							</a>
							<?php endif; ?>
						</div>
					</li>
				<?php endforeach; ?>
			</ul>
		</div>
	</div>
	<!-- Top news end -->
<?php endif; ?>