<?php

Doo::loadCore('db/DooSmartModel');

class EsTeams extends DooSmartModel {
    
    public $ID_TEAM;
    public $FK_GROUP;
    public $DisplayName;
    public $TeamInitials;
    public $EMail;
    public $Avatar;
    public $Address;
    public $Country;
    public $isSinglePlayerTeam;
    public $Dollars;
    public $Cents;
    public $Area;
    public $CreateDate;
    public $MatchedPlayedCount;
    public $DisputedMatchCount;
    public $IntroMessage;
    public $ViewCount;
    
    //Filled out by getLeagueData()//
    public $Division;
    public $Tier;
    public $Rank;
    public $Fans;
    public $LeagueRankings;
    public $TotalWins;
    public $TotalLosses;
    public $TotalDraws;
    /////////////////////////////////
    
    public $_table = 'es_teams';
    public $_primarykey = 'ID_TEAM'; 
    public $_fields = array(
                'ID_TEAM',
                'FK_GROUP',
                'DisplayName',
                'TeamInitials',
                'EMail',
                'Avatar',
                'Address',
                'Country',
                'isSinglePlayerTeam',
                'Dollars',
                'Cents',
                'Area',
                'CreateDate',
                'MatchedPlayedCount',
                'DisputedMatchCount',
                'IntroMessage',
                'ViewCount'
	);
    
    public function viewed(){
                $this->ViewCount = $this->ViewCount + 1;
                $this->update();
    }
    
    public function updateViews(){
        $p = User::getUser();
        
        if($this->isSinglePlayerTeam == 0){
            $rel = Doo::db()->getOne('EsTeamMembersRel', array(
                            'where' =>  "FK_PLAYER = {$p->ID_TEAM} AND FK_TEAM = {$this->ID_TEAM} AND isPending = 0"
            ));
                            
            if(empty($rel))
                $this->viewed();
        }
        else{
            if($p->ID_TEAM != $this->ID_TEAM)
                $this->viewed();
        }
    }
    
    public function getLeagueData(){
                $esport = new Esport();
                
		$games = $esport->GetGamesByTeam($this->ID_TEAM);
		$leagues = $esport->GetLadderLeagues();
                
                //Games rating
                $allRatings = $this->isSinglePlayerTeam == 0 ? $esport->GetAllTeamRatings() : $esport->GetAllRatings();
               
		//My rating
		$myRating = $esport->GetTotalRating($this->ID_TEAM,$allRatings);

		//Show by game
		$selectedLeague = $esport->GetLeagueIndexByRating($myRating);
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
                $totalWins = 0;
                foreach($allRatings as $rating){              
                    if($rating['TotalRating'] > $tierMin && $rating['TotalRating'] < $tierMax){
                        if($rating['ID_TEAM'] == $this->ID_TEAM){
                            $myposition = $count;
                            $totalWins = $rating['TotalWins'];
                        }
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
                
                $gamerank = $esport->GetHighestAchievedLeagueInGames($games, $this->ID_TEAM);
                
                $this->Tier = $selectedTier;
                $this->Rank = $myposition;
                $this->Fans = $esport->getTotalLikes($this->ID_TEAM);
                $this->Division = $gamerank['ladderLeague'];
                $this->TotalWins = $totalWins;
                $this->LeagueRankings = $leagueranking;
    }
}
?>