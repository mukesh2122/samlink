<?php

include('openinviter.php');

$inviter = new OpenInviter();
$oi_services = $inviter->getPlugins();

$ers = array();
$oks = array();
$import_ok = false;
$done = false;
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
	if ($step == 'get_contacts') {
		$inviter->startPlugin($_POST['provider_box']);
		$internal = $inviter->getInternalError();

		$contacts = $inviter->getMyContacts();

		$_POST['oi_session_id'] = $inviter->plugin->getSessionID();
		$_POST['message_box'] = '';

		$inviter->startPlugin($_POST['provider_box']);

		if ($inviter->showContacts()) {
			$count = 0;
			foreach ($contacts as $email => $name): ?>
				
				<input name='check_<?php echo $count; ?>' value='<?php echo $count; ?>' type='checkbox' class='' checked />
				<input type='hidden' name='email_<?php echo $count; ?>' value='<?php echo $email; ?>'>
				<input type='hidden' name='name_<?php echo $count; ?>' value='<?php echo $name; ?>' />
				
			<?php $count++; endforeach; ?>
<?php
		}
	}
}
?>
