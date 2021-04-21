<?php
	$reguserFunctions = MainHelper::GetModuleFunctionsByTag('reguser');
	$userPlayer = User::getUser();
	$isApproved = ($userPlayer) ? MainHelper::IsPlayerApproved($userPlayer->ID_PLAYER) : 1;

	$suspendLevel = ($userPlayer) ? $userPlayer->getSuspendLevel() : 0;
	$noProfileFunctionality = MainHelper::GetNoProfileFunctionality($suspendLevel);
	$noSiteFunctionality = MainHelper::GetNoSiteFunctionality($suspendLevel);

	$forumBanned = MainHelper::ifBannedForum($ownerType, $ownerID);
	$boardBanned = MainHelper::ifBannedBoard($ownerType, $ownerID, $board->ID_BOARD);
	
	$playerid = $thread->ID_PLAYER_STARTED;
	$player = User::getById($playerid);

	$last_msg_info = $model->getLastMessageOfEntireBoard($ownerType, $ownerID, $thread->ID_LAST_MSG);
	$last_player_info = User::getById($last_msg_info->ID_PLAYER);

	if ($userPlayer) {
		$playersHighestMsgNumberforTopic = MainHelper::getHighestMsgNumberForTopic($userPlayer->ID_PLAYER, $thread);
		$highestMsgNumber = isset($playersHighestMsgNumberforTopic->ID_MSG) ? $playersHighestMsgNumberforTopic->ID_MSG : 1;
		$firstUnreadMsgNumber = MainHelper::getFirstUnreadMsgNumberForTopic($highestMsgNumber, $thread);
		$pageOfFirstUnreadMsg = MainHelper::getPageForFirstUnreadMsgForTopic($highestMsgNumber, $thread);
	} else {
		$highestMsgNumber = $firstUnreadMsgNumber = 1;
	}

	$topicPaginationBaseUrl = $model->FORUM_URL . '/' . $board->ID_BOARD . '/' . $thread->ID_TOPIC . '/page';
	$pagerTopics = MainHelper::TopicPagination($board->OwnerType, $board->ID_OWNER, $thread->ID_TOPIC, $topicPaginationBaseUrl);
	//var_dump($thread);
?>
<div class="threadBg <?php echo ($highestMsgNumber < $firstUnreadMsgNumber) ? 'unread' : ''; ?>">
	<div class="iconsForum">
		<?php
		if(!$boardBanned && !$forumBanned){
			if ($model->isForumAdmin() || ($model->isForumMod() && !$noSiteFunctionality)) {
				if ($thread->isSticky == 0): ?>
					<div class="pinThread"><a href="<?php echo $thread->URL . '/pl-type/pin'; ?>" title="Pin it."><img src="<?php echo MainHelper::site_url('global/img/iconPinForumRED.png'); ?>"></a></div>
				<?php else: ?>
					<div class="unpinThread"><a href="<?php echo $thread->URL . '/pl-type/unpin'; ?>" title="Unpin it."><img src="<?php echo MainHelper::site_url('global/img/iconPinForum.png'); ?>"></a></div>
				<?php endif;
				if ($highestMsgNumber < $firstUnreadMsgNumber) { 
					if($thread->ID_POLL > 0){ ?>
						<div>
							<?php if ($pageOfFirstUnreadMsg > 1) { ?>
								<a href="<?php echo $thread->URL .'/'. $thread->ID_POLL .'/page/' . $pageOfFirstUnreadMsg . '/#reply-' . $firstUnreadMsgNumber; ?>" title="Go to the first unread reply."><img src="<?php echo MainHelper::site_url('global/img/iconGoToButtonLightForum.png'); ?>"></a>
							<?php } else { ?>
								<a href="<?php echo $thread->URL .'/'. $thread->ID_POLL. '/#reply-' . $firstUnreadMsgNumber; ?>" title="Go to the first unread reply."><img src="<?php echo MainHelper::site_url('global/img/iconGoToButtonLightForum.png'); ?>"></a>
							<?php } ?>
						</div>
					<?php 
					}else{ ?>
						<div>
						<?php if ($pageOfFirstUnreadMsg > 1) { ?>
							<a href="<?php echo $thread->URL . '/page/' . $pageOfFirstUnreadMsg . '/#reply-' . $firstUnreadMsgNumber; ?>" title="Go to the first unread reply."><img src="<?php echo MainHelper::site_url('global/img/iconGoToButtonLightForum.png'); ?>"></a>
						<?php } else { ?>
							<a href="<?php echo $thread->URL . '/#reply-' . $firstUnreadMsgNumber; ?>" title="Go to the first unread reply."><img src="<?php echo MainHelper::site_url('global/img/iconGoToButtonLightForum.png'); ?>"></a>
						<?php } ?>
					</div>
					<?php
					}
				}
				if ($thread->isLocked == 0){ ?>
					<div class="lockThread"><a href="<?php echo $thread->URL . '/pl-type/lock'; ?>" title="Lock it."><img src="<?php echo MainHelper::site_url('global/img/iconLockForumGREY.png'); ?>"></a></div>
				<?php
				} else { ?>
					<div class="unlockThread"><a href="<?php echo $thread->URL . '/pl-type/unlock'; ?>" title="Unlock it."><img src="<?php echo MainHelper::site_url('global/img/iconLockForum.png'); ?>"></a></div>
				<?php 
				}
			} else {
				// normal user - just icons no functions
				if ($thread->isSticky == 1) { // pinned - green pin ?>
					<div><a href="javascript:void(0);" title="Pinned."><img src="<?php echo MainHelper::site_url('global/img/iconPinForum.png'); ?>"></a></div>
				<?php
				}
				if ($highestMsgNumber < $firstUnreadMsgNumber) { 
					if($thread->ID_POLL > 0){ ?>
						<div>
							<?php if ($pageOfFirstUnreadMsg > 1) { ?>
								<a href="<?php echo $thread->URL .'/'. $thread->ID_POLL .'/page/' . $pageOfFirstUnreadMsg . '/#reply-' . $firstUnreadMsgNumber; ?>" title="Go to the first unread reply."><img src="<?php echo MainHelper::site_url('global/img/iconGoToButtonLightForum.png'); ?>"></a>
							<?php } else { ?>
								<a href="<?php echo $thread->URL .'/'. $thread->ID_POLL. '/#reply-' . $firstUnreadMsgNumber; ?>" title="Go to the first unread reply."><img src="<?php echo MainHelper::site_url('global/img/iconGoToButtonLightForum.png'); ?>"></a>
							<?php } ?>
						</div>
					<?php 
					}else{ ?>
						<div>
						<?php if ($pageOfFirstUnreadMsg > 1) { ?>
							<a href="<?php echo $thread->URL . '/page/' . $pageOfFirstUnreadMsg . '/#reply-' . $firstUnreadMsgNumber; ?>" title="Go to the first unread reply."><img src="<?php echo MainHelper::site_url('global/img/iconGoToButtonLightForum.png'); ?>"></a>
						<?php } else { ?>
							<a href="<?php echo $thread->URL . '/#reply-' . $firstUnreadMsgNumber; ?>" title="Go to the first unread reply."><img src="<?php echo MainHelper::site_url('global/img/iconGoToButtonLightForum.png'); ?>"></a>
						<?php } ?>
					</div>
					<?php
					}
				}
				if ($thread->isLocked == 1) { ?>
					 <div><a href="javascript:void(0);" title="Locked."><img src="<?php echo MainHelper::site_url('global/img/iconLockForum.png'); ?>"></a></div>
				<?php
				}
			}
		}
		?>
	</div>
	<div class="forumLeft">
		<div class="subjectForum">
			<p class="forumSubject">
			<?php
			if($thread->ID_POLL > 0) {
				echo '<a href="'. $thread->URL.'/'.$thread->ID_POLL.'" class="fcdg fs14">
				
					<strong>[POLL] '. $thread->Subject.'</strong>
				</a>';
			} else {
				echo '<a href="'. $thread->URL.'" class="fcdg fs14">
					<strong>'.$thread->Subject.'</strong>
				</a>';
			}
			?>
			</p>
		</div>
		<div class="descriptionForum">
			<?php echo $this->__('Started by:');
			if ($player): ?>
				<a href="<?php echo MainHelper::site_url('player/'.$player->URL); ?>">
					<?php echo PlayerHelper::showName($player); ?>
				</a>
			<?php
			else:
				echo $this->__('Unknown')." ";
			endif;
			echo date(DATE_FULL, $thread->PostingTime);
			if (isset($pagerTopics) and $pagerTopics->totalPage > 1) {
				echo $this->renderBlock('forum/common/pagination', array('pager' => $pagerTopics));
			}
			?>
		</div>
	</div>
	<div class="forumCenter">
		<div><?php echo $thread->ReplyCount, ' ', $this->__('Replies'); ?></div>
		<div><?php echo $thread->ViewCount, ' ', $this->__('Views'); ?></div>
	</div>
	<div class="forumRight">
		<div class="forumAvatar">
			<a href="<?php echo (empty($last_player_info)) ? 'javascript:void(0);' : MainHelper::site_url('player/' . $last_player_info->URL); ?>">
				<?php echo MainHelper::showImage($player, THUMB_LIST_40x40, false, array('no_img' => 'noimage/no_player_40x40.png')); ?>
			</a>
		</div>
		<p class="forumThread">
			<?php echo $this->__('Latest'), ': ';
			if($last_player_info): ?>
				<a href="<?php echo MainHelper::site_url('player/' . $last_player_info->URL); ?>"><?php echo PlayerHelper::showName($last_player_info); ?></a>
			<?php else:
				echo $this->__('Unknown');
			endif; ?>
			<span class="posting-time">
				<?php echo date(DATE_FULL, $last_msg_info->PostingTime); ?>
			</span>
		</p>
	</div>
	<div class="clearfix"></div>
</div>
