<?php
    $platformNames = MainHelper::getGamePlatforms($item);
    $time = MainHelper::getGameRelease($item);
?>
<div class="<?php echo!$num ? 'dot_top' : ''; ?>">
    <div class="pt10 pb10 clearfix dot_bot">
        <div class="grid_1 alpha">
            <a href="<?php echo $item->GAME_URL; ?>"><?php echo MainHelper::showImage($item, THUMB_LIST_60x60, false, array('no_img' => 'noimage/no_game_60x60.png')); ?></a>
        </div>
        <div class="clearfix grid_5 alpha omega">
            <a class="fs13" href="<?php echo $item->GAME_URL; ?>"><?php echo $item->GameName; ?></a>
            <span class="db fclg fft fs11 mt8"><strong><?php echo $this->__('Game Type'); ?></strong>: <?php echo $item->GameType != '' ? $this->__($item->GameType) : '-'; ?></span>
            <span class="db fclg fft fs11"><strong><?php echo $this->__('Release Date'); ?></strong>: <?php echo $item->CreationDate != '0000-00-00' ? $time : '-'; ?></span>
            <span class="db fclg fft fs11"><strong><?php echo $this->__('Platforms'); ?></strong>: <?php echo !empty($platformNames) ? implode(", ", $platformNames) : '-'; ?></span>
        </div>
        <div class="clearfix grid_2 alpha omega fr">
            <span class="db fclg fft fs11"><strong><?php echo $this->__('Players'); ?></strong>: <?php echo $item->PlayersCount != '' ? $item->PlayersCount : '-'; ?></span>
            <span class="db fclg fft fs11"><strong><?php echo $this->__('ESRB Rating'); ?></strong>: <?php echo $item->ESRB != '' ? $item->ESRB : '-'; ?></span>
            <?php if(!$item->isPlaying() and Auth::isUserLogged()): ?>
                <a href="javascript:void(0);" class="link_green db tac mt10 action_is_playing" rel="<?php echo $item->ID_GAME; ?>"><span><span><?php echo $this->__('I play this'); ?></span></span></a>
            <?php endif; ?>
        </div>
    </div>
</div>