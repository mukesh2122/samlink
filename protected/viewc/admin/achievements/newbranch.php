<form class="standard_form" method="post" action="<?php echo MainHelper::site_url('admin/achievements/newbranch'); ?>">

	<div class="standard_form_header clearfix">
		<h1 class="pull_left"><?php echo $this->__('New branch settings'); ?></h1>
	</div>
	
	<div class="standard_form_elements clearfix">
		<div class="clearfix">
                    <label for="name"><?php echo $this->__('Name'); ?> </label>
                    <span>
                            <input tabindex="1" id="name" name="name" type="text" value="" class="text_input" />
                    </span>
		</div>
                
                <div class="clearfix">
                    <label for="desc"><?php echo $this->__('Desciption'); ?> </label>
                    <span>
                            <input tabindex="1" id="desc" name="desc" type="text" value="" class="text_input" />
                    </span>
		</div>
        </div> 
    
    	<div class="standard_form_footer clearfix">
		<input class="button button_auto light_blue pull_right" type="submit" value="<?php echo $this->__('Save Settings'); ?>" />
	</div>
</form>
<script type="text/javascript">loadCheckboxes();</script>