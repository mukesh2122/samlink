<form class="standard_form" name="moduleform" method="post" action="#">
	<input type="hidden" name="ID_MODULE" id="ID_MODULE" value="<?php echo $selected_module['ID_MODULE']; ?>" />
	<input type="hidden" name="actionType" id="actionType" value="none" />
	<input type="hidden" name="actionValue" id="actionValue" value="" />

	<div class="standard_form_header clearfix">
		<h1 class="pull_left"><?php echo 'Edit ' . $selected_module['ModuleTitle']; ?></h1>
	</div>

	<div class="standard_form_elements clearfix">
		<div class="clearfix">
			<label for="A2"><?php echo 'Module name'; ?></label>
			<span>
				<input tabindex="1" id="ModuleName" name="ModuleName" type="text" value="<?php echo $selected_module['ModuleName']; ?>" class="text_input" />
			</span>
		</div>

		<div class="clearfix">
			<label for="ModuleTitle"><?php echo 'Module title'; ?></label>
			<span>
				<input tabindex="2" id="ModuleTitle" name="ModuleTitle" type="text" value="<?php echo $selected_module['ModuleTitle']; ?>" class="text_input" />
			</span>
		</div>

		<div class="clearfix">
			<label for="ModuleDesc"><?php echo 'Module description'; ?></label>
			<span>
				<input tabindex="3" id="ModuleDesc" name="ModuleDesc" type="text" value="<?php echo $selected_module['ModuleDesc']; ?>" class="text_input" />
			</span>
		</div>
		
		<div class="standard_form_checks clearfix" <?php if (!$superadmin){echo'style="display:none;"';} ?>>
			<label for="isEnabled"><?php echo 'Is enabled'; ?></label>
			<span>
				<div class="standard_form_checks_wrapper no-margin clearfix">
					<input class="dst" tabindex="4" id="isEnabled" name="isEnabled" type="checkbox" <?php if ($selected_module['isEnabled']=="1") echo "checked";?> class="text_input" />
				</div>
			</span>
		</div>
	</div>
	<?php $functions = $selected_module['functions'];
		if (count($functions)> 0): ?>
	<div class="standard_form_header clearfix">
		<h1 class="pull_left"><?php echo 'Functions'; ?></h1>
	</div>
	<div class="standard_form_elements clearfix">
		<?php
		foreach($functions as $function)
		{
			$checked = ($function['isEnabled']==1) ? " checked " : "";
		?>
			<div class="standard_form_checks clearfix">
				<label for="isEnabled"><?php echo $function['FunctionTitle']; ?></label>
				<span>
					<div class="standard_form_checks_wrapper no-margin clearfix">
						<input class="dst" tabindex="4" id="modfunc<?php echo $function['ID_MODFUNC']; ?>" name="modfunc<?php echo $function['ID_MODFUNC']; ?>" type="checkbox" <?php if ($function['isEnabled']=="1") echo $checked;?> class="text_input" />
						<?php echo $function['FunctionDesc']; ?>
					</div>
				</span>
			</div>
		<?php } ?>
	</div>
	<?php endif; ?>

	<?php $fieldsNative = $selected_module['fields'];
		if (count($fieldsNative)> 0): ?>

	<div class="standard_form_header clearfix">
		<h1 class="pull_left"><?php echo 'Fields'; ?></h1>
	</div>

	<div class="standard_form_elements clearfix">
		<table cellspacing="0" cellpadding="0" class="table table_bordered table_striped gradient_thead mt10">
			<thead>
				<tr>
					<th class="size_15 centered"><?php echo $this->__('Field name');?></th>
					<th class="size_15 centered"><?php echo $this->__('Enabled');?></th>
					<th class="size_15 centered"><?php echo $this->__('Required');?></th>
				</tr>
			</thead>
			<tbody>
				<?php
				foreach($fieldsNative as $field)
				{?>
					<tr>
						<td>
							<label for="isEnabled"><?php echo $field['FieldTitle']; ?></label>
						</td>
						<td>
							<input class="dst" tabindex="4" id="fieldenabled<?php echo $field['ID_FIELD']; ?>" name="fieldenabled<?php echo $field['ID_FIELD']; ?>" type="checkbox" <?php echo ($field['isEnabled']==1) ? " checked " : "";?> class="text_input" />
						</td>
						<td>
							<?php if ($field['ShowRequired']==1): ?>
								<input class="dst" tabindex="5" id="fieldrequired<?php echo $field['ID_FIELD']; ?>" name="fieldrequired<?php echo $field['ID_FIELD']; ?>" type="checkbox" <?php echo ($field['isRequired']==1) ? " checked " : "";?> class="text_input" />
							<?php endif; ?>
						</td>
					</tr><?php
				} ?>
			</tbody>
		</table>
	</div>
		
	<?php endif; ?>







	<?php $extraFields = $selected_module['extrafields'];
		$OwnerType = $selected_module['OwnerType'];
		if (isset($OwnerType) && $OwnerType!=""): ?>

	<div class="standard_form_header clearfix">
		<h1 class="pull_left"><?php echo 'Extra fields'; ?></h1>
	</div>

	<div class="standard_form_elements clearfix">
		<table cellspacing="0" cellpadding="0" class="table table_bordered table_striped gradient_thead mt10">
			<thead>
				<tr>
					<th class="size_5 centered"><?php echo $this->__('Order');?></th>
					<th class="size_15 centered"><?php echo $this->__('Field name');?></th>
					<th class="size_15 centered"><?php echo $this->__('Field type');?></th>
					<th class="size_20 centered" colspan="2"><?php echo $this->__('Action');?></th>
				</tr>
			</thead>
			<tbody>
				<?php
				foreach($extraFields as $field)
				{?>
					<tr>
						<td>
							<label for="isEnabled"><?php echo $field['Priority']; ?></label>
						</td>
						<td>
							<label for="isEnabled"><?php echo $field['FieldName']; ?></label>
						</td>
						<td>
							<label for="isEnabled"><?php echo $field['FieldType']; ?></label>
						</td>
						<td class="centered">
							<a href="<?php echo MainHelper::site_url('admin/setup/editextrafield/moduleid/'.$selected_module['ID_MODULE'].'/fieldid/'.$field['ID_FIELD']); ?>"><?php echo 'Edit'; ?></a>
						</td>
						<td class="centered">
							<a href="#" onclick="actionType.value='deleteextrafield';actionValue.value='<?php echo $field['ID_FIELD']; ?>'; if (confirm('Are you sure?'))document.moduleform.submit();"><?php echo 'Delete'; ?></a>
						</td>
					</tr><?php
				} ?>
			</tbody>
		</table>

		<table cellspacing="0" cellpadding="0" class="table table_bordered table_striped gradient_thead mt10">
			<thead>
				<tr>
					<th class="size_50 centered"><?php echo $this->__('Add extra field');?></th>
				</tr>
			</thead>
			<tbody>
				<tr>
					<td>
						<div class="clearfix">
							<label for="Priority"><?php echo 'Field priority'; ?></label>
							<span>
								<input id="extrafieldpriority" name="extrafieldpriority" type="text" value="0" class="text_input" />
							</span>
						</div>
					</td>
				</tr>
				<tr>
					<td>
						<div class="clearfix">
							<label for="FieldName"><?php echo 'Field name'; ?></label>
							<span>
								<input id="extrafieldname" name="extrafieldname" type="text" value="New field" class="text_input" />
							</span>
						</div>
					</td>
				</tr>
				<tr>
					<td>
						<div class="clearfix">
							<label for="FieldType">Field type</label>
							<span>
								<select id="extrafieldtype" class="dropkick_lightWide" name="extrafieldtype">
									<option value="text" >Text</option>
									<option value="integer" >Integer</option>
									<option value="boolean" >Boolean</option>
									<option value="date" >Date</option>
									<option value="timestamp" >Timestamp</option>
								</select>
							</span>
						</div>
					</td>
				</tr>
				<tr>
					<td class="centered">
						<a href="#" onclick="actionType.value='addextrafield'; if (confirm('Are you sure?'))document.moduleform.submit();" class="button button_auto light_blue pull_right"><?php echo 'Add field'; ?></a>
					</td>
				</tr>
			</tbody>
		</table>
		
	</div>
		
	<?php endif; ?>


	<?php $categories = $selected_module['categories'];
		if (isset($OwnerType) && $OwnerType=="player"): ?>

	<div class="standard_form_header clearfix">
		<h1 class="pull_left"><?php echo 'Categories'; ?></h1>
	</div>

	<div class="standard_form_elements clearfix">
		<table cellspacing="0" cellpadding="0" class="table table_bordered table_striped gradient_thead mt10">
			<thead>
				<tr>
					<th class="size_50 centered"><?php echo $this->__('Category name');?></th>
					<th class="size_5 centered"><?php echo $this->__('Must Be Approved');?></th>
					<th class="size_20 centered" colspan="2"><?php echo $this->__('Action');?></th>
				</tr>
			</thead>
			<tbody>
				<?php
				foreach($categories as $category)
				{?>
					<tr>
						<td>
							<label for="isEnabled"><?php echo $category['CategoryName']; ?></label>
						</td>
						<td>
							<label for="isEnabled"><?php echo ($category['MBA_enabled']==1)?'Yes' : 'No'; ?></label>
						</td>
						<td class="centered">
							<a href="<?php echo MainHelper::site_url('admin/setup/editcategory/moduleid/'.$selected_module['ID_MODULE'].'/categoryid/'.$category['ID_CATEGORY']); ?>"><?php echo 'Edit'; ?></a>
						</td>
						<td class="centered">
							<a href="#" onclick="actionType.value='deletecategory';actionValue.value='<?php echo $category['ID_CATEGORY']; ?>'; if (confirm('Are you sure?'))document.moduleform.submit();"><?php echo 'Delete'; ?></a>
						</td>
					</tr><?php
				} ?>
			</tbody>
		</table>
		
		<table cellspacing="0" cellpadding="0" class="table table_bordered table_striped gradient_thead mt10">
			<thead>
				<tr>
					<th class="size_50 centered"><?php echo $this->__('Add new category');?></th>
				</tr>
			</thead>
			<tbody>
				<tr>
					<td>
						<div class="clearfix">
							<label for="categoryname"><?php echo 'Category name'; ?></label>
							<span>
							<input id="categoryname" name="categoryname" type="text" value="New category" class="text_input" />
							</span>
						</div>
					</td>
				</tr>
				<tr>
					<td>
						<div class="standard_form_checks clearfix" >
							<label for="mbaenabled"><?php echo 'Must Be Approved'; ?></label>
							<span>
								<div class="standard_form_checks_wrapper no-margin clearfix">
									<input class="dst" id="mbaenabled" name="mbaenabled" type="checkbox" />
								</div>
							</span>
						</div>
					</td>
				</tr>
				<tr>
					<td class="centered">
						<a href="#" onclick="actionType.value='addcategory'; if (confirm('Are you sure?'))document.moduleform.submit();" class="button button_auto light_blue pull_right"><?php echo 'Add category'; ?></a>
					</td>
				</tr>
			</tbody>
		</table>
		
	</div>
	<?php endif; ?>


	
	
	
	
	
	<?php $settings = $selected_module['settings'];
		if (!empty($settings)): ?>

	<div class="standard_form_header clearfix">
		<h1 class="pull_left"><?php echo 'Settings'; ?></h1>
	</div>

	<div class="standard_form_elements clearfix">
		<table cellspacing="0" cellpadding="0" class="table table_bordered table_striped gradient_thead mt10">
			<thead>
			</thead>
			<tbody>
				<?php
				foreach($settings as $setting)
				{
					$SettingType = $setting['SettingType'];
					$value = $setting['ValueText'];
					switch ($SettingType)
					{
						case 'ValueBool':
							$value = $setting['ValueBool'];
							break;
						case 'ValueInt':
							$value = $setting['ValueInt'];
							break;
						case 'ValueDec':
							$value = $setting['ValueDec'];
							break;
						case 'ValueText':
							$value = $setting['ValueText'];
							break;
						case 'ValueBin':
							$value = $setting['ValueBin'];
							break;
					}
				
				?>
					<tr>
						<td>
							<div class="clearfix">
								<label for="settings"><?php echo $setting['ID_SETTING']; ?></label>
									<span>
									<?php if ($setting['DataSource']=="language") : ?>
									<?php 
										$langs = Lang::getLanguages();
									?>
											<select id="settings_<?php echo $setting['ID_SETTING']; ?>" name="settings_<?php echo $setting['ID_SETTING']; ?>" class="dropkick_lightWide">
											<?php foreach ($langs as $lang): ?>
											<option value="<?php echo $lang->ID_LANGUAGE; ?>" <?php echo ($value==$lang->ID_LANGUAGE) ? 'selected="selected"' : '';?>><?php echo $lang->NativeName; ?></option>
											<?php endforeach; ?>
											</select>
										</select>
										
									<?php else: ?>
											<input id="settings_<?php echo $setting['ID_SETTING']; ?>" name="settings_<?php echo $setting['ID_SETTING']; ?>" type="text" value="<?php echo $value; ?>" class="text_input" />
									<?php endif; ?>
								</span>
							</div>
						</td>
		
					</tr><?php
				} ?>
			</tbody>
		</table>
		
		
	</div>
	<?php endif; ?>
	
	<?php $availability = $selected_module['availability'];
		if (!empty($availability)):?>
	<div class="standard_form_header clearfix">
		<h1 class="pull_left"><?php echo 'Not available'; ?></h1>
	</div>
	<div class="standard_form_elements clearfix">
		<div class="standard_form_checks clearfix">
			<label for="notavailable"><?php echo "Not available" ?></label>
			<span>
				<div class="standard_form_checks_wrapper no-margin clearfix">
					<input class="dst" tabindex="4" id="na_notavailable" name="na_notavailable" type="checkbox" <?php if ($availability['NotAvailable']=="1") echo "checked";?> class="text_input" />
				</div>
			</span>
		</div>
	</div>



	<div class="clearfix standard_form_elements">
			<label for="message"><?php echo 'Text'; ?></label>
		<div class="border mt2">
			<?php echo MainHelper::loadCKE('na_message', $availability['Message']); ?>
		</div>
	</div>

	<?php endif; ?>
	

	
	<div class="standard_form_footer clearfix">
		<input class="button button_auto light_blue pull_right" onclick="actionType.value='submitform';" type="submit" value="<?php echo 'Save Settings'; ?>" />
	</div>
</form>



<script type="text/javascript">loadCheckboxes();</script> 