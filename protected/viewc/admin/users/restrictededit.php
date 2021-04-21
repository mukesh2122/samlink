<form class="standard_form" method="post" action="<?php echo MainHelper::site_url('admin/users/edit/'.$user->ID_PLAYER); ?>">

	<div class="standard_form_header clearfix">
		<h1 class="pull_left"><?php echo $this->__('Account Settings'); ?></h1>
		<span class="pull_right standard_form_header_info">- <?php echo $this->__('Registered'); ?>: <?php echo date(DATE_SHORT, $user->RegistrationTime); ?> - <?php echo $user->Credits;?> / <?php echo $user->PlayCredits;?></span>
	</div>

	<div class="standard_form_elements clearfix">
		<div class="standard_form_info_header">
			<h2><?php echo $this->__('Permission settings') ?></h2>
		</div>

		<div class="clearfix">
			<label for="group"><?php echo $this->__('Permission Group'); ?></label>
			<span>
				<select id="group" class="dropkick_lightWide" name="usergroup" tabindex="15">
					<?php $groups = Doo::conf()->userGroups; ?>
					<?php foreach ($groups as $key=>$group): ?>
						<?php if(strpos(',0,3,4,5,', ','.$key.',') !== FALSE): ?>
							<option value="<?php echo $key; ?>" <?php echo ($user->ID_USERGROUP == $key) ? 'selected="selected"' : ''; ?>>
								<?php echo $group['label']; ?>
							</option>
						<?php endif; ?>
					<?php endforeach; ?>
				</select>
			</span>
		</div>
                <div class="clearfix">
			<label for="hasBlog"><?php echo $this->__('Is Blogger'); ?></label>
			<span>
				<input type="checkbox" id="hasBlog" class="dst" name="hasBlog" tabindex="16" value="1" <?php echo ($user->hasBlog == 1) ? 'checked="checked"' : ''; ?> />
                                <input type="hidden" id="blogger" name="blogger" value="1" />
			</span>
		</div>
	</div>

	<div class="standard_form_footer clearfix">
		<input class="button button_auto light_blue pull_right" type="submit" value="<?php echo $this->__('Save Settings'); ?>" />
	</div>

</form>
<script type="text/javascript">loadCheckboxes();</script>