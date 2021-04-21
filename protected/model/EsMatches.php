<?php

Doo::loadCore('db/DooSmartModel');

class EsMatches extends DooSmartModel {
    
    public $ID_MATCH;
    public $FK_CUP;
    public $FK_LEAGUE;
    public $MatchWinnerID;
    public $MatchLoserID;
    public $Score;
    public $StartTime;
    public $ReportedResultTime;
    public $MatchClosedTime;
    public $RoundPlayedIn;
    public $ChallengerID;
    public $ChallengerRatingBefore;
    public $OpponentID;
    public $OpponentRatingBefore;
    public $State;
    public $RequiredTeamMembers;
    public $BetSize;
    public $PlayMode;
    public $RoundPlacement;
    public $ChallengerReportedScore;
    public $ChallengerScreenshot;
    public $OpponentReportedScore;
    public $OpponentScreenshot;
    public $DisputeCount;
    
    //Set for switching between screenshots: (challenger = ChallengerScreenshot, opponent = OpponentScreenshot)
    public $ImageType = 'challenger';
    
    //Leagueinfo
    public $FK_GAME;
    public $RankedStatus;
    public $Host;
    public $ServerDetails;
    
    public $_table = 'es_matches';
    public $_primarykey = 'ID_MATCH'; 
    public $_fields = array(
                 'ID_MATCH',
                 'FK_CUP',
                 'FK_LEAGUE',
                 'MatchWinnerID',
                 'MatchLoserID',
                 'Score',
                 'StartTime',
                 'ReportedResultTime',
                 'MatchClosedTime',
                 'RoundPlayedIn',
                 'ChallengerID',
                 'ChallengerRatingBefore',
                 'OpponentID',
                 'OpponentRatingBefore',
                 'State',
                 'RequiredTeamMembers',
                 'BetSize',
                 'PlayMode',
                 'RoundPlacement',
                 'ChallengerReportedScore',
                 'ChallengerScreenshot',
                 'OpponentReportedScore',
                 'OpponentScreenshot',
                 'DisputeCount',
	);
    
    public function hasReported($ID_TEAM = 0){
        $id = $ID_TEAM == 0 ? User::getUser()->ID_TEAM : $ID_TEAM;
        $status = false;
        
        if($id == $this->ChallengerID){
            $status = !empty($this->ChallengerReportedScore) && $this->ChallengerReportedScore != 0 ? true : false;
        }
        else if($id == $this->OpponentID){
            $status = !empty($this->OpponentReportedScore) && $this->OpponentReportedScore != 0 ? true : false;
        }
        
        return $status;
    }
    
    public function getGameName(){
        
        $game = Doo::db()->getOne('SnGames', array(
            'where' =>  "ID_GAME = {$this->FK_GAME}"
        ));
        
        return $game->GameName;
    }
    
    public function getPlayersResult($ID_TEAM = 0){
        $id = $ID_TEAM == 0 ? User::getUser()->ID_TEAM : $ID_TEAM;
        
        if($this->ChallengerID == $id || $this->OpponentID == $id){
            if($this->MatchWinnerID == $id){
                return 'won';
            }
            else if($this->MatchLoserID == $id){
                return 'loss';
            }
            else{
                return 'draw';
            }
        }
        
        return 'undefined';
    }
    
    public function getOpponent($ID_TEAM = 0){
        $id = $ID_TEAM == 0 ? User::getUser()->ID_TEAM : $ID_TEAM;
        $opponent = 0;
        if($this->ChallengerID == $id && $this->OpponentID != 0)
            $opponent = $this->OpponentID;
        else if($this->OpponentID == $id && $this->ChallengerID != 0)
            $opponent = $this->ChallengerID;
        else return false;
        
        return Esport::getTeamByID($opponent); 
    }
}
?>