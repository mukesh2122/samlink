<?php

/**
  Esport Controller Class
 *
 *
 */

class EsportController extends SnController {

	var $data;

	public function beforeRun($resource, $action) {
		if ($rs = parent::beforeRun($resource, $action))
		{
			return $rs;
		}

		$this->addCrumb($this->__('eSport'), MainHelper::site_url('esport'));
		$this->data['type'] = !empty($this->params['type']) ? $this->params['type'] : 'esport';
		$this->data['user'] = User::getUser();
                $this->data['free2play'] = '1';
                $this->data['pay2playcredits'] = '2';
                $this->data['pay2playcoins'] = '4';
	}

	public function moduleOff()
	{
		$user = new User();
		$ignoreAvailable = 0;

		if(Auth::isUserLogged()):
			$player = $user->getByID(User::getUser()->ID_PLAYER);
			$ignoreAvailable = $player->ID_USERGROUP;
		endif;

		if($ignoreAvailable == 0)
		{
			$notAvailable = MainHelper::TrySetModuleNotAvailableByTag('esport');
			if ($notAvailable)
			{
				$data['title'] = $this->__('eSport');
				$data['body_class'] = 'index_esport';
				$list['type'] = $this->data['type'];
				$data['selected_menu'] = 'esport';
				$data['left'] = PlayerHelper::playerLeftSide();
				$data['right'] = PlayerHelper::playerRightSide();
				$data['content'] = $notAvailable;
				$data['footer'] = MainHelper::bottomMenu();
				$data['header'] = MainHelper::topMenu();
				$this->render3Cols($data);
				exit;
			}
		}
	}

	public function getMenuData()
	{
		$data['title'] = $this->__('eSport');
		$data['body_class'] = 'index_esport';
		return $data;
	}

	public function index() {
		$this->moduleOff();

		$data = $this->getMenuData();
		$data['left'] = PlayerHelper::playerLeftSide('wall');
		$data['footer'] = MainHelper::bottomMenu();
		$data['header'] = MainHelper::esportMenu();
		$data['right'] = PlayerHelper::playerRightSide();

		$data['content'] = '';
		$this->render3Cols($data);
	}

	public function profile() {
		$this->moduleOff();
                                
		$p = User::getUser();	//Current user. Could also be viewed player.
                
                if(!Auth::isUserLogged())
			DooUriRouter::redirect(MainHelper::site_url('esport'));
                
		$esport = new Esport();
                
		if (isset($this->params['participant']))
		{
			$ID_TEAM = $this->params['participant'];
			$p = $esport->GetPlayerByTeam($ID_TEAM,$p);
		}
                
                $games = $esport->GetGamesByFK_TEAM($p->ID_TEAM);
                $teams = $esport->GetPlayerTeams($p->ID_TEAM);
                
		$profile['player'] = $p;
		$profile['hideMenu'] = true;
		$profile['teams'] = $teams;
		$profile['singleteam'] = $esport->getTeamByID($p->ID_TEAM);
		$profile['games'] = $games;
		$profile['maxplayedgame'] = $esport->GetMaxPlayedGame($games);
		$profile['highestGameLeague'] = $esport->GetHighestAchievedLeagueInGames($games, $p->ID_TEAM);
		$profile['matchHistory'] = $esport->GetMatchHistoryByFK_TEAM($p->ID_TEAM);
		$profile['gameRatings'] = $esport->GetGameRatingsByTeams($teams);
		$profile['attendedTournaments'] = $esport->GetAttendedTournamentsByFK_TEAM($p->ID_TEAM);
		$profile['tournaments'] = $esport->GetTournamentsByFK_TEAM($p->ID_TEAM);
		$profile['achievements'] = $esport->GetAchievements($p->ID_PLAYER);

		$list['profile'] = $profile;
                $list['type'] = $this->data['type'];
		$list['crumb'] = $this->getCrumb();
		$list['esMenuSelected'] = 'profile';
                
                $data = $this->getMenuData();
		$data['left'] = PlayerHelper::playerLeftSide();
		$data['footer'] = MainHelper::bottomMenu();
		$data['header'] = MainHelper::esportMenu();
		$data['selected_menu'] = 'esport/profile';
		$data['right'] = '';
		$data['content'] = $this->renderBlock('esport/profile/main',$list);

		$this->render1Col($data);
	}

	public function ladder() {
		$this->moduleOff();
                
		$p = User::getUser();
                
                if(!$p->isEsportPlayer())
			DooUriRouter::redirect(MainHelper::site_url('esport/profile'));
		
		$esport = new Esport();
		$game = new Games();

		$teams = $esport->GetPlayerTeams($p->ID_TEAM);
		$games = $esport->GetGamesByFK_TEAM($p->ID_TEAM);
		$leagues = $esport->GetLadderLeagues();
                
                //Games rating
		$ID_GAME = isset($this->params['id']) ? $this->params['id'] : 'all';
                
                    $allRatings = ($ID_GAME=='all') ? array() : $esport->GetAllRatingsByGame($ID_GAME);
                    $teamRatings = ($ID_GAME=='all') ? array() : $esport->GetAllTeamRatingsByGame($ID_GAME);
                    $gameinfo = $ID_GAME != 'all' ? $game->getGameByID($ID_GAME) : new SnGames; 
               
		//My rating
		$myRating = ($ID_GAME=='all') ? 0 : $esport->GetTotalRating($p->ID_TEAM,$allRatings);

		//Show by game
		$selectedLeague = isset($this->params['league']) ? $this->params['league'] : $esport->GetLeagueIndexByRating($myRating);
		$selectedTier = isset($this->params['tier']) ? $this->params['tier'] : 0;
                $l = $leagues[$selectedLeague-1];
                $dLeague = ($l['max']+1 - $l['min']) / 5;
                $tierMin = $l['min'] + ($dLeague * ($selectedTier - 1));
                $tierMax = $tierMin + $dLeague;
                
		if($selectedTier == 0){
			$l = $leagues[$selectedLeague-1];
                        $dLeague = ($l['max']+1 - $l['min']) / 5;
                        $tierMax = $l['min'];
                        
			for($i = 1; $i <= 5; $i++):
				$tierMin = $tierMax;
				$tierMax = $tierMin + $dLeague;
		
                                if($tierMin <= $myRating && $tierMax >= $myRating ){
					$selectedTier = $i;
					break;
				}
			endfor;
		};
                
                $ladder['tierMax'] = $tierMax;
                $ladder['tierMin'] = $tierMin;
                
                $profile['player'] = $p;
		$profile['hideMenu'] = true;
		$profile['teams'] = $teams;
                
		$ladder['allRatings'] = $allRatings;
		$ladder['teamRatings'] = $teamRatings;
		$ladder['selectedLeague'] = $selectedLeague;
		$ladder['selectedTier'] = $selectedTier;
                $ladder['leagues'] = $leagues;
                $ladder['myAVGRating'] = $myRating;
		$ladder['gameinfo'] = $gameinfo;
                
		$list['profile'] = $profile;
		$list['ladder'] = $ladder;
		$list['games'] = $games;
		$list['ID_GAME'] = $ID_GAME;
                $list['type'] = $this->data['type'];
		$list['crumb'] = $this->getCrumb();
		$list['esMenuSelected'] = 'ladder';

                $data = $this->getMenuData();
		$data['left'] = PlayerHelper::playerLeftSide();
		$data['footer'] = MainHelper::bottomMenu();
		$data['header'] = MainHelper::esportMenu();
		$data['selected_menu'] = 'esport/ladder';
		$data['right'] = '';
		$data['content'] = $this->renderBlock('esport/ladder/main',$list);

		$this->render1Col($data);
	}


	public function tournaments() {
		$this->moduleOff();

		$p = User::getUser();
                
                if(!$p->isEsportPlayer())
			DooUriRouter::redirect(MainHelper::site_url('esport/profile'));
		                
		$esport = new Esport();

		$games = $esport->GetGamesByFK_TEAM($p->ID_TEAM);
		$playmodes = $esport->GetPlayModes();
                
                //Find tournaments. Get all if no searchstring is chosen
		if(isset($_POST['searchstring']) && !empty($_POST['searchstring'])):
			$tournamentsFree = $esport->SearchTournaments($_POST['searchstring'],$playmodes['Free2Play'],'League',false);
			$tournamentsCredits = $esport->SearchTournaments($_POST['searchstring'],$playmodes['Pay2PlayCredits'],'League',false);
			$tournamentsCoins = $esport->SearchTournaments($_POST['searchstring'],$playmodes['Pay2PlayCoins'],'League',false);
		else:
			$tournamentsFree = $esport->GetAllTournaments($playmodes['Free2Play'],'League', false);
			$tournamentsCredits = $esport->GetAllTournaments($playmodes['Pay2PlayCredits'],'League',false);
			$tournamentsCoins = $esport->GetAllTournaments($playmodes['Pay2PlayCoins'],'League',false);
		endif;
                
		$profile['tournamentsFree'] = $tournamentsFree;
		$profile['tournamentsCredits'] = $tournamentsCredits;
		$profile['tournamentsCoins'] = $tournamentsCoins;
		$profile['player'] = $p;
		$profile['hideMenu'] = true;
		$profile['games'] = $games;

		$list['profile'] = $profile;
		$list['esMenuSelected'] = 'tournaments';
                $list['type'] = $this->data['type'];
		$list['crumb'] = $this->getCrumb();

		$data = $this->getMenuData();
		$data['left'] = PlayerHelper::playerLeftSide();
		$data['footer'] = MainHelper::bottomMenu();
		$data['header'] = MainHelper::topMenu();
		$data['right'] = '';
		$data['content'] = $this->renderBlock('esport/tournaments/main',$list);

		$this->render1Col($data);
	}

	public function tournamentinfo() {
		$this->moduleOff();

		$p = User::getUser();

		$esport = new Esport();
		$game = new Games();

		if (!isset($this->params['id']))
                    DooUriRouter::redirect(MainHelper::site_url('esport/tournaments'));

                if(!$p->isEsportPlayer())
                    DooUriRouter::redirect(MainHelper::site_url('esport/profile'));
                
		$ID_LEAGUE = $this->params['id'];
		$tournamentinfo = $esport->getTournamentByID($ID_LEAGUE);
		$tournamentteams = $esport->GetTeamsInLeague($ID_LEAGUE);
                $isSignedUp = $esport->isTeamSignedUp($p->ID_TEAM, $ID_LEAGUE);
		$games = $esport->GetGamesByFK_TEAM($p->ID_TEAM);

                if(isset($this->params['error'])){
                    $profile['error'] = $this->__("You don't have enough [_1] to join this tournament",array($tournamentinfo->BetType));
                }
                
                $profile['games'] = $games;
                $profile['player'] = $p;
		$profile['singleteam'] = $esport->getTeamByID($p->ID_TEAM);
		$profile['hideMenu'] = true;
		$profile['tournamentinfo'] = $tournamentinfo;
		$profile['gameinfo'] = $game->GetGameByID($tournamentinfo->FK_GAME);
		$profile['tournamentteams'] = $tournamentteams;
		$profile['isSignedUp'] = $isSignedUp;
                $profile['signedTeam'] = $isSignedUp ? $esport->getSignedUpTeamByPlayer($p->ID_PLAYER, $ID_LEAGUE) : ''; 

		$list['profile'] = $profile;
		$list['esMenuSelected'] = 'tournaments';
		$list['type'] = $this->data['type'];
		$list['crumb'] = $this->getCrumb();

		$data = $this->getMenuData();
		$data['left'] = PlayerHelper::playerLeftSide();
		$data['footer'] = MainHelper::bottomMenu();
		$data['header'] = MainHelper::topMenu();
		$data['right'] = '';
		$data['content'] = $this->renderBlock('esport/tournamentinfo/main',$list);

		$this->render1Col($data);
	}

	public function spotlight() {
		$this->moduleOff();

		$p = User::getUser();
                
                if(!Auth::isUserLogged())
			DooUriRouter::redirect(MainHelper::site_url('esport/news'));
                
                if(!$p->isEsportPlayer())
			DooUriRouter::redirect(MainHelper::site_url('esport/register'));
                
		$esport = new Esport();
		
		$list = array();
                
                $ID_TEAM = isset($this->params['id']) ? $this->params['id'] : $p->ID_TEAM; 
		$fanclubs = $esport->getAllFanclubs();
		$games = $esport->GetGamesByTeam($ID_TEAM);
                $lastplayed = $esport->getLastPlayedMatches($ID_TEAM);
                $team = $esport->getTeamByID($ID_TEAM);
                $team->updateViews();
  
                $profile['playerfanclub'] = $esport->GetPlayerFanclubRel($p->ID_PLAYER, $ID_TEAM);
		$profile['player'] = $p;
		$profile['hideMenu'] = true;
		$profile['games'] = $games;
		$profile['fans'] = $esport->getFansByTeam($ID_TEAM);
                $profile['lastgame'] = !empty($lastplayed) ? Games::getGameByID($lastplayed[0]->FK_GAME) : '';
		$profile['fanclubs'] = $fanclubs;
                $profile['fanclub'] = $team;
		$profile['highestGameLeague'] = $esport->GetHighestAchievedLeagueInGames($games, $ID_TEAM);
		$profile['gamingRig'] = $esport->GetComputerSpecificationsByTeam($ID_TEAM);
                $profile['wallitems'] = $esport->getSpotlightItems($ID_TEAM);
		$profile['social'] = Social::getSocialsWithUrls($ID_TEAM, SOCIAL_OWNERTYPE_TEAM);
		$profile['likes'] = $esport->GetTotalLikes($ID_TEAM);
                $profile['bottom_menu'] = isset($this->params['botmenu']) ? $this->params['botmenu'] : 'wallfeed';
		$profile['top_menu'] = isset($this->params['topmenu']) ? $this->params['topmenu'] : 'profileinfo';

		$list['profile'] = $profile;
                $list['type'] = $this->data['type'];
		$list['crumb'] = $this->getCrumb();

		$data = $this->getMenuData();
		$data['selected_menu'] = 'esport/spotlight';
		$data['left'] = PlayerHelper::playerLeftSide();
		$data['footer'] = MainHelper::bottomMenu();
		$data['header'] = MainHelper::esportMenu();
		$data['content'] = $this->renderBlock('esport/fanclubs/main',$list);

		$this->render1Col($data);
	}


	public function fanclubinfo() {
		$this->moduleOff();

		$p = User::getUser();

		$esport = new Esport();

		if (!isset($this->params['id']))
                        DooUriRouter::redirect(MainHelper::site_url('esport/fanclubs'));

		$ID_TEAM = $this->params['id'];
		//$fanclubinfo = $esport->GetTournamentInfoByLeagueID($ID_LEAGUE);
		$games = $esport->GetGamesByFK_TEAM($this->params['id']);

                $profile['player'] = $p;
		$profile['hideMenu'] = true;
                $profile['playerfanclub'] = $esport->GetPlayerFanclubRel($p->ID_PLAYER, $this->params['id']);
                $profile['games'] = $games;
                $profile['fanclub'] = $esport->getFanclubByID($this->params['id']);
                $profile['teams'] = $esport->GetTeamByID($this->params['id']);
                
		$list['profile'] = $profile;
		$list['esMenuSelected'] = 'fanclubs';
                $list['type'] = $this->data['type'];
		$list['crumb'] = $this->getCrumb();

		$data = $this->getMenuData();
		$data['left'] = PlayerHelper::playerLeftSide();
		$data['footer'] = MainHelper::bottomMenu();
		$data['header'] = MainHelper::topMenu();
		$data['right'] = '';
		$data['content'] = $this->renderBlock('esport/fanclubinfo/main',$list);

		$this->render1Col($data);
	}

	public function betting() {
		$this->moduleOff();

		$p = User::getUser();
                
                if(!Auth::isUserLogged())
                    DooUriRouter::redirect(MainHelper::site_url('esport/profile'));
                
		$esport = new Esport();

		$profile['player'] = $p;
		$profile['hideMenu'] = true;

		$list['profile'] = $profile;
		$list['esMenuSelected'] = 'betting';
		$list['type'] = $this->data['type'];
		$list['crumb'] = $this->getCrumb();

		$data = $this->getMenuData();
		$data['left'] = PlayerHelper::playerLeftSide();
		$data['footer'] = MainHelper::bottomMenu();
		$data['header'] = MainHelper::topMenu();
		$data['right'] = '';
		$data['content'] = $this->renderBlock('esport/betting/main',$list);

		$this->render1Col($data);
	}

	public function coverage() {
		$this->moduleOff();
                
		$p = User::getUser();

                $twitch = new Twitch();

                $channels = $twitch->getSortedChannels();
		$activeChannel = isset($this->params['name']) ? $twitch->getChannelByTwitchName($this->params['name']) : $channels['startChannel'];

		$profile['player'] = $p;
		$profile['hideMenu'] = false;

		$list['channels'] = $channels;
		$list['activeChannel'] = $activeChannel;
		$list['profile'] = $profile;
		$list['type'] = $this->data['type'];
		$list['crumb'] = $this->getCrumb();

		$data = $this->getMenuData();
		$data['left'] = PlayerHelper::playerLeftSide();
		$data['footer'] = MainHelper::bottomMenu();
		$data['header'] = MainHelper::esportMenu();
		$data['selected_menu'] = 'esport/coverage';
		$data['right'] = '';
		$data['content'] = $this->renderBlock('esport/coverage/main',$list);

		$this->render1Col($data);
	}
        
	public function tempadmin() {
		$this->moduleOff();
                
                if(!Auth::isUserLogged())
                    DooUriRouter::redirect(MainHelper::site_url('esport/profile'));
                
		$p = User::getUser();

		$profile['player'] = $p;
		$profile['hideMenu'] = false;

		$list['profile'] = $profile;
		$list['type'] = $this->data['type'];
		$list['crumb'] = $this->getCrumb();

		$data = $this->getMenuData();
		$data['left'] = PlayerHelper::playerLeftSide();
		$data['footer'] = MainHelper::bottomMenu();
		$data['header'] = MainHelper::esportMenu();
		$data['selected_menu'] = 'esport/tempadmin';
		$data['right'] = '';
		$data['content'] = $this->renderBlock('esport/createteam/main',$list);

		$this->render1Col($data);
	}
        
	public function submitscores() {
		$this->moduleOff();
                
                if(!Auth::isUserLogged())
                    DooUriRouter::redirect(MainHelper::site_url('esport/news'));
                
                if(!isset($_POST))
                    DooUriRouter::redirect(MainHelper::site_url('esport/myteam/challenges'));
                
		$p = User::getUser();
                $esport = new Esport();
                
                $match = $esport->getMatchByIDWithLeagueData($_POST['id']);
                
                $matchinfo['game'] = Games::getGameByID($match->FK_GAME);
                $matchinfo['challenger'] = Esport::getTeamByID($match->ChallengerID);
                $matchinfo['opponent'] = Esport::getTeamByID($match->OpponentID);
                $matchinfo['match'] = $match;
                
		$profile['player'] = $p;
		$profile['hideMenu'] = false;

		$list['matchinfo'] = $matchinfo;
		$list['profile'] = $profile;
		$list['type'] = $this->data['type'];
		$list['crumb'] = $this->getCrumb();

		$data = $this->getMenuData();
		$data['left'] = PlayerHelper::playerLeftSide();
		$data['footer'] = MainHelper::bottomMenu();
		$data['header'] = MainHelper::esportMenu();
		$data['selected_menu'] = 'esport/teamcenter';
		$data['right'] = '';
		$data['content'] = $this->renderBlock('esport/challenge_submit_result/main',$list);

		$this->render1Col($data);
	}
        
	public function createchallenge() {
		$this->moduleOff();
                
                if(!Auth::isUserLogged())
                    DooUriRouter::redirect(MainHelper::site_url('esport/news'));
                
                if(empty($this->params['type']))
                    DooUriRouter::redirect(MainHelper::site_url('esport/spotlight'));
                
		$p = User::getUser();
                $ID_TEAM = $p->ID_TEAM;
                
                if(isset($_SESSION['createchallenge']['opponentinfo']) && $_SESSION['createchallenge']['opponentinfo'] == $ID_TEAM)
                   unset($_SESSION['createchallenge']);
                
                $esport = new Esport();
                
		$profile['player'] = $p;
		$profile['id'] = $ID_TEAM;
		$profile['hideMenu'] = false;
		$profile['gamelist'] = isset($_SESSION['createchallenge']['opponentinfo']) ? $esport->getGamesInCommon($_SESSION['createchallenge']['opponentinfo'], $ID_TEAM) : $esport->getGamesByTeam($ID_TEAM);
                $profile['team'] = $esport->getTeamByID($ID_TEAM);
                $profile['opponent'] = isset($_SESSION['createchallenge']['opponentinfo']) ? $esport->getTeamByID($_SESSION['createchallenge']['opponentinfo']) : '';

		$list['profile'] = $profile;
		$list['type'] = $this->data['type'];
		$list['crumb'] = $this->getCrumb();
                $list['playmode'] = $this->params['type'];

		$data = $this->getMenuData();
		$data['left'] = PlayerHelper::playerLeftSide();
		$data['footer'] = MainHelper::bottomMenu();
		$data['header'] = MainHelper::esportMenu();
		$data['selected_menu'] = 'esport/teamcenter';
		$data['right'] = '';
		$data['content'] = $this->renderBlock('esport/createchallenge/main',$list);

		$this->render1Col($data);
	}
        
	public function editspotlight() {
		$this->moduleOff();
                
                if(!Auth::isUserLogged())
                    DooUriRouter::redirect(MainHelper::site_url('esport/login'));
                
		$p = User::getUser();
		$esport = new Esport();
                $team = Esport::getTeamByID($p->ID_TEAM);

		$profile['player'] = $p;
                $profile['team'] = Esport::getTeamByID($p->ID_TEAM);
                $profile['games'] = $esport->getGamesByTeam($team->ID_TEAM);
                $profile['socials'] = Social::getAllSocialsWithUrls($team->ID_TEAM, SOCIAL_OWNERTYPE_TEAM);
                $profile['gamingrig'] = $esport->getAllComputerSpecificationsbyTeam($team->ID_TEAM);
		$profile['hideMenu'] = false;

		$list['profile'] = $profile;
		$list['type'] = $this->data['type'];
		$list['crumb'] = $this->getCrumb();

		$data = $this->getMenuData();
		$data['left'] = PlayerHelper::playerLeftSide();
		$data['footer'] = MainHelper::bottomMenu();
		$data['header'] = MainHelper::esportMenu();
		$data['selected_menu'] = 'esport/spotlight';
		$data['right'] = '';
		$data['content'] = $this->renderBlock('esport/edit_spotlight/main',$list);

		$this->render1Col($data);
	}
        
	public function editteam() {
		$this->moduleOff();
                
                if(!Auth::isUserLogged())
                    DooUriRouter::redirect(MainHelper::site_url('esport/login'));
                
                if(empty($this->params['id']))
                    DooUriRouter::redirect(MainHelper::site_url('esport/teamcenter'));
                
		$p = User::getUser();
		$esport = new Esport();
                $ID_TEAM = $this->params['id'];
                $team = Esport::getTeamByID($ID_TEAM);

		$profile['player'] = $p;
                $profile['team'] = Esport::getTeamByID($ID_TEAM);
                $profile['games'] = $esport->getGamesByTeam($ID_TEAM);
                $profile['socials'] = Social::getAllSocialsWithUrls($ID_TEAM, SOCIAL_OWNERTYPE_TEAM);
                $profile['roster'] = $esport->getAllPlayersByTeam($ID_TEAM);
		$profile['hideMenu'] = false;

		$list['profile'] = $profile;
		$list['type'] = $this->data['type'];
		$list['crumb'] = $this->getCrumb();

		$data = $this->getMenuData();
		$data['left'] = PlayerHelper::playerLeftSide();
		$data['footer'] = MainHelper::bottomMenu();
		$data['header'] = MainHelper::esportMenu();
		$data['selected_menu'] = 'esport/teamcenter';
		$data['right'] = '';
		$data['content'] = $this->renderBlock('esport/editteam/main',$list);

		$this->render1Col($data);
	}
        
	public function forum() {
		$this->moduleOff();
                
		$p = User::getUser();

		$profile['player'] = $p;
		$profile['hideMenu'] = false;

		$list['profile'] = $profile;
		$list['type'] = $this->data['type'];
		$list['crumb'] = $this->getCrumb();

		$data = $this->getMenuData();
		$data['left'] = PlayerHelper::playerLeftSide();
		$data['footer'] = MainHelper::bottomMenu();
		$data['header'] = MainHelper::esportMenu();
		$data['selected_menu'] = 'esport/teamcenter';
		$data['right'] = '';
		$data['content'] = $this->renderBlock('esport/team_forum/main',$list);

		$this->render1Col($data);
	}
        
	public function verifychallenge() {
		$this->moduleOff();
                
                if(!Auth::isUserLogged())
                    DooUriRouter::redirect(MainHelper::site_url('login/loginfirst'));
                
                if(empty($_POST) || empty($this->params['type']))
                    DooUriRouter::redirect(MainHelper::site_url('esport/spotlight/challenges'));
                
		$p = User::getUser();
                
                $timezone = new GeTimezones();
                $timezone->ID_TIMEZONE = $_POST['timezone'];

		$profile['player'] = $p;
		$profile['hideMenu'] = false;

                $gamedata['info'] = $_POST;
                $gamedata['timezone'] = $timezone->getOne();
                $gamedata['challenger'] = Esport::getTeamByID($_POST['challengerinfo']);
                $gamedata['opponent'] = Esport::getTeamByID($_POST['opponentinfo']);;
                $gamedata['game'] = Games::getGameByID($_POST['gameinfo']);;
                
		$list['gamedata'] = $gamedata;
		$list['profile'] = $profile;
		$list['playmode'] = $this->params['type'];
		$list['type'] = $this->data['type'];
		$list['crumb'] = $this->getCrumb();

		$data = $this->getMenuData();
		$data['left'] = PlayerHelper::playerLeftSide();
		$data['footer'] = MainHelper::bottomMenu();
		$data['header'] = MainHelper::esportMenu();
		$data['selected_menu'] = 'esport/teamcenter';
		$data['right'] = '';
		$data['content'] = $this->renderBlock('esport/createchallenge/verify/main',$list);

		$this->render1Col($data);
	}
        
	public function acceptchallenge() {
		$this->moduleOff();
                
                if(!Auth::isUserLogged())
                    DooUriRouter::redirect(MainHelper::site_url('esport/news'));
                
                if(empty($this->params['match']))
                    DooUriRouter::redirect(MainHelper::site_url('esport/spotlight'));
                
		$p = User::getUser();
                
                $esport = new Esport();
                $timezone = new GeTimezones();
                
                $match = $esport->getMatchByIDWithLeagueData($this->params['match']);
                //$timezone->ID_TIMEZONE = $_POST['timezone'];

		$profile['player'] = $p;
		$profile['hideMenu'] = false;

                $gamedata['info'] = $match;
                //$gamedata['timezone'] = $timezone->getOne();
                $gamedata['challenger'] = Esport::getTeamByID($match->ChallengerID);
                $gamedata['opponent'] = Esport::getTeamByID($match->OpponentID);
                $gamedata['game'] = Games::getGameByID($match->FK_GAME);
                
		$list['gamedata'] = $gamedata;
		$list['profile'] = $profile;
		$list['playmode'] = Esport::getPlayMode($match->PlayMode);
		$list['type'] = $this->data['type'];
		$list['crumb'] = $this->getCrumb();

		$data = $this->getMenuData();
		$data['left'] = PlayerHelper::playerLeftSide();
		$data['footer'] = MainHelper::bottomMenu();
		$data['header'] = MainHelper::esportMenu();
		$data['selected_menu'] = 'esport/teamcenter';
		$data['right'] = '';
		$data['content'] = $this->renderBlock('esport/myteamchallenges/verify/main',$list);

		$this->render1Col($data);
	}
        
	public function allchallenges() {
		$this->moduleOff();

                if(empty($this->params['category']))
                    DooUriRouter::redirect(MainHelper::site_url('esport/myteam/challenges'));
                
		$p = User::getUser();
                $esport = new Esport();
                
                $challenges = new EsMatches();
                
                switch($this->params['category']){
                    case 'pending':
                        $challenges = $esport->getMatchesByParticipantAndState($p->ID_TEAM, $esport->GetMatchState('Open'));
                    break;
                    case 'active':
                        $challenges = $esport->getMatchesByParticipantAndState($p->ID_TEAM, $esport->GetMatchState('Active'));
                    break;
                    case 'finished':
                        $challenges = $esport->getMatchesByParticipantAndState($p->ID_TEAM, $esport->GetMatchState('Closed'));
                    break;
                }
                
		$profile['challenges'] = $challenges;
		$profile['player'] = $p;
		$profile['hideMenu'] = false;

		$list['profile'] = $profile;
		$list['challenge_category'] = $this->params['category'];
		$list['type'] = $this->data['type'];
		$list['crumb'] = $this->getCrumb();

		$data = $this->getMenuData();
		$data['left'] = PlayerHelper::playerLeftSide();
		$data['footer'] = MainHelper::bottomMenu();
		$data['header'] = MainHelper::esportMenu();
		$data['selected_menu'] = 'esport/teamcenter';
		$data['right'] = '';
		$data['content'] = $this->renderBlock('esport/myteamchallenges/full_list/main',$list);

		$this->render1Col($data);
	}

	public function news() {
		$this->moduleOff();

		$news = new News();
		$settings = new SySettings;
		$result = $settings->getone(array(
			'select' => 'ValueInt'
		,	'where'  => 'ID_SETTING = "NwNewsLimit"'
		));
		if ($result) {
			$newsPerPage = $result->ValueInt;
		}
		else {
			$newsPerPage = -1;
		}

		$frontpage = new NwFrontpage;
		$moduleState = $frontpage->getModuleStates();
		$newsTotal = $news->getNewsTotal();

                $list = array();
		$list['NewsCategories'] = Esport::getAllGames();
		$list['NewsCategoriesType'] = false;
		$list['showEvents'] = $moduleState['Upcoming Events']['News'];
                
		$list['recentNews'] = $news->getPlatformNews(22,5);
		$list['otherNews'] = $news->getPlatformNews(22,7);
		$list['featureVideos'] = $news->getPlatformNews(22,5);

		$list['news_slider'] = '';
		//if ($moduleState['Slider']['News']) {
			$list['news_slider'] .= $this->renderBlock('esport/news/slider_new');
		//}
		$list['news_hightlights'] = '';
		if ($moduleState['Highlights']['News']) {
			$list['news_hightlights'] .= $this->renderBlock('news/highlights');
		}
		
                $data['title'] = $this->__('News');
		$data['body_class'] = 'index_esport';
		$data['selected_menu'] = 'esport/news';
		$data['footer'] = MainHelper::bottomMenu();
		$data['header'] = MainHelper::esportMenu();
		$data['content'] = $this->renderBlock('esport/news/main',$list);

		$this->render1Col($data);
	}
        
        public function articleview(){
		$this->moduleOff();

		if(!Auth::isUserLogged())
			DooUriRouter::redirect(MainHelper::site_url('login/loginfirst'));

		$this->moduleOff();
                
		$p = User::getUser();
                $lang = array_search($this->params['lang'], Doo::conf()->lang);
                $url = Url::getUrlByName($this->params['article'], URL_NEWS, $lang);
                $news = News::getArticleByID($url->ID_OWNER, $lang);
                 
                $profile['article'] = $news;
                $profile['author'] = User::getById($news->ID_AUTHOR);
                $profile['game'] = Games::getGameByID($news->ID_OWNER);
		$profile['player'] = $p;
		$profile['hideMenu'] = false;

		$list['profile'] = $profile;
		$list['type'] = $this->data['type'];
		$list['crumb'] = $this->getCrumb();

		$data = $this->getMenuData();
		$data['left'] = PlayerHelper::playerLeftSide();
		$data['footer'] = MainHelper::bottomMenu();
		$data['header'] = MainHelper::esportMenu();
		$data['selected_menu'] = 'esport/news';
		$data['right'] = '';
		$data['content'] = $this->renderBlock('esport/news/single_article',$list);

		$this->render1Col($data);
	}
        
        public function challenges(){
		$this->moduleOff();

		if(!Auth::isUserLogged())
			DooUriRouter::redirect(MainHelper::site_url('login/loginfirst'));

		$this->moduleOff();
                
		$p = User::getUser();
                $esport = new Esport();
                $ID_TEAM = $p->ID_TEAM;

                $challenges['pending'] = $esport->getMatchesByParticipantAndState($ID_TEAM, $esport->GetMatchState('Open'));
                $challenges['active'] = $esport->getMatchesByParticipantAndState($ID_TEAM, $esport->GetMatchState('Active'));;
                $challenges['finished'] = $esport->getMatchesByParticipantAndState($ID_TEAM, $esport->GetMatchState('Closed'));;
                
		$profile['player'] = $p;
		$profile['id'] = $ID_TEAM;
		$profile['hideMenu'] = false;

		$list['challenges'] = $challenges;
		$list['profile'] = $profile;
		$list['type'] = $this->data['type'];
		$list['crumb'] = $this->getCrumb();

		$data = $this->getMenuData();
		$data['left'] = PlayerHelper::playerLeftSide();
		$data['footer'] = MainHelper::bottomMenu();
		$data['header'] = MainHelper::esportMenu();
		$data['selected_menu'] = 'esport/myteam';
		$data['right'] = '';
		$data['content'] = $this->renderBlock('esport/myteamchallenges/main',$list);

		$this->render1Col($data);
	}

	public function instantchallenge() {
		$p = User::getUser();

		$esport = new Esport();
		if (isset($this->params['id']))
		{

			//Respond the challenge in this match. Set matchstate to active now and set opponentID.
			$active = $esport->GetMatchState('Active');
			$ID_MATCH = $this->params['id'];
			$ID_TEAM = $p->ID_TEAM;
			$ID_GAME = $esport->GetGameIDByMatch($ID_MATCH);

			$match = $esport->GetMatch($ID_MATCH);
			$ID_LEAGUE = $match['FK_LEAGUE'];
			$ID_CHALLENGER = $match['ChallengerID'];

			//Rating before
			$gameRatings = $esport->GetAllRatingsByGame($ID_GAME);
			$OpponentRatingBefore = $esport->GetGameRating($ID_TEAM,$ID_GAME,$ID_LEAGUE);
			//echo "teamid: $ID_TEAM, gameid: $ID_GAME, leagueid: $ID_LEAGUE, rating: $OpponentRatingBefore";exit;

			//Set the Challenge
			$query = "UPDATE es_matches SET OpponentID=$ID_TEAM,State=$active,OpponentRatingBefore=$OpponentRatingBefore WHERE ID_MATCH=$ID_MATCH";
			Doo::db()->query($query);
			$query = "	INSERT INTO es_matchplayer_rel (FK_MATCH,FK_TEAM,FK_PLAYER,MatchPlayerState) VALUES($ID_MATCH,$ID_TEAM,0,1);
						INSERT INTO es_matchplayer_rel (FK_MATCH,FK_TEAM,FK_PLAYER,MatchPlayerState) VALUES($ID_MATCH,$ID_CHALLENGER,0,1);";
			Doo::db()->query($query);


			/*
			echo "Match: $ID_MATCH<br/>";
			$query = "select *
				from es_matches
				left join es_leagues
				on es_leagues.ID_LEAGUE = es_matches.FK_LEAGUE
				left join sn_games
				on sn_games.ID_GAME = es_leagues.FK_GAME
				where ID_MATCH=$ID_MATCH";
			$matches = Doo::db()->query($query)->fetchall();
			if (count($matches)==1)
			{
				$match = $matches[0];
				echo "Game: {$match['GameName']}<br/>";
				echo "League: {$match['LeagueName']}<br/>";
				echo "ChallengerID: {$match['ChallengerID']}<br/>";
				echo "OpponentID: {$match['OpponentID']}<br/>";
			}
			*/

		}
		DooUriRouter::redirect(MainHelper::site_url('esport/profile'));
	}

	public function quickmatchsignup() {
		$p = User::getUser();

		$esport = new Esport();
		if (isset($this->params['id']))
		{
			//Create a match-challenge for this game in league. Set matchstate to open now and set challengerID.
			$open = $esport->GetMatchState('Open');
			$ID_TEAM = $p->ID_TEAM;
			$ID_LEAGUE = $this->params['id'];
			$playmode = $this->params['playmode'];
			$betsize = $this->params['betsize'];
			$ID_GAME = $esport->GetGameIDByLeague($ID_LEAGUE);
			//Rating before
			$gameRatings = $esport->GetAllRatingsByGame($ID_GAME);
			$ChallengerRatingBefore = $esport->GetGameRating($ID_TEAM,$ID_GAME,$ID_LEAGUE);
			//echo "gameid: $ID_GAME, leagueid: $ID_LEAGUE, rating: $ChallengerRatingBefore";exit;

			//Create the Challenge
			$query = "INSERT INTO es_matches (FK_LEAGUE,ChallengerID,State,PlayMode,BetSize,ChallengerRatingBefore)
				VALUES
				($ID_LEAGUE,$ID_TEAM,$open,$playmode,$betsize,$ChallengerRatingBefore)";
			Doo::db()->query($query);

			//Add to league
			$query = "CALL esp_AddLeagueParticipant($ID_LEAGUE,$ID_TEAM,1)";
			Doo::db()->query($query);
		}
		//DooUriRouter::redirect(MainHelper::site_url('esport/profile'));
	}


	public function reportmatchresult() {
		$p = User::getUser();

		$esport = new Esport();
		
                if (isset($_POST['action']))
		{
			if (isset($_POST['submit']))
			{
				$ID_MATCH = $_POST['ID_MATCH'];
				$whoreports = $_POST['whoreports'];
				$Score = $_POST['challengerscore'] . " - " . $_POST['opponentscore'];
				switch ($whoreports)
				{
					default:
					case 'challenger':
						$query = "UPDATE es_matches SET ChallengerReportedScore='$Score' WHERE ID_MATCH=$ID_MATCH";
						break;
					case 'opponent':
						$query = "UPDATE es_matches SET OpponentReportedScore='$Score' WHERE ID_MATCH=$ID_MATCH";
						break;
				}
				//Report a result
				Doo::db()->query($query);


				//Verify the result
				$closed = $esport->GetMatchState('Closed');
				$match = $esport->GetMatch($ID_MATCH);
				$ID_GAME = $esport->GetGameIDByMatch($ID_MATCH);
				$ID_LEAGUE = $match['FK_LEAGUE'];
                                $league = $esport->GetTournamentByID($match['FK_LEAGUE']);
				$ChallengerID = $match['ChallengerID'];
				$OpponentID = $match['OpponentID'];
				$PlayMode = $match['PlayMode'];
				$c_score = $match['ChallengerReportedScore'];
				$o_score = $match['OpponentReportedScore'];
				$MatchWinnerID = 0;
				$MatchLoserID = 0;
				$OpponentRatingBefore = $match['OpponentRatingBefore'];
				$ChallengerRatingBefore = $match['ChallengerRatingBefore'];
				$BetSize = $match['BetSize'];

				if ($c_score!="" && $o_score!="")
				{
					if ($c_score == $o_score)
					{
						$s = explode(" - ",$c_score);
						$s_c = $s[0];
						$s_o = $s[1];

						$winnerRating = $OpponentRatingBefore;
						$loserRating = $ChallengerRatingBefore;
						$challengerWon = 0;
						$challengerLost = 0;
						$opponentWon = 0;
						$opponentLost = 0;
						if ($s_c > $s_o)
						{
							$challengerWon = 1;
							$opponentLost = 1;
							//Challenger wins
							$MatchWinnerID = $ChallengerID;
							$MatchLoserID = $OpponentID;
							$winnerRating = $ChallengerRatingBefore;
							$loserRating = $OpponentRatingBefore;
						}
						if ($s_o > $s_c)
						{
							$opponentWon = 1;
							$challengerLost = 1;
							$MatchWinnerID = $match['OpponentID'];
							$MatchLoserID = $match['ChallengerID'];
						}

						//calculate new ratings
						$newRating = $esport->CalcRating($winnerRating, $loserRating);
						$newWinnerRating = round($newRating['NewWinnerRating']);
						$newLoserRating = round($newRating['NewLoserRating']);

						$newChallengerRating = ($s_c > $s_o) ? $newWinnerRating : $newLoserRating;
						$newOpponentRating = ($s_c > $s_o) ? $newLoserRating : $newWinnerRating;

						//Match update
						$query = "UPDATE es_matches SET MatchWinnerID=$MatchWinnerID, MatchLoserID=$MatchLoserID, State=$closed, ChallengerReportedScore='',OpponentReportedScore='',Score='$c_score' WHERE ID_MATCH=$ID_MATCH";
						Doo::db()->query($query);
                                                
                                                
						//Distribute betsize
						if ($s_o != $s_c)
						{
                                                    //Set Cup results
                                                    if($league->TournamentType == ESPORT_TOURNAMENTTYPE_CUP)
                                                    {
                                                        $matchup = $esport->getCupMatchupByMatchID($ID_MATCH);
                                                        DooUriRouter::redirect(MainHelper::site_url('/esport/reportcupmatch/'.$matchup->ID_MATCHUP.'/'.$s_c.'/'.$s_o));
                                                    }
                                                    
                                                    if($league->TournamentType == ESPORT_TOURNAMENTTYPE_QUICKMATCH && $league->EntryFee > 0){
                                                        $esport->createTransaction($owner = $MatchWinnerID , $transactiontype = ESPORT_TRANSACTION_MATCHWIN, $credittype = $league->BetType, $amount = $league->Account, $ownertype = ESPORT_TRANSACTIONTYPE_TEAM, $transactortype = ESPORT_TRANSACTIONTYPE_QUICKMATCH, $transactor = $league->ID_LEAGUE );
                                                    }
						}

						//Game rating update
						$esport->SetGameRating($ChallengerID,$ID_GAME,$ID_LEAGUE,$newChallengerRating,$PlayMode,$challengerWon,$challengerLost);
						$esport->SetGameRating($OpponentID,$ID_GAME,$ID_LEAGUE,$newOpponentRating,$PlayMode,$opponentWon,$opponentLost);

						//echo "Match is reported ok by both.";
					}
				}

			}
			DooUriRouter::redirect(MainHelper::site_url('esport/profile'));
		}


		if (isset($this->params['matchid']) && isset($this->params['reporterid']))
		{
			$ID_MATCH = $this->params['matchid'];
			$ID_TEAM = $this->params['reporterid'];
			$match = $esport->GetMatch($ID_MATCH);

			$ChallengerID = $match['ChallengerID'];
			$OpponentID = $match['OpponentID'];

			$challenger = $esport->GetTeamByID($ChallengerID);
			$opponent = $esport->GetTeamByID($OpponentID);

			$whoreports = ($ChallengerID==$ID_TEAM) ? 'challenger' : 'opponent';
			$you = '('.$this->__('You').')';
			$list = array
			(
				'ID_MATCH'=>$ID_MATCH,
				'whoreports'=>$whoreports,
				'challenger'=>$challenger,
				'ChallengerID'=>$ChallengerID,
				'opponent'=>$opponent,
				'OpponentID'=>$OpponentID,
				'ID_TEAM'=>$ID_TEAM,
				'you'=>$you
			);

			echo $this->RenderBlock('esport/common/reportmatchresult',$list);

			//echo "ChallengerID: $ChallengerID, OpponentID: $OpponentID, reporterid: $ID_TEAM, ID_MATCH: $ID_MATCH";
		}
		//DooUriRouter::redirect(MainHelper::site_url('esport/profile'));
	}

	public function playquickmatch() {
		$p = User::getUser();

		$esport = new Esport();

		$profile['player'] = $p;
		$profile['hideMenu'] = true;

		$list['profile'] = $profile;
		$list['esMenuSelected'] = 'admin';

		if (isset($this->params['id']))
		{
			$ID_GAME = $this->params['id'];

			$open = $esport->GetMatchState('Open');
			$query = "SELECT * FROM es_matches, es_teams, es_leagues
				WHERE es_matches.ChallengerID = es_teams.ID_TEAM
				AND es_matches.FK_LEAGUE = es_leagues.ID_LEAGUE
				AND es_leagues.FK_GAME=$ID_GAME
				AND (1 AND es_matches.State & $open)";
			$openMatches = Doo::db()->query($query)->fetchall();

			//Not Pay2PlayCredits at the moment..
			$playmodes = $esport->GetPlayModes();
			$Pay2PlayCredits = $playmodes['Pay2PlayCredits'];
/*			$query = "SELECT * FROM es_leagues,es_leagueteam_rel WHERE FK_GAME=$ID_GAME
				AND es_leagues.ID_LEAGUE=es_leagueteam_rel.FK_LEAGUE
				AND es_leagueteam_rel.FK_TEAM={$p->ID_TEAM}";*/
			$query = "
				SELECT * FROM es_leagues WHERE FK_GAME=$ID_GAME AND isActive AND (starttime <= UNIX_TIMESTAMP(now()) && UNIX_TIMESTAMP(now()) <= endtime)
				AND PlayMode<>$Pay2PlayCredits
				";
			$leagues = Doo::db()->query($query)->fetchall();

			echo $this->RenderBlock('esport/common/playquickmatch',array('playmodes'=>$playmodes,'p'=>$p,'leagues'=>$leagues,'openMatches'=>$openMatches));
		}
//		$this->render1Col($data);
	}

	public function addgamescollection() {
		$p = User::getUser();

		$esport = new Esport();
                $games = new Games();
		//Create the team and import the games
		
                $new_team_id = $esport->createTeam($single = true);
                
		$mygames = $games->getPlayerGames($p,100000);
                
                foreach($mygames as $game){
                    if($game->isESportGame == 1){
                        $esport->addGameToEsportTeam($new_team_id, $game->ID_GAME);  
                    }
                }
		DooUriRouter::redirect(MainHelper::site_url('esport/profile'));
	}

	public function addgametocollection() {
		$p = User::getUser();

		$esport = new Esport();
		$pDisplayName = $p->DisplayName;
		$pPlayerDatabaseID = $p->ID_PLAYER;
		$ID_TEAM = $p->ID_TEAM;

		if (isset($this->params['id']))
		{
			$ID_GAME = $this->params['id'];

			//Create the team and import the games
			$query = "insert into es_gameteam_rel
					(FK_GAME,FK_TEAM,isActive)
					VALUES
					($ID_GAME,$ID_TEAM,1)";
			$res = Doo::db()->query($query);
		}

		DooUriRouter::redirect(MainHelper::site_url('esport/profile'));
	}

	public function ajaxjoincup()
	{
		$p = User::getUser();	//Current user. Could also be viewed player.
		$esport = new Esport();

		$ID_TEAM = $_POST['ID_TEAM'];
		$ID_MATCHUP = $_POST['ID_MATCHUP'];
		$FK_PARTICIPANT = $_POST['FK_PARTICIPANT'];

		$query = "UPDATE es_cupmatchups SET $FK_PARTICIPANT = $ID_TEAM WHERE ID_MATCHUP=$ID_MATCHUP";
		$res = Doo::db()->query($query);

		$p = $esport->GetPlayerByTeam($ID_TEAM,$p);

		$data['result'] = "Player: " . $p->DisplayName . ", Matchup: " . $ID_MATCHUP;

		$this->toJSON($data, true);
	}

	public function signupcup()
	{
		$p = User::getUser();	//Current user. Could also be viewed player.
		$esport = new Esport();

		$ID_LEAGUE = $this->params['id'];
                $tournament = $esport->getTournamentByID($ID_LEAGUE);
                $team = $esport->getTeamByID($p->ID_TEAM);
                $allowSignup = false;

		$cTeam = $this->params['type'] == 'player' ? $team : $esport->getTeamByID($team->FK_GROUP);
		$ID_TEAM = $cTeam->ID_TEAM;
                
                //Determine if there is enough credits to join tournament
                switch($tournament->BetType):
                    case(ESPORT_BETTYPE_COINS):
                        $allowSignup = $cTeam->Coins >= $tournament->EntryFee ? true : false ;
                    break;
                    case(ESPORT_BETTYPE_CREDITS):
                        $allowSignup = $cTeam->Credits >= $tournament->EntryFee ? true : false ;
                    break;
                    case(ESPORT_BETTYPE_FREE):
                        $allowSignup = true;
                    break;
                endswitch;
                                   
                if($allowSignup == false){
                    DooUriRouter::redirect(MainHelper::site_url('esport/tournamentinfo/'.$ID_LEAGUE.'/error'));
                }
                
		//Join cup. Find a free place, and asure the team is not already present.
		if ($ID_TEAM!=0)
		{
                    if($tournament->TournamentType == ESPORT_TOURNAMENTTYPE_CUP){
			$query = "
				select * from es_cupmatchups where FK_CUP = $ID_LEAGUE
				and (FK_PARTICIPANT1=0 or FK_PARTICIPANT2=0)
				and Round=1
				and
				(
					select count(*) as cnt from es_cupmatchups where FK_CUP = $ID_LEAGUE
					and (FK_PARTICIPANT1=$ID_TEAM or FK_PARTICIPANT2=$ID_TEAM)
				)=0
				";
			$res = Doo::db()->query($query)->fetchall();
			//There are free places and you are not there
			if (count($res)>0)
			{
				foreach($res as $r)
				{
					$ID_MATCHUP = $r['ID_MATCHUP'];
					$p1 = $r['FK_PARTICIPANT1'];
					$p2 = $r['FK_PARTICIPANT2'];

					//Insert as challenger
					if ($p1==0)
					{
						$query = "UPDATE es_cupmatchups SET FK_PARTICIPANT1 = $ID_TEAM WHERE ID_MATCHUP=$ID_MATCHUP";
						$res = Doo::db()->query($query);
						break;
					}
					else
					{
						//Insert as oponent
						if ($p2==0)
						{
							$query = "UPDATE es_cupmatchups SET FK_PARTICIPANT2 = $ID_TEAM WHERE ID_MATCHUP=$ID_MATCHUP";
							$res = Doo::db()->query($query);
							break;
						}
					}
				}
			}
                    }
                    else if($tournament->TournamentType == ESPORT_TOURNAMENTTYPE_LEAGUE){
                        $esport->signupTournament($ID_LEAGUE, $ID_TEAM);
                    }
                    
                    if($tournament->EntryFee > 0){
                        $transactiontype = $tournament->TournamentType = 'League' ? ESPORT_TRANSACTION_LEAGUESIGNUP : ESPORT_TRANSACTION_CUPSIGNUP;
                        $ownertype = $tournament->TournamentType = 'League' ? ESPORT_TRANSACTIONTYPE_LEAGUE : ESPORT_TRANSACTIONTYPE_CUP;

                        $esport->createTransaction($ID_LEAGUE,$transactiontype,$tournament->BetType,$tournament->EntryFee,$ownertype);
                    }
		}
		DooUriRouter::redirect(MainHelper::site_url('esport/tournamentinfo/'.$ID_LEAGUE));
	}

	public function reportcupmatch()
	{
		//Update win/loose in current matchup
		$p = User::getUser();	//Current user. Could also be viewed player.
		$esport = new Esport();

		$ID_MATCHUP = $this->params['id'];
		$res1 = $this->params['r1'];
		$res2 = $this->params['r2'];

		$query = "select * from es_cupmatchups where ID_MATCHUP=$ID_MATCHUP";
		$res = Doo::db()->query($query)->fetchall();
		$MatchUp = $res[0];

		$ID_LEAGUE = $MatchUp['FK_CUP'];

		//how many rounds
		$query = "select max(Round) as maxRounds from es_cupmatchups where FK_CUP=$ID_LEAGUE";
		$mr = Doo::db()->query($query)->fetchAll();
		$nRounds = $mr[0]['maxRounds'];

		//Update win/loose
		$Round = $MatchUp['Round'];
		$query = "UPDATE es_cupmatchups SET RoundWinsP1=$res1, RoundWinsP2=$res2 WHERE ID_MATCHUP=$ID_MATCHUP";
		Doo::db()->query($query);

		$ID_TEAM = $p->ID_TEAM;
		if ($ID_TEAM!=0)
		{
		}

		//Find canditates for next round
		$query = "
			select count(*) as done
			from es_cupmatchups
			where RoundWinsP1 + RoundWinsP2 = 0
			and Round=$Round
			and FK_CUP=$ID_LEAGUE
			";
			$done = Doo::db()->query($query)->fetchall();

		//all matches in level won by someone. Pick them out for next round
		//But only available rounds.
		if ($Round<$nRounds)
		{
			if ($done[0]['done']==0)
			{
				$query = "
					select
					(IF(RoundWinsP1 > RoundWinsP2, FK_PARTICIPANT1, FK_PARTICIPANT2)) as ID_WINNER,
					es_cupmatchups.*
					from es_cupmatchups
					where round=$Round
					and FK_CUP=$ID_LEAGUE
					order by RoundIndex
				";
				$winners = array();
				$res = Doo::db()->query($query)->fetchall();
				foreach ($res as $r)
				{
					$winners[] = $r['ID_WINNER'];
				}
				for ($i=0;$i<count($winners);$i+=2)
				{
					$newIndex = $i/2;
					$ID_WINNER1 = $winners[$i];
					$ID_WINNER2 = $winners[$i+1];
					$query = "UPDATE es_cupmatchups SET FK_PARTICIPANT1=$ID_WINNER1 ,FK_PARTICIPANT2=$ID_WINNER2
						WHERE FK_CUP=$ID_LEAGUE
						AND Round={$Round}+1
						AND RoundIndex=$newIndex";
						$res = Doo::db()->query($query);
				}
			}
		}
		DooUriRouter::redirect(MainHelper::site_url('esport/tournamentinfo/'.$ID_LEAGUE));
	}

	public function ajaxUploadPhoto() {
		$c = new Esport();
		$league = new EsLeagues();
		$image = new Image();

                $result = $image->uploadImage(FOLDER_ESPORT);

		if ($result['filename'] != '') {
			$league->Image = ContentHelper::handleContentInput($result['filename']);
			$file = MainHelper::showImage($league, THUMB_LIST_100x100, true, array('width', 'no_img' => 'noimage/no_games_100x100.png'));
			echo $this->toJSON(array('success' => TRUE, 'img' => $file, 'changeProfilePic' => FALSE, 'fileName' => $result['filename']));
		} else {
			echo $this->toJSON(array('error' => $result['error']));
		}
	}
        
	public function ajaxUploadAvatar() {
		$c = new Esport();
		$fanclub = new EsFanclubs();

		$image = new Image();
		$result = $image->uploadImage(FOLDER_ESPORT_FANCLUBS);

		if ($result['filename'] != '') {
			$fanclub->ImageURL = ContentHelper::handleContentInput($result['filename']);
			$file = MainHelper::showImage($fanclub, THUMB_LIST_100x100, true, array('width', 'no_img' => 'noimage/no_game_100x100.png'));
			echo $this->toJSON(array('success' => TRUE, 'img' => $file, 'changeProfilePic' => FALSE, 'fileName' => $result['filename']));
		} else {
			echo $this->toJSON(array('error' => $result['error']));
		}
	}
        
	public function ajaxUploadScreenshot() {
		$c = new Esport();
		$match = new EsMatches();

		$image = new Image();
		$result = $image->uploadImage(FOLDER_ESPORT_SCREENSHOTS);

		if ($result['filename'] != '') {
                        $match->ChallengerScreenshot = ContentHelper::handleContentInput($result['filename']);
			$file = MainHelper::showImage($match, THUMB_LIST_100x100, true, array('width', 'no_img' => 'noimage/no_game_100x100.png'));
			echo $this->toJSON(array('success' => TRUE, 'img' => $file, 'changeProfilePic' => FALSE, 'fileName' => $result['filename']));
		} else {
			echo $this->toJSON(array('error' => $result['error']));
		}
	}
        
	public function ajaxUploadTeamPhoto() {
		$esport = new Esport();
		$team = new EsTeams();

		$image = new Image();
		$result = $image->uploadImage(FOLDER_ESPORT_TEAMS);

		if ($result['filename'] != '') {
			$team->Avatar = ContentHelper::handleContentInput($result['filename']);
			$file = MainHelper::showImage($team, THUMB_LIST_100x100, true, array('width', 'no_img' => 'noimage/no_game_100x100.png'));
			echo $this->toJSON(array('success' => TRUE, 'img' => $file, 'changeProfilePic' => FALSE, 'fileName' => $result['filename']));
		} else {
			echo $this->toJSON(array('error' => $result['error']));
		}
	}

	public function ajaxUploadMap(){
		$esport = new Esport();

		if(isset($_FILES['qqfile']) && isset($this->params['id'])){
			$ext = '.'.pathinfo($_FILES['qqfile']['name'], PATHINFO_EXTENSION);
			$name = str_replace($ext,'',$_FILES['qqfile']['name']);
			$esport->uploadMap($this->params['id'],$name);
			$map = $esport->getMapByName($name);

			if(isset($map) && !empty($map))
				echo $this->toJSON(array('success' => TRUE, 'mapid' => $map->ID_MAP,'mapname' => $map->MapName));
			 else
				echo $this->toJSON(array('error' => 'failed'));
		}
	}
        
	public function ajaxWallLike(){
		$esport = new Esport();

		if(isset($_POST['post']) && isset($_POST['reply']) && isset($_POST['like'])){
                    $replydata = explode('_', $_POST['post']);
                    
                    if($_POST['like'] == 'true'){
                        $esport->setLike(User::getUser()->ID_PLAYER, $replydata[0], $replydata[1]);
                    }
                    else{
                        $esport->deleteLike(User::getUser()->ID_PLAYER, $replydata[0], $replydata[1]);
                    }

                    echo $this->toJSON(array('success' => TRUE));
		}
	}
        
	public function ajaxNewWallComment(){
		$esport = new Esport();

		if(isset($_POST['post']) && isset($_POST['comment'])){                       
                        $esport->setComment(User::getUser(), $_POST['post'], $_POST['comment']);
		}
	}

	public function createfanclub(){
		$this->moduleOff();

		if(!Auth::isUserLogged())
			DooUriRouter::redirect(MainHelper::site_url('login/loginfirst'));

		$p = User::getUser();

		$esport = new Esport();

                $games = $esport->GetGamesByFK_TEAM($p->ID_TEAM);

		$profile['player'] = $p;
		$profile['hideMenu'] = true;
		$profile['games'] = $games;

		$list['fanclub'] = isset($this->params['id']) ? $esport->getFanclubByID($this->params['id']) : '';
		$list['team'] = isset($this->params['id']) ? $esport->GetTeamByID($this->params['id']) : $esport->GetTeamByID($p->ID_TEAM) ;
		$list['profile'] = $profile;
		$list['esMenuSelected'] = 'fanclubs';
		$list['esMenuSelected'] = 'fanclubs';

		$data = $this->getMenuData();
		$data['left'] = PlayerHelper::playerLeftSide();
		$data['footer'] = MainHelper::bottomMenu();
		$data['header'] = MainHelper::topMenu();
		$data['right'] = '';
		$data['content'] = $this->renderBlock('esport/createfanclub/main',$list);

		$this->render1Col($data);
	}
        
	public function teamcenter(){
		$this->moduleOff();

		if(!Auth::isUserLogged())
			DooUriRouter::redirect(MainHelper::site_url('login/loginfirst'));

		$p = User::getUser();

		$esport = new Esport();

		$profile['player'] = $p;
		$profile['hideMenu'] = true;
		$profile['games'] = $esport->getAllGames();
                $profile['teams'] = $esport->getPlayerTeams($p->ID_TEAM);
                $profile['topwon'] = $esport->getAllTeamRatings(10);
                $profile['topviews'] = $esport->getMostViewedTeams(10);

		$list['profile'] = $profile;
		$list['selected_menu'] = 'esport/teamcenter';

		$data = $this->getMenuData();
		$data['left'] = PlayerHelper::playerLeftSide();
		$data['footer'] = MainHelper::bottomMenu();
		$data['header'] = MainHelper::esportMenu();
		$data['right'] = '';
		$data['content'] = $this->renderBlock('esport/teamcenter/main',$list);

		$this->render1Col($data);
	}
        
	public function createteam(){
		$this->moduleOff();

		if(!Auth::isUserLogged())
			DooUriRouter::redirect(MainHelper::site_url('login/loginfirst'));

		$p = User::getUser();

		$esport = new Esport();

		$profile['player'] = $p;
		$profile['hideMenu'] = true;

		$list['profile'] = $profile;
		$list['selected_menu'] = 'esport/teamcenter';

		$data = $this->getMenuData();
		$data['left'] = PlayerHelper::playerLeftSide();
		$data['footer'] = MainHelper::bottomMenu();
		$data['header'] = MainHelper::esportMenu();
		$data['right'] = '';
		$data['content'] = $this->renderBlock('esport/createteam/main',$list);

		$this->render1Col($data);
	}
        
	public function register(){
		$this->moduleOff();

		if(!Auth::isUserLogged())
			DooUriRouter::redirect(MainHelper::site_url('login/loginfirst'));

		$p = User::getUser();

		$profile['player'] = $p;
		$profile['hideMenu'] = true;

		$list['profile'] = $profile;
		$list['selected_menu'] = 'esport/spotlight';

		$data = $this->getMenuData();
		$data['left'] = PlayerHelper::playerLeftSide();
		$data['footer'] = MainHelper::bottomMenu();
		$data['header'] = MainHelper::esportMenu();
		$data['right'] = '';
		$data['content'] = $this->renderBlock('esport/common/register',$list);

		$this->render1Col($data);
	}
        
	public function browseteams(){
		$this->moduleOff();

		if(!Auth::isUserLogged())
			DooUriRouter::redirect(MainHelper::site_url('login/loginfirst'));
                
                $byAlphabet = isset($this->params['letter']) ? $this->params['letter'] : ''; 
                $byName = isset($this->params['searchstring']) ? $this->params['searchstring'] : ''; 
                $byGame = isset($this->params['game']) && $this->params['game'] != 'all'  ? $this->params['game'] : ''; 
                
		$p = User::getUser();

		$esport = new Esport();

		$profile['player'] = $p;
		$profile['hideMenu'] = true;
                $profile['teams'] = empty($byAlphabet) && empty($byName) && empty($byGame) ? $esport->getAllTeams() : $esport->searchAllTeams($byAlphabet, $byName, $byGame);
		$profile['games'] = $esport->getAllGames();
                $profile['byAlphabet'] = $byAlphabet;
                $profile['byName'] = $byName;
                $profile['byGame'] = $byGame;

		$list['profile'] = $profile;
		$list['selected_menu'] = 'esport/browseteams';

		$data = $this->getMenuData();
		$data['left'] = PlayerHelper::playerLeftSide();
		$data['footer'] = MainHelper::bottomMenu();
		$data['header'] = MainHelper::esportMenu();
		$data['right'] = '';
		$data['content'] = $this->renderBlock('esport/browseteams/main',$list);

		$this->render1Col($data);
	}
        
	public function browseplayers(){
		$this->moduleOff();

		if(!Auth::isUserLogged())
			DooUriRouter::redirect(MainHelper::site_url('login/loginfirst'));
                
                $byAlphabet = isset($this->params['letter']) ? $this->params['letter'] : ''; 
                $byName = isset($this->params['searchstring']) ? $this->params['searchstring'] : ''; 
                $byGame = isset($this->params['game']) && $this->params['game'] != 'all'  ? $this->params['game'] : ''; 
                
		$p = User::getUser();

		$esport = new Esport();

		$profile['player'] = $p;
		$profile['hideMenu'] = true;
                $profile['teams'] = empty($byAlphabet) && empty($byName) && empty($byGame) ? $esport->getEsportPlayers() : $esport->searchAllTeams($byAlphabet, $byName, $byGame, true);
		$profile['games'] = $esport->getAllGames();
                $profile['byAlphabet'] = $byAlphabet;
                $profile['byName'] = $byName;
                $profile['byGame'] = $byGame;

		$list['profile'] = $profile;
		$list['selected_menu'] = 'esport/browseplayers';

		$data = $this->getMenuData();
		$data['left'] = PlayerHelper::playerLeftSide();
		$data['footer'] = MainHelper::bottomMenu();
		$data['header'] = MainHelper::esportMenu();
		$data['right'] = '';
		$data['content'] = $this->renderBlock('esport/browseplayers/main',$list);

		$this->render1Col($data);
	}
        
	public function addNews(){
		$this->moduleOff();

		$game = $this->getGame();
		$player = User::getUser();
		if (!$game) {
			DooUriRouter::redirect($game->GAME_URL);
			return FALSE;
		}

		if (!$player or $player->canAccess('Create news') === FALSE) {
			DooUriRouter::redirect($game->GAME_URL);
			return FALSE;
		}

		$list = array();
		if (isset($_POST) and !empty($_POST)) {
			$news = new News();
			$result = $news->saveNews($_POST,0,0,1);
			if ($result instanceof NwItems) {
				$translated = current($result->NwItemLocale);
				$LID = $translated->ID_LANGUAGE;
				DooUriRouter::redirect($game->GAME_URL.'/admin/edit-news/'.$result->ID_NEWS.'/'.$LID);
				return FALSE;
			} else {
				$list['post'] = $_POST;
			}
		}

		$games = new Games();
		$companies = new Companies();
		$news = new News();
		$companyOwners=$companies->getAllCompanies(10000, 1, "ASC"); // List of Companies / Games
		$gameOwners=$games->getAllGames(10000, 1, "ASC"); // Alternate List of Companies / Games
		$companyKeys=array(array('TypeID','ID_COMPANYTYPE'),
						array('OwnerID','ID_COMPANY'),
						array('Name','CompanyName'));
		$gameKeys=array(array('TypeID','ID_GAMETYPE'),
						array('OwnerID','ID_GAME'),
						array('Name','GameName'));
		$companytypeKeys=array(array('TypeID','ID_COMPANYTYPE'),
						array('Name','CompanyTypeName'));
		$gametypeKeys=array(array('TypeID','ID_GAMETYPE'),
						array('Name','GameTypeName'));
		$companytypes = $companies->getTypes(); // Company Types / Game Types
		$gametypes = $games->getTypes(); // Alternate Company Types / Game Types
		$list['companyOwnerArray'] = $news->populateArrayNewsAdmin($companyOwners, $companyKeys);
		$list['gameOwnerArray'] = $news->populateArrayNewsAdmin($gameOwners, $gameKeys);
		$list['companytypes'] = $news->populateArrayNewsAdmin($companytypes, $companytypeKeys);
		$list['gametypes'] = $news->populateArrayNewsAdmin($gametypes, $gametypeKeys);
		$list['function'] = 'add';
		$list['game'] = $game;
		$list['adminPanel'] = 0;
		$list['ownerID'] = $game->ID_GAME;
		$list['type'] = $game->ID_GAMETYPE;
		$list['ownerType'] = 'game';
		$list['itemPlatforms'] = $games->getAssignedPlatformsByGameId($game->ID_GAME);
		$list['typeUrl'] = $game->GAME_URL;
		$list['platforms'] = $games->getGamePlatforms();
		$list['language'] = 1;
		$list['languages'] = Lang::getLanguages();
		$list['CategoryType'] = false;
		$list['infoBox'] = MainHelper::loadInfoBox('Games', 'index', true);

		$list['selected_menu'] = 'esport/browseteams';

		$data = $this->getMenuData();
		$data['left'] = PlayerHelper::playerLeftSide();
		$data['footer'] = MainHelper::bottomMenu();
		$data['header'] = MainHelper::esportMenu();
		$data['right'] = '';
		$data['content'] = $this->renderBlock('esport/news/addEditNews',$list);

		$this->renderBlank($data);
	}

	public function savefanclub(){
		$this->moduleOff();

		$esport = new Esport();

		if(isset($_POST) && !empty($_POST))
			$esport->createFanclub($_POST);

		DooUriRouter::redirect(MainHelper::site_url('esport/fanclubinfo/'.$_POST['id_team']));
	}
        
	public function SubmitMatchresult(){
		$this->moduleOff();

		$esport = new Esport();

		if(isset($_POST) && !empty($_POST))
			$esport->SubmitScore($_POST);

		DooUriRouter::redirect(MainHelper::site_url('esport/myteam/challenges'));
	}

	public function updatefanclub(){
		$this->moduleOff();

		$esport = new Esport();

		if(isset($_POST) && !empty($_POST))
			$esport->updateFanclub($_POST);

		DooUriRouter::redirect(MainHelper::site_url('esport/fanclubinfo/'.$_POST['id_team']));
	}

	public function ajaxToggleLike() {
		if ($this->isAjax()) {
			$player = User::getUser();
			if ($player) {
				$result['result'] = $player->toggleLikeFanclub($_POST['id']);
				$player->purgeCache();
				$this->toJSON($result, true);
			}
		}
	}
        
        public function ajaxCheckStatus(){
            if($this->isAjax()){
                $esport = new Esport();
                extract($_POST);
                
                $esport->updateStatus($id,$online);
            }
        }
        public function ajaxCheckNotes(){
            
            if($this->isAjax()){
                $esport = new Esport();
                extract($_POST);
                $p = User::getUser();
                $note = $esport->getLobbyNotesByTeam($p->ID_TEAM,'ASC', 1);
                
                if(!empty($note)){
                        $note->Read();
                       
                        echo $this->toJSON(array(
                            'from' => $note->Sender,
                            'fromName'  => $note->getSenderName(),
                            'type' => $note->MessageType, 
                            'to' => $note->Reciever, 
                            'match' => $note->FK_QUICKMATCH));
                }
            }
        }
        
        public function cuptree(){
            
                $list = array();
                
                $esport = new Esport();
		$game = new Games();

		if (!isset($this->params['id']))
		{
			DooUriRouter::redirect(MainHelper::site_url('esport/tournaments'));
		}

		$ID_LEAGUE = $this->params['id'];
                
		$list['tournamentinfo'] = $esport->GetTournamentInfoByLeagueID($ID_LEAGUE);
		$list['tournamentteams'] = $esport->GetTeamsInLeague($ID_LEAGUE);
		$list['tournamentmatches'] = $esport->GetAllMatchesByLeague($ID_LEAGUE);
                
                $data['title'] = 'Cuptree';
		$data['content'] = $this->renderBlock('esport/tournamentinfo/cuptree',$list);
	
		$this->renderCuptree($data);
        }
        
	public function gamelobby(){
		$this->moduleOff();

		if(!Auth::isUserLogged())
			DooUriRouter::redirect(MainHelper::site_url('login/loginfirst'));
		
                $p = User::getUser();

		if(!$p->isEsportPlayer())
			DooUriRouter::redirect(MainHelper::site_url('esport/profile'));

		$esport = new Esport();
                
                $esport->updateStatus($p->ID_PLAYER,1);
                $playmodes = $esport->GetPlayModes();
		$games = $esport->GetGamesByFK_TEAM($p->ID_TEAM);
                
                $profile['myQuickmatches'] = $esport->GetQuickmatchByTeam($p->ID_TEAM);
                $profile['Quickmatches'] = $esport->GetAllQuickmatches(true);
                $profile['tournamentsFree'] = $esport->GetAllTournaments($playmodes['Free2Play'],'',false);
                $profile['tournamentsCoins'] = $esport->GetAllTournaments($playmodes['Pay2PlayCoins'],'',false);
                $profile['tournamentsCredits'] = $esport->GetAllTournaments($playmodes['Pay2PlayCredits'],'',false);
                $profile['myNotifications'] = $esport->getLobbyNotesByTeam($p->ID_TEAM,'DESC');
                $profile['onlinecount'] = $esport->getOnlinePlayers();
                $profile['chatbox_state'] = count(file('esport_shoutbox.txt'));
		$profile['player'] = $p;
		$profile['team'] = $esport->getTeamByID($p->ID_TEAM);
		$profile['hideMenu'] = true;
		$profile['games'] = $games;

		$list['profile'] = $profile;
		$list['esMenuSelected'] = 'gamelobby';

		$data = $this->getMenuData();
		$data['left'] = PlayerHelper::playerLeftSide();
		$data['footer'] = MainHelper::bottomMenu();
		$data['header'] = MainHelper::topMenu();
		$data['right'] = '';
		$data['content'] = $this->renderBlock('esport/gamelobby/main',$list);

		$this->render1Col($data);
	}
        
	public function myteam(){
		$this->moduleOff();

		if(!Auth::isUserLogged())
			DooUriRouter::redirect(MainHelper::site_url('login/loginfirst'));
                
		if(!isset($this->params['id']))
			DooUriRouter::redirect(MainHelper::site_url('esport/teamcenter'));

		$p = User::getUser();
                $ID_TEAM = $this->params['id'];
		$esport = new Esport();
                
                $team = $esport->GetTeamByID($ID_TEAM);
                $team->getLeagueData();
                $team->updateViews();
                
                $profile['playerfanclub'] = $esport->GetPlayerFanclubRel($p->ID_PLAYER, $ID_TEAM);
		$profile['team'] = $team;
                $profile['wallitems'] = $esport->getSpotlightItems($ID_TEAM);
                $profile['bottom_menu'] = isset($this->params['botmenu']) ? $this->params['botmenu'] : 'wallfeed';
		$profile['top_menu'] = isset($this->params['topmenu']) ? $this->params['topmenu'] : 'profileinfo';
		$profile['player'] = $p;
		$profile['hideMenu'] = true;
		$profile['games'] = $esport->getGamesByTeam($ID_TEAM);
                $profile['social'] = Social::getSocialsWithUrls($ID_TEAM, SOCIAL_OWNERTYPE_TEAM);
		$profile['leagueranking'] = $team->LeagueRankings;
		$profile['teammates'] = !empty($team) ? $esport->getAllPlayersByTeam($ID_TEAM) : '';
                $profile['fans'] = $esport->getFansByTeam($ID_TEAM);
		$profile['lastmatches'] = $esport->getLastPlayedMatches($ID_TEAM, 10);
		$profile['lastmatch'] = !empty($profile['lastmatches'][0]) ? $profile['lastmatches'][0] : array();

		$list['profile'] = $profile;
		$list['esMenuSelected'] = 'myteam';

		$data = $this->getMenuData();
		$data['left'] = PlayerHelper::playerLeftSide();
		$data['footer'] = MainHelper::bottomMenu();
		$data['selected_menu'] = 'esport/myteam';
		$data['header'] = MainHelper::esportMenu();
		$data['right'] = '';
		$data['content'] = $this->renderBlock('esport/myteam/main',$list);

		$this->render1Col($data);
	}
        
	public function moneytransfer(){
		$this->moduleOff();

		if(!Auth::isUserLogged())
			DooUriRouter::redirect(MainHelper::site_url('login/loginfirst'));

		$p = User::getUser();
		$esport = new Esport();
                
                $note = '';
		$games = $esport->GetGamesByFK_TEAM($p->ID_TEAM);
                
                if(isset($_POST) && !empty($_POST)){
                    $credittype = $_POST['ctype'];
                    $amount = $_POST['amount'];
                    $team = $_POST['team'];
                    $teaminfo = $esport->getTeamByID($team);
                    $credits = isset($_POST['ttype']) && $_POST['ttype'] == 'to_player' ? $teaminfo->Credits : $p->Credits;
                    $coins = isset($_POST['ttype']) && $_POST['ttype'] == 'to_player' ? $teaminfo->Coins : $p->PlayCredits;
                    
                    if($credittype != '0' && isset($credittype)){ //COINTYPE ERROR CHECK
                        //ENOUGH CREDIT CHECK
                        if(is_numeric($amount)){ //VALID AMOUNT ENTERED ERROR CHECK
                            if($amount >= 10){ //MINIMUM AMOUNT ENTERED ERROR CHECK
                                if(($credittype == ESPORT_TRANSACTIONTYPE_CREDITS && $credits > $amount) || ($credittype == ESPORT_TRANSACTIONTYPE_COINS && $coins > $amount)){
                                    if(isset($_POST['ttype']) && $_POST['ttype'] == "to_player"){
                                        $esport->createTransaction($p->ID_PLAYER, ESPORT_TRANSACTION_TRANSFERFROMTEAM, $credittype, $amount, ESPORT_TRANSACTIONTYPE_PLAYER, ESPORT_TRANSACTIONTYPE_TEAM, $team);
                                    }
                                    else{
                                        $esport->createTransaction($team, ESPORT_TRANSACTION_TRANSFERTOTEAM, $credittype, $amount);
                                    }
                                    $note = $this->__('Transfer succesful');
                                }
                                else{//ENOUGH CREDIT ERROR HANDLER
                                    $note = $this->__('Not enough credits on your account');
                                }
                            }
                            else{//MINIMUM AMOUNT INPUT ERROR HANDLER
                                $note = $this->__('Entered amount must be minimum 10');
                            }
                        }
                        else{//VALID AMOUNT INPUT ERROR HANDLER
                            $note = $this->__('Entered amount must be a number');
                        }
                    }
                    else{ //COINTYPE ERROR HANDLER
                        $note = $this->__('You must choose a credittype');
                    }
                }
                
		$profile['player'] = $p;
		$profile['hideMenu'] = true;
		$profile['games'] = $games;

                $list['team'] = $esport->GetTeamByID($this->params['id']);
		$list['profile'] = $profile;
                $list['note'] = $note;
		$list['esMenuSelected'] = 'myteam';

		$data = $this->getMenuData();
		$data['left'] = PlayerHelper::playerLeftSide();
		$data['footer'] = MainHelper::bottomMenu();
		$data['header'] = MainHelper::topMenu();
		$data['right'] = '';
		$data['content'] = $this->renderBlock('esport/moneytransfer/main',$list);

		$this->render1Col($data);
	}
                
        public function RegisterTeam(){
               $this->moduleOff();

		if(!Auth::isUserLogged())
			DooUriRouter::redirect(MainHelper::site_url('login/loginfirst'));
		
                if(!isset($_POST))
			DooUriRouter::redirect(MainHelper::site_url('esport'));

                $esport = new Esport();
                
                $esport->createTeam($_POST);
                DooUriRouter::redirect(MainHelper::site_url('esport/teamcenter'));
        }
        
        public function RegisterPlayer(){
               $this->moduleOff();

		if(!Auth::isUserLogged())
			DooUriRouter::redirect(MainHelper::site_url('login/loginfirst'));

                $esport = new Esport();
                
                $esport->RegisterPlayer(User::getUser());
                DooUriRouter::redirect(MainHelper::site_url('esport/spotlight'));
        }
        
        public function CloseTeam(){
               $this->moduleOff();

		if(!Auth::isUserLogged())
			DooUriRouter::redirect(MainHelper::site_url('login/loginfirst'));

		$p = User::getUser();
                $esport = new Esport();
                
                $esport->deleteTeam($this->params['id']);
                DooUriRouter::redirect(MainHelper::site_url('esport/profile'));
        }
        
        public function UpdateTeaminfo(){
                $this->moduleOff();

		if(!Auth::isUserLogged())
			DooUriRouter::redirect(MainHelper::site_url('login/loginfirst'));
                
                $esport = new Esport();
                $esport->updateTeaminfo($_POST);
                
                DooUriRouter::redirect(MainHelper::site_url('esport/myteam'));
        }
        
        public function CreateMatch(){
                $this->moduleOff();

		if(!Auth::isUserLogged())
			DooUriRouter::redirect(MainHelper::site_url('login/loginfirst'));
                
                extract($_POST);
                $esport = new Esport();
                $playmodes = $esport->getPlayModes();
                $challenger = $esport->getTeamByID($challengerinfo);
                $opponent = !empty($opponentinfo) ? $esport->getTeamByID($opponentinfo) : 'random';
                $note = 'Undefined error';
                $error = true;
                
                if(isset($gameinfo) && isset($playmodes) && !empty($challenger)){ //ALL FILLED ERROR CHECK
                    //ENOUGH CREDIT CHECK
                    if(is_numeric($betsize) || $playmode == $playmodes['Play4Free']){ //VALID AMOUNT ENTERED ERROR CHECK
                        if($betsize >= 10 || $playmode == $playmodes['Play4Free']){ //MINIMUM AMOUNT ENTERED ERROR CHECK
                            if(($playmode == $playmodes['Play4Credits'] && $challenger->Credits > $betsize) || $playmode == $playmodes['Play4Free']){ //ENOUGH CREDITS ERROR CHECK
                                if($opponent == 'random' || !empty($opponent) || ($playmode == $playmodes['Play4Credits'] && $opponent->Credits > $betsize) || $playmode == $playmodes['Play4Free']){ //ENOUGH CREDITS ERROR CHECK
                                  
                                    $esport->createQuickmatch($_POST);
                                    $error = false;

                                }
                                else{//ENOUGH CREDIT ERROR HANDLER
                                    $note = $this->__('Not enough credits on your opponents account');
                                }
                            }
                            else{//ENOUGH CREDIT ERROR HANDLER
                                $note = $this->__('Not enough credits on your account');
                            }
                        }
                        else{//MINIMUM AMOUNT INPUT ERROR HANDLER
                            $note = $this->__('Entered amount must be minimum 10');
                        }
                    }
                    else{//VALID AMOUNT INPUT ERROR HANDLER
                        $note = $this->__('Entered amount must be a number');
                    }
                }
                else{ //ALL FILLED ERROR HANDLER
                    $note = $this->__('You must choose a game and gametype');
                }
                
                if($error == true){
                    echo $this->toJSON(array(
                                'error' => $error,
                                'note' => $note));    
                }
                else{
                    DooUriRouter::redirect(MainHelper::site_url('esport/spotlight'));
                }
        }
        
        public function DeleteQuickmatch(){
                $this->moduleOff();

		if(!Auth::isUserLogged())
			DooUriRouter::redirect(MainHelper::site_url('login/loginfirst'));

                $esport = new Esport();
                $match = $esport->getQuickmatchByID($_POST['id']);
                
                if($match->BetSize > 0){
                    $bettype = $match->PlayMode == '2' ? ESPORT_TRANSACTIONTYPE_CREDITS : ESPORT_TRANSACTIONTYPE_COINS;
                    $esport->createTransaction($owner = $match->ChallengerID, $transactiontype = ESPORT_TRANSACTION_MATCHCANCELED, $credittype = $bettype, $amount = $match->BetSize, $ownertype = ESPORT_TRANSACTIONTYPE_TEAM, $transactortype = ESPORT_TRANSACTIONTYPE_QUICKMATCH, $transactor = $match->FK_LEAGUE); 
                    
                    if($match->Opponent != 0){
                        $esport->createTransaction($owner = $match->OpponentID, $transactiontype = ESPORT_TRANSACTION_MATCHCANCELED, $credittype = $bettype, $amount = $match->BetSize, $ownertype = ESPORT_TRANSACTIONTYPE_TEAM, $transactortype = ESPORT_TRANSACTIONTYPE_QUICKMATCH, $transactor = $match->FK_LEAGUE); 
                    }
                }
                $esport->deleteQuickmatch($_POST['id']);
                
        }
        
        public function JoinQuickmatch(){
                $this->moduleOff();

		if(!Auth::isUserLogged())
			DooUriRouter::redirect(MainHelper::site_url('login/loginfirst'));
                
                $p = User::getUser();
                $esport = new Esport();
                $match = $esport->getQuickmatchByID($_POST['match']);
               
                $esport->createLobbyNote($p->ID_TEAM,$match->Host, NOTIFICATION_QUICKMATCH_CHALLENGE, $_POST['match']);
        }
        
        public function AjaxAcceptChallenge(){
                $this->moduleOff();

		if(!Auth::isUserLogged())
			DooUriRouter::redirect(MainHelper::site_url('login/loginfirst'));
                
                $p = User::getUser();
                $esport = new Esport();
                
                //$esport->createLobbyNote($p->ID_TEAM,$_POST['to'], NOTIFICATION_QUICKMATCH_ACCEPT,$_POST['match']);            
                //$esport->setupQuickmatch($_POST['match'], $_POST['to']);
                
                $esport->setMatchState($this->params['match'], 'Active');
                
                DooUriRouter::redirect(MainHelper::site_url('esport/myteam/challenges'));
        }
        
        public function AjaxRejectChallenge(){
                $this->moduleOff();

		if(!Auth::isUserLogged())
			DooUriRouter::redirect(MainHelper::site_url('login/loginfirst'));
                
                $p = User::getUser();
                $esport = new Esport();
                
                //$esport->createLobbyNote($p->ID_TEAM,$_POST['to'], NOTIFICATION_QUICKMATCH_REJECT,$_POST['match']);
                
                $esport->setMatchState($this->params['match'], 'Rejected');
                
                DooUriRouter::redirect(MainHelper::site_url('esport/myteam/challenges'));
        }
        
        public function AjaxSendChat(){
            $message = $_POST['shout'];
            fwrite(fopen("esport_shoutbox.txt","a"), $message."\n");
        }
        
        public function AjaxUpdateChat(){
            
            $lines = file('esport_shoutbox.txt');
            $count = count($lines);
            $username = User::getUser()->DisplayName;
            
            if($count >= $_POST['state'] ){
            $isOwn = strpos($lines[$_POST['state']],$username) ? true : false;
                
            echo $this->toJSON(array(
                            'state' => $_POST['state'] + 1,
                            'you' => $isOwn,
                            'msg' => $lines[$_POST['state']]
                    ));
            }
        }
        
        public function ajaxAddGame(){
            
            $esport = new Esport();
            $game = Games::getGameById($_POST['id']);
            $found = !empty($game) ? true : false;
            if($found){
                
            $gt = new EsGameTeamRel();
            $gt->FK_GAME =  $_POST['id'];
            $gt->FK_TEAM =  $_POST['team'];
            $rel = $gt->getOne();
            if(!empty($rel)){
                $esport->ToggleGameTeamRelation($_POST['team'], $_POST['id'], 1); 
            }
            else{
                $esport->addGameToEsportTeam($_POST['team'], $_POST['id']); 
            }
            
            echo $this->toJSON(array(
                            'name' => $game->GameName,
                            'id'    =>  $game->ID_GAME,
                            'img'    =>  MainHelper::showImage($game, THUMB_LIST_95x95, false, array('width', 'no_img' => 'noimage/no_game_95x95.png')),
                            'found' => true
                    ));
            }
            else{
            echo $this->toJSON(array(
                            'found' => false
                    ));    
            }
        }
        
        public function ajaxRemoveGame(){
            
            $esport = new Esport();
            $game = Games::getGameById($_POST['id']);
            $found = !empty($game) ? true : false;
            if($found){
                
            $esport->ToggleGameTeamRelation($_POST['team'], $_POST['id'], 0); 
            
            echo $this->toJSON(array(
                            'found' => true
                    ));
            }
            else{
            echo $this->toJSON(array(
                            'found' => false
                    ));    
            }
        }
        
        public function ajaxSearchPlayer(){
            $user = new User();
            
            $player = User::searchPlayers($_POST['searchstring']);
            $found = !empty($player) ? true : false;
            if($found){
            echo $this->toJSON(array(
                            'name' => $this->toJSON($player),
                            'found' => true
                    ));
            }
            else{
            echo $this->toJSON(array(
                            'found' => false
                    ));    
            }
        }
        public function ajaxSearchTeams(){
            $esport = new Esport();
            
            $teams = $esport->searchAllTeams('', $_POST['searchstring'], '', true);
            $found = !empty($teams) ? true : false;
            if($found){
            echo $this->toJSON(array(
                            'name' => $this->toJSON($teams),
                            'found' => true
                    ));
            }
            else{
            echo $this->toJSON(array(
                            'found' => false
                    ));    
            }
        }
        
        public function ajaxSetFavorite(){
            $twitch = new Twitch();
            
            $channel = $twitch->getChannelByTwitchName($_POST['channel']);
            $twitch->setFavorite($channel->ID_CHANNEL, User::getUser()->ID_PLAYER, $_POST['remove']);
        }
        
        public function teamRequestRespond(){
            $esport = new Esport();
            $status = $this->params['status'] == 'accept' ? false : true;
            
            if($this->params['status'] == 'accept'){
                $esport->setTeamStatus($this->params['id'], User::getUser()->ID_TEAM, ESPORT_TEAMSTATUS_PENDING, $status);
            }
            else{
                $esport->deleteTeamMemberRelation($this->params['id'], User::getUser()->ID_TEAM);
            }
            
            if(strstr($_SERVER["REQUEST_URI"],'esport')){
                DooUriRouter::redirect(MainHelper::site_url('esport/profile'));
            }
            if(strstr($_SERVER["REQUEST_URI"],'players')){
                DooUriRouter::redirect(MainHelper::site_url('players/notifications'));
            }
        }
        
        public function leavetournament(){
            $esport = new Esport();
            
            $ID_TEAM = $this->params['team'];
            $ID_LEAGUE = $this->params['league'];
            
            $tournament = $esport->getTournamentByID($ID_LEAGUE);
            
            $esport->unsubscribeTournament($ID_LEAGUE, $ID_TEAM);
            
            if($tournament->BetSize > 0){
                $esport->createTransaction($owner = $ID_TEAM, $transactiontype = ESPORT_TRANSACTION_TOURNAMENTLEFT, $credittype = $tournament->BetType, $amount = $tournament->EntryFee, $ownertype = ESPORT_TRANSACTIONTYPE_TEAM, $transactortype = strtolower($tournament->TournamentType), $transactor = $ID_LEAGUE );
            }
            
            DooUriRouter::redirect(MainHelper::site_url('esport/tournamentinfo/'.$this->params['league']));
        }
        
        public function UpdateSpotlight(){
            if(!Auth::isUserLogged())
			DooUriRouter::redirect(MainHelper::site_url('login/loginfirst'));
            
            if(empty($_POST))
			DooUriRouter::redirect(MainHelper::site_url('esport/spotlight'));
            
            $esport = new Esport();
            
            $esport->SaveSpotlight($_POST);
            
            DooUriRouter::redirect(MainHelper::site_url('esport/spotlight'));
        }
        
        public function UpdateTeam(){
            if(!Auth::isUserLogged())
			DooUriRouter::redirect(MainHelper::site_url('login/loginfirst'));
            
            if(empty($_POST))
			DooUriRouter::redirect(MainHelper::site_url('esport/teamcenter'));
            
            $esport = new Esport();
            
            $esport->SaveTeam($_POST);
            
            DooUriRouter::redirect(MainHelper::site_url('esport/teamcenter'));
        }
}

?>
