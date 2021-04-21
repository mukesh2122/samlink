<?php echo $this->__('Reset your password.

A request to reset your password for your PlayNation account has been made.
If you did not make this request, please ignore this email.

To reset your password, click on the link below:') ?>

<?php echo MainHelper::site_url('login/reset-password/'.$player->PassRequest);?>

<?php echo $this->__('If you have any problems resetting your password, please contact our customer support at support@playnation.eu') ?>

--
<?php echo $this->__('PlayNation Team') ?>
