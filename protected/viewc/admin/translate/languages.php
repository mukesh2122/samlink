<table cellspacing="0" cellpadding="0" class="table table_bordered table_striped gradient_thead mt10">
	<thead>
		<tr>
			<th class="size_15 centered">ID</th>
			<th class="size_15 centered">Language</th>
			<th class="size_15 centered">isEnabled</th>
			<th class="size_10 centered"><?php echo $this->__('Action');?></th>
		</tr>
	</thead>

	<tbody>
 		<?php foreach($languageObjects as $languageitem):?>
			<tr>
				<td class="centered" style="width:45%;">
					<?php echo($languageitem['ID_LANGUAGE']); ?>
				</td>
				<td class="centered" style="width:45%;">
					<?php echo($languageitem['NativeName']); ?>
				</td>
				<td class="centered" style="width:45%;">
					<?php echo($languageitem['isEnabled']); ?>
				</td>
				<td class="centered">
					<a href="<?php echo MainHelper::site_url('admin/translate/editlanguage/id/'.$languageitem['ID_LANGUAGE']);?>"><?php echo 'Edit';?></a>
				</td>
			</tr>
		<?php endforeach;?>
	</tbody>
</table>
