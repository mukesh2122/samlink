<?php $contentparentFields = MainHelper::GetModuleFieldsByTag('contentparent'); ?> 
<?php
   $EditorData = array(
        'ID'            => $company->ID_COMPANY,
        'Post'          => MainHelper::site_url('admin/companies/edit/'.$company->ID_COMPANY),
        'MainOBJ'       => $company,
        'Title'         => 'Company',
        'ID_PRE'        => 'company',
        'NativeFields' 	=> $contentparentFields,
        'Elements'      => array(
            array( // all the hidden values
                'type'      => 'hidden',
                'values'    => array (
                    array('company', $company->ID_COMPANY)
                )
            ),
            array(
                'type'      => 'title',
                'text'      => $this->__('Company Settings')
            ),
            array(
                'id'        => 'company_name',
                'title'     => $this->__('Name'),
                'value'     => $company->CompanyName,
				'fieldName'	=> 'Name'
            ),
            array(
                'type'      => 'desc',
                'id'        => 'company_description',
                'title'     => $this->__('Description'),
                'value'     => $company->CompanyDesc,
				'fieldName'	=> 'Description'
            ),
            array(
                'id'        => 'company_founded',
                'title'     => $this->__('Founded Date'),
                'value'     => $company->Founded,
				'fieldName'	=> 'FoundedDate'
            ),
            array(
                'id'        => 'company_headquarters',
                'title'     => $this->__('Address'),
                'value'     => $company->CompanyAddress,
				'fieldName'	=> 'Address'
            ),
            array(
                'id'        => 'company_ownership',
                'title'     => $this->__('Ownership'),
                'value'     => $company->Ownership,
				'fieldName'	=> 'Ownership'
            ),
            array(
                'id'        => 'company_employees',
                'title'     => $this->__('Employees'),
                'value'     => $company->Employees,
				'fieldName'	=> 'Employees'
            ),
            array(
                'id'        => 'company_url',
                'title'     => $this->__('URL'),
                'value'     => $company->URL,
				'fieldName'	=> 'URL'
            ),
            array(
                'type'      => 'select',
                'title'     => $this->__('Company Type'),
                'id'        => 'company_type',
                'value'     => '0',
                'text'      => $this->__('Select company type'),
                'options'   => ContentHelper::ObjArrayToOptions($companyTypes, 'ID_COMPANYTYPE', 'CompanyTypeName', 'ID_COMPANYTYPE', array($company->ID_COMPANYTYPE)),
				'fieldName'	=> 'Type'
            )
        )
     );

	//Add extrafields to EditorData
	if (isset($extrafields))
		$EditorData = ContentHelper::AddEditorDataExtrafields($extrafields,$EditorData,$this);
	 
	//Add picture nativefield
	$EditorData['Elements'][] = array(
                'type'      => 'picture'
            );
	
	
	ContentHelper::ParseEditorData($EditorData);
?>
