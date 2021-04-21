<?php

class GetAccessToken {
    private $request_token;
    private $request_token_secret;
    private $oauth_verifier;

    public function __construct($token, $secret, $verifier) {
        $this->request_token = $token;
        $this->request_token_secret = $secret;
        $this->oauth_verifier = $verifier;
    }

    public function getAccess() {
        $retarr = $this->getAccessToken(false, true, true);
        if (!empty($retarr)) {
            list($info, $headers, $body, $body_parsed) = $retarr;
            if ($info['http_code'] == 200 && !empty($body)) {
                return $body_parsed;
            }
        }
    }

    /**
     * Get an access token using a request token and OAuth Verifier.
     * @param bool $usePost use HTTP POST instead of GET
     * @param bool $useHmacSha1Sig use HMAC-SHA1 signature
     * @param bool $passOAuthInHeader pass OAuth credentials in HTTP header
     * @return array of response parameters or empty array on error
     */
    private function getAccessToken($usePost=false, $useHmacSha1Sig=true, $passOAuthInHeader=true) {
        $consumer_secret = Doo::conf()->OAUTH_CONSUMER_SECRET;
        $request_token_secret = $this->request_token_secret;

        $helper = new OauthHelper();
        $yglobals = new YahooGlobals();
        $retarr = array();  // return value
        $response = array();

        $url = 'https://api.login.yahoo.com/oauth/v2/get_token';
        $params['oauth_version'] = '1.0';
        $params['oauth_nonce'] = mt_rand();
        $params['oauth_timestamp'] = time();
        $params['oauth_consumer_key'] = Doo::conf()->OAUTH_CONSUMER_KEY;;
        $params['oauth_token'] = $this->request_token;;
        $params['oauth_verifier'] = $this->oauth_verifier;;

        // compute signature and add it to the params list
        if ($useHmacSha1Sig) {
            $params['oauth_signature_method'] = 'HMAC-SHA1';
            $params['oauth_signature'] = $helper->oauth_compute_hmac_sig($usePost ? 'POST' : 'GET', $url, $params, $consumer_secret, $request_token_secret);
        } else {
            $params['oauth_signature_method'] = 'PLAINTEXT';
            $params['oauth_signature'] = $helper->oauth_compute_plaintext_sig($consumer_secret, $request_token_secret);
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
