<?php
	$reguserFunctions = MainHelper::GetModuleFunctionsByTag('reguser');
	$userPlayer = User::getUser();
	$isApproved = ($userPlayer) ? MainHelper::IsPlayerApproved($userPlayer->ID_PLAYER) : 1;

	$suspendLevel = ($userPlayer) ? $userPlayer->getSuspendLevel() : 0;
	$noProfileFunctionality = MainHelper::GetNoProfileFunctionality($suspendLevel);
	$noSiteFunctionality = MainHelper::GetNoSiteFunctionality($suspendLevel);

	$forumBanned = MainHelper::ifBannedForum($type, $model->UNID);
	$boardBanned = MainHelper::ifBannedBoard($type, $model->UNID, $board->ID_BOARD);
?>

<?php include('common/tabs.php'); ?>

<?php
	if(isset($infoBox)):
		echo $infoBox;
	endif;
?>

<?php if(isset($board) and $board): ?>
	<a name="top"></a>
	<?php if (isset($crumb)) { ?>
		<div class="clearfix">
			<?php echo $this->renderBlock('common/breadcrumb', array('crumb' => $crumb)); ?>
		</div>
	<?php }
	
	echo $this->renderBlock('forum/common/search', array(
		'url' => MainHelper::site_url('forum/'.$type.'/'. $url.'/'.$board->ID_BOARD.'/search'),
		'resetUrl' => MainHelper::site_url('forum/'.$type.'/'.$url.'/'.$board->ID_BOARD), 
		'searchText' => isset($searchText) ? $searchText : '',
		'label' => $label = $this->__('Search for Topics...'),
		'type' => $topic = $this->__('topics')
	));
	echo '<div class="clearfix">&nbsp;</div>';
	?>
	<div class="catwrap">
		<?php echo $this->renderBlock('forum/common/boardTitle', array('category' => $category)); ?>
	</div>

	<div class="clearfix "></div>
	<div class="clearfix boardBar pr">
		
		<div class="forumThreadBg">
			<div class="forumLeft">
				<div class="subjectForum">
					<h2><?php echo $board->BoardName; ?></h2>
				</div>
				<div class="descriptionForum">
					<?php 
						if ($board->BoardDesc == "") {
							echo '<p>'. $this->__('This board has no description.').'</p>'; 
						} else {
							echo '<p>'.$board->BoardDesc.'</p>';
						}
					?>
				</div>
				<div class="topicsForum"> 
					<?php
						if (isset($pager) and $pager->totalPage > 1) {
							echo $this->renderBlock('forum/common/pagination', array('pager' => $pager, 'withHighlight' => true));
						}
					?>
				</div>
			</div>
			<div>
				<div class="forumThreadRight">
					<?php if(Auth::isUserLogged()): ?>
						<?php  if($reguserFunctions['reguserSubscriptions']==1 && $isApproved==1 && !$noProfileFunctionality && !$boardBanned && !$forumBanned):?>
							<div class="clearfix">
							<?php if($model->isSubscribedBoard($board->ID_BOARD)):?>
								<a data-opt='{"id":"<?php echo $board->ID_BOARD;?>", "type":"<?php echo SUBSCRIPTION_BOARD;?>", "otype": "<?php echo $type;?>", "oid": "<?php echo $model->UNID;?>"}' class="buttonRRound buttonSubscribeRound dn subscribe mt5 subscribe_<?php echo $type;?>_<?php echo $board->ID_BOARD;?>" href="javascript:void(0)">
									<img src="<?php echo MainHelper::site_url('global/img/iconPlayers.png'); ?>">
									<?php // echo $this->__('Unfollow'); ?>
									<span class="iconForum_follow"></span>
									<?php echo $this->__('Follow this board'); ?>
								</a>
								<a data-opt='{"id":"<?php echo $board->ID_BOARD;?>", "type":"<?php echo SUBSCRIPTION_BOARD;?>", "otype": "<?php echo $type;?>", "oid": "<?php echo $model->UNID;?>"}' class="buttonRRound buttonSubscribeRound unsubscribe mt5 unsubscribe_<?php echo $type;?>_<?php echo $board->ID_BOARD;?>" href="javascript:void(0)">
									<img src="<?php echo MainHelper::site_url('global/img/iconPlayers.png'); ?>">
									<?php // echo $this->__('follow'); ?>
									<span class="iconForum_follow"></span>
									<?php echo $this->__('Unfollow this board'); ?>
								</a>
							<?php else: ?>
								<a data-opt='{"id":"<?php echo $board->ID_BOARD;?>", "type":"<?php echo SUBSCRIPTION_BOARD;?>", "otype": "<?php echo $type;?>", "oid": "<?php echo $model->UNID;?>"}' class="buttonRRound buttonSubscribeRound subscribe mt5 subscribe_<?php echo $type;?>_<?php echo $board->ID_BOARD;?>" href="javascript:void(0)">
									<img src="<?php echo MainHelper::site_url('global/img/iconPlayers.png'); ?>">
									<?php // echo $this->__('follow'); ?>
									<span class="iconForum_follow"></span>
									<?php echo $this->__('Follow this board'); ?>
								</a>
								<a data-opt='{"id":"<?php echo $board->ID_BOARD;?>", "type":"<?php echo SUBSCRIPTION_BOARD;?>", "otype": "<?php echo $type;?>", "oid": "<?php echo $model->UNID;?>"}' class="buttonRRound buttonSubscribeRound dn mt5 unsubscribe unsubscribe_<?php echo $type;?>_<?php echo $board->ID_BOARD;?>" href="javascript:void(0)">
									<img src="<?php echo MainHelper::site_url('global/img/iconPlayers.png'); ?>">
									<?php // echo $this->__('Unfollow'); ?>
									<span class="iconForum_follow"></span>
									<?php echo $this->__('Unfollow this board'); ?>
								</a>
							<?php endif; ?>
							</div>
						<?php endif; ?>
					<?php endif; ?>

					<?php if (Auth::isUserLogged() && $isMember && !$noSiteFunctionality && !$boardBanned && !$forumBanned ): ?>
						<div class="forumNewTopic">
							<a class="" rel="iframe" href="<?php echo MainHelper::site_url('forum/'.$type.'/'. $url.'/'.$board->ID_BOARD.'/select-create-form'); ?>">
								<?php echo $this->__('+ Start new topic'); ?>
							</a>
						</div>
						
						<div class="forumRead"><a href="<?php echo MainHelper::site_url('forum/'.$type.'/'. $url.'/'.$board->ID_BOARD.'/mark-as-read'); ?>"><img src="<?php echo MainHelper::site_url('global/img/iconReadForum.png'); ?>"/> <?php echo $this->__('Mark this board as read.') ?></a></div>
						
					<?php endif; ?>
				</div>
			</div>
		</div>
		<div class="ulOrderByBg">
			
			<ul class="ulOrderBy">
				<li><a href="<?php echo MainHelper::site_url('forum/'.$type.'/'. $url.'/'.$board->ID_BOARD.'/sort/recently-updated'); ?>" class="<?php if ($sort == 'recently-updated') echo 'current'; ?>">Recently updated</a></li>
				<li><a href="<?php echo MainHelper::site_url('forum/'.$type.'/'. $url.'/'.$board->ID_BOARD.'/sort/start-date'); ?>" class="<?php if ($sort == 'start-date') echo 'current'; ?>">Start date</a></li>
				<li><a href="<?php echo MainHelper::site_url('forum/'.$type.'/'. $url.'/'.$board->ID_BOARD.'/sort/most-replies'); ?>" class="<?php if ($sort == 'most-replies') echo 'current'; ?>">Most replies</a></li>
				<li><a href="<?php echo MainHelper::site_url('forum/'.$type.'/'. $url.'/'.$board->ID_BOARD.'/sort/most-viewed'); ?>" class="<?php if ($sort == 'most-viewed') echo 'current'; ?>">Most viewed</a></li>
				<!-- <li><a href="#">Custom</a></li> -->
			</ul>
		</div>
	</div>
	<?php if (isset($childBoards) and !empty($childBoards)): ?>
		<?php
			$n = 0;
			foreach ($childBoards as $b): ?>
				<?php echo $this->renderBlock('forum/common/boardItem', array(
					'model' => $model, 
					'board' => $b, 
					'n' => $n, 
					'ownerType' => $type, 
					'ownerID' => $ownerId, 
					'isAdmin' => $isAdmin, 
					'url' => $url));
			$n++;
			endforeach;
		?>
	<?php endif; ?>
	<div class="treadBGwrapper">
		<?php if(isset($topics) and !empty($topics)):
			$n = 0;
			foreach($topics as $t): ?>
				<?php echo $this->renderBlock('forum/common/threadItem', array(
					'model' => $model,
					'board' => $board,
					'thread' => $t,
					'ownerType' => $type,
					'url' => $url,
					'ownerID' => $ownerId,
					'n' => $n));
			$n++;
			endforeach; ?>
		<?php else: ?>
			<div class="noItemsText"><?php echo $this->__('There are no forum topics at this moment.'); ?></div>
		<?php endif; ?>
	</div>
<?php endif;?>

<div class="clearfix"></div>
<div class="forumBottom_bar">
	<div class="forumBottom_barLeft">
	<?php
		if (isset($pager) and $pager->totalPage > 1) {
			echo $this->renderBlock('forum/common/pagination', array('pager' => $pager, 'withHighlight' => true));
		}
	?>
	</div>
	<div class="forumBottom_barCenter">
	</div>
	<div class="forumBottom_barRight">
		<a href="#top"><?php echo $this->__('To top'); ?></a>
	</div>
</div>




<?php
	echo $this->renderBlock('forum/common/onlineUsers',
							 array(
							 	'allOnlineUsers' => $allOnlineUsers,
							 	'OnlineUsers' => $OnlineUsers,
							 	'onlineGuests' => $onlineGuests,
							 	'onlineMembers' => $onlineMembers,
							 	'model' => $model

							  ) 
	     );
?>
