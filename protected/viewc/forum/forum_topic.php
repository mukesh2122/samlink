<?php
	$reguserFunctions = MainHelper::GetModuleFunctionsByTag('reguser');

	$userPlayer = User::getUser();
	$isApproved = ($userPlayer) ? MainHelper::IsPlayerApproved($userPlayer->ID_PLAYER) : 1;

	$suspendLevel = ($userPlayer) ? $userPlayer->getSuspendLevel() : 0;
	$noProfileFunctionality = MainHelper::GetNoProfileFunctionality($suspendLevel);
	$noSiteFunctionality = MainHelper::GetNoSiteFunctionality($suspendLevel);

	$forumBanned = MainHelper:: ifBannedForum($type, $ownerId);
	$boardBanned = MainHelper:: ifBannedBoard($type, $ownerId, $boardInfo->ID_BOARD);
	
?>

<?php include('common/tabs.php');

if(isset($infoBox)):
	echo $infoBox;
endif;

if(isset($crumb)): ?>
	<div class="clearfix">
		<?php echo $this->renderBlock('common/breadcrumb', array('crumb' => $crumb)); ?>
	</div>
<?php endif; ?>

<?php 
if(isset($messages) and !empty($messages)){ 
	echo $this->renderBlock('forum/common/topicTitle', 
		array( 
			'noProfileFunctionality' => $noProfileFunctionality,
			'reguserFunctions' => $reguserFunctions,
			'userPlayer' => $userPlayer,
			'isApproved'=> $isApproved, 
			'model'=> $model, 
			'messages' => $messages[0],
			'total' => $total, 
			'topic' => $topic, 
			'type'=> $type,
			'ownerId'=> $ownerId, 
			'url' => $url,
			'pager' => $pager,
			'pagerObj' => $pagerObj,
			'boardInfo' => $boardInfo,
			'category' => $category
		)
	);
?>
	
<!-- forums -->
<input type="hidden" id="type" value="<?php echo $type; ?>" />
<input type="hidden" id="id" value="<?php echo $ownerId; ?>" />
<input type="hidden" id="board" value="<?php echo $messages[0]->ID_BOARD; ?>" />
<input type="hidden" id="url" value="<?php echo $url; ?>" />
<div class="forumLevel3">
	<?php
		$i = ($pager->currentPage == 1) ? 1 : $pager->low + 1;
		foreach($messages as $m) {
			$msg_class = 'message_'.$type.'_'.$ownerId.'_'.$m->ID_BOARD.'_'.$m->ID_MSG;
			// the isXX vars is for the user that views the board
			echo $this->renderBlock('forum/common/postBlock',
				array(
					'message' => $m,
					'isForumAdmin' => $isForumAdmin,
					'isMember' => $isMember,
					'isForumMod' => $isForumMod,
					'isBoardMod' => $isBoardMod,
					'messageNum' => $i,
					'class' => $msg_class,
					'total' => $total,
					'model' => $model,
					'type' => $type,
					'url' => $url,
					'id' => $ownerId,
					'board' => $m->ID_BOARD,
					'topicID' => $topic->ID_TOPIC,
					'poll_id' => $pollid,
					'Poll_choices' => $Poll_choices,
					'topic' => $topic,
					'playerVoted' => $playerVoted,
					'getplayervote' => $getplayervote,
					'totalVotes' => $totalvotes,
					'servertime' => $servertime,
					'expiretime' => $ExpireTime
				)
			);
			$i++;
		}
	?>
</div>
<div class="clearfix"> </div>
<?php if(Auth::isUserLogged() && $isMember == true && !$topic->isLocked && !$noSiteFunctionality && !$boardBanned && !$forumBanned):?>
<?php echo $this->renderBlock('forum/common/replyBlock', array('subject' => $messages[0]->Subject)); ?>
<?php endif; ?>

<div class="forumBottom_bar">
	<div class="forumBottom_barLeft">
		<?php
			if (isset($pager) and $pager->totalPage > 1) {
				echo $this->renderBlock('forum/common/pagination', array('pager' => $pager, 'withHighlight' => true));
			}
		?>
	</div>
	<?php
	 if(!$boardBanned && !$forumBanned){
			$sURL = urlencode(MainHelper::site_url('forum/'.$type.'/'. $url.'/'.$messages[0]->ID_BOARD.'/'.$messages[0]->ID_TOPIC));
		?>
	
	<div class="forumBottom_barCenter">
		<a href="https://www.facebook.com/sharer/sharer.php?u=<?php echo $this->__($sURL); ?>" target="_blank"><i class="facebook_icon" title="Share this topic on Facebook"></i></a>
		<a href="https://twitter.com/intent/tweet?text=<?php echo $this->__($topic->TopicName); ?>&amp;url=<?php echo $this->__($sURL); ?>" target="_blank"><i class="twitter_icon" title="Share this topic on Twitter"></i></a>
	</div>
 	<?php 
 	} 
 	?>
 	<div class="forumBottom_barRight">
 	</div>
</div>

<?php } // end if isset messages?>

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
<!-- end forums -->
