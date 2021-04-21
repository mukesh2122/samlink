<?php
	$reguserFunctions = MainHelper::GetModuleFunctionsByTag('reguser');
	$userPlayer = User::getUser();
	$isApproved = ($userPlayer) ? MainHelper::IsPlayerApproved($userPlayer->ID_PLAYER) : 1;

	if($board->TopicCount > 0){
		$last_msg_info = $model->getLastMessageOfEntireBoard($ownerType, $ownerID, $board->ID_LAST_MSG);
		$last_player_info =User:: getById($last_msg_info->ID_PLAYER);
	}
	
?>

<div class="mt10 clearfix itemPost pr">
	<div class="iconForum">
		<img src="<?php echo MainHelper::site_url('global/img/iconForum.png'); ?>">
	</div>
	<div class="forumLeft">
		<div class="subjectForum">
			<a href="<?php echo $board->URL; ?>"><?php echo $board->BoardName; ?></a>
		</div>

		<div class="descriptionForum">
			 <?php 
				if($board->BoardDesc == ""){
					echo '<p>'. $this->__('There is no description of this board.').'</p>'; 
				}else{
					echo '<p>'.$board->BoardDesc.'</p>';
				}
			?>
		</div>
			
		<div class="topicsForum">
			<?php if(empty($board->childBoards)): ?>
					<?php echo $board->TopicCount ? $board->TopicCount : 0;
						echo " ".$this->__('Topics');
						echo " ". ($board->PostCount - $board->TopicCount)." ".$this->__('replies');
					?> 
			<?php else: ?>
				<div class="fl mr10">
					<span class="iconr_threadsForum fl mr4"></span>
					<span class="fclg1"><?php echo $this->__('Child boards'); ?>:
						<?php $i = 0;
						foreach($board->childBoards as $chb):
							echo $i == 0 ? '' : ', '; ?>
							<a class="fclg1" href="<?php echo $board->URL; ?>"><?php echo $chb->BoardName; ?></a>
							<?php $i++;
						endforeach; ?>
					</span>
				</div>
			<?php endif; ?>
		</div>
	</div>

		
	<div class="forumRight">
			 <p>
   
            <?php 
            if(isset($last_msg_info) && !empty($last_msg_info)) {
               
                if($last_msg_info->ID_POLL > 0 ){ 
                    echo '<a href="'.MainHelper::site_url('forum/'.$ownerType.'/'.$url.'/'.$board->ID_BOARD.'/'.$last_msg_info->ID_TOPIC.'/'.$last_msg_info->ID_POLL).'"> [POLL] '.$last_msg_info->Subject.' </a><br/>';
                }else{
                    echo '<a href="'.MainHelper::site_url('forum/'.$ownerType.'/'.$url.'/'.$board->ID_BOARD.'/'.$last_msg_info->ID_TOPIC).'">'.$last_msg_info->Subject.' </a><br/>';
                }
                
				echo $this->__('Latest: '); 
				if(!is_object($last_player_info)){
					echo $last_msg_info->PosterName.'.<br/>';            
				}else{ ?>
					<a href="<?php echo MainHelper::site_url('player/'.$last_player_info->URL); ?>" > <?php echo  $last_player_info->DisplayName; ?> </a><br/> 
				<?php
				}

				if(empty($last_msg_info->PostingTime)){
					echo $this->__('Date unknown');
				}else{
					echo date(DATE_FULL, $last_msg_info->PostingTime);
				}
			}else{
				echo $this->__('Latest: '); 
			}?>
			
			</p>
	  
	</div>
	 <div class="forum_dividingStripe"></div>
</div>
