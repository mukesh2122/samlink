<?php echo $this->__('New update to your ticket'); ?> '<?php echo $bugreport->ErrorName; ?>'

<?php echo $this->__('Here is a run down of the changes:'); ?>
<?php echo strip_tags($changed); ?>

<?php echo $this->__('Respond to your ticket here:') ?> <?php echo MainHelper::site_url('players/feedback/edit/'.$bugreport->ID_ERROR); ?>

--
<?php echo $this->__('PlayNation Team'); ?>
