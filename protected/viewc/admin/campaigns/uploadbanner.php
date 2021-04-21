<?php ?><form class="standard_form" method="post" enctype="multipart/form-data">

	<div class="standard_form_header clearfix">
		<h1 class="pull_left"><?php echo $this->__('Upload banner'); ?></h1>
	</div>
    <div class="standard_form_elements clearfix">
    <div class="clearfix"> 
		<div class="profile_foto_edit mt5">
			<label><?php echo 'Banner'; ?></label>
			<div class="standard_form_photo mt2">
                                    <input name="Filedata" type="file" />
				</div>
			</div>
    </div>
    <div class="standard_form_checks clearfix">
        <label for="placements"><?php echo $this->__('Placement'); ?></label>
        <span>
            <div class="standard_form_checks_wrapper no-margin clearfix">
                    <input type="checkbox" name="placements[]" value="top" id="top" />
                    <label for="top" class="cp"><?php echo $this->__('Top'); ?></label>
                    <input type="checkbox" name="placements[]" value="side" id="side" />
                    <label for="side" class="cp"><?php echo $this->__('Side'); ?></label>
            </div>
        </span>
    </div>
    <div class="clearfix">
        <label for="campaign"><?php echo $this->__('Campaign'); ?></label>
        <span>
                    <input type="hidden" id="campaign_id" name="campaign_id" value="<?php echo $campaign->ID_CAMPAIGN; ?>"/>
                    <input tabindex="1" id="campaign" name="campaign" type="text" value="<?php echo $campaign->AdvertiserName; ?>" class="text_input" disabled="disabled"/>
        </span>
    </div>
    <div class="clearfix">
            <label for="maxClicks"><?php echo $this->__('Max clicks'); ?></label>
            <span>
                    <input tabindex="1" id="maxClicks" name="maxClicks" type="text" value="" class="text_input" />
            </span>
    </div>
            <div class="clearfix">
            <label for="maxDisplays"><?php echo $this->__('Max displays'); ?></label>
            <span>
                    <input tabindex="1" id="maxDisplays" name="maxDisplays" type="text" value="" class="text_input" />
            </span>
    </div>
            <div class="clearfix">
            <label for="destination"><?php echo $this->__('Destination URL'); ?></label>
            <span>
                    <input tabindex="1" id="destination" name="destination" type="text" class="text_input" />
            </span>
    </div>
   <div class="clearfix">
            <label for="displaysite"><?php echo $this->__('Display site URL'); ?></label>
            <span>
                    <input tabindex="1" id="displaysite" name="displaysite" type="text" class="text_input" />
            </span>

    </div>
</div>
<div class="standard_form_footer clearfix">
            <input class="button button_auto light_blue pull_right" type="submit" value="<?php echo $this->__('Save Settings'); ?>" />
</div>
<?php ?></form>
<script type="text/javascript">loadCheckboxes();</script>