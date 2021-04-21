<div class="message_container">
    <!-- header -->
    <div class="clearfix">
        <span class="fs22 fft fclg2 fl mr10"><?php echo $this->__('Edit Category'); ?></span>
    </div>
    <!-- end header -->
    <form action="#" method="post" id="add_forum_cat_form">
        <input type="hidden" name="type" value="<?php echo $type; ?>" />
        <input type="hidden" name="id" value="<?php echo $id; ?>" />
        <input type="hidden" name="cat_id" value="<?php echo $category->ID_CAT; ?>" />

		<div class="mt5">
			<label for="catName" class="cp"><?php echo $this->__('Name');?></label>
			<div class="border mt2">
				<input name="cat_name" class="w576 news_border cat_name" id="catName" value="<?php echo $category->CategoryName; ?>" />
			</div>
		</div>
		
		<a href="javascript:void(0)" class="roundedButton grey fr add_forum_cat mt10">
			<span class="lrc"></span>
			<span class="mrc"><?php echo $this->__('Edit'); ?></span>
			<span class="rrc"></span>
		</a>
	</form>
</div>