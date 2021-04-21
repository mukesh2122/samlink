<?php $player = User::getUser(); ?>

<div class="BBblack3">
	<div class="postContainer  mt10 pl10 mb10">
		<div class="replyBar"><?php echo $this->__('Reply'); ?></div>
		<div class="userHalf fl">
			<div class="w100px pr5 fl pr game_img">
				<a href="<?php echo MainHelper::site_url('player/'.$player->URL); ?>"><?php echo MainHelper::showImage($player, THUMB_LIST_100x100, false, array('no_img' => 'noimage/no_player_100x100.png')); ?></a>
			</div>
			<div class="mt5 fs11 fclg">
				<a href="<?php echo MainHelper::site_url('player/'.$player->URL) ?>"><?php echo PlayerHelper::showName($player); ?></a>
			</div>
		</div>
		<div class="fl postBody">
			<div id="createForm" class="replyForm">
				<form method="POST">
					<div>
						<div class="textMid">
							<textarea id="newPostText" class="elasticTextA inputTextArea" title="<?php echo $this->__('Text for the post'); ?>" name="messageText"></textarea>
						</div>
						<div class="sprite_3 textBotCorn"></div>
					</div>
					<input type="hidden" name="subject" value="<?php echo $this->__('Re').': '.$subject; ?>" />
					<a href="javascript:void(0)" class="roundedButton grey fr formSubmitUniversal">
						<span class="lrc"></span>
						<span class="mrc"><?php echo $this->__('submit'); ?></span>
						<span class="rrc"></span>
					</a>
					<input type="submit" class="dn hiddenSubmitButton" />
				</form>
			</div>
		</div>
		<div class="clearfix"></div>
	</div>
</div>