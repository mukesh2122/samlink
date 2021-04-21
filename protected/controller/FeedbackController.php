<?php

class FeedbackController extends SnController
{
    /**
     * Main website
     *
     */
    public function index()
	{
		$player = User::getUser();

		$feedbackreports = new FeedbackReports();
		$list = array();

		$typeFilter = (isset($this->params['type_id']) ? $this->params['type_id'] : 'All');
		
		$sortType = isset($this->params['sortType']) ? $this->params['sortType'] : 'Status';
		$sortDir = isset($this->params['sortDir']) ? $this->params['sortDir'] : 'asc';

		$feedbackreportsTotal = $feedbackreports->getTotal($typeFilter, $player->ID_PLAYER);
		$pager = $this->appendPagination($list, new stdClass(), $feedbackreportsTotal, MainHelper::site_url('players/feedback/'.(isset($typeFilter) ? "/".$typeFilter : '').(isset($sortType) ? ('/sort/'.$sortType.'/'.$sortDir) : '').'/page'), Doo::conf()->adminBugReportsLimit);

 		$list['feedbackreports'] = $feedbackreports->getAllFeedbackReports($pager->limit, $sortType, $sortDir, $typeFilter, $player->ID_PLAYER);
		$list['typeFilter'] = $typeFilter;
		$list['sortType'] = $sortType;
		$list['sortDir'] = $sortDir;
		$list['types'] = $feedbackreports->getTypes();
		$list['errorstatuses'] = $feedbackreports->getErrorStatuses();
		$leftList['typeFilter'] = $typeFilter;

		$data['title'] = 'My Tickets';
		$data['body_class'] = 'index_feedback';
		$data['selected_menu'] = 'feedback';
		$data['left'] =  $this->renderBlock('feedback/common/leftColumn', $leftList);
		$data['content'] = $this->renderBlock('feedback/index', $list);
		$data['footer'] = MainHelper::bottomMenu();
		$data['header'] = MainHelper::topMenu();

		$this->loadExtraScripts($data);
		$this->render2ColsLeft($data);
	}

    private function loadExtraScripts(&$data)
	{
  		/*
		 * This will load the stylesheet and script used for the feedback pages only.
		 * No need to transfer this script from the server to the client on
		 * every single page.
		 */
		$this->appendFile($data, MainHelper::site_url('global/css/feedback.css'), 'stylesheet');
		$this->appendScript($data, '$(function() {$( "#tabs_feedback" ).tabs();});');
	
		// Add/override 'horizontal_tabs' class elements
		$this->appendScript($data, '.horizontal_tabs { border-bottom: 0px }', 'stylesheet');
		$this->appendScript($data, '.horizontal_tabs .selected { color: #FFFFFF; text-decoration: none; background-color: #0084C7; }', 'stylesheet');
	}
	
	public function edit()
	{	
		$player = User::getUser();
		$feedbackreports = new FeedbackReports();
		$list = array();
		$fbreport = $feedbackreports->getFeedbackReportByID($this->params['error_id']);

		if(!$fbreport || $fbreport->ID_REPORTEDBY != $player->ID_PLAYER)
		{
			DooUriRouter::redirect(MainHelper::site_url('players/feedback'));
		}

		if(isset($_POST) and !empty($_POST))
		{
			$feedbackreports->updateFeedbackReportInfo($fbreport, $_POST);
			
			DooUriRouter::redirect(MainHelper::site_url('players/feedback/edit/'.$fbreport->ID_ERROR));
		}
		
		$list['feedbackreport'] = $fbreport;
		$list['types'] = $feedbackreports->getTypes();
		$list['categories'] = $feedbackreports->getCategories();
		$list['subcategories'] = $feedbackreports->getSubCategories();
		
		$leftList['typeFilter'] = "";

		$data['title'] = 'Edit support ticket';
		$data['body_class'] = 'index_feedback';
		$data['selected_menu'] = 'feedback';
		$data['left'] =  $this->renderBlock('feedback/common/leftColumn',$leftList);
		$data['content'] = $this->renderBlock('feedback/edit', $list);
		$data['footer'] = MainHelper::bottomMenu();
		$data['header'] = MainHelper::topMenu();

		$this->loadExtraScripts($data);
		$this->render2ColsLeft($data);
	}

	public function newFeedbackReport()
	{
		$feedbackreports = new FeedbackReports();
		$list = array();

		if(isset($_POST) and !empty($_POST))
		{
			$fbreport = $feedbackreports->createFeedbackReportInfo($_POST);
			DooUriRouter::redirect(MainHelper::site_url('players/feedback/edit/'.$fbreport->ID_ERROR));
		}

		$list['types'] = $feedbackreports->getTypes();
		$list['categories'] = $feedbackreports->getCategories();
		$list['subcategories'] = $feedbackreports->getSubCategories();

		$leftList['typeFilter'] = "new";

		$data['title'] = 'New support ticket';
		$data['body_class'] = 'index_feedback';
		$data['selected_menu'] = 'feedback';
		$data['left'] =  $this->renderBlock('feedback/common/leftColumn',$leftList);
		$data['content'] = $this->renderBlock('feedback/new', $list);
		$data['footer'] = MainHelper::bottomMenu();
		$data['header'] = MainHelper::topMenu();

	    $this->loadExtraScripts($data);
		$this->render2ColsLeft($data);
	}
	
	/**
	 * Upload screenshot
	 *
	 * @return JSON
	 */
	public function ajaxUploadScreenshot()
	{
		$fbreport = new FeedbackReports();
		if (!isset($this->params['error_id']))
			return false;

		$upload = $fbreport->uploadScreenshot(intval($this->params['error_id']));

		if ($upload['filename'] != '')
		{
			$file = MainHelper::showImage($upload['fbreport'], THUMB_LIST_100x100, true, array('width', 'no_img' => 'noimage/no_forum_100x100.png'));
			echo $this->toJSON(array('success' => TRUE, 'img' => $file));
		}
		else
		{
			echo $this->toJSON(array('error' => $upload['error']));
		}
	}

	public function ajaxScreenshotView()
	{
		$feedbackreports = new FeedbackReports();
		$fbreport = $feedbackreports->getFeedbackReportByID($this->params['error_id']);

		$list['image'] = $this->renderBlock('feedback/viewScreenshot', array('fbreport' => $fbreport));
		echo $list['image'];
	}
}