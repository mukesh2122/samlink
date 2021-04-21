<form class="standard_form" method="post" action="">
    
    <div class="standard_form_header clearfix">
        <h1 class="pull_left"><?php echo $this->__('Merge company types'); ?></h1>
    </div>
    
	<input type="hidden" name="ID_COMPANYTYPE" value="<?php echo $typeItem->ID_COMPANYTYPE; ?>" />

		<div class="standard_form_elements clearfix">
            <div class="clearfix">
                <label for="CompanyTypeName"><?php echo $this->__('Merge with'); ?></label>
                <select name="tab" id="CompanyTypeName" class="dropkick_lightWide">
                    <?php foreach ($companyTypes as $tab): ?>
                        <?php $tab->ID_COMPANYTYPE==$typeItem->ID_COMPANYTYPE ? $selected='selected="selected"' : $selected='' ?>
                        <option value="<?php echo $tab->ID_COMPANYTYPE; ?>" <?php echo $selected; ?> ><?php echo $tab->CompanyTypeName; ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
        <div class="standard_form_footer clearfix">
		<input class="button button_auto light_blue pull_right" type="submit" value="<?php echo $this->__('Save Settings'); ?>" />
	</div>
	</div>	
</form>