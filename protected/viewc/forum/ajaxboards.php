<?php $reguserFunctions = MainHelper::GetModuleFunctionsByTag('reguser'); ?>
<?php
	$userPlayer = User::getUser();
	$isApproved = ($userPlayer) ? MainHelper::IsPlayerApproved($userPlayer->ID_PLAYER) : 1;

	$suspendLevel = ($userPlayer) ? $userPlayer->getSuspendLevel() : 0;
	$noProfileFunctionality = MainHelper::GetNoProfileFunctionality($suspendLevel);
	$noSiteFunctionality = MainHelper::GetNoSiteFunctionality($suspendLevel);
?>

<?php
if(isset($boards) and count($boards) != 0){
	foreach($boards as $b){
		?>
		<tr class="forumBoard board_<?php echo $type; ?>_<?php echo $ownerId; ?>_<?php echo $b->ID_BOARD; ?>">
			<td colspan="2" class="boardTitle">
				<div class="boardImg clearfix mb10 fl">
					<a href="<?php echo $model->FORUM_URL.'/'.$b->ID_BOARD; ?>">
						<img src="<?php echo Doo::conf()->APP_URL; ?>global/img/no_avatar.gif" /></a>
				</div>
				<div class="boardTitleC clearfix fl pr">
					<span class="fs15 mt5 fl">
						<a href="<?php echo $model->FORUM_URL.'/'.$b->ID_BOARD; ?>">
							<?php echo $b->BoardName; ?>
						</a>
					</span>
					<?php if(count($b->childBoards) > 0): ?>
					<div class="pa b0 l0 pl5">
						<?php echo $this->__('Child boards'); ?>:
						<?php 
						$i = 0;
						foreach($b->childBoards as $chb):
							echo $i == 0 ? '' : ', '; ?>
							<a href="<?php echo $model->FORUM_URL.'/'.$chb->ID_BOARD; ?>"><?php echo $chb->BoardName; ?></a><?php 
							$i++;
						endforeach; ?>
					</div>
					<?php endif; ?>
					<?php if($isAdmin){ ?>
						<span class="adminActions pa b0 r0">
							<a class="editBoard" rel="<?php echo $b->ID_BOARD; ?>" href="<?php echo MainHelper::site_url('forum-edit/board/'.$type.'/'.$ownerId.'/'.$b->ID_BOARD); ?>">
								<?php echo $this->__('Edit'); ?>
							</a> |
							<a class="deleteBoard" rel="<?php echo $b->ID_BOARD; ?>" href="<?php echo MainHelper::site_url('forum-delete/board/'.$type.'/'.$ownerId.'/'.$b->ID_BOARD); ?>">
								<?php echo $this->__('Delete'); ?>
							</a>
						</span>
					<?php } ?>
					<?php if(Auth::isUserLogged() && !$noProfileFunctionality):?>
						<?php if($reguserFunctions['reguserSubscriptions']==1 && $isApproved==1):?>
							<div class="subscribeBox pa t0 r0">
								<?php if($model->isSubscribedBoard($b->ID_BOARD)):?>
									<a class="link_icon mr10 dn icon_subscribe board_subscribe subscribe_board_<?php echo $b->ID_BOARD;?>" rel="<?php echo $b->ID_BOARD;?>" href="javascript:void(0)"><?php echo $this->__('Subscribe');?></a>
									<a class="link_icon mr10 icon_unsubscribe board_subscribe unsubscribe_board_<?php echo $b->ID_BOARD;?>" rel="<?php echo $b->ID_BOARD;?>" href="javascript:void(0)"><?php echo $this->__('Unsubscribe');?></a>
								<?php else: ?>
									<a class="link_icon mr10 icon_subscribe board_subscribe subscribe_board_<?php echo $b->ID_BOARD;?>" rel="<?php echo $b->ID_BOARD;?>" href="javascript:void(0)"><?php echo $this->__('Subscribe');?></a>
									<a class="link_icon mr10 dn icon_unsubscribe board_subscribe unsubscribe_board_<?php echo $b->ID_BOARD;?>" rel="<?php echo $b->ID_BOARD;?>" href="javascript:void(0)"><?php echo $this->__('Unsubscribe');?></a>
								<?php endif; ?>
							</div>
						<?php endif;?>
					<?php endif; ?>
				</div>
				<div class="clearfix"></div>
			</td>

			<td class="boardInfo">
				<div class="fl forum_info fclg fs11">
					<?php echo $b->TopicCount; ?> <?php echo $this->__('Topics'); ?><br />
					<?php echo $b->PostCount; ?> <?php echo $this->__('Posts'); ?>
				</div>
			</td>

			<?php if(!empty($b->PostingTime) && !empty($b->Subject) && !empty($b->PosterName)){ ?>

			<td class="boardInfo">
				<div class="fl forum_info fclg fs11">
					<?php echo date("d/m - Y g:i A", $b->PostingTime); ?><br/>
					<a href="<?php echo $model->FORUM_URL.'/'.$b->ID_BOARD.'/'.$b->ID_TOPIC; ?>">
							<?php echo strlen($b->Subject) > 19 ? substr($b->Subject, 0, 17).'...' : $b->Subject; ?>
						</a><br/>

					<?php echo $this->__('By'); ?>: 
					<?php echo strlen($b->PosterName) > 19 ? substr($b->PosterName, 0, 17).'...' : $b->PosterName; ?>

				</div>
			</td>

			<?php } else{ ?>
				<td class="boardInfo" colspan="2">
					<div class="fl forum_info fclg fs11">
						-<br />
						<?php echo $this->__('In'); ?>: -<br />
						<?php echo $this->__('By'); ?>: -
					</div>
				</td>
			<?php } ?>
		</tr>
		<?php
	}
}
?>
