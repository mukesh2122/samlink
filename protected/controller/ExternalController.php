
<?php

class ExternalController extends SnController {

	public function generateUrl()
	{
//		exit;
		set_time_limit(0);
		$url = new SnUrl();
		Doo::db()->query("TRUNCATE {$url->_table}");
		echo "All URL deleted <br/>";
		//generate news items
		echo "Starting News<br/>";
//		$items = Doo::db()->find('NwItems');
		$nlocale = new NwItemLocale;
		$nitems = new NwItems;
		$params['NwItemLocale'] = array(
			'select' => "{$nitems->_table}.*, {$nlocale->_table}.*", //, {$locale->_table}.Headline as THeadline, {$locale->_table}.NewsText as TNewsText, {$locale->_table}.ID_LANGUAGE as TID
			'asc' => "{$nitems->_table}.ID_NEWS",
			'where' => "{$nitems->_table}.isInternal = 0 AND ".
					   "{$nitems->_table}.Published = 1 AND ".
					   "{$nlocale->_table}.Published = 1 AND ".
					   "{$nitems->_table}.OwnerType <> 'group'",
			'joinType' => 'LEFT',
		);

		$items = Doo::db()->relateMany('NwItems', array('NwItemLocale'), $params);
		$num = 0;
		if (!empty($items))
		{
			foreach ($items as $item)
			{
				foreach ($item->NwItemLocale as $locale)
				{
					Url::createUpdateURL($locale->Headline, URL_NEWS, $item->ID_NEWS, $locale->ID_LANGUAGE);
					$num++;
				}
			}
		}
		echo "News URL generated: {$num} <br/>";

		echo "Starting Groups<br/>";
		$items = Doo::db()->find('SnGroups');
		$num = 0;
		if (!empty($items)) {
			foreach ($items as $item)
			{
				Url::createUpdateURL($item->GroupName, URL_GROUP, $item->ID_GROUP);
				$num++;
			}
		}
		echo "Groups URL generated: {$num} <br/>";

		echo "Starting Companies<br/>";
		$items = Doo::db()->find('SnCompanies');
		$num = 0;
		if (!empty($items))
		{
			foreach ($items as $item)
			{
				Url::createUpdateURL($item->CompanyName, URL_COMPANY, $item->ID_COMPANY);
				$num++;
			}
		}
		echo "COMPANY URL generated: {$num} <br/>";

		echo "Starting Games<br/>";
		$items = Doo::db()->find('SnGames');
		$num = 0;
		if (!empty($items))
		{
			foreach ($items as $item)
			{
				Url::createUpdateURL($item->GameName, URL_GAME, $item->ID_GAME);
				$num++;
			}
		}
		echo "GAME URL generated: {$num} <br/>";

		echo "Starting Platforms<br/>";
		$items = Doo::db()->find('SnPlatforms');
		$num = 0;
		if (!empty($items))
		{
			foreach ($items as $item)
			{
				Url::createUpdateURL($item->PlatformName, URL_PLATFORM, $item->ID_PLATFORM);
				$num++;
			}
		}
		echo "Platforms URL generated: {$num} <br/>";

		Doo::cache()->flushAll();
	}

	public function clearCache() {
		echo "Clearing cache<br>";
		Doo::cache()->flushAll();
		Doo::cache('apc')->flushAll();
		echo "Cache cleared";
	}

	public function generateNewsPriorities() {
		set_time_limit(0);
		echo "Generating news ratings <br/>";
		$news = new News();
		$nwItems = new NwItems();
		$total = $news->getNewsTotal();
		$items = array();
		//not to loop forever
		if ($total > 10) {
			$days = 1;
			while (count($items) != 10) {
				$query = "SELECT ID_NEWS, RatingTop, RatingPop, (ShowCount+LikeCount+DislikeCount) as SocialSort from {$nwItems->_table} WHERE isInternal=0 AND PostingTime >= " . (time() - ($days * 24 * 3600 )) . " order by ShowCount desc, Replies desc, PostingTime desc, SocialSort desc limit 10";
				$q = Doo::db()->query($query);
				$items = $q->fetchAll(PDO::FETCH_CLASS, 'NwItems');
				$days++;
			}

			$topIds = array();
			foreach ($items as &$item) {
				$topIds[] = $item->ID_NEWS;
			}

			$query = "SELECT ID_NEWS, RatingTop, RatingPop, (ShowCount+LikeCount+DislikeCount) as SocialSort from {$nwItems->_table} WHERE isInternal=0 AND ID_NEWS NOT IN('" . implode("','", $topIds) . "') order by ShowCount desc, Replies desc, PostingTime desc, SocialSort desc limit 10";
			$q = Doo::db()->query($query);
			$itemsAdd = $q->fetchAll(PDO::FETCH_CLASS, 'NwItems');
			$items = array_merge($items, $itemsAdd);
		} else {
			$query = "SELECT ID_NEWS, RatingTop, RatingPop, (ShowCount+LikeCount+DislikeCount) as SocialSort from {$nwItems->_table} WHERE isInternal=0 order by ShowCount desc, Replies desc, PostingTime desc, SocialSort desc ";
			$q = Doo::db()->query($query);
			$items = $q->fetchAll(PDO::FETCH_CLASS, 'NwItems');
		}

		if (!empty($items)) {
			$total = count($items);
			$cnt = 0;
			$ratingTop = 5;
			$ratingPop = 5;
			foreach ($items as &$item) {
				$item->Featured = $total;
				if ($cnt < 5) {
					$item->isPopular = 0;
					if ($item->RatingTop < $ratingTop) {
						$item->RatingTop = $ratingTop;
					}

					$ratingTop--;
				} elseif ($cnt >= 5 and $cnt < 10) {
					$item->isPopular = 1;
					if ($item->RatingPop < $ratingPop) {
						$item->RatingPop = $ratingPop;
					}
					$ratingPop--;
				} else {
					$item->isPopular = 2;
				}
				$item->update(array('field' => 'Featured,isPopular,RatingTop,RatingPop'));
				$total--;
				$cnt++;
			}
		}

		echo "Generating platform ratings <br/>";
		$platformArray = array();
		$platformObj = new SnPlatforms();
		$query = "SELECT * from {$platformObj->_table}";
		$q = Doo::db()->query($query);
		$items = $q->fetchAll(PDO::FETCH_CLASS, 'SnPlatforms');
		$max = 0;
		if (!empty($items)) {
			$query = "SELECT SUM(ShowCount + ShareCount + LikeCount + DislikeCount) as total from {$nwItems->_table} WHERE isInternal=0 AND ID_PLATFORM = 0 GROUP BY ID_PLATFORM";
			$q = Doo::db()->query($query);
			$totalGeneral = $q->fetchObject('NwItems');
			if (!$totalGeneral) {
				$totalGeneral = 0;
			} else {
				$totalGeneral = $totalGeneral->total;
			}

			foreach ($items as &$item) {
				$query = "SELECT SUM(ShowCount + ShareCount + LikeCount + DislikeCount) as total from {$nwItems->_table} WHERE isInternal=0 AND ID_PLATFORM = {$item->ID_PLATFORM} GROUP BY ID_PLATFORM";
				$q = Doo::db()->query($query);
				$total = $q->fetchObject('NwItems');
				if ($total) {
					$item->totalScore = $total->total + $totalGeneral;
					if ($max < $item->totalScore) {
						$max = $item->totalScore;
					}
				} else {
					$item->totalScore = $totalGeneral;
				}
			}
			$starScore = $max / 5;
			foreach ($items as &$item) {
				if($starScore == 0) {
					$stars = 0;
				} else {
					if($item->NewsCount == 0) {
						$stars = 0;
					} else {
						$stars = abs(round(($item->totalScore / $starScore) - 0.3, 0));
					}
				}

				$item->RatingCur = $stars;
				$item->update(array('field' => 'RatingCur'));
			}
		}
		echo "Generating company ratings <br/>";
		$companyObj = new SnCompanies();
		$query = "UPDATE {$companyObj->_table} SET NewsCurrentTop = 0 WHERE NewsCurrentTop > 0";
		$q = Doo::db()->query($query);

		$max = 0;
		if (!empty($items)) {
			$query = "SELECT ID_OWNER, SUM(ShowCount + ShareCount + LikeCount + DislikeCount) as total from {$nwItems->_table} WHERE isInternal=0 AND OwnerType = '" . POSTRERTYPE_COMPANY . "' GROUP BY ID_OWNER ORDER BY total DESC";
			$q = Doo::db()->query($query);
			$news = $q->fetchAll(PDO::FETCH_CLASS, 'NwItems');

			foreach ($news as &$item) {
				$item->totalScore = $item->total;
				if ($max < $item->totalScore) {
					$max = $item->totalScore;
				}
			}
			$starScore = $max / 5;
			if ($starScore == 0) {
				$starScore = 1;
			}

			$maxTop = 5;
			foreach ($news as &$item) {
				$stars = abs(round(($item->totalScore / $starScore) - 0.3, 0));
				$query = "SELECT * from {$companyObj->_table} WHERE ID_COMPANY = {$item->ID_OWNER}";
				$q = Doo::db()->query($query);
				$company = $q->fetchObject('SnCompanies');
				if ($company) {
					$update = false;
					if ($company->NewsCurrentTop < $maxTop) {
						$company->NewsCurrentTop = $maxTop;
						$update = true;
					}
					if ($company->NewsHistoryTop < $maxTop) {
						$company->NewsHistoryTop = $maxTop;
						$update = true;
					}
					if ($update == true)
						$company->update(array('field' => 'NewsCurrentTop,NewsHistoryTop'));

					$maxTop--;
				}
			}
		}

		echo "Generating game ratings <br/>";
		$gameObj = new SnGames();
		$query = "UPDATE {$gameObj->_table} SET NewsCurrentTop = 0 WHERE NewsCurrentTop > 0";
		$q = Doo::db()->query($query);

		$max = 0;
		if (!empty($items)) {
			$query = "SELECT ID_OWNER, SUM(ShowCount + ShareCount + LikeCount + DislikeCount) as total from {$nwItems->_table} WHERE isInternal=0 AND OwnerType = '" . POSTRERTYPE_GAME . "' GROUP BY ID_OWNER ORDER BY total DESC";
			$q = Doo::db()->query($query);
			$news = $q->fetchAll(PDO::FETCH_CLASS, 'NwItems');

			foreach ($news as &$item) {
				$item->totalScore = $item->total;
				if ($max < $item->totalScore) {
					$max = $item->totalScore;
				}
			}
			$starScore = $max / 5;
			if ($starScore == 0) {
				$starScore = 1;
			}

			$maxTop = 5;
			foreach ($news as &$item) {
				$stars = abs(round(($item->totalScore / $starScore) - 0.3, 0));
				$query = "SELECT * from {$gameObj->_table} WHERE ID_GAME = {$item->ID_OWNER}";
				$q = Doo::db()->query($query);
				$game = $q->fetchObject('SnGames');
				if ($game) {
					$update = false;
					if ($game->NewsCurrentTop < $maxTop) {
						$game->NewsCurrentTop = $maxTop;
						$update = true;
					}
					if ($game->NewsHistoryTop < $maxTop) {
						$game->NewsHistoryTop = $maxTop;
						$update = true;
					}
					if ($update == true)
						$game->update(array('field' => 'NewsCurrentTop,NewsHistoryTop'));

					$maxTop--;
				}
			}
		}
	}

	public function generateRatings() {
		echo "Generating company top ratings <br/>";
		$companyObj = new SnCompanies();
		$company = new Companies();
		$top = new SnLogtop();

		$query = "UPDATE {$companyObj->_table} SET CurrentPop = 0, CurrentTop = 0 WHERE 1";
		$q = Doo::db()->query($query);

		$query = "SELECT ID_OWNER, SUM(NewsCount + MessageCount + GameCount + DownloadCount + EventCount) as total FROM {$top->_table}
				  WHERE
					OwnerType = 'company'
					AND LogDate >= " . date("Y-m-d", (time() - 604800)) . "
					GROUP BY ID_OWNER
					ORDER BY total DESC
					LIMIT 5";
		$q = Doo::db()->query($query);
		$items = $q->fetchAll(PDO::FETCH_CLASS, 'SnLogtop');
		$max = 5;
		if (!empty($items)) {

			foreach ($items as $item) {
				$query = "SELECT * from {$companyObj->_table} WHERE ID_COMPANY = {$item->ID_OWNER}";
				$q = Doo::db()->query($query);
				$company = $q->fetchObject('SnCompanies');

				if ($company) {
					$update = false;
					if ($company->HistoryTop < $max) {
						$company->HistoryTop = $max;
						$update = true;
					}
					if ($company->CurrentTop < $max) {
						$company->CurrentTop = $max;
						$update = true;
					}
					if ($update == true)
						$company->update(array('field' => 'CurrentTop,HistoryTop'));

					$max--;
				}
			}
		}

		echo "Generating company pop ratings <br/>";
		$companyObj = new SnCompanies();
		$top = new SnLogpop();
		$query = "SELECT ID_OWNER, SUM(NewsReadCount + NewsCommentCount + NewsLikeCount + ItemLikeCount + NewsShareCount + ItemShareCount + DownloadCount) as total FROM {$top->_table}
				  WHERE
					OwnerType = 'company'
					AND LogDate >= " . date("Y-m-d", (time() - 604800)) . "
					GROUP BY ID_OWNER
					ORDER BY total DESC";
		$q = Doo::db()->query($query);
		$items = $q->fetchAll(PDO::FETCH_CLASS, 'SnLogpop');

		$max = 5;
		if (!empty($items)) {

			foreach ($items as $item) {
				$query = "SELECT * from {$companyObj->_table} WHERE ID_COMPANY = {$item->ID_OWNER}";
				$q = Doo::db()->query($query);
				$company = $q->fetchObject('SnCompanies');
				if ($company) {
					if ($company->HistoryPop < $max) {
						$company->HistoryPop = $max;
						$update = true;
					}
					if ($company->CurrentPop < $max) {
						$company->CurrentPop = $max;
						$update = true;
					}
					if ($update == true)
						$company->update(array('field' => 'CurrentPop,HistoryPop'));

					$max--;
				}
			}
		}

		echo "Generating game top ratings <br/>";
		$gameObj = new SnGames();
		$game = new Games();
		$top = new SnLogtop();

		$query = "UPDATE {$gameObj->_table} SET CurrentPop = 0, CurrentTop = 0 WHERE 1";
		$q = Doo::db()->query($query);

		$query = "SELECT ID_OWNER, SUM(NewsCount + MessageCount + GameCount + DownloadCount + EventCount) as total FROM {$top->_table}
				  WHERE
					OwnerType = 'game'
					AND LogDate >= " . date("Y-m-d", (time() - 604800)) . "
					GROUP BY ID_OWNER
					ORDER BY total DESC
					LIMIT 5";
		$q = Doo::db()->query($query);
		$items = $q->fetchAll(PDO::FETCH_CLASS, 'SnLogtop');
		$max = 5;
		if (!empty($items)) {

			foreach ($items as $item) {
				$query = "SELECT * from {$gameObj->_table} WHERE ID_GAME = {$item->ID_OWNER}";
				$q = Doo::db()->query($query);
				$company = $q->fetchObject('SnGames');

				if ($company) {
					$update = false;
					if ($company->HistoryTop < $max) {
						$company->HistoryTop = $max;
						$update = true;
					}
					if ($company->CurrentTop < $max) {
						$company->CurrentTop = $max;
						$update = true;
					}
					if ($update == true)
						$company->update(array('field' => 'CurrentTop,HistoryTop'));

					$max--;
				}
			}
		}

		echo "Generating game pop ratings <br/>";
		$gameObj = new SnGames();
		$top = new SnLogpop();
		$query = "SELECT ID_OWNER, SUM(NewsReadCount + NewsCommentCount + NewsLikeCount + ItemLikeCount + NewsShareCount + ItemShareCount + DownloadCount) as total FROM {$top->_table}
				  WHERE
					OwnerType = 'game'
					AND LogDate >= " . date("Y-m-d", (time() - 604800)) . "
					GROUP BY ID_OWNER
					ORDER BY total DESC";
		$q = Doo::db()->query($query);
		$items = $q->fetchAll(PDO::FETCH_CLASS, 'SnLogpop');

		$max = 5;
		if (!empty($items)) {

			foreach ($items as $item) {
				$query = "SELECT * from {$gameObj->_table} WHERE ID_GAME = {$item->ID_OWNER}";
				$q = Doo::db()->query($query);
				$company = $q->fetchObject('SnGames');
				if ($company) {
					if ($company->HistoryPop < $max) {
						$company->HistoryPop = $max;
						$update = true;
					}
					if ($company->CurrentPop < $max) {
						$company->CurrentPop = $max;
						$update = true;
					}
					if ($update == true)
						$company->update(array('field' => 'CurrentPop,HistoryPop'));

					$max--;
				}
			}
		}
	}

	public function importGames() {
		set_time_limit(0);
		$player = User::getUser();
		if (!$player or $player->canAccess('Super Admin Interface') !== TRUE) {
			DooUriRouter::redirect(Doo::conf()->APP_URL);
			return false;
		}
		$games = new Games();
		$companies = new Companies();
		$images = new Image();
		$file = fopen(MainHelper::site_url('games_list.csv'), 'r');
		/**
		  [0] => Game Name
		  [1] => Type
		  [2] => Relase date
		  [3] => Developer
		  [4] => Publisher
		  [5] => Describtion
		  [6] => Avatar
		  [7] => platform
		  [8] => game URL
		  [9] => ESRB rating
		 */
		$start = 0;
		$end = 9999;
		$cnt = -1;
		while (!feof($file)) {
			$cnt++;

			$line = array();
			$line = fgetcsv($file, 90000, ';');

			if ($cnt < $start) {
				continue;
			}
			if ($cnt > $end) {
				break;
			}

			$name = trim($line[0]);
			$type = trim($line[1]);
			$relaseDate = date("Y-m-d", strtotime(trim($line[2])));
			$developer = trim($line[3]);
			$publisher = trim($line[4]);
			$description = trim($line[5]);
			$gameImage = trim($line[6]);
			$platforms = explode(",", $line[7]);
			$url = trim($line[8]);
			$esrb = trim($line[9]);

			$gameType = new SnGameTypes();
			$gameType->GameTypeName = $type;
			$gameType = $gameType->getOne();

			$platformIDs = array();
			if (!empty($platforms)) {
				foreach ($platforms as &$platform) {
					$platform = trim($platform);
					$p = new SnPlatforms();
					$p->PlatformName = $platform;
					$p = $p->getOne();

					if ($p) {
						$platformIDs[] = $p->ID_PLATFORM;
					}
				}
			}

			// getting game
			$params = array(
				'select' => "ID_GAME, ImageURL",
				'where' => "GameName = ?",
				'param' => array($name),
				'limit' => 1
			);
			$gameResult = Doo::db()->find('SnGames', $params);
			$params = array(
				'select' => "ID_COMPANY",
				'where' => "CompanyName = ?",
				'param' => array($developer),
				'limit' => 1
			);
			$developerResult = Doo::db()->find('SnCompanies', $params);

			if (!$developerResult) {
				$companyParams['company_name'] = $developer;
				$companyParams['company_type'] = '';
				$companyParams['company_headquarters'] = '';
				$companyParams['company_founded'] = '';
				$companyParams['company_ownership'] = '';
				$companyParams['company_employees'] = '';
				$companyParams['company_url'] = '';
				$companyParams['company_description'] = '';
				$developerResult = $companies->createCompanyInfo($companyParams);
			}

			if ($developer == $publisher) {
				$publisherResult = $developerResult;
			} else {
				$params = array(
					'select' => "ID_COMPANY",
					'where' => "CompanyName = ?",
					'param' => array($publisher),
					'limit' => 1
				);
				$publisherResult = Doo::db()->find('SnCompanies', $params);

				if (!$publisherResult) {
					$companyParams['company_name'] = $publisher;
					$companyParams['company_type'] = '';
					$companyParams['company_headquarters'] = '';
					$companyParams['company_founded'] = '';
					$companyParams['company_ownership'] = '';
					$companyParams['company_employees'] = '';
					$companyParams['company_url'] = '';
					$companyParams['company_description'] = '';
					$publisherResult = $companies->createCompanyInfo($companyParams);
				}
			}

			if (!$gameResult) {
				//import
				$gameParams = array();
				if (strlen($gameImage) > 0) {
					$resultImage = $images->importImage(FOLDER_GAMES, $gameImage);
					if ($resultImage['filename'] != '') {
						$gameParams['image_url'] = ContentHelper::handleContentInput($resultImage['filename']);
					}
				}

				$gameParams['game_name'] = $name;
				$gameParams['game_type'] = !$gameType ? 1 : $gameType->ID_GAMETYPE;
				$gameParams['game_release'] = $relaseDate;
				$gameParams['game_esrb'] = $esrb;
				$gameParams['game_description'] = $description;
				$gameParams['game_url'] = $url;
				$gameParams['platforms'] = $platformIDs;

				$gameParams['developer_id'] = $developerResult->ID_COMPANY;
				$gameParams['distributor_id'] = $publisherResult->ID_COMPANY;

				$result = $games->createGame($gameParams);

				print "Number INSERTED: " . $cnt . "<br/>";
				print "<pre>";
				print_r($gameParams);
				print "</pre>";
			} else {
				$gameParams = array();
				if (strlen($gameImage) > 0) {
					$resultImage = $images->importImage(FOLDER_GAMES, $gameImage, $gameResult->ImageURL);
					if ($resultImage['filename'] != '') {
						$gameParams['image_url'] = ContentHelper::handleContentInput($resultImage['filename']);
					}
				}

				$gameParams['game_name'] = $name;
				$gameParams['game_type'] = !$gameType ? 1 : $gameType->ID_GAMETYPE;
				$gameParams['game_release'] = $relaseDate;
				$gameParams['game_esrb'] = $esrb;
				$gameParams['game_description'] = $description;
				$gameParams['game_url'] = $url;
				$gameParams['platforms'] = $platformIDs;

				$gameParams['developer_id'] = $developerResult->ID_COMPANY;
				$gameParams['distributor_id'] = $publisherResult->ID_COMPANY;

				$result = $games->updateGameInfo($gameResult, $gameParams);

				print "Number UPDATED: " . $cnt . "<br/>";
				print "<pre>";
				print_r($gameParams);
				print "</pre>";
			}
		}
		fclose($file);
		echo "completed";
		exit;
	}

	public function importCompanies() {
		set_time_limit(0);
		$player = User::getUser();
		if (!$player or $player->canAccess('Super Admin Interface') !== TRUE) {
			DooUriRouter::redirect(Doo::conf()->APP_URL);
			return false;
		}
		$companies = new Companies();
		$images = new Image();
		$file = fopen(MainHelper::site_url('companies.csv'), 'r');
		/**
		  [0] => Company Name
		  [1] => Avatar
		  [2] => Founded
		  [3] => Headquaters
		  [4] => Ownership
		  [5] => Employees
		  [6] => Company URL
		  [7] => Company Type
		  [8] => Describtion
		 */
		$lines = array();
		$start = 1;
		$end = 9999;
		$cnt = -1;
		while (!feof($file)) {
			$cnt++;

			$line = array();
			$line = fgetcsv($file, 90000, ';');

			if ($cnt < $start) {
				continue;
			}
			if ($cnt > $end) {
				break;
			}

			$companyName = trim($line[0]);
			$companyImage = trim($line[1]);
			$founded = date("Y-m-d", strtotime(trim($line[2])));
			$headquaters = trim($line[3]);
			$ownership = trim($line[4]);
			$employees = trim($line[5]);
			$url = trim($line[6]);
			$type = trim($line[7]);
			$description = trim($line[8]);

			$params = array(
				'select' => "ID_COMPANY, ImageURL",
				'where' => "CompanyName = ?",
				'param' => array($companyName),
				'limit' => 1
			);
			$companyResult = Doo::db()->find('SnCompanies', $params);

			$params = array(
				'select' => "ID_COMPANYTYPE",
				'where' => "CompanyTypeName = ?",
				'param' => array($type),
				'limit' => 1
			);
			$companyTypeResult = Doo::db()->find('SnCompanyTypes', $params);
			if ($companyTypeResult) {
				$companyTypeID = $companyTypeResult->ID_COMPANYTYPE;
			} else {
				$companyTypeID = 1;
			}

			$companyParams = array();
			$companyParams['company_name'] = $companyName;
			$companyParams['company_type'] = $companyTypeID;
			$companyParams['company_headquarters'] = $headquaters;
			$companyParams['company_founded'] = $founded;
			$companyParams['company_ownership'] = $ownership;
			$companyParams['company_employees'] = $employees;
			$companyParams['company_url'] = $url;
			$companyParams['company_description'] = $description;

			if (!$companyResult) {
				if (strlen($companyImage) > 0) {
					$resultImage = $images->importImage(FOLDER_COMPANIES, $companyImage);
					if ($resultImage['filename'] != '') {
						$companyParams['image_url'] = ContentHelper::handleContentInput($resultImage['filename']);
					}
				}
				$result = $companies->createCompanyInfo($companyParams);
				print "Number INSERTED: " . $cnt . "<br/>";
				print "<pre>";
				print_r($companyParams);
				print "</pre>";
			} else {
				if (strlen($companyImage) > 0 and strlen($companyResult->ImageURL) == 0) {
					$resultImage = $images->importImage(FOLDER_COMPANIES, $companyImage, $companyResult->ImageURL);
					if ($resultImage['filename'] != '') {
						$companyParams['image_url'] = ContentHelper::handleContentInput($resultImage['filename']);
					}
				}

				$result = $companies->updateCompanyInfo($companyResult, $companyParams);
				print "Number UPDATED: " . $cnt . "<br/>";
				print "<pre>";
				print_r($companyParams);
				print "</pre>";

			}
		}
		fclose($file);
		echo 'completed';
		exit;
	}

	public function synchTranslations() {
		/*
		Find new translateable texts in php files and add them to the databases
		*/
		//header('Content-type: text/html; charset=utf-8');
		$player = User::getUser();
		$lang = $this->params['lang'];

		//ONLY English!
		$lang = "EN";
		if (!$player or $player->canAccess('Super Admin Interface') !== TRUE or strlen($lang) != 2) {
			DooUriRouter::redirect(Doo::conf()->APP_URL);
			return false;
		}

		$file_names = array();
		$path = Doo::conf()->SITE_PATH . 'protected';
		ExternalController::scanFileNameRecursivly($path, $file_names);

		//$translator = Doo::translator('Csv', Doo::conf()->SITE_PATH . 'protected/lang/' . $lang . '/' . $lang . //'.csv');
		$translator = Doo::translator('database', $lang);

		$fileResult = array();

		foreach ($file_names as $file) {

			if (file_exists($file)) {

				$content = file_get_contents($file);

				$clen = strlen($content);

				$pos = 0;
				while ($pos = strpos($content, 'this'.'->__(', $pos))
				{
					if ($pos)
					{
						//Get ''
						if ($content[$pos+9]=="'")
						{
							$res = "";
							$pos1 = strpos($content, "'", $pos+1);
							$pos2 = strpos($content, "'", $pos1+1);

							for ($i=$pos1+1;$i<$pos2;$i++)
								$res .= $content[$i];
							$fileResult[] = $res;
						}
						//Get ""
						if ($content[$pos+9]=='"')
						{
							$res = "";
							$pos1 = strpos($content, '"', $pos+1);
							$pos2 = strpos($content, '"', $pos1+1);

							for ($i=$pos1+1;$i<$pos2;$i++)
								$res .= $content[$i];
							$fileResult[] = $res;
						}
					}
					$pos++;
				}

				// Check for snController - used when this can not be used
				$pos = 0;
				while ($pos = strpos($content, 'snController'.'->__(', $pos))
				{
					if ($pos)
					{
						//Get ''
						if ($content[$pos+17]=="'")
						{
							$res = "";
							$pos1 = strpos($content, "'", $pos+1);
							$pos2 = strpos($content, "'", $pos1+1);

							for ($i=$pos1+1;$i<$pos2;$i++)
								$res .= $content[$i];
							$fileResult[] = $res;
						}
						//Get ""
						if ($content[$pos+17]=='"')
						{
							$res = "";
							$pos1 = strpos($content, '"', $pos+1);
							$pos2 = strpos($content, '"', $pos1+1);

							for ($i=$pos1+1;$i<$pos2;$i++)
								$res .= $content[$i];
							$fileResult[] = $res;
						}
					}
					$pos++;
				}

			} else {
				echo "No file";
			}
		}
                $fileResult = array_unique($fileResult);
                //Fetch and compare texts from database with collected fileresults to find unused texts and delete them
                if (!empty($fileResult)) {
                    echo "TRANSLATION KEY DELETION: <br/><br/>";

                    $dRows = 0;
                    $screentexts = new GeScreenTexts();
                    $params['select'] = "{$screentexts->_table}.ID_TEXT, {$screentexts->_table}.TransKey";
                    $dbKeys = Doo::db()->find('GeScreenTexts', $params);
                    foreach($dbKeys as $text) {
                        $key = array_search($text->TransKey, $fileResult);
                        // If key isn't used, delete it
                        if(!$key) {
                            $query = "DELETE FROM ge_screentexts WHERE ID_TEXT={$text->ID_TEXT}";
                            echo "Deleted: $text->TransKey<br/>";
                            Doo::db()->query($query);
                            $dRows++;
                        }
                    }
                    echo "$dRows keys deleted<br/><br/>";
                }

		//Loop thru the collected fileresults and find new untranslated texts and insert them
		if (!empty($fileResult)) {
			echo "FILE TRANSLATION: <br/><br/>";

			$nRows = 0;
			foreach ($fileResult as $item)
			{
				$query = "SELECT COUNT(*) as n FROM ge_screentexts WHERE TransKey=" .'"' . $item . '"';

				$o = (object)Doo::db()->fetchRow($query);
				$n = $o->n;

				if ($n==0)
				{
					$query = "INSERT INTO ge_screentexts".
							 "(TransKey,TransTextEN,TransTextDA,TransTextDE,TransTextFR,TransTextES,TransTextRO,TransTextLT,TransTextBG,".
							 "TransTextNL,TransTextEL,TransTextTR,TransTextZH,TransTextIS,TransTextBR,TransTextTH,TransTextPT,TransTextRU,".
							 "TransTextPL,TransTextFI,TransTextFA,TransTextDR,TransTextNO,TransTextSE,TransTextHU,TransTextAR,TransTextET)".
							 "VALUES (".'"'.$item.'","'.$item.'"'.",'','','','','','','','','','','','','','','','','','','','','','','','','')";
					echo "New: $item<br/>";
					Doo::db()->query($query);
					//echo " - $query<br/>";
					$nRows++;
				}

			}
			echo "$nRows new rows added<br/>";
		}


		echo "<p>Synch translations done</p>";
		exit;

	}

	public static function scanFileNameRecursivly($path = '', &$name = array()) {
		$path = $path == '' ? dirname(__FILE__) : $path;
		$lists = @scandir($path);

		if (!empty($lists)) {
			foreach ($lists as $f) {

				if (is_dir($path . DIRECTORY_SEPARATOR . $f) && $f != ".." && $f != ".") {
					ExternalController::scanFileNameRecursivly($path . DIRECTORY_SEPARATOR . $f, $name);
				} else {
					if (substr($path . DIRECTORY_SEPARATOR . $f, -3, 3) == 'php') {
						$name[] = $path . DIRECTORY_SEPARATOR . $f;
					}
				}
			}
		}
		return $name;
	}

	public function generateFreeGames() {
		print "Generating free items <br/>";
		$membership = new Membership();
		$membership->prepareFreeItems();
		print "Generated";
	}

	public function updatePlayerFreeGames() {
		print "Updating player free games <br/>";
		$membership = new Membership();
		$membership->updateFreeGameCount();
		print "Done updating!";
	}

	public function convertMessages() {
		print "Start converting messages <br>";
		$messages = new Messages();
		$oldMessages = $messages->getAllOldMessages();
		echo "Messages to convert: ".count($oldMessages);
		echo "<br>";

		foreach ($oldMessages as $oldMessage)
		{
			$participants = array($oldMessage->ID_PLAYER_FROM);
			$participantList = $messages->getOldRecipients($oldMessage->ID_PM);
			foreach ($participantList as $participant)
			{
				if (in_array($participant->ID_PLAYER, $participants) === false)
				$participants[] = $participant->ID_PLAYER;
			}
			echo "Message: ".$oldMessage->ID_PM." participants = ".implode(',', $participants)."<br>";

			// Get (or set) conversation
			$conversation = $messages->getConversation($participants);
			// Save message
			$newMessage = new MeMessages();
			$newMessage->ID_CONVERSATION = $conversation->ID_CONVERSATION;
			$newMessage->ID_PLAYER = $oldMessage->ID_PLAYER_FROM;
			$newMessage->MessageText = $oldMessage->Body;
			$newMessage->MessageTime = $oldMessage->MsgTime;
			$newMessage->insert();
		}
		print "Done";
	}

	public function NewsCrawler() {
		$newsCrawler = new NewsCrawler();
		$newsCrawler->run();
	}

	public function cleanUpMostRead($retainPeriod = 7) {
		$mostRead = new NwMostRead;
		$mostRead->delete(array('where'  => 'ReadDate < DATE_SUB(CURDATE(), INTERVAL '.$retainPeriod.' DAY)'));
		echo 'Records in '.$mostRead->_table.' table older than '.$retainPeriod.' days are deleted.<br />';
		Doo::cache()->flushAll();

	}
}

?>