<?php

class Invitation {

    private $user;
    private $pass;

    public function __construct($user = '', $pass = '') {
        $this->user = $user;
        $this->pass = $pass;
    }

    public function inviteFromGmail() {
        Doo::loadClass('Zend/Gdata');
        Doo::loadClass('Zend/Gdata/ClientLogin');
        Doo::loadClass('Zend/Http/Client');
        Doo::loadClass('Zend/Gdata/Query');
        Doo::loadClass('Zend/Gdata/Feed');

        try {
            // perform login and set protocol version to 3.0
            $client = Zend_Gdata_ClientLogin::getHttpClient($this->user, $this->pass, 'cp');
            $gdata = new Zend_Gdata($client);
            $gdata->setMajorProtocolVersion(3);

            // perform query and get feed of all results
            $query = new Zend_Gdata_Query('http://www.google.com/m8/feeds/contacts/default/full');
            $query->maxResults = 999999;
            $query->setParam('orderby', 'lastmodified');
            $query->setParam('sortorder', 'descending');
            $feed = $gdata->getFeed($query);

            $results['error'] = '';
            $results['title'] = $feed->title;
            $results['totalResults'] = $feed->totalResults;

            // parse feed and extract contact information
            // into simpler objects
            $results = array();
            foreach ($feed as $entry) {
                $obj = new stdClass;
                $xml = simplexml_load_string($entry->getXML());
                $obj->Name = (string) $entry->title;

                foreach ($xml->email as $e) {
                    $obj->Email[] = (string) $e['address'];
                }

                $results['list'][] = $obj;
            }
        } catch (Exception $e) {
            $results['error'] = $e->getMessage();
        }

        return (object) $results;
    }

    public function inviteFromYahoo() {
        Doo::loadClass('Yahoo/GetRequestToken');
        Doo::loadClass('Yahoo/GetAccessToken');
        Doo::loadClass('Yahoo/CallContact');

        //beginning
//        $request = new GetRequestToken();
//        $requestResult = $request->getRequest();
//        
//        print_R($requestResult);
//        print rawurldecode($requestResult['xoauth_request_auth_url']);
        //oauth_verifier=bykxsz
        //[oauth_token] => hwhnznq [oauth_token_secret] => dd3b1096fa3d85d670c12a0c8a4257d03630193d
        //after verification
//        $access = new GetAccessToken('hwhnznq', 'dd3b1096fa3d85d670c12a0c8a4257d03630193d', 'bykxsz');
//        $accessResult = $access->getAccess();
//        
//        print_R($accessResult);
        //after access
        /**
          [oauth_token] => A%3DDg2IqTvRpisaEnMGR4WBqYLh.wGdoR0lujQbKKfOsOZBioCB7mSLVXKaMxrSO3saR95zIfJmvHEJRn1H.MOq44W1A2imRdEnWaTe2T7d13oYr5yokhSRRougw3H0LG4u0w5WkaEjw2UYaeKw4lbi7PlY.RRGSc81GkN9UT1N_k9XTmE6hz_pLNjl.LwIbb4SBNx98DTFqA_DZ3jXBzKbrXT3pf8jh6zpx_J731mcu4ErfCnU_KKvS6w5eSXoP_QJJRJ40nnncRafbopT81JQESNMkDDNFRdOGGgEBBZHBgpPhOTZgxCCBMyZRj0pKqI2f1K.d4ZsF.ShWOT8evVybypw27YUPVyEqJdZtLEIbgwlSXbphCXwIKoG._sxOdQjA0rQqtG1tbWZxiF2z8XSZgZQONrjKENAtivcBYLjHA5NyxYey.Q7sSxZ5wzoSjdRlAkS2hIzK0zH7CddnCup81KPeDQwE1Z4zBWwviPSyHD20mQWaiBMZ31yluKRU_Eb7VZArWeNJAHedwn3vbV48okMKhlM.tTTZParD0w7vx1l9bxSeAE05h665pQhXRbx54Tb4xcCchRYlcWO06Em9CKCrRFUCZj3lWgIEJ7E_lRiaCfwnNufFQY2RPMestUC.6DknVKjBACSWAmSmNkPx5Zjve0owuCPrp_bD77JoimEqXjvdIckyxDMMBzeMa_sSH6HkvLDTzWPSfBOXShC6JahfwBxe_6HsGahmZiU68u.pV6wDKKyvw--
          [oauth_token_secret] => 5c0ac00e4af0160e838bcdd1aebe8070a18d2105
          [xoauth_yahoo_guid] => HWCWTM7PKUCA6EH6AXO2W72EH4
         */
        $call = new CallContact('HWCWTM7PKUCA6EH6AXO2W72EH4', 'A%3DDg2IqTvRpisaEnMGR4WBqYLh.wGdoR0lujQbKKfOsOZBioCB7mSLVXKaMxrSO3saR95zIfJmvHEJRn1H.MOq44W1A2imRdEnWaTe2T7d13oYr5yokhSRRougw3H0LG4u0w5WkaEjw2UYaeKw4lbi7PlY.RRGSc81GkN9UT1N_k9XTmE6hz_pLNjl.LwIbb4SBNx98DTFqA_DZ3jXBzKbrXT3pf8jh6zpx_J731mcu4ErfCnU_KKvS6w5eSXoP_QJJRJ40nnncRafbopT81JQESNMkDDNFRdOGGgEBBZHBgpPhOTZgxCCBMyZRj0pKqI2f1K.d4ZsF.ShWOT8evVybypw27YUPVyEqJdZtLEIbgwlSXbphCXwIKoG._sxOdQjA0rQqtG1tbWZxiF2z8XSZgZQONrjKENAtivcBYLjHA5NyxYey.Q7sSxZ5wzoSjdRlAkS2hIzK0zH7CddnCup81KPeDQwE1Z4zBWwviPSyHD20mQWaiBMZ31yluKRU_Eb7VZArWeNJAHedwn3vbV48okMKhlM.tTTZParD0w7vx1l9bxSeAE05h665pQhXRbx54Tb4xcCchRYlcWO06Em9CKCrRFUCZj3lWgIEJ7E_lRiaCfwnNufFQY2RPMestUC.6DknVKjBACSWAmSmNkPx5Zjve0owuCPrp_bD77JoimEqXjvdIckyxDMMBzeMa_sSH6HkvLDTzWPSfBOXShC6JahfwBxe_6HsGahmZiU68u.pV6wDKKyvw--', '5c0ac00e4af0160e838bcdd1aebe8070a18d2105');
        $callResult = $call->call();

        $results = array();
        if (isset($callResult->contacts->contact)) {
            foreach ($callResult->contacts->contact as $entry) {

                if (!empty($entry->fields)) {
                    $obj = new stdClass;
                    foreach ($entry->fields as $e) {
                        if ($e->type == 'name') {
                            $name = '';
                            if(isset($e->value->givenName)) {
                               $name = $e->value->givenName;
                            } else if(isset($e->value->middleName)) {
                                $name = $e->value->middleName;
                            } else if(isset($e->value->familyName)) {
                                $name = $e->value->familyName;
                            }
                            $obj->Name = $name;
                        } else if ($e->type == 'email') {
                            $obj->Email[] = $e->value;
                        }
                    }
                    $results['list'][] = $obj;
                }
            }
        } else {
            $results['error'] = 'No Contacts';
        }
        return (object) $results;
    }

}

?>
