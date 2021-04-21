<?php
	$numOfFollowers = MainHelper::GetNumberOfFollowers($topic->ID_OWNER, $topic->OwnerType, $topic->ID_BOARD, $topic->ID_TOPIC);

	$playerID = $messages->ID_PLAYER;
	$player = User::getById($playerID);

	$user = User::getUser();
	$forumBanned = MainHelper:: ifBannedForum($type, $ownerId);
	$boardBanned = MainHelper:: ifBannedBoard($type, $ownerId, $boardInfo->ID_BOARD);

?>
<div class="catwrap">
	<div class="forumCategoryBar">
		<div class="forumCategoryNameLeft">
			<div class="forumL3CategoryName">
				<span class="cNameL3">
					<?php echo strtoupper($category->CategoryName); ?>
				</span>
				<br/>
				<span class="bNameL3">
				<?php echo $this->__($boardInfo->BoardName); ?>
				</span>
			</div>
		</div>
		<div class="forumCategoryRight">
		
		<!--<div class="clearfix messagesPagerInfo mt5 itemPost pr">-->
		</div>
	</div>
</div>
<?php //$reguserFunctions = MainHelper::GetModuleFunctionsByTag('reguser'); 
	$playerID = $messages->ID_PLAYER;
	$player = User::getById($playerID);

	$user = User::getUser(); 
?>
<div class="forumL3ThreadPost">
	<div class="forumThreadPostLeft">
		<div class="subjectForum">
			<h2>
			<?php
				if($topic->ID_POLL > 0) {
					echo "[POLL] ".$topic->TopicName;
				} else {
					echo $topic->TopicName;
				}
			?>
			</h2>
		</div>
		<div class="descriptionForum">
			<p>
				<?php echo "Started by: ";
					if($player): ?>
						<a href="<?php echo MainHelper::site_url('player/'.$player->URL); ?>">
							<?php echo PlayerHelper::showName($player);?></a>
				<?php
					else:
						echo $this->__('Unknown');
					endif;
					echo ', ' . date('d M Y', $messages->PostingTime) . ', ' . $topic->ReplyCount; ?> <?php echo $this->__('Replies') . ', ' . $topic->ViewCount; ?> <?php echo $this->__('Views');
				?>
			</p>
		</div>
		<?php
			if (isset($pager) and $pager->totalPage > 1) {
				echo $this->renderBlock('forum/common/pagination', array('pager' => $pager, 'withHighlight' => true));
			}
		?>
	</div>
	<div class="forumL3Subbar">
		<?php if(Auth::isUserLogged() and isset($topic) and $topic): ?>
			<?php if($reguserFunctions['reguserSubscriptions'] == 1 && $isApproved == 1 && !$noProfileFunctionality && !$boardBanned && !$forumBanned):?>
				<div class="clearfix subscr-links">
					<?php if($model->isSubscribedTopic($topic->ID_TOPIC)): ?>
						<a data-opt='{"id":"<?php echo $topic->ID_TOPIC;?>", "type":"<?php echo SUBSCRIPTION_TOPIC;?>", "otype": "<?php echo $type;?>", "oid": "<?php echo $ownerId;?>", "oid1": "<?php echo $topic->ID_BOARD;?>"}' title="Unfollow this topic" class="unsubscribe unsubscribe_<?php echo $type;?>_<?php echo $topic->ID_TOPIC;?>" href="#">
							<img src="<?php echo MainHelper::site_url('global/img/iconPlayers.png'); ?>">
							<?php // echo $this->__('Unfollow'); ?>
							<span class="iconForum_follow"></span>
							<?php echo $this->__($numOfFollowers); ?>
						</a>
						<a data-opt='{"id":"<?php echo $topic->ID_TOPIC;?>", "type":"<?php echo SUBSCRIPTION_TOPIC;?>", "otype": "<?php echo $type;?>", "oid": "<?php echo $ownerId;?>", "oid1": "<?php echo $topic->ID_BOARD;?>"}' title="Follow this topic" class="subscribe dn subscribe_<?php echo $type;?>_<?php echo $topic->ID_TOPIC;?>" href="#">
							<img src="<?php echo MainHelper::site_url('global/img/iconPlayers.png'); ?>">
							<?php // echo $this->__('Unfollow'); ?>
							<span class="iconForum_follow"></span>
							<?php echo $this->__($numOfFollowers - 1); ?>
						</a>
					<?php else: ?>
						<a data-opt='{"id":"<?php echo $topic->ID_TOPIC;?>", "type":"<?php echo SUBSCRIPTION_TOPIC;?>", "otype": "<?php echo $type;?>", "oid": "<?php echo $ownerId;?>", "oid1": "<?php echo $topic->ID_BOARD;?>"}' title="Follow this topic" class="subscribe subscribe_<?php echo $type;?>_<?php echo $topic->ID_TOPIC;?>" href="#">
							<img src="<?php echo MainHelper::site_url('global/img/iconPlayers.png'); ?>">
							<?php // echo $this->__('Follow'); ?>
							<span class="iconForum_follow"></span>
							<?php echo $this->__($numOfFollowers); ?>
						</a>
						<a data-opt='{"id":"<?php echo $topic->ID_TOPIC;?>", "type":"<?php echo SUBSCRIPTION_TOPIC;?>", "otype": "<?php echo $type;?>", "oid": "<?php echo $ownerId;?>", "oid1": "<?php echo $topic->ID_BOARD;?>"}' title="Unfollow this topic" class="unsubscribe dn unsubscribe_<?php echo $type;?>_<?php echo $topic->ID_TOPIC;?>" href="#">
							<img src="<?php echo MainHelper::site_url('global/img/iconPlayers.png'); ?>">
							<?php // echo $this->__('Follow'); ?>
							<span class="iconForum_follow"></span>
							<?php echo $this->__($numOfFollowers + 1); ?>
						</a>
					<?php endif; ?>
				</div>
			<?php endif; ?>
		<?php endif; 

		if(!$boardBanned && !$forumBanned && !$topic->isLocked) { ?>
			<a class="db forumThreadPostRight replyToTopic" href="#"><?php echo $this->__('+ Reply to this topic'); ?></a>
		<?php
		}
		?>
	</div>
</div>
