<?php echo $this->__('Filled:') ?>

<?php echo $this->__('What`s your name?') ?>
<?php echo $rec['name']; ?>


<?php echo $this->__('How old are you?') ?>
<?php echo $rec['age']; ?>


<?php echo $this->__('What`s your eMail?') ?>
<?php echo $rec['email']; ?>


<?php echo $this->__('Link(s) to your portfolio and earlier work') ?>
<?php echo $rec['links']; ?>


<?php echo $this->__('Write a bit about your self, a short application and the reason for applying') ?>
<?php echo $rec['description']; ?>



<?php echo $this->__('User information') ?>

<?php echo $this->__('ID:') ?> <?php echo $user->ID_PLAYER; ?>
<?php echo $this->__('Email:') ?> <?php echo $user->EMail; ?>
<?php echo $this->__('DOB:') ?> <?php echo $user->DateOfBirth; ?>
<?php echo $this->__('Display name:') ?> <?php echo $user->DisplayName; ?>
<?php echo $this->__('Country:') ?> <?php echo $user->Country; ?>
<?php echo $this->__('City:') ?> <?php echo $user->City; ?>
