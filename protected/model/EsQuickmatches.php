<?php

Doo::loadCore('db/DooSmartModel');

class EsQuickmatches extends DooSmartModel {
    
    public $ID_QUICKMATCH;
    public $FK_GAME;
    public $Challenger;
    public $Opponent;
    public $MatchState;
    public $PlayMode;
    public $BetSize;
    public $ChallengerRatingBefore;
    public $OpponentRatingBefore;
    
    public $_table = 'es_quickmatches';
    public $_primarykey = 'ID_QUICKMATCH'; 
    public $_fields = array(
                'ID_QUICKMATCH',
                'FK_GAME',
                'Challenger',
                'Opponent',
                'MatchState',
                'PlayMode',
                'BetSize',
                'ChallengerRatingBefore',
                'OpponentRatingBefore'
	);
}
?>