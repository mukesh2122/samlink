<?php
	$facebook = Layout::getActiveLayout('siteinfo_social_facebook');
	$twitter = Layout::getActiveLayout('siteinfo_social_twitter');
	$linkedin = Layout::getActiveLayout('siteinfo_social_linkedin');
	$name = Layout::getActiveLayout('siteinfo_site_name');
	$ageLimit = Layout::getActiveLayout('siteinfo_age_limit');
	$creator = Layout::getActiveLayout('siteinfo_register_creator');
	$approver = Layout::getActiveLayout('siteinfo_register_approver');
?>

<?php echo $this->renderBlock('admin/setup/layout/common/infobox'); ?>

<form class="standard_form" method="post" action="<?php echo MainHelper::site_url('admin/setup/siteinfo'); ?>">
	<div class="standard_form_header clearfix">
		<h1 class="pull_left"><?php echo $this->__('Site info'); ?></h1>
	</div>
	<div class="standard_form_elements clearfix">
		<div class="clearfix">
			<label for="name"><?php echo $this->__('Site Name'); ?></label>
			<span>
				<input tabindex="1" id="name" name="name" type="text" value="<?php echo $name->Value; ?>" class="text_input" />
			</span>
		</div>
		<div class="clearfix">
			<label for="agelimit"><?php echo $this->__('Age Limit'); ?></label>
			<span>
				<input tabindex="2" id="agelimit" name="agelimit" type="text" value="<?php echo (!empty($agelimit) ? $ageLimit->Value : ''); ?>" class="text_input" />
			</span>
		</div>
		
		<div class="standard_form_info_header">
			<h2><?php echo $this->__('Registration method') ?></h2>
		</div>
		<div class="standard_form_checks clearfix bg_choser">
			<label for="creator"><?php echo $this->__('Creator'); ?></label>
			<span>
				<div class="standard_form_checks_wrapper clearfix">
					<input tabindex="3" type="radio" <?php echo (!empty($creator) && $creator->Value == 'admin' ? 'checked="checked"' : ''); ?> class="creator" name="creator" value="admin" id="cr_admin" />
					<label for="admin" class="dst"><?php echo $this->__('Admin'); ?></label>
					<input type="radio" <?php echo (!empty($creator) && $creator->Value == 'user' ? 'checked="checked"' : ''); ?> class="creator" name="creator" value="user" id="cr_user" />
					<label for="user" class="dst"><?php echo $this->__('User'); ?></label>
				</div>
			</span>
		</div>
		<div class="standard_form_checks clearfix bg_choser">
			<label for="approver"><?php echo $this->__('Approver'); ?></label>
			<span>
				<div class="standard_form_checks_wrapper clearfix">
					<input tabindex="4" type="radio" <?php echo (!empty($approver) && $approver->Value == 'admin' ? 'checked="checked"' : ''); ?> class="approver" name="approver" value="admin" id="ap_admin" />
					<label for="admin" class="dst"><?php echo $this->__('Admin'); ?></label>
					<input type="radio" <?php echo (!empty($approver) && $approver->Value == 'user' ? 'checked="checked"' : ''); ?> class="approver" name="approver" value="user" id="ap_user" />
					<label for="user" class="dst"><?php echo $this->__('User'); ?></label>
					<input type="radio" <?php echo (!empty($approver) && $approver->Value == 'none' ? 'checked="checked"' : ''); ?> class="approver" name="approver" value="none" id="ap_user" />
					<label for="user" class="dst"><?php echo $this->__('None'); ?></label>
				</div>
			</span>
		</div>

		<div class="standard_form_info_header">
			<h2><?php echo $this->__('Account settings') ?></h2>
		</div>
		<div class="clearfix">
			<label for="facebook"><?php echo $this->__('Facebook'); ?></label>
			<span>
				<input tabindex="5" id="facebook" name="facebook" type="text" value="<?php echo $facebook->Value; ?>" class="text_input" />
			</span>
		</div>
		<div class="clearfix">
			<label for="twitter"><?php echo $this->__('Twitter'); ?></label>
			<span>
				<input tabindex="6" id="twitter" name="twitter" type="text" value="<?php echo $twitter->Value; ?>" class="text_input" />
			</span>
		</div>
		<div class="clearfix">
			<label for="linkedin"><?php echo $this->__('Linked In'); ?></label>
			<span>
				<input tabindex="7" id="linkedin" name="linkedin" type="text" value="<?php echo $linkedin->Value; ?>" class="text_input" />
			</span>
		</div>   
	</div>                  
	<div class="standard_form_footer clearfix">
		<input class="button button_auto light_blue pull_right button_span_left" name="save_button" type="submit" value="<?php echo $this->__('Save settings'); ?>" />
		<input class="button button_auto red pull_right" type="submit" name="reset_button" value="<?php echo $this->__('Reset to default'); ?>" />
	</div>
</form>
<script type="text/javascript">loadCheckboxes();</script>


