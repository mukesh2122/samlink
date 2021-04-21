<ul id="lobby_notification" class="esport_widget_content">
    <li>
    	<div class="notification_buttons">
        	<span><a class="button button_small grey pull_right btn_red_gradient_bg" href="#">Let's Go!</a>
            <a class="button button_small grey pull_right btn_red_gradient_bg" href="#">Reject</a></span>
        </div>
        <div class="notification_message">
        	<span>19:30 - Pwiestfield Accepted your challenge</span>
        </div>
    </li>
    <li>
    	<div class="notification_buttons">
        	<span><a class="button button_small grey pull_right btn_red_gradient_bg" href="#">Ok</a></span>
        </div>
        <div class="notification_message">
        	<span>Request sent to Pwiestfield</span>
        </div>
    </li>
    <li>
    	<div class="notification_buttons">
        	<span><a class="button button_small grey pull_right btn_red_gradient_bg" href="#">Ok</a></span>
        </div>
        <div class="notification_message">
        	<span>Request sent to Arachnia</span>
        </div>
    </li>
    
    
    <!-- *********** READ ME *********** Dont know if you can use this PHP, but ive commented it all out. Use it if youd like, else delete it.
	<?php foreach($notifications as $note): ?>
    <?php   $note->Read();
            $state = $note->MessageType;
            $statemsg = '';

            switch($state){
                case NOTIFICATION_QUICKMATCH_ACCEPT:
                        $statemsg = 'is ready for you';
                        break;
                case NOTIFICATION_QUICKMATCH_REJECT:
                        $statemsg = 'backed out';
                        break;
                case NOTIFICATION_QUICKMATCH_CHALLENGE:
                        $statemsg = 'accepted your challenge';
                        break;
            }
    ?>
    <li>
        <p><strong class="mr10"><?php echo date('H:m'); ?></strong><?php echo ' '.$note->getSenderName().' '.$this->__($statemsg); ?></p>
        <div class="tournament_buttons">
            <?php if($state == NOTIFICATION_QUICKMATCH_CHALLENGE): ?>
            <a class="button red reject" id="<?php echo $note->Sender; ?>" href="javascript:void(0)"><?php echo $this->__('Reject'); ?></a>
            <?php endif;?>
            <?php if($state== NOTIFICATION_QUICKMATCH_ACCEPT || $state == NOTIFICATION_QUICKMATCH_CHALLENGE): ?>
            <a class="button red accept" id="<?php echo $note->Sender.'_'.$note->FK_QUICKMATCH; ?>" href="javascript:void(0)"><?php echo $this->__("Let's go"); ?></a>
            <?php endif;?>
            <?php if($state == NOTIFICATION_QUICKMATCH_REJECT): ?>
            <a class="button red ok" id="<?php echo $note->Sender; ?>" href="javascript:void(0)"><?php echo $this->__("Too bad"); ?></a>
            <?php endif;?>
        </div>
    </li>
    <?php endforeach; ?>-->
</ul>