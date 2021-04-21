<?php echo $this->renderBlock('admin/esport/common/progressmenu_cup',array('progress' => 'participants')); ?>
<?php 

	$playmodes = array
	(
        'Free2Play' => 1,
        'Pay2PlayCoins' => 4,
        'Pay2PlayCredits' => 2,
        'Unranked' => 8
	);
	$PlaymodeOptions = array();
	foreach ($playmodes as $k=>$v)
	{
		$PlaymodeOptions[] = array(
			'value'     => $v,
			'selected'  => isset($_SESSION['createcup']['PlayMode']) && $v == $_SESSION['createcup']['PlayMode'] ? 1 : 0,
			'text'      => $k
		);
	}
        $url = isset($_SESSION['createcup']['ID_GAME']) ? '/'.$_SESSION['createcup']['ID_GAME'] : '';
	$EditorData = array(
		'ID'            => 0,//$user->ID_PLAYER,
		'Post'          => MainHelper::site_url('esport/admin/createcup/3'.$url),
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
				'value'     => $this->__('Participation Requirements'),
				'info'      => $this->__('Participation Requirements')
			),
			array(
				'title'     => $this->__('Min Rating'),
				'id'        => 'minrating',
				'value'     => isset($_SESSION['createcup']['minrating']) ? $_SESSION['createcup']['minrating'] : '0'
			),
			array(
				'title'     => $this->__('Max Rating'),
				'id'        => 'maxrating',
				'value'     => isset($_SESSION['createcup']['maxrating']) ? $_SESSION['createcup']['maxrating'] : '999999'
			),
			array(
				'type'      => 'select',
				'title'     => $this->__('Playmode'),
				'id'        => 'PlayMode',
				'options'   => $PlaymodeOptions
			),
			array(
				'title'     => $this->__('Entry fee'),
				'id'        => 'entryfee',
				'value'     => isset($_SESSION['createcup']['entryfee']) ? $_SESSION['createcup']['entryfee'] : '0'
			),
		)
		
   );
?>

<div class="esportform">
	<?php
		echo ContentHelper::ParseEditorData($EditorData);
	?>
</div>