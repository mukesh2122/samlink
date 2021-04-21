<?php

class AdminMainController extends AdminController {
	
	/**
     * Main website
     *
     */
/*    public function index() {
		$list = array();
		$list['NewsCategoriesType'] = false;
		$data['title'] ='Admin';
		$data['body_class'] = 'index_news';
		$data['selected_menu'] = '';
		$data['left'] = 'left';
		$data['right'] = 'right';
		$data['content'] = $this->renderBlock('main/index', $list);
		$data['footer'] = MainHelper::bottomMenu();
		$data['header'] = $this->getMenu();
		$this->render3Cols($data);
	}*/
	
	public function index(){
		$user = User::getUser();

		if(!$user or $user->canAccess(array('Super Admin Interface', 'Partial Admin')) !== TRUE) 
		{
			//Admin sign-in page
			$list = array();

			$data['title'] = $this->__('Sign in as admin');
			$data['body_class'] = 'index_admin';
			$data['selected_menu'] = 'admin';
			$data['content'] = $this->renderBlock('../login/admin', $list);
//			$data['content'] = $this->renderBlock('main/admin', $list);
			$data['footer'] = MainHelper::bottomMenu();
			$data['header'] = MainHelper::topMenu();

			$this->render1Col($data);
//			DooUriRouter::redirect(MainHelper::site_url('admin/index'));
//          return FALSE;
		}
		else
		{
			//Admin main index page
			$list = array();
			$list['NewsCategoriesType'] = false;
			$data['title'] ='Admin';
			$data['body_class'] = 'index_news';
			$data['selected_menu'] = '';
			$data['left'] = 'left';
			$data['right'] = 'right';
			$data['content'] = $this->renderBlock('main/index', $list);
			$data['footer'] = MainHelper::bottomMenu();
			$data['header'] = $this->getMenu();
			$this->render3Cols($data);
		}
	}

	
}