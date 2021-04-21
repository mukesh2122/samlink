<form class="standard_form" method="post" action="">

	<div class="standard_form_header clearfix">
		<h1 class="pull_left"><?php echo $this->__('Create new company type'); ?></h1>
	</div>
	
	<div class="standard_form_elements clearfix">
            <div class="clearfix">
                <label for="GameTypeName"><?php echo $this->__('Name'); ?></label>
                <span>
                    <input tabindex="1" id="GameTypeName" name="CompanyTypeName" type="text" value="" class="text_input" />
                </span>
            </div>
            <div class="clearfix">
                <label for="GameTypeDesc"><?php echo $this->__('Description'); ?></label>
                <span>
                    <div class="standard_form_checks_wrapper no-margin clearfix">
                        <textarea rows="7" cols="43" tabindex="2" id="GameTypeDesc" name="CompanyTypeDesc"></textarea>
                    </div>
                </span>
            </div>
        <div class="standard_form_footer clearfix">
		<input class="button button_auto light_blue pull_right" type="submit" value="<?php echo $this->__('Save Settings'); ?>" />
	</div>
	</div>	
</form>