<form name="friendcatform" class="" method="post" action="#"> 
	<input type="hidden" name="actiontype" id="actiontype" value="" />
	<input type="hidden" name="deleteID" id="deleteID" value="" />
	<table cellspacing="0" cellpadding="0" class="table table_bordered table_striped gradient_thead mt10">
		<thead>
			<tr>
				<th><?php echo $this->__('Predefined friend categories'); ?></th>
				<th><?php echo $this->__('Action'); ?></th>
			</tr>
		</thead>
		<tbody>
			<?php foreach($friendcats as $cat): ?>
			<tr>
				<td>
					<input name="ID_<?php echo $cat['ID_CAT']; ?>" id="ID_<?php echo $cat['ID_CAT']; ?>" type="text" value="<?php echo $cat['CategoryName']; ?>" class="text_input" />			
				</td>
				<td>
					<a href="#" onclick="
						deleteID.value='<?php echo $cat['ID_CAT']; ?>';
						actiontype.value='delete';
						if(confirm('Are you sure?'))
							document.friendcatform.submit();
						" ><?php echo $this->__('Delete'); ?></a>
				</td>
			</tr>
			<?php endforeach; ?>
			<tr>
				<td colspan="3">
					<input type="submit" onclick="actiontype.value='rename';" value="<?php echo $this->__('Save');?>" class="button button_auto light_blue pull_right"/>
				</td>
			</tr>
		</tbody>
	</table>

	<table cellspacing="0" cellpadding="0" class="table table_bordered table_striped gradient_thead mt10">
		<thead>
			<tr>
				<th colspan="3"><?php echo $this->__('New predefined friend category'); ?></th>
			</tr>
		</thead>
		<tbody>
			<tr>
				<td><?php echo $this->__('New category name'); ?>
				</td>
				<td>
					<input name="CategoryName" type="text" value="<?php echo $this->__('New category name'); ?>" class="text_input" />			
				</td>
				<td>
					<input type="submit" onclick="actiontype.value='new';" value="<?php echo $this->__('Add new');?>" class="button button_auto light_blue pull_right"/>
				</td>
			</tr>
		</tbody>
	</table>

</form>