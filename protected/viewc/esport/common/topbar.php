<?php
    $player = User::getUser();
?>
<div class="esports_userprofile dib">
    <?php if(Auth::isUserLogged()): ?>
        <div class="esports_userprofile_logout pull_left w190">
            <?php echo $this->renderBlock('esport/common/logout', array('player' => $player)); ?>
        </div>
        <div class="profile_widget_menu pull_left mt8">
            <span><a class="profile_widget_upgrade" href="<?php echo MainHelper::site_url('esport/spotlight/edit') ?>"><?php echo $this->__('Edit spotlight'); ?></a></span>
            <span><a class="profile_widget_upgrade" href="<?php echo MainHelper::site_url('shop/buy-credits') ?>"><?php echo $this->__('Buy credits'); ?></a></span>
        </div>
    <?php endif; ?>
    <div class="sponsors pull_right p10">
        <p class="pull_left mt30">Powered by: </p>
        <a><img src="<?php echo MainHelper::site_url('global/pub_img/esport/sponsors/playnation.png'); ?>" /></a>
    </div>
</div>