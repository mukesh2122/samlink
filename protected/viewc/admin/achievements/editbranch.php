<?php $contentchildFields = MainHelper::GetModuleFieldsByTag('contentchild'); ?> 
<?php $isEnabledContentparent = MainHelper::IsModuleEnabledByTag('contentparent'); ?> 
<?php $contentchildFunctions = MainHelper::GetModuleFunctionsByTag('contentchild'); ?>
<?php if (MainHelper::IsModuleNotAvailableByTag('contentparent')==1) $isEnabledContentparent = 0; ?>

<?php

    $EditorData = array(
        'ID'            => $branch->ID_BRANCH,
        'Post'          => MainHelper::site_url('admin/achievements/editbranch/'.$branch->ID_BRANCH),
        'MainOBJ'       => $branch,
        'Title'         => 'Branch',
        'ID_PRE'        => 'branch',
        'NativeFields' 	=> $contentchildFields,
        'Elements'      => array(
            array(
                'type'      => 'title',
                'text'      => $this->__('Branch Settings')
            ),
            array( // all the hidden values
                'type'      => 'hidden',
                'values'    => array (
                    array('branch_id', $branch->ID_BRANCH)
                )
            ),
            array(
                'id'        => 'branch_name',
                'title'     => $this->__('Name'),
                'value'     => $branch->BranchName, 
				'fieldName'	=> 'Name'

            ),
            array(
                'id'        => 'branch_desc',
                'title'      => $this->__('Description'),
                'value'      => $branch->BranchDesc,
				'fieldName'	=> 'Description'
            ),
        )        
    );
			
    ContentHelper::ParseEditorData($EditorData);
?>
		
