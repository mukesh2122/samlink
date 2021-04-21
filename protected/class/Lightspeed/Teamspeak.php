<?php
class Teamspeak{
    private $apiUsername = 'playnation';
	private $apiKey = 'B5D5369F-3621EFA7-6AF97F5F-B75C85EE-9A28617A';
    
    private $teamSpeakClient;
    
    private $wsdlTeamSpeak = 'https://api.light-speed.com/rsapi/teamspeak3/1.0/?wsdl';
    private $nameSpaceTeamSpeak = 'urn:lightspeed:api:rsapi:teamspeak3';
    
    function start(){
        try{
            $this->teamSpeakClient = new SoapClient($this->wsdlTeamSpeak, array(
                'cache_wsdl'    => WSDL_CACHE_NONE,
                'soap_version'	=> SOAP_1_2,
                'features'	    => SOAP_SINGLE_ELEMENT_ARRAYS,
                'trace'         => TRUE
            ));
        
            $header = new SoapHeader($this->nameSpaceTeamSpeak,"RequestCredentials",new SoapVar(array(
                'username'	=> $this->apiUsername,
                'apiKey'	=> $this->apiKey,
                ),SOAP_ENC_OBJECT
            ));

            $this->teamSpeakClient->__setSoapHeaders(array( $header ));
        }
        catch(exception $e){
            return $e->getMessage();    
        }
    }
    
    function handleOrder($clientId){
        
        $this->start();
        $result = $this->serviceCreate(array(
            'clientId'              =>  $clientId,
            'locationId'            =>  '38',
            'ipPort'                =>  '0',
            'serverName'            =>  'Playnation',
            'slots'                 =>  '20',
            'serviceRef'            =>  ''        
        ));  
    }
    
    function serviceCreate($params){
        try{
            $tempCall = $this->teamSpeakClient->serviceCreate(array(
                'clientId'              =>  $params['clientId'],
                'locationId'            =>  $params['locationId'],
                'ipPort'                =>  $params['ipPort'],
                'serverName'            =>  $params['serverName'],
                'slots'                 =>  $params['slots'],
                'serviceRef'            =>  $params['serviceRef']  
            ));
            $result = array(
                'serviceId'     =>  $tempCall->serviceId,
                'ipAddress'     =>  $tempCall->ipAddress,
                'ipPort'        =>  $tempCall->ipPort,
                'queryAddress'  =>  $tempCall->queryAddress,
                'queryPort'     =>  $tempCall->queryPort,
                'hostname'      =>  $tempCall->hostname,
                'privilegeKey'  =>  $tempCall->privilegeKey
            );
            return $result;
        }
        catch(exception $e){
            return $e->getMessage();
        }    
    }
     
    function serviceControl($params){
        try{
            $result = $this->teamSpeakClient->serviceControl(array(
                'serviceId'     =>  $params['serviceId'],
                'action'        =>  $params['action']
            ));
        }
        catch(exception $e){
            return $e->getMessage();
        }
        return true;    //This function returns TRUE if the action was successful or throws an SoapFault if it failed.     
    }
     
    function serviceRemove($params){
        try{
            $result = $this->teamSpeakClient->serviceRemove(array(
                'serviceId'     =>  $params['serviceId']
            ));
        }
        catch(exception $e){
            return $e->getMessage();
        }
        return true;    //This function returns TRUE if the action was successful or throws an SoapFault if it failed.     
    }
     
    function serviceInformation($params){
        try{
            $tempCall = $this->teamSpeakClient->serviceInformation(array(
                'serviceId'              =>  $params['serviceId']  
            ));
            $result = array(
                'serviceId'         =>  $tempCall->serviceId,
                'clientId'          =>  $tempCall->clientId,
                'adminStatus'       =>  $tempCall->adminStatus,
                'serverStatus'      =>  $tempCall->serverStatus,
                'slots'             =>  $tempCall->slots,
                'serverName'        =>  $tempCall->serverName,
                'privilegeKey'      =>  $tempCall->privilegeKey,
                'ipAddress'         =>  $tempCall->ipAddress,
                'ipPort'            =>  $tempCall->ipPort,
                'machineId'         =>  $tempCall->machineId,
                'machineHostname'   =>  $tempCall->machineHostname,
                'locationId'        =>  $tempCall->locationId,
                'hostname'          =>  $tempCall->hostname,
                'properties'        =>  $tempCall->properties,                  //TODO service properties type, must handle
                'serviceRef'        =>  $tempCall->serviceRef
                
            );
            return $result;
        }
        catch(exception $e){
            return $e->getMessage();
        }        
    }
    
    function serviceSearch($params){
        try{
            $tempCall = $this->teamSpeakClient->serviceSearch(array(
                'filter'    =>  $params['filter'],                          //TODO takes array as param, must fix
                'offset'    =>  $params['offset'],
                'limit'     =>  $params['limit']
            ));
            $result = array(
                'results'       =>  $tempCall->results,                     //TODO returns array, must fix
                'numResults'    =>  $tempCall->numResults,
                'totalResults'  =>  $tempCall->totalResults       
            );
            return $result;
        }
        catch(exception $e){
            return $e->getMessage();
        }        
    }
     
    function configLoad($params){
        try{
            $tempCall = $this->teamSpeakClient->configLoad(array(
                'serviceId'    =>  $params['serviceId'],                          
            ));
            $result = array(
                'config'       =>  $tempCall->config,                     //TODO returns array, must fix   
            );
            return $result;
        }
        catch(exception $e){
            return $e->getMessage();
        }        
    }
     
    function configSave($params){
        try{
            $result = $this->teamSpeakClient->configSave(array(
                'config'     =>  $params['config']                      //TODO takes array as param, must fix
            ));
        }
        catch(exception $e){
            return $e->getMessage();
        }
        return true;    //This function returns TRUE if the action was successful or throws an SoapFault if it failed.      
    }
     
    function configUpdateSlotCount($params){
        try{
            $result = $this->teamSpeakClient->configUpdateSlotCount(array(
                'serviceId'     =>  $params['serviceId'],
                'slots'         =>  $params['slots']                      
            ));
        }
        catch(exception $e){
            return $e->getMessage();
        }
        return true;    //This function returns TRUE if the action was successful or throws an SoapFault if it failed.    
    }
     
    function messageSend($params){
        try{
            $result = $this->teamSpeakClient->messageSend(array(
                'serviceId'     =>  $params['serviceId'],
                'message'       =>  $params['message']                      
            ));
        }
        catch(exception $e){
            return $e->getMessage();
        }
        return true;    //This function returns TRUE if the action was successful or throws an SoapFault if it failed.     
    }
     
    function banList($params){
        try{
            $tempCall = $this->teamSpeakClient->banList(array(
                'serviceId'    =>  $params['serviceId']
            ));
            $result = array(                    
                'bans'    =>  $tempCall->bans   //TODO returns ArrayOfbanInfo, must handle properly      
            );
            return $result;
        }
        catch(exception $e){
            return $e->getMessage();
        }     
    }
     
    function banAdd($params){
        try{
            $result = $this->teamSpeakClient->banAdd(array(
                'serviceId' =>  $params['serviceId'],
                'banip'     =>  $params['banip'],
                'time'      =>  $params['time'],
                'reason'    =>  $params['reason']                   
            ));
        }
        catch(exception $e){
            return $e->getMessage();
        }
        return true;    //This function returns TRUE if the action was successful or throws an SoapFault if it failed.        
    }
     
    function banDel($params){
        try{
            $result = $this->teamSpeakClient->banDel(array(
                'serviceId' =>  $params['serviceId'],
                'banId'     =>  $params['banId'],                 
            ));
        }
        catch(exception $e){
            return $e->getMessage();
        }
        return true;    //This function returns TRUE if the action was successful or throws an SoapFault if it failed.         
    }
     
    function logLoad($params){
        try{
            $tempCall = $this->teamSpeakClient->logLoad(array(
                'serviceId'    =>  $params['serviceId']
            ));
            $result = array(                    
                'data'          => $tempCall->data,
                'dataLength'    => $tempCall->dataLength       
            );
            return $result;
        }
        catch(exception $e){
            return $e->getMessage();
        }       
    }     
}
?>