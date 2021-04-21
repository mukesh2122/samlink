<?php
class Esport 
{
	public function GetAchievements($ID_PLAYER)
	{
		//$query = "SELECT * FROM es_achievements WHERE ID_TEAM=$ID_TEAM ORDER BY ID_ACHIEVEMENT DESC";

		$query = "select * from ac_levels
			left join ac_playerachievement_rel
			on ac_levels.ID_LEVEL = ac_playerachievement_rel.FK_LEVEL
			where ac_playerachievement_rel.FK_PLAYER = $ID_PLAYER";
		return Doo::db()->query($query)->fetchall();
	}

	public function GetLadderLeagues()
	{
	
		$query = "SELECT * FROM es_ladderranges ORDER BY entry ASC";
		return Doo::db()->query($query)->fetchall();
	
/*		$leagues = array();
		$medals = array('bronze.png', 'silver.png', 'gold.png', 'platinum.png', 'elite.png');
		$lsize = 3000/25;
		for ($i=0;$i<25;$i++)
		{
			$min = $i*$lsize;
			$max = ($i+1)*$lsize - 1;
			$m = floor($i/5);
			$medal = $medals[$m];
			$tier = $i % 5;

			$leagues[] = array('min'=>$min,'max'=>$max,'img'=>$medal,'league'=>$m,'tier'=>$tier);
		}*/
	}
	
	public function GetHighestAchievedLeagueInGames($games, $ID_TEAM)
	{
		//Find highest game rating
		$highestRating = 0;
		$highestGame = 0;
		foreach ($games as $game)
		{
			$res = $this->GetTeamRatingsByGame($game->ID_GAME, $ID_TEAM);
			if (count($res)>0)
			{
				$gameAVGRating = $res[0]['TotalRating'];
				if ($gameAVGRating>=$highestRating)
				{
					$highestRating = $gameAVGRating;
					$highestGame = $game;
				}
			}
		}

		//Find ladder league by highest game rating
		$ladderLeagues = $this->GetLadderLeagues();
		$ladderLeague = array();
		foreach ($ladderLeagues as $ll)
		{
			if ($ll['min'] <= $highestRating && $highestRating <= $ll['max'])
				$ladderLeague = $ll;
		}

		return array('rating'=>$highestRating, 'game'=>$highestGame, 'ladderLeague'=>$ladderLeague);
	}

	public function GetAVGRating($ID_TEAM,$ratings)
	{
		$myAVGRating = 0;
		foreach ($ratings as $rating)
		{
			if ($rating['ID_TEAM']==$ID_TEAM)
				$myAVGRating = round($rating['AvgRating'],2);
		}
		return $myAVGRating;
	}
        
	public function GetTotalRating($ID_TEAM,$ratings)
	{
		$myRating = 0;
		foreach ($ratings as $rating)
		{
			if ($rating['ID_TEAM']==$ID_TEAM)
				$myRating = $rating['TotalRating'];
		}
		return $myRating;
	}
	
	public function GetGameIDByMatch($ID_MATCH)
	{
		$query = "select * from es_leagues
			left join es_matches on es_matches.FK_LEAGUE = es_leagues.ID_LEAGUE
			where es_matches.ID_MATCH = $ID_MATCH";
		$res = Doo::db()->query($query)->fetchall();
		if (count($res)>0)
			return $res[0]['FK_GAME'];

		return 0;
	}

	public function GetGameIDByLeague($ID_LEAGUE)
	{
		$query = "select distinct(FK_GAME) from es_leagues where ID_LEAGUE=$ID_LEAGUE";
		$res = Doo::db()->query($query)->fetchall();
		if (count($res)>0)
			return $res[0]['FK_GAME'];

		return 0;
	}

	public function GetMatchByID($ID_MATCH)
	{
		$game = Doo::db()->getOne('EsMatches', array(
                            'where' =>  "ID_MATCH = {$ID_MATCH}"
                ));
                            
                return $game;
	}
        
	public function GetMatchByLeague($ID_LEAGUE)
	{
		$game = Doo::db()->getOne('EsMatches', array(
                            'where' =>  "FK_LEAGUE = {$ID_LEAGUE}"
                ));
                            
                return $game;
	}
        
	public function GetMatchByIDWithLeagueData($ID_MATCH)
	{
		$query = "SELECT * FROM es_matches LEFT JOIN es_leagues 
                    ON FK_LEAGUE = ID_LEAGUE
                    WHERE ID_MATCH = {$ID_MATCH}";
                    
                $game = Doo::db()->query($query)->fetchAll(PDO::FETCH_CLASS,'EsMatches');
                            
                return !empty($game[0]) ? $game[0] : false;
	}
	
	public function GetLeagueIDByMatch($ID_MATCH)
	{
		$query = "select * from es_matches where ID_MATCH=$ID_MATCH";
		$res = Doo::db()->query($query)->fetchall();
		if (count($res)>0)
			return $res[0]['FK_LEAGUE'];

		return 0;
	}

	public function GetChallengerIDByMatch($ID_MATCH)
	{
		$query = "select * from es_matches where ID_MATCH=$ID_MATCH";
		$res = Doo::db()->query($query)->fetchall();
		if (count($res)>0)
			return $res[0]['ChallengerID'];

		return 0;
	}

	public function calculateK($rating)
	{
        $Kmin = 10.0;
        $Kmax = 60.0;
        $ratingKmax = 3000.0;
        $ratingKmin = 1000.0;

		$num = $ratingKmax - $ratingKmin;
		$num2 = max( ($rating - $ratingKmin),  0.0);
		$num3 = max(min( (1.0 - ($num2 / $num)),  1.0), 0.0);
		$num3 *= $num3;
		return ($Kmin + ($num3 * ($Kmax - $Kmin)));
	}

	public function CalcRating($winnerRating, $loserRating)
	{
		$num = pow($winnerRating / 400.0, 10.0);
		$num2 = pow($loserRating / 400.0, 10.0);
		$d = ($num + $num2);
		if ($d!=0)
		{
			$num3 = $num / ($num + $num2);
			$num4 = $num2 / ($num + $num2);
		}
		else
		{
			$num3 = $num;
			$num4 = $num2;
		}

		$num5 = $this->calculateK($winnerRating);
		$WinnerDifference = $num5 * (1.0 - $num3);
		$num6 = $num5;
		$LoserDifference = $num6 * (0.0 - $num4);
		$winnerRating += $WinnerDifference;
		$loserRating += $LoserDifference;
		$loserRating = max($loserRating, 100.0);

		$result = array
		(
			'WinnerDifference' => $WinnerDifference,
			'LoserDifference' => $LoserDifference,
			'NewWinnerRating' => $winnerRating,
			'NewLoserRating' => $loserRating
		);

		return $result;
	}



	public function GetMatchState($s)
	{
		$MatchState = array
		(
			'Active' => 4,
			'All' => 0xffff,
			'AutoLoss' => 0x2000,
			'Cancelled' => 0x40,
			'Challenge' => 1,
			'ChallengerResult' => 520,
			'Closed' => 0x10,
			'Dispute' => 0x20,
			'InProgress' => 0x12f,
			'None' => 0,
			'Open' => 0x100,
			'OpponentResult' => 0x408,
			'Ready' => 2,
			'Rejected' => 0x80,
			'ReportedResult' => 8,
			'Upcomming' => 14,
			'Valid' => 0xfff,
		);
		return $MatchState[$s];
	}
	
	public function getPlayModes()
	{
		$PlayModes = array
		(
			'Play4Free'	=> 1,
			'Play4Credits' => 2,
			'Pay2PlayCoins'	=> 4
		);
		return $PlayModes;
	}
        
	public static function getPlayMode($m)
	{
		$PlayModes = array
		(
			 '1'  => 'Play4Free',
			 '2'  => 'Play4Credits',
			 '4'  => 'Play4Coins'
		);
		return $PlayModes[$m];
	}
	public static function getPlayModeByName($n)
	{
		$cons = Doo::db()->getOne('EsConstants',array(
                        'where' =>  "ConstantType = 'PlayMode' AND ConstantName = '{$n}'"
                ));
                
		return $cons->Value;
	}
	
	public function GetPlayerByTeam($ID_TEAM)
	{
                $players = new Players();
                
		$player = Doo::db()->getOne('Players', array(
                                'where'     => "{$players->_table}.ID_TEAM = {$ID_TEAM}",
                                'limit'     => 1
                ));

		return $player;
	}
	
	public function GetGameRating($FK_TEAM,$FK_GAME,$FK_LEAGUE)
	{
		$query = "select * from es_gameratings 
		where es_gameratings.FK_TEAM=$FK_TEAM and es_gameratings.FK_GAME=$FK_GAME and es_gameratings.FK_LEAGUE=$FK_LEAGUE";
		$res = Doo::db()->query($query)->fetchall();
		if (count($res)>0)
			return $res[0]['Rating'];

		return 0;
	}
	
	
	public function GetGameRatings($FK_GAME,$FK_TEAM)
	{
/*		$query = "SELECT gr.FK_GAME, gr.FK_LEAGUE, g.GameName, gr.Rating, gr.Wins, gr.Losses, gr.PlayMode FROM es_gameratings AS gr, sn_games AS g
			WHERE gr.FK_TEAM = {$FK_TEAM} AND gr.FK_GAME = g.ID_GAME
			AND (SELECT COUNT(*) FROM es_leagues WHERE es_leagues.ID_LEAGUE=gr.FK_LEAGUE AND es_leagues.isGlobal)=1
			AND gr.FK_GAME = {$FK_GAME}";*/
		$query = "SELECT gr.FK_GAME, gr.FK_LEAGUE, g.GameName, gr.Rating, gr.Wins, gr.Losses, gr.PlayMode FROM es_gameratings AS gr, sn_games AS g
			WHERE gr.FK_TEAM = {$FK_TEAM} AND gr.FK_GAME = g.ID_GAME
			AND (SELECT COUNT(*) FROM es_leagues WHERE es_leagues.ID_LEAGUE=gr.FK_LEAGUE)=1
			AND gr.FK_GAME = {$FK_GAME}";
		$gameratings = Doo::db()->query($query)->fetchall();				
		$totalWins = 0;
		$totalLosses = 0;
		$matchesplayedF2p = 0;
		$matchesplayedCredits = 0;
		$matchesplayedCoins = 0;
		$ratingF2p = 0;
		$ratingCredits = 0;
		$PlayModes = $this->GetPlaymodes();
		foreach ($gameratings as $gr)
		{
			//echo " - Rating: {$gr['Rating']}   Wins: {$gr['Wins']}   Losses: {$gr['Losses']}<br/>";
			$w = $gr['Wins'];
			$l = $gr['Losses'];
			$t = $w + $l;
			$totalWins += $w;
			$totalLosses += $l;
			$playmode = $gr['PlayMode'];
			$rating = $gr['Rating'];

			$matchesplayedF2p = ($playmode==$PlayModes['Play4Free']) ? $t : $matchesplayedF2p;
			$matchesplayedCredits = ($playmode==$PlayModes['Play4Credits']) ? $t : $matchesplayedCredits;

			$ratingF2p = ($playmode==$PlayModes['Play4Free']) ? $rating : $ratingF2p;
			$ratingCredits = ($playmode==$PlayModes['Play4Credits']) ? $rating : $ratingCredits;
			
		}
		$totalMatchesPlayed = $totalWins + $totalLosses;

		if ($totalMatchesPlayed!=0)
		{
			$gameRating = ($ratingF2p * $matchesplayedF2p) + ($ratingCredits * $matchesplayedCredits);
			$gameRating /= $totalMatchesPlayed;
		}
		else
		{
			$gameRating = 0;
		}
		$gameRating = round($gameRating,2);
		return array
		(
			'matchesplayedF2p' => $matchesplayedF2p,
			'matchesplayedCredits' => $matchesplayedCredits,
			'matchesplayedCoins' => $matchesplayedCoins,
			'ratingF2p' => $ratingF2p,
			'ratingCredits' => $ratingCredits,
			'gameRating' => $gameRating,
			'totalWins' => $totalWins,
			'totalLosses' => $totalLosses,
			'totalMatchesPlayed' => $totalMatchesPlayed
		);
	}
				
	
	public function GetMaxPlayedGame($games)
	{
		$maxMatchesPlayed = 0;
		$maxGame = array();
		foreach ($games as $game)
		{
			$gameRatings = $game['GameRatings'];
			$totalMatchesPlayed = $gameRatings['totalMatchesPlayed'];
			if ($totalMatchesPlayed >= $maxMatchesPlayed)
			{
				$maxMatchesPlayed = $totalMatchesPlayed;
				$maxGame = $game;
			}
		}
		return $maxGame;
	}
	
	public function GetGamesByFK_TEAM($FK_TEAM)
	{   
		/*$query = "SELECT * from sn_games 
			left join sn_playergame_rel
			on sn_games.ID_GAME = sn_playergame_rel.ID_GAME
			WHERE sn_playergame_rel.ID_PLAYER={$FK_TEAM}
                        AND sn_playergame_rel.isPlaying = 1
                        AND sn_games.isESportGame = 1
			group by sn_games.GameName";*/
            
                //*************GET BY TEAM TABLE****************************///
		$query = "SELECT * from es_gameteam_rel 
			left join sn_games
			on es_gameteam_rel.FK_GAME = sn_games.ID_GAME
			WHERE es_gameteam_rel.FK_TEAM={$FK_TEAM}
                        AND es_gameteam_rel.isActive = 1
			group by sn_games.GameName";
                        
		$games = Doo::db()->query($query)->fetchall();

		foreach ($games as $key=>$game)
			$games[$key]['GameRatings'] = $this->GetGameRatings($game['ID_GAME'],$FK_TEAM);

		return $games;
	}
	public function getGamesByTeam($ID_TEAM)
	{
            $game = new SnGames();
            $gt = new EsGameTeamRel();
            
            $query = "SELECT {$game->_table}.* FROM {$game->_table} 
                LEFT JOIN {$gt->_table} on {$game->_table}.ID_GAME = {$gt->_table}.FK_GAME 
                    WHERE {$gt->_table}.FK_TEAM = {$ID_TEAM}
                    AND {$gt->_table}.isActive = 1";
                    
            $games = Doo::db()->query($query)->fetchAll(PDO::FETCH_CLASS,'SnGames');
            return $games;
	}
        
	public function GetGameRatingsByParticipant($ID_TEAM)
	{
            return Doo::db()->query("SELECT gr.FK_GAME, gr.FK_LEAGUE, g.GameName, gr.Rating, gr.Wins, gr.Losses, gr.PlayMode FROM es_gameratings AS gr, sn_games AS g
                WHERE gr.FK_TEAM = {$ID_TEAM} AND gr.FK_GAME = g.ID_GAME")->fetchAll();
	}
	
	public function getPlayerTeams($ID_PLAYER = 0)
	{       
                $team = new EsTeams();
                $tr = new EsTeamMembersRel();
                
                $pid = $ID_PLAYER == 0 ? User::getUser()->ID_TEAM : $ID_PLAYER;
                
                $query = "SELECT * FROM {$team->_table} RIGHT JOIN {$tr->_table} 
                    ON {$team->_table}.ID_TEAM = {$tr->_table}.FK_TEAM
                    WHERE {$tr->_table}.FK_PLAYER = {$pid}";
                
                $teams = Doo::db()->query($query)->fetchAll(PDO::FETCH_CLASS, 'EsTeams');    
                return $teams;
	}

	public function getAllTeams()
	{            
                $teams = Doo::db()->find('EsTeams', array(
                        'where' => 'isSinglePlayerTeam = 0',
                        'asc'  =>  'DisplayName'
                ));
                
                return $teams;
	}
        
	public function getEsportPlayers()
	{            
                $teams = Doo::db()->find('EsTeams', array(
                        'where' => 'isSinglePlayerTeam = 1',
                        'asc'  =>  'DisplayName'
                ));
                
                return $teams;
	}
        
	public function getMostViewedTeams($limit = 10)
	{            
                $teams = Doo::db()->find('EsTeams', array(
                        'where' => 'isSinglePlayerTeam = 0',
                        'desc'  =>  'ViewCount',
                        'limit'  => $limit 
                ));
                
                return $teams;
	}
        
	public function searchAllTeams($letter = '', $name = '', $game = '', $singleplayer = false)
    {           $team = new EsTeams();
                $gt = new EsGameTeamRel();
                $searchstring = '';
                $singleplayer = $singleplayer == false ? 0 : 1;
                
                if(!empty($letter) || !empty($name))
                    $searchstring = empty($letter) ? "AND {$team->_table}.DisplayName LIKE '%{$name}%'" : "AND {$team->_table}.DisplayName REGEXP '^[{$letter}]'";
                 
                if(empty($game)){
                    $query = "SELECT {$team->_table}.* FROM {$team->_table} WHERE {$team->_table}.isSinglePlayerTeam = {$singleplayer} {$searchstring} ";
                }
                else{
                    $query = "SELECT {$team->_table}.* FROM {$team->_table} LEFT JOIN {$gt->_table} ON {$team->_table}.ID_TEAM = {$gt->_table}.FK_TEAM
                                WHERE {$team->_table}.isSinglePlayerTeam = {$singleplayer}
                                AND {$gt->_table}.FK_GAME = {$game} {$searchstring}
                                ";
                }
                
                $teams = Doo::db()->query($query)->fetchAll(PDO::FETCH_CLASS, 'EsTeams');
                return $teams;
	}
	
	public function getMatchesByParticipantAndState($ID_TEAM,$matchState)
	{
            //return Doo::db()->query("CALL esp_GetMatchesByParticipantAndState({$ID_TEAM},{$matchState});")->fetchall();
            $match = new EsMatches();
            $league = new EsLeagues();
            
            $query = "SELECT {$match->_table}.*, {$league->_table}.FK_GAME, {$league->_table}.RankedStatus, {$league->_table}.Host FROM {$match->_table} 
                LEFT JOIN {$league->_table} ON {$match->_table}.FK_LEAGUE = {$league->_table}.ID_LEAGUE
                WHERE ({$match->_table}.ChallengerID = {$ID_TEAM} OR {$match->_table}.OpponentID = {$ID_TEAM}) 
                    AND {$match->_table}.State = {$matchState}
                ORDER BY {$match->_table}.StartTime DESC;";
                
            return Doo::db()->query($query)->fetchall(PDO::FETCH_CLASS, 'EsMatches');
	}

	public function GetMatchHistoryByFK_TEAM($ID_TEAM)
	{
		$matchHistory = array();
		$matchState = $this->GetMatchState('Closed');
		$matches = $this->GetMatchesByParticipantAndState($ID_TEAM,$matchState);
                $items = 0;
		foreach ($matches as $match)
		{
                        $game = $this->getGameByLeague($match['FK_LEAGUE']);
			$MatchWinnerID = $match['MatchWinnerID'];
			$MatchLoserID = $match['MatchLoserID'];
			$res = 'Even';
			if ($ID_TEAM==$MatchWinnerID)
			{
				$res = 'Win';
			}
			if ($ID_TEAM==$MatchLoserID)
			{
				$res = 'Lost';
			}
			
			$matchHistory[] = array(
				'img'=>$game->ImageURL,
				'result'=>$res,
				'time'=>$match['StartTime'],
                                'gamename' => $game->GameName,
				'score'=>$match['Score']);
                        $items++;
		}
                $matchHistory['total'] = $items;
		return $matchHistory;
	}
	public function GetAttendedTournamentsByFK_TEAM($FK_TEAM){
                $query = "SELECT count(1) as cnt FROM es_leagueteam_rel
                            WHERE es_leagueteam_rel.FK_TEAM = {$FK_TEAM}
			";
		$rs = Doo::db()->query($query)->fetchall();
                return $rs[0]['cnt'];
        }
	public function GetTournamentsByFK_TEAM($FK_TEAM)
	{
		$query = "SELECT es_leagues.LeagueName,es_leagues.*,es_leagueteam_rel.*,sn_games.* FROM es_leagueteam_rel
			LEFT JOIN es_leagues
			ON es_leagues.ID_LEAGUE = es_leagueteam_rel.FK_LEAGUE
			LEFT JOIN sn_games
			ON es_leagues.FK_GAME = sn_games.ID_GAME 
			WHERE es_leagueteam_rel.FK_TEAM = {$FK_TEAM}
			";
		return Doo::db()->query($query)->fetchall();
	}

	public function GetAllTournaments($playmode,$TournamentType='League',$getType = true)
	{
                $getType = $getType == true ? "AND TournamentType='{$TournamentType}'" : "";
                $sp = ($playmode!='') ? "AND playmode={$playmode}" : "";
		$query = "SELECT * FROM es_leagues
			LEFT JOIN sn_games
			ON es_leagues.FK_GAME = sn_games.ID_GAME 
                        WHERE TournamentType <> 'Quickmatch'
			{$getType}
			{$sp} 
			ORDER BY StartTime DESC";
			//AND NOT isDone
		$tournaments = Doo::db()->query($query)->fetchall();

		return $tournaments;
	}
	public function SearchTournaments($searchstring,$playmode,$TournamentType='League', $getType = true)
	{
                $getType = $getType == true ? "AND TournamentType='{$TournamentType}'" : "";
		$sp = ($playmode!='') ? "WHERE playmode={$playmode}" : "";
		$query = "SELECT * FROM es_leagues
			LEFT JOIN sn_games
			ON es_leagues.FK_GAME = sn_games.ID_GAME 
			{$sp}
			{$getType}
                        AND es_leagues.LeagueName LIKE '%".addslashes($searchstring)."%'
			ORDER BY StartTime DESC";
			//AND NOT isDone
		$tournaments = Doo::db()->query($query)->fetchall();

		return $tournaments;
	}
	
	public function GetTournamentInfoByLeagueID($ID_LEAGUE)
	{
		$query = "SELECT * FROM es_leagues
			WHERE ID_LEAGUE = {$ID_LEAGUE} 
			";//AND NOT isDone";
		$rs = Doo::db()->query($query)->fetchall();
		if (count($rs)>0)
			return $rs[0];
		return array();
	}
	public function GetTeams()
	{
		$query = "SELECT * FROM es_teams ORDER BY DisplayName";
		return Doo::db()->query($query)->fetchall();
	}
	
	public function GetTeamsInLeague($ID_LEAGUE)
	{
		$query = "SELECT * FROM es_teams
			LEFT JOIN es_leagueteam_rel
			ON es_teams.ID_TEAM=es_leagueteam_rel.FK_TEAM
			LEFT JOIN es_gameratings
			ON es_gameratings.FK_LEAGUE=es_leagueteam_rel.FK_LEAGUE AND es_gameratings.FK_TEAM=es_leagueteam_rel.FK_TEAM
			WHERE es_leagueteam_rel.FK_LEAGUE = {$ID_LEAGUE}
			ORDER BY (es_gameratings.Wins/(es_gameratings.Wins+es_gameratings.Losses)) DESC";

		return Doo::db()->query($query)->fetchall();
	}

	public function GetGameRatingsByTeams($teams)
	{
		$gameRatings = array();
		foreach ($teams as $team)
		{
			$ID_TEAM = $team->ID_TEAM;

			$gameRatingsByTeam = $this->GetGameRatingsByParticipant($ID_TEAM);
			$gameRatings[] = $gameRatingsByTeam;

			$matchState = $this->GetMatchState('Valid');
			$matches = $this->GetMatchesByParticipantAndState($ID_TEAM,$matchState);

			//Test game data
			foreach ($matches as $match)
			{
				$FK_LEAGUE = $match['FK_LEAGUE'];

				$leagues = Doo::db()->query("CALL esp_GetLeague({$FK_LEAGUE});")->fetchall();
				$league = $leagues[0];
				$FK_GAME = $league['FK_GAME'];

				$games = Doo::db()->query("CALL esp_GetGame({$FK_GAME});")->fetchall();
				$game = $games[0];
			
				//echo "League: {$league['LeagueName']}  ,game: {$game['GameName']}<br/>";
			}
			//exit;

		}
        return $gameRatings;
	}

	public function GetAllRatings($limit = 0, $byRating = true, $sortBy = 'DESC')
	{
                $lim = $limit == 0 ? '' : 'LIMIT '.$limit;
                $order = $byRating == true ? 'TotalRating' : 'DisplayName';
                
		$query = "
			SELECT COUNT(gr.Rating)as cnt, 
				SUM(gr.Rating) as TotalRating,
				(SUM(gr.Rating) / COUNT(gr.Rating)) as AvgRating,
				SUM(gr.Wins) as TotalWins,
				(SELECT FK_GROUP FROM es_teams WHERE ID_TEAM = p.ID_TEAM) as MultiplayerID,
				(SELECT DisplayName FROM es_teams WHERE ID_TEAM = MultiplayerID) as MultiplayerName,
				(SELECT Avatar FROM es_teams WHERE ID_TEAM = MultiplayerID) as TeamAvatar,
				p.*, gr.FK_TEAM, gr.FK_GAME, gr.Rating, gr.Wins, gr.Losses, gr.PlayMode
			FROM es_gameratings AS gr
			INNER JOIN sn_players AS p
			ON gr.FK_TEAM = p.ID_TEAM	
			GROUP BY p.DisplayName
			ORDER BY {$order} {$sortBy}
                        {$lim};
			";

		$ratings = Doo::db()->query($query)->fetchall();

		return $ratings;
	}
        
	public function GetAllTeamRatings($limit = 0, $byRating = true, $sortBy = 'DESC')
	{
                $lim = $limit == 0 ? '' : 'LIMIT '.$limit;
                $order = $byRating == true ? 'TotalRating' : 'DisplayName';
            
		$query = "
                        SELECT COUNT(gr.Rating)as cnt, 
				SUM(gr.Rating) as TotalRating,
				(SUM(gr.Rating) / COUNT(gr.Rating)) as AvgRating,
				SUM(gr.Wins) as TotalWins,
				t.*, gr.FK_TEAM, gr.FK_GAME, gr.Rating, gr.Wins, gr.Losses, gr.PlayMode
			FROM es_gameratings AS gr			
			INNER JOIN es_teams AS t
			ON gr.FK_TEAM = t.ID_TEAM	
			WHERE isSinglePlayerTeam = 0
			GROUP BY t.DisplayName
			ORDER BY {$order} {$sortBy}
                        {$lim};
			";

		$ratings = Doo::db()->query($query)->fetchall();

		return $ratings;
	}
	
	public function GetAllRatingsByGame($ID_GAME)
	{
		$query = "
			SELECT COUNT(gr.Rating)as cnt, 
				SUM(gr.Rating) as TotalRating,
				(SUM(gr.Rating) / COUNT(gr.Rating)) as AvgRating,
				SUM(gr.Wins) as TotalWins,
				(SELECT FK_GROUP FROM es_teams WHERE ID_TEAM = p.ID_TEAM) as MultiplayerID,
				(SELECT DisplayName FROM es_teams WHERE ID_TEAM = MultiplayerID) as MultiplayerName,
				(SELECT Avatar FROM es_teams WHERE ID_TEAM = MultiplayerID) as TeamAvatar,
				p.*, gr.FK_TEAM, gr.FK_GAME, gr.Rating, gr.Wins, gr.Losses, gr.PlayMode
			FROM es_gameratings AS gr
			INNER JOIN sn_players AS p
			ON gr.FK_TEAM = p.ID_TEAM
			WHERE gr.FK_GAME=$ID_GAME
			GROUP BY p.DisplayName
			ORDER BY AvgRating DESC;
			";

/*				SELECT p.*, gr.FK_TEAM, gr.FK_GAME, g.GameName, gr.Rating, gr.Wins, gr.Losses, gr.PlayMode FROM es_gameratings AS gr 
			INNER JOIN sn_games AS g
			ON gr.FK_GAME = g.ID_GAME
			INNER JOIN sn_players AS p
			ON gr.FK_TEAM = p.ID_TEAM
			WHERE gr.FK_LEAGUE = 38 AND gr.FK_GAME = g.ID_GAME
			ORDER BY gr.Rating DESC;
			";*/
		$ratings = Doo::db()->query($query)->fetchall();

		return $ratings;
	}
        
	public function GetAllTeamRatingsByGame($ID_GAME)
	{
		$query = "
                        SELECT COUNT(gr.Rating)as cnt, 
				SUM(gr.Rating) as TotalRating,
				(SUM(gr.Rating) / COUNT(gr.Rating)) as AvgRating,
				SUM(gr.Wins) as TotalWins,
				p.*
			FROM es_gameratings AS gr
			INNER JOIN es_teams AS p
			ON gr.FK_TEAM = p.ID_TEAM
			WHERE isSinglePlayerTeam = 0 AND gr.FK_GAME= {$ID_GAME}
			GROUP BY p.DisplayName
			ORDER BY AvgRating DESC;
			";

/*				SELECT p.*, gr.FK_TEAM, gr.FK_GAME, g.GameName, gr.Rating, gr.Wins, gr.Losses, gr.PlayMode FROM es_gameratings AS gr 
			INNER JOIN sn_games AS g
			ON gr.FK_GAME = g.ID_GAME
			INNER JOIN sn_players AS p
			ON gr.FK_TEAM = p.ID_TEAM
			WHERE gr.FK_LEAGUE = 38 AND gr.FK_GAME = g.ID_GAME
			ORDER BY gr.Rating DESC;
			";*/
		$ratings = Doo::db()->query($query)->fetchall();

		return $ratings;
	}

	
	public function GetRatingsByGame($ID_GAME,$ID_TEAM)
	{
		$query = "
			SELECT COUNT(gr.Rating)as cnt, 
				SUM(gr.Rating) as TotalRating,
				(SUM(gr.Rating) / COUNT(gr.Rating)) as AvgRating,
				SUM(gr.Wins) as TotalWins,
				p.*, gr.FK_TEAM, gr.FK_GAME, gr.Rating, gr.Wins, gr.Losses, gr.PlayMode
			FROM es_gameratings AS gr
			INNER JOIN sn_players AS p
			ON gr.FK_TEAM = p.ID_TEAM
			WHERE gr.FK_GAME=$ID_GAME
			AND p.ID_TEAM=$ID_TEAM
			GROUP BY p.DisplayName
			ORDER BY AvgRating DESC;
			";

		$ratings = Doo::db()->query($query)->fetchall();

		return $ratings;
	}
        
	public function GetTeamRatingsByGame($ID_GAME,$ID_TEAM)
	{
		$query = "
			SELECT COUNT(gr.Rating)as cnt, 
				SUM(gr.Rating) as TotalRating,
				(SUM(gr.Rating) / COUNT(gr.Rating)) as AvgRating,
				SUM(gr.Wins) as TotalWins,
				t.*, gr.FK_TEAM, gr.FK_GAME, gr.Rating, gr.Wins, gr.Losses, gr.PlayMode
			FROM es_gameratings AS gr
			INNER JOIN es_teams AS t
			ON gr.FK_TEAM = t.ID_TEAM
			WHERE gr.FK_GAME=$ID_GAME
			AND t.ID_TEAM=$ID_TEAM
			GROUP BY t.DisplayName
			ORDER BY AvgRating DESC;
			";

		$ratings = Doo::db()->query($query)->fetchall();

		return $ratings;
	}

	public static function GetTeamByID($ID_TEAM, $myteam = true)
	{
                $teams = new EsTeams();
                
                if($myteam == false){
                    $t1 = new EsTeams();
                    $t1->ID_TEAM = $ID_TEAM;
                    $t = $t1->getOne();
                    
                    return self::GetTeamByID($t->FK_GROUP);
                }
                
                $team = Doo::db()->getOne('EsTeams', array(
                                'where' => "{$teams->_table}.ID_TEAM = {$ID_TEAM}",
                                'limit' =>  1,
                ));
                                
                return $team;
		/*$query = "SELECT * FROM es_teams WHERE ID_TEAM = $ID_TEAM";

		$res = Doo::db()->query($query)->fetchall();
		if (count($res)>0)
			return $res[0];

		return array();
                 * 
                 */
                 
	}
	
	public function SetGameRating($ID_TEAM,$ID_GAME,$ID_LEAGUE,$Rating,$PlayMode,$won,$lost)
	{
		$query = "SELECT count(*) as cnt FROM es_gameratings WHERE FK_TEAM=$ID_TEAM AND FK_GAME=$ID_GAME AND FK_LEAGUE=$ID_LEAGUE";
		$res = Doo::db()->query($query)->fetchall();
		if ($res[0]['cnt'] >0)
		{
			$query = "UPDATE es_gameratings SET Wins=(Wins+$won),Losses=(Losses+$lost), Rating=$Rating WHERE FK_TEAM=$ID_TEAM AND FK_GAME=$ID_GAME AND FK_LEAGUE=$ID_LEAGUE";
			Doo::db()->query($query);
		}
		else
		{
			$query = "INSERT INTO es_gameratings (FK_TEAM,FK_GAME,FK_LEAGUE,Rating,Wins,Losses,PlayMode) VALUES 
				($ID_TEAM,$ID_GAME,$ID_LEAGUE,$Rating,$won,$lost,$PlayMode)";
			Doo::db()->query($query);
		}
	}
        
        public function GetLeagueIndexByRating($rating){
            
            $query = "SELECT entry FROM es_ladderranges WHERE min <= {$rating} AND max >= {$rating} LIMIT 1";
            $league = Doo::db()->query($query)->fetchall();
            
            return (int) !empty($league[0]['entry']) ? $league[0]['entry'] : 1;
        }
        
        public function GetHost($host){
            $query = "SELECT sn_players.* FROM sn_players WHERE sn_players.ID_PLAYER = {$host} LIMIT 1";
            $host = Doo::db()->query($query)->fetchall();
            
            return $host;
        }
        public function isTeamSignedUp($team, $league){
            $teams = new EsTeams();
            $teams->ID_TEAM = $team;
            $t = $teams->getOne();
            
            $where = $t->FK_GROUP != 0 ? "WHERE FK_LEAGUE = {$league} AND (FK_TEAM = {$t->ID_TEAM} OR FK_TEAM = {$t->FK_GROUP})" : "WHERE FK_LEAGUE = {$league} AND FK_TEAM = {$t->ID_TEAM}";
            
            $query = "SELECT * FROM es_leagueteam_rel {$where}";
                        
            $isSigned = Doo::db()->query($query)->fetchAll();
            
            if(isset($isSigned) && !empty($isSigned))
                return true;
            
            else return false;          
        }
        public function PickTournamentBackground($gamename){
            $url = "";
            $class = "";
            //****BY NAME ***//
            if(strpos($gamename,'Starcraft') !== false){
                    $url = Doo::conf()->APP_URL.'/global/img/esport/test/tournaments/bg_starcraft.png';
                    $class = 'game_starcraft';
            }
            else if(strpos($gamename, 'Call of Duty') !== false){
                    $url = Doo::conf()->APP_URL.'/global/img/esport/test/tournaments/bg_cod.png';
                    $class = 'game_cod';
            }
            else if(strpos($gamename, 'League of Legends') !== false){
                    $url = Doo::conf()->APP_URL.'/global/img/esport/test/tournaments/bg_lol.png';
                    $class = 'game_lol';
            }
            else{
                    $url = Doo::conf()->APP_URL.'/global/img/esport/test/tournaments/bg_default.png';
                    $class = 'game_default';
            }
                   
            //****BY TYPE ***//        
            /*switch ($gametype) {
                case 7: //First Person Shooter
                    $url = Doo::conf()->APP_URL.'/global/img/esport/test/tournaments/bg_lol.png';
                    break;
                case 7://Roleplay
                    $url = Doo::conf()->APP_URL.'/global/img/esport/test/tournaments/bg_lol.png';
                    break;
                case 9://Strategy
                    $url = Doo::conf()->APP_URL.'/global/img/esport/test/tournaments/bg_lol.png';
                    break;

                default:
                    break;*/
            return $class;
        }
        
        public function CreateSession($id){          
            
            $league = Doo::db()->getOne('EsLeagues',array(
                            'where'     =>  "ID_LEAGUE = {$id}"
            ));
            $sponsors = self::getSponsorsByLeague($id);
            
            $session['ID_GAME'] = $id;
            $session['Update'] = true;
            $session['CupType'] = $league->CupType;
                    
            //********BASIC INFO**********************************************/
            $session['cupName'] = $league->LeagueName;
            $session['game'] = $league->FK_GAME;
            $session['region'] = $league->FK_REGION;
            $starttime = $league->StartTime;
            $session['startdate_day'] = date('d',$starttime);
            $session['startdate_month'] = date('m',$starttime);
            $session['startdate_year'] = date('Y',$starttime);
            $session['starttime_hours'] = date('H',$starttime);
            $session['starttime_minutes'] = date('i',$starttime);
            $endtime = $league->EndTime;
            $session['enddate_day'] = date('d',$endtime);
            $session['enddate_month'] = date('m',$endtime);
            $session['enddate_year'] = date('Y',$endtime);
            $session['endtime_hours'] = date('H',$endtime);
            $session['endtime_minutes'] = date('i',$endtime);
            $signupdate = $league->SignupDeadline;
            $session['signupdeadline_day'] = date('d',$signupdate);
            $session['signupdeadline_month'] = date('m',$signupdate);
            $session['signupdeadline_year'] = date('Y',$signupdate);
            $session['cupsize'] = $league->LeagueSize;
            $session['teamsize'] = $league->Format;
            //********PARTICIPANTS********************************************/
            $session['minrating'] = $league->LowerRankingRestrictionRange;  
            $session['maxrating'] = $league->UpperRankingRestrictionRange;  
            $session['PlayMode'] = $league->PlayMode;  
            $session['entryfee'] = $league->EntryFee;  
            //********ROUNDS**************************************************/
            $session['DefaultBestOfMatchCount'] = $league->BestOfMatchCount;  
            
            //********REPLAYS*************************************************/
            $session['ReplayUploads'] = $league->ReplayUploads;  
            $session['ReplayDownloads'] = $league->ReplayDownloads;
            //********DESCRIPTION*********************************************/
            $session['LeagueDesc'] = $league->LeagueDesc;  
            //********GRAPHICS************************************************/
            $i = 0;
            foreach($sponsors as $sponsor){
                $places = array('one','two','three');
                $name = 'sponsor_'.$places[$i];
                $session[$name] = $sponsor->ID_SPONSOR;
                $i++;
            }
            $session['change_league_picture'] = $league->Image;
            
            
            return $session;
        }
        
        public function getAllSponsors(){
            $sponsors = new EsSponsors();
            
            $list = Doo::db()->find('EsSponsors', array(
                        'select' => "{$sponsors->_table}.*"
            ));
            
            return $list;
            
        }
         public function getSponsorsByLeague($ID_LEAGUE){
            $sponsors = new EsSponsors();
            $sl = new EsSponsorLeagueRel();
            
            $query = "SELECT {$sponsors->_table}.* FROM {$sponsors->_table} LEFT JOIN {$sl->_table} 
                        ON {$sl->_table}.FK_SPONSOR = {$sponsors->_table}.ID_SPONSOR
                        WHERE {$sl->_table}.FK_LEAGUE = {$ID_LEAGUE}
                        ORDER BY {$sl->_table}.SponsorPlace ASC";
            $rs = Doo::db()->query($query);
            $list = $rs->fetchAll(PDO::FETCH_CLASS, 'EsSponsors');
            
            return $list;
        }       
        public function setSponsor($league, $sponsor, $place){
            $sl = new EsSponsorLeagueRel();
            
            $query = "INSERT INTO {$sl->_table} ({$sl->_table}.FK_LEAGUE, {$sl->_table}.FK_SPONSOR, {$sl->_table}.SponsorPlace)
                        VALUES ({$league}, {$sponsor}, {$place})
                        ON DUPLICATE KEY UPDATE SponsorPlace = {$place}";
           Doo::db()->query($query);
        }
        public function getTotalSponsors($ID_LEAGUE){
            $result = Doo::db()->find('EsSponsorLeagueRel', array(
                            'select' => "COUNT(1) as cnt",
                            'where'  => "FK_LEAGUE = {$ID_LEAGUE}",
                            'limit'  => 1
                
            ));
            return $result->cnt;
        }
        
        public function getMapsByGame($ID_GAME){
            $maps = new EsMaps();
            
            $result = Doo::db()->find('EsMaps', array(
                            'select'    =>  "{$maps->_table}.*",
                            'where'     =>  "{$maps->_table}.FK_GAME = $ID_GAME",
                            'asc'      =>  "MapName"
            ));
            
            if(!empty($result) && isset($result))
                return $result;
            else return false;
        }

        public function getMapByName($name){
            $maps = new EsMaps();
            
            $result = Doo::db()->getOne('EsMaps', array(
                            'select'    =>  "{$maps->_table}.*",
                            'where'     =>  "{$maps->_table}.MapName = $name",
                            'limit' => 1
            ));
            
            if(!empty($result) && isset($result))
                return $result;
            else return false;
        }
        
        public function setMaps($ID_LEAGUE, $maps){
            $ml = new EsMapLeagueRel();
            $round = 1;
            
            foreach($maps as $map){
                if(!empty($map)){
                $query = "INSERT INTO {$ml->_table} ({$ml->_table}.FK_MAP,{$ml->_table}.FK_LEAGUE,{$ml->_table}.Round)
                            VALUES ($map,$ID_LEAGUE,$round)
                            ON DUPLICATE KEY UPDATE FK_MAP = {$map}";
                            
                Doo::db()->query($query);
                $round++;
                }
            }
        }
        
        public function uploadMap($ID_GAME, $mapname){
            $map = new EsMaps();
            
            $map->FK_GAME = $ID_GAME;
            $map->MapName = $mapname;
            $map->insert();
            
        }
        
        public function getGameByLeague($ID_LEAGUE){
            $games = new SnGames();
            $leagues = new EsLeagues();
            
            $leagues->ID_LEAGUE = $ID_LEAGUE;
            $league = $leagues->getOne();
            
            $games->ID_GAME = $league->FK_GAME;
            $game = $games->getOne();
            
            return $game;
        }
        
        public function deleteTournament($ID_LEAGUE){
            $leagues = new EsLeagues();
            
            $leagues->ID_LEAGUE = $ID_LEAGUE;
            $league = $leagues->getOne();
            $league->delete();
        }
        
        public function getTournamentByID($ID_LEAGUE){
            $leagues = new EsLeagues();
            
            $leagues->ID_LEAGUE = $ID_LEAGUE;
            $league = $leagues->getOne();
            
            return $league;
        }
        
        public function createFanclub($post){
            $fanclub = new EsFanclubs();
            
            if(isset($post['id_team'])){
                $fanclub->FK_TEAM = $post['id_team'];
                $fanclub->WelcomeMessage = isset($post['fanclub_desc']) ? $post['fanclub_desc'] : '';
                if(isset($post['fanclub_useProfile']))
                    $fanclub->ImageURL = User::getUser()->Avatar;
                else
                    $fanclub->ImageURL = isset($post['fanclub_img']) ? $post['fanclub_img'] : '';

                $fanclub->isProfileUrl = isset($post['fanclub_useProfile']) ? 1 : 0;

                $fanclub->insert();
            }
        }
        public function updateFanclub($post){
            $fanclub = new EsFanclubs();
            
            if(isset($post['id_team'])){
                $fanclub->FK_TEAM = $post['id_team'];
                $fanclub->WelcomeMessage = isset($post['fanclub_desc']) ? $post['fanclub_desc'] : '';
                if(isset($post['fanclub_useProfile']))
                    $fanclub->ImageURL = User::getUser()->Avatar;
                else
                    $fanclub->ImageURL = isset($post['fanclub_img']) ? $post['fanclub_img'] : '';

                $fanclub->isProfileUrl = isset($post['fanclub_useProfile']) ? 1 : 0;

                $fanclub->update();
            }
        }
        
        public function getAllFanclubs(){
            $fanclub = new EsFanclubs();
            
            $fanclubs = Doo::db()->find('EsFanclubs');
            return $fanclubs;
        }
        
        public function hasFanclub($player = ''){
            $player = !empty($player) ? $player : User::getUser()->ID_TEAM;
            
            $fanclub = self::getFanclubByID($player);
            
            if(isset($fanclub) && !empty($fanclub))
                return true;
            
            else return false;
        }
        
        public function getFanclubByID($ID_TEAM){
            $fanclub = Doo::db()->getOne('EsFanclubs',array(
                                    'where' => "FK_TEAM = {$ID_TEAM}",
                                    'limit' => 1,
            ));
            
            return $fanclub;
        }
        
        public function getPlayerFanclubRel($ID_PLAYER, $ID_FANCLUB){
            $pf = Doo::db()->getOne('SnPlayerFanclubRel',array(
                                'where' => "ID_PLAYER = {$ID_PLAYER} && ID_FANCLUB = {$ID_FANCLUB}",
                                'limit' => 1
            ));
            
            return $pf;
        }
        
        public function getAllMatchesByLeague($ID_LEAGUE){
            $matches = Doo::db()->find('EsCupmatchups',array(
                            'where' => "FK_CUP=$ID_LEAGUE",
                            'asc'   => 'Round,RoundIndex'
            ));   
            
            return $matches;
        }
        
        public function updateStatus($ID_PLAYER, $online){
            
            $query = "INSERT INTO es_gamelobby (FK_PLAYER,OnPage) VALUES({$ID_PLAYER},'{$online}')
                            ON DUPLICATE KEY UPDATE OnPage={$online}";
                            
            Doo::db()->query($query);
        }
        
        public function createQuickmatch($info){
            $league = new EsLeagues();
            extract($info);
            $player = User::getUser();
                        
            $league->FK_GAME = $gameinfo;
            $league->TournamentType = 'Quickmatch';
            $league->LeagueName = 'PlayNation Quickmatch';
            $league->FK_RULE = 1;
            $league->FK_REGION = 1;
            $league->isGlobal = 1;
            $league->PlayThirdPlaceMatch = 0;
            $league->LowerRankingRestrictionRange = 1;
            $league->UpperRankingRestrictionRange = 999999;
            $league->LeagueSize = 1;
            $league->StartTime = strtotime($date.' '.$time) ? strtotime($date.' '.$time)  : time();
            $league->Format = 1;
            $league->PlayMode = $playmode;
            $league->Host = $challengerinfo;
            $league->isActive = 1;
            $league->EntryFee = $betsize;
            $league->RankedStatus = $rankedstatus;
            $league->ServerDetails = $serverdetails;
            $league->TimeZone = $timezone;
            $league->insert();
            $new_id = Doo::db()->lastInsertId();
            
            if($opponentinfo != 0){
                $match = self::getMatchByLeague($new_id);
                $match->OpponentID = $opponentinfo;
                $match->update();
            }
            
            if($betsize > 0){
                $bettype = $playmode == '2' ? ESPORT_TRANSACTIONTYPE_CREDITS : ESPORT_TRANSACTIONTYPE_COINS;
                self::createTransaction($new_id, ESPORT_TRANSACTION_MATCHSIGNUP, $bettype, $betsize, ESPORT_TRANSACTIONTYPE_QUICKMATCH, ESPORT_TRANSACTIONTYPE_TEAM, $player->ID_TEAM);
            }
        }
        
        public function setQuickmatchOpponent($match, $opponent){
            $quickmatch = new EsQuickmatches();

            $quickmatch->ID_QUICKMATCH = $match;
            
            $quickmatch->Opponent = $opponent;
            $quickmatch->MatchState = self::GetMatchState('Active');
            $quickmatch->update();

            if($quickmatch->BetSize > 0){
                $bettype = $playmode == '2' ? ESPORT_TRANSACTIONTYPE_CREDITS : ESPORT_TRANSACTIONTYPE_COINS;
                self::createTransaction($quickmatch->ID_QUICKMATCH, ESPORT_TRANSACTION_MATCHSIGNUP, $bettype, $quickmatch->BetSize, ESPORT_TRANSACTIONTYPE_QUICKMATCH, ESPORT_TRANSACTIONTYPE_TEAM, $opponent);
            }
        }
        public function deleteQuickmatch($id){
            
            $league = Doo::db()->getOne('EsMatches',array(
                        'where' =>  "FK_LEAGUE = {$id}"
            ));
                        
            $league->State = self::GetMatchState('Cancelled'); 
            $league->update();
        }
        
        public function getQuickmatchByTeam($ID_TEAM = ''){
            $quickmatch = Doo::db()->getOne('EsLeagues', array(
                            'where' =>  "Host = {$ID_TEAM} AND TournamentType = 'Quickmatch' AND isActive = 1",
                                    'limit' =>  1
            ));
            if(!empty($quickmatch)){
                $match = Doo::db()->getOne('EsMatches', array(
                    "where" =>  "FK_LEAGUE = {$quickmatch->ID_LEAGUE}"
                )); 
                $quickmatch->MatchState = $match->State;                
            }
            return $quickmatch;
        }
        public function getQuickmatchByID($ID_MATCH){
            $quickmatch = Doo::db()->getOne('EsMatches', array(
                            'where' =>  "FK_LEAGUE = {$ID_MATCH}",
                            'limit' =>  1
            ));
                            
            return $quickmatch;
        }
        public function getAllQuickmatches($includeOwn = false){
            $p = User::getUser();
            $matches = array();
            $params = array();
            
            $includeOwn == false ? $params['where'] = "ChallengerID <> {$p->ID_TEAM} AND TournamentType = 'Quickmatch' AND isActive = 1" : $params['where'] = "TournamentType = 'Quickmatch' AND isActive = 1";
            
            
            $quickmatch = Doo::db()->find('EsLeagues',$params);
            foreach($quickmatch as $q){
                
                $match = Doo::db()->getOne('EsMatches',array(
                    'where' => "FK_LEAGUE = {$q->ID_LEAGUE}"
                ));
                    
                $qm = new EsQuickmatches();
                $qm->ID_QUICKMATCH = $q->ID_LEAGUE;     
                $qm->Challenger = $match->ChallengerID;    
                $qm->MatchState = $match->State;    
                $qm->BetSize = $q->EntryFee;    
                $qm->FK_GAME = $q->FK_GAME;    
                $qm->PlayMode = $q->PlayMode;    
                $qm->Account = $q->Account;
                $matches[] = $qm;
            }
                              
                            
            return $matches;
        }
        
        public function createLobbyNote($from, $to, $type, $match){
            $note = new EsLobbynotifications();
            
            $note->Reciever = $to;
            $note->Sender = $from;
            $note->MessageType = $type;
            $note->FK_QUICKMATCH = $match;
            $note->insert();
            
        }
        
        public function getLobbyNotesByTeam($ID_TEAM, $order = 'ASC', $limit = 20){
            
            $notes = Doo::db()->find('EsLobbynotifications', array(
                                'where'     =>  "Reciever = {$ID_TEAM} && New = 1",
                                'limit'     =>  $limit,
                                "$order"    =>  "ID_LOBBYNOTE"        
            ));
            
            return $notes;
        }
        
        public function setupQuickmatch($id, $opponent){
            $match = new EsMatches();
            $qm = new EsQuickmatches();
            $league = new EsLeagues();
            
            /*$qm->ID_QUICKMATCH = $id;
            $quick = $qm->getOne();
            $quick->Opponent = $opponent;
            $quick->MatchState = self::GetMatchState('Active');*/
            
            $league = Doo::db()->getOne('EsMatches',array(
                        'where' =>  "FK_LEAGUE = {$id}"
            ));
                        
            $league->OpponentID = $opponent;            
            $league->State = self::GetMatchState('Active');    
            $league->update();
            
            if($quick->BetSize > 0){
                $bettype = $quick->PlayMode == 2 ? ESPORT_TRANSACTIONTYPE_CREDITS : ESPORT_TRANSACTIONTYPE_COINS;
                self::createTransaction($quick->ID_QUICKMATCH, ESPORT_TRANSACTION_MATCHSIGNUP, $bettype, $quick->BetSize, ESPORT_TRANSACTIONTYPE_QUICKMATCH, ESPORT_TRANSACTIONTYPE_TEAM, $opponent);
            }
            
            /*$quick->update();
            
            $league->FK_GAME = $quick->FK_GAME;
            $league->TournamentType = 'Quickmatch';
            $league->LeagueName = 'PlayNation Quickmatch';
            $league->FK_RULE = 1;
            $league->FK_REGION = 1;
            $league->isGlobal = 1;
            $league->PlayThirdPlaceMatch = 0;
            $league->LowerRankingRestrictionRange = 1;
            $league->UpperRankingRestrictionRange = 999999;
            $league->LeagueSize = 1;
            $league->StartTime = time();
            $league->Format = 1;
            $league->PlayMode = $quick->PlayMode;
            $league->isActive = 1;
            $league->EntryFee = $quick->BetSize;
            $league->Account = $quick->Account * 2;
            $league->Rake = $quick->Rake * 2;
            $league->insert();
            
            $l = $league->getOne();
            
            $match->FK_LEAGUE = $l->ID_LEAGUE; 
            $match->StartTime = time();
            $match->ChallengerID = $quick->Challenger;
            $match->OpponentID = $quick->Opponent;
            $match->StartTime = $l->StartTime;
            $match->State = $quick->MatchState;
            $match->PlayMode = $quick->PlayMode;
            $match->BetSize = $quick->BetSize;
            $match->insert();*/
            
        }
        
        public function getOnlinePlayers(){
            $lobby = new EsGamelobby();
            
            $query = "SELECT * FROM {$lobby->_table} WHERE {$lobby->_table}.OnPage = 1";
            $cnt = Doo::db()->query($query)->rowCount();
            return $cnt;
        }
        
        public function updateTeaminfo($post){
            $team = new EsTeams();
            $tm = new EsTeamMembersRel();
            $user = new User();
            extract($post);
            
            $team->ID_TEAM = $team_id;
            $team->DisplayName = $team_name;
            $team->TeamInitials = $team_initials;
            $team->Country = $team_country;
            if(isset($team_img) && $team_img != '') $team->Avatar = $team_img ;
            
            if(isset($delete) && !empty($delete)){
                foreach($delete as $player){
                    $p = $user->getByEmail($player);
                    
                    $query = "DELETE FROM {$tm->_table} WHERE {$tm->_table}.FK_PLAYER = {$p->ID_TEAM}";
                        
                    Doo::db()->query($query);
                }
            }
            if(isset($roster) && !empty($roster)){
                foreach($roster as $player){
                    $p = $user->getByEmail($player);
                    
                    $query = "INSERT INTO {$tm->_table} (FK_PLAYER, FK_TEAM, Role, isPending) VALUES ({$p->ID_TEAM},{$team_id},1,1)
                        ON DUPLICATE KEY UPDATE FK_TEAM={$team_id}, Role=1;";
                        
                    Doo::db()->query($query);
                }
            }
            
            $team->update();
        }
        
        public function getAllPlayersByTeam($id){
            $p = new Players();
            
            $teams = Doo::db()->find('EsTeamMembersRel', array(
                        'where' =>  "FK_TEAM = {$id}",
                        'desc'  =>  'isCaptain'
            )); 
                        
            $players = array();
                        
            foreach($teams as $team){
                $p = Doo::db()->getOne('Players',array(
                        'where' =>  "ID_TEAM = {$team->FK_PLAYER}",
                ));
                $p->isCaptain = $team->isCaptain;
                $p->Role = $team->Role;
                $p->isPending = $team->isPending;
                $players[] = $p;
            }            
            return $players;            
        }
        
        public function createTeam($info = array()){
            
            $team = new EsTeams();
            $p = User::getUser();
            $post = extract($info);
            
            if(!empty($info)){
                
                if($p->ID_TEAM == 0){
                    self::RegisterPlayer($p);
                }
                                
                $team->DisplayName = !empty($teamname) ? $teamname : 'TEAM '.$p->DisplayName; 
                $team->TeamInitials = !empty($initials) ? $initials : '';
                $team->Country = !empty($country) ? $country : $p->Country;
                $team->IntroMessage = !empty($intromessage) ? $intromessage : '';
                $team->isSinglePlayerTeam = 0;
                $team->insert();
                $new_id = Doo::db()->lastInsertId();
                
                if(!empty($facebook)){
                    $face = new EsTeamSocialRel();
                    $face->FK_TEAM = $new_id;
                    $face->SocialName = SOCIAL_FACEBOOK;
                    $face->SocialURL = $facebook;
                    $face->insert();
                }
                if(!empty($twitter)){
                    $face = new EsTeamSocialRel();
                    $face->FK_TEAM = $new_id;
                    $face->SocialName = SOCIAL_TWITTER;
                    $face->SocialURL = $twitter;
                    $face->insert();
                }
                if(!empty($twitch)){
                    $face = new EsTeamSocialRel();
                    $face->FK_TEAM = $new_id;
                    $face->SocialName = SOCIAL_TWITCH;
                    $face->SocialURL = $twitch;
                    $face->insert();
                }
                if(!empty($youtube)){
                    $face = new EsTeamSocialRel();
                    $face->FK_TEAM = $new_id;
                    $face->SocialName = SOCIAL_YOUTUBE;
                    $face->SocialURL = $youtube;
                    $face->insert();
                }
                
                $cap = new EsTeamMembersRel();
                $cap->FK_PLAYER = $p->ID_TEAM;
                $cap->FK_TEAM = $new_id;
                $cap->isCaptain = 1;
                $cap->isPending = 0;
                $cap->insert();
                    
                foreach($members as $member){
                    if($member != '0'){
                        $tm = new EsTeamMembersRel();
                        $tm->FK_PLAYER = $member;
                        $tm->FK_TEAM = $new_id;
                        $tm->isPending = 1;
                        $tm->isCaptain = $_POST['rolebox_'.$member] == 'captain' ? 1 : 0;
                        $tm->insert();
                    }
                }
            }
        }
        
        public function createTransaction($owner, $transactiontype, $credittype, $amount, $ownertype = ESPORT_TRANSACTIONTYPE_TEAM, $transactortype = ESPORT_TRANSACTIONTYPE_PLAYER, $transactor = '' ){
            $trans = new EsTransactions();
            
            $trans->FK_OWNER = $owner;
            $trans->OwnerType = $ownertype;
            $trans->TransactionType = $transactiontype;
            $trans->TransactionTime = time();
            $credittype == ESPORT_TRANSACTIONTYPE_CREDITS ? $trans->Credits = $amount : $trans->Coins = $amount;
            $trans->FK_TRANSACTOR = $transactor == '' ? User::getUser()->ID_PLAYER : $transactor;
            $trans->TransactorType = $transactortype;
            $trans->insert();
        }
        
        public function deleteTeam($id, $singleteam = false){
            $tm = new EsTeamMembersRel();
            $players = new Players();
            
            if($singleteam == false){
                $query = "DELETE FROM {$tm->_table} WHERE {$tm->_table}.FK_TEAM = {$id}";
                Doo::db()->query($query);
            }
            else{
                $query = "UPDATE {$players->_table} SET {$players->_table}.ID_TEAM = 0 WHERE {$players->_table}.ID_TEAM = {$id}";
                Doo::db()->query($query);
            }
            
        }
        
        public function deleteTeamMemberRelation($ID_TEAM, $ID_PLAYER){
            $tm = new EsTeamMembersRel();
            
            $tm->FK_TEAM = $ID_TEAM;
            $tm->FK_PLAYER = $ID_PLAYER;
            $tm->delete();
        }
        
        public function signupTournament($ID_LEAGUE, $ID_TEAM){
            $lt = new EsLeagueTeamRel();
            
               $query = "INSERT INTO {$lt->_table} (FK_LEAGUE, FK_TEAM, ParticipantStatus) VALUES({$ID_LEAGUE},{$ID_TEAM},1)
             ON DUPLICATE KEY UPDATE FK_TEAM = {$ID_TEAM}";
            
            Doo::db()->query($query);
        }
        
        public function getTeamRelations($ID_TEAM, $isPending = false, $isCaptain = false){
            
            $teams = array();
            $pending = $isPending ? ' AND isPending = 1' : '';
            $captain = $isCaptain ? ' AND isCaptain = 1' : '';
            
            $pt = Doo::db()->find('EsTeamMembersRel',array(
                        'where' =>  "FK_PLAYER = {$ID_TEAM}{$pending}{$captain}"
            ));
                        
            foreach($pt as $team){
                $teams[] = Doo::db()->getOne('EsTeams',array(
                    'where' =>  "ID_TEAM = {$team->FK_TEAM}"
                ));
            }
            
            return $teams;
        }
        
        public function getTeamRelationsByTeam($ID_TEAM, $ID_PLAYER){
            
            $tm = Doo::db()->getOne('EsTeamMembersRel',array(
                    'where' =>  "FK_TEAM = {$ID_TEAM} AND FK_PLAYER = {$ID_PLAYER}"
            ));
                    
            return $tm;
        }
        
        public function setTeamStatus($ID_TEAM, $ID_PLAYER, $statustype, $status){
            
            $tm = new EsTeamMembersRel();
            $tm->FK_TEAM = $ID_TEAM;
            $tm->FK_PLAYER = $ID_PLAYER;
            
            if($statustype == ESPORT_TEAMSTATUS_PENDING){ 
                    $tm->isPending = $status;
                    Doo::db()->query("INSERT INTO {$tm->_table} (FK_PLAYER, FK_TEAM, isPending) VALUES ({$tm->FK_PLAYER},{$tm->FK_TEAM},{$tm->isPending})
                        ON DUPLICATE KEY
                        UPDATE {$tm->_table}.isPending = {$tm->isPending} WHERE {$tm->_table}.FK_TEAM = {$tm->FK_TEAM} AND {$tm->_table}.FK_PLAYER = {$tm->FK_PLAYER}");
            }
            if($statustype == ESPORT_TEAMSTATUS_CAPTAIN){
                    $tm->isCaptain = $status;
                    Doo::db()->query("INSERT INTO {$tm->_table} (FK_PLAYER, FK_TEAM, isCaptain) VALUES ({$tm->FK_PLAYER},{$tm->FK_TEAM},{$tm->isCaptain})
                        ON DUPLICATE KEY
                        UPDATE {$tm->_table} SET {$tm->_table}.isCaptain = '{$tm->isCaptain}' WHERE {$tm->_table}.FK_TEAM = {$tm->FK_TEAM} AND {$tm->_table}.FK_PLAYER = {$tm->FK_PLAYER}");
            }
        }
        
        public function addGameToEsportTEAM($ID_TEAM, $ID_GAME){
            $gt = new EsGameTeamRel();
            
            $gt->FK_GAME = $ID_GAME;
            $gt->FK_TEAM = $ID_TEAM;
            $gt->isActive = 1;
            $gt->insert();
        }
        
        public function ToggleGameTeamRelation($ID_TEAM, $ID_GAME, $active){
            $gt = new EsGameTeamRel();
            
            $query = "UPDATE {$gt->_table} SET {$gt->_table}.isActive = {$active} WHERE {$gt->_table}.FK_GAME = {$ID_GAME} AND {$gt->_table}.FK_TEAM = {$ID_TEAM}";
            
            Doo::db()->query($query);
        }
        
        public function unsubscribeTournament($ID_LEAGUE, $ID_TEAM){
            $lt = new EsLeagueTeamRel();
            $cupmatchup = new EsCupmatchups();
            $league = self::getTournamentByID($ID_LEAGUE);
            
            if($league->TournamentType == 'Cup'){
                $query = "UPDATE {$cupmatchup->_table} SET 
                            {$cupmatchup->_table}.FK_PARTICIPANT1 = IF({$cupmatchup->_table}.FK_PARTICIPANT1 = {$ID_TEAM}, 0, {$cupmatchup->_table}.FK_PARTICIPANT1), 
                            {$cupmatchup->_table}.FK_PARTICIPANT2 = IF({$cupmatchup->_table}.FK_PARTICIPANT2 = {$ID_TEAM}, 0, {$cupmatchup->_table}.FK_PARTICIPANT2) 
                            WHERE {$cupmatchup->_table}.FK_CUP = {$ID_LEAGUE} AND {$cupmatchup->_table}.FK_PARTICIPANT1 = {$ID_TEAM} OR {$cupmatchup->_table}.FK_PARTICIPANT2 = {$ID_TEAM}";
                            
            }
            else{
                $query = "DELETE FROM {$lt->_table} WHERE {$lt->_table}.FK_LEAGUE = {$ID_LEAGUE} AND {$lt->_table}.FK_TEAM = {$ID_TEAM}";
            }
            
            Doo::db()->query($query);
        }
        
        public function getSignedUpTeamByPlayer($ID_PLAYER, $ID_LEAGUE){
            $lt = new EsLeagueTeamRel();
            $player = User::getById($ID_PLAYER);
            $team = self::getTeamByID($player->ID_TEAM);
            $or = $team->FK_GROUP != 0 ? " OR FK_TEAM = {$team->FK_GROUP}" : '';
            
            $rel = Doo::db()->getOne('EsLeagueTeamRel', array(
                    'where' =>  "FK_LEAGUE = {$ID_LEAGUE} AND FK_TEAM = {$team->ID_TEAM}{$or}"
            ));
                    
            return self::getTeamByID($rel->FK_TEAM);
        }
        
        public function getMatchupByMatchID($ID_MATCH){
            
            $matchup = Doo::db()->getOne('EsCupmatchups',array(
                        'where' =>  "FK_MATCH = {$ID_MATCH}"
            ));
                        
            return $matchup;
        }
        
        public function getAllComputerSpecificationsByTeam($ID_TEAM){
            $constant = new EsConstants();
            $tc = new EsTeamComputerSpecRel();
            
            $query = "SELECT {$tc->_table}.*, {$constant->_table}.ConstantName as SpecName FROM {$constant->_table}
                LEFT JOIN {$tc->_table} ON {$constant->_table}.ID_CONSTANT = {$tc->_table}.FK_COMPUTERSPEC AND {$tc->_table}.FK_TEAM = {$ID_TEAM} 
                WHERE {$constant->_table}.ConstantType = 'ComputerSpec'";
            
            $spec = Doo::db()->query($query)->fetchAll(PDO::FETCH_CLASS, 'EsTeamComputerSpecRel');    
            return $spec;
        }
        
        public function getComputerSpecificationsByTeam($ID_TEAM){
            $constant = new EsConstants();
            $tc = new EsTeamComputerSpecRel();
            
            $query = "SELECT {$tc->_table}.*, {$constant->_table}.ConstantName as SpecName FROM {$constant->_table} LEFT JOIN {$tc->_table} 
                ON {$constant->_table}.ID_CONSTANT = {$tc->_table}.FK_COMPUTERSPEC 
                WHERE {$tc->_table}.FK_TEAM = {$ID_TEAM} AND {$constant->_table}.ConstantType = 'ComputerSpec'";
                    
            $spec = Doo::db()->query($query)->fetchAll(PDO::FETCH_CLASS, 'EsTeamComputerSpecRel');    
            return $spec;
        }
        
        public function getTeamSocials($ID_TEAM){
            
            $social = Doo::db()->find('EsTeamSocialRel', array(
                    'where' =>  "FK_TEAM = {$ID_TEAM}"
            ));

            return $social;
        }
        
        public function getTotalLikes($ID_TEAM){
            
            $ts = new SnPlayerFanclubRel();
            $likes = (object) Doo::db()->fetchRow('SELECT COUNT(*) as cnt FROM ' . $ts->_table . ' WHERE isLiked = 1 AND ID_FANCLUB = '. $ID_TEAM .' LIMIT 1');

            return $likes->cnt;
        }
        
        public function getSpotlightItems($ID_TEAM){
            
            $items = Doo::db()->find('EsWallitems', array(
                    'where' =>  "ID_WALLOWNER = {$ID_TEAM}",
                    'desc'  =>  'PostingTime'
            ));

            return $items;
        }
        
        public static function getAllGames(){
            $games = Doo::db()->find('SnGames', array(
                    'where' =>  "isESportGame = 1"
            ));
            
            return $games;
        }
        
        public function getFansByTeam($ID_TEAM){
            $query = "SELECT sn_players.* FROM sn_players 
                RIGHT JOIN sn_playerfanclub_rel ON sn_players.ID_PLAYER = sn_playerfanclub_rel.ID_PLAYER
                WHERE isLiked = 1 AND ID_FANCLUB = {$ID_TEAM}";
                
            $res = Doo::db()->query($query)->fetchAll(PDO::FETCH_CLASS, 'Players');
            return $res;
        }
        
        public function getLastPlayedMatches($ID_TEAM, $limit = 1){
            $match = new EsMatches();
            $league = new EsLeagues();
            $state = self::GetMatchState('Closed'); 
            
            $query = "SELECT * FROM {$match->_table} 
                LEFT JOIN {$league->_table} ON {$match->_table}.FK_LEAGUE = {$league->_table}.ID_LEAGUE 
                WHERE ({$match->_table}.ChallengerID = {$ID_TEAM} OR {$match->_table}.OpponentID = {$ID_TEAM}) AND {$match->_table}.State = {$state} 
                ORDER BY {$match->_table}.ReportedResultTime 
                DESC LIMIT {$limit};";
                
            return Doo::db()->query($query)->fetchAll(PDO::FETCH_CLASS, 'SnGames');            
        }
        
        public function setComment(Players &$p, $postID, $comment) {
            $wall = new EsWallitems();
            $wall->ID_WALLITEM = $postID;
            $wall->purgeCache();
            $wall = $wall->getOne();
            if($p->ID_PLAYER && strlen($comment) > 0 && !empty($wall)) {
                $wallreply = new EsWallreplies();
                $wallreply->ID_WALLITEM = $postID;
                $wallreply->ID_OWNER = $p->ID_PLAYER;
                $wallreply->OrgOwnerType = WALL_OWNER_PLAYER;
                $wallreply->Message = ContentHelper::handleContentInput(trim($comment));
                $wallreply->insert();

                $wallreply->purgeCache();
                $p->purgeCache();
                return $postID;
            }
            return 0;
        }
        
        public function setLike($ID_PLAYER, $postID, $ReplyNumber = 0){
            $like = new EsLikes();
            
            $like->ID_PLAYER = $ID_PLAYER;
            $like->ID_WALLITEM = $postID;
            $like->ReplyNumber = $ReplyNumber;
            $like->Likes = 1;
            
            $like->insert();
        }
        public function deleteLike($ID_PLAYER, $postID, $ReplyNumber = 0){
            $like = new EsLikes();
            
            $like->ID_PLAYER = $ID_PLAYER;
            $like->ID_WALLITEM = $postID;
            $like->ReplyNumber = $ReplyNumber;
            
            $like->delete();
        }
        
        public function getLeagueDataByTeam(EsTeams $team){
                            /************TEST AREA************/
		$game = new Games();
                
		$games = self::GetGamesByFK_TEAM($team->ID_TEAM);
		$leagues = self::GetLadderLeagues();
                
                //Games rating
                $allRatings = self::GetAllRatingsByGame(11);
               
		//My rating
		$myRating = self::GetTotalRating($team->ID_TEAM,$allRatings);

		//Show by game
		$selectedLeague = self::GetLeagueIndexByRating($myRating);
		$selectedTier = 0;
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
                
                $leagueranking = array();
                $count = 1;
                $myposition = '-';
                foreach($allRatings as $rating){
                    
                    
                    if($rating['TotalRating'] > $tierMin && $rating['TotalRating'] < $tierMax){
                        if($rating['ID_TEAM'] == $team->ID_TEAM) $myposition = $count;
                        $rating['position'] = $count++;
                        $leagueranking[] = $rating;
                    }
                }
                
                $profile['leagueranking'] = $leagueranking;
                $profile['selectedTier'] = $selectedTier;
                $profile['tierMax'] = $tierMax;
                $profile['tierMin'] = $tierMin;
                
                switch ($selectedTier){
                    case 1:
                        $selectedTier = 'I';
                        break;
                    case 2:
                        $selectedTier = 'II';
                        break;
                    case 3:
                        $selectedTier = 'III';
                        break;
                    case 4:
                        $selectedTier = 'IV';
                        break;
                    case 5:
                        $selectedTier = 'V';
                        break;
                    default:
                        $selectedTier = 0;
                        break;
                }
                
                $gamerank = self::GetHighestAchievedLeagueInGames($games, $team->ID_TEAM);
                
                $team->Tier = $selectedTier;
                $team->Rank = $myposition;
                $team->Fans = self::getTotalLikes($team->ID_TEAM);
                $team->Division = $gamerank['ladderLeague'];
                /*************************/
                return $team;
        }
        
        public function getGamesInCommon($team1, $team2){
            $query = "SELECT v1.FK_GAME, sn_games.*
                        FROM es_gameteam_rel v1
                        LEFT JOIN sn_games  ON v1.FK_GAME = sn_games.ID_GAME
                        INNER JOIN es_gameteam_rel v2 ON (v1.FK_GAME = v2.FK_GAME)
                        WHERE v1.FK_TEAM = {$team1}
                        AND v2.FK_TEAM = {$team2}";
                        
            $games = Doo::db()->query($query)->fetchAll(PDO::FETCH_CLASS, 'SnGames');
            return $games;
        }
        
        public static function getUserByEsportTeam($ID_TEAM){
            $p = Doo::db()->getOne('Players', array(
                        'where' =>  "ID_TEAM = {$ID_TEAM}"
            ));
                        
            return $p;
        }
        
        public function SaveSpotlight($post){
            extract($post);
            
            $ID_TEAM = $teaminfo;
            
            $team = new EsTeams();
            $team->ID_TEAM = $ID_TEAM;
            
            !empty($displayname) ? $team->DisplayName = $displayname : '';
            $team->Avatar = $team_img;
            $team->IntroMessage = $intromessage;
            $team->update();
            
            $count = 1;
            
            foreach ($socials as $social){
                $soc = new SnSocialsRel();
                $soc->FK_OWNER = $ID_TEAM;
                $soc->OwnerType = SOCIAL_OWNERTYPE_TEAM;
                $soc->FK_SOCIAL = $count;
                $soc->SocialURL = $social;
                
                if(empty($social)){
                    $query = "DELETE FROM {$soc->_table} WHERE {$soc->_table}.FK_OWNER = {$soc->FK_OWNER} AND {$soc->_table}.OwnerType = '{$soc->OwnerType}' AND {$soc->_table}.FK_SOCIAL =  {$soc->FK_SOCIAL};";
                              
                    Doo::db()->query($query);
                }
                else{
                    $query = "INSERT INTO {$soc->_table} (FK_OWNER,OwnerType,FK_SOCIAL, SocialURL) VALUES ({$soc->FK_OWNER},'{$soc->OwnerType}',{$soc->FK_SOCIAL},'{$soc->SocialURL}')
                              ON DUPLICATE KEY UPDATE SocialURL='{$soc->SocialURL}';";
                              
                    Doo::db()->query($query);
                }
                $count++;
            }
            
            $rigcount = 21;
            
            foreach ($gamingrig as $item){
                $spec = new EsTeamComputerSpecRel();
                $spec->FK_TEAM = $ID_TEAM;
                $spec->FK_COMPUTERSPEC = $rigcount;
                $spec->SpecDesc = $item;
                
                if(empty($item)){
                    $query = "DELETE FROM {$spec->_table} WHERE {$spec->_table}.FK_TEAM = {$spec->FK_TEAM} AND {$spec->_table}.FK_COMPUTERSPEC = {$spec->FK_COMPUTERSPEC};";
                              
                    Doo::db()->query($query);
                }
                else{
                    $query = "INSERT INTO {$spec->_table} (FK_TEAM,FK_COMPUTERSPEC,SpecDesc) VALUES ({$spec->FK_TEAM},{$spec->FK_COMPUTERSPEC},'{$spec->SpecDesc}')
                              ON DUPLICATE KEY UPDATE SpecDesc='{$spec->SpecDesc}';";
                              
                    Doo::db()->query($query);
                }
                $rigcount++;
            }
            
        }
        
        public function SaveTeam($post){
            extract($post);
            
            $ID_TEAM = $teaminfo;
            
            $team = new EsTeams();
            $team->ID_TEAM = $ID_TEAM;
            
            !empty($displayname) ? $team->DisplayName = $displayname : '';
            $team->Country = $country;
            $team->Avatar = $team_img;
            $team->IntroMessage = $intromessage;
            $team->update();
            
            $count = 1;
            
            foreach ($socials as $social){
                $soc = new SnSocialsRel();
                $soc->FK_OWNER = $ID_TEAM;
                $soc->OwnerType = SOCIAL_OWNERTYPE_TEAM;
                $soc->FK_SOCIAL = $count;
                $soc->SocialURL = $social;
                
                if(empty($social)){
                    $query = "DELETE FROM {$soc->_table} WHERE {$soc->_table}.FK_OWNER = {$soc->FK_OWNER} AND {$soc->_table}.OwnerType = '{$soc->OwnerType}' AND {$soc->_table}.FK_SOCIAL =  {$soc->FK_SOCIAL};";
                              
                    Doo::db()->query($query);
                }
                else{
                    $query = "INSERT INTO {$soc->_table} (FK_OWNER,OwnerType,FK_SOCIAL, SocialURL) VALUES ({$soc->FK_OWNER},'{$soc->OwnerType}',{$soc->FK_SOCIAL},'{$soc->SocialURL}')
                              ON DUPLICATE KEY UPDATE SocialURL='{$soc->SocialURL}';";
                              
                    Doo::db()->query($query);
                }
                $count++;
            }
            
            $rigcount = 21;
            
            foreach ($members as $member){
                $memberinfo = explode('_', $member);
                $role = $memberinfo[0];
                $id = $memberinfo[1];
                
                switch($role){
                    case '1':
                        self::setTeamStatus($ID_TEAM, $id, ESPORT_TEAMSTATUS_CAPTAIN, 1);
                    break;
                    case '2':
                        self::setTeamStatus($ID_TEAM, $id, ESPORT_TEAMSTATUS_CAPTAIN, 1);
                    break;
                    case '3':
                        self::setTeamStatus($ID_TEAM, $id, ESPORT_TEAMSTATUS_PENDING, 0);
                    break;
                    case '4':
                        self::deleteTeamMemberRelation($ID_TEAM, $id);
                    break;
                }
            }
        }
        
        public function SetMatchState($ID_MATCH, $state){
            $match = new EsMatches();
            $match->ID_MATCH = $ID_MATCH;
            $match->State = self::GetMatchState($state);
            $match->update();
        }
        
        public function RegisterPlayer(Players $p){
            $sTeam = new EsTeams();
            $sTeam->DisplayName = $p->DisplayName;
            $sTeam->Avatar = $p->Avatar;
            $sTeam->Country = $p->Country;
            $sTeam->isSinglePlayerTeam = 1;
            $sTeam->insert();
            $single_id = Doo::db()->lastInsertId();

            $p->ID_TEAM = $single_id;
            $p->update();
        }
        
        public function SubmitScore($post){
            extract($post);
            
            $ID_TEAM = User::getUser()->ID_TEAM;
            $match = self::getMatchByIDWithLeagueData($matchinfo);
            
            if($ID_TEAM == $match->ChallengerID){
                $match->ChallengerReportedScore = $matchscore;
                $match->ChallengerScreenshot = $challenge_img_upload;
            }
            elseif($ID_TEAM == $match->OpponentID){
                $match->OpponentReportedScore = $matchscore;
                $match->OpponentScreenshot = $challenge_img_upload;
            }
            else return false;
            
            if(!empty($match->ChallengerReportedScore) && !empty($match->OpponentReportedScore)){
                if($match->ChallengerReportedScore == $match->OpponentReportedScore){
                    $match->Score = $matchscore;
                    $match->State = self::getMatchState('Closed');
                            
                    $score = explode('-',$match->Score);
                    $challengerRes = $score[0];
                    $opponentRes = $score[1];
                    
                    if($challengerRes > $opponentRes){
                        $match->MatchWinnerID = $match->ChallengerID;
                        $match->MatchLoserID = $match->OpponentID;
                    }   
                    else if($opponentRes > $challengerRes){
                        $match->MatchWinnerID = $match->OpponentID;
                        $match->MatchLoserID = $match->ChallengerID;
                    }
                }
                else{
                    $match->DisputeCount = 1;
                }
            }
            $match->update();
        }
}
?>