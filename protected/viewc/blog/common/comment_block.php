<?php
$url = 'http://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
$urlEncoded = urlencode('http://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']);
$title = $item->Headline;
$titleEncoded = urlencode($item->Headline);
$description = strip_tags(DooTextHelper::limitChar($item->NewsText, 300));
$descriptionEncoded = urlencode(strip_tags(DooTextHelper::limitChar($item->NewsText, 300)));
$mailBody = urlencode($this->__('I want to share news with you:')." ".$url);
$itemID = $item->ID_NEWS;
$langID = $item->LANG_ID;
$itemReplies = $item->Replies;
$likeCount = $item->LikeCount;
$dislikeCount = $item->DislikeCount;
$likeTxt = $this->__('Like');
$unlikeTxt = $this->__('Unlike');
$subscribeTxt = $this->__('Subscribe');
$unsubscribeTxt = $this->__('Unsubscribe');
$dislikeTxt = $this->__('Dislike');
$undislikeTxt = $this->__('Undislike');
$commentTxt = $this->__('Comment');
?>
<div class="news_article_actions_container clearfix">
	<!-- Article actions start -->
	<div class="news_article_actions">
		<a data-opt='{"ID":"<?php echo $itemID; ?>", "langID": "<?php echo $langID; ?>"}' class="icon_link action_viewnewscomments vc_<?php echo $itemID; ?>" href="javascript:void(0);">
            <i class="comment_icon"></i>
            <?php echo $itemReplies > 0 ? $this->__('View All Comments') : $this->__('No Comments'); ?> 
            (<span class="comments_num_<?php echo $itemID; ?>"><?php echo $itemReplies; ?></span>)
        </a>
		<a data-opt='{"ID":"<?php echo $itemID; ?>", "langID": "<?php echo $langID; ?>"}' class="icon_link action_hidenewscomments hc_<?php echo $itemID; ?> dn" href="javascript:void(0);">
            <i class="comment_icon"></i>
            <?php echo $this->__('Hide comments'); ?> 
            (<span class="comments_num_<?php echo $itemID; ?>"><?php echo $itemReplies; ?></span>)
        </a>
		<?php if(Auth::isUserLogged()):
			if($item->isLiked()): ?>
				<a data-opt='{"id":"<?php echo $itemID; ?>", "reply": "0", "type":"news", "like":"1"}' class="icon_link action_unlike unlike_<?php echo $itemID; ?>_0" href="javascript:void(0);">
                    <i class="like_icon"></i>
                    <?php echo $unlikeTxt; ?> 
                    (<span class="like_comment_num"><?php echo $likeCount; ?></span>)
                </a>
				<a data-opt='{"id":"<?php echo $itemID; ?>", "reply": "0", "type":"news", "like":"1"}' class="icon_link action_like dn like_<?php echo $itemID; ?>_0" href="javascript:void(0);">
                    <i class="like_icon"></i><?php echo $likeTxt; ?> 
                    (<span class="like_comment_num"><?php echo $likeCount; ?></span>)
                </a>
			<?php else: ?>
				<a data-opt='{"id":"<?php echo $itemID; ?>", "reply": "0", "type":"news", "like":"1"}' class="icon_link action_like like_<?php echo $itemID; ?>_0" href="javascript:void(0);">
                    <i class="like_icon"></i><?php echo $likeTxt; ?> 
                    (<span class="like_comment_num"><?php echo $likeCount; ?></span>)
                </a>
				<a data-opt='{"id":"<?php echo $itemID; ?>", "reply": "0", "type":"news", "like":"1"}' class="icon_link action_unlike dn unlike_<?php echo $itemID; ?>_0" href="javascript:void(0);">
                    <i class="like_icon"></i><?php echo $unlikeTxt; ?> 
                    (<span class="like_comment_num"><?php echo $likeCount; ?></span>)
                </a>
			<?php endif;
            if($item->isDisliked()): ?>
				<a data-opt='{"id":"<?php echo $itemID; ?>", "reply": "0", "type":"news", "like":"0"}' class="icon_link action_undislike undislike_<?php echo $itemID; ?>_0" href="javascript:void(0);">
                    <i class="dislike_icon"></i><?php echo $undislikeTxt; ?> 
                    (<span class="dislike_comment_num"><?php echo $dislikeCount; ?></span>)
                </a>
				<a data-opt='{"id":"<?php echo $itemID; ?>", "reply": "0", "type":"news", "like":"0"}' class="icon_link action_dislike dn dislike_<?php echo $itemID; ?>_0" href="javascript:void(0);">
                    <i class="dislike_icon"></i><?php echo $dislikeTxt; ?> 
                    (<span class="dislike_comment_num"><?php echo $dislikeCount; ?></span>)
                </a>
            <?php else: ?>
				<a data-opt='{"id":"<?php echo $itemID; ?>", "reply": "0", "type":"news", "like":"0"}' class="icon_link action_dislike dislike_<?php echo $itemID; ?>_0" href="javascript:void(0);">
                    <i class="dislike_icon"></i><?php echo $dislikeTxt; ?> 
                    (<span class="dislike_comment_num"><?php echo $dislikeCount; ?></span>)
                </a>
				<a data-opt='{"id":"<?php echo $itemID; ?>", "reply": "0", "type":"news", "like":"0"}' class="icon_link action_undislike dn undislike_<?php echo $itemID; ?>_0" href="javascript:void(0);">
                    <i class="dislike_icon"></i><?php echo $undislikeTxt; ?> 
                    (<span class="dislike_comment_num"><?php echo $dislikeCount; ?></span>)
                </a>
            <?php endif;
			if($item->isSubscribed()): ?>
				<a data-opt='{"id":"<?php echo $itemID; ?>", "type":"<?php echo SUBSCRIPTION_NEWS; ?>"}' class="icon_link dn subscribe subscribe_<?php echo $itemID; ?>" href="javascript:void(0);">
                    <i class="subscribe_icon"></i><?php echo $subscribeTxt; ?>
                </a>
				<a data-opt='{"id":"<?php echo $itemID; ?>", "type":"<?php echo SUBSCRIPTION_NEWS; ?>"}' class="icon_link unsubscribe unsubscribe_<?php echo $itemID; ?>" href="javascript:void(0);">
                    <i class="unsubscribe_icon"></i><?php echo $unsubscribeTxt; ?>
                </a>
			<?php else: ?>
				<a data-opt='{"id":"<?php echo $itemID; ?>", "type":"<?php echo SUBSCRIPTION_NEWS; ?>"}' class="icon_link subscribe subscribe_<?php echo $itemID; ?>" href="javascript:void(0);">
                    <i class="subscribe_icon"></i><?php echo $subscribeTxt; ?>
                </a>
				<a data-opt='{"id":"<?php echo $itemID; ?>", "type":"<?php echo SUBSCRIPTION_NEWS; ?>"}' class="icon_link dn unsubscribe unsubscribe_<?php echo $itemID; ?>" href="javascript:void(0);">
                    <i class="unsubscribe_icon"></i><?php echo $unsubscribeTxt; ?>
                </a>
			<?php endif;
		endif; ?>
		<a class="icon_link shareTipTrigger" href="javascript:void(0);">
            <i class="share_icon"></i><?php echo $this->__('Share'); ?>
        </a>
		<!-- ShareTip start -->
		<div class="shareTip">
			<div class="shareTipArrow"></div>
			<div class="shareTipBody clearfix">
				<?php if(Auth::isUserLogged()): ?>
				<ul>
					<li>
						<a class="share_wall" data-opt='{"otype": "<?php echo SHARE_NEWS; ?>", "oid" : "<?php echo $itemID; ?>", "olang" : "<?php echo $lang; ?>"}' href="javascript:void(0);">
                            <?php echo $this->__('On my wall'); ?>
                        </a>
					</li>
					<li>
						<a class="share_group" data-opt='{"otype": "<?php echo SHARE_NEWS; ?>", "oid" : "<?php echo $itemID; ?>", "olang" : "<?php echo $lang; ?>"}' href="javascript:void(0);">
                            <?php echo $this->__('With a group'); ?>
                        </a>
					</li>
					<li>
						<a class="share_message" data-opt='{"otype": "<?php echo SHARE_NEWS; ?>", "oid" : "<?php echo $itemID; ?>", "olang" : "<?php echo $lang; ?>"}' href="javascript:void(0);">
                            <?php echo $this->__('By message'); ?>
                        </a>
					</li>
					<li>
						<a class="share_mail" href="mailto:?subject=<?php echo $title; ?> via playnation.eu&body=<?php echo $mailBody; ?>">
						<!--<a class="share_mail" href="mailto:?subject=<?php echo $title; ?> via playnation.eu&body=<?php echo $description; ?>">-->
                            <?php echo $this->__('By e-mail'); ?>
                        </a>
					</li>
				</ul>
				<?php endif; ?>
				<ul>
					<li>
						<a class="share_facebook" target="_blank" href="https://www.facebook.com/sharer.php?u=<?php echo $urlEncoded; ?>&t=<?php echo $titleEncoded; ?>">
                            <?php echo $this->__('Facebook'); ?>
                        </a>
					</li>
					<li>
						<a class="share_twitter" target="_blank" href="https://twitter.com/share?text=<?php echo $titleEncoded; ?>&url=<?php echo $urlEncoded; ?>&via=<?php echo urlencode('PlayNationdoteu'); ?>">
                            <?php echo $this->__('Twitter'); ?>
                        </a>
					</li>
					<li>
						<a class="share_googleplus" target="_blank" href="https://plusone.google.com/_/+1/confirm?hl=en&url=<?php echo $urlEncoded; ?>&title=<?php echo $titleEncoded; ?>">
                            <?php echo $this->__('Google+'); ?>
                        </a>
					</li>
					<li>
						<a class="share_tumblr" target="_blank" href="http://www.tumblr.com/share/link?url=<?php echo $urlEncoded; ?>&name=<?php echo $titleEncoded; ?>&description=<?php echo $descriptionEncoded; ?>">
                            <?php echo $this->__('Tumblr'); ?>
                        </a>
					</li>

				</ul>
				<ul>
					<li>
						<a class="share_stumbleupon" target="_blank" href="http://www.stumbleupon.com/submit?url=<?php echo $urlEncoded; ?>&title=<?php echo $titleEncoded ?>">
                            <?php echo $this->__('StumbleUpon'); ?>
                        </a>
					</li>
					<li>
						<a class="share_reddit" target="_blank" href="http://www.reddit.com/submit?url=<?php echo $urlEncoded; ?>&title=<?php echo $titleEncoded; ?>">
                            <?php echo $this->__('Reddit'); ?>
                        </a>
					</li>
					<li>
						<a class="share_digg" target="_blank" href="http://digg.com/submit?url=<?php echo $urlEncoded; ?>&title=<?php echo $titleEncoded; ?>">
                            <?php echo $this->__('Digg'); ?>
                        </a>
					</li>
					<li>
						<a class="share_myspace" target="_blank" href="http://www.myspace.com/Modules/PostTo/Pages/?u=<?php echo $urlEncoded; ?>">
                            <?php echo $this->__('MySpace'); ?>
                        </a>
					</li>
					<li>
						<a class="share_linkedin" target="_blank" href="http://www.linkedin.com/shareArticle?mini=true&url=<?php echo $urlEncoded; ?>&title=<?php echo $titleEncoded ?>&summary=<?php echo $descriptionEncoded; ?>&source=Playnation">
                            <?php echo $this->__('LinkedIn'); ?>
                        </a>
					</li>
				</ul>
			</div>
			<div class="copy_link">
				<input class="bbs" type="text" value="<?php echo $url; ?>">
			</div>
		</div>
		<!-- ShareTip end -->
	</div>
	<!-- Article actions end -->

	<!-- Comments start -->
	<div class="clearfix">
		<div class="w530 fr clearfix pt10">
			<div class="comments_block <?php echo strlen($replies) > 1 ? '' : 'dn'; ?> clearfix">
				<div class="comments_block_<?php echo $itemID; ?>">
				<?php echo $replies;?>
				</div>
			</div>
			<?php if(Auth::isUserLogged()): ?>
				<div class="comments-cont">
					<div class="comments-top">
						  <div class="comments-bot pr">
							<textarea id="comment_<?php echo $itemID; ?>" rows="1" class="ta comment_block" cols="1" title="<?php echo $commentTxt, '...'; ?>"><?php echo $commentTxt, '...'; ?></textarea>
							<a data-opt='{"ID":"<?php echo $itemID; ?>", "langID": "<?php echo $langID; ?>"}' class="pa comment_newspost fft link_comment" href="javascript:void(0);"><?php echo $commentTxt; ?></a>
						  </div>
					</div>
				</div>
			<?php endif; ?>
		</div>
	</div>
	<!-- Comments end -->
</div>