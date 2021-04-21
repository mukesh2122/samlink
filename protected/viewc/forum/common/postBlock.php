<?php 
	$reguserFunctions = MainHelper::GetModuleFunctionsByTag('reguser');
	$user = User::getUser();
	$isApproved = ($user) ? MainHelper::IsPlayerApproved($user->ID_PLAYER) : 1;

	$suspendLevel = ($user) ? $user->getSuspendLevel() : 0;
	$noProfileFunctionality = MainHelper::GetNoProfileFunctionality($suspendLevel);
	$noSiteFunctionality = MainHelper::GetNoSiteFunctionality($suspendLevel);

	$player = $message->Players;

	$forumBanned = MainHelper:: ifBannedForum($type, $id);
	$boardBanned = MainHelper:: ifBannedBoard($type, $id, $board);
?>

<div class="itemPost" id="reply-<?php echo $message->ID_MSG ?>">
	<div class="forumL3Post">
		<div class="forumL3Username">
			<a href="<?php echo MainHelper::site_url('player/'.$player->URL) ?>">
				<?php echo PlayerHelper::showName($player); ?>
			</a>
			<?php echo ' #' . $messageNum; ?>
		</div>
		<div class="leftSection">
			<div class="forumL3Usertitle">
				<?php
					if ($model->isAdmin($player->ID_PLAYER)) {
						echo 'Admin';
					} elseif ($model->isBoardAdmin($player->ID_PLAYER)) {
						echo 'Forum Admin';
					} elseif ($model->isForumMod($player->ID_PLAYER)) {
						echo 'Forum Moderator';
					} elseif ($model-> isBoardMod($type, $id, $board, $player->ID_PLAYER)) {
						echo 'Board Moderator';
					} elseif ($model->isMember($player->ID_PLAYER)) {
						echo 'Member';
					}
				?>
			</div>
			<div class="forumL3Userimg">
				<a href="<?php echo MainHelper::site_url('player/'.$player->URL); ?>">
					<?php echo MainHelper::showImage($player, THUMB_LIST_100x100, false, array('no_img' => 'noimage/no_player_100x100.png')); ?>
				</a>
			</div>
			<div class="forumL3Userposts ">
				<?php echo $player->PostCount.' posts'; ?>
			</div>
			<div class="forumL3Userlocation">
				<?php echo "Location: ".PlayerHelper::getLocation($player); ?>
			</div>
		</div>
		<div class="rightSection">
			<div class="forumL3Details">
				<div class="timestampPost">
					<?php echo "Posted on " . date("d/m - Y g:i A", $message->PostingTime); ?>
				</div>
				<div class="quoteReply">
					<?php
						if($isMember === true && !$topic->isLocked && !$noSiteFunctionality && !$boardBanned && !$forumBanned) {
							if($topic->ID_POLL > 0 AND $message->ID_MSG === $topic->ID_FIRST_MSG) {

							} else { ?>
								<div class="quotePost">
									<a class="quoteButton" href="#" rel="<?php echo $this->__('[_1] wrote:', array(PlayerHelper::showName($message->Players))); ?>">
										<input type="hidden" id="messageClass" value="<?php echo $class; ?>" />
										<?php echo $this->__('Quote'); ?>
									</a>
								</div>
							<?php 
							}
							?>
							<div class="replyPost">
								<a href="#"><?php echo $this->__('Reply'); ?></a>
							</div>
						<?php
						}
					?>
					
				</div>
			</div>
			<div class="forumL3PostText">
				<p>
					<?php 
						echo $message->Body;
						if($topic->ID_POLL > 0) {
							if(isset($poll_id) && $poll_id !="") {
								if($isMember) {
									if($messageNum === 1){
										if($servertime < $expiretime) {
											if(isset($playerVoted) && $playerVoted != true){ ?>
												<div class="mt10">
													<form method= "POST"  id="Poll_votes"  > 
														<input type="hidden" id="otype" name="otype" value ="<?php echo $type; ?>" >
														<input type="hidden" id="oid" name="oid" value ="<?php echo $id; ?>" >
														<input type="hidden" id="url" name="oid" value ="<?php echo $url; ?>" >
														<input type="hidden" id="board_id" name="board_id" value ="<?php echo $board; ?>" >
														<input type="hidden" id="topic_id" name="topic_id" value ="<?php echo $topicID; ?>" >
														<input type="hidden" id="poll_id" name="poll_id" value ="<?php echo $topic->ID_POLL; ?>" >
														<?php 
															foreach ($Poll_choices as $poll) {
															?>
																<input type="radio" name="pollchoice" value="<?php echo $poll->ID_CHOICE; ?>"> <?php echo $poll->Label?><br>
															<?php	
															}
															?>
														
														<a href="javascript:void(0)"  class ="vote roundedButton grey fr mt10">
															<span class="lrc"></span>
															<span class="mrc"><?php echo $this->__('Vote'); ?></span>
															<span class="rrc"></span>
														</a>
													</form>
												</div> 
											<?php
											}else{
											?>
											<div class="mt10">
													<strong> <?php echo $this->__('Thank you for your vote!'); ?> </strong></br></br>
												
													<table class="w470">
														<thead>
															<tr>
																<td></td>
																<td><?php echo $this->__('Answer choices:'); ?> </td>
																<td><?php echo $this->__('Number of votes:'); ?> </td>
															</tr>
														</thead>
														<tbody>
															<?php
															foreach ($Poll_choices as $poll) {
																echo "<tr>";
																if($getplayervote === $poll->ID_CHOICE){
																	echo '<td><input type="radio" name="pollchoice" value="'.$poll->ID_CHOICE.'" checked ></td>
																	<td> '.$poll->Label.'</td> 
																	<td> '.$poll->Votes.'</td>';
																}else{
																	echo '<td></td> <td>'.$poll->Label.'</td> <td>'.$poll->Votes.'</td>';
																}
																echo "</tr>";
															}
															?>
														</tbody>
													</table>	
													
													<a href="<?php  echo MainHelper::site_url('forum/'.$type.'/'.$url.'/'.$board.'/'.$topicID.'/'. $topic->ID_POLL.'/changevote'); ?>" class="changevotes roundedButton grey fr  mt10">
														<span class="lrc"></span>
														<span class="mrc"><?php echo $this->__('Change vote'); ?></span>
														<span class="rrc"></span>
													</a>
												
											 </div>
											<?php
											}
										}else{
										?>
											<div class="mt10">
												<strong> <?php echo $this->__('This poll has expired'); ?> </strong></br></br>
																	
													<table class="w470">
														<thead>
															<tr>
																<td></td>
																<td><?php echo $this->__('Answer choices:'); ?> </td>
																<td><?php echo $this->__('Number of votes:'); ?> </td>
															</tr>
														</thead>
														<tbody>
															<?php
															foreach ($Poll_choices as $poll) {
																echo "<tr>";
																echo '<td></td> <td>'.$poll->Label.'</td> <td>'.$poll->Votes.'</td>';
																echo "</tr>";
															}
															?>
														</tbody>
													</table>	
											</div>
										<?php			
										}
									}
								}
							}
						}
					?>
				</p>
			</div>

				<?php $sig = PlayerHelper:: getForumSignature($type, $id, $player->ID_PLAYER);
				//var_dump($sig);

				if(!empty($sig)){ ?>
					<div style="border-top: 1px solid #000; width: 106%;margin-left: -10px;"></div>
						<div class="forumL3Signatur">
							<p><?php echo $sig; ?></p>
						</div>
				<?php
				}
				?>
				
		</div>
	</div>

		
	<?php
	
	if(Auth::isUserLogged() && $isMember === true && !$noSiteFunctionality && !$boardBanned && !$forumBanned){ ?>
		<a href="javascript:void(0)" class="itemMoreActions iconr_moreActions t0 zi2 pa mt5 dn" rel="<?php //echo $board->ID_OWNER; ?>"></a>
		<div class="itemMoreActionsBlock pa dn">
			<?php
			if(isset($isForumAdmin) and $isForumAdmin === true OR $isForumMod === true or $isBoardMod === true ){
				if($topic->ID_POLL > 0 ){
					if($message->ID_MSG === $topic->ID_FIRST_MSG){ ?>

						<a class="" rel="" href="<?php echo MainHelper::site_url('forum/'.$type.'/'.$url.'/'.$board.'/'.$topicID.'/'.$topic->ID_POLL.'/editpoll'); ?>" >
							<?php echo $this->__('Edit'); ?>
						</a>
						<?php
						if($messageNum == 1 and $total == 1  AND $totalVotes == 0 ){ ?>
							<a class=" db <?php echo $messageNum== 1 ? 'firstMsg' : ''; ?>" rel="iframe" href="<?php echo MainHelper::site_url('forum/'.$type.'/'.$url.'/'.$board.'/'.$topicID.'/'.$topic->ID_POLL.'/deletepoll'); ?>" >
								<?php echo $this->__('Delete'); // poll?>
							</a> 
							<?php
						}
						
					} else { ?>
						<a class="db" rel="iframe" href="<?php echo MainHelper::site_url('forum/'.$type.'/'.$url.'/'.$board.'/'.$topicID.'/'.$message->ID_MSG.'/edit'); ?>" >
							<?php echo $this->__('Edit'); // edit reply in polls?>
						</a>

						<a class="db" rel="iframe" href="<?php echo MainHelper::site_url('forum/'.$type.'/'.$url.'/'.$board.'/'.$topicID.'/'.$message->ID_MSG.'/deletereply'); ?>" >
							<?php echo $this->__('Delete'); // delete reply?>
						</a>
					<?php
					}

					if($model->isBoardMod($type,$id, $board, $player->ID_PLAYER) === false){ ?>
						<form method= "POST"  id="makemod"  > 
							
							<input type="hidden" id="mod_otype" name="mod_otype" value ="<?php echo $type; ?>" >
							<input type="hidden" id="mod_oid" name="mod_oid" value ="<?php echo $id; ?>" >
							<input type="hidden" id="mod_url" name="mod_oid" value ="<?php echo $url; ?>" >		
							<input type="hidden" id="mod_board_id" name="mod_board_id" value ="<?php echo $board; ?>" >
							<input type="hidden" id="mod_topic_id" name="mod_topic_id" value ="<?php echo $topicID; ?>" >
							<input type="hidden" id="mod_poll_id" name="mod_poll_id" value ="<?php echo $topic->ID_POLL; ?>" >
							<input type="hidden" id="mod_id_player" name="mod_id_player" value ="<?php echo $player->ID_PLAYER; ?>" >
								<a class="makeBoardMod" rel="" href="javascript:void(0)" >
									<?php echo $this->__('Make board mod'); ?>
								</a>
						</form>
					<?php
					}
					
					if(MainHelper::ifBannedForum($type, $id, $player->ID_PLAYER)  == FALSE  AND MainHelper::ifBannedBoard($type, $id, $player->ID_PLAYER) == FALSE){
					?>
					<a class="db" rel="iframe" href="<?php echo MainHelper::site_url('forum/'.$type.'/'.$url.'/'.$board.'/'.$topicID.'/'.$message->ID_MSG.'/banuser'); ?>">				
						<?php echo $this->__('Ban user'); ?>
					</a>
					<?php
					}
					
				} else {
				// thread?>
					<a class="db" rel="iframe" href="<?php echo MainHelper::site_url('forum/'.$type.'/'.$url.'/'.$board.'/'.$topicID.'/'.$message->ID_MSG.'/edit'); ?>" >
						<?php echo $this->__('Edit'); ?>
					</a>
					<?php
					if($messageNum == 1 and $total == 1 ){ ?>

						<a class="db <?php echo $messageNum== 1 ? 'firstMsg' : ''; ?>" rel="iframe" href="<?php echo MainHelper::site_url('forum/'.$type.'/'.$url.'/'.$board.'/'.$topicID.'/'.$message->ID_MSG.'/deletethread'); ?>" >
							<?php echo $this->__('Delete'); ?>
						</a> 
					<?php  
					}elseif($total > 1 and $messageNum > 1){ ?>
						<a class="db" rel="iframe" href="<?php echo MainHelper::site_url('forum/'.$type.'/'.$url.'/'.$board.'/'.$topicID.'/'.$message->ID_MSG.'/deletereply'); ?>" >
							<?php echo $this->__('Delete'); ?>
						</a>
					<?php
					}
				
					if($model->isBoardMod($type,$id, $board, $player->ID_PLAYER) === false){ ?>
						<form method= "POST"  id="makemod"  > 
							<input type="hidden" id="mod_otype" name="mod_otype" value ="<?php echo $type; ?>" >
							<input type="hidden" id="mod_oid" name="mod_oid" value ="<?php echo $id; ?>" >
							<input type="hidden" id="mod_url" name="mod_oid" value ="<?php echo $url; ?>" >		
							<input type="hidden" id="mod_board_id" name="mod_board_id" value ="<?php echo $board; ?>" >
							<input type="hidden" id="mod_topic_id" name="mod_topic_id" value ="<?php echo $topicID; ?>" >
							<input type="hidden" id="mod_poll_id" name="mod_poll_id" value ="<?php echo $topic->ID_POLL; ?>" >
							<input type="hidden" id="mod_id_player" name="mod_id_player" value ="<?php echo $player->ID_PLAYER; ?>" >
							<a class="makeBoardMod" rel="" href="javascript:void(0)" >
								<?php echo $this->__('Make board mod'); ?>
							</a>
						</form>
					<?php
					}
					if(MainHelper::ifBannedForum($type, $id, $player->ID_PLAYER)  == FALSE  AND MainHelper::ifBannedBoard($type, $id, $player->ID_PLAYER) == FALSE){
				?>
					<a class="db" rel="iframe" href="<?php echo MainHelper::site_url('forum/'.$type.'/'.$url.'/'.$board.'/'.$topicID.'/'.$message->ID_MSG.'/banuser'); ?>">				
						<?php echo $this->__('Ban user'); ?>
					</a>
								
				<?php
					}
				}
					// if you not are admins
			}elseif($user and ($user->ID_PLAYER == $player->ID_PLAYER)){ 
				if($topic->ID_POLL > 0){

					if($message->ID_MSG === $topic->ID_FIRST_MSG){ ?>
						<a class="" rel="" href="<?php echo MainHelper::site_url('forum/'.$type.'/'.$url.'/'.$board.'/'.$topicID.'/'.$topic->ID_POLL.'/editpoll'); ?>" >
							<?php echo $this->__('Edit poll'); ?>
						</a>
						<?php
						if($messageNum == 1 and $total == 1  AND $totalVotes == 0 ){ ?>
						<a class="db <?php echo $messageNum== 0 ? 'firstMsg' : ''; ?>" rel="iframe" href="<?php echo MainHelper::site_url('forum/'.$type.'/'.$url.'/'.$board.'/'.$topicID.'/'.$topic->ID_POLL.'/deletepoll'); ?>" >
							 <?php echo $this->__('Delete poll'); ?>
						</a> 
						<?php
						}							 
					}else{ ?>
						<a class="db" rel="iframe" href="<?php echo MainHelper::site_url('forum/'.$type.'/'.$url.'/'.$board.'/'.$topicID.'/'.$message->ID_MSG.'/edit'); ?>" >
							<?php echo $this->__('Edit'); ?>
						</a>

						<a class="db" rel="iframe" href="<?php echo MainHelper::site_url('forum/'.$type.'/'.$url.'/'.$board.'/'.$topicID.'/'.$message->ID_MSG.'/deletereply'); ?>" >
							<?php echo $this->__('Delete'); ?>
						</a>
					<?php
					}   
				}else{ 
					// thread ?>
					<a class="db" rel="iframe" href="<?php echo MainHelper::site_url('forum/'.$type.'/'.$url.'/'.$board.'/'.$topicID.'/'.$message->ID_MSG.'/edit'); ?>" >
						<?php echo $this->__('Edit'); ?>
					</a>

					<?php
					if($messageNum === 1 and $total == 1 ){ ?>
						<a class="db <?php echo $messageNum== 0 ? 'firstMsg' : ''; ?>" rel="iframe" href="<?php echo MainHelper::site_url('forum/'.$type.'/'.$url.'/'.$board.'/'.$topicID.'/'.$message->ID_MSG.'/deletethread'); ?>" >
								<?php echo $this->__('Delete'); ?>
						</a> 
					<?php  
					}elseif($total > 1 and $messageNum > 1){ ?>
						<a class="db" rel="iframe" href="<?php echo MainHelper::site_url('forum/'.$type.'/'.$url.'/'.$board.'/'.$topicID.'/'.$message->ID_MSG.'/deletereply'); ?>" >
							 <?php echo $this->__('Delete'); ?>
						</a>
					<?php
					}
				}
			}    

			 ?>        
		</div>
	<?php         
	}
	?>
</div>
