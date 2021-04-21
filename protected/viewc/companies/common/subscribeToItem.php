<?php if(Auth::isUserLogged()):
    if($item->isSubscribed()): ?>
        <a class="link_icon mr10 dn icon_subscribe company_subscribe subscribe_<?php echo $item->ID_COMPANY; ?>" rel="<?php echo $item->ID_COMPANY; ?>" href="javascript:void(0);"><?php echo $this->__('Subscribe'); ?></a>
        <a class="link_icon mr10 icon_unsubscribe company_unsubscribe unsubscribe_<?php echo $item->ID_COMPANY; ?>" rel="<?php echo $item->ID_COMPANY; ?>" href="javascript:void(0);"><?php echo $this->__('Unsubscribe'); ?></a>
    <?php else: ?>
        <a class="link_icon mr10 icon_subscribe company_subscribe subscribe_<?php echo $item->ID_COMPANY; ?>" rel="<?php echo $item->ID_COMPANY; ?>" href="javascript:void(0);"><?php echo $this->__('Subscribe'); ?></a>
        <a class="link_icon mr10 dn icon_unsubscribe company_unsubscribe unsubscribe_<?php echo $item->ID_COMPANY; ?>" rel="<?php echo $item->ID_COMPANY; ?>" href="javascript:void(0);"><?php echo $this->__('Unsubscribe'); ?></a>
    <?php endif;
endif; ?>