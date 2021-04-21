<form name="specialtoolsform" class="standard_form" method="post" action="#"> 
	<input type ="hidden" name="tooltype" id="tooltype" value="" />
	<table cellspacing="0" cellpadding="0" class="table table_bordered table_striped gradient_thead mt10">
		<thead>
			<tr>
				<th class="centered"><?php echo $this->__('Select a special tool'); ?></th>
			</tr>
		</thead>
		<tbody>
			<tr>
				<td class="centered">
					<a href="#" onclick="if (confirm('Warning: All users looses their privacy settings! Are you sure?')){tooltype.value='privacysettings';document.specialtoolsform.submit();}"><?php echo $this->__('Init privacy settings for all users');?></a>
				</td>
			</tr>
			<tr>
				<td class="centered">
					<a href="#" onclick="if (confirm('Warning: All users looses their personal-info settings! Are you sure?')){tooltype.value='personalinformation';document.specialtoolsform.submit();}"><?php echo $this->__('Init personal information for all users');?></a>
				</td>
			</tr>
		</tbody>
	</table>
</form> 