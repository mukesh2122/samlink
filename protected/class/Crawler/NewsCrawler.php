<?php
	/********************************************
	  NewsCrawler
	  Extends MultiCrawler with News specifics
	********************************************/
	class NewsCrawler extends MultiCrawler {
		public $newsCrawlerLog;
		public $publishCrawlerFindings = false;
		public $sitesTable;
		public $sites = array();
		public $owners = array();

		/* Returns days hours:mins:seconds for time in seconds */
		public static function dhms($time) {
			$seconds = $time % 60;
			$mins  = floor($time / 60) % 60;
			$hours = floor($time / 60 / 60) % 24;
			$days  = floor($time / 60 / 60 / 24);
			return sprintf("%dd %02d:%02d:%02d", $days, $hours, $mins, $seconds);
		}

//		function createUpdateURL($name, $type, $id, $langID = 1) {
//			$name = self::generateUrl($name, $type, $id, $langID);
//			if ($name !== TRUE) {
//				$url = new GlUrl();
//				$url->OwnerType = $type;
//				$url->ID_OWNER = $id;
//				$url->URL = $name;
//				$url->ID_LANGUAGE = $langID;
//				$url->insert();
//			}
//		}

		/* Return id, ownerType for newsParts */
		function fetchOwner($newsParts) {
			//---- find owner in headline or introtext ----
			foreach (array('Headline', 'IntroText') as $headerType) {
				foreach (array('company', 'game') as $ownerType) {
					if (isset($this->owner[$ownerType])) {
						foreach ($this->owner[$ownerType] as $id => $owner) {
							if (stripos($newsParts[$headerType], $owner) !== FALSE) {
								return array($id, $ownerType);   //<--- owner found!!! return(id_owner, ownertype)
							}
						}
					}
				}
			}
			//---- owner not found in headline or introtext, try in news text ----
			$max = array(
			  'count'     => 0
			, 'ownerType' => 'company'
			, 'idOwner'   => 1
			);
			foreach (array('company', 'game') as $ownerType) {
				foreach ($this->owner[$ownerType] as $idOwner => $owner) {
					$count = substr_count($newsParts['NewsText'], $owner);
					if ($count > $max['count']) {     // grab the owner with most meansioned name
						$max['count'] = $count;
						$max['ownerType'] = $ownerType;
						$max['idOwner'] = $idOwner;
					}
				}
			}
			return array($max['idOwner'], $max['ownerType']);
		}

		/* Fetch owner translation tables */
		function fetchOwnerTranslationTable() {
			$Companies = new GlCompanies();
			$result = $Companies->find(array('select' => 'ID_COMPANY, CompanyName', 'asArray' => TRUE));
			foreach ($result as $row) {
				$this->owner['company'][$row['ID_COMPANY']] = utf8_encode($row['CompanyName']);   // store company name as utf8 encoded
			}

			$games = new GlGames();
			$result = $games->find(array('select' => 'ID_GAME, GameName', 'asArray' => TRUE));
			foreach ($result as $row) {
				$this->owner['game'][$row['ID_GAME']] = utf8_encode($row['GameName']);            // store game name as utf8 encoded
			}
		}

//		function generateUrl($url, $urlType, $posterID = 0, $langID = 1){
//			//Convert accented characters, and remove parentheses and apostrophes
//			$from = explode(',', "ą,č,ę,ė,į,š,ų,ū,ž,ç,æ,œ,á,é,í,ó,ú,à,è,ì,ò,ù,ä,ë,ï,ö,ü,ÿ,â,ê,î,ô,û,å,e,i,ø,u,(,),[,],'");
//			$to   = explode(',', 'a,c,e,e,i,s,u,u,z,c,ae,oe,a,e,i,o,u,a,e,i,o,u,a,e,i,o,u,y,a,e,i,o,u,a,e,i,o,u,,,,,,');
//			//Do the replacements, and convert all other non-alphanumeric characters to spaces
//			$url = strtolower($url);
//			$url = preg_replace('~[^\w\d]+~', '-', str_replace($from, $to, trim($url)));
//			//Remove a - at the beginning or end and make lowercase
//			$url = substr(preg_replace('/^-/', '', preg_replace('/-$/', '', $url)), 0, 180);
//
//			$glUrl = new GlUrl();
//			$glUrl->OwnerType = $urlType;
//			$glUrl->ID_OWNER = $posterID;
//			$glUrl->ID_LANGUAGE = $langID;
//			$glUrl = $glUrl->getOne();
//
//			//if url not exists
//			if (!$glUrl){
//				for ($i = 0; $i < 1000; $i++){
//					$glUrl = new GlUrl();
//					$glUrl->OwnerType = $urlType;
//					$turl = $url;
//					if ($i > 0) {
//						$turl = $url . $i;
//					}
//					$glUrl->URL = $turl;
//					$glUrl->ID_LANGUAGE = $langID;
//					$glUrl = $glUrl->getOne();
//					if (!$glUrl){
//						$url = $turl;
//						break;
//					}
//				}
//			}
//			else {
//				//if url exists, check if nothing changed and if changed generate new and delete old
//				if ($glUrl->URL != $url) {
//					$glUrl->delete();
//					for ($i = 0; $i < 1000; $i++){
//						$glUrl = new GlUrl();
//						$glUrl->OwnerType = $urlType;
//						$turl = $url;
//						if ($i > 0) {
//							$turl = $url . $i;
//						}
//						$glUrl->URL = $turl;
//						$glUrl->ID_LANGUAGE = $langID;
//						$glUrl = $glUrl->getOne();
//						if (!$glUrl) {
//							$url = $turl;
//							break;
//						}
//					}
//				}
//				else {
//					return TRUE;
//				}
//			}
//			return $url;
//		}

		/* Return list of active external sites to be crawled */
		function getAllActiveSitesArray() {
			return $this->sitesTable->find(array(
				'where'   => 'isActive=1 AND isInternal=0'
			,	'asArray' => TRUE
			));
		}

		/* Inherited document handler, called from Crawler */
		function handleDocument($docInfo) {
			$news_url = array(
				'#/(\w+(-|$)){2,}#'   // match '/title-of-article', more than 1 word
			,	'#release#'          // match 'release' in URL
			);
			if (isset($docInfo['source']) && strlen($docInfo['source']) > 0) {   // is content received?
				foreach ($news_url as $exp) {                                    // avoid noise, only analyse content of news urls
					if (preg_match($exp, $docInfo['url'])) {
						$articles = self::readArticles($docInfo);                // read articles from DocInfo
						self::storeArticles($docInfo['crawlerID'], $articles);   // store them in database
						break;                                                   // -and skip
					}
				}
			}
		}

		/* Retrive settings from sy_settings */
		function initSySettings() {
			$settings = new GlSettings();
			$result = $settings->find(array('select' => 'ID_SETTING, ValueBool, ValueInt', 'where' => 'ID_SETTING LIKE "Nw%"', 'asArray' => TRUE));
			foreach ($result as $row) {
				switch(strtolower($row['ID_SETTING'])) {
				case 'nwfollowmode':
					$this->setFollowMode($row['ValueInt']);
					break;
				case 'nwobeynofollow':
					$this->setObeyNoFollow($row['ValueBool']);
					break;
				case 'nwobeynoindex':
					$this->setObeyNoIndex($row['ValueBool']);
					break;
				case 'nwobeyrobotstxt':
					$this->setObeyRobotsTxt($row['ValueBool']);
					break;
				case 'nwpagelimit':
					$this->setPageLimit($row['ValueInt']);
					break;
				case 'nwprocesstimelimit':
					$this->setProcessTimeLimit($row['ValueInt']);
					break;
				case 'nwpublishcrawlerfindings':
					$this->setPublishCrawlerFindings($row['ValueBool']);
					break;
				case 'nwscaninterval':
					$this->setScanInterval($row['ValueInt']);
					break;
				case 'nwsitepagelimit':
					$this->setSitePageLimit($row['ValueInt']);
					break;
				case 'nwsitetrafficlimit':
					$this->setSiteTrafficLimit($row['ValueInt']);
					break;
				case 'nwtrafficlimit':
					$this->setTrafficLimit($row['ValueInt']);
					break;
				}
			}
		}

		/* Returns TRUE if article is new */
		function isNewArticle($article) {
			$itemlocale = new GlItemLocale();
			$result = $itemlocale->count(array('where' => 'URL="'.addslashes(utf8_decode($article['URL'])).'"'));
			return ($result == 0);
		}

		/* Decode articles in DocInfo */
		function readArticles($docInfo) {
		$articles = array();
			$html = str_get_html($docInfo['source']);
			foreach ($html->find($this->sites[$docInfo['crawlerID']]['DomArticle']) as $article) {
				$newsParts = array(
				  'ID_OWNER'  => ''
				, 'OwnerType' => ''
				, 'Headline'  => ''
				, 'IntroText' => ''
				, 'NewsText'  => ''
				, 'URL'       => $docInfo['url']
				, 'Published' => $this->publishCrawlerFindings ? 1 : 0
				);
				foreach ($article->find($this->sites[$docInfo['crawlerID']]['DomHeadline']) as $headline) {
					$newsParts['Headline'] .= $headline->plaintext;
				}
				foreach ($article->find($this->sites[$docInfo['crawlerID']]['DomIntrotext']) as $introtext) {
					$newsParts['IntroText'] .= $introtext->plaintext;
				}
				foreach ($article->find($this->sites[$docInfo['crawlerID']]['DomNewstext']) as $newstext) {
					$newsParts['NewsText'] .= $newstext;
				}

				//---- save article if it is new, has headline or introtext, and newstext>100b ----
				if (($newsParts['Headline'] || $newsParts['IntroText']) && strlen($newsParts['NewsText']) > 100) {
					$this->newsCrawlerLog->update($newsParts['Headline'], $this->sites[$docInfo['crawlerID']]['URL']);
					if (self::isNewArticle($newsParts)) {
						list($newsParts['ID_OWNER'],$newsParts['OwnerType']) = self::fetchOwner($newsParts);
						$articles[] = $newsParts;
					}
				}
			}
			$html->clear();
			unset($html);
			return $articles;
		}

		/* Extends MultiCrawler::run() */
		function run() {
			parent::run();
			$report = $this->report();
			$output  = '<table>';
			$output .= '<tr><td>Report summary</td></tr>';
			$output .= '<tr><td>Sites crawled:</td><td>'.$report['sites'].'</td></tr>';
			$output .= '<tr><td>Data received:</td><td>'.round($report['bytesReceived']/(1024*1024)).' MB</td></tr>';
			$output .= '<tr><td>Pages received:</td><td>'.$report['filesReceived'].'</td></tr>';
			$output .= '<tr><td>Links followed:</td><td>'.$report['linksFollowed'].'</td></tr>';
			$output .= '<tr><td>Links found:</td><td>'.$report['linksFound'].'</td></tr>';
			$output .= '<tr><td>Run time:</td><td>'.self::dhms($report['runTime']).'</td></tr>';
			$output .= '<tr><td>Process time:</td><td>'.self::dhms($report['processTime']).'</td></tr>';
			$output .= '</table>';
			echo $output;
			$this->newsCrawlerLog->done($report);
		}

		/* Set PublishCrawlerFinding flag */
		function setPublishCrawlerFindings($publishCrawlerFindings) {
			$this->publishCrawlerFindings = $publishCrawlerFindings;
		}

		/* Store articles in nw_tables */
		function storeArticles($crawlerID, $articles) {   // store articles into database
			$now = new DooDbExpression('UNIX_TIMESTAMP()');
			foreach ($articles as $article) {
				foreach ($article as $key => $value) {  // convert fields for database
					$article[$key] = addslashes(utf8_decode($value));
				}

				$items = new GlItems();
				$items->ID_OWNER  = $article['ID_OWNER'];
				$items->ID_SITE   = $this->sites[$crawlerID]['ID_SITE'];
				$items->OwnerType = $article['OwnerType'];
				$items->PostingTime      = $now;
				$items->LastActivityTime = $now;
				$items->LastUpdatedTime  = $now;
				$items->Published = $article['Published'];
				$id_news = $items->insert();

				$itemlocale = new GlItemLocale();
				$itemlocale->ID_NEWS     = $id_news;
				$itemlocale->ID_LANGUAGE = $this->sites[$crawlerID]['ID_LANGUAGE'];
				$itemlocale->Headline    = $article['Headline'];
				$itemlocale->IntroText   = $article['IntroText'];
				$itemlocale->NewsText    = $article['NewsText'];
				$itemlocale->URL         = $article['URL'];
				$itemlocale->PostingTime      = $now;
				$itemlocale->LastActivityTime = $now;
				$itemlocale->LastUpdatedTime  = $now;
				$itemlocale->Published   = $article['Published'];
				$itemlocale->EditorNote  = '';
				$itemlocale->insert();

//				self::createUpdateURL($id_news, URL_NEWS, $id_news, $this->sites[$crawlerID]['ID_LANGUAGE']);   // (URL, OwnerType, ID_OWNER, ID_LANGUAGE)

				$this->sitesTable->LastUpdateTime = $now;
				$this->sitesTable->update(array('where' => 'ID_SITE='.$this->sites[$crawlerID]['ID_SITE']));
			}
		}

		/* Initialize NewsCrawler */
		function __construct() {
			set_time_limit(0);
			Doo::db()->reconnect('news');
			$this->newsCrawlerLog = new NewsCrawlerLog;
			if (Crawler::seleniumIsActive()){
				$this->sitesTable = new GlSites();
				$this->sitesTable->purgeCache();
				$this->sites = self::getAllActiveSitesArray();
				parent::__construct($this->sites);
				self::initSySettings();
				self::fetchOwnerTranslationTable();
				self::addUrlFilterRule('#xml$# i');
				self::addUrlFilterRule('#^(javascript|https|mailto)# i');
				self::addUrlFilterRule('#log.*out# i');   // avoid crawling of logout page
			}
			else {
				$errorText = 'Selenium server is not available on host: '.Crawler::seleniumHost();
				$this->newsCrawlerLog->failure($errorText);
				echo $errorText;
				exit;
			}
		}
		
		function __destruct(){
			Doo::db()->reconnect(Doo::conf()->APP_MODE);
		}
	}
?>
