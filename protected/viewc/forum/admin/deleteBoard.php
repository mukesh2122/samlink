<div class="message_container">
    <!-- header -->
    <div class="clearfix">
        <span class="fs22 fft fclg2 fl mr10"><?php echo $this->__('Delete Board'); ?></span>
    </div>
    <!-- end header -->
    <form action="#" method="post" id="DeleteBoard"> 
    	<input type="hidden" name="type" value="<?php echo $type; ?>" />
        <input type="hidden" name="id" value="<?php echo $id; ?>" />
        <input type="hidden" name="cat_id" value="<?php echo $cat_id; ?>" />
        <input type="hidden" name="board_id" value="<?php echo $board_id ?>" />

		<div class="mt5">
			<div class="border mt2">
				<?php echo $this->__('Here you sure you want to delete this board?'); ?>

			</div>
		</div>
		
		<a href="javascript:void(0)" class="deleteboard_yes roundedButton grey fr  mr20 mt10"> 
			<span class="lrc"></span>
			<span class="mrc">  <?php echo $this->__('YES'); ?> </span>
			<span class="rrc"></span> 
		</a> 
		
		<a  class=" roundedButton grey fr mr20 mt10" href="<?php echo MainHelper::site_url('adminforum/'.$type.'/'.$name); ?>"> 
			<span class="lrc"></span>
			<span class="mrc">  <?php echo $this->__('NO'); ?> </span>
			<span class="rrc"></span> 
		</a> 

	</form>
</div>
