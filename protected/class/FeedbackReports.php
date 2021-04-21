<?php

/**
 * FeedbackReports class definition and implementation
 *
 * Originally a copy of the BugReports class modified by KiC
 *
 * @return SyBugReports list
 */

class FeedbackReports
{
	/**
	 * Returns all bugs list
	 *
	 * @return SyBugReports list
	 */
	public function getAllFeedbackReports($limit, $tab = 'Status', $order = 'asc', $type = NULL, $playerid = NULL)
	{
		$feedbackreport = new SyBugReports();
		$order = strtoupper($order);
		
		switch ($tab) {
			case 'Status':
				$orderBy = "ErrorStatus $order, LastUpdatedTime desc";
				break;
			case 'Created':
				$orderBy = "CreatedTime $order";
				break;
			case 'LastUpdatedTime':
				$orderBy = "LastUpdatedTime $order";
				break;
			case 'Type':
				$orderBy = "ReportType $order, ErrorStatus, LastUpdatedTime desc";
				break;
			case 'ErrorName':
				$orderBy = "ErrorName $order, LastUpdatedTime desc";
				break;
			default:
				$orderBy = "ID_ERROR $order";
		}

		$where = isset($type) && $type != 'All' ? "WHERE ReportType = '".$type."'" : "WHERE ID_ERROR != '' ";
		$where .= isset($playerid) ? " AND ID_REPORTEDBY = '".$playerid."'" : "";
		$query = "SELECT
					{$feedbackreport->_table}.*
				FROM
					`{$feedbackreport->_table}`" .
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
	public static function getFeedbackReportByID($id)
	{

		if (Doo::conf()->cache_enabled == TRUE)
		{
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

		if (Doo::conf()->cache_enabled == TRUE)
		{
			Doo::cache('apc')->set($cacheKey, $item, Doo::conf()->BUGREPORT_LIFETIME);
		}
		
		/*
		 * This script will change timestamp(s) in the variable with correct format
		 * replace 10 digits with time: in front to secure non-timestamps wont get converted
		 */
		if (isset($item->ErrorLog)){
			function my_replace($match) {
				$dateformat = 'd/m-Y G:i'; //Variable should be dynamic by language
				return MainHelper::calculateTime(str_replace('time:', '', $match[0]), $dateformat);
			}
			$item->ErrorLog = preg_replace_callback('/time:\d{10}/', 'my_replace', $item->ErrorLog);
		}
		return $item;
	}

	/**
	 * Returns amount of bug reports
	 *
	 * @return int
	 */
	public function getTotal($type = NULL, $playerid = NULL)
	{
		$br = new SyBugReports();
		$where = isset($type) && $type != 'All' ? "WHERE ReportType = '".$type."'" : "WHERE ID_ERROR != ''";
		$where .= isset($playerid) ? " AND ID_REPORTEDBY = '".$playerid."'" : '';
		$totalNum = (object) Doo::db()->fetchRow('SELECT COUNT(1) as cnt FROM `' . $br->_table . '` ' . $where . ' LIMIT 1');
		return $totalNum->cnt;
	}
	
	public function createFeedbackReportInfo($post)
	{
		if (!empty($post))
		{
			$player = User::getUser();

			$feedbackreport = new SyBugReports();
			if (isset($post['report_name'])) {
				$feedbackreport->ErrorName = ContentHelper::handleContentInput($post['report_name']);
			}
			if (isset($post['report_type'])) {
				$feedbackreport->ReportType = $post['report_type'];
			}
			if (isset($post['report_category'])) {
				$feedbackreport->Category = $post['report_category'];
			}
			if (isset($post['report_subcategory'])) {
				$feedbackreport->SubCategory = $post['report_subcategory'];
			}
			if (isset($post['report_log'])) {
				$feedbackreport->ErrorLog = "<b>Original description</b><p>".ContentHelper::handleContentInput($post['report_log'])."</p>";
			}
			$feedbackreport->ErrorStatus = 'New';
			$feedbackreport->ID_REPORTEDBY = $player->ID_PLAYER;
			$feedbackreport->LastUpdatedByType = '1';
			$feedbackreport->Priority = '0';
			$feedbackreport->ID_LASTUPDATEDBY = $player->ID_PLAYER;

			$feedbackreport->ID_ERROR = $feedbackreport->insert();

			return $feedbackreport;
		}
		return false;
	}

	/**
	 * Returns bug report types
	 *
	 * @return unknown
	 */
	public function getTypes() {
		$snController = new SnController();
		$types = array(
			'' => $snController->__('None/Unknown'),
			'Feedb' => $snController->__('Feedback'),
			'Help' => $snController->__('Help'),
			'Cont' => $snController->__('Contact'),
		);
		return $types;
	}

	/**
	 * Returns bug report categories ADDED 2014-01-09
	 *
	 * @return unknown
	 */
	public function getCategories() {
		$snController = new SnController();
		$categories = array(
			'' => $snController->__('None/Unknown'),
			'Feedb' => array(
				'' => $snController->__('None/Unknown'),
				'Rep' => $snController->__('Reports'),
				'Sugg' => $snController->__('Suggestions'),
				'Compl' => $snController->__('Complaints'),
				'Bug' => $snController->__('Bug/Error'),
			),
			'Help' => array(
				'' => $snController->__('None/Unknown'),
				'Acc' => $snController->__('Account'),
				'Paym' => $snController->__('Payment'),
				'Subsc' => $snController->__('Subscription/Membership'),
				'Evnt' => $snController->__('Events'),
				'eSprt' => $snController->__('E-Sports'),
				'Grps' => $snController->__('Groups'),
				'oUsr' => $snController->__('Other users'),
				'Cntn' => $snController->__('Content'),
			),
			'Cont' => array(
				'' => $snController->__('None/Unknown'),
				'sCnt' => $snController->__('Staff contact'),
				'jAppl' => $snController->__('Job application'),
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
		$snController = new SnController();
		$subcategories = array(
			'' => $snController->__('None/Unknown'),
			'Rep' => array(
				'' => $snController->__('None/Unknown'),
				'User' => $snController->__('User'),
				'Cntn' => $snController->__('Content'),
			),
			'Acc' => array(
				'' => $snController->__('None/Unknown'),
				'Crea' => $snController->__('Creation'),
				'Hack' => $snController->__('Hacked/Compromised'),
				'Updt' => $snController->__('Update info/details'),
			),
			'Paym' => array(
				'' => $snController->__('None/Unknown'),
				'pErr' => $snController->__('Payment error'),
				'rReq' => $snController->__('Refund request'),
			),
		);
		return $subcategories;
	}

	/**
	 * Returns bug report statuses
	 *
	 * @return unknown
	 */
	public function getErrorStatuses() {
		$snController = new SnController();
		$errorstatuses = array(
			'' => $snController->__('None/Unknown'),
			'New' => $snController->__('New'),
			'Updt' => $snController->__('Updated by user'),
			'Wait' => $snController->__('Waiting for user'),
			'Escl' => $snController->__('Escalated'),
			'Rslv' => $snController->__('Resolved'),
			'Clsd' => $snController->__('Closed'),
		);
		return $errorstatuses;
	}

	public function updateFeedbackReportInfo(SyBugReports $feedbackreport, $post)
	{
		if (!empty($post))
		{
			$player = User::getUser();
			$tmpLog = '';
			$tmpErrorLog = '';
			$bugreports = new BugReports();
			$types = $bugreports->getTypes();
			$categories = $bugreports->getCategories();
			$subcategories = $bugreports->getSubCategories();
			$errorstatuses = $bugreports->getErrorStatuses();
			if(isset($post['report_name']) && $post['report_name'] != $feedbackreport->ErrorName)
			{
				$tmpLog .= "Name changed from '".$feedbackreport->ErrorName."' to '".$post['report_name']."'</br>";
				$feedbackreport->ErrorName = $post['report_name'];
			}
			if(isset($post['report_type']) && $post['report_type'] != $feedbackreport->ReportType)
			{
				$tmpLog .= "Type changed from '".$types[$feedbackreport->ReportType]."' to '".$types[$post['report_type']]."'</br>";
				
				if ($feedbackreport->Category != '') {
					$old_category = $categories[$feedbackreport->ReportType][$feedbackreport->Category];
				} else {
					$old_category = $categories[''];
				}
				
				if ($post['report_type'] != '') {
					$new_category = $categories[$post['report_type']][$post['report_category']];
				} else {
					$new_category = $categories[''];
				}
					
				$tmpLog .= "Category changed from '".$old_category."' to '".$new_category."'</br>";
				if ($feedbackreport->SubCategory != '') {
					$old_subcategory = $subcategories[$feedbackreport->Category][$feedbackreport->SubCategory];
				} else {
					$old_subcategory = $subcategories[''];
				}
				
				if ($post['report_category'] != '') {
					$new_subcategory = $subcategories[$post['report_category']][$post['report_subcategory']];
				} else {
					$new_subcategory = $subcategories[''];
				}
				
				$tmpLog .= "Sub-category changed from '".$old_subcategory."' to '".$new_subcategory."'</br>";
				
				$feedbackreport->SubCategory = $post['report_subcategory'];
				$feedbackreport->Category = $post['report_category'];
				$feedbackreport->ReportType = $post['report_type'];
			}
			if(isset($post['report_category']) && $post['report_category'] != $feedbackreport->Category && $post['report_type'] == $feedbackreport->ReportType)
			{
				
				
				if ($feedbackreport->Category != '') {
					$old_category = $categories[$feedbackreport->ReportType][$feedbackreport->Category];
				} else {
					$old_category = $categories[''];
				}
				
				if ($post['report_type'] != '') {
					$new_category = $categories[$post['report_type']][$post['report_category']];
				} else {
					$new_category = $categories[''];
				}
					
				$tmpLog .= "Category changed from '".$old_category."' to '".$new_category."'</br>";
				if ($feedbackreport->SubCategory != '') {
					$old_subcategory = $subcategories[$feedbackreport->Category][$feedbackreport->SubCategory];
				} else {
					$old_subcategory = $subcategories[''];
				}
				
				if ($post['report_category'] != '') {
					$new_subcategory = $subcategories[$post['report_category']][$post['report_subcategory']];
				} else {
					$new_subcategory = $subcategories[''];
				}
				
				$tmpLog .= "Sub-category changed from '".$old_subcategory."' to '".$new_subcategory."'</br>";
				
				$feedbackreport->SubCategory = $post['report_subcategory'];
				$feedbackreport->Category = $post['report_category'];
			}
			if(isset($post['report_subcategory']) && $post['report_subcategory'] != $feedbackreport->SubCategory && $post['report_category'] == $feedbackreport->Category)
			{
				
				if ($feedbackreport->SubCategory != '') {
					$old_subcategory = $subcategories[$feedbackreport->Category][$feedbackreport->SubCategory];
				} else {
					$old_subcategory = $subcategories[''];
				}
				
				if ($post['report_category'] != '') {
					$new_subcategory = $subcategories[$post['report_category']][$post['report_subcategory']];
				} else {
					$new_subcategory = $subcategories[''];
				}
				
				$tmpLog .= "Sub-category changed from '".$old_subcategory."' to '".$new_subcategory."'</br>";
				
				$feedbackreport->SubCategory = $post['report_subcategory'];
			}
			if(isset($post['report_log']) && $post['report_log'] != '')
			{
				$tmpErrorLog = "<div style='color:blue'> Additional description by ".$player->DisplayName." (time:".time().")</div><p>".$post['report_log']."</p>";
			}
			if ($tmpLog != '' || $tmpErrorLog != '')
			{
				$tmpLog = "<div style='color:blue'> Changed time:".time()." by ".$player->DisplayName."</div><p>".$tmpLog."</p>";
			}
			$tmpLog .= "Status changed from '".$errorstatuses[$feedbackreport->ErrorStatus]."' to '".$errorstatuses['Updt']."'</br>";
			$feedbackreport->ErrorStatus = 'Updt';
			$feedbackreport->InternalLog = $tmpLog.$feedbackreport->InternalLog;
			$feedbackreport->ErrorLog = $tmpErrorLog.$feedbackreport->ErrorLog;
			$feedbackreport->LastUpdatedByType = '1';
			$feedbackreport->ID_LASTUPDATEDBY = $player->ID_PLAYER;

			$feedbackreport->update();
			$this->updateCache($feedbackreport);
			
			return true;
		}
		return false;
	}

	/**
	 * Upload handler
	 *
	 * @return array
	 */
	public function uploadScreenshot($id)
	{
		$fbreport = $this->getFeedbackReportByID($id);

// There should probably be a rule for this...?
//		if (User::canAccess("Edit feedbackreport"))
//		{
			$image = new Image();
			$result = $image->uploadImage(FOLDER_BUGREPORTS, $fbreport->ImageURL);
			if ($result['filename'] != '')
			{
				$fbreport->ImageURL = ContentHelper::handleContentInput($result['filename']);
				$fbreport->update(array('field' => 'ImageURL'));
				$this->updateCache($fbreport);
//				$br->purgeCache();
				$result['fbreport'] = $fbreport;
			}
			return $result;
//		}
	}

	public function updateCache(SyBugReports $feedbackreport)
	{
		Cache::increase(CACHE_BUGREPORT.$feedbackreport->ID_ERROR);
	}

}