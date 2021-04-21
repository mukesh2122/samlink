<div class="message_container">
    <!-- header -->
    <div class="clearfix">
        <span class="fs22 fft fclg2 fl mr10"><?php echo $this->__('Invite Members'); ?></span>
    </div>
    <!-- end header -->
    <form action="#" method="post" id="invite_group_member_form">
        <input type="hidden" name="group_id" value="<?php echo $group->ID_GROUP; ?>" />

		<div class="mt5">
			<label for="player_tags" class="cp"><?php echo $this->__('Search Player');?></label>
			<div class="border mt2 rounded5 h16 pt5 pb5" id="game_tags_cont">
				<input name="player_id" class="w576 news_border dn" id="player_tags" value="" />
			</div>
		</div>
		
        <div class="clear mt10">&nbsp;</div>
        <a href="javascript:void(0)" class="link_green fr invite_group_member"><span><span><?php echo $this->__('Invite'); ?></span></span></a>
    </form>
</div>
<script type="text/javascript">loadGroup();</script>