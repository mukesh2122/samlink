<?php
class Ventrilo{
    private $apiUsername = 'playnation';
	private $apiKey = 'B5D5369F-3621EFA7-6AF97F5F-B75C85EE-9A28617A';
    
    private $ventriloClient;
    
    private $wsdlVentrilo='https://api.light-speed.com/rsapi/ventrilo/1.1/?wsdl';
    private $nameSpaceVentrilo = 'urn:lightspeed:api:rsapi:ventrilo';
    
    function start(){
        try{
            $this->ventriloClient = new SoapClient($this->wsdlVentrilo, array(
                'cache_wsdl'    => WSDL_CACHE_NONE,
                'soap_version'	=> SOAP_1_2,
                'features'	    => SOAP_SINGLE_ELEMENT_ARRAYS,
                'trace'         => TRUE
            ));
        
            $header = new SoapHeader($this->nameSpaceVentrilo,"RequestCredentials",new SoapVar(array(
                'username'	=> $this->apiUsername,
                'apiKey'	=> $this->apiKey,
                ),SOAP_ENC_OBJECT
            ));

            $this->ventriloClient->__setSoapHeaders(array( $header ));
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
            'serverAdminPassword'   =>  'playnation',
            'serverName'            =>  'Playnation',
            'slots'                 =>  '20',
            'serviceRef'            =>  ''        
        ));  
    }
    
    function serviceCreate($params){
        try{
            $tempCall = $this->ventriloClient->serviceCreate(array(
                'clientId'              =>  $params['clientId'],
                'locationId'            =>  $params['locationId'],
                'ipPort'                =>  $params['ipPort'],
                'serverAdminPassword'   =>  $params['serverAdminPassword'],
                'serverName'            =>  $params['serverName'],
                'slots'                 =>  $params['slots'],
                'serviceRef'            =>  $params['serviceRef']  
            ));
            $result = array(
                'serviceId'     =>  $tempCall->serviceId,
                'ipAddress'     =>  $tempCall->ipAddress,
                'ipPort'        =>  $tempCall->ipPort,
                'hostname'      =>  $tempCall->hostname,
                'serviceRef'    =>  $tempCall->serviceRef
            );
            return $result;
        }
        catch(exception $e){
            return $e->getMessage();
        }        
    }
        
    function serviceControl($params){
        try{
            $result = $this->ventriloClient->serviceControl(array(
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
            $result = $this->ventriloClient->serviceRemove(array(
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
            $tempCall = $this->ventriloClient->serviceInformation(array(
                'serviceId'     =>  $params['serviceId']
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
                'queryAddress'      =>  $tempCall->queryAddress,
                'queryPort'         =>  $tempCall->queryPort,
                'machineId'         =>  $tempCall->machineId,
                'machineHostname'   =>  $tempCall->machineHostname,
                'locationId'        =>  $tempCall->locationId,
                'hostname'          =>  $tempCall->hostname,
                'properties'        =>  $tempCall->properties,                      //TODO handle servicePropertiesType collection
                'serviceRef'        =>  $tempCall->serviceRef 
            );
            return $result;
        }
        catch(exception $e){
            return $e->getMessage();
        }
    } 
    
    function serviceCheckPort($params){
        try{
            $result = $this->ventriloClient->serviceCheckPort(array(
                'locationId'    =>  $params['locationId'],
                'ipPort'        =>  $params['ipPort'],
                'serviceId'     =>  $params['serviceId'],
                'ipSelection'   =>  $params['ipSelection']          //TODO must handle type
            ));
        }
        catch(exception $e){
            return $e->getMessage();
        }
        return true;    //This function returns TRUE if the action was successful or throws an SoapFault if it failed.    
    }
     
    function serviceMove($params){
        try{
            $tempCall = $this->ventriloClient->serviceMove(array(
                'serviceId'     =>  $params['serviceId'],
                'locationId'    =>  $params['locationId'],
                'ipPort'        =>  $params['ipPort'],
                'ipSelection'   =>  $params['ipSelection']          //TODO must handle type
            ));
            $result = array(
                'ipAddress'     =>  $tempCall->ipAddress,
                'ipPort'        =>  $tempCall->ipPort         
            );
            return $result;
        }
        catch(exception $e){
            return $e->getMessage();
        }    
    } 
    
    function serviceSearch($params){
        try{
            $tempCall = $this->ventriloClient->serviceSearch(array(
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
            $tempCall = $this->ventriloClient->configLoad(array(
                'serviceId'         =>  $params['serviceId'],                          
                'showFileUSR'       =>  $params['showFileUSR'],
                'showFileCHN'       =>  $params['showFileCHN'],
                'showFileRANK'      =>  $params['showFileRANK'],
                'showFileBAN'       =>  $params['showFileBAN'],
                'showFileMOTD'      =>  $params['showFileMOTD'],
                'showFileGMOTD'     =>  $params['showFileGMOTD'],
                'showFileTRGVOICE'  =>  $params['showFileTRGVOICE'],
                'showFileTRGCMD'    =>  $params['showFileTRGCMD']
            ));
            $result = array(
                'test' =>   $tempCall->result                   //TODO returns base64binary, must handle properly    
            );
            return $result;
        }
        catch(exception $e){
            return $e->getMessage();
        }              
    }
     
    function configSave($params){
        try{
            $result = $this->ventriloClient->configSave(array(
                'temp'    =>  $params['temp']                       //TODO takes base64binary as param, must handle properly
            ));
        }
        catch(exception $e){
            return $e->getMessage();
        }
        return true;    //This function returns TRUE if the action was successful or throws an SoapFault if it failed.         
    }
     
    function configUpdateSlotCount($params){
        try{
            $result = $this->ventriloClient->configUpdateSlotCount(array(
                'serviceId' =>  $params['serviceId'],
                'slots'     =>  $params['slots']                       
            ));
        }
        catch(exception $e){
            return $e->getMessage();
        }
        return true;    //This function returns TRUE if the action was successful or throws an SoapFault if it failed.         
    }
     
    function ttsSend($params){
        try{
            $result = $this->ventriloClient->ttsSend(array(
                'serviceId' =>  $params['serviceId'],
                'message'   =>  $params['message']                       
            ));
        }
        catch(exception $e){
            return $e->getMessage();
        }
        return true;    //This function returns TRUE if the action was successful or throws an SoapFault if it failed.        
    }
      
    function connectedUserList($params){
        try{
            $tempCall = $this->ventriloClient->connectedUserList(array(
                'serviceId'    =>  $params['serviceId']
            ));
            $result = array(
                'serverVersion'     =>  $tempCall->serverVersion,                     
                'connectedUsers'    =>  $tempCall->connectedUsers   //TODO returns ArrayOfConnectedUsersInfo, must handle properly      
            );
            return $result;
        }
        catch(exception $e){
            return $e->getMessage();
        }     
    } 
    
    function connectedUserKick($params){
        try{
            $result = $this->ventriloClient->connectedUserKick(array(
                'serviceId' =>  $params['serviceId'],
                'clientId'  =>  $params['clientId']                       
            ));
        }
        catch(exception $e){
            return $e->getMessage();
        }
        return true;    //This function returns TRUE if the action was successful or throws an SoapFault if it failed.        
    }
     
    function banList($params){
        try{
            $tempCall = $this->ventriloClient->banList(array(
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
            $result = $this->ventriloClient->banAdd(array(
                'serviceId' =>  $params['serviceId'],
                'mask'      =>  $params['mask'],
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
            $result = $this->ventriloClient->banDel(array(
                'serviceId' =>  $params['serviceId'],
                'mask'      =>  $params['mask'],                 
            ));
        }
        catch(exception $e){
            return $e->getMessage();
        }
        return true;    //This function returns TRUE if the action was successful or throws an SoapFault if it failed.     
    }
    
    function logLoad($params){
        try{
            $tempCall = $this->ventriloClient->logLoad(array(
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
    
    function backupList($params){
        try{
            $tempCall = $this->ventriloClient->backupList(array(
                'serviceId'    =>  $params['serviceId'],
                'type'         =>  $params['type'],                 //TODO tk_backup_type must handle properly         
                'date'         =>  $params['date']
            ));
            $result = array(                    
                'numResults' => $tempCall->numResults,
                'results'    => $tempCall->results                  //TODO  bk_backupInfo type, must handle properly       
            );
            return $result;
        }
        catch(exception $e){
            return $e->getMessage();
        }        
    }
    
    function backupRestore($params){
        try{
            $result = $this->ventriloClient->backupRestore(array(
                'serviceId' =>  $params['serviceId'],
                'type'      =>  $params['type'],                   //TODO bk_backupType must handle properly               
                'entry'     =>  $params['entry']                 
            ));
        }
        catch(exception $e){
            return $e->getMessage();
        }
        return true;    //This function returns TRUE if the action was successful or throws an SoapFault if it failed.            
    }
    
    function serviceUpdate($params){
        try{
            $result = $this->ventriloClient->serviceUpdate(array(
                'serviceId'     =>  $params['serviceId'],
                'clientId'      =>  $params['clientId'],                               
                'serviceRef'    =>  $params['serviceRef']                 
            ));
        }
        catch(exception $e){
            return $e->getMessage();
        }
        return true;    //This function returns TRUE if the action was successful or throws an SoapFault if it failed.  
    }
}
?>