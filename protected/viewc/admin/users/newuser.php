<?php 
	$query = "SELECT EMail FROM sn_players";
	$rs = Doo::db()->query($query)->fetchall();
	$jstable = "";
	$c = "";
	foreach ($rs as $r)
	{
		$jstable .= $c."'".$r['EMail']."'";
		$c = ",";
	}

?>

<form class="standard_form" method="post" action="<?php echo MainHelper::site_url('admin/users/newuser'); ?>">

	<div class="standard_form_header clearfix">
		<h1 class="pull_left"><?php echo $this->__('New user Account Settings'); ?></h1>
	</div>
	
	<div class="standard_form_elements clearfix">
		<div class="clearfix">
			<label for="email"><?php echo $this->__('E-Mail'); ?> </label>
			<span>
				<input tabindex="1" id="email" name="email" type="text" value="" class="text_input" />
			</span>
		</div>
		
		<div class="clearfix">
			<label for="firstName"><?php echo $this->__('First name'); ?></label>
			<span>
				<input tabindex="2" id="firstName" name="firstName" type="text" value="" class="text_input" />
			</span>
		</div>
		
		<div class="clearfix">
			<label for="lastName"><?php echo $this->__('Last name'); ?></label>
			<span>
				<input tabindex="3" id="lastName" name="lastName" type="text" value="" class="text_input" />
			</span>
		</div>
		
		<div class="clearfix">
			<label for="nickname"><?php echo $this->__('Nickname'); ?></label>
			<span>
				<input tabindex="4" id="nickname" name="nickname" type="text" value="" class="text_input" />
			</span>
		</div>
		
		<div class="clearfix">
			<label for="displayName"><?php echo $this->__('Display name'); ?></label>
			<span>
				<input tabindex="5" id="displayName" name="displayName" type="text" value="" class="text_input" />
			</span>
		</div>
		<?php if (1==2): ?>
		<div class="standard_form_dob clearfix">
			<label for="dob"><?php echo $this->__('Date of birth'); ?></label>
			<span>
				<select id="dobYear" class="dropkick_lightNarrow" name="year" tabindex="6">
					<?php $years = MainHelper::getYears(); ?>
					<?php foreach ($years as $c => $v): ?>
						<option value="<?php echo $c; ?>" >
							<?php echo $v; ?>
						</option>
					<?php endforeach; ?>
				</select>
			</span>	
			
			<span>
				<select id="dobMonth" class="dropkick_lightNarrow" name="month" tabindex="7">
					<?php $months = MainHelper::getMonthList(); ?>
					<?php foreach ($months as $c => $v): ?>
						<option value="<?php echo $c; ?>" >
							<?php echo $v; ?>
						</option>
					<?php endforeach; ?>
				</select>
			</span>

			<span>
				<select id="dobDay" class="dropkick_lightNarrow" name="day" tabindex="8">
					<?php $days = MainHelper::getDays(); ?>
					<?php foreach ($days as $c => $v): ?>
						<option value="<?php echo $c; ?>" >
							<?php echo $v; ?>
						</option>
					<?php endforeach; ?>
				</select>
			</span>
		</div>
		<?php endif; ?>

		<div class="clearfix">
			<label for="city"><?php echo $this->__('City'); ?></label>
			<span>
				<input tabindex="9" id="city" type="text" name="city" value="" class="text_input" />
			</span>
		</div>

		<div class="clearfix">
			<label for="country"><?php echo $this->__('Country'); ?></label>
			<span>
				<select id="country" class="dropkick_lightWide" name="country" tabindex="10">
					<?php $countries = MainHelper::getCountryList(); ?>
					<?php foreach ($countries as $country): ?>
						<option value="<?php echo $country->A2; ?>" >
							<?php echo $country->Country; ?>
						</option>
					<?php endforeach; ?>
				</select>
			</span>
		</div>
		
		<div class="clearfix">
			<label for="address"><?php echo $this->__('Address'); ?></label>
			<span>
				<input tabindex="11" id="address" name="address" type="text" value="" class="text_input" />
			</span>
		</div>
		
		<div class="clearfix">
			<label for="zip"><?php echo $this->__('Zip'); ?></label>
			<span>
				<input tabindex="12" id="zip" name="zip" type="text" value="" class="text_input" />
			</span>
		</div>
		
		<div class="clearfix">
			<label for="phone"><?php echo $this->__('Phone'); ?></label>
			<span>
				<input tabindex="13" id="phone" name="phone" type="text" value="" class="text_input" />
			</span>
		</div>
		
		<div class="standard_form_info_header">
			<h2><?php echo $this->__('Password settings') ?></h2>
		</div>
		
		<div class="clearfix">
			<label for="password"><?php echo $this->__('Password'); ?></label>
			<span>
				<input tabindex="14" id="pass" name="password" type="text" value="" class="text_input" />
			</span>
		</div>
		
		<?php if (1==2): ?>
		<div class="standard_form_info_header">
			<h2><?php echo $this->__('Permission settings') ?></h2>
		</div>
		
		<div class="clearfix">
			<label for="group"><?php echo $this->__('Permission Group'); ?></label>
			<span>
				<select id="group" class="dropkick_lightWide" name="usergroup" tabindex="15">
					<?php $groups = Doo::conf()->userGroups; ?>
					<?php foreach ($groups as $key=>$group): ?>
						<option value="<?php echo $key; ?>" >
							<?php echo $group['label']; ?>
						</option>
					<?php endforeach; ?>
				</select>
			</span>
		</div>
		
		<div class="standard_form_info_header">
			<h2><?php echo $this->__('Timezone settings') ?></h2>
			<p><?php echo $this->__('Change timezone and daylight saving time settings.'); ?></p>
		</div>

		<div class="clearfix">
			<label for="ID_TIMEZONE"><?php echo $this->__('Timezone'); ?></label>
			<span>
				<select id="ID_TIMEZONE" class="dropkick_lightWide" name="ID_TIMEZONE" tabindex="16">
					<?php $zones = MainHelper::getTimeZoneList(); ?>
					<?php foreach ($zones as $zone): ?>
						<option value="<?php echo $zone->ID_TIMEZONE; ?>" >
							<?php echo $zone->TimeZoneText . ' ' . $zone->HelpText; ?>
						</option>
					<?php endforeach; ?>
				</select>
			</span>
		</div>

		<div class="standard_form_checks clearfix">
			<label><?php echo $this->__('Daylight saving time'); ?></label>
			<span>
				<div class="standard_form_checks_wrapper no-margin clearfix">
					<input type="hidden" name="daylight" value="1" />
					<input tabindex="17" class="dst" type="checkbox" id="dst" name="dst" value="1"  /> 
					<label for="dst"><?php echo $this->__('Yes'); ?></label>
				</div>
			</span>
		</div>
		
		<div class="standard_form_info_header">
			<h2><?php echo $this->__('Language settings') ?></h2>
			<p><?php echo $this->__('Change language settings.'); ?></p>
		</div>

		<div class="clearfix">
			<label for="language"><?php echo $this->__('Site language'); ?></label>
			<span>
				<select id="language" class="dropkick_lightWide" name="mainLanguage" tabindex="18">
					<?php $langs = Lang::getLanguages(); ?>
					<?php foreach ($langs as $lang): ?>
						<option value="<?php echo $lang->ID_LANGUAGE; ?>" >
							<?php echo $lang->NativeName; ?>
						</option>
					<?php endforeach; ?>
				</select>
			</span>
		</div>

		<div class="standard_form_checks clearfix">
			<label><?php echo $this->__('Additional languages'); ?></label>
			<?php foreach ($langs as $lang): ?>
				<div class="standard_form_checks_wrapper no-margin clearfix">
					<input class="updatePlayerLang" type="checkbox" id="alang_<?php echo $lang->ID_LANGUAGE; ?>" name="addLangs[]" value="<?php echo $lang->ID_LANGUAGE; ?>"  /> 
					<label for="alang_<?php echo $lang->ID_LANGUAGE; ?>"><?php echo $lang->NativeName; ?></label>
				</div>
			<?php endforeach; ?>
		</div>
		
		<div class="standard_form_info_header">
			<h2><?php echo $this->__('Profile photo') ?></h2>
			<p><?php echo $this->__('Change profile photo. Use PNG, GIF or JPG with a max. window size at 200x300px.'); ?></p>
		</div>

		<div class="profile_foto_edit clearfix">
			<label><?php echo $this->__('Profile photo'); ?></label>
			<div class="standard_form_photo clearfix">
				<input type="hidden" id="user" value="" />
				<div class="standard_form_photo_action">
					<a id="uploadProfilePhotoAdm" class="button button_medium light_grey" href="javascript:void(0)"><?php echo $this->__('Upload Photo'); ?></a>
					<p><?php echo $this->__('Use PNG, GIF or JPG.') ?>
					<br /><?php echo $this->__('Max. window size at 200x300px.') ?></p>
				</div>
			</div>
		</div>
		<?php endif; ?>
		
		<?php if (1==2): ?>
		<div class="standard_form_info_header">
			<h2><?php echo $this->__('Referrer settings') ?></h2>
			<p><?php echo $this->__('Use integer values for percentage'); ?></p>
		</div>
		<div class="standard_form_checks clearfix">
			<label><?php echo $this->__('Enabled'); ?></label>
			<span>
				<div class="standard_form_checks_wrapper no-margin clearfix">
					<input tabindex="17" class="dst" type="checkbox" id="isReferrer" name="isReferrer" value="1"  /> 
					<label for="isReferrer"><?php echo $this->__('Yes'); ?></label>
				</div>
			</span>
		</div>
		<div class="standard_form_checks clearfix">
			<label><?php echo $this->__('Can Create SubReferrers'); ?></label>
			<span>
				<div class="standard_form_checks_wrapper no-margin clearfix">
					<input tabindex="18" class="dst" type="checkbox" id="canCreateReferrers" name="canCreateReferrers" value="1"  /> 
					<label for="canCreateReferrers"><?php echo $this->__('Yes'); ?></label>
				</div>
			</span>
		</div>
		<div class="clearfix">
			<label for="referrerName"><?php echo $this->__('Display Name'); ?></label>
			<span>
				<input tabindex="19" id="referrerName" name="referrerName" type="text" value="" class="text_input" />
			</span>
		</div>
		<div class="clearfix">
			<label for="comission"><?php echo $this->__('Commission'); ?></label>
			<span>
				<input tabindex="19" id="comission" name="comission" type="text" value="" class="text_input" />
			</span>
		</div>
		<?php endif; ?>

	</div>

	<div class="standard_form_footer clearfix">
		<input onclick="a=[<?php echo $jstable; ?>];for(var i in a){if (email.value==a[i]){alert(email.value+' already exists..');return false}};" class="button button_auto light_blue pull_right" type="submit" value="<?php echo $this->__('Add user'); ?>" />
	</div>
		
</form>
<script type="text/javascript">loadCheckboxes();</script>
