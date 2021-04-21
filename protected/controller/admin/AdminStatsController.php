<?php

class AdminStatsController extends AdminController {
    /**
     * Main website
     *
     */
    public function index() {
		$player = User::getUser();

		if(!$player or $player->canAccess(array('Super Admin Interface', 'Partial Admin')) !== TRUE) 
		{
			//Stats admin sign-in page
			$list = array();

			$data['title'] = $this->__('Sign in as statsadmin');
			$data['body_class'] = 'index_admin';
			$data['selected_menu'] = 'admin';
			$data['content'] = $this->renderBlock('main/statsadmin', $list);
			$data['footer'] = MainHelper::bottomMenu();
			$data['header'] = MainHelper::topMenu();

			$this->render1Col($data);
//			DooUriRouter::redirect(MainHelper::site_url('admin/index'));
//          return FALSE;
		}
		else
		{
			if($player->canAccess('Stats') === FALSE) {
				DooUriRouter::redirect(MainHelper::site_url('admin'));
			}

			$stats = new Stats();
			$list = array();
			$list['stats'] = $stats;
			
			$data['title'] = 'Stats';
			$data['body_class'] = 'index_stats';
			$data['selected_menu'] = 'stats';
			$data['left'] =  $this->renderBlock('stats/common/leftColumn');
			$data['right'] = '';
			$data['content'] = $this->renderBlock('stats/index',$list);
			$data['header'] = $this->getMenu();
			$this->render3Cols($data);
		}
    }
    
    public function users() {
        $player = User::getUser();
        if($player->canAccess('Stats') === FALSE) {
            DooUriRouter::redirect(MainHelper::site_url('admin'));
        }
        
        $stats = new Stats();
        $list = array();
        $list['stats'] = $stats;

        $data['title'] = 'Stats';
        $data['body_class'] = 'index_stats';
        $data['selected_menu'] = 'stats';
        $data['left'] =  $this->renderBlock('stats/common/leftColumn');
        $data['right'] = '';
        $data['content'] = $this->renderBlock('stats/users', $list);
        $data['header'] = $this->getMenu();
        $this->render3Cols($data);
    }
    
    public function credits() {
        $player = User::getUser();
        if($player->canAccess('Stats') === FALSE) {
            DooUriRouter::redirect(MainHelper::site_url('admin'));
        }
        
        $stats = new Stats();
        $list = array();
        $list['stats'] = $stats;

        $data['title'] = 'Credits';
        $data['body_class'] = 'index_stats';
        $data['selected_menu'] = 'stats';
        $data['left'] =  $this->renderBlock('stats/common/leftColumn');
        $data['right'] = '';
        $data['content'] = $this->renderBlock('stats/credits', $list);
        $data['header'] = $this->getMenu();
        $this->render3Cols($data);
    }
    
    public function referrers() {
        $player = User::getUser();
        if($player->canAccess('Stats') === FALSE) {
            DooUriRouter::redirect(MainHelper::site_url('admin'));
        }
        $stats = new Stats();
        $list = array();
        $pager = $this->appendPagination($list, new stdClass(), $stats->referrersCount(), MainHelper::site_url('admin/stats/referrers/page'), 10);
        
        $list['referrers_list'] = $stats->referrersList($pager->limit,'asc');
        
        $list['stats'] = $stats;
        
        $data['title'] = 'Referrers';
        $data['body_class'] = 'index_stats';
        $data['selected_menu'] = 'stats';
        $data['left'] =  $this->renderBlock('stats/common/leftColumn');
        $data['right'] = '';
        $data['content'] = $this->renderBlock('stats/referrers',$list);
        $data['header'] = $this->getMenu();
        $this->render3Cols($data);
    }

    public function search() {
        $player = User::getUser();
        if($player->canAccess('Stats') === FALSE) {
            DooUriRouter::redirect(MainHelper::site_url('admin'));
        }
        
        if (!isset($this->params['searchText'])) {
            DooUriRouter::redirect(MainHelper::site_url('admin/stats/referrers'));
            return FALSE;
        }

        $stats = new Stats();
        $list = array();
        $list['stats'] = $stats;

        $list['searchText'] = urldecode($this->params['searchText']);

        $bugreportsTotal = $stats->referrersCount($this->params['searchText']);
        $pager = $this->appendPagination($list, new stdClass(), $bugreportsTotal, MainHelper::site_url('stats/referrers/search/'.urlencode($list['searchText'])),10);
        
        $list['referrers_list'] = $stats->referrersList($pager->limit,'asc',urldecode($this->params['searchText']));
        
        $list['searchTotal'] = $bugreportsTotal;

        $data['title'] = $this->__('Search results');
        $data['body_class'] = 'search_stats';
        $data['selected_menu'] = 'stats';
        $data['left'] =  $this->renderBlock('stats/common/leftColumn');
        $data['right'] = '';
        $data['content'] = $this->renderBlock('stats/referrers', $list);
        $data['header'] = $this->getMenu();
        $this->render3Cols($data);
    }

	
	public function beforeRun($resource, $action) {
		
		//if not login, group = anonymous
        $role = (isset($_SESSION['user']['group'])) ? $_SESSION['user']['group'] : GROUP_ANONYMOUS;

        $user = User::getUser();
		
		if(!$user or $user->canAccess(array('Super Admin Interface', 'Partial Admin', 'Stats')) !== TRUE) {
			
			$pageURL1 = $_SERVER["SERVER_NAME"].$_SERVER["REQUEST_URI"];
			$pageURL2 = MainHelper::site_url('stats');
			$s1 = explode('/',$pageURL1);
			$s2 = explode('/',$pageURL2);
			$page1 = $s1[count($s1)-1];
			$page2 = $s2[count($s2)-1];

			//Go back to adminpage, if you aren't there already..
			if ($page1 != $page2)
				DooUriRouter::redirect(MainHelper::site_url('stats'));

			return FALSE;
		}
		if (Auth::isUserLogged() === FALSE) {
            $role = GROUP_ANONYMOUS;
        }
        //sets lang if nessecary
        Lang::getLang();
		
        if ($rs = $this->acl()->process($role, $resource, $action)) {
            return $rs;
        }
    }		
}
?>