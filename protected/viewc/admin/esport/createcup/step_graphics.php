<?php echo $this->renderBlock('admin/esport/common/progressmenu_cup',array('progress' => 'graphics')); ?>
<?php
        $esport = new Esport();
        if(isset($_SESSION['createcup']['change_league_picture'])){
            $league = new EsLeagues();
            $league->Image = $_SESSION['createcup']['change_league_picture'];
        }
        $sponsorone = isset($_SESSION['createcup']['sponsor_one']) ? $_SESSION['createcup']['sponsor_one'] : 0 ;
        $sponsortwo = isset($_SESSION['createcup']['sponsor_two']) ? $_SESSION['createcup']['sponsor_two'] : 0 ;
        $sponsorthree = isset($_SESSION['createcup']['sponsor_three']) ? $_SESSION['createcup']['sponsor_three'] : 0 ;
        $SponsorList = $esport->getAllSponsors();

        $url = isset($_SESSION['createcup']['ID_GAME']) ? '/'.$_SESSION['createcup']['ID_GAME'] : '';
	$EditorData = array(
		'ID'            => 0,//$user->ID_PLAYER,
		'Post'          => MainHelper::site_url('esport/admin/createcup/7'.$url),
		'MainOBJ'       => array(),
		'formid'        => 'editForm', // TODO: test if this actually is needed
		'Title'         => 'User',
		'ID_PRE'        => 'league',
		'NativeFields' 	=> array(),
		'PersonalInformation' => array(),
                'Submitbutton' => 'Next',
		'Elements'      => array(
			array(
				'type'      => 'info',
				'value'     => $this->__('Graphics'),
				'info'      => $this->__('Select your tournamentbanner and sponsors'),
			),
			array(
				'type'      => 'fileupload',
                                'title'     => $this->__('Banner').(' (665x340)'),
                                'id'        => 'change_league_picture',
                                'model'     => isset($league) ? $league : ''
			),
                        array(
				'type'      => 'select',
				'title'     => $this->__('Sponsor').' 1',
				'text'      => $this->__('Disabled'),
                                'value'     => '0',
				'id'        => 'sponsor_one',
				'options'   => ContentHelper::ObjArrayToOptions($SponsorList, 'ID_SPONSOR', 'SponsorName', 'ID_SPONSOR', array($sponsorone)),
			),
                        array(
				'type'      => 'select',
				'title'     => $this->__('Sponsor').' 2',
				'text'      => $this->__('Disabled'),
                                'value'     => '0',
				'id'        => 'sponsor_two',
				'options'   => ContentHelper::ObjArrayToOptions($SponsorList, 'ID_SPONSOR', 'SponsorName', 'ID_SPONSOR', array($sponsortwo)),
			),
                        array(
				'type'      => 'select',
				'title'     => $this->__('Sponsor').' 3',
				'text'      => $this->__('Disabled'),
                                'value'     => '0',
				'id'        => 'sponsor_three',
				'options'   => ContentHelper::ObjArrayToOptions($SponsorList, 'ID_SPONSOR', 'SponsorName', 'ID_SPONSOR', array($sponsorthree)),
			),
		)
		
   );
?>

<div class="esportform">
	<?php
		echo ContentHelper::ParseEditorData($EditorData);
	?>
</div>