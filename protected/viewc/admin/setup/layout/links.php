<?php
    $layout = new Layout();

    $link_default = $layout->getActiveLayout('link_defaultcolor');
    $link_hover = $layout->getActiveLayout('link_hovercolor');
    $link_active = $layout->getActiveLayout('link_activecolor');
    $link_visited = $layout->getActiveLayout('link_visitedcolor');
?>

<?php echo $this->renderBlock('admin/setup/layout/common/infobox'); ?>

<form class="standard_form" method="post" action="<?php echo MainHelper::site_url('admin/setup/layout/links'); ?>">

	<div class="standard_form_header clearfix">
		<h1 class="pull_left"><?php echo $this->__('Links settings'); ?></h1>
	</div>

	<div class="standard_form_elements clearfix">
                    <div class="standard_form_info_header">
                <h2><?php echo $this->__('Color settings') ?></h2>
        </div>
                <div class="clearfix">
                    <label for="link"><?php echo $this->__('Default'); ?></label>
                    <span>
                            <input tabindex="1" id="link" name="link" type="text" value="<?php echo $link_default->Value; ?>" class="text_input" />
                    </span>
                </div>
                <div class="clearfix">
                    <label for="hover"><?php echo $this->__('Hover'); ?></label>
                    <span>
                            <input tabindex="2" id="hover" name="hover" type="text" value="<?php echo $link_hover->Value; ?>" class="text_input" />
                    </span>
                </div>
                <div class="clearfix">
                    <label for="active"><?php echo $this->__('Active'); ?></label>
                    <span>
                            <input tabindex="3" id="active" name="active" type="text" value="<?php echo $link_active->Value; ?>" class="text_input" />
                    </span>
                </div>
                <div class="clearfix">
                    <label for="visited"><?php echo $this->__('Visited'); ?></label>
                    <span>
                            <input tabindex="4" id="visited" name="visited" type="text" value="<?php echo $link_visited->Value; ?>" class="text_input" />
                    </span>
                </div>
                
        </div>                  
	<div class="standard_form_footer clearfix">
		<input class="button button_auto light_blue pull_right" type="submit" value="<?php echo $this->__('Save Settings'); ?>" />
	</div>
</form>