<?php

class CallContact {
    private $guid;
    private $access_token;
    private $access_token_secret;

    public function __construct($guid, $token, $secret) {
        $this->guid = $guid;
        $this->access_token = rawurldecode($token);
        $this->access_token_secret = $secret;
    }

    public function call() {
        $retarr = $this->callContact(false, true);
        if (!empty($retarr)) {
            list($info, $headers, $body) = $retarr;
            if ($info['http_code'] == 200 && !empty($body)) {
                return json_decode($body);
            }
        }
    }

    /**
     * Call the Yahoo Contact API
     * @param bool $usePost use HTTP POST instead of GET
     * @param bool $passOAuthInHeader pass the OAuth credentials in HTTP header
     * @return response string with token or empty array on error
     */
    function callContact($usePost=false, $passOAuthInHeader=true) {
        $retarr = array();  // return value
        $response = array();
        $helper = new OauthHelper();
        $yglobals = new YahooGlobals();
        
        $url = 'http://social.yahooapis.com/v1/user/' . $this->guid . '/contacts;count=5';
        $params['format'] = 'json';
        $params['view'] = 'compact';
        $params['oauth_version'] = '1.0';
        $params['oauth_nonce'] = mt_rand();
        $params['oauth_timestamp'] = time();
        $params['oauth_consumer_key'] = Doo::conf()->OAUTH_CONSUMER_KEY;;
        $params['oauth_token'] = $this->access_token;

        // compute hmac-sha1 signature and add it to the params list
        $params['oauth_signature_method'] = 'HMAC-SHA1';
        $params['oauth_signature'] = $helper->oauth_compute_hmac_sig($usePost ? 'POST' : 'GET', $url, $params, Doo::conf()->OAUTH_CONSUMER_SECRET, $this->access_token_secret);

        // Pass OAuth credentials in a separate header or in the query string
        if ($passOAuthInHeader) {
            $query_parameter_string = $helper->oauth_http_build_query($params, true);
            $header = $helper->build_oauth_header($params, "yahooapis.com");
            $headers[] = $header;
        } else {
            $query_parameter_string = $helper->oauth_http_build_query($params);
        }

        // POST or GET the request
        if ($usePost) {
            $request_url = $url;
            $headers[] = 'Content-Type: application/x-www-form-urlencoded';
            $response = $yglobals->do_post($request_url, $query_parameter_string, 80, $headers);
        } else {
            $request_url = $url . ($query_parameter_string ? ('?' . $query_parameter_string) : '' );
            $response = $yglobals->do_get($request_url, 80, $headers);
        }

        // extract successful response
        if (!empty($response)) {
            $retarr = $response;
        }

        return $retarr;
    }

}

?>
