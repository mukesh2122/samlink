<?php

    $EditorData = array(
        'ID'            => $level->ID_LEVEL,
        'Post'          => MainHelper::site_url('admin/achievements/editlevel/'.$level->ID_LEVEL),
        'MainOBJ'       => $level,
        'Title'         => 'Level',
        'ID_PRE'        => 'level',
        'Elements'      => array(
            array(
                'type'      => 'title',
                'text'      => $this->__('Level Settings')
            ),
            array( // all the hidden values
                'type'      => 'hidden',
                'values'    => array (
                    array('level_id', $level->ID_LEVEL)
                )
            ),
            array(
                'id'        => 'level_name',
                'title'     => $this->__('Name'),
                'value'     => $level->LevelName, 
				'fieldName'	=> 'Name'

            ),
            array(
                'id'        => 'level_desc',
                'title'      => $this->__('Level'),
                'value'      => $level->LevelDesc,
				'fieldName'	=> 'Description'
            ),
            array(
                'id'        => 'level_ach_id',
                'type'      => 'select',
                'options'   => ContentHelper::ObjArrayToOptions($achievementList, 'ID_ACHIEVEMENT', 'AchievementName', 'ID_ACHIEVEMENT', array($level->FK_ACHIEVEMENT)),
                'value'     => '0',
                'text'      => $this->__('Select parent'),
                'title'     => $this->__('Achievement parent')
            ),
            array(
                'id'        => 'level_points',
                'title'      => $this->__('Points'),
                'value'      => $level->Points,
				'fieldName'	=> 'Points'
            ),
            array(
                'id'        => 'level_multiplier',
                'title'      => $this->__('Multiplier'),
                'value'      => $level->Multiplier,
				'fieldName'	=> 'Multiplier'
            ),
        )        
    );
                	//Add picture nativefield
	$EditorData['Elements'][] = array(
                'type'      => 'singlepicture',
            );
			
    ContentHelper::ParseEditorData($EditorData);
?>
		
