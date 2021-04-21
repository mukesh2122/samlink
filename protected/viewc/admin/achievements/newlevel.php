<form class="standard_form" method="post" action="<?php echo MainHelper::site_url('admin/achievements/newlevel'); ?>">

	<div class="standard_form_header clearfix">
		<h1 class="pull_left"><?php echo $this->__('New level settings'); ?></h1>
	</div>
	
	<div class="standard_form_elements clearfix">
		<div class="clearfix">
                    <label for="name"><?php echo $this->__('Name'); ?> </label>
                    <span>
                            <input tabindex="1" id="name" name="name" type="text" value="" class="text_input" />
                    </span>
		</div>
                
                <div class="clearfix">
                    <label for="desc"><?php echo $this->__('Description'); ?> </label>
                    <span>
                            <input tabindex="1" id="desc" name="desc" type="text" value="" class="text_input" />
                    </span>
		</div>
                 <div class="clearfix">
                    <label for="level"><?php echo $this->__('Level'); ?> </label>
                    <span>
                            <input tabindex="1" id="level" name="level" type="text" value="" class="text_input" />
                    </span>
		</div>
                           	
                <div class="clearfix">
                    <label for="points"><?php echo $this->__('Points'); ?> </label>
                    <span>
                            <input tabindex="1" id="points" name="points" type="text" value="" class="text_input" />
                    </span>
		</div>
                
                <div class="clearfix">
                    <label for="multiplier"><?php echo $this->__('Multiplier'); ?> </label>
                    <span>
                            <input tabindex="1" id="multiplier" name="multiplier" type="text" value="" class="text_input" />
                    </span>
		</div>           
		<div class="clearfix">
			<label for="achievement"><?php echo $this->__('Achievement'); ?></label>		
			<span>
				<select id="achievement" class="dropkick_lightWide" name="achievement" tabindex="7">
                                        <option value="0">
                                            <?php echo $this->__('Choose Parent') ?>
                                        </option>
                                        <?php foreach ($achievementList as $a): ?>
						<option value="<?php echo $a->ID_ACHIEVEMENT; ?>" >
							<?php echo $a->AchievementName; ?>
						</option>
					<?php endforeach; ?>
				</select>
			</span>
		</div>
               <div class="clearfix"> 
			<label><?php echo 'Image'; ?></label>
			<div class="standard_form_photo mt2">
                                    <input name="Filedata" type="file" />
                        </div>
               </div>
        </div> 
    
    	<div class="standard_form_footer clearfix">
		<input class="button button_auto light_blue pull_right" type="submit" value="<?php echo $this->__('Save Settings'); ?>" />
	</div>
</form>