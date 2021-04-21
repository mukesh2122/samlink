<?php echo $this->renderBlock('admin/esport/common/progressmenu_cup',array('progress' => 'replays')); ?>
<?php

	$ReplayUploadsOptions = array
	(
		array(
			'value'     => 'Disabled',
			'selected'  => isset($_SESSION['createcup']['ReplayUploads']) && $_SESSION['createcup']['ReplayUploads'] == 'Disabled' ? 1 : 0,
			'text'      => 'Disabled'
		),
		array(
			'value'     => 'Optional',
			'selected'  => isset($_SESSION['createcup']['ReplayUploads']) && $_SESSION['createcup']['ReplayUploads'] == 'Optional' ? 1 : 0,
			'text'      => 'Optional'
		),
		array(
			'value'     => 'Mandatory',
			'selected'  => isset($_SESSION['createcup']['ReplayUploads']) && $_SESSION['createcup']['ReplayUploads'] == 'Mandatory' ? 1 : 0,
			'text'      => 'Mandatory'
		),
	);
	$ReplayDownloadsOptions = array
	(
		array(
			'value'     => 'Disabled',
			'selected'  => isset($_SESSION['createcup']['ReplayDownloads']) && $_SESSION['createcup']['ReplayDownloads'] == 'Disabled' ? 1 : 0,
			'text'      => 'Disabled'
		),
		array(
			'value'     => 'Enabled',
			'selected'  => isset($_SESSION['createcup']['ReplayDownloads']) && $_SESSION['createcup']['ReplayDownloads'] == 'Enabled' ? 1 : 0,
			'text'      => 'Enabled'
		),
	);
        $url = isset($_SESSION['createcup']['ID_GAME']) ? '/'.$_SESSION['createcup']['ID_GAME'] : '';
	$EditorData = array(
		'ID'            => 0,//$user->ID_PLAYER,
		'Post'          => MainHelper::site_url('esport/admin/createcup/6'.$url),
		'MainOBJ'       => array(),
		'formid'        => 'editForm', // TODO: test if this actually is needed
		'Title'         => 'User',
		'ID_PRE'        => 'user',
		'NativeFields' 	=> array(),
		'PersonalInformation' => array(),
                'Submitbutton' => 'Next',
		'Elements'      => array(
			array(
				'type'      => 'info',
				'value'     => $this->__('Replays'),
				'info'      => $this->__('Replays')
			),
			array(
				'type'      => 'select',
				'title'     => $this->__('Replay Uploads'),
				'id'        => 'ReplayUploads',
				'options'   => $ReplayUploadsOptions
			),
			array(
				'type'      => 'select',
				'title'     => $this->__('Replay Downloads'),
				'id'        => 'ReplayDownloads',
				'options'   => $ReplayDownloadsOptions
			),
		)
		
   );
?>

<div class="esportform">
	<?php
		echo ContentHelper::ParseEditorData($EditorData);
	?>
</div>