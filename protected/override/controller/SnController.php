<?php

class SnController extends DooController {

	//used for breadcumbs
	public $crumb = array();

	public function beforeRun($resource, $action) {
		//if not login, group = anonymous
		$role = (isset($_SESSION['user']['group'])) ? $_SESSION['user']['group'] : GROUP_ANONYMOUS;

		User::getUser();

		if (Auth::isUserLogged() === FALSE) {
			$role = GROUP_ANONYMOUS;
		}
		$this->crumb = array();
		//sets lang if nessecary
		Lang::getLang();
		User::isReturningVisitor();
		User::initShowHideBlock();

		// do a cookie test
//		if (cc_cookie_cutter() == FALSE) {
//            header("Location: ".MainHelper::site_url('enable-cookie'));
//            exit(0);
//        }

		//check against the ACL rules
		if ($rs = $this->acl()->process($role, $resource, $action)) {
			return $rs;
		}
	}

	public function render2ColsRight($data = array()) {
		$this->view()->render('template_2cols_right', $data);
	}

	public function render2ColsLeft($data = array()) {
		$this->view()->render('template_2cols_left', $data);
	}

	public function render1Col($data = array()) {
		$this->view()->render('template_1col', $data);
	}

	public function render1ColGame($data = array()) {
		$this->view()->render('template_game', $data);
	}
        
	public function renderCuptree($data = array()) {
		$this->view()->render('template_cuptree', $data);
	}
        
	public function renderBlank($data = array()) {
		$this->view()->render('template_blank', $data);
	}

	public function render3Cols($data = array()) {
		$this->view()->render('template', $data);
	}

	public function renderBlock($file, $data=NULL, $controller = NULL, $includeTagClass = FALSE) {
		return (string) $this->view()->renderBlock($file, $data, $controller, $includeTagClass);
	}

	/**
	 * The view singleton, auto create if the singleton has not been created yet.
	 * @return DooView|DooViewBasic
	 */
	public function view() {
		if ($this->_view == NULL) {
			$engine = Doo::conf()->TEMPLATE_ENGINE;
			Doo::loadCore('../protected/override/view/' . $engine);
			$this->_view = new $engine;
		}

		return $this->_view;
	}

	//langs
	public static function __($msg, $params=array()) {
		$lang = Lang::getLang();
		//$translator = Doo::translator('Csv', Doo::conf()->SITE_PATH . 'protected/lang/' . $lang . '/' . $lang . '.csv' /* ,array('cache' => 'apc', 'delimiter' => ';') */);
		$translator = Doo::translator('database',$lang);
		return $translator->translate($msg, $params);
	}

	/**
	 * Adds pagination
	 *
	 * @param array $list
	 * @param active record $object
	 * @return unknown
	 */
	public function appendPagination(&$list, $object, $total = -1, $url = "", $limit = -1) {

		$url = $url != "" ? $url : $object->NEWS_URL;
		$total = $total >= 0 ? $total : $object->NewsCount;
		$limit = $limit >= 0 ? $limit : Doo::conf()->defaultPageLimit;

		$pager = new SnPager($url, $total, $limit, 12, $this->__('&laquo;'), $this->__('&raquo;'));
		if (isset($this->params['page']))
			$pager->paginate(intval($this->params['page']));
		else
			$pager->paginate(1);
		$list['pager'] = $pager->output;
		$list['pagerObj'] = $pager;
		return $pager;
	}

	/**
	 * Adds breadcrumb item
	 *
	 * @param String $title
	 * @param String $url
	 * @return void
	 */
	public function addCrumb($title, $url = "") {
		if (!empty($title)) {
			$item = new stdClass();
			$item->Title = $title;
			$item->Url = $url;

			array_push($this->crumb, $item);
		}
	}

	/**
	 * Returns breadcrumb items
	 *
	 * @return array
	 */
	public function getCrumb() {
		return $this->crumb;
	}

	// KiC - Begin
	/*
	 * Used to load ekstra page specifik script files in head.php.
	 */
	public function appendFile(&$data, $url, $type = 'text/javascript')
	{
		switch ($type)
		{
			case 'text/javascript':
				$html = '<script type="' . $type . '" src="' . $url . '"></script>';
				break;
			case 'stylesheet':
				$html = '<link rel="' . $type . '" href="' . $url . '" />';
				break;
			/*
			 * Insert further case statements here if support for other header types are needed...
			 */
			case '':
				break;
		}

		if (isset($data['scripts']))
		{
			$data['scripts'] .= $html;
		}
		else
		{
			$data['scripts'] = $html;
		}
	}

	/*
	 * Used to load ekstra page specifik script data in head.php.
	 */
	public function appendScript(&$data, $content, $type = 'text/javascript')
	{
		switch ($type)
		{
			case 'text/javascript':
				$html = '<script type="' . $type . '">' . $content . '</script>';
				break;
			case 'stylesheet':
				$html = '<style>' . $content . '</style>';
				break;
			/*
			 * Insert further case statements here if support for other header types are needed...
			 */
			case '':
				break;
		}

		if (isset($data['scripts']))
		{
			$data['scripts'] .= $html;
		}
		else
		{
			$data['scripts'] = $html;
		}
	}
	// KiC - End

}
