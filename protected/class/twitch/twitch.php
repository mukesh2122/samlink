<?php
/**
* TwitchTV API
*
* SDK for interacting with the TwitchTV API.
*
* @author Darren Taylor <shout@darrenonthe.net>
* https://github.com/dtisgodsson/twitch.tv-php-sdk
*/
class TwitchTV {

	private static $base_url = "https://api.twitch.tv/kraken/";
    
    public static function get_access_token ( $params ){
        //echo(PHP_EOL.TwitchTV_Endpoints::GET_ACCESS_TOKEN.$params);
        //exit();
        return static::_request(TwitchTV_Endpoints::GET_ACCESS_TOKEN . $params, "POST");
    }
    
    public static function get_auth_user( $accessToken )
    {
        $query_string = static::_build_query_string( array( "oauth_token" => $accessToken ));
        return static::_request(TwitchTV_Endpoints::GET_AUTH_USER . $query_string, "GET");
    }
    
    public static function get_followed_streams( $accessToken )
    {
        $query_string = static::_build_query_string( array( "oauth_token" => $accessToken ));
        return static::_request(TwitchTV_Endpoints::GET_FOLLOWED_STREAMS . $query_string, "GET");
    }

	public static function get_user( $username )
	{
		return static::_request( TwitchTV_Endpoints::GET_USER . $username );
	}

	public static function get_channel( $channel )
	{
		return static::_request( TwitchTV_Endpoints::GET_CHANNEL . $channel );
	}

	public static function get_stream( $channel )
	{
		return static::_request( TwitchTV_Endpoints::GET_STREAM . $channel );	
	}

	public static function get_video ( $video )
	{
		return static::_request( TwitchTV_Endpoints::GET_VIDEO . $video );
	}

	public static function get_featured_streams( $limit = NULL, $offset = NULL )
	{
		$query_string = static::_build_query_string( array( 
            "limit" => $limit,                                  //default = 25 ;    max = 100
            "offset" => $offset ) );                            //Object offset for pagination. Default is 0.
		return static::_request( TwitchTV_Endpoints::GET_FEATURED_STREAMS . $query_string );		
	}

	public static function get_streams_by_game( $game, $limit = NULL, $offset = NULL )
	{
		return static::get_streams( $game, $limit, $offset );
	}

	public static function get_streams_by_channel( $channels, $limit = NULL, $offset = NULL )
	{
		$channels = is_array( $channels ) ? $channels : (array) $channels;
		return static::get_streams( NULL, $limit, $offset, $channels );
	}

	public static function get_top_games( $limit = NULL, $offset = NULL )
	{
		$query_string = static::_build_query_string( array( "limit" => $limit, "offset" => $offset ) );
		return static::_request( TwitchTV_Endpoints::GET_TOP_GAMES . $query_string );
	}

	public static function search_streams( $query, $limit = NULL, $offset = NULL )
	{
		$query_string = static::_build_query_string( array( "query" => $query, "limit" => $limit, "offset" => $offset ) );
		return static::_request( TwitchTV_Endpoints::SEARCH_STREAMS . $query_string );
	}

	private static function get_streams( $game = NULL, $limit = NULL, $offset = NULL, $channels = array() )
	{
		$params = array(
			"game" 		=> $game,
			"limit" 	=> $limit,
			"offset" 	=> $offset,
			"channel" 	=> !empty( $channels ) ? implode( ",", $channels ) : NULL
		);

		$query_string = static::_build_query_string( $params );

		return static::_request( TwitchTV_Endpoints::GET_STREAM . $query_string );
	}

	private static function _build_query_string( $params )
	{
		$param = array();
		$query_string = "";

		foreach( $params as $key => $value )
		{
			if( !empty( $value ) )
			{
				$param[$key] = $value;
			}
		}

		if( !empty( $params ) )
		{
			$query_string = "?" . http_build_query( $params );
		}

		return $query_string;
	}

	private static function _request( $url , $reqType = 'GET')
	{
		$curl = curl_init();

		curl_setopt( $curl, CURLOPT_URL, static::$base_url . $url );
		curl_setopt( $curl, CURLOPT_HEADER, 0 );
		curl_setopt( $curl, CURLOPT_RETURNTRANSFER, 1 );
		curl_setopt( $curl, CURLOPT_SSL_VERIFYPEER, TRUE); 
		curl_setopt( $curl, CURLOPT_CAINFO, dirname(__FILE__) . "/cacert.pem");
		curl_setopt( $curl, CURLOPT_CUSTOMREQUEST, $reqType);	

		$result = curl_exec( $curl );

		if( curl_errno( $curl ) )
		{
			$exception = new TwitchException( 'Curl Exception', curl_errno( $curl ), curl_error( $curl ) );
			curl_close( $curl );
			throw $exception;
		}

		return json_decode( $result , TRUE);
	}
    
    private static function _addAccessToken($url, $accessToken = NULL)
    {
        if(!empty($accessToken)){
            $result = $url."&oauth_token=".$accessToken;
            return $result;
        }
        else return $url;         
    }

}

class TwitchTV_Endpoints
{
	const GET_USER 				    = "users/";
	const GET_STREAM 			    = "streams/";
	const GET_FEATURED_STREAMS 	    = "streams/featured/";
    const GET_FOLLOWED_STREAMS      = "streams/followed/";
	const GET_CHANNEL 			    = "channels/";
	const GET_TOP_GAMES			    = "games/top/";
	const SEARCH_STREAMS		    = "search/streams/";
	const GET_VIDEO                 = "videos/";
    const GET_ACCESS_TOKEN          = "oauth2/token/";
    const GET_AUTH_USER             = "user/";
}


class TwitchException extends Exception
{
	protected $error_type;
	protected $error_code;
	protected $error_message;

	public function __construct( $error_type, $error_code, $error_message=NULL )
	{
		if( is_null( $error_message ) )
		{
			$error_message = 'Unknown error.';
		}

		$this->error_type    = $error_type;
		$this->error_code    = $error_code;
		$this->error_message = $error_message;

		parent::__construct( $error_message, $error_code );
	}

	public function getType(){ return $this->error_type; }

	public function __toString()
	{
		$toRet = 'Exception type: ' . $this->error_type;
		$toRet .= ', Code ' . $this->error_code;
		$toRet .= ' -- ' . $this->error_message;
		return $toRet;
	}
}
?>