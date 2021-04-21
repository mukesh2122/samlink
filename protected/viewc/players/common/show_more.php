<?php if(isset($total) && ($total > Doo::conf()->playersLimit)): ?>
	<input type="hidden" value="<?php echo $tab; ?>" id="wallID">
	<input type="hidden" value="<?php echo $order; ?>" id="wallType">
	<a class="show_more_button show_more_friends" href="javascript:void(0);" rel="<?php echo Doo::conf()->playersLimit; ?>">
		<?php echo $this->__('Show more'); ?>
	</a>
<?php endif; ?>