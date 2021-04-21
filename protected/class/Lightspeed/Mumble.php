<?php
class Mumble{
    private $apiUsername = 'playnation';
	private $apiKey = 'B5D5369F-3621EFA7-6AF97F5F-B75C85EE-9A28617A';
    
    private $mumbleClient;
    
    private $wsdlMumble = 'https://api.light-speed.com/rsapi/mumble/1.1/?wsdl';
	private $nameSpaceMumble = 'urn:lightspeed:api:rsapi:mumble'; 
    
    function start(){
        try{
            $this->mumbleClient = new SoapClient($this->wsdlMumble, array(
                'cache_wsdl'    => WSDL_CACHE_NONE,
                'soap_version'	=> SOAP_1_2,
                'features'	    => SOAP_SINGLE_ELEMENT_ARRAYS,
                'trace'         => TRUE
            ));
        
            $header = new SoapHeader($this->nameSpaceMumble,"RequestCredentials",new SoapVar(array(
                'username'	=> $this->apiUsername,
                'apiKey'	=> $this->apiKey,
                ),SOAP_ENC_OBJECT
            ));

            $this->mumbleClient->__setSoapHeaders(array( $header ));
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
            'slots'                 =>  '20'
        ));  
    }
    
    function serviceCreate($params){
        try{
            $tempCall = $this->mumbleClient->serviceCreate(array(
                'clientId'              =>  $params['clientId'],
                'locationId'            =>  $params['locationId'],
                'ipPort'                =>  $params['ipPort'],
                'serverAdminPassword'   =>  $params['serverAdminPassword'],
                'serverName'            =>  $params['serverName'],
                'slots'                 =>  $params['slots'] 
            ));
            $result = array(
                'serviceId'     =>  $tempCall->serviceId,
                'ipAddress'     =>  $tempCall->ipAddress,
                'ipPort'        =>  $tempCall->ipPort,
                'hostname'      =>  $tempCall->hostname
            );
            return $result;
        }
        catch(exception $e){
            return $e->getMessage();
        }     
    }
     
    function serviceInformation($params){
        try{
            $tempCall = $this->mumbleClient->serviceInformation(array(
                'serviceId'     =>  $params['serviceId']
            ));
            $result = array(
                'serviceId'             =>  $tempCall->serviceId,
                'clientId'              =>  $tempCall->clientId,
                'adminStatus'           =>  $tempCall->adminStatus,
                'serverStatus'          =>  $tempCall->serverStatus,
                'slots'                 =>  $tempCall->slots,
                'serverName'            =>  $tempCall->serverName,
                'serverAdminPassword'   =>  $tempCall->severAdminPassword,
                'ipAddress'             =>  $tempCall->ipAddress,
                'ipPort'                =>  $tempCall->ipPort,
                'machineId'             =>  $tempCall->machineId,
                'machineHostname'       =>  $tempCall->machineHostname,
                'locationId'            =>  $tempCall->locationId,
                'hostname'              =>  $tempCall->hostname,
                'properties'            =>  $tempCall->properties,                      //TODO handle servicePropertiesType collection

            );
            return $result;
        }
        catch(exception $e){
            return $e->getMessage();
        }    
    }
    
    function serviceUpdate($params){
        try{
            $result = $this->mumbleClient->serviceUpdate(array(
                'serviceId'     =>  $params['serviceId'],
                'clientId'      =>  $params['clientId']
            ));
        }
        catch(exception $e){
            return $e->getMessage();
        }
        return true;    //This function returns TRUE if the action was successful or throws an SoapFault if it failed.         
    }
     
    function serviceRemove($params){
        try{
            $result = $this->mumbleClient->serviceRemove(array(
                'serviceId'     =>  $params['serviceId']
            ));
        }
        catch(exception $e){
            return $e->getMessage();
        }
        return true;    //This function returns TRUE if the action was successful or throws an SoapFault if it failed.     
    }
     
    function serviceControl($params){
        try{
            $result = $this->mumbleClient->serviceControl(array(
                'serviceId'     =>  $params['serviceId'],
                'action'        =>  $params['action']
            ));
        }
        catch(exception $e){
            return $e->getMessage();
        }
        return true;    //This function returns TRUE if the action was successful or throws an SoapFault if it failed.     
    }
     
    function serviceCheckPort($params){
        try{
            $result = $this->mumbleClient->serviceCheckPort(array(
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
            $tempCall = $this->mumbleClient->configLoad(array(
                'serviceId' =>  $params['serviceId']                          
            ));
            $result = array(
                'config' =>   $tempCall->config                   //TODO returns ArrayOfKeyValuePair, must handle properly    
            );
            return $result;
        }
        catch(exception $e){
            return $e->getMessage();
        }    
    }
     
    function configSave($params){
        try{
            $result = $this->mumbleClient->configSave(array(
                'config'    =>  $params['config']               //TODO must send    ArrayOfKeyValuePair type
            ));
        }
        catch(exception $e){
            return $e->getMessage();
        }
        return true;    //This function returns TRUE if the action was successful or throws an SoapFault if it failed.      
    }
     
    function configUpdateSlotCount($params){
        try{
            $result = $this->mumbleClient->configUpdateSlotCount(array(
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
            $result = $this->mumbleClient->ttsSend(array(
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
            $tempCall = $this->mumbleClient->connectedUserList(array(
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
            $result = $this->mumbleClient->connectedUserKick(array(
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
            $tempCall = $this->mumbleClient->banList(array(
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
            $result = $this->mumbleClient->banAdd(array(
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
            $result = $this->mumbleClient->banDel(array(
                'serviceId' =>  $params['serviceId'],
                'mask'      =>  $params['mask']                       
            ));
        }
        catch(exception $e){
            return $e->getMessage();
        }
        return true;    //This function returns TRUE if the action was successful or throws an SoapFault if it failed.    
    }
     
    function logLoad($params){
        try{
            $tempCall = $this->mumbleClient->logLoad(array(
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