<div class="message_container">
    <!-- header -->
    <div class="clearfix">
        <span class="fs22 fft fclg2 fl mr10"><?php echo $this->__('Request To Join [_1]', array('"'.$group->GroupName.'"')); ?></span>
    </div>
    <!-- end header -->
    <form action="#" method="post" id="add_group_application_form">
        <input type="hidden" name="group_id" class="F_group_apply_id" value="<?php echo $group->ID_GROUP; ?>" />

        <div class="mt10 fs15"><?php echo $this->__('I want to join because');?></div>
        <div class="mt10 fs11 fclg fft"><?php echo $this->__('Symbols left');?>: <span id="symbol_count">250</span></div>

        <div class="comments-cont mt5">
            <div class="comments-top">
                <div class="comments-bot pr">
                    <textarea name="group_apply_description" id="group_apply_description" rows="1" class="autoSize comment_block apply_to_join_input" cols="1" title=""></textarea>
                </div>
            </div>
        </div>

        <div class="clear mt10">&nbsp;</div>
        <a href="javascript:void(0)" class="link_green fr add_group_application"><span><span><?php echo $this->__('Send'); ?></span></span></a>
    </form>
</div>
<script type="text/javascript">autoSize();</script>