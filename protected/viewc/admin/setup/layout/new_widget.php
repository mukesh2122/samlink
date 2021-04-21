<div class="info_box">
	<?php echo $this->__('Before activating the widget (i.e. unhiding it), remember to upload a php file in "viewc/sidebar/widgets/" with the same name as the name of the new widget with "_" between the words. 
		For example "New widget" -> "new_widget.php". If you are in doubt, contact the developer team.'); ?>
</div>
<?php
	$EditorData = array(
		'ID'            => 'new-widget',
		'Post'          => MainHelper::site_url('admin/setup/layout/right-column/new-widget'),
		// 'MainOBJ'       => $widget,
		'Title'         => 'New widget',
		'ID_PRE'        => '',
		'Submitbutton'  => 'Create',
		'Elements'      => array(
			array(
				'type'      => 'title',
				'text'      => $this->__('New widget')
			),
			array(
				'id'        => 'widget_Name',
				'title'     => $this->__('Name'),
				'value'     => '',
				'fieldName'	=> 'Name'
			),
			array(
				'type'      => 'select',
				'title'     => $this->__('Module'),
				'id'        => 'widget_Module',
				'options'   => array(
					array(
						'value' => 'all',
						'selected' => '',
						'text' => 'All'
					),
					array(
						'value' => 'esport',
						'selected' => '',
						'text' => 'eSport'
					)
				)
			),
			array(
				'type'      => 'checkbox',
				'title'     => $this->__('Is default?'),
				'id'        => 'widget_isDefault',
				'label'     => '',
				'checked'   => true
			),
			array(
				'type'      => 'checkbox',
				'title'     => $this->__('Is hidden?'),
				'id'        => 'widget_isHidden',
				'label'     => '',
				'checked'   => true
			)
		)
	);

	ContentHelper::ParseEditorData($EditorData);
?>