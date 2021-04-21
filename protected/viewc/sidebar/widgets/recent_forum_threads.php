<?php
	$forumSubscribtions = MainHelper::getForumSubscribtions($player->ID_PLAYER);
	$numOfSubscribtions = count($forumSubscribtions);
	$latestForumThreads = MainHelper::getLatestForumThreads($forumSubscribtions, $numOfSubscribtions);
?>
<div class="widget recent-forum-threads" data-state="<?php echo ($isOpen == 1) ? 'open' : 'closed'; ?>" data-id="<?php echo $widgetId; ?>">
	<div class="top">
		<h3><?php echo $widgetName; ?></h3>
		<span class="slide-icon" title="<?php echo ($isOpen == 1) ? 'Collapse' : 'Expand'; ?> this widget.">&#9660;</span>
		<span class="close-icon" title="Hide this widget.">X</span>
	</div>
	<?php 
		foreach ($latestForumThreads as $key => $forum) { ?>
			<div class="widget-body forum-threads">
				<div class="forum-name">
					<h4><?php echo $this->__('Forum'); ?></h4>
					<a href="<?php echo $forum['forumURL']; ?>"><?php echo $forum['name']; ?></a>
					<?php if ($numOfSubscribtions > 1) { ?>
						<div class="change-forum">
							<?php if ($key > 0) { ?>
								<a class="prev-forum" href="#" title="Switch to the previous forum."></a><span>
							<?php } ?>
								<?php echo ($key + 1) . '/' . $numOfSubscribtions; ?></span>
							<?php if (($key + 1) < $numOfSubscribtions) { ?>
								<a class="next-forum" href="#" title="Switch to the next forum."></a>
							<?php } ?>
						</div>
					<?php } ?>
				</div>
				<ul class="list-of-items">
					<?php
						foreach ($forum['threads'] as $thread) {
							$userInfo = User::getById($thread->ID_PLAYER_STARTED);
							$firstTopicMessage = MainHelper::getFirstTopicMessage($thread);
							$timePosted = MainHelper::timeAgo($firstTopicMessage->PostingTime);
						?>
						<li>
							<h4>
							<?php
								if ($thread->ID_POLL > 0) { ?>
									<a href="<?php echo $thread->URL . '/' . $thread->ID_POLL; ?>">
										<?php echo $this->__('[POLL] ' . $thread->TopicName); ?>
									</a>
									<?php 
								} else { ?>
									<a href="<?php echo $thread->URL; ?>">
										<?php echo $this->__($thread->TopicName); ?>
									</a>
								<?php 
								} ?>
							</h4>
							<p class="thread-author"><?php echo $this->__('by '); ?>
								<?php if ($userInfo) { ?>
									<a href="<?php echo MainHelper::site_url('player/' . $userInfo->URL); ?>"><?php echo $this->__(PlayerHelper::showName($userInfo)); ?></a>
								<?php } else { ?>
									<a href="<?php echo MainHelper::site_url('player/'); ?>"><?php echo $this->__('Unknown'); ?></a>
								<?php } ?>
							</p>
							<p class="thread-posted-time"><?php echo $this->__('Posted: ' . $timePosted); ?></p>
						</li>
						<?php
						}
					?>
				</ul>
			</div>
			<?php
		}
	?>
</div>