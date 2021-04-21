<?php
class AdminEsportController extends AdminController {
	var $data;

	public function getMenuData()
	{
            if(Auth::isUserLogged() === TRUE) 
                    {
            }
            else 
            {
                    exit;
            }

            $data['title'] = $this->__('eSport');
            $data['body_class'] = 'index_esport';
            $data['selected_menu'] = 'esport';
            return $data;
	}
	
	public function admin() {
		$this->moduleOff();

		$p = User::getUser();

		if($p->canAccess('Esport') === FALSE)
			DooUriRouter::redirect(MainHelper::site_url('esport/profile'));

		$esport = new Esport();
                
		$this->data['type'] = !empty($this->params['type']) ? $this->params['type'] : 'esport';

                $profile['player'] = $p;
		$profile['hideMenu'] = true;
                
		$list['type'] = $this->data['type'];
		$list['crumb'] = $this->getCrumb();
		$list['profile'] = $profile;
		$list['esMenuSelected'] = 'admin';

		$data = $this->getMenuData();
		$data['left'] = PlayerHelper::playerLeftSide();
		$data['footer'] = MainHelper::bottomMenu();
		$data['header'] = MainHelper::topMenu();
		$data['right'] = '';
		$data['content'] = $this->renderBlock('esport/main',$list);
	
		$this->render1Col($data);
	}

	public function showleagues() {
		$this->moduleOff();

		$p = User::getUser();

		if($p->canAccess('Esport') === FALSE)
			DooUriRouter::redirect(MainHelper::site_url('esport/admin'));

		$esport = new Esport();

                $this->data['type'] = !empty($this->params['type']) ? $this->params['type'] : 'esport';
		
                $profile['player'] = $p;
		$profile['hideMenu'] = true;

                $list['type'] = $this->data['type'];
		$list['crumb'] = $this->getCrumb();
		$list['profile'] = $profile;
		$list['esMenuSelected'] = 'admin';

		$data = $this->getMenuData();
		$data['left'] = PlayerHelper::playerLeftSide();
		$data['footer'] = MainHelper::bottomMenu();
		$data['header'] = MainHelper::topMenu();
		$data['right'] = '';
		$data['content'] = $this->renderBlock('esport/showleagues/main',$list);

		$this->render1Col($data);
	}

	
	public function saveCupDate($step)
	{
		if ($step==="submit")
		{
			if (isset($_SESSION['createcup']))
			{
                                $esport = new Esport();
				$s = $_SESSION['createcup'];
				extract($s);
/*				echo "$CupType</br>";
				echo "$cupName</br>";
				echo "$game</br>";
				echo "$region</br>";
				echo "$startdate_year</br>";
				echo "$startdate_month</br>";
				echo "$startdate_day</br>";
				echo "$enddate_year</br>";
				echo "$enddate_month</br>";
				echo "$enddate_day</br>";
				echo "$signupdeadline_year</br>";
				echo "$signupdeadline_month</br>";
				echo "$signupdeadline_day</br>";
				echo "$cupsize</br>";
				echo "$teamsize</br>";
				echo "$minrating</br>";
				echo "$maxrating</br>";
				echo "$PlayMode</br>";
				echo "$entryfee</br>";
				echo "$DefaultRoundLengthHours</br>";
				echo "$DefaultRoundLengthMinutes</br>";
				echo "$DefaultRoundIntervalHours</br>";
				echo "$DefaultRoundIntervalMinutes</br>";
				echo "$DefaultBestOfMatchCount</br>";
				echo "$RoundNr</br>";
				echo "$RoundStartTime_year</br>";
				echo "$RoundStartTime_month</br>";
				echo "$RoundStartTime_day</br>";
				echo "$RoundEndTimeyear</br>";
				echo "$RoundEndTimemonth</br>";
				echo "$RoundEndTimeday</br>";
				echo "$ReplayUploads</br>";
				echo "$ReplayDownloads</br>";
				echo "$LeagueDesc</br>";
*/
				//$startdate = "$startdate_year/$startdate_month/$startdate_day 15:15";
				$starttime_hours = $starttime_hours != 'Hour' ? $starttime_hours : 0;
				$starttime_minutes = $starttime_minutes != 'Min' ? $starttime_minutes : 0;
                                $startdate = mktime($starttime_hours,$starttime_minutes,0,$startdate_month,$startdate_day,$startdate_year);				
				//$enddate = "$enddate_year/$enddate_month/$enddate_day";
				$endtime_hours = $endtime_hours != 'Hour' ? $endtime_hours : 0;
				$endtime_minutes = $endtime_minutes != 'Min' ? $endtime_minutes : 0;
				$enddate = mktime($endtime_hours,$endtime_minutes,0,$enddate_month,$enddate_day,$enddate_year);				
				
                                $signupdeadline = "$signupdeadline_year/$signupdeadline_month/$signupdeadline_day";
				$signupdeadline = date(strtotime($signupdeadline));
				
                                $host = Auth::isUserLogged() === true ? User::getUser()->ID_PLAYER : 0; 
				//Unknown..
				$Access = 'PublicAll';
				$LooserPicksMap = 1;
				$PlayThirdPlaceMatch = 0;

				$query = 
				"INSERT INTO es_leagues
				(
					TournamentType,
					LeagueName,
					CupType,
					FK_GAME,
					FK_REGION,
					LowerRankingRestrictionRange,
					UpperRankingRestrictionRange,
					LeagueSize,
                                        StartTime,
                                        EndTime,
					SignUpDeadline,
					PlayMode,
					Format,
					EntryFee,
					AccessType,
					isActive,
					BestOfMatchCount,
					LooserPicksMap,
					PlayThirdPlaceMatch,
					ReplayDownloads,
					ReplayUploads,
					Image,
                                        Host,
                                        LeagueDesc
				)
				VALUES
				(
					'Cup',
					'$cupName',
					'$CupType',
					$game,
					$region,
					$minrating,
					$maxrating,
					$cupsize,
					$startdate,
					$enddate,
					$signupdeadline,
					$PlayMode,
					$teamsize,
					$entryfee,
					'$Access',
					1,
					$DefaultBestOfMatchCount,
					$LooserPicksMap,
					$PlayThirdPlaceMatch,
					'$ReplayUploads',
					'$ReplayDownloads',
					'$change_league_picture',
                                        $host,
                                        '$LeagueDesc'    
				);
				";
				//echo $query;exit;
				Doo::db()->query($query);

				//Set Sponsors
                                if(isset($sponsor_one) && $sponsor_one != 0){
                                    $esport->SetSponsor($ID_LEAGUE_NEW, $sponsor_one, 1);
                                }
                                if(isset($sponsor_two) && $sponsor_two != 0){
                                    $esport->SetSponsor($ID_LEAGUE_NEW, $sponsor_two, 2);
                                }
                                if(isset($sponsor_three) && $sponsor_three != 0){
                                    $esport->SetSponsor($ID_LEAGUE_NEW, $sponsor_three, 3);
                                }
                                
                                //Set mappool
                                $maps = explode(',',$mappool);                               
                                $esport->SetMaps($ID_LEAGUE_NEW,$maps);
			}
		}//End of if $post['submit]
                
		if ($step==0)
		{
			//Init cup create
			$_SESSION['createcup'] = array();
		}
		if ($step>=1 && $step<=8)
		{
			$s = $_SESSION['createcup'];
			//Init cup create
			foreach ($_POST as $k=>$v)
			{
				$s[$k] = $v;
			}
			$_SESSION['createcup'] = $s;
		}
	}
	
	public function createcup() {
		$this->moduleOff();
		
		$p = User::getUser();

		if($p->canAccess('Esport') === FALSE)
			DooUriRouter::redirect(MainHelper::site_url('esport/profile'));
		
                $esport = new Esport();
                
                if(isset($this->params['id']) && !empty($this->params['id'])){
                    $_SESSION['createcup'] = $esport->CreateSession($this->params['id']);
                }
		$step = isset($this->params['step']) ? $this->params['step'] : 0;
                
		//Save the cupdata from form(s) and submit
		$this->saveCupDate($step);
              
                $profile['player'] = $p;
		$profile['hideMenu'] = true;

                $list['type'] = $this->data['type'];
		$list['crumb'] = $this->getCrumb();
		$list['profile'] = $profile;
		$list['step'] = $step;
		$list['esMenuSelected'] = 'admin';
                
		$data = $this->getMenuData();
		$data['left'] = PlayerHelper::playerLeftSide();
		$data['footer'] = MainHelper::bottomMenu();
		$data['header'] = MainHelper::topMenu();
		$data['right'] = '';
		$data['content'] = $this->renderBlock('esport/createcup/main',$list);
	
		$this->render1Col($data);
	}

	public function createleague() {
		$this->moduleOff();
		
		$p = User::getUser();
                $esport = new Esport();

		if($p->canAccess('Esport') === FALSE)
			DooUriRouter::redirect(MainHelper::site_url('esport/admin'));

                //Create league
		if (isset($_POST['action']))
		{
			if ($_POST['action']=='CreateLeague')
			{
				extract($_POST);
				$startdate = "$startdate_year/$startdate_month/$startdate_day";
				$startdate = date(strtotime($startdate));				
				$enddate = "$enddate_year/$enddate_month/$enddate_day";
				$enddate = date(strtotime($enddate));				
				
				$query = "CALL esp_CreateLeague($game,1,$region,'$LeagueName',$minrating,$maxrating,$LeagueSize,0,0,
					$startdate,$startdate,$enddate,$PlayMode,$Format,0,1,0,0,$entryfee,0,@pID_LEAGUE);";

				//echo $query;exit;
				Doo::db()->query($query);

				DooUriRouter::redirect(MainHelper::site_url('esport/admin'));
			}
			if ($_POST['action']=='EditLeague')
			{
				extract($_POST);

				$startdate = "$startdate_year/$startdate_month/$startdate_day";
				$startdate = date(strtotime($startdate));				
				$enddate = "$enddate_year/$enddate_month/$enddate_day";
				$enddate = date(strtotime($enddate));				
				$ID_LEAGUE = $this->params['id'];
				
				$query = "UPDATE es_leagues SET
					LeagueName='$LeagueName',
					FK_GAME=$game,
					FK_REGION=$region,
					StartTime='$startdate',
					EndTime='$enddate',
					LowerRankingRestrictionRange=$minrating,
					UpperRankingRestrictionRange=$maxrating,
					LeagueSize=$LeagueSize,
					Format=$Format,
					PlayMode=$PlayMode,
					EntryFee=EntryFee,
					Image='$change_league_picture' 
					WHERE ID_LEAGUE=$ID_LEAGUE";

				Doo::db()->query($query);

				//DooUriRouter::redirect(MainHelper::site_url('esport/admin'));
			}
		}
		
		$edit_action = 'CreateLeague';
		$ID_LEAGUE = 0;

		//Edit
                if(isset($this->params['id'])){
                     $leagueData= $esport->getTournamentByID($this->params['id']);   
                }
		else
		{
			$leagueData = new EsLeagues();
                        $leagueData->LeagueName = LeagueName;
			$leagueData->FK_GAME = 0;
                        $leagueData->FK_REGION = 0;
                        $leagueData->StartTime = time();
                        $leagueData->EndTime = time();
                        $leagueData->LowerRankingRestrictionRange = 0;
                        $leagueData->UpperRankingRestrictionRange = 999999;
                        $leagueData->LeagueSize = 100;
                        $leagueData->Format = 0;
                        $leagueData->PlayMode = 8;
                        $leagueData->EntryFee = 0;
                        $leagueData->Image = '';
		}


                $profile['player'] = $p;
		$profile['hideMenu'] = true;		
                
                $list['type'] = $this->data['type'];
		$list['crumb'] = $this->getCrumb();
                $list['profile'] = $profile;
                $list['esMenuSelected'] = 'admin';
		$list['edit_action'] = $edit_action;
		$list['ID_LEAGUE'] = $ID_LEAGUE;
		$list['leagueData'] = $leagueData;

		$data = $this->getMenuData();
		$data['left'] = PlayerHelper::playerLeftSide();
		$data['footer'] = MainHelper::bottomMenu();
		$data['header'] = MainHelper::topMenu();
		$data['right'] = '';
		$data['content'] = $this->renderBlock('esport/createleague/main',$list);
	
		$this->render1Col($data);
	}


	public function editladder() {
		$this->moduleOff();
		
		$p = User::getUser();

		if($p->canAccess('Esport') === FALSE)
			DooUriRouter::redirect(MainHelper::site_url('esport/admin'));

		$esport = new Esport();
	
		//Update edit
		if (isset($_POST['action']))
		{
			if ($_POST['action']=='submitall')
			{
				$query = "
					UPDATE es_ladderranges SET min={$_POST['min0']},max={$_POST['max0']} WHERE entry=1;
					UPDATE es_ladderranges SET min={$_POST['min1']},max={$_POST['max1']} WHERE entry=2;
					UPDATE es_ladderranges SET min={$_POST['min2']},max={$_POST['max2']} WHERE entry=3;
					UPDATE es_ladderranges SET min={$_POST['min3']},max={$_POST['max3']} WHERE entry=4;
					UPDATE es_ladderranges SET min={$_POST['min4']},max={$_POST['max4']} WHERE entry=5;
					";
				Doo::db()->query($query);
				DooUriRouter::redirect(MainHelper::site_url('esport/admin/editladder'));
			}
			
		}

                $profile['player'] = $p;
                $profile['hideMenu'] = true;
                
                $list['type'] = $this->data['type'];
		$list['crumb'] = $this->getCrumb();
		$list['profile'] = $profile;
		$list['esMenuSelected'] = 'admin';

		$data = $this->getMenuData();
		$data['left'] = PlayerHelper::playerLeftSide();
		$data['footer'] = MainHelper::bottomMenu();
		$data['header'] = MainHelper::topMenu();
		$data['right'] = '';
		$data['content'] = $this->renderBlock('esport/editladder/main',$list);
	
		$this->render1Col($data);
	}

	public function achievements() {
		$this->moduleOff();
		
		$p = User::getUser();

		if($p->canAccess('Esport') === FALSE)
			DooUriRouter::redirect(MainHelper::site_url('esport/admin'));

                $profile['player'] = $p;
		$profile['hideMenu'] = true;

		$list['type'] = $this->data['type'];
		$list['crumb'] = $this->getCrumb();
		$list['profile'] = $profile;
		$list['esMenuSelected'] = 'admin';

		$data = $this->getMenuData();
		$data['left'] = PlayerHelper::playerLeftSide();
		$data['footer'] = MainHelper::bottomMenu();
		$data['header'] = MainHelper::topMenu();
		$data['right'] = '';
		$data['content'] = $this->renderBlock('esport/achievements/main',$list);
	
		$this->render1Col($data);
	}

	public function editachievement() {
		$this->moduleOff();
		
		$p = User::getUser();

		if($p->canAccess('Esport') === FALSE)
			DooUriRouter::redirect(MainHelper::site_url('esport/admin'));
	
		$ID_TEAM = (isset($this->params['teamid'])) ? $this->params['teamid'] : 0;

		//Add new achievement
		if (isset($_POST['action']))
		{
			if ($_POST['action']=='addachievement')
			{
				extract($_POST);	
				$query = "INSERT INTO es_achievements (Title,Image,ID_TEAM) VALUES ('$Title','$Image',$ID_TEAM)";
				Doo::db()->query($query);
			}
			DooUriRouter::redirect(MainHelper::site_url('esport/admin/achievements'));
		}


		$acData	= array ('Title'=>'Achievement','Image'=>'achi_example.png');
        
                $profile['player'] = $p;
		$profile['hideMenu'] = true;
		
                $list['type'] = $this->data['type'];
		$list['crumb'] = $this->getCrumb();
                $list['profile'] = $profile;
		$list['ID_TEAM'] = $ID_TEAM;
		$list['acData'] = $acData;
		$list['esMenuSelected'] = 'admin';

		$data = $this->getMenuData();
		$data['left'] = PlayerHelper::playerLeftSide();
		$data['footer'] = MainHelper::bottomMenu();
		$data['header'] = MainHelper::topMenu();
		$data['right'] = '';
		$data['content'] = $this->renderBlock('esport/editachievement/main',$list);
	
		$this->render1Col($data);
	}

	public function deleteachievement() {
		$ID_ACHIEVEMENT = (isset($this->params['id'])) ? $this->params['id'] : 0;

		//Delete achievement
		if ($ID_ACHIEVEMENT!=0)
		{
			$query = "DELETE FROM es_achievements WHERE ID_ACHIEVEMENT=$ID_ACHIEVEMENT";
			Doo::db()->query($query);
			DooUriRouter::redirect(MainHelper::site_url('esport/admin/achievements'));
		}
	}
        
        public function deletetournament(){
            $esport = new Esport();
            
            $esport->deleteTournament($this->params['id']);
            DooUriRouter::redirect(MainHelper::site_url('esport/admin/showleagues'));
        }
}
?>
