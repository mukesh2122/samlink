<?php $contentparentFields = MainHelper::GetModuleFieldsByTag('contentparent'); ?>  

<form class="standard_form" method="post" action="<?php echo MainHelper::site_url('admin/companies/new'); ?>">

	<div class="standard_form_header clearfix">
		<h1 class="pull_left"><?php echo $this->__('Company Settings'); ?></h1>
	</div>
	
	<div class="standard_form_elements clearfix">
		<div class="clearfix">
		<?php if ($contentparentFields['Name']['isEnabled']==1): ?> 
		<label for="company_name"><?php echo $this->__('Name'); ?></label>
			<span>
				<input tabindex="1" id="company_name" name="company_name" type="text" value="" class="text_input" />
			</span>
		</div>
		<?php endif; ?>
		
		<?php if ($contentparentFields['Description']['isEnabled']==1): ?> 
		<div class="clearfix">
			<label for="company_description"><?php echo $this->__('Description'); ?></label>
			<span>
				<div class="standard_form_checks_wrapper no-margin clearfix">
					<textarea rows="7" cols="43" tabindex="2" id="company_description" name="company_description"></textarea>
				</div>
			</span>
		</div>
		<?php endif; ?>
		
		<?php if ($contentparentFields['FoundedDate']['isEnabled']==1): ?> 
		<div class="clearfix">
			<label for="company_founded"><?php echo $this->__('Founded Date'); ?></label>
			<span>
				<input tabindex="1" id="company_founded" name="company_founded" type="text" value="" class="text_input" />
			</span>
		</div>
		<?php endif; ?>
		
		<?php if ($contentparentFields['Address']['isEnabled']==1): ?> 		
		<div class="clearfix">
			<label for="company_headquarters"><?php echo $this->__('Address'); ?></label>
			<span>
				<input tabindex="1" id="company_headquarters" name="company_headquarters" type="text" value="" class="text_input" />
			</span>
		</div>
		<?php endif; ?>
		
		<?php if ($contentparentFields['Ownership']['isEnabled']==1): ?> 		
		<div class="clearfix">
			<label for="company_ownership"><?php echo $this->__('Ownership'); ?></label>
			<span>
				<input tabindex="1" id="company_ownership" name="company_ownership" type="text" value="" class="text_input" />
			</span>
		</div>
		<?php endif; ?>

		<?php if ($contentparentFields['Employees']['isEnabled']==1): ?> 		<div class="clearfix">
			<label for="company_employees"><?php echo $this->__('Employees'); ?></label>
			<span>
				<input tabindex="1" id="company_employees" name="company_employees" type="text" value="" class="text_input" />
			</span>
		</div>
		<?php endif; ?>

		<?php if ($contentparentFields['URL']['isEnabled']==1): ?>
 		<div class="clearfix">
			<label for="company_url"><?php echo $this->__('URL'); ?></label>
			<span>
				<input tabindex="1" id="company_url" name="company_url" type="text" value="" class="text_input" />
			</span>
		</div>
		<div class="clearfix">
		<?php endif; ?>

		<?php if ($contentparentFields['Type']['isEnabled']==1): ?> 
		<label for="company_type"><?php echo $this->__('Company Type'); ?></label>
			<span>
				<select id="company_type" class="dropkick_lightWide" name="company_type" tabindex="10">
					<option value="0">
						<?php echo $this->__('Select company type');?>
					</option>
					<?php foreach ($companyTypes as $type): ?>
						<option value="<?php echo $type->ID_COMPANYTYPE; ?>">
							<?php echo $type->CompanyTypeName; ?>
						</option>
					<?php endforeach; ?>
				</select>
			</span>
		</div>
		<?php endif; ?>
		
		<?php MainHelper::RenderExtrafields($extrafields,$this,''); ?> 	
	</div>

	
	<div class="standard_form_footer clearfix">
		<input class="button button_auto light_blue pull_right" type="submit" value="<?php echo $this->__('Save Settings'); ?>" />
	</div>
		
</form>
<script type="text/javascript">loadCheckboxes();</script>