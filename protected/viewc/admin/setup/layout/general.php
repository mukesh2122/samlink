<?php
    $facebook = Layout::getActiveLayout('general_social_facebook');
    $twitter = Layout::getActiveLayout('general_social_twitter');
    $linkedin = Layout::getActiveLayout('general_social_linkedin');
    $bg_image = Layout::getActiveLayout('general_bg_img');
    $name = Layout::getActiveLayout('general_site_name');
    $bg_active = Layout::getActiveLayout('general_bg_active');
    $startgradient = Layout::getActiveLayout('general_bg_startgradient');
    $stopgradient = Layout::getActiveLayout('general_bg_stopgradient');
    $bg_color = Layout::getActiveLayout('general_bg_color');
?>

<?php echo $this->renderBlock('admin/setup/layout/common/infobox'); ?>

<form class="standard_form" method="post" action="<?php echo MainHelper::site_url('admin/setup/layout/general'); ?>">

	<div class="standard_form_header clearfix">
		<h1 class="pull_left"><?php echo $this->__('General settings'); ?></h1>
	</div>
	<div class="standard_form_elements clearfix">
            <div class="standard_form_info_header">
                <h2><?php echo $this->__('Background') ?></h2>
            </div>
            <div class="standard_form_checks clearfix bg_choser">
                <label for="bg_active"><?php echo $this->__('Active'); ?></label>
                <span>
                    <div class="standard_form_checks_wrapper clearfix">
                        <input type="radio" <?php echo $bg_active->Value == 'image' ? 'checked="checked"' : ''; ?> class="bg_active" name="bg_active" value="image" id="image" />
                        <label for="image" class="dst"><?php echo $this->__('Image'); ?></label>
                        
                        <input type="radio" <?php echo $bg_active->Value == 'color' ? 'checked="checked"' : ''; ?> class="bg_active" name="bg_active" value="color" id="color" />
                        <label for="color" class="dst"><?php echo $this->__('Color'); ?></label>
                        
                        <input type="radio" <?php echo $bg_active->Value == 'gradient' ? 'checked="checked"' : ''; ?> class="bg_active" name="bg_active" value="gradient" id="gradient" />
                        <label for="gradient" class="dst"><?php echo $this->__('Gradient'); ?></label>
                    </div>
                </span>
            </div>
            <div class="profile_foto_edit mt5 bg_container container_image" <?php echo $bg_active->Value != 'image' ? "style='display:none'" : ''; ?>">
                <label><?php echo 'Image' ; ?></label>
                <div class="standard_form_photo mt2">       
                        <div class="standard_form_photo_action">
                                <a id="layout_background_uploader" rel="" class="button button_medium light_grey" href="javascript:void(0)"><?php echo $this->__('Upload Photo'); ?></a>
                                <input class="mt5 text_input" type="text" id="imageName" name="layout_background_uploader" value="<?php echo $bg_image->Value; ?>"/>
                        </div>
                </div>
            </div>
            <div class="clearfix bg_container container_color" <?php echo $bg_active->Value != 'color' ? "style='display:none'" : ''; ?>>
                <label for="bg_color"><?php echo $this->__('Color'); ?></label>
                    <span>
                        <input tabindex="1" id="bg_color" name="bg_color" type="text" value="<?php echo $bg_color->Value; ?>" class="text_input cp-basic bgbg" />
                        <div class="color_preview" style="background-color:<?php echo $bg_color->Value; ?>"></div>
                    </span>
            </div> 
            <div class="clearfix bg_container container_gradient" <?php echo $bg_active->Value != 'gradient' ? "style='display:none'" : ''; ?>>
                <label for="bg_gradient_start"><?php echo $this->__('Gradient'); ?></label>
                <span>
                    <div>
                        <input tabindex="1" id="bg_gradient_start" name="bg_gradient_start" type="text" value="<?php echo $startgradient->Value; ?>" class="text_input cp-basic" />
                        <div class="color_preview" style="background-color:<?php echo $startgradient->Value; ?>"></div>
                    </div>
                    <div>
                        <input tabindex="1" id="bg_gradient_stop" name="bg_gradient_stop" type="text" value="<?php echo $stopgradient->Value; ?>" class="text_input cp-basic" />
                        <div class="color_preview" style="background-color:<?php echo $stopgradient->Value; ?>"></div>
                    </div>
                </span>
            </div>  
        </div>                  
	<div class="standard_form_footer clearfix">
            <input class="button button_auto light_blue pull_right button_span_left" name="save_button" type="submit" value="<?php echo $this->__('Save settings'); ?>" />
            <input class="button button_auto red pull_right" type="submit" name="reset_button" value="<?php echo $this->__('Reset to default'); ?>" />
	</div>
</form>
<script type="text/javascript">loadCheckboxes();</script>


