<?php
    $footer_height = Layout::getActiveLayout('footer_height');
    $footer_border_active = Layout::getActiveLayout('footer_border_active');
    $footer_border_color = Layout::getActiveLayout('footer_border_color');
    $footer_logo_img = Layout::getActiveLayout('footer_logo_img');
    $footer_logo_top = Layout::getActiveLayout('footer_logo_top');
    $footer_logo_left = Layout::getActiveLayout('footer_logo_left');
    $footer_bg_active = Layout::getActiveLayout('footer_bg_active');
    $footer_bg_img = Layout::getActiveLayout('footer_bg_img');
    $footer_bg_color = Layout::getActiveLayout('footer_bg_color');
    $footer_bg_startgradient = Layout::getActiveLayout('footer_bg_startgradient');
    $footer_bg_stopgradient = Layout::getActiveLayout('footer_bg_stopgradient');
?>

<?php echo $this->renderBlock('admin/setup/layout/common/infobox'); ?>

<form class="standard_form" method="post" action="<?php echo MainHelper::site_url('admin/setup/layout/footer'); ?>">

	<div class="standard_form_header clearfix">
		<h1 class="pull_left"><?php echo $this->__('Footer settings'); ?></h1>
	</div>
	<div class="standard_form_elements clearfix">
            <div class="clearfix">
                <label for="footer_height"><?php echo $this->__('Height'); ?></label>
                <span>
                        <input tabindex="1" id="footer_height" name="footer_height" type="text" value="<?php echo $footer_height->Value; ?>" class="text_input" />
                </span>
            </div>
            <div class="standard_form_info_header">
                    <h2><?php echo $this->__('Background') ?></h2>
            </div>
                        <div class="standard_form_checks clearfix bg_choser">
                <label for="bg_active"><?php echo $this->__('Active'); ?></label>
                    <span>
                        <div class="standard_form_checks_wrapper clearfix">
                            <input type="radio" <?php echo $footer_bg_active->Value == 'image' ? 'checked="checked"' : ''; ?> class="bg_active" name="bg_active" value="image" id="image" />
                            <label for="image" class="dst"><?php echo $this->__('Image'); ?></label>
                            <input type="radio" <?php echo $footer_bg_active->Value == 'color' ? 'checked="checked"' : ''; ?> class="bg_active" name="bg_active" value="color" id="color" />
                            <label for="color" class="dst"><?php echo $this->__('Color'); ?></label>
                            <input type="radio" <?php echo $footer_bg_active->Value == 'gradient' ? 'checked="checked"' : ''; ?> class="bg_active" name="bg_active" value="gradient" id="gradient" />
                            <label for="gradient" class="dst"><?php echo $this->__('Gradient'); ?></label>
                        </div>
                    </span>
           </div>
            <div class="clearfix profile_foto_edit bg_container container_image" <?php echo $footer_bg_active->Value != 'image' ? "style='display:none'" : ''; ?>>
                <label><?php echo 'Image' ; ?></label>
                <div class="standard_form_photo mt2">       
                        <div class="ml2 standard_form_photo_action">
                                <a id="layout_background_uploader" rel="" class="button button_medium light_grey" href="javascript:void(0)"><?php echo $this->__('Upload Image'); ?></a>
                                <input class="mt5 text_input" type="text" id="imageName" name="layout_background_uploader" value="<?php echo $footer_bg_img->Value; ?>"/>
                        </div>
                </div>
            </div>    
            <div class="clearfix bg_container container_color" <?php echo $footer_bg_active->Value != 'color' ? "style='display:none'" : ''; ?>>
                <label for="bg_color"><?php echo $this->__('Color'); ?></label>
                    <span>
                            <input tabindex="1" id="bg_color" name="bg_color" type="text" value="<?php echo $footer_bg_color->Value; ?>" class="text_input cp-basic bgbg" />
                            <div class="color_preview" style="background-color:<?php echo $footer_bg_color->Value; ?>"></div>
                    </span>
            </div> 
            <div class="clearfix bg_container container_gradient" <?php echo $footer_bg_active->Value != 'gradient' ? "style='display:none'" : ''; ?>>
                <label for="bg_gradient_start"><?php echo $this->__('Gradient'); ?></label>
                    <span>
                        <div>
                            <input tabindex="1" id="bg_gradient_start" name="bg_gradient_start" type="text" value="<?php echo $footer_bg_startgradient->Value; ?>" class="text_input cp-basic" />
                            <div class="color_preview" style="background-color:<?php echo $footer_bg_startgradient->Value; ?>"></div>
                        </div>
                        <div>
                            <input tabindex="1" id="bg_gradient_stop" name="bg_gradient_stop" type="text" value="<?php echo $footer_bg_stopgradient->Value; ?>" class="text_input cp-basic" />
                            <div class="color_preview" style="background-color:<?php echo $footer_bg_stopgradient->Value; ?>"></div>
                        </div>
                            
                    </span>
            </div>
                <div class="standard_form_info_header">
                    <h2><?php echo $this->__('Border') ?></h2>
                </div>
            <div class="standard_form_checks clearfix">
                <label for="border_active"><?php echo $this->__('Active'); ?></label>
                    <span>
                        <div class="standard_form_checks_wrapper no-margin clearfix">
                            <input <?php echo $footer_border_active->Value == '1' ? "checked='checked'" : ''; ?> type="checkbox" name="border_active" value="1" id="border_active" />
                            <label for="border_active" class="cp"><?php echo $this->__('On'); ?></label>
                        </div>
                    </span>
             </div>
            <div class="clearfix">
                <label for="border_color"><?php echo $this->__('Color'); ?></label>
                    <span>
                        <input tabindex="1" id="border_color" name="border_color" type="text" value="<?php echo $footer_border_color->Value; ?>" class="text_input cp-basic" />
                        <div class="color_preview" style="background-color:<?php echo $footer_border_color->Value; ?>"></div>
                    </span>
            </div>        
            <div class="standard_form_info_header">
                    <h2><?php echo $this->__('Logo') ?></h2>
            </div>
            <div class="clearfix profile_foto_edit">
                <label><?php echo 'Image' ; ?></label>
                <div class="standard_form_photo mt2">       
                        <div class="ml2 standard_form_photo_action">
                                <a id="layout_logo_uploader" rel="" class="button button_medium light_grey" href="javascript:void(0)"><?php echo $this->__('Upload Image'); ?></a>
                                <input class="mt5 text_input" type="text" id="imageName_logo" name="layout_logo_uploader" value="<?php echo $footer_logo_img->Value; ?>"/>
                        </div>
                </div>
            </div>                     
        </div> 
	<div class="standard_form_elements clearfix">
                <div class="standard_form_info_header">
                    <h2><?php echo $this->__('Logo placement') ?></h2>
                </div>
            <div class="clearfix">
                <label for="logo_top"><?php echo $this->__('Top'); ?></label>
                    <span>
                            <input tabindex="1" id="logo_top" name="logo_top" type="text" value="<?php echo $footer_logo_top->Value; ?>" class="text_input" />
                    </span>
            </div>       
            <div class="clearfix">
                <label for="logo_left"><?php echo $this->__('Left'); ?></label>
                    <span>
                            <input tabindex="1" id="logo_left" name="logo_left" type="text" value="<?php echo $footer_logo_left->Value; ?>" class="text_input" />
                    </span>
            </div>   

        </div>     
	<div class="standard_form_footer clearfix">
		<input class="button button_auto light_blue pull_right button_span_left" name="save_button" type="submit" value="<?php echo $this->__('Save settings'); ?>" />
		<input class="button button_auto red pull_right" type="submit" name="reset_button" value="<?php echo $this->__('Reset to default'); ?>" />
	</div>
</form>
<script type="text/javascript">loadCheckboxes();</script>