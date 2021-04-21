<?php $reguserFields = MainHelper::GetModuleFieldsByTag('reguser'); ?> 
<?php $isEnabledTranslate = MainHelper::IsModuleEnabledByTag('translations'); ?>
<?php MainHelper::MakeValidation($reguserFields,'.F_FTUupdateProfile'); ?>


<!-- FTU form step 1 begin -->
<form method="POST" action="<?php echo MainHelper::site_url('players/updateprofile'); ?>" class="F_FTUupdateProfile">
	<div class="ftu_form yellow_box rounded_5">
		<!-- Header start -->
		<div class="box_header clearfix">
			<h3><?php echo $this->__('Please fill in your personal information (Required)'); ?></h3>
			<div class="ftu_form_steps">
				<a href="javascript:void(0)" class="current_step" rel="0">1</a>
				<a href="javascript:void(0)" class="ftu_form_step F_loadFTUStep" rel="1">2</a>
				<a href="javascript:void(0)" class="ftu_form_step F_loadFTUStep" rel="2">3</a>
				<a href="javascript:void(0)" class="ftu_form_step F_loadFTUStep" rel="3">4</a>
			</div>
		</div>
		<!-- Header end -->

		<input type="hidden" name="step" value="1" />

		<!-- Input start -->
		<div>
			<label for="firstName"><?php echo $this->__('First name'); ?></label>
			<span>
				<input id="firstName" name="firstName" type="text" value="<?php echo $user->FirstName; ?>" class="text_input" />
			</span>
		</div>

		<div>
			<label for="lastName"><?php echo $this->__('Last name'); ?></label>
			<span>
				<input id="lastName" name="lastName" type="text" value="<?php echo $user->LastName; ?>" class="text_input" />
			</span>
		</div>

		<div>
			<label for="displayName"><?php echo $this->__('Display name'); ?> <a href="javascript:void(0)" class="F_helpBubble" rel="<?php echo $this->__('Your display name is the name you choose to display on your profile. It can be your first name, full name, nickname or any combination. It can also be something completely different.').' '.$this->__('If you do not choose a display name, your nickname will be displayed by default.'); ?>">?</a></label>
			<span>
				<input id="displayName" name="displayName" type="text" value="<?php echo $user->DisplayName; ?>" class="text_input" />
			</span>
		</div>

		<div>
			<label for="city"><?php echo $this->__('City'); ?></label>
			<span>
				<input id="city" type="text" name="city" value="<?php echo $user->City; ?>" class="text_input" />
			</span>
		</div>

		<div class="clearfix">
			<label for="country"><?php echo $this->__('Country'); ?></label>
			<span class="clearfix">
				<select id="country" class="dropkick_lightWide" name="country" tabindex="1">
					<?php $countries = MainHelper::getCountryList($this->__('Choose your country')); ?>
					<?php foreach ($countries as $country): ?>
						<option value="<?php echo $country->A2; ?>" <?php echo ($user->Country == $country->A2) ? 'selected="selected"' : ''; ?>>
							<?php echo $country->Country; ?>
						</option>
					<?php endforeach; ?>
				</select>
			</span>
		</div>

		<div class="clearfix">
			<label for="timezone"><?php echo $this->__('Timezone'); ?></label>
			<span class="clearfix">
				<select id="timezone" class="dropkick_lightWide" name="timezone" tabindex="1">
					<?php $zones = MainHelper::getTimeZoneList($this->__('Choose your timezone')); ?>
					<?php foreach ($zones as $zone): ?>
						<option value="<?php echo $zone->ID_TIMEZONE; ?>" <?php echo ($user->ID_TIMEZONE == $zone->ID_TIMEZONE) ? 'selected="selected"' : ''; ?>>
							<?php echo $zone->TimeZoneText . ' ' . $zone->HelpText; ?>
						</option>
					<?php endforeach; ?>
				</select>
			</span>
		</div>

		<div class="clearfix add_langs">
			<input type="hidden" name="daylight" value="1" />
			<input class="dst" type="checkbox" id="dst" name="dst" value="1" <?php echo $user->DSTOffset == 3600 ? 'checked="checked"' : ''; ?> />
			<label for="dst"><?php echo $this->__('Daylight saving time'); ?></label>
		</div>

		<div class="date_of_birth clearfix">
			<label for="dob"><?php echo $this->__('Date of birth'); ?></label>
			<span class="clearfix">
				<select id="dobDay" class="dropkick_lightNarrow" name="day" tabindex="2">
					<?php $days = MainHelper::getDays($this->__('Day')); ?>
					<?php foreach($days as $c => $v): ?>
						<option value="<?php echo $c; ?>" <?php echo MainHelper::isDaySelected($user->DateOfBirth, $v) ? 'selected' : ''; ?>>
							<?php echo $v; ?>
						</option>
					<?php endforeach; ?>
				</select>
			</span>

			<span class="clearfix">
				<select id="dobMonth" class="dropkick_lightNarrow" name="month" tabindex="3">
					<?php $months = MainHelper::getMonthList($this->__('Month')); ?>
					<?php foreach($months as $c => $v): ?>
						<option value="<?php echo $c; ?>" <?php echo MainHelper::isMonthSelected($user->DateOfBirth, $c) ? 'selected' : ''; ?>>
							<?php echo $v; ?>
						</option>
					<?php endforeach; ?>
				</select>
			</span>

			<span class="clearfix">
				<select id="dobYear" class="dropkick_lightNarrow" name="year" tabindex="4">
					<?php $years = MainHelper::getYears($this->__('Year')); ?>
					<?php foreach($years as $c => $v): ?>
						<option value="<?php echo $c; ?>" <?php echo MainHelper::isYearSelected($user->DateOfBirth, $v) ? 'selected' : ''; ?>>
							<?php echo $v; ?>
						</option>
					<?php endforeach; ?>
				</select>
			</span>
		</div>

		<?php if ($isEnabledTranslate==1): ?>
		<div class="clearfix">
			<label for="language"><?php echo $this->__('Site language'); ?> <a href="javascript:void(0)" class="F_helpBubble" rel="<?php echo $this->__('Your site language is the language in which you want to view the site. The default is English. If any content has not been translated into your site language, the English version will be displayed.'); ?>">?</a></label>
			<span class="clearfix">
				<select id="language" class="dropkick_lightWide" name="mainLanguage" tabindex="5">
					<?php $langs = Lang::getLanguages(); ?>
					<?php foreach ($langs as $lang): ?>
						<option value="<?php echo $lang->ID_LANGUAGE; ?>" <?php echo $user->ID_LANGUAGE == $lang->ID_LANGUAGE ? 'selected' : ''; ?>>
							<?php echo $lang->NativeName; ?>
						</option>
					<?php endforeach; ?>
				</select>
			</span>
		</div>


		<label><?php echo $this->__('Additional Content Languages'); ?> <a href="javascript:void(0)" class="F_helpBubble" rel="<?php echo $this->__('You have the option to select a number of additional content languages. If our content has not been translated into your site language, it may be available in other languages that you prefer.') . ' ' . $this->__('You will get the option to choose between the available languages that you have selected.'); ?>">?</a></label>
		<div class="add_langs">
			<div class="clearfix">
				<?php $x = 1; ?>
				<?php $addLangs = explode(',', $user->OtherLanguages); ?>
				<?php foreach ($langs as $lang): ?>
					<input class="updatePlayerLang" type="checkbox" id="alang_<?php echo $lang->ID_LANGUAGE; ?>" name="addLanguage" value="<?php echo $lang->ID_LANGUAGE; ?>" <?php echo in_array($lang->ID_LANGUAGE, $addLangs) ? 'checked="checked"' : ''; ?> />
					<label for="alang_<?php echo $lang->ID_LANGUAGE; ?>"><?php echo $lang->NativeName; ?></label>
					<?php if ($x % 4 == 0) {
						echo '</div><div class="clear"></div><div class="clearfix">';
					}; ?>
				<?php $x++; ?>
				<?php endforeach; ?>
			</div>
		</div>
		<?php endif; ?>

		<?php
			$extrafields = MainHelper::GetExtraFieldsByOwnertype('player',$user->ID_PLAYER);
			MainHelper::RenderExtrafields($extrafields,$this,''); 
		?>
		<?php
			$categories = MainHelper::GetPlayerCategories('player');
			MainHelper::RenderCategories($categories,$this,'',$user->ID_PLAYER);
		?>


		<label><?php echo $this->__('Personal Avatar'); ?></label>
		<div class="personal_avatar clearfix">
			<span class="F_profileImage100x100">
				<?php echo MainHelper::showImage($user, THUMB_LIST_100x100, false, array('width', 'no_img' => 'noimage/no_player_100x100.png'));?>
			</span>
			<span>
				<p>
					<?php echo $this->__('Use PNG, GIF or JPG format'); ?><br />
					<?php echo $this->__('Max. window size: 200x300px'); ?>
				</p>
				<a id="uploadProfilePhoto" class="button button_large light_green" href="javascript:void(0)"><?php echo $this->__('Upload Image'); ?></a>
			</span>
		</div>
		<!-- Input end -->
	</div>
	<div class="ftu_form_footer clearfix">
		<input class="button button_medium light_blue fr" type="submit" value="<?php echo $this->__('Next'); ?>" />
	</div>
</form>
<!-- FTU form step 1 end -->
<script type="text/javascript">loadCheckboxes();</script>
