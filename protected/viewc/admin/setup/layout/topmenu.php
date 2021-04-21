<?php
    $font_color = Layout::getActiveLayout('top_font_color');
    $font_size = Layout::getActiveLayout('top_font_size');
    $font_shadow = Layout::getActiveLayout('top_font_shadow');
    $bg_active = Layout::getActiveLayout('top_bg_active');
    $bg_color = Layout::getActiveLayout('top_bg_color');
    $bg_gradient_top = Layout::getActiveLayout('top_bg_startgradient');
    $bg_gradient_bottom = Layout::getActiveLayout('top_bg_stopgradient');
    $bg_img = Layout::getActiveLayout('top_bg_img');
    $border_active = Layout::getActiveLayout('top_border_active');
    $border_top = Layout::getActiveLayout('top_border_top');
    $border_bottom = Layout::getActiveLayout('top_border_bottom');
    $hover_fontcolor = Layout::getActiveLayout('top_hover_fontcolor');
    $hover_startgradient = Layout::getActiveLayout('top_hover_startgradient');
    $hover_stopgradient = Layout::getActiveLayout('top_hover_stopgradient');
    $active_fontcolor = Layout::getActiveLayout('top_active_fontcolor');
    $active_color = Layout::getActiveLayout('top_active_color');
    $border_splitter = Layout::getActiveLayout('top_border_splitter');
?>

<?php echo $this->renderBlock('admin/setup/layout/common/infobox'); ?>

<form class="standard_form" method="post" action="<?php echo MainHelper::site_url('admin/setup/layout/topmenu'); ?>">

	<div class="standard_form_header clearfix">
            <h1 class="pull_left"><?php echo $this->__('Topmenu settings'); ?></h1>
	</div>

	<div class="standard_form_elements clearfix">
            <div class="standard_form_info_header">
                <h2><?php echo $this->__('Font') ?></h2>
            </div>
            <div class="clearfix">
                <label for="font_color"><?php echo $this->__('Color'); ?></label>
                <span>
                    <input tabindex="1" id="font_color" name="font_color" type="text" value="<?php echo $font_color->Value; ?>" class="text_input cp-basic" />
                    <div class="color_preview" style="background-color:<?php echo $font_color->Value; ?>"></div>
                </span>
            </div>
            <div class="clearfix">
                <label for="font_size"><?php echo $this->__('Size'); ?></label>
                <span>
                        <input tabindex="1" id="font_size" name="font_size" type="text" value="<?php echo $font_size->Value; ?>" class="text_input" />
                </span>
            </div>
            
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
            <div class="clearfix profile_foto_edit bg_container container_image" <?php echo $bg_active->Value != 'image' ? "style='display:none'" : ''; ?>>
                <label><?php echo 'Image' ; ?></label>
                <div class="standard_form_photo mt2">       
                        <div class="ml2 standard_form_photo_action">
                                <a id="layout_background_uploader" rel="" class="button button_medium light_grey" href="javascript:void(0)"><?php echo $this->__('Upload Image'); ?></a>
                                <input class="mt5 text_input" type="text" id="imageName" name="layout_background_uploader" value="<?php echo $bg_img->Value; ?>"/>
                        </div>
                </div>
            </div>     
           <div class="clearfix bg_container container_color" <?php echo $bg_active->Value != 'color' ? "style='display:none'" : ''; ?>>
               <label for="bg_color"><?php echo $this->__('Color'); ?></label>
               <span>
                    <input tabindex="1" id="bg_color" name="bg_color" type="text" value="<?php echo $bg_color->Value; ?>" class="text_input cp-basic" />
                    <div class="color_preview" style="background-color:<?php echo $bg_color->Value; ?>"></div>
               </span>
           </div> 
            <div class="clearfix bg_container container_gradient" <?php echo $bg_active->Value != 'gradient' ? "style='display:none'" : ''; ?>>
                <label for="gradient_top"><?php echo $this->__('Gradient'); ?></label>
                <span>
                    <div>
                        <input tabindex="1" id="gradient_top" name="gradient_top" type="text" value="<?php echo $bg_gradient_top->Value; ?>" class="text_input cp-basic" />
                        <div class="color_preview" style="background-color:<?php echo $bg_gradient_top->Value; ?>"></div>
                    </div>
                    <div>
                        <input tabindex="1" id="gradient_bottom" name="gradient_bottom" type="text" value="<?php echo $bg_gradient_bottom->Value; ?>" class="text_input cp-basic" />
                        <div class="color_preview" style="background-color:<?php echo $bg_gradient_bottom->Value; ?>"></div>
                    </div>
                </span>
            </div>
            
            <div class="standard_form_info_header">
                <h2><?php echo $this->__('Border') ?></h2>
            </div>
            <div class="standard_form_checks clearfix">
                <label for="border_active"><?php echo $this->__('Borders'); ?></label>
                <span>
                    <div class="standard_form_checks_wrapper no-margin clearfix">
                        <input <?php echo $border_active->Value == '1' ? "checked='checked'" : ''; ?> type="checkbox" name="border_active" value="1" id="border_active">
                        <label for="border_active" class="cp"><?php echo $this->__('On'); ?></label>
                    </div>
                </span>
            </div>
            <div class="standard_form_checks clearfix">
                <label for="font_shadow"><?php echo $this->__('Shadow'); ?></label>
                <span>
                    <div class="standard_form_checks_wrapper no-margin clearfix">
                        <input <?php echo $font_shadow->Value == '1' ? "checked='checked'" : ''; ?> type="checkbox" name="font_shadow" value="1" id="font_shadow">
                        <label for="font_shadow" class="cp"><?php echo $this->__('On'); ?></label>
                    </div>
                </span>
            </div>
            <div class="clearfix">
                <label for="border_top"><?php echo $this->__('Top'); ?></label>
                <span>
                        <input tabindex="4" id="border_top" name="border_top" type="text" value="<?php echo $border_top->Value; ?>" class="text_input cp-basic" />
                        <div class="color_preview" style="background-color:<?php echo $border_top->Value; ?>"></div>
                </span>
            </div>
            <div class="clearfix">
                <label for="border_bottom"><?php echo $this->__('Bottom'); ?></label>
                <span>
                        <input tabindex="4" id="border_bottom" name="border_bottom" type="text" value="<?php echo $border_bottom->Value; ?>" class="text_input cp-basic" />
                        <div class="color_preview" style="background-color:<?php echo $border_bottom->Value; ?>"></div>
                </span>
            </div>
            <div class="clearfix">
                <label for="border_splitter"><?php echo $this->__('Splitter'); ?></label>
                <span>
                        <input tabindex="4" id="border_splitter" name="border_splitter" type="text" value="<?php echo $border_splitter->Value; ?>" class="text_input cp-basic" />
                        <div class="color_preview" style="background-color:<?php echo $border_splitter->Value; ?>"></div>
                </span>
            </div>
            
            <div class="standard_form_info_header">
                <h2><?php echo $this->__('Hover settings') ?></h2>
            </div>
                <div class="clearfix">
                    <label for="hover_fontcolor"><?php echo $this->__('Font color'); ?></label>
                    <span>
                            <input tabindex="4" id="hover_fontcolor" name="hover_fontcolor" type="text" value="<?php echo $hover_fontcolor->Value; ?>" class="text_input cp-basic" />
                            <div class="color_preview" style="background-color:<?php echo $hover_fontcolor->Value; ?>"></div>
                    </span>
                </div>
                <div class="clearfix">
                    <label for="hover_start"><?php echo $this->__('Background colors'); ?></label>
                    <span>
                        <span>
                            <input tabindex="4" id="hover_start" name="hover_start" type="text" value="<?php echo $hover_startgradient->Value; ?>" class="text_input cp-basic" />
                            <div class="color_preview" style="background-color:<?php echo $hover_stopgradient->Value; ?>"></div>
                        </span>
                        <span>
                            <input tabindex="4" id="hover_stop" name="hover_stop" type="text" value="<?php echo $hover_stopgradient->Value; ?>" class="text_input cp-basic" />
                            <div class="color_preview" style="background-color:<?php echo $hover_stopgradient->Value; ?>"></div>
                        </span>
                    </span>
                </div>
            
            <div class="standard_form_info_header">
                <h2><?php echo $this->__('Active settings') ?></h2>
            </div>
                <div class="clearfix">
                    <label for="active_fontcolor"><?php echo $this->__('Font color'); ?></label>
                    <span>
                            <input tabindex="4" id="active_fontcolor" name="active_fontcolor" type="text" value="<?php echo $active_fontcolor->Value; ?>" class="text_input cp-basic" />
                            <div class="color_preview" style="background-color:<?php echo $active_fontcolor->Value; ?>"></div>
                    </span>
                </div>
                <div class="clearfix">
                    <label for="active_color"><?php echo $this->__('Background color'); ?></label>
                    <span>
                            <input tabindex="4" id="active_color" name="active_color" type="text" value="<?php echo $active_color->Value; ?>" class="text_input cp-basic" />
                            <div class="color_preview" style="background-color:<?php echo $active_color->Value; ?>"></div>
                    </span>
                </div>
        </div>                  
	<div class="standard_form_footer clearfix">
		<input class="button button_auto light_blue pull_right button_span_left" name="save_button" type="submit" value="<?php echo $this->__('Save settings'); ?>" />
		<input class="button button_auto red pull_right" type="submit" name="reset_button" value="<?php echo $this->__('Reset to default'); ?>" />
	</div>
</form>
<script type="text/javascript">loadCheckboxes();</script>