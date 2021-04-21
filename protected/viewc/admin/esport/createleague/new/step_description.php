<?php echo $this->renderBlock('admin/esport/common/progressmenu_cup',array('progress' => 'description')); ?>
<?php
        $url = isset($_SESSION['createcup']['ID_GAME']) ? '/'.$_SESSION['createcup']['ID_GAME'] : '';
	$EditorData = array(
		'ID'            => 0,//$user->ID_PLAYER,
		'Post'          => MainHelper::site_url('esport/admin/createcup/8'.$url),
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
				'value'     => $this->__('Description'),
				'info'      => $this->__('Description')
			),
			array(
				'title'     => $this->__('Cup description'),
				'id'        => 'LeagueDesc',
				'value'     => isset($_SESSION['createcup']['LeagueDesc']) ? $_SESSION['createcup']['LeagueDesc'] : 'Cup description'
			),
		)
		
   );
?>

<div class="esportform">
	<?php
		echo ContentHelper::ParseEditorData($EditorData);
	?>
</div>