<?php
    $logo_img = Layout::getActiveLayout('header_logo_img');
    $logo_top = Layout::getActiveLayout('header_logo_top');
    $logo_left = Layout::getActiveLayout('header_logo_left');
    $header_height = Layout::getActiveLayout('header_height');
    $bg_img = Layout::getActiveLayout('header_bg_img');
    $header_color = Layout::getActiveLayout('header_bg_color');
    $header_startgradient = Layout::getActiveLayout('header_bg_startgradient');
    $header_stopgradient = Layout::getActiveLayout('header_bg_stopgradient');
    $bg_active = Layout::getActiveLayout('header_bg_active');
    $searchbar = Layout::getActiveLayout('header_searchbar_active');
    $logo_title = Layout::getActiveLayout('header_logo_title');
?>

<?php echo $this->renderBlock('admin/setup/layout/common/infobox'); ?>

<form class="standard_form" method="post" action="<?php echo MainHelper::site_url('admin/setup/layout/header'); ?>">

	<div class="standard_form_header clearfix">
		<h1 class="pull_left"><?php echo $this->__('Header settings'); ?></h1>
	</div>
    	<div class="standard_form_elements clearfix">
                <div class="clearfix">
                    <label for="header_height"><?php echo $this->__('Height'); ?></label>
                    <span>
                            <input tabindex="1" id="header_height" name="header_height" type="text" value="<?php echo $header_height->Value; ?>" class="text_input" />
                    </span>
                </div> 
                <div class="standard_form_checks clearfix">
                    <label for="searchbar"><?php echo $this->__('Searchbar'); ?></label>
                        <span>
                            <div class="standard_form_checks_wrapper no-margin clearfix">
                                <input <?php echo $searchbar->Value == '1' ? "checked='checked'" : ''; ?> type="checkbox" name="searchbar" value="1" id="searchbar" />
                                <label for="searchbar" class="dst"><?php echo $this->__('On'); ?></label>
                            </div>
                        </span>
               </div>
                <div class="standard_form_info_header">
                        <h2><?php echo $this->__('Logo') ?></h2>
                </div>
                <div class="clearfix">
                    <label for="logo_title"><?php echo $this->__('Title'); ?></label>
                        <span>
                                <input tabindex="1" id="logo_title" name="logo_title" type="text" value="<?php echo $logo_title->Value; ?>" class="text_input" />
                        </span>
                </div>  
                <div class="profile_foto_edit bg_container container_image">
                    <label><?php echo 'Image' ; ?></label>
                    <div class="standard_form_photo mt2">       
                            <div class="ml2 standard_form_photo_action">
                                    <a id="layout_logo_uploader" rel="" class="button button_medium light_grey" href="javascript:void(0)"><?php echo $this->__('Upload Image'); ?></a>
                                    <input class="mt5 text_input" type="text" id="imageName_logo" name="layout_logo_uploader" value="<?php echo $logo_img->Value; ?>"/>
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
                                <input tabindex="1" id="logo_top" name="logo_top" type="text" value="<?php echo $logo_top->Value; ?>" class="text_input" />
                        </span>
                </div>       
                <div class="clearfix">
                    <label for="logo_left"><?php echo $this->__('Left'); ?></label>
                        <span>
                                <input tabindex="1" id="logo_left" name="logo_left" type="text" value="<?php echo $logo_left->Value; ?>" class="text_input" />
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
                <div class="profile_foto_edit bg_container container_image" <?php echo $bg_active->Value != 'image' ? "style='display:none'" : ''; ?>>
                    <label><?php echo 'Image' ; ?></label>
                    <div class="standard_form_photo mt2">       
                            <div class="ml2 standard_form_photo_action">
                                    <a id="layout_background_uploader" rel="" class="button button_medium light_grey" href="javascript:void(0)"><?php echo $this->__('Upload Image'); ?></a>
                                    <input class="mt5 text_input" type="text" id="imageName" name="layout_background_uploader" value="<?php echo $bg_img->Value; ?>"/>
                            </div>
                    </div>
                </div>    
                <div class="clearfix bg_container container_color" <?php echo $bg_active->Value != 'color' ? "style='display:none'" : ''; ?>>
                    <label for="header_color"><?php echo $this->__('Color'); ?></label>
                        <span>
                                <input tabindex="1" id="header_color" name="header_color" type="text" value="<?php echo $header_color->Value; ?>" class="text_input cp-basic bgbg" />
                                <div class="color_preview" style="background-color:<?php echo $header_color->Value; ?>"></div>
                        </span>
                </div> 
                <div class="clearfix bg_container container_gradient" <?php echo $bg_active->Value != 'gradient' ? "style='display:none'" : ''; ?>>
                    <label for="header_gradient_start"><?php echo $this->__('Gradient'); ?></label>
                        <span>
                            <div>
                                <input tabindex="1" id="header_gradient_start" name="header_gradient_start" type="text" value="<?php echo $header_startgradient->Value; ?>" class="text_input cp-basic" />
                                <div class="color_preview" style="background-color:<?php echo $header_startgradient->Value; ?>"></div>
                            </div>
                            <div>
                                <input tabindex="1" id="header_gradient_stop" name="header_gradient_stop" type="text" value="<?php echo $header_stopgradient->Value; ?>" class="text_input cp-basic" />
                                <div class="color_preview" style="background-color:<?php echo $header_stopgradient->Value; ?>"></div>
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