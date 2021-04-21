<?php if($limit == 0):?>
<!-- header -->
<div class="mt10 clearfix">
    <span class="fs22 fft fclg2 fl mr10"><?php echo $this->__('Sent Messages');?></span>
    <div class="blue_block fl mr10"><div><div><?php echo $total;?></div></div></div>
</div>
<!-- end header -->
<div class="clearfix dot_bot mt8 pr">
    <div class="grid_5 alpha mt6 mb10">
        <a class="fs10 mr20" id="select_all" href="javascript:void(0)"><?php echo $this->__('Select All');?></a>
        <a class="fs10 mr20 dn" id="deselect_all" href="javascript:void(0)"><?php echo $this->__('Deselect All');?></a>
        <a class="fs10 mr20 delete_selected_sent_messages" href="javascript:void(0)"><?php echo $this->__('Delete Selected');?></a>
        <a class="fs10 mr20 delete_all_sent_messages" href="javascript:void(0)"><?php echo $this->__('Delete All');?></a>
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
<?php if(!empty($messages)):?>
    <?php foreach ($messages as $item):?>
    <?
        $nick = PlayerHelper::showName($item);
        $img = MainHelper::showImage($item, THUMB_LIST_60x60);
    ?> 

    <div class="post_message post_message_<?php echo $item->ID_PM;?> mt10 clearfix dot_bot">
        <div class="message_inside mb10 pt10 clearfix">
            <div class="grid_1 alpha omega">
                <input id="c1" value="<?php echo $item->ID_PM;?>" class="cp" type="checkbox"/>
            </div>
            <div class="grid_7 alpha omega">    
                <div class="post_head post_head_message clearfix">
                    <div class="grid_1 alpha"><a class="img" title="<?php echo $nick;?>" href="<?php echo MainHelper::site_url('player/'.$item->URL);?>"><?php echo $img?></a></div>
                    <div class="grid_4 alpha pr10">
                        <span class="fs10 mt13 fclg db"><?php echo $this->__('Message To');?>:</span>
                        <span class="db mt0"><a href="<?php echo MainHelper::site_url('player/'.$item->URL);?>"><?php echo $nick;?></a></span>
                    </div>
                    <div class="grid_2 omega pr">
                        <div class="calendar db pa cal_body">
                            <span class="db fs10 fft mt15 fclg tac"><?php echo date("h:i A", $item->MsgTime);?></span>
                            <span class="db fwb tac fs19 lhn com_inbox_day"><?php echo date("d", $item->MsgTime);?></span>
                            <span class="db fs10 fft fclg tac cal_time"><?php echo date("M Y", $item->MsgTime);?></span>
                        </div>
                        <a href="javascript:void(0)" rel="<?php echo $item->ID_PM;?>" class="pa delete_sent_message cal icon_close">&nbsp;</a>
                    </div>
                </div>
                
                <div class="mt10 fcb post_body clearfix">
                    <?php echo ContentHelper::handleContentOutput($item->Body);?>
                </div>
                
                <div class="mt10 post_body clearfix">
                    <a class="link_icon icon_forward forward_message" href="<?php echo MainHelper::site_url('players/ajaxgetsendmessage/'.$item->URL.'/'.$item->ID_PM);?>"><?php echo $this->__('Forward');?></a>
                </div>
            </div>
        </div>
        
    </div>
    <?php endforeach; ?>
<?php endif; ?>
<script type="text/javascript">loadCheckboxes();</script>
