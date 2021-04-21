<?php if(!empty($conversations)):?>
<?php
	$viewer = User::getUser();
	$suspendLevel = ($viewer) ? $viewer->getSuspendLevel() : 0;
	$nocommenting = ($suspendLevel==1 || $suspendLevel==2);
?>
    <?php foreach ($conversations as $conversation):?>
	<div class="post_message post_message_<?php echo $conversation->ID_CONVERSATION;?> clearfix <?php echo ($type == MESSAGES_INBOX) ? 'newMessage' : ''; ?>">
		<div class="clearfix">
<?php /* To be re-enabled once a solution for the deletion of conversations have been found
			<div class="grid_1 alpha omega mt20">
				<div class="ml8">
					<input id="c1" value="<?php echo $conversation->ID_CONVERSATION;?>" class="cp" type="checkbox"/>
				</div>
			</div>
*/ ?>
			<div class="clearfix fl w530 pb10">
			<?php if (count($conversation->players) > 1): ?>
				<?php foreach ($conversation->players as $p): ?>
					<div class="fl w450">
						<span class="mt0"><a href="<?php echo MainHelper::site_url('player/'.$p->URL);?>"><?php echo PlayerHelper::showName($p);?></a></span>
					</div>
				<?php endforeach; ?>
			<?php else: ?>
				<div class="fl w70"><a class="img" title="<?php echo PlayerHelper::showName($conversation->players[0]);?>" href="<?php echo MainHelper::site_url('player/'.$conversation->players[0]->URL);?>"><?php echo MainHelper::showImage($conversation->players[0], THUMB_LIST_60x60, false, array('no_img' => 'noimage/no_player_60x60.png'));?></a></div>
				<div class="fl w450">
					<span class="mt0"><a href="<?php echo MainHelper::site_url('player/'.$conversation->players[0]->URL);?>"><?php echo PlayerHelper::showName($conversation->players[0]);?></a></span>
				</div>
			<?php endif; ?>
			</div>
		</div>
		<?php if (!$nocommenting): ?>
			<?php if($type == MESSAGES_INBOX and $conversation->NewMessageCount): ?>
				<div class="newMessageInfo pa b0">
					<span class="lrc fl"></span>
					<span class="mrc fl pr2 pl2 fs11">
						<span class="db fl"><?php echo $this->__('New!')." (".$conversation->NewMessageCount.")"; ?></span>
					</span>
					<span class="rrc fl"></span>
				</div>
			<?php endif; ?>

			<div class="pa b0 messageOptions">
				<a href="<?php echo MainHelper::site_url('players/conversations/read/'.$conversation->ID_CONVERSATION); ?>" class="messageOpt mr2 fl db">
					<span class="lrc fl"></span>
					<span class="mrc fl pr2 pl2 fs11">
						<span class="db fl"><?php echo $this->__('Read'); ?></span>
					</span>
					<span class="rrc fl"></span>
				</a>
				<a class="messageOpt mr2 fl db reply_message" rel="<?php echo $conversation->ID_CONVERSATION;?>" title="<?php echo $this->__('Reply');?>" href="<?php echo MainHelper::site_url('players/ajaxsendconvmessage/'.$conversation->ID_CONVERSATION);?>">
					<span class="lrc fl"></span>
					<span class="mrc fl pr2 pl2 fs11">
						<span class="db fl"><?php echo $this->__('Reply'); ?></span>
					</span>
					<span class="rrc fl"></span>
				</a>
	<?php /*
				<a class="messageOpt mr2 fl db forward_message" href="<?php echo MainHelper::site_url('players/ajaxsendconvmessage/'.$conversation->ID_CONVERSATION);?>">
					<span class="lrc fl"></span>
					<span class="mrc fl pr2 pl2 fs11">
						<span class="db fl"><?php echo $this->__('Forward'); ?></span>
					</span>
					<span class="rrc fl"></span>
				</a>
	*/ ?>
	<?php /* To be re-enabled once a solution for the deletion of conversations have been found
				<a href="javascript:void(0)" class="messageOpt mr2 fl db delete_inbox_message" rel="<?php echo $conversation->ID_CONVERSATION;?>">
					<span class="lrc fl"></span>
					<span class="mrc fl pr2 pl2 fs11">
						<span class="db fl"><?php echo $this->__('Delete'); ?></span>
					</span>
					<span class="rrc fl"></span>
				</a>
	*/ ?>
			</div>
		<?php endif; ?>
	</div>
    <?php endforeach; ?>
<?php endif; ?>
<script type="text/javascript">loadCheckboxes();</script>