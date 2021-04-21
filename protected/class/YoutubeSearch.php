<?php

	//Doo::loadClass(array("Google/Google_Client", "Google/contrib/Google_YoutubeService"));

	class YoutubeSearch {
		
		//CONSTANTS.
		/**
		 * High resolution thumbnail.
		 */
		const THUMBNAIL_HIGH = "high";
		/**
		 * Medium resolution thumbnail.
		 */
		const THUMBNAIL_MEDIUM = "medium";
		/**
		 * Low resolution thumbnail.
		 */
		const THUMBNAIL_LOW = "default";
		
		/**
		 * Order results by upload date.
		 */
		const ORDER_DATE = "date";
		/**
		 * Order results by rating.
		 */
		const ORDER_RATING = "rating";
		/**
		 * Order results by search relevance.
		 */
		const ORDER_RELEVANCE = "relevance";
		/**
		 * Order results by video title.
		 */
		const ORDER_TITLE = "title";
		/**
		 * Order results by view count.
		 */
		const ORDER_VIEWS = "viewCount";
		
		/**
		 * Use no search moderation.
		 */
		const MODERATION_NONE = "none";
		/**
		 * Use the default search moderation.
		 */
		const MODERATION_MODERATE = "moderate";
		/**
		 * Use strict search moderation.
		 */
		const MODERATION_STRICT = "strict";
		
		/**
		 * Search for both HD and non-HD videos.
		 */
		const QUALITY_ANY = "any";
		/**
		 * Search for non-HD videos only.
		 */
		const QUALITY_STANDARD = "standard";
		/**
		 * Search for HD videos only.
		 */
		const QUALITY_HIGH = "high";
		
		
		/**
		 * Performs a Youtube search using the given parameters.
		 * @static
		 * @param YoutubeSearchParameters $params An instance of the YoutubeSearchParameters class.
		 * @return YoutubeSearchResult
		 */
		public static function Search($params = null){
			//Validate parameters.
			$result = null;
			if($params != null && $params instanceof YoutubeSearchParameters){
				//Setup the client.
				$client = new Google_Client();
				$client->setDeveloperKey(Doo::conf()->google_developer_key);
				$ytclient = new Google_YouTubeService($client);
				
				//Try to perform a search request.
				try {
					$searchResponse = $ytclient->search->listSearch("id,snippet", $params->_getSearchParams());
					
					//Collect all videos from the search.
					$videos = array();
					foreach($searchResponse['items'] as $result){
						if($result['id']['kind'] == "youtube#video"){
							$videos[] = $result;
						}
					}

					//Create a new instance of YoutubeSearchResult with the found videos.
					$result = new YoutubeSearchResult($videos,
													  (array_key_exists("nextPageToken", $searchResponse)) ? $searchResponse['nextPageToken'] : "",
													  (array_key_exists("prevPageToken", $searchResponse)) ? $searchResponse['prevPageToken'] : "",
													  $searchResponse["pageInfo"]["totalResults"]
													  );
				}
				catch(Google_ServiceException $e){
					$htmlBody .= sprintf('<p>Ohh you done goofed! Something went wrong on the service: <code>%s</code></p>', htmlspecialchars($e->getMessage()));
				}
				catch(Google_Exception $e){
					$htmlBody .= sprintf('<p>Ohh you done goofed! Something went wrong on the client: <code>%s</code></p>', htmlspecialchars($e->getMessage()));
				}
			}
			else {
				//TODO Throw exception.
				throw new Exception("YoutubeSearch: Expected parameter to be an instance of YoutubeSearchParameters.");
			}
			
			return $result;
		}

		/**
		 * Performs a Youtube search and returns all videos on the given channel or optionally all videos on a given playlist.
		 * @static
		 * @param string $channel The name or id of the Youtube channel to search through.
		 * @param string $playlist Optional. The playlist on the channel to search through.
		 * @return YoutubeSearchResult
		 */
		public static function SearchChannel($channel, $params, $playlist = null){
			//Validate parameters.
			$result = null;
			if($params != null && $params instanceof YoutubeSearchParameters){
				//Setup the client.
				$client = new Google_Client();
				$client->setDeveloperKey(Doo::conf()->google_developer_key);
				$ytclient = new Google_YouTubeService($client);
				
				$params->unsetOption("q");
				
				//Try to perform a search request.
				try {
					$channelSearch = $ytclient->channels->listChannels("id,snippet", array("forUsername" => $channel));
					
					//If the channel exists.
					if($channelSearch["pageInfo"]["totalResults"] > 0){
						$channelId = $channelSearch["items"][0]["id"];
						
						if($playlist == null){
							//Get all videos on the channel.							
							$params->setCustomOption("channelId", $channelId);
							$search = $ytclient->search->listSearch("id,snippet", $params->_getSearchParams());
							
							//Collect all videos from the search.
							$videos = array();
							foreach($search['items'] as $result){
								if($result['id']['kind'] == "youtube#video"){
									$videos[] = $result;
								}
							}
							
							$result = new YoutubeSearchResult($videos,
													  (array_key_exists("nextPageToken", $search)) ? $search['nextPageToken'] : "",
													  (array_key_exists("prevPageToken", $search)) ? $search['prevPageToken'] : "",
													  $search["pageInfo"]["totalResults"]
													  );
						}
						else {
							//Get only videos from the given playlist.
							//Firstly we need to find the playlist id.
							$playlistSearch = $ytclient->playlists->listPlaylists("id,snippet", array("channelId" => $channelId, "maxResults" => 50));
							
							if($playlistSearch["pageInfo"]["totalResults"] > 0){
								$playlistId = "";

								foreach($playlistSearch["items"] as $item){
									if($item["snippet"]["title"] == $playlist){
										$playlistId = $item["id"];
										break;
									}
								}
								
								if(!empty($playlistId)){
									//Get all videos in the playlist.
									$params->unsetOption("type");
									$params->unsetOption("order");
									$params->unsetOption("videoDefinition");
									$params->unsetOption("videoEmbeddable");
									$params->unsetOption("safeSearch");
									$params->setCustomOption("playlistId", $playlistId);
									
									$videosList = $ytclient->playlistItems->listPlaylistItems("id,snippet", $params->_getSearchParams());
									
									//Collect all videos from the search.
									$videos = array();
									foreach($videosList['items'] as $result){
										if($result['kind'] == "youtube#playlistItem"){
											$videos[] = $result;
										}
									}
									
									$result = new YoutubeSearchResult($videos,
														  (array_key_exists("nextPageToken", $videosList)) ? $videosList['nextPageToken'] : "",
														  (array_key_exists("prevPageToken", $videosList)) ? $videosList['prevPageToken'] : "",
														  $videosList["pageInfo"]["totalResults"]
														  );
								}
							}
						}
					}
				}
				catch(Google_ServiceException $e){
					echo sprintf('<p>Ohh you done goofed! Something went wrong on the service: <code>%s</code></p>', htmlspecialchars($e->getMessage()));
				}
				catch(Google_Exception $e){
					echo sprintf('<p>Ohh you done goofed! Something went wrong on the client: <code>%s</code></p>', htmlspecialchars($e->getMessage()));
				}
			}
			else {
				//TODO Throw exception.
				throw new Exception("YoutubeSearch: Expected parameter to be an instance of YoutubeSearchParameters.");
			}
			
			return $result;
		}
		
	}
	
	
	class YoutubeSearchResult {
		
		private $videos, $nextT, $previousT, $total;
		
		public function __construct($videos, $next = "", $previous = "", $total){
			if(is_array($videos) && is_string($next) && is_string($previous) && is_int($total)){
				$this->videos = $videos;
				$this->nextT = $next;
				$this->previousT = $previous;
				$this->total = $total;
			}
			else {
				//Throw exception.
				throw new Exception("YoutubeSearchResult: Invalid parameters.");
			}
		}
		
		/**
		 * Gets the title of the video with the given index.
		 * @param int $index The index of the video.
		 * @return string
		 */
		public function getVideoTitle($index = 0){
			if($this->checkIndexRange($index)){
				return $this->videos[$index]['snippet']['title'];
			}
			else {
				throw new Exception("YoutubeSearchResult.getVideoTitle: Index(" . $index . ") not an integer or it was out of range.");
			}
		}
		
		/**
		 * Gets the description of the video with the given index.
		 * @param int $index The index of the video.
		 * @return string
		 */
		public function getVideoDescription($index = 0){
			if($this->checkIndexRange($index)){
				return $this->videos[$index]['snippet']['description'];
			}
			else {
				throw new Exception("YoutubeSearchResult.getVideoDescription: Index(" . $index . ") not an integer or it was out of range.");
			}
		}
		
		/**
		 * Gets the name of the channel the video with the given index belongs to.
		 * @param int $index The index of the video.
		 * @return string
		 */
		public function getChannelName($index = 0){
			if($this->checkIndexRange($index)){
				return $this->videos[$index]['snippet']['channelTitle'];
			}
			else {
				throw new Exception("YoutubeSearchResult.getChannelName: Index(" . $index . ") not an integer or it was out of range.");
			}
		}
		
		/**
		 * Gets the ID of the video with the given index.
		 * @param int $index The index of the video.
		 * @return string
		 */
		public function getVideoId($index = 0){
			if($this->checkIndexRange($index)){
				if(array_key_exists("resourceId", $this->videos[$index]['snippet']))
					return $this->videos[$index]['snippet']['resourceId']['videoId'];
				
				return $this->videos[$index]['id']['videoId'];
			}
			else {
				throw new Exception("YoutubeSearchResult.getVideoId: Index(" . $index . ") not an integer or it was out of range.");
			}
		}
		
		/**
		 * Gets a direct link to the video with the given index.
		 * @param int $index The index of the video.
		 * @return string
		 */
		public function getVideoLink($index = 0){
			if($this->checkIndexRange($index)){
				return "http://www.youtube.com/watch?v=" . $this->getVideoId($index);
			}
			else {
				throw new Exception("YoutubeSearchResult.getVideoLink: Index(" . $index . ") not an integer or it was out of range.");
			}
		}
		
		/**
		 * Gets a direct link to the channel the video with the given index belongs to.
		 * @param int $index The index of the video.
		 * @return string
		 */
		public function getChannelLink($index = 0){
			if($this->checkIndexRange($index)){
				return "http://www.youtube.com/" . $this->getChannelName($index);
			}
			else {
				throw new Exception("YoutubeSearchResult.getChannelLink: Index(" . $index . ") not an integer or it was out of range.");
			}
		}
		
		/**
		 * Gets embed code for the video with the given index.
		 * @param int $index The index of the video.
		 * @param int $width The width of the embedded video.
		 * @param int $height The heigh of the embedded video.
		 * @param bool $showRelatedVideos Whether or not to show related videos when the video is done playing.
		 * @return string
		 */
		public function getEmbeddedVideo($index = 0, $width = 560, $height = 315, $showRelatedVideos = true){
			if($this->checkIndexRange($index)){
				if(is_int($width) && $width > 0 && is_int($height) && $height > 0){
					if(is_bool($showRelatedVideos)){
						$videoId = $this->getVideoId($index);
						if(!$showRelatedVideos){
							$videoId .= "?rel=0";
						}
						
						return "<iframe width=\"" . $width . "\" height=\"" . $height . "\" src=\"//www.youtube.com/embed/" . $videoId . "\" frameborder=\"0\" allowFullscreen></iframe>";
					}
					else {
						throw new Exception("YoutubeSearchResult.getEmbeddedVideo: Expected showRelatedVideos to be a boolean.");
					}
				}
				else {
					throw new Exception("YoutubeSearchResult.getEmbeddedVideo: Expected width and height to be non-zero integers.");
				}
			}
			else {
				throw new Exception("YoutubeSearchResult.getEmbeddedVideo: Index(" . $index . ") not an integer or it was out of range.");
			}
		}
		
		/**
		 * Gets the thumbnail of the video with the given index. Use the constants in the YoutubeSearch class.
		 * @param int $index The index of the video.
		 * @param string $resolution The resolution of the thumbnail.
		 * @return string
		 */
		public function getVideoThumbnail($index = 0, $resolution = "default"){
			if($this->checkIndexRange($index)){
				if(is_string($resolution) && !empty($resolution)){
					return "<img src=\"" . $this->getVideoThumbnailLink($i, $resolution) . "\" alt=\"\" />";
				}
				else {
					throw new Exception("YoutubeSearchResult.getVideoThumbnail: Resolution(" . $resolution . ") not valid.");
				}
			}
			else {
				throw new Exception("YoutubeSearchResult.getVideoThumbnail: Index(" . $index . ") not an integer or it was out of range.");
			}
		}
		
		/**
		 * Gets the link to the given videos thumbnail. Use the constants in the YoutubeSearch class.
		 * @param int $index The index of the video.
		 * @param string $resolution The resolution of the thumbnail.
		 * @return string
		 */
		public function getVideoThumbnailLink($index = 0, $resolution = "default"){
			if($this->checkIndexRange($index)){
				if(is_string($resolution) && !empty($resolution)){
					return $this->videos[$index]['snippet']['thumbnails'][$resolution]['url'];
				}
				else {
					throw new Exception("YoutubeSearchResult.getVideoThumbnailLink: Resolution(" . $resolution . ") not valid.");
				}
			}
			else {
				throw new Exception("YoutubeSearchResult.getVideoThumbnailLink: Index(" . $index . ") not an integer or it was out of range.");
			}
		}

		/**
		 * Gets the date and time the video was uploaded in the given format.
		 * @param int $index The index of the video.
		 * @param string $format The format of the date and time.
		 * @return string
		 */
		public function getVideoUploadDate($index = 0, $format = "d/m-Y - G:i:s"){
			if($this->checkIndexRange($index)){
				if(!empty($format)){
					$publishDate = explode('T', $this->videos[$index]['snippet']['publishedAt']);
					$date = $publishDate[0];
					$time = substr($publishDate[1], 0, count($publishDate[1]) - 6);
				
					$datetime = DateTime::createFromFormat("Y-m-d:G:i:s", $date . ":" . $time, new DateTimeZone("UTC")); 
				
					return date_format($datetime, $format);
				}
				else {
					throw new Exception("YoutubeSearchResult.getVideoUploadDate: Format cannot be empty.");
				}
			}
			else {
				throw new Exception("YoutubeSearchResult.getVideoUploadDate: Index(" . $index . ") not an integer or it was out of range.");
			}
		}
		
		/**
		 * Gets the amount of videos on the current page.
		 * @return int
		 */
		public function getVideoAmount(){
			return count($this->videos);
		}
		
		/**
		 * Gets the token for the next page of videos, returns null if there are no more pages.
		 * @return string|null
		 */
		public function getNextPageToken(){
			return (!empty($this->nextT)) ? $this->nextT : null;
		}
		
		/**
		 * Gets the token for the previous page of videos, returns null if there are no previous pages.
		 * @return string|null
		 */
		public function getPreviousPageToken(){
			return (!empty($this->previousT)) ? $this->previousT : null;
		}
		
		/**
		 * Gets the total amount of results found.
		 * @return int
		 */
		public function getTotalResultCount(){
			return $this->total;
		}
		
		/**
		 * Reverses the order of the videos.
		 */
		public function reverseOrder(){
			$this->videos = array_reverse($this->videos);
		}
		
		private function checkIndexRange($index){
			return (is_int($index) && $index >= 0 && $index < $this->getVideoAmount());
		}
		
	}

	
	class YoutubeSearchParameters {
		
		private $params;
		
		/**
		 * Makes a new instance of the YoutubeSearchParameters class.
		 * @param string $keyword The term to search for.
		 */
		public function __construct($keyword = "Games"){
			if(is_string($keyword) && !empty($keyword)){
				$this->params = array();
				$this->params["q"] = $keyword;
				$this->params["maxResults"] = 50;
				$this->params["type"] = "video";
			}
			else {
				throw new Exception("YoutubeSearchParameters: Expected parameter to be a non-empty string.");	
			}
		}
		
		/**
		 * Sets a custom option.
		 * $param string $key The option to set.
		 * $param string $value The value to set.
		 */
		public function setCustomOption($key, $value){
			$this->params[$key] = $value;
		}
		
		/**
		 * Unsets a given option.
		 * $param string $key The option to unset.
		 */
		public function unsetOption($key){
			if(array_key_exists($key, $this->params))
				unset($this->params[$key]);
		}
		
		/**
		 * Sets how many results to get per page.
		 * @param int $limit The search limit per page.
		 */
		public function setResultLimit($limit){
			if(is_int($limit) && $limit > 0){
				$this->params["maxResults"] = $limit;
			}
			else {
				throw new Exception("YoutubeSearchParameters.setResultLimit: Expected parameter to be an integer bigger than zero.");
			}
		}
		
		/**
		 * Sets how the results should be ordered. Use the constants in the YoutubeSearch class.
		 * @param string $order How to order the videos.
		 */
		public function setResultOrder($order){
			if(is_string($order) && !empty($order)){
				$this->params["order"] = $order;
			}
			else {
				throw new Exception("YoutubeSearchParameters.setResultOrder: Expected parameter to be a non-empty string.");
			}
		}
		
		/**
		 * Sets the quality constraints of the search results. Use the constants in the YoutubeSearch class.
		 * @param string $quality The quality constraint to set.
		 */
		public function setResultQuality($quality){
			if(is_string($quality) && !empty($quality)){
				$this->params["videoDefinition"] = $quality;
			}
			else {
				throw new Exception("YoutubeSearchParameters.setResultQuality: Expected parameter to be a non-empty string.");
			}
		}
		
		/**
		 * Sets whether or not to make sure the videos can be embedded.
		 * @param bool $enabled Whether or not to make sure videos can be embedded.
		 */
		public function setResultEmbeddable($enabled = true){
			if(is_bool($enabled)){
				$this->params["videoEmbeddable"] = ($enabled) ? "true" : "any";
			}
			else {
				throw new Exception("YoutubeSearchParameters.setResultEmbeddable: Expected parameter to be a boolean.");
			}
		}
		
		/**
		 * Sets the search moderation. This determines how much restricted content is in the search results. Use the constants in the YoutubeSearch class.
		 * @param string $level The level of moderation to apply to the search.
		 */
		public function setSearchModeration($level){
			if(is_string($level) && !empty($level)){
				$this->params["safeSearch"] = $level;
			}
			else {
				throw new Exception("YoutubeSearchParameters.setSearchModeration: Expected parameter to be a non-empty string.");
			}
		}
		
		/**
		 * Sets a page token.
		 * @param string $token A page token retrieved from either YoutubeSearchResult->getNextPageToken() or YoutubeSearchResult->getPreviousPageToken().
		 */
		public function setPageToken($token){
			if(is_string($token) && !empty($token)){
				$this->params["pageToken"] = $token;
			}
			else {
				throw new Exception("YoutubeSearchParameters.setPageToken: Expected parameter to be a non-empty string.");
			}
		}
		
		public function _getSearchParams(){
			return $this->params;
		}
		
	}
	
?>