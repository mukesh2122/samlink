<?php

class BugReports {

	/**
	 * Returns all bugs list
	 *
	 * @return SyBugReports list
	 */
	public function getAllBugReports($limit, $tab = 'Status', $order = 'asc', $type = NULL, $category, $subcategory) {
		$bugreport = new SyBugReports();
		$order = strtoupper($order);

		if ($type == 'None') { $type = ''; }
		if ($category == 'None') { $category = ''; }
		if ($subcategory == 'None') { $subcategory = ''; }

		switch ($type)	{
			case '':
				$where = "WHERE isBug = '0' AND ReportType = ''";
				$statusname = 'ErrorStatus';
				break;
			case 'All':
				$where = "WHERE isBug = '0'";
				$statusname = 'ErrorStatus';
				break;
			case 'Bug':
				$where = "WHERE isBug = '1'";
				$where .= isset($category) ? " AND Module = '" . $category . "'" : '';
				$statusname = 'Status';
				break;
			default:
				$where = "WHERE ReportType = '".$type."'";
				$statusname = 'ErrorStatus';
		}
		switch ($tab) {
			case 'Status':
				$orderBy = $statusname." $order, ReportType, Priority";
				break;
			case 'Type':
				$orderBy = "ReportType $order, ".$statusname.", Priority";
				break;
			case 'Cat':
				$orderBy = "Category $order, ".$statusname." Priority";
				break;
			case 'SubCat':
				$orderBy = "SubCategory $order, ".$statusname.", Priority";
				break;
			case 'Module':
				$orderBy = "Module $order, ".$statusname.", Priority";
				break;
			case $tab == 'ErrorName':
				$orderBy = "ErrorName $order";
				break;
			case 'Priority':
				$orderBy = "Priority $order, ReportType, ".$statusname."";
				break;
			case 'Supporter':
				$orderBy = "Developer $order, ".$statusname.", ReportType, Priority";
				break;
			case 'LastUpdatedBy':
				$orderBy = "LastUpdatedBy $order, ".$statusname."";
				break;
			default:
				$orderBy = "ID_ERROR $order";
		}
		$where .= isset($category) && $type != 'Bug' ? " AND Category = '" . $category . "'" : '';
		$where .= isset($subcategory) ? " AND SubCategory = '" . $subcategory . "'" : '';
		$query = "SELECT
					{$bugreport->_table}.*
				FROM
					`{$bugreport->_table}`" .
				$where
				."ORDER BY {$orderBy}
				LIMIT $limit";

		$rs = Doo::db()->query($query);
		$list = $rs->fetchAll(PDO::FETCH_CLASS, 'SyBugReports');

		return $list;
	}

	/**
	 * Returns bugreport item
	 *
	 * @return SyBugReports object
	 */
	public static function getBugReportByID($id) {

		if (Doo::conf()->cache_enabled == TRUE) {
			$currentDBconf = Doo::db()->getDefaultDbConfig();
			$cacheKey = md5(CACHE_BUGREPORT."_{$id}_".$currentDBconf[0]."_".$currentDBconf[1]."_".Cache::getVersion(CACHE_BUGREPORT.$id));

			if (Doo::cache('apc')->get($cacheKey)) {
				return Doo::cache('apc')->get($cacheKey);
			}
		}

		$item = Doo::db()->getOne('SyBugReports', array(
			'limit' => 1,
			'where' => 'ID_ERROR = ?',
			'param' => array($id)
		));

		if (Doo::conf()->cache_enabled == TRUE) {
			Doo::cache('apc')->set($cacheKey, $item, Doo::conf()->BUGREPORT_LIFETIME);
		}

		if ($item->isBug == 1) {
			$pbrels = new SyPlayerBugRel();
			$params = array();
			$params['where'] = "ID_ERROR = ".$item->ID_ERROR;
			$result = Doo::db()->find($pbrels, $params);
			$SelectedApprovers = array();
			foreach($result as $key=>$value) {
				$SelectedApprovers[] = $value->ID_PLAYER;
			}
			$item->Approvers = $SelectedApprovers;
		}
		/*
		 * This script will change timestamp(s) in the variable with correct format
		 * replace 10 digits with time: in front to secure non-timestamps wont get converted
		 */
		function replace_timestamp($match) {
			$dateformat = 'd/m-Y G:i'; //Variable should be dynamic by language
			return MainHelper::calculateTime(str_replace('time:', '', $match[0]), $dateformat);
		}

		if (isset($item->ErrorLog)){
			$item->ErrorLog = preg_replace_callback('/time:\d{10}/', 'replace_timestamp', $item->ErrorLog);
		}

		if (isset($item->InternalLog)){
			$item->InternalLog = preg_replace_callback('/time:\d{10}/', 'replace_timestamp', $item->InternalLog);
		}
		return $item;
	}

	/**
	 * Returns amount of bug reports
	 *
	 * @return int
	 */
	public function getTotal($type = NULL, $category = NULL, $subcategory = NULL)
	{
		switch ($type)	{
			case '':
				$where = "WHERE isBug = '0' AND ReportType = ''";
				break;
			case 'All':
				$where = "WHERE isBug = '0'";
				break;
			case 'Bug':
				$where = "WHERE isBug = '1'";
				$where .= isset($category) ? " AND Module = '" . $category . "'" : '';
				break;
			default:
				$where = "WHERE ReportType = '".$type."'";
		}
		$br = new SyBugReports();
		$where .= isset($category) && $type != 'Bug' ? " AND Category = '".$category."'" : '';
		$where .= isset($subcategory) ? " AND SubCategory = '" . $subcategory . "'" : '';
		$totalNum = (object) Doo::db()->fetchRow('SELECT COUNT(1) as cnt FROM `' . $br->_table . '` ' . $where . ' LIMIT 1');
		return $totalNum->cnt;
	}

	/**
	 * Returs number of results
	 *
	 * @param String $phrase
	 * @return int
	 */
	public function getSearchTotal($phrase, $type = NULL, $category = NULL, $subcategory = NULL) {
		if (isset($phrase) && mb_strlen($phrase) >= 3)
		{
			switch ($type)
			{
				case '':
					$where = "WHERE isBug = '0' AND ReportType = ''";
					break;
				case 'All':
					$where = "WHERE isBug = '0'";
					break;
				case 'Bug':
					$where = "WHERE isBug = '1'";
					$where .= isset($category) ? " AND Module = '" . $category . "'" : '';
					break;
				default:
					$where = "WHERE ReportType = '".$type."'";
			}
			$br = new SyBugReports();
			$where .= isset($category) && $type != 'Bug' ? " AND Category = '".$category."'" : '';
			$where .= isset($subcategory) ? " AND SubCategory = '" . $subcategory . "'" : '';
			$where .= " AND ErrorName LIKE '%".$phrase."%'";
			$totalNum = (object) Doo::db()->fetchRow('SELECT COUNT(1) as cnt FROM `' . $br->_table . '` ' . $where . ' LIMIT 1');
			return $totalNum->cnt;
		}
		return 0;
	}

	/**
	 * Returs search results
	 *
	 * @param String $phrase
	 * @return collection of SyBugReports
	 */
	public function getSearch($limit, $phrase, $type = NULL, $category = NULL, $subcategory = NULL)
	{
		if ($phrase && mb_strlen($phrase) >= 3)
		{
			switch ($type)	{
				case '':
					$where = "WHERE isBug = '0' AND ReportType = ''";
					break;
				case 'All':
					$where = "WHERE isBug = '0'";
					break;
				case 'Bug':
					$where = "WHERE isBug = '1'";
					$where .= isset($category) ? " AND Module = '" . $category . "'" : '';
					break;
				default:
					$where = "WHERE ReportType = '".$type."'";
			}
			$bugreport = new SyBugReports();
			$where .= isset($category) && $type != 'Bug' ? " AND Category = '".$category."'" : '';
			$where .= isset($subcategory) ? " AND SubCategory = '" . $subcategory . "'" : '';
			$where .= " AND ErrorName LIKE '%".$phrase."%'";
			$orderBy = "ErrorName asc";
			$query = "SELECT
					{$bugreport->_table}.*
				FROM
					`{$bugreport->_table}`" .
				$where
				." ORDER BY {$orderBy}
				LIMIT $limit";

			$q = Doo::db()->query($query);
			$result = $q->fetchAll(PDO::FETCH_CLASS, 'SyBugReports');
			return $result;
		}
		return array();
	}

	public function createBugReportInfo($post) {
		if (!empty($post)) {
			$player = User::getUser();

			$bugreport = new SyBugReports();
			if (isset($post['report_name'])) {
				$bugreport->ErrorName = ContentHelper::handleContentInput($post['report_name']);
			}
			if (isset($post['report_isbug'])) {
				$bugreport->isBug = '1';
				if (isset($post['report_module'])) {
					$bugreport->Module = $post['report_module'];
				}
				if(isset($post['report_status'])) {
					$bugreport->Status = $post['report_status'];
				}
				if(isset($post['report_developer'])  && is_numeric($post['report_developer'])) {
					$bugreport->ID_DEVELOPER = $post['report_developer'];
				}
			} else {
				$bugreport->isBug = '0';
				if(isset($post['report_ticketowner']) && is_numeric($post['report_ticketowner'])) {
					$bugreport->ID_DEVELOPER = $post['report_ticketowner'];
				}
				if(isset($post['report_escalation']) && is_numeric($post['report_escalation'])) {
					$bugreport->ID_APPROVER = $post['report_escalation'];
				}
			}
			if (isset($post['report_type'])) {
				$bugreport->ReportType = $post['report_type'];
			}
			if (isset($post['report_category'])) {
				$bugreport->Category = $post['report_category'];
			}
			if (isset($post['report_subcategory'])) {
				$bugreport->SubCategory = $post['report_subcategory'];
			}
			if (isset($post['report_errorstatus'])) {
				$bugreport->ErrorStatus = $post['report_errorstatus'];
			}
			if (isset($post['report_priority'])) {
				$bugreport->Priority = $post['report_priority'];
			}
			$bugreport->ID_REPORTEDBY = $player->ID_PLAYER;
			$bugreport->LastUpdatedByType = '2';
			$bugreport->ID_LASTUPDATEDBY = $player->ID_PLAYER;

			if (isset($post['report_errorlog'])) {
				$bugreport->ErrorLog = "<p><b>Original description</b></p>".ContentHelper::handleContentInput($post['report_errorlog']);
			}
			$bugreport->InternalLog = '';
			$bugreport->ID_ERROR = $bugreport->insert();


			if(isset($post['report_isbug']) && isset($post['report_approver']))
			{
				$pbrel = new SyPlayerBugRel();
				foreach ($post['report_approver'] as $report_approver) {
					$pbrel->ID_ERROR = $bugreport->ID_ERROR;
					$pbrel->ID_PLAYER = $report_approver;
					$pbrel->insert();
				}
				$bugreport->Approver = "";
				$bugreport->ID_APPROVER = "";
			}
			return $bugreport;
		}
		return false;
	}

	/**
	 * Returns bug report types
	 *
	 * @return unknown
	 */
	public function getTypes() {
		$types = array(
			'' => 'None/Unknown',
			'Feedb' => 'Feedback',
			'Help' => 'Help',
			'Cont' => 'Contact',
		);
		return $types;
	}

	/**
	 * Returns bug report categories
	 *
	 * @return unknown
	 */
	public function getCategories() {
		$categories = array(
			'' => 'None/Unknown',
			'Feedb' => array(
				'' => 'None/Unknown',
				'Rep' => 'Reports',
				'Sugg' => 'Suggestions',
				'Compl' => 'Complaints',
				'Bug' => 'Bug/Error',
			),
			'Help' => array(
				'' => 'None/Unknown',
				'Acc' => 'Account',
				'Paym' => 'Payment',
				'Subsc' => 'Subscription/Membership',
				'Evnt' => 'Events',
				'eSprt' => 'E-Sports',
				'Grps' => 'Groups',
				'oUsr' => 'Other users',
				'Cntn' => 'Content',
			),
			'Cont' => array(
				'' => 'None/Unknown',
				'sCnt' => 'Staff contact',
				'jAppl' => 'Job application',
			),
		);
		return $categories;
	}

	/**
	 * Returns bug report sub-categories
	 *
	 * @return unknown
	 */
	public function getSubCategories() {
		$subcategories = array(
			'' => 'None/Unknown',
			'Rep' => array(
				'' => 'None/Unknown',
				'User' => 'User',
				'Cntn' => 'Content',
			),
			'Acc' => array(
				'' => 'None/Unknown',
				'Crea' => 'Creation',
				'Hack' => 'Hacked/Compromised',
				'Updt' => 'Update info/details',
			),
			'Paym' => array(
				'' => 'None/Unknown',
				'pErr' => 'Payment error',
				'rReq' => 'Refund request',
			),
		);
		return $subcategories;
	}

	/**
	 * Returns bug report statuses
	 *
	 * @return unknown
	 */
	public function getStatuses()
	{
		$statuses = array(
			'' => 'None/Unknown',
			'Spec' => 'To be specified',
			'Devel' => 'To be developed',
			'Test' => 'Ready for test',
			'Done' => 'Completed',
			'Reject' => 'Rejected',
		);
		return $statuses;
	}

	/**
	 * Returns bug report statuses
	 *
	 * @return unknown
	 */
	public function getErrorStatuses() {
		$errorstatuses = array(
			'' => 'None/Unknown',
			'New' => 'New',
			'Updt' => 'Updated by user',
			'Wait' => 'Waiting for user',
			'Escl' => 'Escalated',
			'Rslv' => 'Resolved',
			'Clsd' => 'Closed',
		);
		return $errorstatuses;
	}

	/**
	 * Returns preset bug report proirities
	 *
	 * @return unknown
	 */
	public function getPriorities() {
		$proirities = array(
			0 => 'None/Unknown',
			100 => 'Fix now!',
			1000 => 'Very high',
			2000 => 'High',
			4000 => 'Normal',
			6000 => 'Low',
			8000 => 'Very low',
			9000 => 'Feedback',
		);
		return $proirities;
	}

	/**
	 * Returns bug report modules
	 *
	 * @return unknown
	 */
	public function getModules() {
		$modules = array(
			'' =>  'None/Unknown',
			'ES' =>  'ESport',
			'SN' =>  'Social network',
			'FI' =>  'Finances',
			'ME' =>  'Messages & chat',
			'FO' =>  'Forum',
			'NW' =>  'News',
			'RE' =>  'Registration, referrals & invitations',
			'GE' =>  'Geography & localization',
			'RC' =>  'Recruitment',
			'AC' =>  'Achievements',
			'BA' =>  'Ads & Banners',
			'AD' =>  'Admin',
			'MI' =>  'Miscellaneous',
		);
		return $modules;
	}

	public function updateBugReportInfo(SyBugReports $bugreport, $post) {
		if (!empty($post))
		{
			$player = User::getUser();
			$tmpLog = '';
			$tmpErrorLog = '';
			$modules = $this->getModules();
			$priorities = $this->getPriorities();
			$errorstatuses = $this->getErrorStatuses();
			$statuses = $this->getStatuses();
			$types = $this->getTypes();
			$categories = $this->getCategories();
			$subcategories = $this->getSubCategories();
			if(isset($post['report_name']) && $post['report_name'] != $bugreport->ErrorName)
			{
				$tmpLog .= "Name changed from '".$bugreport->ErrorName."' to '".$post['report_name']."'</br>";
				$bugreport->ErrorName = ContentHelper::handleContentInput($post['report_name']);
			}
			if (isset($post['report_isbug'])) {
				if($bugreport->isBug == 0) {
					$tmpLog .= "Changed ticket from Support to Bug/Error.</br>";
				}
				$bugreport->isBug = '1';
				if(isset($post['report_module']) && $post['report_module'] != $bugreport->Module) {
					$tmpLog .= "Module changed from '".$modules[$bugreport->Module]."' to '".$modules[$post['report_module']]."'</br>";
					$bugreport->Module = $post['report_module'];
				}
				if(isset($post['report_status']) && $post['report_status'] != $bugreport->Status)
				{
					$tmpLog .= "Bug status changed from '".$statuses[$bugreport->Status]."' to '".$statuses[$post['report_status']]."'</br>";
					$bugreport->Status = $post['report_status'];
				}
				if(isset($post['report_developer']))
				{
					if ($post['report_developer'] != '') {
						$pieces = explode(",", $post['report_developer']);
						$ID_DEVELOPER = $pieces[0];
						$Developer = $pieces[1];
					} else {
						$ID_DEVELOPER = '0';
						$Developer = '';
					}
					if ($ID_DEVELOPER != $bugreport->ID_DEVELOPER) {
						$tmpLog .= "Developer changed from '".$bugreport->Developer."' to '".$Developer."'</br>";
						$bugreport->Developer = $Developer;
						$bugreport->ID_DEVELOPER = $ID_DEVELOPER;
					}
				}
				if(isset($post['report_approver']) && $post['report_approver'] != $bugreport->Approvers)
				{
					$tmpLog .= "Testers updated</br>";
					$pbrel = new SyPlayerBugRel();
					$pbrel->ID_ERROR = $bugreport->ID_ERROR;
					$pbrel->delete();
					foreach ($post['report_approver'] as $ID_APPROVER) {
						$pbrel->ID_ERROR = $bugreport->ID_ERROR;
						$pbrel->ID_PLAYER = $ID_APPROVER;
						$pbrel->insert();
					}
					$bugreport->Approver = "";
					$bugreport->ID_APPROVER = "";
				} else if (empty($post['report_approver']) && $bugreport->Approvers != "") {
					$tmpLog .= "Testers removed</br>";
					$pbrel = new SyPlayerBugRel();
					$pbrel->ID_ERROR = $bugreport->ID_ERROR;
					$pbrel->delete();
				}
			} else {
				if($bugreport->isBug == 1) {
					$tmpLog .= "Changed ticket from Bug/Error to Support.</br>";
				}
				$bugreport->isBug = '0';
				$bugreport->Module = '';
				if(isset($post['report_ticketowner']))
				{
					if ($post['report_ticketowner'] != '') {
						$pieces = explode(",", $post['report_ticketowner']);
						$ID_DEVELOPER = $pieces[0];
						$Developer = $pieces[1];
					} else {
						$ID_DEVELOPER = '0';
						$Developer = '';
					}
					if ($ID_DEVELOPER != $bugreport->ID_DEVELOPER) {
						$tmpLog .= "Ticket Owner changed from '".$bugreport->Developer."' to '".$Developer."'</br>";
						$bugreport->Developer = $Developer;
						$bugreport->ID_DEVELOPER = $ID_DEVELOPER;
					}
				}
				if(isset($post['report_escalation']))
				{
					if ($post['report_escalation'] != '') {
						$pieces = explode(",", $post['report_escalation']);
						$ID_APPROVER = $pieces[0];
						$Approver = $pieces[1];
					} else {
						$ID_APPROVER = '0';
						$Approver = '';
					}
					if ($ID_APPROVER != $bugreport->ID_APPROVER) {
						$tmpLog .= "Escalation changed from '".$bugreport->Approver."' to '".$Approver."'</br>";
						$bugreport->Approver = $Approver;
						$bugreport->ID_APPROVER = $ID_APPROVER;
					}
				}
			}
			if(isset($post['report_type']) && $post['report_type'] != $bugreport->ReportType)
			{
				$tmpLog .= "Type changed from '".$types[$bugreport->ReportType]."' to '".$types[$post['report_type']]."'</br>";

				if ($bugreport->Category != '') {
					$old_category = $categories[$bugreport->ReportType][$bugreport->Category];
				} else {
					$old_category = $categories[''];
				}

				if ($post['report_type'] != '') {
					$new_category = $categories[$post['report_type']][$post['report_category']];
				} else {
					$new_category = $categories[''];
				}

				$tmpLog .= "Category changed from '".$old_category."' to '".$new_category."'</br>";
				if ($bugreport->SubCategory != '') {
					$old_subcategory = $subcategories[$bugreport->Category][$bugreport->SubCategory];
				} else {
					$old_subcategory = $subcategories[''];
				}

				if ($post['report_category'] != '') {
					$new_subcategory = $subcategories[$post['report_category']][$post['report_subcategory']];
				} else {
					$new_subcategory = $subcategories[''];
				}

				$tmpLog .= "Sub-category changed from '".$old_subcategory."' to '".$new_subcategory."'</br>";

				$bugreport->SubCategory = $post['report_subcategory'];
				$bugreport->Category = $post['report_category'];
				$bugreport->ReportType = $post['report_type'];
			}
			if(isset($post['report_category']) && $post['report_category'] != $bugreport->Category && $post['report_type'] == $bugreport->ReportType)
			{


				if ($bugreport->Category != '') {
					$old_category = $categories[$bugreport->ReportType][$bugreport->Category];
				} else {
					$old_category = $categories[''];
				}

				if ($post['report_type'] != '') {
					$new_category = $categories[$post['report_type']][$post['report_category']];
				} else {
					$new_category = $categories[''];
				}

				$tmpLog .= "Category changed from '".$old_category."' to '".$new_category."'</br>";
				if ($bugreport->SubCategory != '') {
					$old_subcategory = $subcategories[$bugreport->Category][$bugreport->SubCategory];
				} else {
					$old_subcategory = $subcategories[''];
				}

				if ($post['report_category'] != '') {
					$new_subcategory = $subcategories[$post['report_category']][$post['report_subcategory']];
				} else {
					$new_subcategory = $subcategories[''];
				}

				$tmpLog .= "Sub-category changed from '".$old_subcategory."' to '".$new_subcategory."'</br>";

				$bugreport->SubCategory = $post['report_subcategory'];
				$bugreport->Category = $post['report_category'];
			}
			if(isset($post['report_subcategory']) && $post['report_subcategory'] != $bugreport->SubCategory && $post['report_category'] == $bugreport->Category)
			{

				if ($bugreport->SubCategory != '') {
					$old_subcategory = $subcategories[$bugreport->Category][$bugreport->SubCategory];
				} else {
					$old_subcategory = $subcategories[''];
				}

				if ($post['report_category'] != '') {
					$new_subcategory = $subcategories[$post['report_category']][$post['report_subcategory']];
				} else {
					$new_subcategory = $subcategories[''];
				}

				$tmpLog .= "Sub-category changed from '".$old_subcategory."' to '".$new_subcategory."'</br>";

				$bugreport->SubCategory = $post['report_subcategory'];
			}
			if(isset($post['report_errorstatus']) && $post['report_errorstatus'] != $bugreport->ErrorStatus)
			{
				$tmpLog .= "Status changed from '".$errorstatuses[$bugreport->ErrorStatus]."' to '".$errorstatuses[$post['report_errorstatus']]."'</br>";
				$tmpErrorLog .= "Status changed ".date("d/m-Y G:i")." by '".$player->DisplayName."'";
				$bugreport->ErrorStatus = $post['report_errorstatus'];
			}
			if(isset($post['report_priority']) && $post['report_priority'] != $bugreport->Priority)
			{
				$tmpLog .= "Priority changed from ".$priorities[$bugreport->Priority]." to ".$priorities[$post['report_priority']]."</br>";
				$bugreport->Priority = $post['report_priority'];
			}
			if (isset($post['report_errorlog']) && $post['report_errorlog'] != '') {
				$tmpErrorLog = ContentHelper::handleContentInput($post['report_errorlog'])."</br>".$tmpErrorLog;
			}
			if (isset($post['report_internallog']) && $post['report_internallog'] != '') {
				$tmpLog = "<b>Note:</b> ".ContentHelper::handleContentInput($post['report_internallog'])."</br>";
			}

			if ($tmpLog != '') {
				$tmpLog = "<div style='color:blue'> Changed time:".time()." by ".$player->DisplayName."</div>".$tmpLog;
			}

			if ($tmpErrorLog != '')
			{
				$mailErrorLog = "<div style='color:blue'> Response from ".$player->DisplayName." (".MainHelper::calculateTime(time(), 'd/m-Y G:i').")</div>".$tmpErrorLog;
				$tmpErrorLog = "<div style='color:blue'> Response from ".$player->DisplayName." (time:".time().")</div>".$tmpErrorLog;

				$p = Doo::db()->getOne('Players', array('where' => 'ID_PLAYER = ?', 'param' => array($bugreport->ID_REPORTEDBY)));
				$mail = new EmailNotifications();
				$mail->updatedBugreport($bugreport, $p, $mailErrorLog);
			}
			$bugreport->InternalLog = $tmpLog.$bugreport->InternalLog;
			$bugreport->ErrorLog = $tmpErrorLog.$bugreport->ErrorLog;
			$bugreport->LastUpdatedByType = '2';
			$bugreport->ID_LASTUPDATEDBY = $player->ID_PLAYER;

			if ($tmpLog != '' || $tmpErrorLog != '')
			{
				$bugreport->update();
				$this->updateCache($bugreport);
			}
			return true;
		}
		return false;
	}

	/**
	 * Returns players by filter
	 * e.g. isDeveloper, isTester, isSupporter
	 * @return array
	 */
	public function getPlayersWho($who) {
		if (isset($who)) {
			$params = array();
			$params['asc'] = 'DisplayName';
			$params['select'] = 'ID_PLAYER, DisplayName';
			$params['where'] = $who." = 1";
			$result = Doo::db()->find('Players', $params);

			return $result;
		}
	}

	/**
	 * Upload handler
	 *
	 * @return array
	 */
	public function uploadScreenshot($id) {
		$br = $this->getBugReportByID($id);

		if (User::canAccess("Edit bugreport")) {
			$image = new Image();
			$result = $image->uploadImage(FOLDER_BUGREPORTS, $br->ImageURL);
			if ($result['filename'] != '') {
				$br->ImageURL = ContentHelper::handleContentInput($result['filename']);
				$br->update(array('field' => 'ImageURL'));
				$this->updateCache($br);
//				$br->purgeCache();
				$result['br'] = $br;
			}
			return $result;
		}
	}

	/**
	 * Returns all bug reports list, used for ajax in admin
	 *
	 * @return SyBugReports list
	 */
	public function getSearchBugReports($phrase) {
		if (strlen($phrase) > 2) {
			$list = Doo::db()->find('SyBygReports', array(
				'limit' => 10,
				'asc' => 'ErrorName',
				'where' => 'ErrorName LIKE ?',
				'param' => array('%'. $phrase . '%')
			));
		}

		return $list;
	}

	public function updateCache(SyBugReports $bugreport) {
		Cache::increase(CACHE_BUGREPORT.$bugreport->ID_ERROR);
	}

}