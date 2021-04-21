<?php
class Reseller{
	private $apiUsername = 'playnation';
	private $apiKey = 'B5D5369F-3621EFA7-6AF97F5F-B75C85EE-9A28617A';
    
    private $resellerClient;

    private $wsdlReseller = 'https://api.light-speed.com/rsapi/1.1/?wsdl';
	private $nameSpaceReseller = 'urn:lightspeed:api:rsapi'; 
    
    /**
     * Reseller::start()
     * Must always be run before calling any other function in the class
     */
    function start(){
        try{
            $this->resellerClient = new SoapClient($this->wsdlReseller, array(
                'cache_wsdl'    => WSDL_CACHE_NONE,
                'soap_version'	=> SOAP_1_2,
                'features'	    => SOAP_SINGLE_ELEMENT_ARRAYS,
                'trace'         => TRUE
            ));
        
            $header = new SoapHeader($this->nameSpaceReseller,"RequestCredentials",new SoapVar(array(
                'username'	=> $this->apiUsername,
                'apiKey'	=> $this->apiKey,
                ),SOAP_ENC_OBJECT
            ));

            $this->resellerClient->__setSoapHeaders(array( $header ));
        }
        catch(exception $e){
            echo($e->getMessage());
            throw($e);     
        }
    }
    
    function handleOrder($itemId , $playerNickname, $playerEmail){
        
        $this->start();
        if($this->clientUsernameIsAvailable($playerNickname)){
            $clientId = $this->clientCreate(array(
                'username'  =>  $playerNickname,   
                'password'  =>  'playnation',    
                'clientRef' =>  '', 
                'name'      =>  $playerNickname,       
                'email'     =>  $playerEmail
            ));
        }else{
            $clientId = $this->clientSearch($playerNickname);
        }    

        //ItemId-s subject to change
        if($itemId=='4'||$itemId=='5'||$itemId=='6'||$itemId=='7'){
            $mumble = new Mumble();
            $mumble->handleOrder($clientId);
        } else if($itemId=='8'||$itemId=='9'||$itemId=='10'){
            $ventrilo = new Ventrilo();
            $ventrilo->handleOrder($clientId);
        } else if($itemId=='11'||$itemId=='12'||$itemId=='13'||$itemId=='14'){
            $teamspeak = new Teamspeak();
            $teamspeak->handleOrder($clientId);
        }    
    }
    
    function getBalance(){
        try{
            $result = $this->resellerClient->getBalance();
            return $result->balance;
        }
        catch(exception $e){
            echo($e->getMessage());
            throw($e); 
        }
    }
    
    function clientCreate($params){
        try{
            echo($params['username']);
            $result = $this->resellerClient->clientCreate(array(
                'username'  =>  $params['username'],    //mandatory
                'password'  =>  $params['password'],    //mandatory
                'clientRef' =>  $params['clientRef'],   //client reference ID(optional)
                'name'      =>  $params['name'],        //customer real name(optional)
                'email'     =>  $params['email']        //email(optional)       
            ));
            $clientID = $result->clientId;
            return $clientID;    
        }
        catch(exception $e){
            echo($e->getMessage());
            throw($e); 
        }
    }
    
    function clientGetAuthToken($params){
        try{
            $tempCall = $this->resellerClient->clientGetAuthToken(array(
                'clientId'  => $params['clientId']  //mandatory
            ));
            $result = array(
                'url'           =>  $tempCall->url,
                'validUntil'    =>  $tempCall->validUntil   
            );
            return $result;
        }
        catch(exception $e){
            echo($e->getMessage());
            throw($e); 
        }
    }
    
    function clientUpdate($params){
        try{
            $result = $this->resellerClient->clientUpdate(array(
                'clientId'  =>  $params['clientId'],    //mandatory
                'username'  =>  $params['username'],    //optional
                'password'  =>  $params['password'],    //optional
                'clientRef' =>  $params['clientRef']    //optional
            ));
        }
        catch(exception $e){
            echo($e->getMessage());
            throw($e); 
        }
        return true;    //This function returns TRUE if the username is available or throws a Fault if invalid or unavailable.
    }
    
    function clientUsernameIsAvailable($playerNickname){
        try{
            $result = $this->resellerClient->clientUsernameIsAvailable(array(
                'username'  =>  $playerNickname
            ));
        }
        catch(exception $e){
            echo($e->getMessage());
            return false;
        }
        return true;    //This function returns TRUE if the username is available or throws a Fault if invalid or unavailable.
    }
    
    function clientSearch($clientName){
        try{
            $tempCall = $this->resellerClient->clientSearch(array(
                'filter'    =>  array(
                    'username'      =>  $clientName
				)
            ));
            $result = array(
                'results'       =>  $tempCall->results,            
                'numResults'    =>  $tempCall->numResults,
                'totalResults'  =>  $tempCall->totalResults 
            );
			foreach($result['results'] as $test){
				$clientId = $test->clientId;
			}
            return $clientId;
        }
        catch(exception $e){
            return $e->getMessage();
        }
    }
    
    function locationList($params){
        try{
            $tempCall = $this->resellerClient->locationList(array(
                'productId' =>  $params['productId']
            ));
            $result = array(
                'locations'     =>  $tempCall->locations,           //TODO returns array, must fix
                'numLocations'  =>  $tempCall->numLocations
            );
            return $result;
        }
        catch(exception $e){
            echo($e->getMessage());
            throw($e); 
        }
    }
    
    function noticeList($params){
        try{
            $tempCall = $this->resellerClient->noticeList();
            $result = array(
                'numResults'    =>   $tempCall->numResults,
                'results'       =>   $tempCall->results             //TODO returns array, must fix
            );
            return $result;
        }
        catch(exception $e){
            echo($e->getMessage());
            throw($e);
        }    
    }
}
?>