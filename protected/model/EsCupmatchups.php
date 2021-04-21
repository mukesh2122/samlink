<?php
Doo::loadCore('db/DooSmartModel');

class EsCupmatchups extends DooSmartModel{

	public $ID_MATCHUP;
	public $Round;
	public $IsPrimaryTree;
	public $FK_PARTICIPANT1;
	public $FK_PARTICIPANT2;
	public $RoundWinsP1;
	public $RoundWinsP2;
	public $SeedP1;
	public $SeedP2;
	public $RoundIndex;
	public $FK_MATCH;

	public $_table = 'es_cupmatchups';
	public $_primarykey = 'ID_MATCHUP';
	public $_fields = array(
                'ID_MATCHUP',
                'Round',
                'IsPrimaryTree',
                'FK_PARTICIPANT1',
                'FK_PARTICIPANT2',
                'RoundWinsP1',
                'RoundWinsP2',
                'SeedP1',
                'SeedP2',
                'RoundIndex',
                'FK_MATCH',
         );
        
        public function getP1Name(){
            if($this->FK_PARTICIPANT1){
                $esport = new Esport();
                $team = $esport->GetTeamByID($this->FK_PARTICIPANT1);
                return $team->DisplayName;
            }
        }

        public function getP2Name(){
            if($this->FK_PARTICIPANT2){
                $esport = new Esport();
                $team = $esport->GetTeamByID($this->FK_PARTICIPANT2);
                return $team->DisplayName;
            }
        }
}
?>
