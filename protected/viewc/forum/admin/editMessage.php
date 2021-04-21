<?php
$reguserFunctions = MainHelper::GetModuleFunctionsByTag('reguser');

$userPlayer = User::getUser();
$isApproved = ($userPlayer) ? MainHelper::IsPlayerApproved($userPlayer->ID_PLAYER) : 1;

$suspendLevel = ($userPlayer) ? $userPlayer->getSuspendLevel() : 0;
$noProfileFunctionality = MainHelper::GetNoProfileFunctionality($suspendLevel);
$noSiteFunctionality = MainHelper::GetNoSiteFunctionality($suspendLevel);

?>
<?php // have this - but cant make it work
//include('../forum/common/tabs.php');?>

<?php if(isset($crumb)): ?>
	<div class="clearfix">
		<?php echo $this->renderBlock('common/breadcrumb', array('crumb' => $crumb)); ?>
	</div>
<?php endif; ?>

<div class="message_container">
    <!-- header -->
    <div class="clearfix">
        <span class="fs22 fft fclg2 fl mt10 mb20 mr10"><?php echo $this->__('Edit message'); ?></span>
    </div>
    <!-- end header -->
    <form  method="post" id="EditMessageForm"> 
    	<input type="hidden" name="type" value="<?php echo $type; ?>" />
        <input type="hidden" name="id" value="<?php echo $id; ?>" />
        <input type="hidden" name="board_id" value="<?php echo $board_id ?>" />
        <input type="hidden" name="topic_id" value="<?php echo $topic_id; ?>" />
        <input type="hidden" name="poll_id" value="<?php echo $poll_id ?>" />
        <input type="hidden" name="msg_id" value="<?php echo $msg_id; ?>" />
		<input type="hidden" name="firstMsgID" value="<?php echo $firstMsgID; ?>" />
		<input type="hidden" name="threadStarter" value="<?php echo $threadStarter; ?>" />
		<input type="hidden" name="createdBy" value="<?php echo $createdBy; ?>" />
		<div class="postContainer mb20 w600">
			<div class = "textMid w600">
				<?php 
				if ($model->isForumAdmin() OR $model->isForumMod() OR $model->isBoardMod($type, $id, $board_id, $user->ID_PLAYER) ){
					
					if($firstMsgID == $msg_id){ 
						echo '<input type="text" id="topicSubject" class=" borderframe mb20 w470" name="topicSubject"  value=" '.$subject.' " /> '; ?>
						<textarea id="msgbody" class="elasticTextA inputTextArea mb20 w470" name="body"> <?php echo $body; ?> </textarea>
						
					<?php }else{ ?>
						<textarea id="msgbody" class="elasticTextA inputTextArea mb20 w470" name="body"> <?php echo $body; ?> </textarea>
					<?php	
					}

				}elseif($user && $model->isMember() ){
					
					if($firstMsgID == $msg_id AND $user->ID_PLAYER == $threadStarter){
						echo '<input type="text" id="topicSubject" class=" borderframe mb20 w470" name="topicSubject"  value=" '.$subject.' " /> ';	?>
						<textarea id="msgbody" class="elasticTextA inputTextArea mb20 w470" name="body"> <?php echo $body; ?> </textarea>
						
					<?php }elseif($user->ID_PLAYER == $createdBy){ ?>
						
						<textarea id="msgbody" class="elasticTextA inputTextArea mb20 w470" name="body"> <?php echo $body; ?> </textarea>
					<?php	
					}
				}
				?>
			</div>
			<a href="javascript:void(0)" class="updateMessage_yes roundedButton grey fr  mt10">
				<span class="lrc"></span>
				<span class="mrc"><?php echo $this->__('Update'); ?></span>
				<span class="rrc"></span>
			</a>
					
		</div>
	</form>
</div>