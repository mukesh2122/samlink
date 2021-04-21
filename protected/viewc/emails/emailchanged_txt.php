<?php echo $this->__('Thank you for registering to become a PlayNation member!

Logging in to the PlayNation website are just a few clicks away. Before you can proceed you will need to click the following link, within 24 hours, to activate your account:') ?>
<?php echo MainHelper::site_url('login/activate/'.$player->VerificationCode);?>


<?php echo $this->__('You have registered with this email:') ?> <?php echo $player->EMail;?>

<?php echo $this->__('Your password is not included in this email for security reasons. If you loose or forget your password, you can have your password reset via the login form.') ?>

<?php echo $this->__('If you have any problems activating your account, please contact our customer support at support@playnation.eu') ?>

<?php echo $this->__('Thank you!') ?>

--
<?php echo $this->__('The PlayNation Team') ?>
