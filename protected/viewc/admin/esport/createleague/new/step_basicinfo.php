<?php echo $this->renderBlock('admin/esport/common/progressmenu_cup',array('progress' => 'basic')); ?>
<?php
        //extract($_SESSION['createcup']);
        if(isset($_SESSION['createcup']['startdate_day']) && isset($_SESSION['createcup']['startdate_month']) && isset($_SESSION['createcup']['startdate_year'])){
            $startdate = date("Y-m-d",strtotime($_SESSION['createcup']['startdate_year'].'-'.$_SESSION['createcup']['startdate_month'].'-'.$_SESSION['createcup']['startdate_day']));
        }
        if(isset($_SESSION['createcup']['enddate_day']) && isset($_SESSION['createcup']['enddate_month']) && isset($_SESSION['createcup']['enddate_year'])){
            $enddate = date("Y-m-d",strtotime($_SESSION['createcup']['enddate_year'].'-'.$_SESSION['createcup']['enddate_month'].'-'.$_SESSION['createcup']['enddate_day']));
        }
        if(isset($_SESSION['createcup']['signupdeadline_day']) && isset($_SESSION['createcup']['signupdeadline_month']) && isset($_SESSION['createcup']['signupdeadline_year'])){
            $signupdate = date("Y-m-d",strtotime($_SESSION['createcup']['signupdeadline_year'].'-'.$_SESSION['createcup']['signupdeadline_month'].'-'.$_SESSION['createcup']['signupdeadline_day']));
        }
        if(isset($_SESSION['createcup']['starttime_hours']) && isset($_SESSION['createcup']['starttime_minutes'])){
            $starttime= date("H:i",strtotime($_SESSION['createcup']['starttime_hours'].':'.$_SESSION['createcup']['starttime_minutes']));
        }
        if(isset($_SESSION['createcup']['endtime_hours']) && isset($_SESSION['createcup']['endtime_minutes'])){
            $endtime= date("H:i",strtotime($_SESSION['createcup']['endtime_hours'].':'.$_SESSION['createcup']['endtime_minutes']));
        }
	$leagueData = array
	(
		'StartTime'			=>	time(),
		'EndTime'			=>	time(),
		'SignupdDeadline'	=>	time()
	);


	$ESportGames = Doo::db()->query("CALL esp_GetAllESportGames();")->fetchall();
	$GameOptions = array();     
	foreach ($ESportGames as $game)
	{
                
		$GameOptions[] = array(
			'value'     => $game['ID_GAME'],
			'selected'  => isset($_SESSION['createcup']['game']) && $game['ID_GAME'] == $_SESSION['createcup']['game'] ? 1 : 0,
			'text'      => $game['GameName']
		);
	}

	$Regions = Doo::db()->query("CALL esp_GetAllRegions();")->fetchall();
	$RegionOptions = array();
	foreach ($Regions as $region)
	{
		$RegionOptions[] = array(
			'value'     => $region['ID_REGION'],
			'selected'  => isset($_SESSION['createcup']['region']) && $region['ID_REGION'] == $_SESSION['createcup']['region'] ? 1 : 0,
			'text'      => $region['RegionName']
		);
	}

	$CupsizeOptions = array();
	for ($i = 4; $i < 1025;)
	{
		//string selected = (leagueData.TournamentSize == i) ? "selected" : "";
		$CupsizeOptions[] = array(
			'value'     => $i,
			'selected'  => isset($_SESSION['createcup']['cupsize']) && $i == $_SESSION['createcup']['cupsize'] ? 1 : 0,
			'text'      => $i
		);
		$i *= 2;		
	}

	$formats = array
	(
		'Individual' => 1,
		'TwovsTwo' => 2,
		'ThreevsThree' => 3,
		'FourvsFour' => 4,
		'FivevsFive' => 5,
		'SixvsSix' => 6,
		'EightvsEight' => 8,
		'TenvsTen' => 10,
		'Fourteen' => 14,
		'Twelve' => 12,
		'Sixteen' => 0x10,
		'Twenty' => 20,
		'TwentyFour' => 0x18,
		'TwentyEight' => 0x1c,
		'ThirtyTwo' => 0x20,
	);
	
	$TeamsizeOptions = array();
	foreach ($formats as $k=>$v)
	{
		$s = ($v==1) ? 1 : 0;
		$TeamsizeOptions[] = array(
			'value'     => $v,
			'selected'  => isset($_SESSION['createcup']['teamsize']) && $v == $_SESSION['createcup']['teamsize'] ? 1 : 0,
			'text'      => "$v vs $v"
		);
	}
/*			@foreach (int i in formats)
	{
		string selected = (leagueData.Format == i) ? "selected" : "";
		<option value="@i" @selected>@(i) vs @(i)</option>
	}*/
   $url = isset($_SESSION['createcup']['ID_GAME']) ? '/'.$_SESSION['createcup']['ID_GAME'] : '';
   $EditorData = array(
		'ID'            => 0,//$user->ID_PLAYER,
		'Post'          => MainHelper::site_url('esport/admin/createcup/2'.$url),
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
				'value'     => $this->__('Basic Info'),
				'info'      => $this->__('Basic Info')
			),
			array(
				'title'     => $this->__('Cup Name'),
				'id'        => 'cupName',
				'value'     => isset($_SESSION['createcup']['cupName']) ? $_SESSION['createcup']['cupName'] : 'Cup name'
			),
			array(
				'type'      => 'select',
				'title'     => $this->__('Game'),
				'id'        => 'game',
				'options'   => $GameOptions
			),
			array(
				'type'      => 'select',
				'title'     => $this->__('Region'),
				'id'        => 'region',
				'options'   => $RegionOptions
			),
			array(
				'type'      => 'date',
				'id'        => 'startdate',
				'prefix'    => 'startdate_',
				'title'     => $this->__('Start date'),
				'value'     => isset($startdate) ? $startdate : date('Y-m-d', $leagueData['StartTime']),
				'fieldName'	=> ''
			),
			array(
				'type'      => 'time',
				'id'        => 'starttime',
				'prefix'    => 'starttime_',
				'title'     => $this->__('Start time'),
                                'value'     => isset($starttime) ? $starttime : '',
				'fieldName'	=> ''
			),
			array(
				'type'      => 'date',
				'id'        => 'enddate',
				'prefix'    => 'enddate_',
				'title'     => $this->__('End date'),
				'value'     => isset($enddate) ? $enddate : date('Y-m-d', $leagueData['EndTime']),
				'fieldName'	=> ''
			),
			array(
				'type'      => 'time',
				'id'        => 'endtime',
				'prefix'    => 'endtime_',
				'title'     => $this->__('End time'),
                                'value'     => isset($endtime) ? $endtime : '',
				'fieldName'	=> ''
			),
			array(
				'type'      => 'date',
				'id'        => 'signupdeadline',
				'prefix'    => 'signupdeadline_',
				'title'     => $this->__('Signup deadline'),
				'value'     => isset($signupdate) ? $signupdate : date('Y-m-d', $leagueData['SignupdDeadline']),
				'fieldName'	=> ''
			),
			array(
				'type'      => 'select',
				'title'     => $this->__('Cup size'),
				'id'        => 'cupsize',
				'options'   => $CupsizeOptions
			),
			array(
				'type'      => 'select',
				'title'     => $this->__('Team size'),
				'id'        => 'teamsize',
				'options'   => $TeamsizeOptions
			),
		)
		
   );
?>
<div class="esportform">
	<?php
		echo ContentHelper::ParseEditorData($EditorData);
	?>
</div>