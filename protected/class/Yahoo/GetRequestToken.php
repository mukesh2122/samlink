<?php

class GetRequestToken {
    private $callback; //'oob' or a url

    public function __construct() {
        $this->callback = MainHelper::site_url('players/invite');
    }
    
    public function getRequest() {
        $retarr = $this->getRequestToken(false, true, true);
        if (!empty($retarr)) {
            list($info, $headers, $body, $body_parsed) = $retarr;
            if ($info['http_code'] == 200 && !empty($body)) {
                return $body_parsed;
            }
        }
    }

    /**
     * Get a request token.
     * @param bool $usePost use HTTP POST instead of GET
     * @param bool $useHmacSha1Sig use HMAC-SHA1 signature
     * @param bool $passOAuthInHeader pass OAuth credentials in HTTP header
     * @return array of response parameters or empty array on error
     */
    private function getRequestToken($usePost=false, $useHmacSha1Sig=true, $passOAuthInHeader=false) {
        $consumer_secret = Doo::conf()->OAUTH_CONSUMER_SECRET;
        
        $retarr = array();  // return value
        $response = array();
        $helper = new OauthHelper();
        $yglobals = new YahooGlobals();

        $url = 'https://api.login.yahoo.com/oauth/v2/get_request_token';
        $params['oauth_version'] = '1.0';
        $params['oauth_nonce'] = mt_rand();
        $params['oauth_timestamp'] = time();
        $params['oauth_consumer_key'] = Doo::conf()->OAUTH_CONSUMER_KEY;;
        $params['oauth_callback'] = $this->callback;;

        // compute signature and add it to the params list
        if ($useHmacSha1Sig) {
            $params['oauth_signature_method'] = 'HMAC-SHA1';
            $params['oauth_signature'] = $helper->oauth_compute_hmac_sig($usePost ? 'POST' : 'GET', $url, $params, $consumer_secret, null);
        } else {
            $params['oauth_signature_method'] = 'PLAINTEXT';
            $params['oauth_signature'] = $helper->oauth_compute_plaintext_sig($consumer_secret, null);
        }

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
            $response = $yglobals->do_post($request_url, $query_parameter_string, 443, $headers);
        } else {
            $request_url = $url . ($query_parameter_string ? ('?' . $query_parameter_string) : '' );
            $response = $yglobals->do_get($request_url, 443, $headers);
        }

        // extract successful response
        if (!empty($response)) {
            list($info, $header, $body) = $response;
            $body_parsed = $helper->oauth_parse_str($body);
            $retarr = $response;
            $retarr[] = $body_parsed;
        }

        return $retarr;
    }
}

?>
