<form class="standard_form" method="post" action="<?php echo MainHelper::site_url('admin/campaigns/newcampaign'); ?>">

	<div class="standard_form_header clearfix">
		<h1 class="pull_left"><?php echo $this->__('New Campaign'); ?></h1>
	</div>
	 
	<div class="standard_form_elements clearfix">
                <div class="clearfix">
                    <label for="advertiser_name"><?php echo $this->__('Advertiser Name'); ?></label>
                    <span>
                            <input tabindex="1" id="advertiser_name" name="advertiser_name" type="text" value="" class="text_input" />
                    </span>
                </div>
		<div class="clearfix">
			<label for="country"><?php echo $this->__('Country') ?></label>		
			<span>
				<select id="country" class="dropkick_lightWide" name="country" tabindex="2">
                                        <option value="0">
                                            <?php echo $this->__('Choose Country'); ?>
                                        </option>
                                        <?php foreach ($countries as $country): ?>
						<option value="<?php echo $country->ID_COUNTRY; ?>" >
							<?php echo $country->Country; ?>
						</option>
					<?php endforeach; ?>
				</select>
			</span>
		</div> 
                <div class="clearfix">
			<label for="language"><?php echo $this->__('Language') ?></label>		
			<span>
				<select id="language" class="dropkick_lightWide" name="language" tabindex="3">
                                        <option value="0" >
                                            <?php echo $this->__('Choose Language'); ?>
                                        </option>
                                        <?php foreach ($languages as $language): ?>
						<option value="<?php echo $language->ID_LANGUAGE; ?>" >
							<?php echo $language->EnglishName; ?>
						</option>
					<?php endforeach; ?>
				</select>
			</span>
		</div> 
                <div class="standard_form_info_header">
                        <h2><?php echo $this->__('Campaign duration') ?></h2>
		</div>
                <div class="standard_form_dob clearfix">
			<label for="csYear"><?php echo $this->__('Campaign start'); ?></label>
			<span>
				<select id="csYear" class="dropkick_lightNarrow" name="csyear" tabindex="6">
					<?php $years = MainHelper::getYears(); ?>
                                        <?php $curYear = date('Y'); ?>
					<?php foreach ($years as $c => $v): ?>
						<option <?php echo $v == $curYear ? 'selected="selected"' : '' ?> value="<?php echo $c; ?>">
							<?php echo $v; ?>
						</option>
					<?php endforeach; ?>
				</select>
			</span>	
			
			<span>
				<select id="csMonth" class="dropkick_lightNarrow" name="csmonth" tabindex="7">
					<?php $months = MainHelper::getMonthList(); ?>
                                        <?php $curMonth = date('M'); ?>
					<?php foreach ($months as $c => $v): ?>
						<option <?php echo $v == $curMonth ? 'selected="selected"' : '' ?> value="<?php echo $c; ?>" >
							<?php echo $v; ?>
						</option>
					<?php endforeach; ?>
				</select>
			</span>

			<span>
				<select id="csDay" class="dropkick_lightNarrow" name="csday" tabindex="8">
					<?php $days = MainHelper::getDays(); ?>
                                        <?php $curDay = date('d'); ?>
					<?php foreach ($days as $c => $v): ?>
						<option <?php echo $v == $curDay ? 'selected="selected"' : '' ?> value="<?php echo $c; ?>" >
							<?php echo $v; ?>
						</option>
					<?php endforeach; ?>
				</select>
			</span>
		</div>
                <div class="standard_form_dob clearfix">
			<label for="ceYear"><?php echo $this->__('Campaign stop'); ?></label>
			<span>
				<select id="ceYear" class="dropkick_lightNarrow" name="ceyear" tabindex="9">
					<?php foreach ($years as $c => $v): ?>
						<option value="<?php echo $c; ?>" >
							<?php echo $v; ?>
						</option>
					<?php endforeach; ?>
				</select>
			</span>	
			<span>
				<select id="ceMonth" class="dropkick_lightNarrow" name="cemonth" tabindex="10">
					<?php foreach ($months as $c => $v): ?>
						<option value="<?php echo $c; ?>" >
							<?php echo $v; ?>
						</option>
					<?php endforeach; ?>
				</select>
			</span>

			<span>
				<select id="ceDay" class="dropkick_lightNarrow" name="ceday" tabindex="11">
					<?php foreach ($days as $c => $v): ?>
						<option value="<?php echo $c; ?>" >
							<?php echo $v; ?>
						</option>
					<?php endforeach; ?>
				</select>
			</span>
		</div>
                <div class="standard_form_checks clearfix">
        <label for="enddate"><?php echo $this->__('No end date'); ?></label>
        <span>
            <div class="standard_form_checks_wrapper no-margin clearfix">
                    <input type="checkbox" name="enddate" value="0" id="top">
            </div>
        </span>
    </div>
        </div>                  
	<div class="standard_form_footer clearfix">
		<input class="button button_auto light_blue pull_right" type="submit" value="<?php echo $this->__('Save Settings'); ?>" />
	</div>
</form>
<script type="text/javascript">loadCheckboxes();</script>