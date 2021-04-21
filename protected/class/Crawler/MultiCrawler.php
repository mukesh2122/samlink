<?php
	/**********************************
	  MultiCrawler
	  using one Crawler per site
	**********************************/
	abstract class MultiCrawler {
		public $processStartTime;       // Start time for crawling process
		public $crawlers = array();     // Individual crawlers
		public $scanInterval = 30;      // Scanning interval in sec
		public $trafficLimit = 0;       // Max number of bytes to receive
		public $pageLimit = 0;          // Max number of pages/files to receive
		public $processTimeLimit = 0;   // Max crawling time in sec

		/* Add URL to URL filer for all crawlers */
		function addUrlFilterRule($regexp) {
			foreach ($this->crawlers as $crawler) {
				$crawler->addUrlFilterRule($regexp);
			}
		}

		/* Abstract function to handle received document */
		abstract function handleDocument($docInfo);

		/* Returns statistical information report */
		function report() {
			$sites = 0;
			$bytesReceived = 0;
			$filesReceived = 0;
			$linksFollowed = 0;
			$linksFound    = 0;
			$runTime       = 0;
			foreach ($this->crawlers as $crawler) {
				++$sites;
				$report = $crawler->report();
				$bytesReceived += $report['bytesReceived'];
				$filesReceived += $report['filesReceived'];
				$linksFollowed += $report['linksFollowed'];
				$linksFound    += $report['linksFound'];
				$runTime       += $report['runTime'];
			}
			$processTime = time() - $this->processStartTime;
			return array(
			  'sites' => $sites
			, 'bytesReceived' => $bytesReceived
			, 'filesReceived' => $filesReceived
			, 'linksFollowed' => $linksFollowed
			, 'linksFound'    => $linksFound
			, 'runTime'       => $runTime
			, 'processTime'   => $processTime
			);
		}

		/* cycle through all crawlers until no new page is received */
		function run() {
			do {
				$scanStartTime = time();
				$bytesReceived = 0;
				$filesReceived = 0;
				$done = TRUE;
				foreach ($this->crawlers as $crawlerID => $crawler) {
//					echo __LINE__.": Crawler - ".$crawler->rootUrl."<br />";
					$docInfo = $crawler->next();
					$docInfo['crawlerID'] = $crawlerID;
					$this->handleDocument($docInfo);
					$report = $crawler->report();
					$bytesReceived += $report['bytesReceived'];
					$filesReceived += $report['filesReceived'];
					if ($done && isset($docInfo['source'])) {   // Clear done flag if source still received;
						$done = !$docInfo['source'];
					}
				}

				$done = ($done
				     || ($this->trafficLimit > 0 && $bytesReceived >= $this->trafficLimit)
				     || ($this->pageLimit > 0 && $filesReceived >= $this->pageLimit)
				     || ($this->processTimeLimit > 0 && (time() - $this->processStartTime) >= $this->processTimeLimit)
					 );

				if (!$done) {
					$timeToSleep = $this->scanInterval - (time() - $scanStartTime);
					if ($timeToSleep > 0) {
						sleep($timeToSleep);
					}
				}
			} while (!$done);   // Repeat as long as page is received
		}

		/* Set follow mode for all crawlers */
		function setFollowMode($followMode) {
			foreach ($this->crawlers as $crawler) {
				$crawler->setFollowMode($followMode);
			}
		}

		/* Set ObeyNoFollow for all crawlers */
		function setObeyNoFollow($ObeyNoFollow) {
			foreach ($this->crawlers as $crawler) {
				$crawler->setObeyNoFollow($ObeyNoFollow);
			}
		}

		/* Set ObeyNoIndex for all crawlers */
		function setObeyNoIndex($ObeyNoIndex) {
			foreach ($this->crawlers as $crawler) {
				$crawler->setObeyNoIndex($ObeyNoIndex);
			}
		}

		/* Set obeyRobots for all crawlers */
		function setObeyRobotsTxt($obeyRobotsTxt) {
			foreach ($this->crawlers as $crawler) {
				$crawler->setObeyRobotsTxt($obeyRobotsTxt);
			}
		}

		/* Set total page limit for all sites */
		function setPageLimit($limit) {
			$this->pageLimit = $limit;
		}

		/* Set total time limit all sites */
		function setProcessTimeLimit($limit) {
			$this->processTimeLimit = $limit;
		}

		/* Set scanning interval */
		function setScanInterval($interval) {
			$this->scanInterval = $interval;
		}

		/* Set page limit per site */
		function setSitePageLimit($limit) {
			foreach($this->crawlers as $crawler) {
				$crawler->setPageLimit($limit);
			}
		}

		/* Set traffic limit per site */
		function setSiteTrafficLimit($limit) {
			foreach($this->crawlers as $crawler) {
				$crawler->setTrafficLimit($limit);
			}
		}

		/* Set total traffic limit for all sites */
		function setTrafficLimit($limit) {
			$this->trafficLimit = $limit;
		}

		//---- Initialize all crawlers ----
		function __construct($sites) {
			$this->processStartTime = time();
			foreach ($sites as $site) {
				$this->crawlers[] = new Crawler($site);
			}
		}

	}
?>