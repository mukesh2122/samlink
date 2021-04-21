<?php /*
<?php if($limit == 0):?>
<!-- header -->
<div class="mt10 clearfix">
    <span class="fs22 fft fclg2 fl mr10"><?php echo $this->__('Messages');?></span>
    <div class="blue_block fl mr10"><div><div><?php echo $total;?></div></div></div>
    <?php if($player->NewMessageCount > 0):?>
    <span class="fl fs22 fft fcbl"><?php echo $player->NewMessageCount;?> <?php echo $this->__('New');?>!</span>
    <?php endif; ?>
</div>
<!-- end header -->
<div class="clearfix dot_bot mt8 pr">
    <div class="grid_5 alpha mt6 mb10">
        <a class="fs10 mr20" id="select_all" href="javascript:void(0)"><?php echo $this->__('Select All');?></a>
        <a class="fs10 mr20 dn" id="deselect_all" href="javascript:void(0)"><?php echo $this->__('Deselect All');?></a>
        <a class="fs10 mr20 delete_selected_messages" href="javascript:void(0)"><?php echo $this->__('Delete Selected');?></a>
        <a class="fs10 mr20 delete_all_messages" href="javascript:void(0)"><?php echo $this->__('Delete All');?></a>
        <a class="fs10 mr20 create_new_message" href="javascript:void(0)"><?php echo $this->__('New Message');?></a>
    </div>
    <div class="fr inbox_sent">
        <div class="grey_dark fl mr2">
            <div><div><a href="<?php echo MainHelper::site_url('players/messages');?>"><?php echo $this->__('Inbox');?> (<?php echo $player->MessageCount;?>)</a></div></div>
        </div>
        <div class="light_dark fl">
            <div><div><a href="<?php echo MainHelper::site_url('players/messages/sent');?>"><?php echo $this->__('Sent');?> (<?php echo $player->MessageSentCount;?>)</a></div></div>
        </div>
    </div>
</div>
<?php endif;?>
 * 
 */ ?>

<?php if(!empty($messages)):?>
    <?php foreach ($messages as $item):?>
	<?php
		$messArr = (object) unserialize($item->Body);
		$content = $messArr->content;
		$description = ContentHelper::handleContentOutput($messArr->description);

		$nick = PlayerHelper::showName($item);
		$img = MainHelper::showImage($item, THUMB_LIST_60x60, false, array('no_img' => 'noimage/no_player_60x60.png'));
	?> 
	<div class="post_message post_message_<?php echo $item->URL;?> clearfix <?php echo ($type == MESSAGES_INBOX and $item->isRead == 0) ? 'newMessage' : ''; ?>">
		<div class="clearfix">
			<div class="grid_1 alpha omega mt20">
				<div class="ml8">
					<input id="c1" value="<?php echo $item->URL;?>" class="cp" type="checkbox"/>
				</div>
			</div>
			<div class="clearfix fl w530 pb10">
				<div class="fl w70"><a class="img" title="<?php echo $nick;?>" href="<?php echo MainHelper::site_url('player/'.$item->URL);?>"><?php echo $img?></a></div>
				<div class="fl w450">
					<span class="mt0"><a href="<?php echo MainHelper::site_url('player/'.$item->URL);?>"><?php echo $nick;?></a></span>
					<?php echo ($messArr->type != WALL_VIDEO) ? $content : $description;?>
				</div>
				<?php echo $this->renderBlock('common/videoItem', array(
					'messArr' => $messArr,
					'item' => $item,
				));?>
			</div>
		</div>

		<?php if($type == MESSAGES_INBOX and $item->isRead == 0): ?>
			<div class="newMessageInfo pa b0">
				<span class="lrc fl"></span>
				<span class="mrc fl pr2 pl2 fs11">
					<span class="db fl"><?php echo $this->__('New!'); ?></span>
				</span>
				<span class="rrc fl"></span>
			</div>

		<?php endif; ?>

		<div class="pa b0 messageOptions">
			<a href="<?php echo MainHelper::site_url('players/messages/read/'.$item->URL); ?>" class="messageOpt mr2 fl db">
				<span class="lrc fl"></span>
				<span class="mrc fl pr2 pl2 fs11">
					<span class="db fl"><?php echo $this->__('Read'); ?></span>
				</span>
				<span class="rrc fl"></span>
			</a>
			<a class="messageOpt mr2 fl db reply_message" rel="<?php echo $item->URL;?>" title="<?php echo $nick;?>" href="<?php echo MainHelper::site_url('players/ajaxgetsendmessage/'.$item->URL);?>">
				<span class="lrc fl"></span>
				<span class="mrc fl pr2 pl2 fs11">
					<span class="db fl"><?php echo $this->__('Reply'); ?></span>
				</span>
				<span class="rrc fl"></span>
			</a>
			<a class="messageOpt mr2 fl db forward_message" href="<?php echo MainHelper::site_url('players/ajaxgetsendmessage/'.$item->URL.'/'.$item->ID_PM);?>">
				<span class="lrc fl"></span>
				<span class="mrc fl pr2 pl2 fs11">
					<span class="db fl"><?php echo $this->__('Forward'); ?></span>
				</span>
				<span class="rrc fl"></span>
			</a>
			<a href="javascript:void(0)" class="messageOpt mr2 fl db delete_inbox_message" rel="<?php echo $item->URL;?>">
				<span class="lrc fl"></span>
				<span class="mrc fl pr2 pl2 fs11">
					<span class="db fl"><?php echo $this->__('Delete'); ?></span>
				</span>
				<span class="rrc fl"></span>
			</a>
		</div>
	</div>
    <?php endforeach; ?>
<?php endif; ?>
<script type="text/javascript">loadCheckboxes();</script>