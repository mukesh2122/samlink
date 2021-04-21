<div class="esports_right_column">
	<?php
		$EditorData = array(
			'ID'            => $ID_TEAM,
			'Post'          => MainHelper::site_url('esport/admin/editachievement/'.$ID_TEAM ),
			'MainOBJ'       => array(),
			'formid'        => 'editForm', // TODO: test if this actually is needed
			'Title'         => 'User',
			'ID_PRE'        => 'user',
			'NativeFields' 	=> array(),
			'PersonalInformation' => array(),
			'Elements'      => array(
				array(
					'type'      => 'info',
					'value'     => $this->__('Edit achievement'),
					'info'      => $this->__('Edit achievement')
				),
				array(
					'type'    	=>	'hidden',
					'values'    => array ( array('action', 'addachievement')	)
				),
				array(
					'title'     => $this->__('Title'),
					'id'        => 'Title',
					'value'     => $acData['Title']
				),
				array(
					'title'     => $this->__('Image'),
					'id'        => 'Image',
					'value'     => $acData['Image']
				),
			)		
	   );
	?>
	
	
	<div style="background-color:#fff;">
		<?php
			echo ContentHelper::ParseEditorData($EditorData);
		?>
	</div>
</div>
