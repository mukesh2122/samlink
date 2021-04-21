<?php
$user = User::getUser();
?>
<h1 class="mb10"><?php echo $this->__('PlayNation is recruiting'); ?></h1>
<p>
	<?php echo $this->__('PlayNation is developing constantly and we are always looking for qualified individuals who wants to become a part of the [_1]PlayNation Team[_2].', array('<a href="' . MainHelper::site_url('group/playnation-team') . '">', '</a>')); ?><br />
	<?php echo $this->__('So if you have what it takes to be a great forum moderator or E-Sport manager, or you simply need to share your knowledge and help the crew build even better features, please contact us.'); ?><br />
	<?php echo $this->__('Regardless of who you are and what you do, we always treasure input and opinions. But we still value a helping hand and a solid partner more.'); ?><br />
	<?php echo $this->__('If you see code like Neo or the world presents itself to you in CMYK colors or wireframes, we want you!'); ?>
</p>

<div class="errorContainer dn"></div>

<form class="standard_form mt30 mb120 pt20" method="post" id="recFormPage" action="<?php echo MainHelper::site_url('recruit'); ?>">

	<div class="standard_form_elements clearfix">

		<div class="clearfix">
			<label for="name"><?php echo $this->__("What's your name?"); ?></label>
			<span>
				<input tabindex="1" id="name" name="name" type="text" value="<?php // echo $user->FirstName . ' ' . $user->LastName;  ?>" class="text_input" />
			</span>
		</div>

		<div class="clearfix">
			<label for="age"><?php echo $this->__('How old are you?'); ?></label>
			<span>
				<input tabindex="2" id="age" name="age" type="text" value="<?php // echo PlayerHelper::calculateAge($user->DateOfBirth);  ?>" class="text_input" />
			</span>
		</div>

		<div class="clearfix">
			<label for="email"><?php echo $this->__("What's your eMail?"); ?></label>
			<span>
				<input tabindex="2" id="email" name="email" type="text" value="<?php // echo $user->EMail;  ?>" class="text_input" />
			</span>
		</div>

		<div class="clearfix">
			<label for="links" class="db"><?php echo $this->__("Link(s) to your portfolio and earlier work"); ?></label>
			<span>
				<textarea id="links" rows="3" name="links" class="text_input w100 ha"></textarea>
			</span>
		</div>

		<div class="clearfix">
			<label for="description" class="db"><?php echo $this->__("Write a bit about your self, a short application and the reason for applying"); ?></label>
			<span>
				<textarea id="description" rows="8" name="description" class="text_input w100 ha"></textarea>
			</span>
		</div>

	</div>

	<div class="standard_form_footer clearfix">
		<input class="button button_auto light_blue pull_right" type="submit" value="<?php echo $this->__('Send'); ?>" />
	</div>

</form>