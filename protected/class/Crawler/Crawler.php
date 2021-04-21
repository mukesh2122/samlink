<?php
	require_once 'simple_html_dom.php';
	require_once 'php-webdriver-master/lib/__init__.php';
	
	/******************************************
	  Crawler
	  crawl one site, one page at the time
	******************************************/
	class Crawler {
		private static $seHost = 'http://localhost:4444/wd/hub'; // this is the default
		public $seDriver;
		
		//---- Crawling ----
		public $rootUrl;
		public $links = array();     // links[] = (url,status)
		public $obeyRobotsTxt = TRUE;
		public $obeyNoFollow = TRUE;
		public $obeyNoIndex = TRUE;
		public $robots = array();   // hash array
		public $urlFilterRules = array();
		public $followMode = 2;
		public $trafficLimit = 0;
		public $pageLimit = 0;

		//---- Documents ----
		public $docInfo = array();

		//---- Stats ----
		public $bytesReceived = 0;
		public $filesReceived = 0;
		public $linksFollowed = 0;
		public $processStartTime = 0;
		public $runTime = 0;

		/* Add link to link-list, with no fragment or query part */
		function addLink($url) {
			$url = preg_replace('#\/+$#', '', $url);   // Skip tailing slash
			if (!in_array($url, array('#', ''))) {

				//---- Rebuild URL ----
				$urlParts = parse_url($url);
				$rootUrlParts = parse_url($this->rootUrl);
				if (empty($urlParts['host'])){
					$urlParts['host'] = $rootUrlParts['host'];
				}
				if (empty($urlParts['scheme'])){
					$urlParts['scheme'] = $rootUrlParts['scheme'];
				}
				unset($urlParts['fragment']);
				$url = self::unparseUrl($urlParts);
				
				//---- Check if link exists ----
				$linkExists = false;
				foreach($this->links as $link){
					if ($link['url'] == $url){
						$linkExists = true;
						break;
					}
				}
				//---- Add new link if not filtered ----
				if (!$linkExists && self::followUrl($url)) {   // url doesn't exist and can be followed
					$url_ok = TRUE;
					if ($url_ok && $this->obeyRobotsTxt) {     // url isn't disallowed in robots.txt
						$url_ok = !self::robotsDisallow($url);
					}
					if ($url_ok) {                             // url isn't filtered
						$url_ok = !self::filterRule($url);
					}
					if ($url_ok) {                             // Add url to link list !
						$link['url'] = $url;
						$link['status'] = 'new';
						$this->links[] = $link;
					}
				}
			}
		}

		/* add links found in html source */
		function addSourceLinks() {
			if (!($this->obeyNoIndex && self::noindex($this->docInfo['source']))) {   // Obey noindex flag if requested
				$html = str_get_html($this->docInfo['source']);
				foreach ($html->find('a') as $anchor) {
					if (!($this->obeyNoFollow && preg_match('#nofollow# i', $anchor->rel))) {   // Obey nofollow flag if requered
						self::addLink(trim($anchor->href));
					}
				}
				$html->clear();
				unset($html);
			}
		}

		/* Add regexp to list of filtered URLs */
		function addUrlFilterRule($regexp) {
			$this->urlFilterRules[] = $regexp;
		}

		/* Fetch and decode robots.txt */
		function fetchRobots() {
			$parsedUrl = parse_url($this->rootUrl);
			$parsedUrl['path'] = '/robots.txt';
			$fileName = self::unparseUrl($parsedUrl);
			if (self::urlExists($fileName)) {                       // Decode robots.txt
				$myUserAgent = FALSE;
				foreach(file($fileName) as $line) {
					if (!$myUserAgent && preg_match('#^\s*User-agent\s*:\s*\*# i', $line)) {         // My user agent is '*'
						$myUserAgent = TRUE;
					}
					else if ($myUserAgent && preg_match('#^\s*(\S+)\s*:\s*(\S+)#', $line, $regs)){   // Fetch <parameter>:<value>
						$this->robots[$regs[1]][$regs[2]] = 1;
					}
					else if ($myUserAgent && trim($line) == '') {   // End of my user agent
						$myUserAgent = FALSE;
					}
				}
			}
		}

		/* Returns TRUE if URL is addUrlFilterRule */
		function filterRule($url) {
			foreach ($this->urlFilterRules as $rule) {
				if (preg_match($rule, $url)) {
					return TRUE;
				}
			}
			return FALSE;
		}

		/* Returns TRUE if URL should be followed */
		function followUrl($url) {
			$rootUrlParts = parse_url($this->rootUrl);
			$rootHost = preg_replace('#^www.# i', '', $rootUrlParts['host']);   // Remove leading www. from root-url
			$rootHostPath = $rootHost;
			if (!empty($rootUrlParts['path'])) $rootHostPath = $rootHost.$rootUrlParts['path'];
			switch($this->followMode) {
				case 0:   // Follow every link
					return true;
					break;
				case 1:   // Follow link if host is included in url
					return preg_match('#'.$rootHost.'# i', $url);
					break;
				case 2:   // Follow link if it is on same or lower level than host/path
					return preg_match('#'.$rootHostPath.'# i', $url, $regs);
					break;
				case 3:   // Follow link if it is on same host/path
					return preg_match('#'.$rootHostPath.'$# i', $url);
					break;
			}
			return false;
		}

		/* Returns content of next retrieved page */
		function next() {
			$runTimeStart = time();
			if (($this->trafficLimit > 0 && $this->bytesReceived >= $this->trafficLimit)
			 || ($this->pageLimit > 0 && $this->filesReceived >= $this->pageLimit)){
				return FALSE;
			}
			$this->docInfo['source'] = '';
			foreach ($this->links as $key => $link) {
				if ($link['status'] == 'new') {
					$this->docInfo['url'] = $link['url'];
					if (self::urlExists($link['url'])) {
						$this->seDriver->get($link['url']);
						$this->docInfo['source'] = $this->seDriver->getPageSource();
					}
					else {
						$this->docInfo['source'] = FALSE;
					}
					if ($this->docInfo['source']) {
						self::addSourceLinks();
						$this->links[$key]['status'] = 'retrieved';
						$this->bytesReceived += strlen($this->docInfo['source']);
						++$this->filesReceived;
						++$this->linksFollowed;
					}
					else {
						$this->links[$key]['status'] = 'failed';
						++$this->linksFollowed;
					}
					break;
				}
			}
			$this->runTime += time() - $runTimeStart;
			return $this->docInfo;
		}

		/* returns TRUE if NOINDEX is set in meta tags */
		function noindex($source) {
			$html = str_get_html($source);
			$noindex = FALSE;
			foreach($html->find('meta') as $meta) {
				if (preg_match('#robots# i', $meta->name) && preg_match('#noindex# i', $meta->content)) {
					$noindex = TRUE;
					break;
				}
			}
			$html->clear();
			unset($html);
			return $noindex;
		}

		/* Returns statistical information */
		function report() {
				return array(
				  'bytesReceived' => $this->bytesReceived
				, 'filesReceived' => $this->filesReceived
				, 'linksFollowed' => $this->linksFollowed
				, 'linksFound'    => count($this->links)
				, 'runTime'       => $this->runTime
				, 'processTime'   => time() - $this->processStartTime
				);
		}

		/* Returns TRUE if URL is disallowed in robots.txt */
		function robotsDisallow($url) {
			$disallow = FALSE;
			$urlParts = parse_url($url);
			foreach ($this->robots as $field => $paths) {
				foreach ($paths as $path => $dummy) {
					if ($field == 'Disallow') {
						if (!empty($urlParts['path']) && preg_match('#^'.$path.'#', $urlParts['path'])) {
							$disallow = TRUE;
						}
					}
				}
			}
			return $disallow;
		}

		public static function seleniumHost(){
			return self::$seHost;
		}
		
		public static function seleniumIsActive(){
			$urlParts = parse_url(self::seleniumHost());
			if (isset(Doo::conf()->ERROR_HANDLER)){   // Disable doophp error handler in diagnostic/debug.php
				restore_error_handler();
			}
			$socket = @fsockopen($urlParts['host'], $urlParts['port'], $errno, $errstr, 2);
			if (isset(Doo::conf()->ERROR_HANDLER)){   // Re-enable doophp error handler in diagnostic/debug.php
				set_error_handler(Doo::conf()->ERROR_HANDLER);
			}
			if (isset($socket) && !empty($socket)){
				fclose($socket);
			}
			return ($errno == 0);   // Active if errno is 0
		}

		/* Set follow mode */
		function setFollowMode($followMode) {
			$this->followMode = $followMode;
		}

		/* Set if Nofollow flag should be respected */
		function setObeyNoFollow($obeyNoFollow) {
			$this->obeyNoFollow = $obeyNoFollow;
		}

		/* Set if Noindex flag should be respected */
		function setObeyNoIndex($obeyNoIndex) {
			$this->obeyNoIndex = $obeyNoIndex;
		}

		/* Set page limit for site */
		function setPageLimit($limit) {
			$this->pageLimit = $limit;
		}

		/* Set if robots.txt should be respected */
		function setObeyRobotsTxt($obeyRobotsTxt) {
			$this->obeyRobotsTxt = $obeyRobotsTxt;
		}

		/* set traffic limit for site */
		function setTrafficLimit($limit) {
			$this->trafficLimit = $limit;
		}

		/* Returns URL build of URL-componenets */
		static function unparseUrl($parsedUrl) {
			$scheme   = isset($parsedUrl['scheme']) ? $parsedUrl['scheme'].'://' : '';
			$host     = isset($parsedUrl['host']) ? $parsedUrl['host'] : '';
			$port     = isset($parsedUrl['port']) ? ':'.$parsedUrl['port'] : '';
			$user     = isset($parsedUrl['user']) ? $parsedUrl['user'] : '';
			$pass     = isset($parsedUrl['pass']) ? ':'.$parsedUrl['pass']  : '';
			$pass     = ($user || $pass) ? "$pass@" : '';
			$path     = isset($parsedUrl['path']) ? $parsedUrl['path'] : '';
			if (substr($path, 0, 1) != '/'){
				$path = '/'.$path;
			}
			$query    = isset($parsedUrl['query']) ? '?'.$parsedUrl['query'] : '';
			$fragment = isset($parsedUrl['fragment']) ? '#'.$parsedUrl['fragment'] : '';
			return "$scheme$user$pass$host$port$path$query$fragment";
		}

		/* Returns TRUE if URL exists */
		function urlExists($url) {
			$headers = @get_headers($url, 1);
			if (isset($headers) && !empty($headers)) {
				$failures = array(
					'HTTP/1.1 404 Not Found'
				,	'HTTP/1.1 503 Service Unavailable'
				);
				return (!in_array($headers[0], $failures));
			}
			return FALSE;
		}

		/* initialize crawler */
		function __construct($site) {
			$this->processStartTime = time();
			
			//---- Connect to Selenium server and open firefox ----
			if (self::seleniumIsActive()){
				$capabilities = array(WebDriverCapabilityType::BROWSER_NAME => 'firefox');
				$this->seDriver = new RemoteWebDriver(self::seleniumHost(), $capabilities);
				
				//---- Login if necessary ----
				if ($site['LoginActive']){
					$this->seDriver = CrawlerLogin::login($this->seDriver, $site);
				}
				
				$this->rootUrl = $site['URL'];
				self::addLink($site['URL']);
				self::fetchRobots();
			}
			$this->runTime += time() - $this->processStartTime;
		}
		
		function __destruct(){
			if (isset($this->seDriver)){
				$this->seDriver->close();
				$this->seDriver->quit();
			}
		}
		
	}
?>