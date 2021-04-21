<?php

Doo::loadCore('db/DooSmartModel');

class SyChannels extends DooSmartModel {
    
    public $ID_CHANNEL;
    public $ChannelName;
    public $ChannelDesc;
    public $TwitchName;
    public $ImageURL;
    public $FeatureChannel;
    public $TotalViews;
    
    public $isFavorite;
    
    public $GameName;
    public $Logo;
    public $Viewers;
    public $Title;
    public $Screenshot;
                
    public $_table = 'sy_channels';
    public $_primarykey = 'ID_CHANNEL'; 
    public $_fields = array(
		'ID_CHANNEL',
                'ChannelName',
                'ChannelDesc',
                'TwitchName',
                'ImageURL',
                'FeatureChannel',
                'TotalViews',
	);
    
    public function isLive(){
        try{
            $json_file = file_get_contents("http://api.justin.tv/api/stream/list.json?channel=$this->TwitchName", 0, null, null);
            $json_array = json_decode($json_file, true);
        }
        catch (Exception $e){ return false; }
         
        if (isset($json_array) && !empty($json_array)){
            
            $this->Screenshot = $json_array[0]['channel']['screen_cap_url_large'];
            $this->GameName = $json_array[0]['channel']['meta_game'];
            $this->ImageURL = $json_array[0]['channel']['image_url_small'];
            $this->Viewers = $json_array[0]['channel_count'];
            $this->TotalViews = $json_array[0]['channel_view_count'];
            $this->Title = $json_array[0]['title'];
            $this->update();
            
            return true;
        }
        else return false;
    }
    
    public function isFavorite(){
        if(Auth::isUserLogged()){
            $p = User::getUser()->ID_PLAYER;

            $favorite = Doo::db()->getOne('SyPlayerChannelRel',array(
                            'where' =>  "FK_CHANNEL = {$this->ID_CHANNEL} AND FK_PLAYER = {$p}"
                        ));

            if(!empty($favorite) && isset($favorite)){
                $this->isFavorite = true;
                return true;
            }
            else{
                $this->isFavorite = false;
                return false;
            }
        }
        else return false;
    }
}
?>
