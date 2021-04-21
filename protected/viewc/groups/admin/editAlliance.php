<div class="message_container">
    <!-- header -->
    <div class="clearfix">
        <span class="fs22 fft fclg2 fl mr10"><?php echo $this->__('Edit Affiliated Group'); ?></span>
    </div>
    <!-- end header -->
    <form action="#" method="post" id="alliances_group_form">
        <input type="hidden" name="group_id" value="<?php echo $group->ID_GROUP; ?>" />
        <input type="hidden" name="group_affiliate" value="<?php echo $alliance->ID_ALLIANCE; ?>" />
        
		<div class="mt5">
			<label for="groupAffiliateDescription" class="cp"><?php echo $this->__('Short Description');?></label>
			<div class="border mt2">
				<textarea name="group_affiliate_description" rows="3"  class="news_border w576" id="groupAffiliateDescription"><?php echo $alliance->AllianceDesc; ?></textarea>
			</div>
		</div>
		
        <div class="clear mt10">&nbsp;</div>
        <a href="javascript:void(0)" class="link_green fr add_group_alliances"><span><span><?php echo $this->__('Save'); ?></span></span></a>
    </form>
</div>
<script type="text/javascript">loadGroup();</script>