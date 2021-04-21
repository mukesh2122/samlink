<form name="approveform" class="standard_form" method="post" action="#"> 
<input type="hidden" name="actionType" id="actionType" value ="" />
<input type="hidden" name="ID_PLAYER" id="ID_PLAYER" value ="" />
<table cellspacing="0" cellpadding="0" class="table table_bordered table_striped gradient_thead mt10">
	<thead>
		<tr>
			<th class="size_10 centered"><?php echo $this->__('ID');?></th>
			<th class="size_20 centered"><?php echo $this->__('Nickname');?></th>
			<th class="size_20 centered"><?php echo $this->__('Real name');?></th>
			<th class="size_20 centered"><?php echo $this->__('E-Mail');?></th>
			<th class="size_20 centered"><?php echo $this->__('Category');?></th>
			<th class="size_20 centered"><?php echo $this->__('Action');?></th>
		</tr>
	</thead>
	<tbody>
	<?php
	$player = User::getUser();
	if(isset($usersNotApproved) and !empty($usersNotApproved)) 
	{
		foreach($usersNotApproved as $user):?>
			<?php if($player->canAccess('Edit user information') === TRUE || strpos(',0,3,4,', ','.$user['ID_USERGROUP'].',') !== FALSE): ?>
				<tr>
					<td class="centered"><?php echo $user['ID_PLAYER'];?></td>
					<td class="centered"><?php echo $user['NickName'];?></td>
					<td class="centered"><?php echo $user['FirstName'];?> <?php echo $user['LastName'];?></td>
					<td class="centered"><?php echo $user['EMail'];?></td>
					<td class="centered"><?php echo $user['CategoryName'];?></td>
					<td class="centered">
						<a href="javascript:void(0);" onclick="actionType.value='approve';ID_PLAYER.value='<?php echo $user['ID_PLAYER'];?>'; if (confirm('Are you sure?'))document.approveform.submit();"><?php echo $this->__('Approve');?></a>
					</td>
				</tr>
			<?php endif; ?>
		<?php endforeach;
	}?>
	</tbody>
</table>
</form>