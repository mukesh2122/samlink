<div class="esports_right_column">


	<?php
		$ESportGames = Doo::db()->query("CALL esp_GetAllESportGames();")->fetchall();
		$GameOptions = array();
		foreach ($ESportGames as $game)
		{
			$GameOptions[] = array(
				'value'     => $game['ID_GAME'],
				'selected'  => ($game['ID_GAME']==$leagueData->FK_GAME) ? true : false,
				'text'      => $game['GameName']
			);
		}

		$Regions = Doo::db()->query("CALL esp_GetAllRegions();")->fetchall();
		$RegionOptions = array();
		foreach ($Regions as $region)
		{
			$RegionOptions[] = array(
				'value'     => $region['ID_REGION'],
				'selected'  => ($region['ID_REGION']==$leagueData->FK_REGION) ? true : false,
				'text'      => $region['RegionName']
			);
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
			'Twelve' => 12,
			'Fourteen' => 14,
			'Sixteen' => 0x10,
			'Twenty' => 20,
			'TwentyFour' => 0x18,
			'TwentyEight' => 0x1c,
			'ThirtyTwo' => 0x20,
		);

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
				'selected'  => ($v==$leagueData->PlayMode) ? true : false,
				'text'      => $k
			);
		}

		$FormatsOptions = array();
			foreach ($formats as $k=>$v)
			{
				$FormatsOptions[] = array(
					'value'     => $v,
					'selected'  => ($v==$leagueData->Format) ? true : false,
					'text'      => "$v vs $v"
				);
			}
                $esport = new Esport();
                if(isset($leagueData->Image)){
                    $league = new EsLeagues();
                    $league->Image = $leagueData->Image;
                }
                $sponsorone = isset($leagueData->sponsor_one) ? $leagueData->sponsor_one : 0 ;
                $sponsortwo = isset($leagueData->sponsor_two) ? $leagueData->sponsor_two : 0 ;
                $sponsorthree = isset($leagueData->sponsor_three) ? $leagueData->sponsor_three : 0 ;
                $SponsorList = $esport->getAllSponsors();
		
		$EditorData = array(
			'ID'            => $ID_LEAGUE,
			'Post'          => MainHelper::site_url('esport/admin/createleague'.(($edit_action == 'EditLeague')?'/'.$ID_LEAGUE:'') ),
			'MainOBJ'       => array(),
			'formid'        => 'editForm', // TODO: test if this actually is needed
			'Title'         => 'User',
			'ID_PRE'        => 'user',
			'NativeFields' 	=> array(),
			'PersonalInformation' => array(),
			'Elements'      => array(
				array(
					'type'      => 'info',
					'value'     => $this->__('League Editor'),
					'info'      => $this->__('Create league')
				),
				array(
					'type'    	=>	'hidden',
					'values'    => array ( array('action', $edit_action)	)
				),
				array(
					'title'     => $this->__('League Name'),
					'id'        => 'LeagueName',
					'value'     => $leagueData->LeagueName
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
					'value'     => date('Y-m-d', $leagueData->StartTime),
					'fieldName'	=> '',
				),
				array(
					'type'      => 'date',
					'id'        => 'enddate',
					'prefix'    => 'enddate_',
					'title'     => $this->__('End date'),
					'value'     => date('Y-m-d', $leagueData->EndTime),
					'fieldName'	=> '',
				),
				array(
					'title'     => $this->__('Min Rating'),
					'id'        => 'minrating',
					'value'     => $leagueData->LowerRankingRestrictionRange
				),
				array(
					'title'     => $this->__('Mix Rating'),
					'id'        => 'maxrating',
					'value'     => $leagueData->UpperRankingRestrictionRange
				),
				array(
					'title'     => $this->__('League size'),
					'id'        => 'LeagueSize',
					'value'     => $leagueData->LeagueSize
				),
				array(
					'type'      => 'select',
					'title'     => $this->__('Format'),
					'id'        => 'Format',
					'options'   => $FormatsOptions
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
					'value'     => $leagueData->EntryFee
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
<!--
@using ESport.Model;
@using ESport.Frontend.Model;
@model ESportVM
           
@{
    IList<Region> regions = ESportVM.Inst.GetRegions();
    IList<Game> games = ESportVM.Inst.GetGames().AsReadOnly();
    IList<int> formats = ESportVM.Inst.Formats;
    //LeagueVM league = ESportVM.Inst.SelectedLeague;
    //int leagueID = -1;
    HelperResult formUrl;
    TournamentCreateData leagueData = Admin.Inst.TournamentCreateData;
    string buttonText = "Create League";
    List<Language> languages = ESportVM.ESportAPI.GetLanguages();
    if (leagueData.LeagueID > 0)
    {
        buttonText = "Update League";
        formUrl = ESHelpers.Url("updateLeague");
    }
    else
    {
        formUrl = ESHelpers.Url("createLeague");
    }
}

@if (ESportVM.UserVM.isSuperUser)
{
    @ESHelpers.HomeSharedCont(8)

    @*
    <script type="text/javascript" src="http://playnation.eu/global/js/ckeditor/plugins/autogrow/plugin.js?t=B8DJ5M3"></script>
    <script type="text/javascript" src="http://playnation.eu/global/js/ckeditor/plugins/image/dialogs/image.js?t=B8DJ5M3"></script>
    <link rel="stylesheet" type="text/css" href="http://playnation.eu/global/js/ckeditor/skins/kama/dialog.css?t=B8DJ5M3"/>@**@
    
    <div class="list_header paragraph">
	    <h1>League Editor</h1>
        @if (leagueData.LeagueID > 0)
        {
        <div class="mt5">
            <a class="button button_medium light_blue" href="@ESHelpers.Url("showLeague", leagueData.LeagueID)">Go to league</a>
        </div>
        }
    </div>
    @*<a class="button button_medium light_blue" href="@ESHelpers.Url("showLeague", leagueData.LeagueID)">Go to league</a>
    @*<a href="@ESHelpers.Url("showLeague", leagueData.LeagueID)" style="color:Black; font-weight:bold; font-size:larger">Go to league</a>*@
    
    <form id="createLeagueForm" class="team_size_form" action="@formUrl" method="post">
    @*<form id="createLeagueForm" class="team_size_form" action="@ESHelpers.Url("createLeague")" method="post">*@
        <input id="LeagueID" name="LeagueID" type="hidden" value="@leagueData.LeagueID"/>
        <label for="LeagueName">League Name</label>
		<input id="LeagueName" value="@leagueData.LeagueName" type="text" name="LeagueName" class="text_input margin_b10" style="width:341px"/>

        <label for="Game">Game</label>
        <div class="margin_b10 clearfix">
            <select id="Game" class="dropkick_lightWide" name="GameID" tabindex="5" style="display: none; ">
                @foreach (Game game in games)
                {
                    <option value="@game.GameID">@game.GameName</option>
                }
                @*<option value="1" selected>Europe</option>*@
		    </select>
        </div>

        <label for="Region">Region</label>
        <div class="margin_b10 clearfix">
        <select id="RegionID" class="dropkick_lightWide" name="RegionID" tabindex="5" style="display: none; ">
            @foreach (Region region in regions)
            {
                <option value="@region.RegionID">@region.RegionName</option>
            }
		</select>
        </div>

		<label for="StartDate">Start Date</label>
		<input id="StartDate" value="@leagueData.StartDate" type="text" name="StartDate" class="text_input margin_b10" style="width:341px"/>

        <label for="EndDate">End Date</label>
        <input id="EndDate" value="@leagueData.EndDate" type="text" name="EndDate" class="text_input margin_b10" style="width:341px"/>

        <label for="MinRating">Min Rating</label>
		<input id="MinRating" value="@leagueData.MinRating" type="text" name="MinRating" class="text_input margin_b10" style="width:341px"/>

        <label for="MaxRating">Max Rating</label>
        <input id="MaxRating" value="@leagueData.MaxRating" type="text" name="MaxRating" class="text_input margin_b10" style="width:341px"/>

        <label for="LeagueSize">League Size</label>
        <input id="LeagueSize" value="@leagueData.LeagueSize" type="text" name="LeagueSize" class="text_input margin_b10" style="width:341px"/>

        <label for="Format">Format</label>
        <div class="margin_b10 clearfix">
        <select id="Format" class="dropkick_lightWide" name="Format" tabindex="5" style="display: none; ">
            @foreach (int i in formats)
            {
                <option value="@i">@(i) vs @(i)</option>
            }
		</select>
        </div>

        <label for="Playmode">Playmode</label>
        <div class="margin_b10 clearfix">
        <select id="PlayMode" class="dropkick_lightWide" name="PlayMode" tabindex="5" style="display: none; ">
            <option value="1">Free To Play</option>
            <option value="2">Pay To Play Credits</option>
            <option value="4">Pay To Play Coins</option>
		</select>
        </div>

        <label for="EntryFee">Entry Fee</label>
        <input id="EntryFee" value="@leagueData.EntryFee" type="text" name="EntryFee" class="text_input margin_b10" style="width:341px"/>

        <div id="LeagueDesc">
            @AdminHelpers.ContentEditor(leagueData.Content, languages, leagueData.languageID, "League description")
        </div>

        <div class"mt20">
            <input type="submit" value="@buttonText" class="light_blue es_button"/>
        </div>
	</form>
    @*<script type="text/javascript">        $('#LanguageID').dropkick();</script>
    @*<a class="button button_medium light_blue btn" onclick="alert($('#createLeagueForm').serialize());" href="#">Create League</a>*@
}
-->
</div>
