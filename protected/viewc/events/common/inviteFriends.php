<div class="mt5 pb5 dot_bot">
		<div class="searchGroupInputTop"></div>
		<div class="searchGroupInputMid">
			<input type="text" id="" class="friendSearchBox w300 pl5 bareInput withLabel pt2"
					title="<?php echo $this->__('Search...'); ?>" 
					class="fl withLabel bareInput"
					value="<?php echo $this->__('Search...'); ?>" />

<!--			<a id="" class="buttonRRound eventsSearchRound fr mr4 common_new_search" 
				href="javascript:void(0)">
				<span class="lrc"></span>
				<span class="mrc">
					<span class="fl fs11"><strong><?php echo $this->__('Search'); ?></strong></span>
					<span class="iconr_search fl mt3 ml2"></span>
				</span>
				<span class="rrc"></span>
			</a>-->
		</div>
		<div class="searchGroupInputBottom"></div>
		
</div>



<div class="clearfix bgw mt5 blg p5">
	<?php if (!empty($friends)): ?>
	<div class="JscrollPane">
		<table class="w100 friendsInviteList">
			<?php foreach ($friends as $f): ?>
			<?php $item = (object) $f; ?>
			<tr>
				<td class="w10 dot_bot pt5 pb5">
					<input id="c1" value="<?php echo $item->ID_PLAYER; ?>" name="invitation[]" class="cp" type="checkbox"/>
				</td>
				<td class="searchPlayerName dot_bot">
					<?php echo PlayerHelper::showName($item); ?>
				</td>
			</tr>
			<?php endforeach; ?>
		</table>
			
	</div>
	
	<?php endif; ?>

</div>