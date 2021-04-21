<?php echo $player->DisplayName; ?> <?php echo $this->__('has created') ?> '<?php echo $bugreport->ErrorName; ?>'

See it here: <?php echo MainHelper::site_url('admin/bugreports/edit/'.$bugreport->ID_ERROR); ?>

--
<?php echo $this->__('PlayNation Team') ?>
