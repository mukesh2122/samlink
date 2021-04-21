<?php

Doo::loadCore('db/DooSmartModel');

class EsLeagues extends DooSmartModel {
    
    public $ID_LEAGUE;
    public $FK_GAME;
    public $FK_RULE;
    public $FK_REGION;
    public $TournamentType;
    public $CupType;
    public $LeagueName;
    public $LowerRankingRestrictionRange;
    public $UpperRankingRestrictionRange;
    public $LeagueSize;
    public $CustomPrizeLevelValue;
    public $DefaultPrizeLevelValue;
    public $InactivityDropTime;
    public $TimeZone;
    public $StartTime;
    public $EndTime;
    public $SignupDeadline;
    public $PlayMode;
    public $Format;
    public $BestOfMatchCount;
    public $LooserPicksMap;
    public $PlayThirdPlaceMatch;
    public $AccessType;
    public $isDone;
    public $isActive;
    public $RequireTeamMembers;
    public $Season;
    public $isGlobal;
    public $ReplayUploads;
    public $ReplayDownloads;
    public $Image;
    public $Host;
    public $LeagueDesc;
    public $EntryFee;
    public $BetType;
    public $Amount;
    public $Rake;
    public $RankedStatus;
    public $ServerDetails;
    
    public $MatchState;
    
    
    public $_table = 'es_leagues';
    public $_primarykey = 'ID_LEAGUE'; 
    public $_fields = array(
                'ID_LEAGUE',
                'FK_GAME',
                'FK_RULE',
                'FK_REGION',
                'TournamentType',
                'CupType',
                'LeagueName',
                'LowerRankingRestrictionRange',
                'UpperRankingRestrictionRange',
                'LeagueSize',
                'CustomPrizeLevelValue',
                'DefaultPrizeLevelValue',
                'InactivityDropTime',
                'TimeZone',
                'StartTime',
                'EndTime',
                'SignupDeadline',
                'PlayMode',
                'Format',
                'BestOfMatchCount',
                'LooserPicksMap',
                'PlayThirdPlaceMatch',
                'AccessType',
                'isDone',
                'isActive',
                'RequireTeamMembers',
                'Season',
                'isGlobal',
                'ReplayUploads',
                'ReplayDownloads',
                'Image',
                'Host',
                'LeagueDesc',
                'EntryFee',
                'BetType',
                'Account',
                'Rake',
                'RankedStatus',
                'ServerDetails',
	);
}
?>