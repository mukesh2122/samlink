<?php
	$EditorData = array(
		'ID'            => $widget->ID_WIDGET,
		'Post'          => MainHelper::site_url('admin/setup/layout/right-column/edit-widget/' . $widget->ID_WIDGET),
		'MainOBJ'       => $widget,
		'Title'         => 'Edit widget',
		'ID_PRE'        => 'edit_widget',
		'Elements'      => array(
			array( // all the hidden values
				'type'      => 'hidden',
				'values'    => array (
					array('widget_ID', $widget->ID_WIDGET)
				)
			),
			array(
				'type'      => 'title',
				'text'      => $this->__('Edit widget')
			),
			array(
				'id'        => 'widget_Name',
				'title'     => $this->__('Name'),
				'value'     => $widget->Name,
				'fieldName'	=> 'Name'
			),
			array(
				'type'      => 'select',
				'title'     => $this->__('Module'),
				'id'        => 'widget_Module',
				'options'   => array(
					array(
						'value' => 'all',
						'selected' => ($widget->Module === 'all') ? true : '',
						'text' => 'All'
					),
					array(
						'value' => 'esport',
						'selected' => ($widget->Module === 'esport') ? true : '',
						'text' => 'eSport'
					)
				)
			),
			array(
				'type'      => 'checkbox',
				'title'     => $this->__('Is default?'),
				'id'        => 'widget_isDefault',
				'label'     => '',
				'checked'   => ($widget->isDefault == 1) ? true : ''
			),
			array(
				'type'      => 'checkbox',
				'title'     => $this->__('Is hidden?'),
				'id'        => 'widget_isHidden',
				'label'     => '',
				'checked'   => ($widget->isHidden == 1) ? true : ''
			),
			array(
				'type'      => 'info',
				'value'     => 'Delete'
			),
			array(
				'type'      => 'checkbox',
				'title'     => $this->__('Delete (permanently)'),
				'id'        => 'widget_delete',
				'label'     => '',
				'checked'   => ''
			)
		)
	);

	ContentHelper::ParseEditorData($EditorData);
?>