<div class="message_container">
    <!-- header -->
    <div class="clearfix">
        <span class="fs22 fft fclg2 fl mr10"><?php echo $this->__('Add New Tab'); ?></span>
    </div>
    <!-- end header -->
    <form action="#" method="post" id="addtab_company_form">
        <input type="hidden" name="company_id" value="<?php echo $company->ID_COMPANY; ?>">

        <div class="mt5">
			<label for="tabName" class="cp"><?php echo $this->__('Name'); ?></label>
			<div class="border mt2">
				<input name="tab_name" class="w576 news_border tab_name" id="tabName">
			</div>
		</div>

        <div class="clear mt10">&nbsp;</div>
        <a href="javascript:void(0);" class="link_green fr addtab_company"><span><span><?php echo $this->__('Add'); ?></span></span></a>
    </form>
</div>