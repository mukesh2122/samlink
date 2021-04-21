<script type='text/javascript'>
	function toggleAll(element) 
	{
	var form = document.forms.openinviter, z = 0;
	for(z=0; z<form.length;z++)
		{
		if(form[z].type == 'checkbox')
			form[z].checked = element.checked;
	   	}
	}
</script>

<form method="POST" name="openinviter">
	<label for="email_box">Email</label>
	<input class='thTextbox' type="text" name="email_box" value="">
	
	<label for='password_box'>Password</label>
	<input class='thTextbox' type='password' name='password_box' value=''>
	
	<label for='provider_box'>Email provider</label>
	<select class='thSelect' name='provider_box'>
		<option value=''></option>
		<?php foreach ($oi_services as $type=>$providers) : ?>
			<optgroup label='<?php echo $inviter->pluginTypes[$type]; ?>'>
			<?php foreach ($providers as $provider=>$details) : ?>
				<option value='<?php echo $provider; ?>'><?php echo $details['name']; ?></option>
			<?php endforeach; ?>
			</optgroup>
		<?php endforeach; ?>
	</select>
	<input type='hidden' name='step' value='get_contacts'>
	<input class='thButton' type='submit' name='import' value='Import Contacts'>
</form>