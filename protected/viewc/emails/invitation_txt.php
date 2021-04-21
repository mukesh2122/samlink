<?php echo $player->DisplayName; ?> <?php echo $this->__('invited you to join PlayNation') ?>

<?php echo MainHelper::site_url('registration/'.urlencode($invitation->EMail)); ?>

--
<?php echo $this->__('PlayNation Team') ?>
