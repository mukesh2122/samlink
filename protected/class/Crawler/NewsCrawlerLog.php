<?php
	/**************************************
	  NewsCrawlerLog
	  Log crawler events to nw_crawlerlog
	**************************************/
	class NewsCrawlerLog {
		public $ID_LOG;

		public function done($report){
			$log = new GlCrawlerLog;
			$log->ID_LOG = $this->ID_LOG;
			$log->LogStatus = 'done';
			$log->LogReport = "Report summary\n"
			.	"Sites crawled: ".$report['sites']."\n"
			.	"Data received: ".round($report['bytesReceived']/(1024*1024))." MB\n"
			.	"Pages received: ".$report['filesReceived']."\n"
			.	"Links followed: ".$report['linksFollowed']."\n"
			.	"Links found: ".$report['linksFound']."\n"
			.	"Run time: ".NewsCrawler::dhms($report['runTime'])."\n"
			.	"Process time: ".NewsCrawler::dhms($report['processTime']);
			$log->update();
		}

		public function failure($text){
			$log = new GlCrawlerLog;
			$log->ID_LOG = $this->ID_LOG;
			$log->LogStatus = 'failure';
			$log->LogReport = $text;
			$log->update();
		}
		
		public function update($headline, $siteUrl){
			$log = new GlCrawlerLog;
			$log->ID_LOG = $this->ID_LOG;
			$log->LogStatus = 'running';
			$log->LogReport = "Headline: $headline\nSite Url: $siteUrl";
			$log->update();
		}

		function __construct(){
			$log = new GlCrawlerLog;
			$log->LogStatus = 'started';
			$log->LogReport = 'NewsCrawler started';
			$this->ID_LOG = $log->insert();
		}

	}
?>
