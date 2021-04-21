<?php

Doo::loadCore('db/DooSmartModel');

class EsLobbynotifications extends DooSmartModel {
    
    public $ID_LOBBYNOTE;
    public $Reciever;
    public $Sender;
    public $MessageType;
    public $New;
    public $FK_QUICKMATCH;
    public $Responded;
    
    public $_table = 'es_lobbynotifications';
    public $_primarykey = 'ID_LOBBYNOTE'; 
    public $_fields = array(
                'ID_LOBBYNOTE',
                'Reciever',
                'Sender',
                'MessageType',
                'New',
                'FK_QUICKMATCH',
                'Responded',
	);
    
    public function Read(){
        $this->New = 0;
        $this->update();
    }
    
    public function Responded(){
        $this->Responded = 1;
        $this->update();
    }
    
    public function getSenderName(){
        $esport = new Esport();
        
        $p = $esport->GetPlayerByTeam($this->Sender);
        return $p->DisplayName;
    }
}
?>