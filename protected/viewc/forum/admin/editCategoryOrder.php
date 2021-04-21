<div class="message_container">
    <!-- header -->
    <div class="clearfix">
        <span class="fs22 fft fclg2 fl mr10"><?php echo $this->__('Update Order'); ?></span>
    </div>
    <!-- end header -->
    <form action="#" method="post" id="ChangeCatOrder">

        <input type="hidden" name="type" id="type" value="<?php echo $type; ?>" />
        <input type="hidden" name="id" id="id" value="<?php echo $id; ?>" />
        <input type="hidden" name="cat_id" id="cat_id" value="<?php echo $cat_id; ?>" />


		<div class="mt5">
			<label for="CatOrderNr" class="cp"><?php echo $this->__('CatOrderNr');?></label>
			<div class="border mt2">
				<input type="text" name="cat_order" class="w576 news_border" id="CatOrderNr" value="<?php echo $category->CatOrder; ?>"  />
			</div>
		</div>
		
		<a href="javascript:void(0)" class="UpdateCatOrder roundedButton grey fr  mt10">
			<span class="lrc"></span>
			<span class="mrc"><?php echo $this->__('Update'); ?></span>
			<span class="rrc"></span>
		</a>
	</form>
</div>
