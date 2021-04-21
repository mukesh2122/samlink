<?php

class AdminBugReportsController extends AdminController {

    /**
     * Main website
     *
     */
    public function index() {
		$player = User::getUser();
		if($player->canAccess('Bug Reporting') === FALSE) {
			DooUriRouter::redirect(MainHelper::site_url('admin'));
		}
		// Just testing v. 2.1

		$bugreports = new BugReports();
        $list = array();

		$typeFilter = (isset($this->params['type_id']) ? $this->params['type_id'] : 'All');
		$categoryFilter = (isset($this->params['category_id']) ? $this->params['category_id'] : NULL);
		$subcategoryFilter = (isset($this->params['subcategory_id']) ? $this->params['subcategory_id'] : NULL);
		
		$sortType = isset($this->params['sortType']) ? $this->params['sortType'] : 'Status';
		$sortDir = isset($this->params['sortDir']) ? $this->params['sortDir'] : 'asc';
		$pager = $this->appendPagination($list, new stdClass(), $bugreports->getTotal($typeFilter, $categoryFilter, $subcategoryFilter), MainHelper::site_url('admin/bugreports'.(isset($typeFilter) ? ('/'.$typeFilter.(isset($categoryFilter) ? ('/'.$categoryFilter) : '').(isset($subcategoryFilter) ? ('/'.$subcategoryFilter) : '')) : '').(isset($sortType) ? ('/sort/'.$sortType.'/'.$sortDir) : '').'/page'), Doo::conf()->adminBugReportsLimit);
		$list['bugreports'] = $bugreports->getAllBugReports($pager->limit, $sortType, $sortDir, $typeFilter, $categoryFilter, $subcategoryFilter);
		$list['typeFilter'] = $typeFilter;
		$list['categoryFilter'] = $categoryFilter;
		$list['subcategoryFilter'] = $subcategoryFilter;
		$list['sortType'] = $sortType;
		$list['sortDir'] = $sortDir;
		$list['types'] = $bugreports->getTypes();
		$list['categories'] = $bugreports->getCategories();
		$list['subcategories'] = $bugreports->getSubCategories();
		$list['modules'] = $bugreports->getModules();
		$list['errorstatuses'] = $bugreports->getErrorStatuses();
		$list['statuses'] = $bugreports->getStatuses();
		$addtype1 = array('All' => 'All Support Tickets');
		$addtype2 = array('Bug' => 'All Bug/Error');
		$addcategory = array('Bug' => $list['modules']);
		$leftList['types'] = array_merge($addtype1,$list['types'],$addtype2);
		$leftList['categories'] = array_merge($list['categories'],$addcategory);
		$leftList['subcategories'] = $list['subcategories'];
		$leftList['typeFilter'] = $typeFilter;
		$leftList['categoryFilter'] = $categoryFilter;
		$leftList['subcategoryFilter'] = $subcategoryFilter;

		$data['title'] = 'Support System';
		$data['body_class'] = 'index_bugreports';
		$data['selected_menu'] = 'bugreports';
		$data['left'] =  $this->renderBlock('bugreports/common/leftColumn', $leftList);
		$data['right'] = 'right';
		$data['content'] = $this->renderBlock('bugreports/index', $list);
		$data['header'] = $this->getMenu();
		$this->render2ColsLeft($data);
	}

	public function search() {
        if (!isset($this->params['searchText'])) {
            DooUriRouter::redirect(MainHelper::site_url('admin/bugreports'));
            return FALSE;
        }

		$bugreports = new BugReports();
        $list = array();
		$player = User::getUser();
		if($player->canAccess('Bug Reporting') === FALSE) {
			DooUriRouter::redirect(MainHelper::site_url('admin'));
		}
		
		$list['searchText'] = (isset($this->params['searchText']) ? urldecode($this->params['searchText']) : 'None');
		$typeFilter = (isset($this->params['type_id']) ? $this->params['type_id'] : 'All');
		$categoryFilter = (isset($this->params['category_id']) ? $this->params['category_id'] : NULL);
		$subcategoryFilter = (isset($this->params['subcategory_id']) ? $this->params['subcategory_id'] : NULL);

		$bugreportsTotal = $bugreports->getSearchTotal(urldecode($this->params['searchText']), $typeFilter, $categoryFilter, $subcategoryFilter);
		$pager = $this->appendPagination($list, $bugreports, $bugreportsTotal, MainHelper::site_url('bugreports/search/'.urlencode($list['searchText']).'/page'), Doo::conf()->adminBugReportsLimit);
		$list['bugreports'] = $bugreports->getSearch($pager->limit, urldecode($this->params['searchText']), $typeFilter, $categoryFilter, $subcategoryFilter);
        $list['searchTotal'] = $bugreportsTotal;
		$list['typeFilter'] = $typeFilter;
		$list['categoryFilter'] = $categoryFilter;
		$list['subcategoryFilter'] = $subcategoryFilter;
		$list['sortType'] = 'ErrorName';
		$list['sortDir'] = 'asc';
		$list['types'] = $bugreports->getTypes();
		$list['categories'] = $bugreports->getCategories();
		$list['subcategories'] = $bugreports->getSubCategories();
		$list['modules'] = $bugreports->getModules();
		$list['errorstatuses'] = $bugreports->getErrorStatuses();
		$list['statuses'] = $bugreports->getStatuses();
		$addtype1 = array('All' => 'All Support Tickets');
		$addtype2 = array('Bug' => 'All Bug/Error');
		$addcategory = array('Bug' => $list['modules']);
		$leftList['types'] = array_merge($addtype1,$list['types'],$addtype2);
		$leftList['categories'] = array_merge($list['categories'],$addcategory);
		$leftList['subcategories'] = $list['subcategories'];
		$leftList['typeFilter'] = $typeFilter;
		$leftList['categoryFilter'] = $categoryFilter;
		$leftList['subcategoryFilter'] = $subcategoryFilter;

		$data['title'] = 'Search results';
        $data['body_class'] = 'search_bugreports';
		$data['selected_menu'] = 'bugreports';
		$data['left'] =  $this->renderBlock('bugreports/common/leftColumn', $leftList);
		$data['right'] = 'right';
		$data['content'] = $this->renderBlock('bugreports/index', $list);
		$data['header'] = $this->getMenu();
		$this->render2ColsLeft($data);
    }
	
	public function edit() {
		$player = User::getUser();
		if($player->canAccess('Bug Reporting') === FALSE) {
			DooUriRouter::redirect(MainHelper::site_url('admin'));
		}

		$bugreports = new BugReports();
        $list = array();
		$bugreport = $bugreports->getBugReportByID($this->params['error_id']);
		if(!$bugreport) {
			DooUriRouter::redirect(MainHelper::site_url('admin/bugreports'));
		}
		if(isset($_POST) and !empty($_POST)) {
			$bugreports->updateBugreportInfo($bugreport, $_POST);
			DooUriRouter::redirect(MainHelper::site_url('admin/bugreports/edit/'.$bugreport->ID_ERROR));
		}
		$list['developers'] = $bugreports->getPlayersWho('isDeveloper');
		$list['testers'] = $bugreports->getPlayersWho('isTester');
		$list['supporters'] = $bugreports->getPlayersWho('isSupporter');

		$list['typeFilter'] = 'All';
		$list['bugreport'] = $bugreport;
		$list['types'] = $bugreports->getTypes();
		$list['categories'] = $bugreports->getCategories();
		$list['subcategories'] = $bugreports->getSubCategories();
		$list['modules'] = $bugreports->getModules();
		$list['errorstatuses'] = $bugreports->getErrorStatuses();
		$list['statuses'] = $bugreports->getStatuses();
		$list['priorities'] = $bugreports->getPriorities();
		$addtype1 = array('All' => 'All Support Tickets');
		$addtype2 = array('Bug' => 'All Bug/Error');
		$leftList['types'] = array_merge($addtype1,$list['types'],$addtype2);
		$leftList['typeFilter'] = $list['typeFilter'];

		$data['title'] = 'Edit Support Ticket';
		$data['body_class'] = 'index_bugreports';
		$data['selected_menu'] = 'bugreports';
		$data['left'] =  $this->renderBlock('bugreports/common/leftColumn',$leftList);
		$data['right'] = '<h2>Internal Log</h2>'.$bugreport->InternalLog;
		$data['content'] = $this->renderBlock('bugreports/edit', $list);
		$data['header'] = $this->getMenu();
		$this->render3Cols($data);
	}

	public function newBugReport() {
		$player = User::getUser();
		if($player->canAccess('Bug Reporting') === FALSE) {
			DooUriRouter::redirect(MainHelper::site_url('admin'));
		}

		$bugreports = new BugReports();
        $list = array();
		if(isset($_POST) and !empty($_POST)) {
			$bugreport = $bugreports->createBugReportInfo($_POST);
			DooUriRouter::redirect(MainHelper::site_url('admin/bugreports/edit/'.$bugreport->ID_ERROR));
		}
		$list['developers'] = $bugreports->getPlayersWho('isDeveloper');
		$list['testers'] = $bugreports->getPlayersWho('isTester');
		$list['supporters'] = $bugreports->getPlayersWho('isSupporter');
	
		$list['typeFilter'] = 'new';
		$list['types'] = $bugreports->getTypes();
		$list['categories'] = $bugreports->getCategories();
		$list['subcategories'] = $bugreports->getSubCategories();
		$list['modules'] = $bugreports->getModules();
		$list['errorstatuses'] = $bugreports->getErrorStatuses();
		$list['statuses'] = $bugreports->getStatuses();
		$list['priorities'] = $bugreports->getPriorities();
		$addtype1 = array('All' => 'All Support Tickets');
		$addtype2 = array('Bug' => 'All Bug/Error');
		$leftList['types'] = array_merge($addtype1,$list['types'],$addtype2);
		$leftList['typeFilter'] = $list['typeFilter'];

		$data['title'] = 'Create new ticket';
		$data['body_class'] = 'index_bugreports';
		$data['selected_menu'] = 'bugreports';
		$data['left'] =  $this->renderBlock('bugreports/common/leftColumn',$leftList);
		$data['right'] = 'right';
		$data['content'] = $this->renderBlock('bugreports/new', $list);
		$data['header'] = $this->getMenu();
		$this->render3Cols($data);
	}
	
	/**
	 * Upload screenshot
	 *
	 * @return JSON
	 */
	public function ajaxUploadScreenshot() {
		$br = new BugReports();
		if (!isset($this->params['error_id']))
			return false;

		$upload = $br->uploadScreenshot(intval($this->params['error_id']));

		if ($upload['filename'] != '') {
			$file = MainHelper::showImage($upload['br'], THUMB_LIST_100x100, true, array('width', 'no_img' => 'noimage/no_forum_100x100.png'));
			echo $this->toJSON(array('success' => TRUE, 'img' => $file));
		} else {
			echo $this->toJSON(array('error' => $upload['error']));
		}
	}

	public function ajaxScreenshotView() {
		$bugreports = new BugReports();
		$bugreport = $bugreports->getBugReportByID($this->params['error_id']);

		$list['image'] = $this->renderBlock('bugreports/viewScreenshot', array('bugreport' => $bugreport));
		echo $list['image'];
	}

}
