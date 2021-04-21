<?php echo $this->renderBlock('admin/esport/common/progressmenu_cup',array('progress' => 'submit')); ?>
<?php

        $url = isset($_SESSION['createcup']['ID_GAME']) ? '/'.$_SESSION['createcup']['ID_GAME'] : '';
	$EditorData = array(
		'ID'            => 0,//$user->ID_PLAYER,
		'Post'          => MainHelper::site_url('esport/admin/createcup/submit'.$url),
		'MainOBJ'       => array(),
		'formid'        => 'editForm', // TODO: test if this actually is needed
		'Title'         => 'User',
		'ID_PRE'        => 'user',
		'NativeFields' 	=> array(),
		'PersonalInformation' => array(),
                'Submitbutton' => 'Create Cup',
		'Elements'      => array(
			array(
				'type'      => 'info',
				'value'     => $this->__('Clicking this button will create the cup.'),
				'info'      => $this->__('You can review the submitted data by clicking the above headlines')
			),
		)
		
   );
?>

<div class="esportform">
	<?php
		echo ContentHelper::ParseEditorData($EditorData);
	?>
</div>