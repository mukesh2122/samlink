<div class="gradient_header clearfix">
	<span class="header_name header_name_yellow"><?php echo $this->__($headerName); ?></span>
	<span class="fr show_top_news <?php echo !User::isBlockVisible(GAME_POPULAR) ? '':'dn';?> "><a rel="<?php echo GAME_POPULAR; ?>" class="fft fs11" href="javascript:void(0);"><span>&nbsp;</span><?php echo $this->__('Show Pop Games'); ?></a></span>
</div>
<?php if(isset($gameList) and !empty($gameList)): ?>
    <div class="mt10 clearfix top_news top_games_list pop_companies" <?php echo User::isBlockVisible(GAME_POPULAR) ? '':'style="display: none;"'; ?>>
        <?php foreach ($gameList as $key=>$item) { echo $this->renderBlock('common/game', array('item' => $item, 'topStars' => $item->CurrentPop, 'odd' => (($key-1) % 2 == 0))); }; ?>
		<div class="hide_top_news">
			<a class="fft fs11" rel="<?php echo GAME_POPULAR; ?>" href="javascript:void(0);"><span>&nbsp;</span><?php echo $this->__('Hide Pop Games'); ?></a>
		</div>
    </div>
<?php endif; ?>