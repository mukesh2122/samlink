<div class="message_container">
    <!-- header -->
    <div class="clearfix">
        <span class="fs22 fft fclg2 fl mr10"><?php echo $this->__('Edit Company Info'); ?></span>
    </div>
    <!-- end header -->
    <form action="#" method="post" id="update_company_info_form">
        <input type="hidden" name="company_id" value="<?php echo $company->ID_COMPANY; ?>">
		
		<div class="mt5 pr zi100">
			<label for="companyType" class="cp"><?php echo $this->__('Company Type');?></label>
			<div class="jqtransform pr border clearfix mt2">
				 <select id="companyType" name="company_type" class="w570 company_type jqselect">
					<?php foreach ($company_types as $type): ?>
						<option value ="<?php echo $type->ID_COMPANYTYPE; ?>" <?php echo $type->ID_COMPANYTYPE == $company->ID_COMPANYTYPE ? 'selected="selected"' : ''; ?> ><?php echo $this->__($type->CompanyTypeName); ?></option>
					<?php endforeach; ?>
				</select>
			</div>
		</div>

       <div class="mt5">
			<label for="companyHeadquoters" class="cp"><?php echo $this->__('Headquarters'); ?></label>
			<div class="border mt2">
				<input name="company_headquarters" class="w576 news_border company_headquoters" id="companyHeadquoters" value="<?php echo $company->CompanyAddress; ?>">
			</div>
		</div>

		<div class="mt5">
			<label for="companyFounded" class="cp"><?php echo $this->__('Founded'); ?></label>
			<div class="border mt2">
				<input name="company_founded" class="w576 news_border company_founded" id="companyFounded" value="<?php echo $company->Founded; ?>">
			</div>
		</div>

		<div class="mt5">
			<label for="companyOwnership" class="cp"><?php echo $this->__('Ownership'); ?></label>
			<div class="border mt2">
				<input name="company_ownership" class="w576 news_border company_ownership" id="companyOwnership" value="<?php echo $company->Ownership; ?>">
			</div>
		</div>

		<div class="mt5">
			<label for="companyEmployees" class="cp"><?php echo $this->__('Employees'); ?></label>
			<div class="border mt2">
				<input name="company_employees" class="w576 news_border company_employees" id="companyEmployees" value="<?php echo $company->Employees; ?>">
			</div>
		</div>

		<div class="mt5">
			<label for="companyUrl" class="cp"><?php echo $this->__('Company Url'); ?></label>
			<div class="border mt2">
				<input name="company_url" class="w576 news_border company_url" id="companyUrl" value="<?php echo $company->URL; ?>">
			</div>
		</div>

		<div class="mt5">
			<label for="companyDescription" class="cp"><?php echo $this->__('Company Description'); ?></label>
			<div class="border mt2">
				<textarea name="company_description" rows="5" class="news_border w576" id="companyDescription"><?php echo $this->__($company->CompanyDesc); ?></textarea>
			</div>
		</div>

		<?php
			$extrafields = MainHelper::GetExtraFieldsByOwnertype('company',$company->ID_COMPANY);
			MainHelper::RenderExtrafields($extrafields,$this,'popupedit'); 
		?>

        <div class="clear mt10">&nbsp;</div>
        <a href="javascript:void(0);" class="link_green fr update_company_info"><span><span><?php echo $this->__('Save'); ?></span></span></a>
    </form>
</div>
<script type="text/javascript">loadDropdowns();</script>