<div class="gradient_header clearfix">
	<span class="header_name header_name_yellow"><?php echo $this->__($headerName); ?></span>
	<span class="fr show_top_news <?php echo !User::isBlockVisible(GAME_TOP) ? '':'dn'; ?>"><a rel="<?php echo GAME_TOP; ?>" class="fft fs11" href="javascript:void(0);"><span>&nbsp;</span><?php echo $this->__('Show Top Games'); ?></a></span>
</div>
<?php if(isset($gameList) and !empty($gameList)): ?>
    <div class="mt10 clearfix top_news top_games_list top_games" <?php echo User::isBlockVisible(GAME_TOP) ? '':'style="display: none;"'; ?>>
        <?php foreach ($gameList as $key=>$item) { echo $this->renderBlock('common/game', array('item' => $item, 'topStars' => $item->CurrentTop, 'odd' => (($key-1) % 2 == 0))); }; ?>
		<div class="hide_top_news">
			<a class="fft fs11" rel="<?php echo GAME_TOP; ?>" href="javascript:void(0);"><span>&nbsp;</span><?php echo $this->__('Hide Top Games'); ?></a>
		</div>
    </div>
<?php endif; ?>