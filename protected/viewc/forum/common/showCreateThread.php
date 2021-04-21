<?php $reguserFunctions = MainHelper::GetModuleFunctionsByTag('reguser'); ?>
<?php
	$userPlayer = User::getUser();
	$isApproved = ($userPlayer) ? MainHelper::IsPlayerApproved($userPlayer->ID_PLAYER) : 1;

	$suspendLevel = ($userPlayer) ? $userPlayer->getSuspendLevel() : 0;
	$noProfileFunctionality = MainHelper::GetNoProfileFunctionality($suspendLevel);
	$noSiteFunctionality = MainHelper::GetNoSiteFunctionality($suspendLevel);
?>

<?php include('top.php');?>

<?php if(isset($infoBox)):?>
    <?php echo $infoBox;?>
<?php endif; ?>

<?php if(isset($crumb)): ?>
		<div class="clearfix">
			<?php echo $this->renderBlock('common/breadcrumb', array('crumb' => $crumb)); ?>
		</div>
	<?php endif; ?>

<div class="clearfix mt10 ">
	<div class="clearfix pb10 polldescription">
		<?php $player = User::getUser(); ?>
		<div class="postContainer mt10 pb10 pt10">
			<div class="userHalf fl">
				<div class="w100px pr5 fl pr game_img">
					<a href="<?php echo MainHelper::site_url('player/'.$player->URL); ?>"><?php echo MainHelper::showImage($player, THUMB_LIST_100x100, false, array('no_img' => 'noimage/no_player_100x100.png')); ?></a>

					<div class="company_user_rating game100 pa clearfix b0 l0">
						<?php echo str_repeat("<span class='star_blue'></span>", round($player->SocialRating, 0));?><?php echo str_repeat("<span class='star_grey'></span>", (5 - round($player->SocialRating, 0)));?><span class="fr fft db fs11 fcblue"><?php echo number_format($player->SocialRating, 1);?></span>
					</div>
				</div>
				<div class="mt5 fs11 fclg">
					<a href="<?php echo MainHelper::site_url('player/'.$player->URL) ?>"><?php echo PlayerHelper::showName($player); ?></a>
				</div>
			</div>
			
			<div class="fl postBody">

				<div id="createForm" class="replyForm pt5">
					<form method="POST" id="createForumTopic" class="forumForm" action="<?php echo MainHelper::site_url('forum-create/topic/'.$board->OwnerType.'/'.$url.'/'.$board->ID_BOARD); ?>">
						<h2 class="fcb"><?php echo $this->__('Create new thread'); ?></h2>
						<div class="mt5">
							<label for="topicSubject" class="cp"><?php echo $this->__('Subject');?></label>
							<div class="roundedInputField clearfix">
								<div class="rifL sprite_3 fl"></div>
								<div class="rifM fl">
									<input type="text" id="topicSubject" class="input_text w300" name="topicName" title="<?php echo $this->__('Subject...'); ?>" value="" />
								</div>
								<div class="rifR sprite_3 fl"></div>
							</div>
						</div>
						
						<p class="clearfix">
							<div>
								<div class="textMid">
									<textarea id="newPostText" class="elasticTextA inputTextArea" title="<?php echo $this->__('Text for the post'); ?>" name="messageText"></textarea>
								</div>
								<div class="sprite_3 textBotCorn"></div>
							</div>
						</p>
						<a href="javascript:void(0)" class="roundedButton grey fr formSubmitUniversal">
							<span class="lrc"></span>
							<span class="mrc"><?php echo $this->__('Create thread'); ?></span>
							<span class="rrc"></span>
						</a>

						<input type="submit" name="createthread" class="dn hiddenSubmitButton" />
					</form>
				</div>
			</div>
			<div class="clearfix"></div>
		</div>
	</div>
</div>
<div class="clearfix"></div>