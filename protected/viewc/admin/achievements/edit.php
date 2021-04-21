<?php

    $EditorData = array(
        'ID'            => $achievement->ID_ACHIEVEMENT,
        'Post'          => MainHelper::site_url('admin/achievements/edit/'.$achievement->ID_ACHIEVEMENT),
        'MainOBJ'       => $achievement,
        'Title'         => 'Achievement',
        'ID_PRE'        => 'achievement',
        'Elements'      => array(
            array(
                'type'      => 'title',
                'text'      => $this->__('Achievement Settings')
            ),
            array( // all the hidden values
                'type'      => 'hidden',
                'values'    => array (
                    array('ach_id', $achievement->ID_ACHIEVEMENT)
                )
            ),
            array(
                'id'        => 'ach_name',
                'title'     => $this->__('Name'),
                'value'     => $achievement->AchievementName, 
				'fieldName'	=> 'Name'

            ),
            array(
                'id'        => 'ach_desc',
                'title'      => $this->__('Description'),
                'value'      => $achievement->AchievementDesc,
				'fieldName'	=> 'Description'
            ),
            array(
                'id'        => 'ach_branch_id',
                'type'      => 'select',
                'options'   => ContentHelper::ObjArrayToOptions($branches, 'ID_BRANCH', 'BranchName', 'ID_BRANCH', array($achievement->FK_BRANCH)),
                'value'     => '0',
                'text'      => $this->__('Select branch'),
                'title'     => $this->__('Achieve branch')
            ),
        )        
    );
        //Add picture nativefield
	$EditorData['Elements'][] = array(
                'type'      => 'singlepicture'
            );
			
    ContentHelper::ParseEditorData($EditorData);
?>
		
