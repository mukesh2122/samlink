<?php echo $this->renderBlock('admin/esport/common/progressmenu_cup',array('progress' => 'rounds')); ?>
<?php
	$DefaultRoundLengthHoursOptions = array();
	for ($i=0;$i<7;$i++)
	{
		$DefaultRoundLengthHoursOptions[] = array(
			'value'     => $i,
			'selected'  => isset($_SESSION['createcup']['DefaultRoundLengthHours']) && $i == $_SESSION['createcup']['DefaultRoundLengthHours'] ? 1 : 0,
			'text'      => $i
		);
	}

	$DefaultRoundLengthMinutesOptions = array();
	for ($i=0;$i<60;$i+=10)
	{
		$DefaultRoundLengthMinutesOptions[] = array(
			'value'     => $i,
			'selected'  => isset($_SESSION['createcup']['DefaultRoundLengthMinutes']) && $i == $_SESSION['createcup']['DefaultRoundLengthMinutes'] ? 1 : 0,
			'text'      => $i
		);
	}

	$DefaultBestOfMatchCountOptions = array();
	for ($i=0;$i<=4;$i++)
	{
		$i1 = $i+1;
		$i2 = $i*2+1;
		$DefaultBestOfMatchCountOptions[] = array(
			'value'     => $i2,
			'selected'  => isset($_SESSION['createcup']['DefaultBestOfMatchCount']) && $i2 == $_SESSION['createcup']['DefaultBestOfMatchCount'] ? 1 : 0,
			'text'      => $i2 . " (First to win $i1)" 
		);
	}
	
	$roundCount = 10;//Hardcoded. TODO: wher can it be found??
	$RoundNrOptions = array();
	for ($i=0;$i<$roundCount;$i++)
	{
		$RoundNrOptions[] = array(
			'value'     => $i,
			'selected'  => isset($_SESSION['createcup']['RoundNr']) && $i == $_SESSION['createcup']['RoundNr'] ? 1 : 0,
			'text'      => "Round ".($i+1)
		);
	}

   $url = isset($_SESSION['createcup']['ID_GAME']) ? '/'.$_SESSION['createcup']['ID_GAME'] : '';	
   $EditorData = array(
		'ID'            => 0,//$user->ID_PLAYER,
		'Post'          => MainHelper::site_url('esport/admin/createcup/5'.$url),
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
				'value'     => $this->__('Round formats'),
				'info'      => $this->__('Here you specify the default round length and round interval for all rounds. This will generate a list containing the individual rounds. Thereafter you will be able to edit the individual rounds.')
			),
			array(
				'type'      => 'select',
				'title'     => $this->__('Default Round Length (Hours)'),
				'id'        => 'DefaultRoundLengthHours',
				'options'   => $DefaultRoundLengthHoursOptions
			),
			array(
				'type'      => 'select',
				'title'     => $this->__('Default Round Length (Minutes)'),
				'id'        => 'DefaultRoundLengthMinutes',
				'options'   => $DefaultRoundLengthMinutesOptions
			),
			array(
				'type'      => 'select',
				'title'     => $this->__('Default Round Interval (Hours)'),
				'id'        => 'DefaultRoundIntervalHours',
				'options'   => $DefaultRoundLengthHoursOptions
			),
			array(
				'type'      => 'select',
				'title'     => $this->__('Default Round Interval (Minutes)'),
				'id'        => 'DefaultRoundIntervalMinutes',
				'options'   => $DefaultRoundLengthMinutesOptions
			),
			array(
				'type'      => 'select',
				'title'     => $this->__('Best of Match Count'),
				'id'        => 'DefaultBestOfMatchCount',
				'options'   => $DefaultBestOfMatchCountOptions
			),
			/*array(
				'type'      => 'select',
				'title'     => $this->__('Round'),
				'id'        => 'RoundNr',
				'options'   => $RoundNrOptions
			),

						array(
				'title'     => $this->__('Cup Name'),
				'id'        => 'cupName',
				'value'     => 'Cup name'
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
				'value'     => '',
				'fieldName'	=> '',
			),
			array(
				'type'      => 'date',
				'id'        => 'enddate',
				'prefix'    => 'enddate_',
				'title'     => $this->__('End date'),
				'value'     => '',
				'fieldName'	=> '',
			),
			array(
				'type'      => 'date',
				'id'        => 'signupdeadline',
				'prefix'    => 'signupdeadline_',
				'title'     => $this->__('Signup deadline'),
				'value'     => '',
				'fieldName'	=> '',
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
			),*/
		)
		
   );
?>


<div class="esportform">
	<?php
		echo ContentHelper::ParseEditorData($EditorData);
	?>
</div>

<div class="mt10">
	<!--@using ESport.Model;
	@using ESport.Frontend.Model;
	@model ESportVM

	@{
		HelperResult formUrl = ESHelpers.Url("createCup2");
		TournamentCreateDataExt leagueData = Admin.Inst.TournamentCreateData;
		int selectedRoundNumber = leagueData.SelectedRoundNumber;

		int roundCount = 0;
		IList<CupRound> roundList = null;
		CupRound roundInfo = leagueData.GetCupRound(selectedRoundNumber);
		if (roundInfo != null)
		{
			roundList = leagueData.Rounds;
			roundCount = roundList.Count;
		}
	}-->


		<?php if (1 == 2): ?>
		
		<form id="CupRoundForm" class="team_size_form" action="<?php echo MainHelper::site_url('esport/admin/createcup/5');?>" method="post">
		<div class="ct_contentMono rounded_5">
			<div>
				<input name="LeagueID" type="hidden" value="@leagueData.LeagueID"/>
				<input name="CreateStep" type="hidden" value="3"/>
				<input name="UpdateCupRound" type="hidden" value="true"/>
			
				<label for="RoundNr">Round</label>
				<div class="margin_b10 clearfix">
					<select id="RoundNr" class="ct_autoSubmit" name="SelectedRoundNumber" tabindex="5" style="display: none; ">
						@for (int i = 0; i < roundCount; i++)
						{
							string selected = (selectedRoundNumber == i) ? "selected" : "";
							<option value="@i" @selected>@("Round " + (i + 1))</option>
						}
					</select>
				</div>

				<label for="StartTime">Round Start Time</label>
				<input id="StartTime" value="@roundInfo.StartTime" type="text" name="RoundStartTime" class="text_input margin_b10" style="width:341px"/>

				<label for="EndTime">Round End Time</label>
				<input id="EndTime" value="@roundInfo.EndTime" type="text" name="RoundEndTime" class="text_input margin_b10" style="width:341px"/>

				<label for="BestOfCount">Best of Match Count</label>
				<div class="margin_b10 clearfix">
					<select id="BestOfCount" class="dropkick_lightWide" name="BestOfCount" tabindex="5" style="display: none; ">
						@foreach (KeyValuePair<int, string> kvp in TournamentCreateDataExt.BestOfCountList)
						{
							string selected = (roundInfo.BestOfMatchCount == kvp.Key) ? "selected" : "";
							<option value="@kvp.Key" @selected>@kvp.Value</option>
						}
					</select>
				</div>
			</div>
			<input type="submit" value="Submit" class="ct_button green"/>
			</div>
		</form>


		<h3>Rounds</h3>
		
			<table class="table table_striped table_bordered gradient_thead mt5 mb10">
				<thead>
					<tr>
						<th>Round</th>
						<th>Start Time</th>
						<th>End Time</th>
						<th>Best Of</th>
					</tr>
				</thead>

				<tbody>
					@foreach (CupRound cr in roundList)
					{
						<tr>
							<td>@cr.RoundNumber</td>
							<td>@cr.StartTime</td>
							<td>@cr.EndTime</td>
							<td>@(cr.BestOfMatchCount + " Match(es)")</td>
						</tr>
					}
				</tbody>
			</table>

		<form id="CupRoundNextForm" class="team_size_form" action="<?php echo MainHelper::site_url('esport/admin/createcup/5');?>" method="post">
			<input name="CreateStep" type="hidden" value="4"/>

			<a class="ct_button light_blue pull_left ct_prev" style="height:20px; padding-top:2px ">Back</a>
			<input type="submit" value="Next" class="ct_button green pull_right"/>
		</form>
		<?php endif; ?>
	</div>
</div>