<form class="standard_form" method="post" action="">
    
    <div class="standard_form_header clearfix">
        <h1 class="pull_left"><?php echo $this->__('Merge game types'); ?></h1>
    </div>
    
	<input type="hidden" name="ID_GAMETYPE" value="<?php echo $typeItem->ID_GAMETYPE; ?>" />

		<div class="standard_form_elements clearfix">
            <div class="clearfix">
                <label for="GameTypeName"><?php echo $this->__('Merge with'); ?></label>
                <select name="tab" id="GameTypeName" class="dropkick_lightWide">
                    <?php foreach ($gameTypes as $tab): ?>
                        <?php $tab->ID_GAMETYPE==$typeItem->ID_GAMETYPE ? $selected='selected="selected"' : $selected='' ?>
                        <option value="<?php echo $tab->ID_GAMETYPE; ?>" <?php echo $selected; ?> ><?php echo $tab->GameTypeName; ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
        <div class="standard_form_footer clearfix">
		<input class="button button_auto light_blue pull_right" type="submit" value="<?php echo $this->__('Save Settings'); ?>" />
	</div>
	</div>	
</form>