<div class="message_container">
    <!-- header -->
    <div class="clearfix">
        <span class="fs22 fft fclg2 fl mr10"><?php echo $this->__('Add Affiliated Group'); ?></span>
    </div>
    <!-- end header -->
    <form action="#" method="post" id="alliances_group_form">
        <input type="hidden" name="group_id" value="<?php echo $group->ID_GROUP; ?>" />
        
		<div class="mt5">
			<label for="tags" class="cp"><?php echo $this->__('Search groups');?></label>
			<div class="border mt2 rounded5 h16 pt5 pb5" id="group_tags">
				<input name="group_affiliate" class="w576 news_border dn" id="tags" value="" />
			</div>
		</div>
		
		<div class="mt5">
			<label for="groupAffiliateDescription" class="cp"><?php echo $this->__('Short Description');?></label>
			<div class="border mt2">
				<textarea name="group_affiliate_description" rows="3"  class="news_border w576" id="groupAffiliateDescription"></textarea>
			</div>
		</div>
		
        <div class="clear mt10">&nbsp;</div>
        <a href="javascript:void(0)" class="link_green fr add_group_alliances"><span><span><?php echo $this->__('Add'); ?></span></span></a>
    </form>
</div>
<script type="text/javascript">loadGroup();</script>